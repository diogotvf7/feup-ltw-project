<?php
    header('Content-Type: application/json');


    require_once(__DIR__ . '/../utils/session.php');
    session_start();
    
    require_once(__DIR__ . '/../database/faq.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    $ret = array();

    if (!Session::isLoggedIn()) $ret['error'] = 'User not logged in!';

    if (!isset($_GET['functionname'])) $ret['error'] = 'No function name!';

    if (!isset($ret['error'])) {
        switch($_GET['functionname']) {
            case 'fetchfaqs':
                if (!isset($_GET['n'])) {
                    $ret['error'] = 'Number of faqs to fetch (n) not specified!';
                    break;
                }
                if (!isset($_GET['page'])) {
                    $ret['error'] = 'Page of faqs to fetch (page) not specified!';
                    break;
                }
                if (!is_numeric($_GET['n']) || !is_numeric($_GET['page'])) $ret['error'] = 'Arguments must be of type string!';
                else $ret['result'] = FAQ::fetchFAQs($db, floatval($_GET['n']), floatval($_GET['page']));
                break;
            case 'deleteFaq':
                if ($_SESSION['PERMISSIONS'] != 'Admin' && $_SESSION != 'Agent') {
                    $ret['error'] = 'User does not have permission to delete FAQs!';
                    break;
                } 
                if (!isset($_GET['id'])) {
                    $ret['error'] = 'Id must be provided!';
                    break;
                }
                FAQ::deleteFAQ($db, $_GET['id']);
                $ret['message'] = 'Faq with id: ' . $_GET['id'] . ' deleted successfully!';
                break;
            default:
               $ret['error'] = 'Couldn\'t find function '.$_GET['functionname'].'!';
               break;
        }
    }

    echo json_encode($ret);
?>