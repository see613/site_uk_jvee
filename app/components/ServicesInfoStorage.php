<?php

class ServicesInfoStorage extends CApplicationComponent {

    public static function get($portionsCount=1, $portionIndex=1){
        $data = Yii::app()->params['services'];
        $length = count($data);
        $portionLength = ceil($length/$portionsCount);

        return array_slice($data, ($portionIndex-1)*$portionLength, $portionLength);
    }

}

