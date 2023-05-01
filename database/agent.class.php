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
        WHERE AgentID = ?
      ');

      $stmt->execute(array($this->username, $this->id));
    }
    
    static function getAgentWithPassword(PDO $db, string $email, string $password) : ?Agent {
      $stmt = $db->prepare('
        SELECT AgentID, Name, Username, Email, Password
        FROM Agent 
        WHERE (lower(email) = ? AND password = ?) OR (lower(username) = ? AND password = ?)
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($agent = $stmt->fetch()) {
        return new Agent(
          $agent['AgentID'],
          $agent['Name'],
          $agent['Username'],
          $agent['Email'],
          $agent['Password']
        );
      } else return null;
    }

    static function getAgent(PDO $db, int $id) : Agent {
      $stmt = $db->prepare('
        SELECT AgentID, Name, Username, Email, Password
        FROM Agent JOIN Client 
        ON AgentID = ClientID
        WHERE AgentID = ?
      ');

      $stmt->execute(array($id));
      $agent = $stmt->fetch();
      
      return new Agent(
        $agent['AgentID'],
        $agent['Name'],
        $agent['Username'],
        $agent['Email'],
        $agent['Password']
      );
    }

    static function getAllAgents(PDO $db){
      $stmt = $db->prepare('SELECT * from Client join Admin on Client.ClientID = Agent.AgentID');
      $stmt->execute();
      $agents = $stmt->fetchAll();
      return $agents;
    }
  }
?>