<?php

if (! function_exists('tipsOnPollutionLevel')) {
    function tipsOnPollutionLevel($level)
    {
        switch($level){
            case 1:$message = '优，好，适合出行、适合室外运动、无需戴口罩。';break;
            case 2:$message = '良，中等，适合出行、适合室外运动、出入密集场所请佩戴口罩。';break;
            case 3:$message = '轻度污染，对敏感人群不健康，适合出行、减少室外运动、需佩戴N95以上口罩。';break;
            case 4:$message = '中度污染，不健康，减少出行、减少室外运动、需佩戴N95以上口罩。';break;
            case 5:$message = '重度污染，非常不健康，减少出行、请勿室外运动、需佩戴N95以上口罩。';break;
            case 6:$message = '严重污染，有毒害，请勿外出、请勿室外运动、需佩戴N95以上口罩。';break;
            case 42:$message = '已爆表，上帝啊，赶紧跑吧这不是人待的地方！！！';break;
            default:$message = '数据出错';break;
        }
        return $message;
    }
}

if (! function_exists('displayByPollutionLevel')) {
    function displayByPollutionLevel($level)
    {
        switch($level){
            case 1:$displayLevel = '一级';break;
            case 2:$displayLevel = '二级';break;
            case 3:$displayLevel = '三级';break;
            case 4:$displayLevel = '四级';break;
            case 5:$displayLevel = '五级';break;
            case 6:$displayLevel = '六级';break;
            case 42:$displayLevel = '六级以上';break;
            default:$displayLevel = '数据出错';break;
        }
        return $displayLevel;
    }
}

if (! function_exists('getColorByPollutionLevel')) {
    function getColorByPollutionLevel($level)
    {
        switch($level){
            case 1:$color = '#00E400';break;
            case 2:$color = '#FFFF00';break;
            case 3:$color = '#FF7E00';break;
            case 4:$color = '#FF0000';break;
            case 5:$color = '#99004C';break;
            case 6:$color = '#7E0023';break;
            case 42:$color = '#000000';break;
            default:$color = '#ffffff';break;
        }
        return $color;
    }
}

if (! function_exists('config')) {
    function config($type)
    {
        return \Core\Config::get($type);
    }
}

if (! function_exists('dd')) {
    function dd($value)
    {
        var_dump($value);die;
    }
}
