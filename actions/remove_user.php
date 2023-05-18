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
    if (!Session::isLoggedIn()) die(header('Location: /pages/login.php'));
    
    $data = json_decode(file_get_contents('php://input'), true);

    $usersToRemove = $data['usersToRemove'];

    if (empty($usersToRemove)){
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'No users selected!');
        header('Location: /pages/users.php');
    }
    foreach($usersToRemove as $id){
        if (getUserType($db, $id) == 'Admin'){
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Cannot remove admin!');
        header('Location: /pages/users.php');
        }
        else {
            removeUser($db, $id);
            $_SESSION['messages'][] = array('type' => 'success', 'content' => 'User removed successfully!');
            header('Location: /pages/users.php');
        }
    }
?>