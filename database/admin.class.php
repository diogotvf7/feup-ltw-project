<?php
  declare(strict_types = 1);

  class Admin {
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

    // function save($db) {
    //   $stmt = $db->prepare('
    //     UPDATE Client 
    //     SET Username = ?
    //     WHERE AdminID = ClientID 
    //     AND AdminID = ?
    //   ');

    //   $stmt->execute(array($this->username, $this->id));
    // }
    
    static function getAdminWithPassword(PDO $db, string $email, string $password) : ?Admin {
      $stmt = $db->prepare('
        SELECT ClientID, Name, Username, Email, Password
        FROM Admin JOIN Client
        USING(ClientID)
        WHERE (lower(email) = ? AND password = ?) OR (lower(username) = ? AND password = ?)
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($admin = $stmt->fetch()) {
        return new Admin(
          $admin['ClientID'],
          $admin['Name'],
          $admin['Username'],
          $admin['Email'],
          $admin['Password']
        );
      } else return null;
    }

    static function getAdmin(PDO $db, int $id) : Admin {
      $stmt = $db->prepare('
        SELECT ClientID, Name, Username, Email, Password
        FROM Admin JOIN Client 
        USING(ClientID)
        WHERE ClientID = ?
      ');

      $stmt->execute(array($id));
      $admin = $stmt->fetch();
      
      return new Admin(
        $admin['ClientID'],
        $admin['Name'],
        $admin['Username'],
        $admin['Email'],
        $admin['Password']
      );
    }

    static function getAllAdmins(PDO $db){
      $stmt = $db->prepare('SELECT * from Client join Admin on Client.ClientID = Admin.ClientID');
      $stmt->execute();
      $admins = $stmt->fetchAll();
      return $admins;
    }
  }
?>