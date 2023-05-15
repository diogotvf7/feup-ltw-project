<?php
  declare(strict_types = 1);

  class Tag {
    public int $id;
    public string $name;
    
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    static function getTags(PDO $db) {
      $stmt = $db->prepare('
        SELECT * 
        FROM Tag
      ');
      $stmt->execute();
      return $stmt->fetchAll();
    }

    static function createTag(PDO $db, string $name) : int{
      $stmt = $db->prepare('
        INSERT INTO Tag (Name)
        VALUES (?)
      ');
      $stmt->execute([$name]);
      $stmt = $db->prepare('
        SELECT TagID
        FROM Tag
        WHERE Name = ?;');
      $stmt->execute([$name]);
      $tag = $stmt->fetch();
      return $tag['TagID'];
    }

    static function getTagbyName(PDO $db, string $name){
      $stmt = $db->prepare('
        SELECT TagID
        FROM Tag
        WHERE Name = ?
      ');
      $stmt->execute([$name]);
      $tag = $stmt->fetch();
      return $tag['TagID'];
    }



    // static function getTag(PDO $db, int $id) : Tag {
    //   $stmt = $db->prepare('
    //     SELECT TagID, Name
    //     FROM Tag
    //     WHERE TagID = ?
    //   ');

    //   $stmt->execute([$id]);
    //   $agent = $stmt->fetch();
      
    //   return new Tag(
    //     $agent['TagID'],
    //     $agent['Name']
    //   );
    // }
  }
?>