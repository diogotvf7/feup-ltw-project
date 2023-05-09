<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../templates/faq.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $userType = getUserType($db, $_SESSION['IDUSER']);

    if (!Session::isLoggedIn())
        die(header('Location: /pages/login.php'));
    drawHeader(['faq'], ['style']);
    drawNavBar($userType);
    $faqs = FAQ::fetchFAQs($db, 10, 0);
    drawFAQList($faqs);

    drawFooter();
?>