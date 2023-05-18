<?php
  include_once('../includes/session.php');
  include_once('../database/user_db.php');
  include_once('../database/connection.db.php');
  include_once('../database/user.class.php');
  include_once('../utils/util_funcs.php');

  session_start();
  $username = $_POST['username'];
  $email = $_POST['email'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];
  $db = getDatabaseConnection();
  
  /*
  if ($password !== $confirmPassword){
    die(header('Location: /pages/login.php'));
  }
  */

  if (checkUserNotRegistered($db, $username, $email)) { // we should create restrictions for the username and password
    signUpUser($db, $name, $email,$username,$password);
    $user = User::getClientByUsername($db, $username);
    $_SESSION['IDUSER'] = $user->id;
    $_SESSION['PERMISSIONS'] = getUserType($db, $user->id);
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged in successfully!');
    header('Location: /pages/my_tickets.php');
  } else {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed!');
    header('Location: /pages/login.php');
  }

?>
