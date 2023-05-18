<?php
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    if (!Session::isLoggedIn())
        echo json_encode([
            'error' => 'User not logged in!',
        ]);

    echo json_encode([
        'id' => $_SESSION['IDUSER'],
        'permissions' => $_SESSION['PERMISSIONS'],
    ]);
?>