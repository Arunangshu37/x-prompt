<?php
require_once __DIR__."./../DbConfig/Config.php";
class MySqlConnect{
    public function getConnection(){
        $conn = new mysqli(HOST_NAME, HOST_USERNAME, HOST_PASSWORD, DATABASE_NAME);
        if($conn->error){
            die("Connection failed : ". $conn->connect_error);
        }
        return $conn;
    }
}

?>