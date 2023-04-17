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
        WHERE AgentId = ?
      ');

      $stmt->execute(array($this->username, $this->id));
    }
    
    static function getAgentWithPassword(PDO $db, string $email, string $password) : ?Agent {
      $stmt = $db->prepare('
        SELECT AgentId, Name, Username, Email, Password
        FROM Agent 
        WHERE (lower(email) = ? AND password = ?) OR (lower(username) = ? AND password = ?)
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($agent = $stmt->fetch()) {
        return new Agent(
          $agent['AgentId'],
          $agent['Name'],
          $agent['Username'],
          $agent['Email'],
          $agent['Password']
        );
      } else return null;
    }

    static function getAgent(PDO $db, int $id) : Agent {
      $stmt = $db->prepare('
        SELECT AgentId, Name, Username, Email, Password
        FROM Agent 
        WHERE AgentId = ?
      ');

      $stmt->execute(array($id));
      $agent = $stmt->fetch();
      
      return new Agent(
        $agent['AgentId'],
        $agent['Name'],
        $agent['Username'],
        $agent['Email'],
        $agent['Password']
      );
    }

  }
?>