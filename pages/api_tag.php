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
                $ret = array_map('decodeTag', Tag::getTags($db));
                break;
            case 'user_tags':
                $ret = array_map('decodeTag', Tag::getUserTags($db));
                break;
            case 'getMostUsedTags':
                $ret = array_map('decodeTag',Tag::getMostUsedTags($db));
                break; 
            default:
                $ret['error'] = 'Couldn\'t find function '.$_GET['functionname'].'!';
                break;
        }
    }

    echo json_encode($ret);
?>

<?php function decodeTag($tag) {
    $tag['Name'] = htmlspecialchars_decode($tag['Name']);
    return $tag;
} ?>