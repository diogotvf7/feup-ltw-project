<?php
require_once(__DIR__ . '/connection.db.php');

function checkUserNotRegistered(PDO $db,$username){
    $db = getDatabaseConnection();

    $stmt = $db->prepare('SELECT * FROM Client WHERE Username = ?');
    $stmt->execute((array($username)));
    return empty($stmt->fetch()); // se vazio -> nao existe ng com esse username ou email -> return false
}

function signUpUser($db,$name,$email,$username,$password){
    $db = getDatabaseConnection();

    $stmt = $db->prepare('INSERT INTO Client(Name,Email,Username, Password) VALUES(?,?,?,?)');
    $stmt->execute((array($name,$email,$username,$password)));
}

function checkUserCredentials($db,$username,$password){
    $db = getDatabaseConnection();
    if (checkUserNotRegistered($db,$username)) return false; // no user with such username/email
    $stmt = $db->prepare('SELECT * FROM Client WHERE Username = ?');
    $stmt->execute(array($username));
    return (($stmt->fetch()['Password'] == $password));
}
?>
