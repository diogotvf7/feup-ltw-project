<?php
    require_once('../utils/session.php');
    require_once('../database/connection.db.php');
    require_once('../database/faq.class.php');

    session_start();
    $db = getDatabaseConnection();

    if (!Session::isLoggedIn())
        die(header('Location: /pages/login.php'));
    if ($_SESSION['PERMISSIONS'] != 'Admin' && $_SESSION['PERMISSIONS'] != 'Agent')
        die(header('Location: /pages/faq.php'));
    if ($_SERVER["REQUEST_METHOD"] != "POST")
        exit("POST request expected");

    $faq_question = $_POST['faq_question'];
    $faq_answer = $_POST['faq_answer'];

    FAQ::createFaq($db, $faq_question, $faq_answer);

    header("Location: /../pages/admin_page.php");

?>

