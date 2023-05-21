<?php
  declare(strict_types = 1);

  class User {
    public int $id;
    public string $name;
    public string $username;
    public string $email;
    public string $type;
    public string $password;
    
    public function __construct(int $id, string $name, string $username, string $email, string $type, string $password)
    {
      $this->id = $id;
      $this->name = $name;
      $this->username = $username;
      $this->email = $email;
      $this->type = $type;
      $this->password = $password;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE Client SET Username = ?
        WHERE ClientID = ?
      ');

      $stmt->execute(array($this->username, $this->id));
    }

    static function getUser(PDO $db, int $id) : User {
      $stmt = $db->prepare("
        SELECT ClientID, Name, Username, Email,
        CASE 
          WHEN EXISTS (SELECT 1 FROM Admin WHERE ClientID = ?) THEN 'Admin'
          WHEN EXISTS (SELECT 1 FROM Agent WHERE ClientID = ?) THEN 'Agent'
          ELSE 'Client'
        END AS Type, Password
        FROM Client
        WHERE ClientID = ?;
      ");

      $stmt->execute(array($id, $id, $id));
      $user = $stmt->fetch();

      return new User(
        $user['ClientID'],
        $user['Name'],
        $user['Username'],
        $user['Email'],
        $user['Type'],
        $user['Password']
      );
    }

    static function getUsers(PDO $db) {
      $stmt = $db->prepare("
      SELECT ClientID, Name, Username, Email,
      CASE 
        WHEN EXISTS (SELECT 1 FROM Admin WHERE ClientID = Client.ClientID) THEN 'Admin'
        WHEN EXISTS (SELECT 1 FROM Agent WHERE ClientID = Client.ClientID) THEN 'Agent'
        ELSE 'Client'
      END AS Type, Password
      FROM Client;
    ");
      $stmt->execute();
      $users = $stmt->fetchAll();
      $ret = array();

      foreach ($users as $user) 
        array_push($ret, new User(
          $user['ClientID'],
          $user['Name'],
          $user['Username'],
          $user['Email'],
          $user['Type'],
          $user['Password']
        ));
      
      return $ret;
    }

    static function getAgents(PDO $db) {
      $stmt = $db->prepare("
      SELECT Client.ClientID as ClientID, Name, Username, Email,
      CASE 
        WHEN EXISTS (SELECT 1 FROM Admin WHERE ClientID = Client.ClientID) THEN 'Admin'
        WHEN EXISTS (SELECT 1 FROM Agent WHERE ClientID = Client.ClientID) THEN 'Agent'
        ELSE 'Client'
      END AS Type, Password
      FROM Client join Agent where Client.ClientID = Agent.ClientID;
      ");

      $stmt->execute();
      $users = $stmt->fetchAll();
      $ret = array();

      foreach ($users as $user) 
        array_push($ret, new User(
          $user['ClientID'],
          $user['Name'],
          $user['Username'],
          $user['Email'],
          $user['Type'],
          $user['Password']
        ));
      
      return $ret;
    }

    static function getClientByUsername(PDO $db, string $username) : User {
      $username = htmlspecialchars($username);
      $stmt = $db->prepare("
        SELECT ClientID, Name, Username, Email,
        CASE 
          WHEN EXISTS (SELECT 1 FROM Admin WHERE Username = ?) THEN 'Admin'
          WHEN EXISTS (SELECT 1 FROM Agent WHERE Username = ?) THEN 'Agent'
          ELSE 'Client'
        END AS Type, Password
        FROM Client
        WHERE Username = ?;
      ");

      $stmt->execute(array($username, $username, $username));
      $user = $stmt->fetch();
      
      return new User(
        $user['ClientID'],
        $user['Name'],
        $user['Username'],
        $user['Email'],
        $user['Type'],
        $user['Password']
      );
    }

    static function getAllClientsInfo(PDO $db) {
      $stmt = $db->prepare('
        SELECT A.ClientID, A.Name, A.Username, A.Email, Tickets_made, Tickets_in_charge
        FROM (
            SELECT *
            FROM Client 
            LEFT JOIN (
              SELECT ClientID, COUNT(*) Tickets_made
              FROM Client JOIN Ticket
              USING(ClientID)
              GROUP BY ClientID)
            USING(ClientID) 
            ) as A
        LEFT JOIN
          (
            SELECT *
            FROM Client 
            LEFT JOIN (
              SELECT Agent.ClientID, COUNT(*) Tickets_in_charge
              FROM Agent JOIN Ticket
              ON Agent.ClientID = Ticket.AgentID
              GROUP BY AgentID)
            USING(ClientID)
            ) as B
        USING(ClientID)
      ');
      $stmt->execute();
      return $stmt->fetchAll();
    }

    static function getTicketsMade(PDO $db, $id) {
      $stmt = $db->prepare('
        SELECT COUNT(*) Tickets_made
        FROM Client JOIN Ticket
        USING(ClientID)
        WHERE ClientID = ?
        GROUP BY ClientID;
      ');
      $stmt->execute(array($id));
      if ($result = $stmt->fetch()) return $result['Tickets_made'];
      return null;
    }

    static function getTicketsResponsible(PDO $db, $id) {
      $stmt = $db->prepare('
        SELECT COUNT(*) Tickets_responsible
        FROM Agent JOIN Ticket
        ON Agent.ClientID = Ticket.AgentID
        WHERE Agent.ClientID = ?
        GROUP BY Agent.ClientID;
      ');
      $stmt->execute(array($id));
      return $stmt->fetch()['Tickets_responsible'];
    }

    static function getTicketsClosed(PDO $db, $id) {
      $stmt = $db->prepare('
        SELECT COUNT(*) Tickets_closed
        FROM Agent JOIN Ticket
        ON Agent.ClientID = Ticket.AgentID
        WHERE Ticket.Status = "Closed" AND Agent.ClientID = ?
        GROUP BY Agent.ClientID;
      ');
      $stmt->execute(array($id));
      if ($result = $stmt->fetch()) return $result['Tickets_closed'];
      return null;
    }

    static function getTicketsOpen(PDO $db, $id) {
      $stmt = $db->prepare('
        SELECT COUNT(*) Tickets_open
        FROM Agent JOIN Ticket
        ON Agent.ClientID = Ticket.AgentID
        WHERE Ticket.Status = "Open" AND Agent.ClientID = ?
        GROUP BY Agent.ClientID;
      ');
      $stmt->execute(array($id));
      return $stmt->fetch()['Tickets_open'];
    }

    static function makeClient(PDO $db, int $id) {
      $stmt = $db->prepare('
        DELETE FROM Admin
        WHERE ClientID = ?;
        ');
      $stmt->execute(array($id));
      $stmt = $db->prepare('
      DELETE FROM Agent
      WHERE ClientID = ?;
      ');
      $stmt->execute(array($id));
      $stmt = $db->prepare('
        INSERT INTO Client
        VALUES (?);
      ');
      $stmt->execute(array($id));
    }
    static function makeAgent(PDO $db, int $id) {
      $stmt = $db->prepare('
        DELETE FROM Admin
        WHERE ClientID = ?;
        ');
      $stmt->execute(array($id));
      $stmt = $db->prepare('
        INSERT INTO Agent
        VALUES (?);
      ');
      $stmt->execute(array($id));
    }
    static function makeAdmin(PDO $db, int $id) {
      $stmt = $db->prepare('
        INSERT INTO Admin
        VALUES (?);
      ');
      $stmt->execute(array($id));
    }

    static function getDepartment(PDO $db, int $id) {
      $stmt = $db->prepare('
      SELECT DepartmentID
      FROM Agent join Agent_Department on Agent.ClientID = Agent_Department.AgentID
      WHERE Agent.ClientID = ?;
      ');
      $stmt->execute(array($id));
      return $stmt->fetchAll();
    }

    static function removeUserFromDepartment(PDO $db, int $clientID, int $departmentID) {
      $stmt = $db->prepare('
      DELETE FROM Agent_Department
      WHERE AgentID = ? AND DepartmentID = ?;
      ');
      $stmt->execute(array($clientID, $departmentID));
    }
    static function RemoveUser($db, $id){
      $stmt = $db->prepare('
          DELETE FROM Client 
          WHERE ClientID = ?
      ');
      $stmt->execute(array($id));
    }

  static function addUsertoDeparment($db, $id, $departmentID){
    $stmt = $db->prepare('
      INSERT INTO Agent_Department (AgentID, DepartmentID)
      VALUES (?, ?);
    ');
    $stmt->execute(array($id, $departmentID));
  }
}
?>
