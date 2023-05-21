<?php
  declare(strict_types = 1);

  class Status {
    public string $name;
    
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    static function getStatus(PDO $db) {
        $stmt = $db->prepare('
            SELECT * 
            FROM Status
        ');
        $stmt->execute();
        return array_map('decodeStatus', $stmt->fetchAll());
    }

    static function addStatus(PDO $db, $name) {
        $name = htmlspecialchars($name);
        $stmt = $db->prepare('
            INSERT INTO Status (Name)
            VALUES (?)
        ');
        return $stmt->execute([$name]);
    }

    static function deleteStatus(PDO $db, $name) {
        $stmt = $db->prepare('
            DELETE FROM Status
            WHERE Name = ?
        ');
        return $stmt->execute([$name]);
    }
  }

    function decodeStatus($status) {
        $status['Name'] = htmlspecialchars_decode($status['Name']);
        return $status;
    }
?>