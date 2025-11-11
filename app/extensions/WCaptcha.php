<?php

class WCaptcha extends CCaptcha {

    public $model;
    public $attribute;
    public $showRefreshButton = true;
    public $required_string = null;

    public function init(){
        return $this;
    }

    public function run() {
        $this->registerClientScript();
    }

    /**
     * Класс для обновляющего капчу элемента
     */
    public function refreshClass(){
        return 'refresh-captcha-' . $this->attribute;
    }

    public function registerClientScript() {

        $id = $this->imageOptions['id'];
        $url = $this->getController()->createUrl($this->captchaAction, array(CCaptchaAction::REFRESH_GET_VAR=>true) );

        $refreshClass = $this->refreshClass();

        // refresh button
        $js = '$(".' . $refreshClass . '").click( function(){
            jQuery.ajax({
                url: ' . json_encode($url) . ',
                dataType: "json",
                cache: false,
                success: function(data) {
                    jQuery("#' . $id . '").attr("src", data["url"]);
                    jQuery("body").data(" ' . $this->captchaAction . '.hash", [data["hash1"], data["hash2"]]);
                }
            });

            return false;
        });';

        Yii::app()->clientScript->registerScript('Yii.CCaptcha#' . $id, $js);
    }
}
