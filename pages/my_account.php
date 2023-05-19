<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  session_start();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/my_account.tpl.php');

  if (!Session::isLoggedIn())
    die(header('Location: /pages/login.php'));
  drawHeader(['my_account'], ['general', 'my_account']);
  drawNavBar($_SESSION['PERMISSIONS']);
  drawMyAccountPage();
  drawFooter();
?>