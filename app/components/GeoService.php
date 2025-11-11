<?php

require( dirname(__FILE__) . '/GeoService/SxGeo21_API/SxGeo.php' );

class GeoService extends CApplicationComponent {

    private $object;

    public function init() {

        $db = dirname(__FILE__) . '/GeoService/SxGeoCity.dat';

        $this->object = $SxGeo = new SxGeo($db, SXGEO_BATCH | SXGEO_MEMORY);

    }

    public function getCountry($ip){
        return $this->object->getCountry($ip);
    }

    public function getCity($ip){
        return $this->object->getCity($ip);
    }

    public function getCityName($ip){
        $data = $this->getCity($ip);
        //print_r($data);
        return isset($data['city']) ? $data['city'] : '';
    }

}

