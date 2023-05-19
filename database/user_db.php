<?php
require_once(__DIR__ . '/connection.db.php');

    function checkUserNotRegistered(PDO $db,$username){
        $stmt = $db->prepare('SELECT * FROM Client WHERE Username = ?');
        $stmt->execute((array($username)));
        return empty($stmt->fetch()); // se vazio -> nao existe ng com esse username ou email -> return false
    }

    function signUpUser($db,$name, $email, $username, $password){
        $stmt = $db->prepare('INSERT INTO Client(Name,Email,Username, Password) VALUES(?,?,?,?)');
        $options = ['cost' => 12]; 
        $stmt->execute((array($name,$email,$username,password_hash($password,PASSWORD_DEFAULT,$options))));
    }

    function checkUserCredentials($db, $username, $password){
        if (checkUserNotRegistered($db,$username)) return false; // no user with such username/email
        $stmt = $db->prepare('SELECT Password FROM Client WHERE Username = ?');
        $stmt->execute(array($username));
        $hashed_password = $stmt->fetch()['Password'];
        return (password_verify($password, $hashed_password));
    } 

    function checkPassword(PDO $db, $id, $password) {
        $stmt = $db->prepare('
            SELECT Password 
            FROM Client 
            WHERE ClientID = ?
        ');
        $stmt->execute(array($id));
        $hashed_password = $stmt->fetch()['Password'];
        return password_verify($password, $hashed_password);
    }

    function updateUserData($db, $id, $name, $username, $email){
        $stmt = $db->prepare('UPDATE Client SET Name = ?, Email = ?, Username = ? WHERE ClientID = ?');
        $stmt->execute(array($name,$email,$username,$id, ));
    } 

    function RemoveUser($db, $id){
        $stmt = $db->prepare('
            DELETE FROM Client 
            WHERE ClientID = ?
        ');
        $stmt->execute(array($id));
    }

    function checkEmailAvailable(PDO $db, $email) {
        $stmt = $db->prepare('SELECT * FROM Client WHERE Email = ?');
        $stmt->execute([$email]);
        return empty($stmt->fetch());
    }

    function checkUsernameAvailable(PDO $db, $username) {
        $stmt = $db->prepare('SELECT * FROM Client WHERE Username = ?');
        $stmt->execute([$username]);
        return empty($stmt->fetch());
    }

    function updateAccountData(PDO $db, $id, $name, $username, $email, $password) {
        $stmt = $db->prepare('
            UPDATE Client 
            SET Name = ?, Email = ?, Username = ?, Password = ? 
            WHERE ClientID = ?
        ');
        $options = ['cost' => 12]; 
        $stmt->execute([$name, $email, $username, password_hash($password, PASSWORD_DEFAULT, $options), $id]);
    } 

?>
