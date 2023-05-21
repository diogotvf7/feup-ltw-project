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


  $data = json_decode(file_get_contents('php://input'), true);

  $departmentName = $data['departmentName'];
  
  $ret = Department::getDepartmentbyName($db, $departmentName);
  if ($ret != null) {
    $_SESSION['ERROR'] = "Department already exists";
    $response = array('status' => 'error', 'msg' => "Department already exists");
    header('Content-Type: application/json');
    echo json_encode($response);
    die();
  }
  
  Department::addDepartment($db, $departmentName);

  $id = Department::getDepartmentbyName($db, $departmentName);

  $response = array('status' => 'success', 'departmentID' => $id);
  
  header('Content-Type: application/json');
  echo json_encode($response);  
  ?>