<?php
  declare(strict_types = 1);

  class Comment {
    public int $id;
    public int $ticketId;
    public int $clientId;
    public string $comment;
    public Datetime $date;
    
    public function __construct(int $id, int $ticketId, int $clientId, string $comment, string $date)
    {
      $this->id = $id;
      $this->ticketId = $ticketId;
      $this->clientId = $clientId;
      $this->comment = $comment;
      $this->date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    }

    static function createTicketComment(PDO $db, $ticketId, $clientId, $comment) {
      $stmt = $db->prepare('
        INSERT INTO Ticket_Comment (TicketID, ClientID, Comment, Date)
        VALUES (?, ?, ?, ?)
      ');
      $stmt->execute([$ticketId, $clientId, $comment, date('Y-m-d H:i:s')]);
      return $db->lastInsertId();
    }

    static function addTicketDocument(PDO $db, $commentId, $path) {
      $stmt = $db->prepare('
        INSERT INTO Comment_Document (CommentID, Path)
        VALUES (?, ?)
      ');
      $stmt->execute([$commentId, $path]);
    }

    static function getDocuments(PDO $db, $commentId) {
        $stmt = $db->prepare('
            SELECT *
            FROM Comment_Document
            WHERE CommentID = ?
        ');
        $stmt->execute([$commentId]);
        return $stmt->fetchAll();
    }
  }
?>