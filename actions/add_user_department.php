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

    if (!Session::isLoggedIn())
        die(header('Location: /pages/login.php'));

    if ($_SESSION['PERMISSIONS'] != 'Admin'){
        die(header('Location: /pages/my_tickets.php'));
    }

    $data = json_decode(file_get_contents('php://input'), true);
    /*
    foreach ($data['newMembers'] as $member){
        $user = User::getClientByUsername($db, $member);
        $departmentID = Department::getDepartmentByName($db, $data['departmentName']);
        User::addUsertoDeparment($db, $user->id, $departmentID);
    }
    */

?>