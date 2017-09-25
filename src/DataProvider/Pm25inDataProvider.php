<?php

namespace Core\DataProvider;

use Core\Log;

class Pm25inDataProvider implements DataProvider
{
    public $aqi;//空气质量
    public $positionName;//区域监测点名称
    public $primaryPollutant;//首要污染物
    public $pm25;//pm2.5浓度
    public $timePoint;//监测时间
    public $pollutionLevel;//污染等级

    public function request($params)
    {
        $url = 'http://www.pm25.in/api/querys/aqis_by_station.json?token=5j1znBVAsnSf5xQyNQyq&station_code=' . $params->station_code;

        $context = stream_context_create(['http' => ['method' => "GET", 'timeout' => 10]]);

        $contents = @file_get_contents($url, false, $context);

        if ( ! $contents ) {
            Log::failToRequest($url);

            return false;
        }

        $this->format($contents);

        return $this;
    }

    /**
     * 格式化数据，使用由pm25.in提供的源数据
     * @param $sourceData
     */
    public function format($sourceData)
    {
        $sourceDataObj = json_decode($sourceData)[0];

        $this->aqi = $sourceDataObj->aqi;

        $this->positionName = $sourceDataObj->position_name;

        $this->primaryPollutant = $sourceDataObj->primary_pollutant;

        $this->pm25 = $sourceDataObj->pm2_5;

        $this->timePoint = $sourceDataObj->time_point;

        $this->pollutionLevel = call_user_func([config('app')->standard, 'getLevelByIndex'], $sourceDataObj->pm2_5);

    }

}