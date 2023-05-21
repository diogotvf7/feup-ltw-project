<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/comment.class.php');
    require_once(__DIR__ . '/../database/status.class.php');
    require_once(__DIR__ . '/../database/user.class.php');

    echo '<br><br><br><br>';

    Status::addStatus($db, '!"#$%&/()=?*_:;><¹@£§½¬{[]}');

    var_dump(Status::getStatus($db));

    // $user = User::getUser($db, 1)->username;
    // var_dump($user);
?>