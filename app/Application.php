<?php
namespace App;


class Application extends \Core\Application
{

    function __construct(\Core\DataInterface $dataHandler, \Core\NotificationInterface $notificationHandler)
    {
        parent::__construct($dataHandler,$notificationHandler);

    }

    public function run()
    {
        $this->filter()->notify();

    }




}
