<?php
  include_once('../includes/session.php');
  include_once('../database/user_db.php');
  include_once('../database/connection.db.php');


  $userid = $_POST['userid'];
  $password = $_POST['password'];
  $db = getDatabaseConnection();

  if (checkUserCredentials($db, $userid, $password)) {
    $_SESSION['userid'] = $userid;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged in successfully!');
    header('Location: /pages/display_tickets.php');
  } else {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed!');
    header('Location: /pages/login.php');
  }

?>