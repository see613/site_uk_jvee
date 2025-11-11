<?php

class RegistrationController extends Controller {

    //public function filters() {
    //    return array(
    //        'ajaxOnly + full, short, confirm, sendRecoveryPassword',
    //    );
    //}

    /**
     * Страница регистрации
     */
    public function actionIndex() {

        //if (!Yii::app()->user->isGuest) {
        //    $this->redirect('/profile');
        //}

        $form = new RegistrationForm();

        // Ajax валидация
        if( Yii::app()->request->isAjaxRequest ){
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }

        // Post валидация и авторизация
        if(isset($_POST['RegistrationForm'])){

            $attrs = $_POST['RegistrationForm'];

            // set attrs
            $form->attributes = $attrs;

            // validate user input and redirect to the previous page if valid
            if($form->validate()){

                $model = new User('make');

                $model->attributes = $form->attributes;
                $model->role_id = 'user';
                $model->updateSecurity();

                if ($model->save()) {

                    $this->sendRegistrationLink($model);

                    // Авторизуем юзера
                    //$identity = new UserUserIdentity($model['email'], $form['password']);
                    //$identity->model = $model;
                    //$identity->authenticate();
                    //Yii::app()->user->login($identity, 3600*24*30);

                    $this->redirect('/registration/success');
                }
            }

            //print_r($model->getErrors());
        }

        $this->render( 'registrationForm', array('model'=>$form) );
    }

    /**
     * Успешная регистрация
     */
    public function actionSuccess(){
        $this->render( 'registrationSuccess' );
    }

    /**
     * Форма восстановления пароля
     */
    public function actionRecovery(){

        $form = new RecoveryForm('checkEmail');

        if (isset($_POST['RecoveryForm'])) {

            $form->attributes = $_POST['RecoveryForm'];

            if ($form->validate()) {

                $model = User::model()->find('email=?', array($form->email));

                $model->recovery_code = md5(uniqid());
                $model->update(array('recovery_code'));

                $this->sendResetLink($model);
                $this->render('recoverySend');
                return;
            }
        }

        $this->render('recoveryForm', array(
            'model' => $form
        ));
    }

    /**
     * Страница активации аккаунта
     */
    public function actionActivate($key) {

        $model = User::model()->findByAttributes(
            array( 'email_accept_code' => $key )
        );

        // активация устарела
        if( !$model || $model->state != 0 ){
            $this->render('activationIncorrect');
            return;
        }

        if (!$model) {
            throw new CHttpException(404);
        }

        $model->state = 1;
        $model->update( array('state') );

        // Auto login
        $identity = new UserUserIdentity($model->email, $model->password);
		$identity->authenticate(false);
        Yii::app()->user->login($identity);

        $this->redirect('/profile');
        //$this->render('activationSuccess');
    }

    /**
     * Высылаем повторную ссылку на активацию аккаунта (email)
     */
    public function actionSendEmailAccept( $uid ){

        $model = User::model()->findByAttributes( array( 'id' => $uid, 'state' => User::STATE_NEW) ) ;

        if( !$model ){
            $this->redirect('/');
        }

        $model->updateSecurity();
        $model->save();

        $this->sendActivationLink($model);
        Yii::app()->user->setFlash('accept_email_message', true);

        $this->redirect('/profile/login');
    }

    /**
     * Страница сброса пароля
     */
    public function actionResetPassword($key) {

        $model = User::model()->findByAttributes(
            array( 'recovery_code' => $key )
        );

        // активация устарела
        if( !$model ){
            $this->render('activationIncorrect');
            return;
        }

        $password = Yii::app()->helper->random(6);

        $model->password = $password;
        $model->recovery_code = '';

        $model->update(array('password', 'recovery_code'));

        $this->sendNewPassword($model, $password);

        $this->render('recoverySuccess');
    }

    /**
     * Письмо для активация аккаунта
     */
    protected function sendActivationLink($model) {

        $mailBody = $this->renderPartial( 'activationMailLink', array('model'=>$model), true );

        Yii::app()->mailer->send(
            array(
                'email'=>$model->email,
                'subject'=>'Активация аккаунта',
                'body' => $this->renderPartial( '//mail/body', array( 'body'=>$mailBody ), true )
            )
        );
    }

    protected function sendRegistrationLink($model) {

        $mailBody = $this->renderPartial( 'registrationMailLink', array('model'=>$model), true );

        Yii::app()->mailer->send(
            array(
                'email'=>$model->email,
                'subject'=>'Регистрация на сайте ' . $_SERVER['HTTP_HOST'],
                'body' => $this->renderPartial( '//mail/body', array( 'body'=>$mailBody ), true )
            )
        );
    }

    /**
     * Письмо со ссылкой для сброса пароля
     */
    protected function sendResetLink($model) {

        $mailBody = $this->renderPartial('recoveryMailLink', array('model'=>$model), true);

        Yii::app()->mailer->send(array(
            'email'=>$model->email,
            'subject'=>'Восстановление пароля',
            'body'=>$this->renderPartial('//mail/body', array( 'body'=> $mailBody ), true),
        ));
    }

    /**
     * Письмо с новым паролем
     */
    protected function sendNewPassword($model, $password) {

        $mailBody = $this->renderPartial('recoveryMailPassword', array('model'=>$model, 'password'=>$password), true);

        Yii::app()->mailer->send(array(
            'email'=>$model->email,
            'subject'=>'Новый пароль',
            'body'=>$this->renderPartial('//mail/body', array( 'body'=> $mailBody ), true)
        ));
    }

    /**
     * Добавляем автоматические методы для генерации капчи
     */
    public function actions() {
        return array(
            'captcha_registration' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xE2FC7E,
                'foreColor' => 0x405001,
                'testLimit' => 1,
                'transparent' => false,
                'width' => 77,
                'height' => 35,
            ),
            'captcha_recovery' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xE2FC7E,
                'foreColor' => 0x405001,
                'testLimit' => 1,
                'transparent' => false,
                'width' => 77,
                'height' => 35,
            )
        );
    }
}
