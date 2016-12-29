<?php

namespace Core;

use Composer\Script\Event;

class Script
{

    public static function testTime(Event $event)
    {   
		date_default_timezone_set('Asia/Shanghai');

		if(exec('date "+%H:%M"  ')===date('H:i',time())){
			echo 'OK:时区检测通过。'.PHP_EOL;
		}else{
			echo 'Error:请检查系统时区设置，PHP和系统时间不一致会导致订阅者在奇怪的时间收到告警。'.PHP_EOL;
		}
    }


}