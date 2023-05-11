<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  session_start();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/ticket.tpl.php');
  require_once (__DIR__ . '/../database/user.class.php');
  require_once (__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/tag.class.php');

  if (!Session::isLoggedIn())
    die(header('Location: /pages/login.php'));
  drawHeader(['ticket']);
  $db = getDatabaseConnection();
  $tickets = Ticket::getAgentTickets($db, $_SESSION['IDUSER']);
  if ($tickets == null) {echo 'No tickets found!' . '<br>';}
  else {drawTicketsList($db,$tickets);}
  drawFooter();
?>