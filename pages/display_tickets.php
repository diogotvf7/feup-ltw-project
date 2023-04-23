<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/ticket.tpl.php');
  require_once (__DIR__ . '/../database/admin.class.php');
  require_once (__DIR__ . '/../database/agent.class.php');
  require_once (__DIR__ . '/../database/client.class.php');
  require_once (__DIR__ . '/../database/ticket.class.php');

  $db = getDatabaseConnection();
  /* ACTUAL CODE */
  // drawHeader([]);
  // $user1 = new Admin(1, 'Admin', 'admin', 'admin@admin.com', '123456');
  // $user2 = new Agent(2, 'Agent', 'agent', 'agent@agent.com', '123456');
  // $user3 = new Client(3, 'Client', 'client', 'client@client.com', '123456');
  // drawSideBar($user1);
  // drawFooter();
  
  // // // // // // // // // // // // // // // // // // // // 

  /* ASSURING TICKETS ARE BEING FETCHED */
  // $ticketsIds = Ticket::getAllTickets($db);
  // var_dump($ticketsIds);
  // echo '<br>';
  // echo 'number of tickets -> ' . sizeof($ticketsIds);
  // echo '<br>';
  // foreach ($ticketsIds as $ticketId) {
  //   $ticket = Ticket::getTicketData($db, $ticketId);
  //   var_dump($ticket);
  // }

  // // // // // // // // // // // // // // // // // // // // 

  /* Display a ticket for testing */

  // echo 'Attempting to create ticket object!<br>';
  // $ticket = new Ticket(1, 'Issue with product', 'I am having trouble with my product', 'Open', 1, 3, 1, '2022-01-01 12:00:00');
  // echo 'Ticket object created!<br>';


  drawHeader(['ticket_colors']);
  $user1 = new Admin(1, 'Admin', 'admin', 'admin@admin.com', '123456');
  $user2 = new Agent(2, 'Agent', 'agent', 'agent@agent.com', '123456');
  $user3 = new Client(3, 'Client', 'client', 'client@client.com', '123456');
  drawSideBar($user1);
  $tickets = Ticket::getAllTickets($db);
  drawTicketsList($db, $tickets);
  // drawTicket($db, 1);
  drawFooter();
?>
