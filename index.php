<?php

date_default_timezone_set('Asia/Shanghai');

require __DIR__.'/vendor/autoload.php';

require __DIR__.'/app/helpers.php';

$app = new \App\Application(new \Core\DefaultData,new \Core\EmailNotification);

$app->run();