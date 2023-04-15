<?php
    require_once __DIR__ . './../Constants/ResponseConstants.php';
    session_start();
    if(!isset($_SESSION['user'])){
        session_abort();
        header('HTTP/1.1 ' . FORBIDDEN_ERROR . ' '. FORBIDDEN_ERROR_MESSAGE);
        exit;
    }
    session_abort();
?>