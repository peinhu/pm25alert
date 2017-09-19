<?php
namespace Core\Standard;

class AmericanStandard implements Standard{

    public static function name()
    {
        return '美国标准';
    }

    public static function getLevelByIndex($index)
    {
        # 美国标准
        if($index < 12){
            $level = 1;
        }else if($index >= 12 && $index < 35){
            $level = 2;
        }else if($index >= 35 && $index < 55){
            $level = 3;
        }else if($index >= 55 && $index < 150){
            $level = 4;
        }else if($index >= 150 && $index < 250){
            $level = 5;
        }else if($index >= 250 && $index < 500){
            $level = 6;
        }else if($index >= 500){
            # The answer to life , the universe and everything is 42. --《The Hitchhiker's Guide to the Galaxy》
            $level = 42;
        }else{
            $level = -1;
        }
        return $level;
    }

}