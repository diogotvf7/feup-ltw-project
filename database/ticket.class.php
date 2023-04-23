<?php
  declare(strict_types = 1);

  class Ticket {
    public int $id;
    public string $title;
    public string $description;
    public string $status;
    public int $clientId;
    public int $agentId;
    public int $departmentId;
    public Datetime $date;
    
    public function __construct(int $id, string $title, string $description, string $status, int $clientId, int $agentId, int $departmentId, string $date)
    {
      $this->id = $id;
      $this->title = $title;
      $this->description = $description;
      $this->status = $status;
      $this->clientId = $clientId;
      $this->agentId = $agentId;
      $this->departmentId = $departmentId;
      $this->date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    }

    static function filterTicketsByStatus(PDO $db, $statuses) {
      $statusPlaceholders = implode(',', array_fill(0, count($statuses), '?'));
      $stmt = $db->prepare('
        SELECT DISTINCT TicketID
        FROM Ticket
        WHERE Status IN (' . $statusPlaceholders . ')');
      if ($stmt->execute($statuses));
      if ($tickets = $stmt->fetchAll()) {
        return $tickets;
      } else return null;
    }

    static function filterTicketsByTags(PDO $db, $tags) {
      $tagsPlaceholders = implode(',', array_fill(0, count($tags), '?'));
      $stmt = $db->prepare('
        SELECT DISTINCT TicketID
        FROM Ticket JOIN TicketTag 
        USING(TicketID) 
        WHERE TagID IN (' . $tagsPlaceholders . ')');
      if ($stmt->execute($tags));
      if ($tickets = $stmt->fetchAll()) {
        return $tickets;
      } else return null;
    }

    static function filterTicketsByDeparments(PDO $db, $departments) {
      $departmentsPlaceholders = implode(',', array_fill(0, count($departments), '?'));
      $stmt = $db->prepare('
        SELECT DISTINCT TicketID
        FROM Ticket
        WHERE DepartmentID IN (' . $departmentsPlaceholders . ')');
      if ($stmt->execute($departments));
      if ($tickets = $stmt->fetchAll()) {
        return $tickets;
      } else return null;
    }

    static function getAllTickets(PDO $db) {
      $stmt = $db->prepare('
        SELECT TicketID
        FROM Ticket');
      if ($stmt->execute());
      if ($tickets = $stmt->fetchAll()) {
        return $tickets;
      } else return null;
    }

    static function getTickets(PDO $db, $statuses, $tags, $departments) {
      $aux = Ticket::getAllTickets($db);
      $result = array();
      if (!empty($statuses))
        $result = array_intersect($aux, Ticket::filterTicketsByStatus($db, $statuses));
      if (!empty($tags)) 
        $result = array_intersect($aux, Ticket::filterTicketsByTags($db, $tags));
      if (!empty($departments))
        $result = array_intersect($aux, Ticket::filterTicketsByDeparments($db, $departments));
      return $result;
    } 

    static function getTicketData(PDO $db, $ticketID) {
      $stmt = $db->prepare('
        SELECT TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date
        FROM Ticket
        WHERE TicketID = ?');
      if ($stmt->execute([$ticketID]));
      if ($ticket = $stmt->fetch()) {
        return new Ticket(
          $ticket['TicketID'],
          $ticket['Title'],
          $ticket['Description'],
          $ticket['Status'],
          $ticket['ClientID'],
          $ticket['AgentID'],
          $ticket['DepartmentID'],
          $ticket['Date']
        );
      } else return null;
    }

    static function getTicketTags(PDO $db, $ticketID) {
      $stmt = $db->prepare('
        SELECT TagID
        FROM Ticket_Tag
        WHERE TicketID = ?
        ');
      if ($stmt->execute([$ticketID]));
      if ($tickets = $stmt->fetchAll()) {
        return $tickets;
      } else return null;
    }

  }
?>