<?php


class UrlHelper {

    /**
     * max nested level is 2
     *
     * @param $params
     * @return array|string
     */
    public static function pageUrl($params, $onlyParamString = false) {
        $allParams = $_GET;

        foreach ($params as $key=>$value) {
            if ( is_array($value) ) {
                if ( empty($allParams[$key]) ) {
                    $allParams[$key] = array();
                }

                foreach ($value as $subKey=>$subValue) {
                    $allParams[$key][$subKey] = $subValue;
                }
            }
            else {
                $allParams[$key] = $value;
            }
        }

        $paramString = http_build_query($allParams);
        $url = explode('?', Yii::app()->request->requestUri);
        $url = $onlyParamString ? $paramString : $url[0].'?'.$paramString;

        return $url;
    }

    static function is($module = null, $controller = null, $action = null, $get = null, $post = null) {
        $moduleId = Yii::app()->controller->module->id;
        $contrId = Yii::app()->controller->id;
        $actionId = Yii::app()->controller->action->id;

        if ($moduleId != $module) {
            return false;
        }
        if ($contrId != $controller) {
            return false;
        }
        if ($actionId != $action) {
            return false;
        }
        if (!empty($get) && !static::hasParams($_GET, $get)) {
            return false;
        }
        if (!empty($post) && !static::hasParams($_POST, $post)) {
            return false;
        }
        return true;
    }

    static protected function hasParams($actualData, $data) {
        if ( empty( $actualData ) ) {
            return false;
        }

        foreach ($data as $key=>$value) {
            if ( is_numeric($key) ) {
                if ( !isset($actualData[$value]) ) {
                    return false;
                }
            }
            else {
                if ( !isset($actualData[$key]) || $actualData[$key] != $value ) {
                    return false;
                }
            }
        }
        return true;
    }

}