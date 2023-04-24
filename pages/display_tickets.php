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

  drawHeader(['ticket_colors'], ['style']);
  $user1 = new Admin(1, 'Admin', 'admin', 'admin@admin.com', '123456');
  $user2 = new Agent(2, 'Agent', 'agent', 'agent@agent.com', '123456');
  $user3 = new Client(3, 'Client', 'client', 'client@client.com', '123456');
  drawNavBar($user1);
  $tickets = Ticket::getAllTickets($db);
  drawTicketsList($db, $tickets);
  // drawTicket($db, 1);
  drawFooter();
?>
