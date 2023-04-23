<?php
  include_once('../utils/session.php');
  include_once('../database/user_db.php');
  include_once('../database/connection.db.php');
  include_once('../database/client.class.php');

  session_start();
  $userid = $_POST['userid'];
  $password = $_POST['password'];
  $db = getDatabaseConnection();
  
  if (checkUserNotRegistered($db,$userid,$userid)) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed!');
    echo '<script type="text/javascript">';
    echo 'alert("No account with such username/email. Sign up!")';
    echo '</script>';
    header('Location: /pages/login.php');
  } 
  else if (checkUserCredentials($db, $userid, $password)) {
    $_SESSION['emailUsername'] = $userid;
    $client = Client::getClientByEmailUsername($db,$userid);
    $_SESSION['IDUSER'] = $client->id;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged in successfully!');
    header('Location: /pages/display_tickets.php');
  } else {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed!');
    echo '<script type="text/javascript">';
    echo 'alert("Incorrect credentials!")';
    echo '</script>';
    header('Location: /pages/login.php');
  }

?>