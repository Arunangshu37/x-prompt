<?php
class User{
    public $username;
    public $password;
    public $name;
    public $id;

    public function __construct($username, $password, $name='', $id=0){
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->id = $id;
    }
}
?>