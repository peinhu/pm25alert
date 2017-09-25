<?php

namespace Core;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{

    protected static $_logger;

    # 单例模式
    private static function getInfoInstance()
    {
        if ( self::$_logger === null ) {
            self::$_logger = new Logger('Notification');
            self::$_logger->pushHandler(new StreamHandler(__DIR__ . '/../log/notification/' . date('Ym') . '.log'));
        }

        return self::$_logger;
    }

    public static function readyToNotify($name, $email)
    {
        $logger = self::getInfoInstance();
        $logger->addInfo('通知发送准备。', ['name' => $name, 'email' => $email]);
    }

    public static function successToNotify($name, $email)
    {
        $logger = self::getInfoInstance();
        $logger->addInfo('通知发送成功。', ['name' => $name, 'email' => $email]);
    }

    public static function failToNotify($name, $email, $error)
    {
        $logger = self::getInfoInstance();
        $logger->addError('通知发送失败！', ['name' => $name, 'email' => $email, 'error' => $error]);
    }

    public static function failToRequest($url)
    {
        $logger = self::getInfoInstance();
        $logger->addError('接口请求失败！', ['url' => $url]);
    }

}