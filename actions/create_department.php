<?php
  include_once('../utils/session.php');
  include_once('../database/user_db.php');
  include_once('../database/connection.db.php');
  include_once('../database/user.class.php');
  include_once('../utils/util_funcs.php');
  include_once('../database/department.class.php');
  
  $db = getDatabaseConnection();
  session_start();
  
  if (!Session::isLoggedIn())
    die(header('Location: ../pages/login.php'));

  var_dump($_POST);
  $departmentName = $_POST['departmentName'];
  
  if ($id = Department::addDepartment($db, $departmentName))
    $response = array('status' => 'success', 'departmentID' => $id);
  else 
    $response = array('status' => 'error', 'message' => 'Department already exists!');
  
  header('Location: /pages/admin_page.php');
?>