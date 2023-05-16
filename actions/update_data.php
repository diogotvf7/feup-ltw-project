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
    $id = $data['id'];
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $newRole = $data['newRole'];
    /*
    echo "<script> console.log('$id') </script>";
    echo "<br>";
    echo "<script> console.log('$name') </script>";
    echo "<br>";
    echo "<script> console.log('$username') </script>";
    echo "<br>";
    echo "<script> console.log('$email') </script>";
    echo "<br>";
    echo "<script> console.log('$newRole') </script>";
    */
    
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