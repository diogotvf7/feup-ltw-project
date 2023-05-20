<?php
  include_once('../utils/session.php');
  include_once('../database/user_db.php');
  include_once('../database/connection.db.php');
  include_once('../database/user.class.php');
  include_once('../utils/util_funcs.php');
  include_once('../database/department.class.php');
  
  $db = getDatabaseConnection();
  session_start();
  
  $departmentName = $_POST['department-name'];

  
  $ret = Department::getDepartmentbyName($db, $departmentName);
  if ($ret != null) {
    $_SESSION['ERROR'] = "Department already exists";
    header('Location: ../pages/admin_page.php');
    die();
  }
  Department::addDepartment($db, $departmentName);

  header('Location: ../pages/admin_page.php');
  
  ?>