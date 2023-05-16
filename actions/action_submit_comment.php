<?php
    include_once('../utils/session.php');
    include_once('../database/connection.db.php');
    include_once('../database/ticket.class.php');
    include_once('../database/comment.class.php');
    include_once('../database/department.class.php');

    session_start();
    $db = getDatabaseConnection();

    var_dump($_POST);
    echo "<br><br><br><br>";
    var_dump($_FILES);    

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
        if (!move_uploaded_file($_FILES['files']['tmp_name'][$i], $destination)) exit("Error moving file");
        Comment::addTicketDocument($db, $commentId, $path);
    }

    echo "<br><br><br><br>";
    echo 'ticket id: ' . $ticketId;
    echo "<br>";
    echo 'client id: ' . $clientId;
    echo "<br>";
    echo 'comment : ' . $comment;
    echo "<br>";
    echo 'date : ' . $date;
    echo "<br>";


    header("Location: /../pages/ticket_page.php?id=" . $ticketId);

?>
