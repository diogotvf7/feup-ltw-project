<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/comment.class.php');
    require_once(__DIR__ . '/../database/user.class.php');

    echo '<br><br><br><br>';


    for ($i = 1; $i <= 15; $i++) {
        echo $i . '   ' . User::getUser($db, $i)->username . '<br>';
    }

    // $user = User::getUser($db, 1)->username;
    // var_dump($user);
?>