<?php
require_once __DIR__.'./../DbQuery\UserManagementQueryStrings.php';
require_once __DIR__.'./../Models/User.php';
require_once __DIR__.'./../Models/ApiResponse.php';
require_once __DIR__.'./../Constants/UserConstants.php';
require_once __DIR__.'./../Constants/ResponseConstants.php';
class UserController{
    private $connection = null;
    public  function __construct(mysqli $conn){
        $this->connection = $conn;
    }
    
    public function authenticate(User $userDetails) : ApiResponse{
        $apiResponse = new ApiResponse();
        try{
            $statement = $this->connection->prepare(GET_USER_BY_USERNAME_QUERY);
            $statement->bind_param("s", $userDetails->username);
            $statement->execute();
            $result = $statement->get_result();
            $user = array();
            while($row = $result->fetch_assoc()){
                $user[] = $row;
            }
            if(count($user)!=0){
                $apiResponse->status = USER_FOUND;
                // Re-calculate hash to verify the password.
                if(password_verify($userDetails->password, $user[0]['passwordHash']))
                {
                    unset($user[0]['passwordHash']);
                    session_start();
                    $_SESSION['user'] = $user[0];
                    $sessionId = session_id();
                    $apiResponse->data = array('user' => $user[0], 'sessionId' => $sessionId);
                    $apiResponse->message = "User found!";
                }
                else
                {
                    $apiResponse->status = USER_CREDENTIAL_INVALID;
                    $apiResponse->data = null;
                    $apiResponse->message = "User found But invalid credential provided!";
                }
            }
            else{
                $apiResponse->status = USER_NOT_FOUND;
                $apiResponse->data = null;
                $apiResponse->message = "User not found!";
            }
        }catch(Throwable $exception){
            $apiResponse->message = $exception->getMessage();
            $apiResponse->status = SERVER_ERROR;
        }
        return $apiResponse;
    }

    public function createUser(User $userDetails) :ApiResponse{
        $apiResponse  = new ApiResponse();
        try{
            $statement = $this->connection->prepare(CREATE_USER_QUERY);
            $passwordHash = password_hash($userDetails->password, PASSWORD_DEFAULT);
            $statement->bind_param("sss", $userDetails->username, $passwordHash, $userDetails->name);
            $result = $statement->execute();
            if(!$result){
                $apiResponse->status = SERVER_ERROR;
                $apiResponse->message = $this->connection->error;
            }else{
                $apiResponse->data = $result;
                $apiResponse->status = USER_CREATED;
                $apiResponse->message = "User has been create successfully"; 
            }

        }catch(Throwable $exception){
            $apiResponse->status = CONFLICT_ERROR;
            $apiResponse->message = "User creation failed. ".$exception->getMessage(); 
        }
        return $apiResponse;
    }
    
    public function logout() : ApiResponse{
        $apiResponse = new ApiResponse();
        session_start();
        if(isset($_SESSION['user'])){
            session_destroy();
        }
        $apiResponse->status = USER_LOGGED_OUT;
        $apiResponse->message  = 'User has been logged out successfully';
        return $apiResponse;
    }

    public function assignRole(Int $userId, Int $role) : ApiResponse{
        $apiResponse = new ApiResponse();
        try{
            $statement = $this->connection->prepare(ASSIGN_ROLE_QUERY);
            $statement->bind_param('ii',  $role,$userId,);
            $result = $statement->execute();
            if(!$result){
                $apiResponse->status = SERVER_ERROR;
                $apiResponse->message = $this->connection->error;
            }else{
                $apiResponse-> status = ROLE_ASSIGNED;
                $apiResponse->data = $result;
                $apiResponse->message = "Role assigned successfully.";
            }
            
        }catch(Throwable $exception){
            $apiResponse->status = CONFLICT_ERROR;
            $apiResponse->message = "RoleAssignment failed. ".$exception->getMessage(); 
        }
        return $apiResponse;
    }
}

?>