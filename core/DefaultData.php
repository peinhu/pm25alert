<?php

namespace Core;

class DefaultData implements DataInterface
{

    public $aqi;//空气质量
    public $positionName;//区域监测点名称
    public $primaryPollutant;//首要污染物
    public $pm25;//pm2.5浓度
    public $timePoint;//监测时间
    public $pollutionLevel;//污染等级

    /**
     * 格式化数据，默认使用由pm25.in提供的源数据
     * @param $sourceData
     * @return $this
     */
    public function format($sourceData)
    {
        $sourceDataObj = json_decode($sourceData)[0];

        $this->aqi = $sourceDataObj->aqi;

        $this->positionName = $sourceDataObj->position_name;

        $this->primaryPollutant = $sourceDataObj->primary_pollutant;

        $this->pm25 = $sourceDataObj->pm2_5;

        $this->timePoint = $sourceDataObj->time_point;

        $this->pollutionLevel = getLevelByIndex($sourceDataObj->pm2_5);

        return $this;


    }



}