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
        SELECT Name
        FROM Ticket_Tag JOIN Tag
        USING(TagID)
        WHERE TicketID = ?
        ');
      if ($stmt->execute([$ticketID]));
      if ($tickets = $stmt->fetchAll()) {
        return $tickets;
      } else return null;
    }
    
    static function getDocuments(PDO $db, $ticketId) {
      $stmt = $db->prepare('
        SELECT Path
        FROM Ticket_Document
        WHERE TicketID = ?
      ');
      $stmt->execute(array($ticketId));
      if ($paths = $stmt->fetchAll()) {
        return $paths;
      } else return null;
    }

    static function getUserTickets(PDO $db, $userID) {
      $stmt = $db->prepare('
        SELECT DISTINCT TicketID
        FROM Ticket JOIN Client ON Client.ClientID = Ticket.ClientID WHERE Client.ClientID = ?');
      $stmt->execute([$userID]);
      if ($tickets = $stmt->fetchAll()) {
        return $tickets;
      } else return null;
    }

    static function getAgentTickets(PDO $db, $userID) {
      $stmt = $db->prepare('
        SELECT DISTINCT TicketID
        FROM Ticket JOIN Agent ON Ticket.AgentID = ?');
      if ($stmt->execute([$userID]));
      if ($tickets = $stmt->fetchAll()) {
        $tickets = Ticket::sortTicketsMostRecent($db, $tickets);
        return $tickets;
      } else return null;
    }

    static function sortTicketsMostRecent(PDO $db, $tickets) {
      $ticket_ids = array_column($tickets, 'TicketID');
      $ticketsPlaceholders = implode(',', $ticket_ids);
      $stmt = $db->prepare('
        SELECT TicketID
        FROM Ticket
        WHERE TicketID IN (' . $ticketsPlaceholders . ')
        ORDER BY Date DESC');
      if ($stmt->execute());
      if ($tickets = $stmt->fetchAll()) {
        return $tickets;
      } else {return null;}
    }

    static function sortTicketsLeastRecent(PDO $db, $tickets) {
      if (empty($tickets)) return null;
      $ticket_ids = array_column($tickets, 'TicketID');
      $ticketsPlaceholders = implode(',', $ticket_ids);
      $stmt = $db->prepare('
        SELECT TicketID
        FROM Ticket
        WHERE TicketID IN (' . $ticketsPlaceholders . ')
        ORDER BY Date ASC');
      if ($stmt->execute());
      if ($tickets = $stmt->fetchAll()) {
        return $tickets;
      } else {return null;}
    }
  }
?>