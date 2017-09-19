<?php

namespace Core\Notification;

Interface Notification
{
    function send($notifiable);

}