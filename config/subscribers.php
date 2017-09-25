<?php

# 订阅此服务的用户，可添加多个

return [
    [
        'name' => '', # 用户的名称，如'John Doe'

        'email' => '', # 用户接收告警的邮箱，如'1234567@qq.com'

        'alert_time' => '', # 检测时间，如'08:00'

        'alert_level' => 1, # 告警等级，1~6或42(即大于6的情况)，大于等于此数值才会触发告警

        'api_params' => [ # 数据源api的请求参数
            # 如使用pm25.in（默认）的api，请求http://www.pm25.in/api/querys/station_names.json?token=5j1znBVAsnSf5xQyNQyq&city={CITY_NAME}，{CITY_NAME}为城市名，可得到城市中所有监测点及其编号{STATION_CODE}，将其作为station_code的值
            'station_code' => '',
        ],


    ],


];
