<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  session_start();

  require_once(__DIR__ . '/../database/connection.db.php');
  $db = getDatabaseConnection();

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/ticket.tpl.php');
  require_once (__DIR__ . '/../database/user.class.php');
  require_once (__DIR__ . '/../database/ticket.class.php');

  if (!Session::isLoggedIn())
    die(header('Location: /pages/login.php'));
  drawHeader(['display_tickets'], ['general', 'ticket']);
  drawNavBar($_SESSION['PERMISSIONS']);
  drawTicketsListPage();
  drawFooter();
?>
