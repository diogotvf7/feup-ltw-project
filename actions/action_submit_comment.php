<?php
    include_once('../utils/session.php');
    include_once('../database/connection.db.php');
    include_once('../database/ticket.class.php');
    include_once('../database/comment.class.php');
    include_once('../database/department.class.php');

    session_start();
    $db = getDatabaseConnection();

    if (!Session::isLoggedIn())
        die(header('Location: /pages/login.php'));
    if ($_SERVER["REQUEST_METHOD"] != "POST")
        exit("POST request expected");

    $ticketId = $_POST['ticket_id'];
    $clientId = $_SESSION['IDUSER'];
    $comment = $_POST['comment'];
    $date = new DateTime('now',new DateTimeZone('Europe/Lisbon'));
    $date = $date->format('Y-m-d H:i:s');

    $commentId = Comment::createTicketComment(
        $db,
        $ticketId,
        $clientId,
        $comment,
        $date
    );

    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
        if ($_FILES['files']['name'][$i] == '') continue;
        if (!file_exists(__DIR__ . "/../docs/comments-docs/" . $commentId)) mkdir(__DIR__ . "/../docs/comments-docs/" . $commentId,  0777, true);
        $path = "docs/comments-docs/" . $commentId . "/" . $_FILES['files']['name'][$i];
        $destination = __DIR__ . "/../"  . $path;
        echo '<br>' . $destination . '<br>';
        if (!move_uploaded_file($_FILES['files']['tmp_name'][$i], $destination)) exit("Error moving file");
        Comment::addTicketDocument($db, $commentId, $path);
    }

    header("Location: /../pages/ticket_page.php?id=" . $ticketId);

?>
