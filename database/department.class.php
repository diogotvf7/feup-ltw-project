<?php
  declare(strict_types = 1);

  class Department {
    public int $id;
    public string $name;
    
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    static function getDepartment(PDO $db, string $id) : Department {
      $stmt = $db->prepare('
        SELECT *
        FROM Department
        WHERE DepartmentID = ?
      ');

      $stmt->execute([$id]);
      $agent = $stmt->fetch();
      
      return new Department(
        $agent['DepartmentID'],
        $agent['Name']
      );
    }

    static function getDepartmentbyName(PDO $db, string $name) {
      $stmt = $db->prepare('
        SELECT *
        FROM Department
        WHERE Name = ?
      ');

      $stmt->execute([$name]);
      $department = $stmt->fetch();
      if ($department == null) return null; // doesnt exist
      return $department['DepartmentID'];
    }
    
    static function addDepartment(PDO $db, string $name){
      if (self::getDepartmentbyName($db, $name) != null) return false; // already exists
      $stmt = $db->prepare('
        SELECT DepartmentID
        FROM Department order by 1 desc');
        $stmt->execute();
        $lastID = $stmt->fetch();
        $lastID = $lastID['DepartmentID'];
      $stmt = $db->prepare('
        INSERT INTO Department(DepartmentID, Name)
        VALUES (?,?)
      ');
      $lastID += 1;
      $stmt->execute([$lastID,$name]);
    }

    static function removeDepartment(PDO $db, string $name) : bool{
      if (self::getDepartment($db, $name) == null) return false; // doesnt exist
      $stmt = $db->prepare('
        DELETE FROM Department
        WHERE Name = ?');

      $stmt->execute([$name]);
      return true;
    }

    static function getAllDepartments(PDO $db) {
      $stmt = $db->prepare('
        SELECT * 
        FROM Department
      ');
      $stmt->execute();
      return $stmt->fetchAll();
    }

    static function getUserDepartments(PDO $db) {
      $stmt = $db->prepare('
        SELECT DISTINCT DepartmentID, Name
        FROM Ticket
        JOIN Department USING(DepartmentID)
        WHERE ClientID = ?
      ');
      $stmt->execute([$_SESSION['IDUSER']]);
      return $stmt->fetchAll();
    }
    
    static function getUsersInDepartments(PDO $db, int $id) {
      $stmt = $db->prepare('
      SELECT Client.ClientID, Client.Name, Client.Username, Client.Email FROM Department JOIN Agent_Department ON Department.DepartmentID = Agent_Department.DepartmentID JOIN Agent ON Agent_Department.AgentID = Agent.ClientID JOIN Client on Client.ClientID = Agent.ClientID
      WHERE Department.DepartmentID = ?
      ');
      $stmt->execute([$id]);
      return $stmt->fetchAll();
    }
  }
?>