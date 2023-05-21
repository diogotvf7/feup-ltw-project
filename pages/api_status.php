<?php
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/status.class.php');
    require_once(__DIR__ . '/../utils/util_funcs.php');

    $ret = array();

    if (!Session::isLoggedIn()) $ret['error'] = 'User not logged in!';

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $ret = Status::getStatus($db);
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['name'])) $ret['error'] = 'Missing name!';
        else if (empty($_POST['name'])) $ret['error'] = 'Empty name!';
        else if (Status::addStatus($db, $_POST['name'])) 
            $ret['success'] = 'Status successfully added!';
        else
            $ret['failure'] = 'Failed to add status!';
    } else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        if (!isset($_GET['name'])) $ret['error'] = 'Missing name!';
        else if (empty($_GET['name'])) $ret['error'] = 'Empty name!';
        else if (Status::deleteStatus($db, $_GET['name'])) 
            $ret['success'] = 'Status successfully deleted!';
        else
            $ret['failure'] = 'Failed to delete status!';
    }

    echo json_encode($ret);
?>

<?php function decodeTag($tag) {
    $tag['Name'] = htmlspecialchars_decode($tag['Name']);
    return $tag;
} ?>