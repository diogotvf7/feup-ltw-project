<?php
require_once(__DIR__ . '/connection.db.php');

function checkIfUserExists($db,$username,$email){
    $db = getDatabaseConnection();

    $stmt = $db->prepare('SELECT * FROM Client WHERE Email = ? or Username = ?');
    $stmt->execute((array($email,$username)));
    return empty($stmt->fetch());
}

function signUpUser($db,$name,$email,$username,$password){
    $db = getDatabaseConnection();

    $stmt = $db->prepare('INSERT INTO Client(Name,Email,Username, Password) VALUES(?,?,?,?)');
    $stmt->execute((array($name,$email,$username,$password)));
}

function checkUserCredentials($db,$userid,$password){
    $db = getDatabaseConnection();

    $stmt = $db->prepare('SELECT * FROM Client WHERE Email = ? or Username = ?');
    $stmt->execute((array($userid,$userid)));
    return ($stmt->fetch()['Password'] == $password && !empty($stmt->fetch()));
}
?>