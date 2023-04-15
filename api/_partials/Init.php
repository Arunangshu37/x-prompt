<?php
$headers = getallheaders();
if(!isset($headers['action'])){
    header("HTTP/1.1 403 Action not specified.");
    exit;
}
$data = json_decode(file_get_contents('php://input'));
if ($data == null){
    header("HTTP/1.1 403 No paylod present.");
    exit;
}

?>