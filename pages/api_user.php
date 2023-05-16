<?php
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../utils/util_funcs.php');

    $ret = array();

    if ($_SESSION['PERMISSIONS'] != 'Admin' && $_SESSION['PERMISSIONS'] != 'Agent') $ret['error'] = 'You don\'t have permission to access this data!';

    if (!isset($_GET['func'])) $ret['error'] = 'No function provided!';

    if (!isset($_GET['id'])) $ret['error'] = 'No client id provided!';

    if (!isset($ret['error'])) {
        switch ($_GET['func']) {
            case 'getSingleUser':
                $id = $_GET['id'];
                $clientInfo = User::getUser($db, $id);
                $ret['id'] = $clientInfo->id; 
                $ret['name'] = $clientInfo->name; 
                $ret['username'] = $clientInfo->username; 
                $ret['email'] = $clientInfo->email; 
                $ret['role'] = getUserType($db, $id);
                break;
            case 'getAgentInfo':
                if ($_SESSION['PERMISSIONS'] != 'Admin') {
                    $ret['error'] = 'You don\'t have permission to access this data!';
                    break;
                }
                $id = $_GET['id'];
                $ret['id'] = $id;
                $ret['departments'] = User::getDepartment($db, $id);
                $ret['responsible'] = User::getTicketsResponsible($db, $id);
                $ret['open'] = User::getTicketsOpen($db, $id);
                $ret['closed'] = User::getTicketsClosed($db, $id);
                break;
            case 'getClientInfo':
                $id = $_GET['id'];
                $ret['id'] = $id;
                $ret['made'] = User::getTicketsMade($db, $id);
                break;
            default:
                $ret['error'] = 'Couldn\'t find function '.$_GET['functionname'].'!';
                break;
        }
        
    }

    echo json_encode($ret);
?>