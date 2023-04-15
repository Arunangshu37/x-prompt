<?php
require_once __DIR__ . './userActionNames.php';
require_once __DIR__ . './../../Constants/UserConstants.php';
require_once __DIR__ . './../../Constants/ResponseConstants.php';
require_once __DIR__ . './../../Controllers/UserController.php';
require_once __DIR__ . './../../Models/User.php';
require_once __DIR__ .'./../../DbConfig/MySqlConnect.php';

if($_SERVER['REQUEST_METHOD']=='POST')
{
    include __DIR__ . './../../_partials/Init.php';
   
    
    $conn = new MySqlConnect();
    $userController = new UserController($conn->getConnection());
    // echo json_encode($data);
    switch($headers['action']){
        case USER_AUTH :{
            $userInfo = new User($data->username, $data->password);
            $result = $userController->authenticate($userInfo);
            if($result->status == USER_NOT_FOUND){
                header("HTTP/1.1 ". NOT_FOUND_ERROR . " " . $result->message);
                exit;
            }
            if($result->status == USER_CREDENTIAL_INVALID){
                header("HTTP/1.1 ". UNAUTHORIZED_ACCESS_ERROR . " " . $result->message);
                exit;
            }
            if($result->status == SERVER_ERROR){
                header("HTTP/1.1 " . SERVER_ERROR . " " . $result->message);
                exit;
            }
            echo json_encode($result);
            break;
        }
        case USER_CREATE :{
            $userInfo = new User($data->username, $data->password, $data->name);
            $result = $userController->createUser($userInfo);
            if($result->status == USER_CREATED){
                echo json_encode($result);
            }else{
                header('HTTP/1.1 '. CONFLICT_ERROR . '');
            }
            break;
        } 
        case LOG_OUT : {
            echo json_encode($userController->logout());
            break;
        }
        case ASSIGN_ROLE : {
            include __DIR__ . './../../_partials/ValidateSession.php';
            include __DIR__ . './../../_partials/CheckAdminAuthorization.php';
            $result = $userController->assignRole($data->userId, $data->role);
            if($result->status == ROLE_ASSIGNED){
                echo json_encode($result);
            }else{
                header('HTTP/1.1 '. $result->status.' ' .$result->message);
            }
            break;
        }
        default : {
            header("HTTP/1.1 404 Action specified does not exists.");
            exit;
        }
    }
}
else if($_SERVER['REQUEST_METHOD']=='GET'){
    echo "reachable";
}

?>