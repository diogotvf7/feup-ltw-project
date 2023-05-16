<?php
  declare(strict_types = 1);

  class TicketUpdate {
    public int $id;
    public int $ticketId;
    public string $type;
    public string $message;
    public Datetime $date;
    
    public function __construct(int $id, int $ticketId, string $type, string $message, string $date)
    {
      $this->id = $id;
      $this->ticketId = $ticketId;
      $this->type = $type;
      $this->message = $message;
      $this->date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    }

    static function createTicketUpdate(PDO $db, $ticketId, $type, $message) {
      $stmt = $db->prepare('
        INSERT INTO Ticket_Update (TicketID, Type, Message, Date)
        VALUES (?, ?, ?, ?)
      ');
      $stmt->execute([$ticketId, $type, $message, date('Y-m-d H:i:s')]);
    }
  }
?>