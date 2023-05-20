<?php
  include_once('../includes/session.php');
  include_once('../database/user_db.php');
  include_once('../database/connection.db.php');
  include_once('../database/user_db.php');
  include_once('../database/user.class.php');
  include_once('../utils/util_funcs.php');

  session_start();
  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: /pages/login.php');
  }
  $db = getDatabaseConnection();
  
  var_dump($_POST);
  
  if (!checkPassword($db, $_SESSION['IDUSER'], $_POST['password'])) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Incorrect password!');    
    die(header('Location: /pages/my_account.php'));
  }
  
  if (isset($_POST['change-password'])) {
    if ($_POST['new-password'] != $_POST['confirm-new-password']) {
      $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Incorrect password!');    
      die(header('Location: /pages/my_account.php'));
    }
    updateAccountData($db, 
      $_SESSION['IDUSER'], 
      $_POST['name'],
      $_POST['username'],
      $_POST['email'],
      $_POST['new-password']
    );
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Account information successfully updated!');    
    die(header('Location: /pages/my_account.php'));
  }

  updateAccountData($db, 
    $_SESSION['IDUSER'], 
    $_POST['name'],
    $_POST['username'],
    $_POST['email'],
    $_POST['password']
  );
  $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Account information successfully updated!');    
  die(header('Location: /pages/my_account.php'));
?>
