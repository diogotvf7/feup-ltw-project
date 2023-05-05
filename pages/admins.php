<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/ticket.tpl.php');
    require_once(__DIR__ . '/../templates/user_lists.tpl.php');
    require_once (__DIR__ . '/../database/admin.class.php');
    require_once (__DIR__ . '/../database/agent.class.php');
    require_once (__DIR__ . '/../database/client.class.php');
    require_once (__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/tag.class.php');

    drawHeader(['users_list'], ['style']);
    drawNavBar($db, $_SESSION['IDUSER']);
    ?><main><?php
    $users = Admin::getAllAdmins($db);
    drawUsersList($db,$users);
    ?></main><?php
    drawFooter();
?>