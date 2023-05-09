<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  session_start();

  require_once(__DIR__ . '/../database/connection.db.php');
  $db = getDatabaseConnection();

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/ticket.tpl.php');
  require_once (__DIR__ . '/../database/admin.class.php');
  require_once (__DIR__ . '/../database/agent.class.php');
  require_once (__DIR__ . '/../database/client.class.php');
  require_once (__DIR__ . '/../database/ticket.class.php');

  $userType = getUserType($db, $_SESSION['IDUSER']);

  if (!Session::isLoggedIn())
    die(header('Location: /pages/login.php'));
  drawHeader(['ticket_colors'], ['style']);
  drawNavBar($userType);
  $tickets = Ticket::getAllTickets($db);
  $tickets = Ticket::sortTicketsLeastRecent($db,$tickets);
  drawTicketsList($db, $tickets);
  drawFooter();
?>
