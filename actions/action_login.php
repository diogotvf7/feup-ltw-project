<?php
  include_once('../utils/session.php');
  include_once('../database/user_db.php');
  include_once('../database/connection.db.php');
  include_once('../database/client.class.php');
  include_once('../utils/util_funcs.php');

  session_start();
  $username = $_POST['username'];
  $password = $_POST['password'];
  $db = getDatabaseConnection();
  
  if (checkUserNotRegistered($db,$username)) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed!');
    header('Location: /pages/login.php');
  } 

  else if (checkUserCredentials($db, $username, $password)) {
    $client = Client::getClientByUsername($db,$username);
    $_SESSION['IDUSER'] = $client->id;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged in successfully!');
    if (getUserType($db,$_SESSION['IDUSER']) == 'Admin' || getUserType($db,$_SESSION['IDUSER']) == 'Agent'){
      header('Location: /pages/display_tickets.php');
    }
    else{
      header('Location: /pages/my_tickets.php');
    }
  } else {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed!');
    header('Location: /pages/login.php');
  }
?>