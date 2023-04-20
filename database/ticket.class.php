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

    static function getTickets($status, $tags, $departments) {
      // TODO
    } 
  }
?>