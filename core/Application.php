<?php
namespace Core;


class Application
{

    protected $response;
    protected $notifyUserList = [];
    protected $dataHandler;
    protected $notificationHandler;


    /**
     * Application constructor.
     * @param DataInterface $dataHandler
     * @param NotificationInterface $notificationHandler
     */
    function __construct(DataInterface $dataHandler, NotificationInterface $notificationHandler)
    {
        $this->dataHandler = $dataHandler;
        $this->notificationHandler = $notificationHandler;

    }

    protected function filter()
    {

        foreach(config('users') as $user){

            if($this->filterByTime($user->alert_time)){ //时间条件达标

                $this->response = $this->requestData($user->api_url);

                if($this->filterByLevel($user->alert_level)){ //等级条件达标

                    $user->response = $this->response;

                    $this->notifyUserList[] = $user; //放入通知列表

                }

            }

        }

        return $this;
    }

    protected function requestData($api_url)
    {
        $contents = file_get_contents($api_url);

        return $this->dataHandler->format($contents);
    }


    protected function filterByLevel($alertLevel)
    {

        $dataLevel = getLevelByIndex($this->response->pm25);

        if($dataLevel >= $alertLevel){
            return $dataLevel;
        }

        return false;
    }

    protected function filterByTime($userAlertTime)
    {
        $currentTime = date('H:i',time());

        if($userAlertTime === $currentTime){
            return true;
        }

        return false;
    }

    protected function notify()
    {
        foreach($this->notifyUserList as $notifyUser){
            $this->notificationHandler->sendMessage($notifyUser);
        }

    }



}
