<?php
    include_once('../utils/session.php');
    include_once('../database/connection.db.php');
    include_once('../database/ticket.class.php');
    include_once('../database/department.class.php');
    include_once('../database/user.class.php');
    include_once('../database/user_db.php');
    include_once('../utils/util_funcs.php');

    session_start();
    $db = getDatabaseConnection();
    
    $data = json_decode(file_get_contents('php://input'), true);

    if (!Session::isLoggedIn())
        die(header('Location: /pages/login.php'));
    if ($_SERVER["REQUEST_METHOD"] != "POST")
        exit("POST request expected");

    $userID = $data['userID'];
    $departmentID = $data['departmentID'];
    
    User::removeUserFromDepartment($db, $userID, $departmentID);



?>