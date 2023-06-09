<?php
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../utils/util_funcs.php');

    $ret = array();

    if (!Session::isLoggedIn()) $ret['error'] = 'User not logged in!';

    if (!isset($_GET['func'])) $ret['error'] = 'No function provided!';

    if (!isset($ret['error'])) {
        switch ($_GET['func']) {
            case 'getAgents':
                if ($_SESSION['PERMISSIONS'] != 'Admin' && $_SESSION['PERMISSIONS'] != 'Agent') {
                    $ret['error'] = 'You don\'t have permission to access this data!';
                    break;  
                }
                $ret['agents'] = User::getAgents($db);
                break;
            case 'getSingleUser':
                if ($_SESSION['PERMISSIONS'] != 'Admin' && $_SESSION['PERMISSIONS'] != 'Agent') {
                    $ret['error'] = 'You don\'t have permission to access this data!';
                    break;  
                }
                if (!isset($_GET['id'])) {
                    $ret['error'] = 'No client id provided!';
                    break;
                }
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
                if (!isset($_GET['id']) && isset($_GET['username'])) {
                    $username = $_GET['username'];
                    $id = User::getClientByUsername($db, $username)->id;
                }
                else if (!isset($_GET['id']) && !isset($_GET['username'])) {
                    $ret['error'] = 'No client id or username provided!';
                    break;
                }
                else {$id = $_GET['id'];}
                $ret['id'] = $id;
                $ret['name'] = User::getUser($db, $id)->name;
                if (!isset($_GET['username'])) $ret['username'] = User::getUser($db, $id)->username;
                $ret['email'] = User::getUser($db, $id)->email;
                $ret['departments'] = User::getDepartment($db, $id);
                $ret['responsible'] = User::getTicketsResponsible($db, $id);
                $ret['open'] = User::getTicketsOpen($db, $id);
                $ret['closed'] = User::getTicketsClosed($db, $id);
                break;
            case 'getClientInfo':
                if ($_SESSION['PERMISSIONS'] != 'Admin' && $_SESSION['PERMISSIONS'] != 'Agent') {
                    $ret['error'] = 'You don\'t have permission to access this data!';
                    break;  
                }
                if (!isset($_GET['id'])) {
                    $ret['error'] = 'No client id provided!';
                    break;
                }
                $id = $_GET['id'];
                $ret['id'] = $id;
                $ret['made'] = User::getTicketsMade($db, $id);
                break;
            case 'getAccountInfo':
                $ret = User::getUser($db, $_SESSION['IDUSER']);
                break;
            case 'deleteAccount':
                User::RemoveUser($db, $_SESSION['IDUSER']);
                break;
            default:
                $ret['error'] = 'Couldn\'t find function '.$_GET['functionname'].'!';
                break;
        }
        
    }

    echo json_encode($ret);
?>