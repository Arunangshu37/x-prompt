<?php
require_once __DIR__ . './../Models/Reminder.php';
require_once __DIR__ . './../Models/ApiResponse.php';
require_once __DIR__ . './../Constants/ResponseConstants.php';
require_once __DIR__ . './../Constants/ReminderConstants.php';
require_once __DIR__ . './../DbQuery/ReminderManagementQueryStrings.php';
require_once __DIR__ . './../DbQuery/UserManagementQueryStrings.php';
require_once __DIR__ . './../PHPMailer/EmailSender.php';
class ReminderController{
    public ?mysqli $connection=null;
    public function __construct(mysqli $conn)
    {
        $this->connection  = $conn;
    }

    public function createReminder(Reminder $reminder) : ApiResponse{
        $apiResponse = new ApiResponse();
        try{
            $statement =  $this->connection->prepare(CREATE_REMINDER_QUERY);
            $statement->bind_param('ississ', $reminder->userId, $reminder->title, $reminder->description, $reminder->isActive, $reminder->createdAt, $reminder->forDateTime);
            $result = $statement->execute();
            if(!$result){
                $apiResponse->status = SERVER_ERROR;
                $apiResponse->message = $this->connection->error;
            }else{
                $apiResponse-> status = REMINDER_CREATED;
                $apiResponse->data = $result;
                $apiResponse->message = "Reminder has been created";
            }

        }catch(Throwable $exception){
            $apiResponse->status = SERVER_ERROR;
            $apiResponse->message = $exception->getMessage();
        }
        return $apiResponse;
    }

    /**
     *  Session must be set before calling this API
     */
    public function sendRemindersByEmail(Int $userId) : ApiResponse {
        $apiResponse = new ApiResponse();
        // get all active reminders for the suer who is logged in 
        try{
            $statement = $this->connection->prepare(GET_ALL_ACTIVE_REMINDERS_QUERY);
            $statement->bind_param('i', $userId );
            $statement->execute();
            $result = $statement->get_result();
            $htmlContent = '<div>';
            while($row = $result->fetch_assoc()){
                $htmlContent .= $this->getHtmlFormattedText($row['id'], $row['title'], $row['description'], $row['createdAt'], $row['forDateTime']);
            }
            $htmlContent .= '</div>';
            $emailSender = new EmailSender();
            $fetchEmailStatement = $this->connection->prepare(GET_USER_INFO_BY_ID);
            $fetchEmailStatement->bind_param('i', $userId);
            $fetchEmailStatement->execute();
            $userInfo = $fetchEmailStatement->get_result();
            $email = $userInfo->fetch_assoc()['username'];
            // $sent = 1;
            $sent = $emailSender->sendEmail($email, 'Reminders' , $htmlContent) ;
            if($sent == 1){
                $apiResponse->status = EMAIL_SENT;
                $apiResponse->message = 'Email has been sent';
            }else{
                $apiResponse->status = EMAIL_NOT_SENT;
                $apiResponse->message = 'There is a problem while sending email. Please do RCA from code level.';               
            }
        }catch(Throwable $exception){
            $apiResponse->status = SERVER_ERROR;
            $apiResponse->message = 'There is a problem while sending email.'. $exception->getMessage();
        }
        return $apiResponse;
    }

    private function getHtmlFormattedText($id, $title, $description, $createdAt, $forDateTime) : string{
        $html = "<p>"
        ."<span>".$id ." ". $title ." </span>"
        ."<span>". $description ." </span>"
        ."<br>"
        ."<i> Reminder was created on". $createdAt." | for date : ".$forDateTime." </i>"
        ."</p> ";
        return $html;
    }
}

?>