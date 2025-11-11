<?php

class DataController extends Controller {

/*
        public function filters() {
            return array(
                'ajaxOnly + settlements',
            );
        }
*/

        public function actionSettlements() {

            $data = array();
            $search = Yii::app()->request->getQuery('term', false);

            if ($search) {

                $matches = Yii::app()->db->createCommand()
                    ->select("countries.name_ru as country, regions.name_ru as region, settlements.name_ru as settlement, settlements.id as id")
                    ->from('tbl_geo_city settlements')
                    ->join('tbl_geo_region regions', 'settlements.region_id = regions.id')
                    ->join('tbl_geo_country countries', 'settlements.country_id = countries.id')
                    ->where('settlements.name_ru LIKE :search', array(':search'=>'%'.$search.'%'))
                    ->limit(15)
                    ->queryAll();

                foreach($matches as $item){
                    $data[] = array(
                        'id' => $item['id'],
                        'value' => $item['settlement'] . ' (' . $item['country'] . ', ' . $item['region'] . ')',
                    );
                }
            }

            echo json_encode($data);
        }
}