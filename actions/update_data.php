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

    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $newRole = $_POST['newRole'];
    updateUserData($db, $id, $name, $username, $email);
    if (getUserType($db, $id) != $newRole){
        switch($newRole){
            case 'Admin':
                User::makeAdmin($db, $id);
                break;
            case 'Agent':
                User::makeAgent($db, $id);
                break;
            case 'Client':
                User::makeClient($db, $id);
                break;
            }
    }

?>