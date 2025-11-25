<?php

class DefaultController extends Controller {

    public function init(){
        parent::init();
    }

    public function actionIndex() {
        $this->activePage = 'index';

        $cs = Yii::app()->getClientScript();

        $cs->registerScriptFile('/js/gsap/minified/gsap.min.js');
        $cs->registerScriptFile('/js/gsap/minified/ScrollTrigger.min.js');
        $cs->registerScriptFile('/js/pages/home.js?1');

        $this->render('index', []);
    }

    public function actionAbout() {
        $this->activePage = 'about';

        $this->render('about', []);
    }

    public function actionDomesticServices() {
        $this->activePage = 'domestic-services';

        $this->render('domestic-services', []);
    }

    public function actionCommercialServices() {
        $this->activePage = 'commercial-services';

        $this->render('commercial-services', []);
    }

    public function actionError()
    {
        $this->activePage = 'error';

        $error = Yii::app()->errorHandler->error;

        if($error['code'] == 404)
        {
            $this->render( 'error404' );
        }
        else {
            $this->render( 'error', array( 'error' => $error ) );
        }
    }

}

