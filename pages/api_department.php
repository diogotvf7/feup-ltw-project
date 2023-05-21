<?php
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/department.class.php');
    require_once(__DIR__ . '/../utils/util_funcs.php');

    $ret = array();

    if (!Session::isLoggedIn()) $ret['error'] = 'User not logged in!';

    if (!isset($_GET['func'])) $ret['error'] = 'No function provided!';

    if (!isset($ret['error'])) {
        switch ($_GET['func']) {
            case 'departments':
                if ($_SESSION['PERMISSIONS'] != 'Admin' && $_SESSION['PERMISSIONS'] != 'Agent') {
                    $ret['error'] = 'You don\'t have permission to access this data!';
                    break;
                }
                $ret = Department::getAllDepartments($db);
                break;
            case 'getDepartmentInfo':
                $departmentInfo = Department::getDepartment($db, $_GET['id']);
                $ret['id'] = $departmentInfo->id;
                $ret['name'] = $departmentInfo->name;
                break;
            case 'users_in_department':
                $id = Department::getDepartmentbyName($db,$_GET['name']);
                $ret = Department::getUsersInDepartments($db,$id);
                break;
            case 'user_departments':
                $ret = Department::getUserDepartments($db);
                break;
            case 'remove_user':
                if ($_SESSION['PERMISSIONS'] != 'Admin') {
                    $ret['error'] = 'You don\'t have permission to access this data!';
                    break;
                }
                if (!isset($_GET['userID'])) {
                    $ret['error'] = 'No userID provided!';
                    break;
                }
                if (!isset($_GET['departmentID'])) {
                    $ret['error'] = 'No departmentID provided!';
                    break;
                }
                $ret = Department::removeUserFromDepartment($db, $_GET['userID'], $_GET['departmentID']);  
                break;
            case 'remove_department':
                if ($_SESSION['PERMISSIONS'] != 'Admin') {
                    $ret['error'] = 'You don\'t have permission to access this data!';
                    break;
                }
                if (!isset($_GET['departmentID'])) {
                    $ret['error'] = 'No departmentID provided!';
                    break;
                }
                $ret = Department::deleteDepartment($db, $_GET['departmentID']);
                break;
            default:
                $ret['error'] = 'Couldn\'t find function '.$_GET['functionname'].'!';
                break;
        }
    }

    echo json_encode($ret);
?>