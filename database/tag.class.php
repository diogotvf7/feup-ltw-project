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