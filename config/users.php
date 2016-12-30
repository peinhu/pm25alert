<?php

# 订阅此服务的用户，可添加多个

return [
    //请求http://www.pm25.in/api/querys/station_names.json?token=5j1znBVAsnSf5xQyNQyq&city={CITY_NAME}，{CITY_NAME}为城市名，得到城市中所有监测点及其编号{STATION_CODE}
    [
        'name' => '',//'John Doe'

        'email'=>'',//'1234567@qq.com'

        'alert_time'=>'',//'17:22'

        'alert_level'=>1,//1~6或42(即大于6)

        'api_url'=>''//'http://www.pm25.in/api/querys/aqis_by_station.json?token=5j1znBVAsnSf5xQyNQyq&station_code={STATION_CODE}'
    ],




];
