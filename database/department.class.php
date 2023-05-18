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

    static function getDepartmentbyName(PDO $db, string $name) : int {
      $stmt = $db->prepare('
        SELECT *
        FROM Department
        WHERE Name = ?
      ');

      $stmt->execute([$name]);
      $department = $stmt->fetch();
      
      return $department['DepartmentID'];
    }
    
    static function addDepartment(PDO $db, string $name){
      if (self::getDepartment($db, $name) != null) return false; // already exists
      $stmt = $db->prepare('
        INSERT INTO Department(Name)
        VALUES (?)
      ');

      $stmt->execute([$name]);
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
  }
?>