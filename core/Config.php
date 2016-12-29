<?php

namespace Core;

class Config
{
    protected static $_notification;
    protected static $_users;
    protected static $_contact;
    protected static $type_singleton;

    # 单例模式
    public static function get($type)
    {
        $type_singleton = '_'.$type;

        if (self::$$type_singleton === null){

            self::$$type_singleton = self::read($type);

        }

        return self::$$type_singleton;
    }

    protected static function read($type)
    {
        return json_decode(json_encode(require(__DIR__.'/../config/'.$type.'.php')));
    }

}