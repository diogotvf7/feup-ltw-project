<?php
  declare(strict_types = 1);

  class Client {
    public int $id;
    public string $name;
    public string $username;
    public string $email;
    public string $password;
    
    public function __construct(int $id, string $name, string $username, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE Client SET Username = ?
        WHERE ClientID = ?
      ');

      $stmt->execute(array($this->username, $this->id));
    }
    
    static function getClientWithPassword(PDO $db, string $email, string $password) : ?Client {
      $stmt = $db->prepare('
        SELECT ClientID, Name, Username, Email, Password
        FROM Client 
        WHERE (lower(email) = ? AND password = ?) OR (lower(username) = ? AND password = ?)
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($client = $stmt->fetch()) {
        return new Client(
          $client['ClientID'],
          $client['Name'],
          $client['Username'],
          $client['Email'],
          $client['Password']
        );
      } else return null;
    }

    static function getClient(PDO $db, int $id) : Client {
      $stmt = $db->prepare('
        SELECT ClientID, Name, Username, Email, Password
        FROM Client 
        WHERE ClientID = ?
      ');

      $stmt->execute(array($id));
      $client = $stmt->fetch();
      
      return new Client(
        $client['ClientID'],
        $client['Name'],
        $client['Username'],
        $client['Email'],
        $client['Password']
      );
    }

    static function getClientByUsername(PDO $db, string $username) : Client {
      $stmt = $db->prepare('
        SELECT ClientID, Name, Username, Email, Password
        FROM Client 
        WHERE Username = ?
      ');

      $stmt->execute(array($username));
      $client = $stmt->fetch();
      
      return new Client(
        $client['ClientID'],
        $client['Name'],
        $client['Username'],
        $client['Email'],
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
      $clients = $stmt->fetchAll();
      
      return $clients;
    }
  }
?>