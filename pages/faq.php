<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../templates/faq.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    if (!Session::isLoggedIn())
        die(header('Location: /pages/login.php'));
    drawHeader(['faq'], ['faq', 'general']);
    drawNavBar($_SESSION['PERMISSIONS']);
    drawFAQList();

    drawFooter();
?>