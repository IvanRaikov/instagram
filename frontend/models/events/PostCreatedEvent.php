<?php
namespace frontend\models\events;
use yii\base\Event;

class PostCreatedEvent extends Event{
    public $user;
    public $post;
    public function getUser(){
        return $this->user;
    }
    public function getPost(){
        return $this->post;
    }
}
