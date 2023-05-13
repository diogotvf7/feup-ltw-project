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

    static function getUserTags(PDO $db) {
      $stmt = $db->prepare('
        SELECT DISTINCT TagID, Name
        FROM Tag 
        JOIN Ticket_Tag USING(TagID)
        JOIN Ticket USING(TicketID)
        WHERE ClientID = ?
      ');
      $stmt->execute([$_SESSION['IDUSER']]);
      return $stmt->fetchAll();
    }
  }
?>