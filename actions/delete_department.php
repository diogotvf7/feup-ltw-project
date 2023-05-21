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

    if ($_SESSION['PERMISSIONS'] != 'Admin') 
    die(header('Location: /pages/my_tickets.php'));

    $data = json_decode(file_get_contents('php://input'), true);

    $departmentID = $data['departmentID'];

    if (Department::getDepartment($db, $departmentID) == null) {
        $_SESSION['ERROR'] = "Department doesn't exist";
        $response = array('status' => 'error', 'msg' => "Department doesn't exist");
        header('Content-Type: application/json');
        echo json_encode($response);
        die();
    }
    
    Department::deleteDepartment($db, $departmentID);
    $response = array('status' => 'success', 'id' => $departmentID,  'msg' => "Department deleted");
    header('Content-Type: application/json');
    echo json_encode($response);
?>