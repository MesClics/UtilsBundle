<?php

namespace MC\UtilsBundle\Notification;

class Notification{
    private $label;
    private $notification_pluriel;
    private $notification_singulier;

    public function __construct($label){
        $this->setLabel($label);
    }

    public function getLabel(){
        return $this->label;
    }

    public function getNotificationPluriel(){
        return $this->notification_pluriel;
    }

    public function getNotificationSingulier(){
        return $this->notification_singulier;
    }

    public function setLabel($label){
        $this->name = $label;
        return $this;
    }

    public function setNotificationPluriel($notification){
        $this->notification_pluriel = $notification;
        return $this;
    }

    public function setNotificationSingulier($notification){
        $this->notification_singulier = $notification;
        return $this;
    }
}