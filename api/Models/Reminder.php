<?php
class Reminder{
    public $id;
    public $title;
    public $description;
    public $userId;
    public $isActive;
    public $createdAt;
    public $forDateTime;

    public function __construct( $title, $description, $userId, $isActive, $createdAt, $forDateTime, $id= 0)  
    {
        $this->id = $id ;
        $this->title = $title ;
        $this->description = $description ;
        $this->userId = $userId ;
        $this->isActive = $isActive ;
        $this->createdAt = $createdAt ;
        $this->forDateTime = $forDateTime ;
    }
}

?>