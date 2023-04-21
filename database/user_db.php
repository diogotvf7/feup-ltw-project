<?php
require_once(__DIR__ . 'connection.db.php');

function signUpUser($email,$username,$password){
    $db = getDatabaseConnection();

    $stmt = $db->prepare('INSERT INTO Client(Username,Email, password) VALUES(?,?,?)');
    $stmt->execute((array($email,$username,$password)));
}

function checkUserCredentials($email,$password){
    $db = getDatabaseConnection();

    $stmt = $db->prepare('SELECT * FROM Client WHERE Email = ?');
    $stmt->execute()(array($email));
    return $stmt->fetch()['password'] == $password;
}

?>