<?php
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../database/faq.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    $ret = array();

    if (!isset($_GET['functionname'])) $ret['error'] = 'No function name!';

    if (!isset($_GET['n'])) $ret['error'] = 'No function arguments!';

    if (!isset($_GET['page'])) $ret['error'] = 'No function arguments!';

    if (!isset($ret['error'])) {
        switch($_GET['functionname']) {
            case 'fetchfaqs':
                if (!is_numeric($_GET['n']) || !is_numeric($_GET['page'])) $ret['error'] = 'Arguments must be of type string!';
                else $ret['result'] = FAQ::fetchFAQs($db, floatval($_GET['n']), floatval($_GET['page']));
                break;

            default:
               $ret['error'] = 'Couldn\'t find function '.$_GET['functionname'].'!';
               break;
        }
    }

    echo json_encode($ret);
?>