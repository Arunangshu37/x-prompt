<?php
//TODO
    require_once __DIR__ . './../Constants/RoleConstants.php';
    require_once __DIR__ . './../Constants/ResponseConstants.php';
    include __DIR__ . './ValidateSession.php';
    session_start();
    if($_SESSION['user']['roleId'] != ADMIN_USER){
        session_abort();
        header('HTTP/1.1 '.UNAUTHORIZED_ACCESS_ERROR. ' ' . UNAUTHORIZED_ACCESS_ERROR_MESSAGE);
        exit;
    }
    session_abort();

?>