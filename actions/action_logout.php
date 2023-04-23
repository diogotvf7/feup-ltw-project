<?php
  include_once('../includes/session.php');
  include_once('../database/user_db.php');
  include_once('../database/connection.db.php');

  session_start();
  if (session_destroy()) {
    unset($_SESSION['IDUSER']);
    header("Location: ../pages/login.php");
}

?>