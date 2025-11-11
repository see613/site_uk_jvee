<?php

require_once('ReCaptcha/ReCaptcha.php');
require_once('ReCaptcha/RequestMethod.php');
require_once('ReCaptcha/RequestParameters.php');
require_once('ReCaptcha/Response.php');
require_once('ReCaptcha/RequestMethod/Curl.php');
require_once('ReCaptcha/RequestMethod/Post.php');
require_once('ReCaptcha/RequestMethod/Socket.php');
require_once('ReCaptcha/RequestMethod/SocketPost.php');


class ReCaptchaValidator extends CValidator
{
    protected $postParameterName = 'g-recaptcha-response';

    public $privateKey = null;
    public $languageCategory = 'yii';


    protected function validateAttribute($object, $attribute)
    {
        if ( empty($_POST) || empty($_POST[$this->postParameterName]) ) {
            $message = $this->message !== null ? $this->message : Yii::t($this->languageCategory, 'The verification is incorrect');

            $this->addError($object, $attribute, $message);
            return;
        }

        $value = $_POST[$this->postParameterName];

        $recaptcha = new \ReCaptcha\ReCaptcha($this->privateKey);

        $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);

        if ( !$response->isSuccess() ) {
            /*$message = '<ul>';
            foreach ($response->getErrorCodes() as $code) {
                $message .= '<li>'. $code .'</li>';
            }
            $message .= '</ul>';*/

            $message = $this->message !== null ? $this->message : Yii::t($this->languageCategory, 'The verification is incorrect');

            $this->addError($object, $attribute, $message);
            return;
        }
    }

}

