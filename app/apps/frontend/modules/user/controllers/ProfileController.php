<?php

class ProfileController extends Controller {

        public $defaultAction = 'index';

        public function actionIndex() {

            $user = Yii::app()->user;
            $model = $user->getModel();

            if( !$model ){
                $this->redirect('/profile/login');
            }

            $this->_profileForm($user);
        }

        /**
         * Редактирование профиля
         */
        private function _profileForm($user){

            // Профиль
            $model = Yii::app()->user->getModel();

            $form = new ProfileForm();
            $form->attributes = $model->attributes;

            // Ajax валидация
            //if( Yii::app()->request->isAjaxRequest ){
            //    echo CActiveForm::validate($form);
            //    Yii::app()->end();
            //}

            //if( $form->city_id > 0 ){
            //    $city = $this->_loadCity($form->city_id);
            //}

            // Post валидация и авторизация
            if(isset($_POST['ProfileForm'])){

                // set attrs
                $form->attributes = $_POST['ProfileForm'];

                if($form->validate()){

                    $model = User::model()->findByPk(Yii::app()->user->id);
                    $model->attributes = $form->attributes;

                    //print_r($form->attributes);
                    //print_r($model->attributes);
                    //die;

                    if( $model->save() ){
                        Yii::app()->user->setFlash('profile_has_saved', true);
                        $this->redirect('/profile');
                    } else {
                        throw new Exception('Save error');
                    }
                }
            }

            //print_r($model->getErrors());

            $this->render('profileForm', array( 'model'=>$form ));

        }

        /**
         * Форма авторизации
         */
        public function actionLogin() {

            $form = new LoginForm();

            // Ajax валидация
            if( Yii::app()->request->isAjaxRequest ){
                echo CActiveForm::validate($form);
                Yii::app()->end();
            }

            // Post валидация и авторизация
            if(isset($_POST['LoginForm'])){

                $form->attributes=$_POST['LoginForm'];

                // validate user input and redirect to the previous page if valid
                if($form->validate() && $form->login()){
                    //$this->redirect(Yii::app()->user->returnUrl);
                    $this->redirect('/profile');
                }
            }

            // display the login form
            $this->render('loginForm', array('model'=>$form));
        }

        /**
         * Выход из лк
         */
        public function actionLogout()
        {
            Yii::app()->user->logout();
            $this->redirect(Yii::app()->homeUrl);
        }

        /**
         * Send mails
         */
        protected function sendMailRecoveryPassword($model, $password) {
            Yii::app()->jmailer->send(array(
                'email'=>$model['email'],
                'subject'=>'Новый пароль',
                'body'=>$this->renderPartial('//mail/body', array(
                            'body'=>$this->renderPartial('recoveryPasswordEndMessage', array('model'=>$model, 'password'=>$password), true),
                        ),
                    true),
            ));
        }

        protected function sendMailActivation($model) {
            Yii::app()->jmailer->send(array(
                'email'=>$model->email,
                'subject'=>'Активация аккаунта',
                'body'=>$this->renderPartial('//mail/body', array(
                            'body'=>$this->renderPartial('activationMessage', array('model'=>$model), true),
                        ),
                    true),
            ));
        }
}
