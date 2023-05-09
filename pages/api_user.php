<?php
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/client.class.php');
    require_once(__DIR__ . '/../utils/util_funcs.php');

    $ret = array();
    $userType = getUserType($db, $_SESSION['IDUSER']);

    if ($userType != 'Admin' && $userType != 'Agent') $ret['error'] = 'You don\'t have permission to access this page!';

    if (!isset($_GET['id'])) $ret['error'] = 'No client id provided!';

    if (!isset($ret['error'])) {
        $id = $_GET['id'];
        $clientInfo = Client::getClient($db, $id);
        $ret['id'] = $clientInfo->id; 
        $ret['name'] = $clientInfo->name; 
        $ret['username'] = $clientInfo->username; 
        $ret['email'] = $clientInfo->email; 
        $ret['role'] = getUserType($db, $id);
    }

    echo json_encode($ret);
?>