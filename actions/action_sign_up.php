<?php
  include_once('../includes/session.php');
  include_once('../database/user_db.php');
  include_once('../database/connection.db.php');
  include_once('../database/user.class.php');

  session_start();
  $username = $_POST['username'];
  $email = $_POST['email'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $db = getDatabaseConnection();

  if (empty($username) || empty($email) || empty($name) || empty($password)) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed!');
    header('Location: '.$_SERVER['HTTP_REFERER']);
  }

  if (checkUserNotRegistered($db, $username, $email)) { // we should create restrictions for the username and password
    signUpUser($db,$name, $email,$username,$password);
    $_SESSION['IDUSER'] = User::getClientByUsername($db,$username)->id;
    $_SESSION['PERMISSIONS'] = getUserType($db, $user->id);
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged in successfully!');
    header('Location: /pages/my_tickets.php');
  } else {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed!');
    header('Location: '.$_SERVER['HTTP_REFERER']);
  }

?>