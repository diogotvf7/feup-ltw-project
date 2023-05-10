<?php
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../utils/util_funcs.php');

    $ret = array();

    if ($_SESSION['PERMISSIONS'] != 'Admin' && $_SESSION['PERMISSIONS'] != 'Agent') $ret['error'] = 'You don\'t have permission to access this data!';

    if (!isset($_GET['func'])) $ret['error'] = 'No function provided!';

    if (!isset($ret['error'])) {
        switch ($_GET['func']) {
            case 'ticket':
                if (!isset($_GET['id'])) $ret['error'] = 'No client id provided!';
                break;
            case 'tickets-list':
                $status = isset($_GET['status']) ? $_GET['status'] : '';
                $tags = isset($_GET['tags']) ? explode(',', $_GET['tags']) : array();
                $departments = isset($_GET['departments']) ? explode(',', $_GET['departments']) : array();
                $dateLowerBound = isset($_GET['dateLowerBound']) ? $_GET['dateLowerBound'] : '';
                $dateUpperBound = isset($_GET['dateUpperBound']) ? $_GET['dateUpperBound'] : '';
                $ret['status'] = $status;
                $ret['tags'] = $tags;
                $ret['departments'] = $departments;
                $ret['dateLowerBound'] = $dateLowerBound;
                $ret['dateUpperBound'] = $dateUpperBound;
                $ret['tickets'] = Ticket::getTickets($db, $status, $tags, $departments, $dateLowerBound, $dateUpperBound);
                break;
            default:
                $ret['error'] = 'Couldn\'t find function '.$_GET['functionname'].'!';
                break;
        }
        
    }

    echo json_encode($ret);
?>