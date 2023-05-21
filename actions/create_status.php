<?php
    include_once('../utils/session.php');
    include_once('../database/user_db.php');
    include_once('../database/connection.db.php');
    include_once('../database/user.class.php');
    include_once('../utils/util_funcs.php');
    include_once('../database/status.class.php');

    $db = getDatabaseConnection();
    session_start();

    if (!Session::isLoggedIn())
    die(header('Location: ../pages/login.php'));

    var_dump($_POST);
    $statusName = $_POST['statusName'];
  
    Status::addStatus($db, $statusName);

    header('Location: /pages/admin_page.php');
?>