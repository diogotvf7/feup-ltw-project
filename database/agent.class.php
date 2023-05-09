<?php
  declare(strict_types = 1);

  class Agent {
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
        UPDATE Agent SET Username = ?
        WHERE ClientID = ?
      ');

      $stmt->execute(array($this->username, $this->id));
    }
    
    static function getAgentWithPassword(PDO $db, string $email, string $password) : ?Agent {
      $stmt = $db->prepare('
        SELECT ClientID, Name, Username, Email, Password
        FROM Agent 
        WHERE (lower(email) = ? AND password = ?) OR (lower(username) = ? AND password = ?)
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($agent = $stmt->fetch()) {
        return new Agent(
          $agent['ClientID'],
          $agent['Name'],
          $agent['Username'],
          $agent['Email'],
          $agent['Password']
        );
      } else return null;
    }

    static function getAgent(PDO $db, int $id) : Agent {
      $stmt = $db->prepare('
        SELECT ClientID, Name, Username, Email, Password
        FROM Agent JOIN Client 
        USING(ClientID)
        WHERE ClientID = ?
      ');

      $stmt->execute(array($id));
      $agent = $stmt->fetch();
      if ($agent != null)
      return new Agent(
        $agent['ClientID'],
        $agent['Name'],
        $agent['Username'],
        $agent['Email'],
        $agent['Password']
      );
      else return null;
    }

    static function getAllAgents(PDO $db){
      $stmt = $db->prepare('
        SELECT * 
        FROM Client 
        JOIN Agent 
        USING(ClientID)
      ');
      $stmt->execute();
      $agents = $stmt->fetchAll();
      return $agents;
    }
  }
?>