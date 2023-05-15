<?php
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/tag.class.php');
    require_once(__DIR__ . '/../utils/util_funcs.php');

    $ret = array();

    if (!Session::isLoggedIn()) $ret['error'] = 'User not logged in!';

    if (!isset($_GET['func'])) $ret['error'] = 'No function provided!';

    if (!isset($ret['error'])) {
        switch ($_GET['func']) {
            case 'tags':
                if ($_SESSION['PERMISSIONS'] != 'Admin' && $_SESSION['PERMISSIONS'] != 'Agent') {
                    $ret['error'] = 'You don\'t have permission to access this data!';
                    break;
                }
                $ret = Tag::getTags($db);
                break;
            case 'user_tags':
                $ret = Tag::getUserTags($db);
                break;
            default:
                $ret['error'] = 'Couldn\'t find function '.$_GET['functionname'].'!';
                break;
        }
    }

    echo json_encode($ret);
?>