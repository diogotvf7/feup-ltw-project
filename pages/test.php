<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/comment.class.php');

    echo '<br><br><br><br>';


    $comment = TicketComment::createTicketComment(
        $db,
        1,
        1,
        'test comment'
    );
    var_dump($comment);
?>