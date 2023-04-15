<?php
require_once __DIR__ . './reminderActionNames.php';
require_once __DIR__ . './../../Constants/ReminderConstants.php';
require_once __DIR__ . './../../Controllers/ReminderController.php';
require_once __DIR__ . './../../Models/Reminder.php';
require_once __DIR__ . './../../DbConfig/MySqlConnect.php';

$conn = new MySqlConnect();
$reminderController = new ReminderController($conn->getConnection());
if($_SERVER['REQUEST_METHOD']=='POST'){
    include __DIR__ . './../../_partials/Init.php';
    include __DIR__ . './../../_partials/ValidateSession.php';
    session_start();
    $user =  $_SESSION['user'];
    
    switch($headers['action']){
        case CREATE_REMINDER : {
            $reminder = new Reminder($data->title, $data->description, $user['id'] , $data->isActive, $data->createdAt,$data->forDateTime);
            $result = $reminderController->createReminder($reminder);
            if($result->status == REMINDER_CREATED){
                session_abort();
                echo json_encode($result);
            }
            if($result->status == REMINDER_CREATION_FAILED){
                // do someting
            }
            break;
        }
        case UPDATE_REMINDER :{
            break;
        }
        case GET_ALL_REMINDERS :{
            break;
        }
        case DELETE_REMINDER :{
            break;
        }
        default : {
            header("HTTP/1.1 404 Action specified does not exists.");
            exit;
        }
    }
}else if ($_SERVER['REQUEST_METHOD']=='GET'){
    if (!isset($_GET['userId'])){
        header("HTTP/1.1 401 Need to specify user id in order to receive email for reminders");
        exit;
    }
    $userId = $_GET['userId'];
    $req = $_GET['requestName'];
    switch($req){
        case SEND_REMINDERS_BY_EMAIL:{
           $result = $reminderController->sendRemindersByEmail($userId);
        //   $result = array("data"=>$req, "userId"=>$userId);
            echo json_encode($result);
            break;
        }
        default :{
            header("HTTP/1.1 404 Action specified does not exists.");
            exit;
        }     
    }
}

?>