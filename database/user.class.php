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
        SELECT ClientID, Email, Name, Username, 
        CASE 
          WHEN EXISTS (SELECT 1 FROM Admin WHERE ClientID = ?) THEN 'Admin'
          WHEN EXISTS (SELECT 1 FROM Agent WHERE ClientID = ?) THEN 'Agent'
          ELSE 'Client'
        END AS Type
        FROM Client
        WHERE ClientID = ?;
      ");

      $stmt->execute(array($id));
      $client = $stmt->fetch();
      
      return new User(
        $client['ClientID'],
        $client['Name'],
        $client['Username'],
        $client['Email'],
        $client['Type'],
        $client['Password']
      );
    }

    static function getUsers(PDO $db) {
      $stmt = $db->prepare('
        SELECT ClientID, Name, Username, Email, Type, Password
        FROM Client
        USING(ClientID)
      ');

      $stmt->execute();
      $agents = $stmt->fetchAll();
      $ret = array();

      foreach ($agents as $agent) 
        array_push($ret, new User(
          $agent['ClientID'],
          $agent['Name'],
          $agent['Username'],
          $agent['Email'],
          $agent['Type'],
          $agent['Password']
        ));
      
      return $ret;
    }

    static function getAgents(PDO $db) {
      $stmt = $db->prepare('
        SELECT ClientID, Name, Username, Email, Type, Password
        FROM Client JOIN Agent
        USING(ClientID)
      ');

      $stmt->execute();
      $agents = $stmt->fetchAll();
      $ret = array();

      foreach ($agents as $agent) 
        array_push($ret, new User(
          $agent['ClientID'],
          $agent['Name'],
          $agent['Username'],
          $agent['Email'],
          $agent['Type'],
          $agent['Password']
        ));
      
      return $ret;
    }

    static function getClientByUsername(PDO $db, string $username) : User {
      $stmt = $db->prepare('
        SELECT ClientID, Name, Username, Email, Password
        FROM Client 
        WHERE Username = ?
      ');

      $stmt->execute(array($username));
      $client = $stmt->fetch();
      
      return new User(
        $client['ClientID'],
        $client['Name'],
        $client['Username'],
        $client['Email'],
        $client['Type'],
        $client['Password']
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
  }
?>