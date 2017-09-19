<?php

namespace Core;

use Core\DataProvider\DataProvider;
use Core\Notification\Notification;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ApplicationCore
{
    protected $dataProvider;
    protected $notification;
    protected $subscribers = [];
    protected $notifiableList = [];

    function __construct(DataProvider $dataProvider, Notification $notification)
    {
        $this->dataProvider = $dataProvider;
        $this->notification = $notification;
        $this->subscribers = array_map(function ($subscribers) {
            return new Subscriber($subscribers);
        }, config('subscribers'));

    }

    protected function filter()
    {
        if ( ! config('app')->test_mode ) {
            $subscribers = array_filter($this->subscribers, [$this, 'filterByTime']); # 根据告警时间过滤
        }else{
            $subscribers = $this->subscribers;
        }

        $this->notifiableList = array_filter($subscribers, [$this, 'filterByLevel']); # 根据告警等级过滤

        return $this;
    }

    protected function filterByLevel($item)
    {
        $response = $this->dataProvider->request($item->apiParams);

        if ( $response->pollutionLevel >= $item->alertLevel ) {

            $item->response = $response;

            return true;
        }

        return false;
    }

    protected function filterByTime($item)
    {
        $currentTime = date('H:i', time());

        if ( $item->alertTime === $currentTime ) {

            return true;
        }

        return false;
    }

    protected function notify()
    {
        array_walk($this->notifiableList, function (&$notifiable) {

            $log = new Logger('Notification');
            $log->pushHandler(new StreamHandler(__DIR__ . '/../log/notification.log', Logger::INFO));
            $log->addInfo('准备发送通知', ['name' => $notifiable->name, 'email' => $notifiable->email]);

            if ( ! config('app')->test_mode ) {
                if ( $this->notification->send($notifiable) ) {
                    $log->addInfo('成功发送通知', ['name' => $notifiable->name, 'email' => $notifiable->email]);
                }
            }

        });

    }


}
