<?php
  include_once('../includes/session.php');
  include_once('../database/user_db.php');
  include_once('../database/connection.db.php');


  $username = $_POST['username'];
  $email = $_POST['email'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $db = getDatabaseConnection();

  if (checkUserNotRegistered($db, $username, $email)) { // we should create restrictions for the username and password
    signUpUser($db,$name, $email,$username,$password);
    $_SESSION['userid'] = $userid;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged in successfully!');
    header('Location: /pages/display_tickets.php');
  } else {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed!');
    header('Location: '.$_SERVER['HTTP_REFERER']);
  }

?>