<?php


/**
 * js reload: grecaptcha.reset();
 */
class ReCaptchaWidget extends CWidget
{
    const THEME_LIGHT = 'light';
    const THEME_DARK = 'dark';

    public $theme = self::THEME_LIGHT;
    public $publicKey;
    public $language = 'en';


    public function run()
    {
        $this->renderImage();
        $this->registerClientScript();
    }

    protected function renderImage()
    {
        echo '<div 
        class="g-recaptcha" 
        data-size="invisible" 
        data-sitekey="'.$this->publicKey.'" 
        data-theme="'.$this->theme.'"></div>';
    }

    public function registerClientScript()
    {
        $cs = Yii::app()->clientScript;

        $cs->registerScriptFile('/js/captcha.js?6');
        $cs->registerScriptFile('https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit&hl='.$this->language, CClientScript::POS_HEAD);
    }


}
