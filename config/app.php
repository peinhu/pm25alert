<?php

return [

    'active' => true, # 是否启用此服务

    'test_mode' => false, # 测试模式下会忽略时间限制，且不会发送通知仅会记录日志

    'data_provider' => \Core\DataProvider\Pm25inDataProvider::class, # 数据提供者，默认为pm25.in的数据

    'notification' => \Core\Notification\EmailNotification::class, # 通知方式，默认为邮件，需在notification.php中配置

    'standard' => \Core\Standard\ChineseStandard::class, # 检测标准，自带中国(ChineseStandard)和美国(AmericanStandard)两种，默认为中国标准



];
