<?php
namespace Core;

class Subscriber{
    public $name;
    public $email;
    public $alertTime;
    public $alertLevel;
    public $apiParams;

    function __construct($subscriber)
    {
        $this->name = $subscriber->name;
        $this->email = $subscriber->email;
        $this->alertTime = $subscriber->alert_time;
        $this->alertLevel = $subscriber->alert_level;
        $this->apiParams = $subscriber->api_params;
    }

}