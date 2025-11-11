<?php

/**
 * Подписка (действие index). Одним действием выполняется ajax валидация и сохранение пользователя с состоянием 0, но с флагом подписки
 * Вывод представления осуществляется если нет флага ajax валидации и есть данные формы
 */


class SubscribeController extends Controller {
                    
        public function actionIndex() {
            //если пользователь авторизован, редирект на профиль
            if (!Yii::app()->user->isGuest) {
                $this->redirect('/profile#/popup:subscribe_helper');
            }
            
            $form = new SubscribeModel();
            $this->ajaxValidation($form);
            
            $attributes = Yii::app()->request->getPost('SubscribeModel');
            
            //если форма отвалидирована и есть данные, то сохраняем их отправляем коды статуса с завершением
            if (isset($attributes)) {
                $form->attributes = $attributes;
                
                if ($form->validate()) {
                    $model = new JUser('make');
                    $model->setAttributes($attributes, false);
                    //по соглашению о копировании значения email в username, если последний не требуется
                    $model['username'] = $form['email'];
                    //случайный пароль
                    //notice: генератор паролей
                    $password = $model->setRandPassword();
                    //подписанный на новости пользователь имеет аккаунт подписчика (нужна активация)
                    $model['state'] = false;
                    //флаг подписки
                    $model['is_subscribe'] = true;
                    //права
                    $model->jroles = JRole::model()->findAll('name=?', array('login'));
                    
                    //сохраняем данные
                    if ($model->save()) {
                        //обновляем токен для юзера
                        $model->updateSecurity();
                        //шлем привет на мыло и данные для активации
                        $this->sendMailSubscribe($model, $password);

                        echo CJSON::encode(array(
                            'status'=>1,
                            'data'=>array()
                        ));
                        
                        /**
                         * Сохраняем в кукисах id пользователя
                         * 
                         * notice : перевести идентификацию с id из кукисов на ключ из бд.
                         */
                        Yii::app()->request->cookies['Register.Model.Id'] = new CHttpCookie('Register.Model.Id', $model->id);
                        
                        Yii::app()->end();
                    } else {
                        Yii::log(sprintf('[%s] in model [%s] : don\'t be saved. Validation error [%s]', $this->route, get_class($model), $model->getFirstError()), 'error');
                        throw new CException('unknown service error : data don\'t be saved');
                    }
                }
            }
            
            $this->render('subscribe', array('model'=>$form));
        }
        
        /**
         * Отправка письма "о подписке"
         * 
         */
        protected function sendMailSubscribe($model, $password) {
            Yii::app()->jmailer->send(array(
                'email'=>$model['email'],
                'subject'=>'Подписка',
                'body'=>$this->renderPartial('//mail/body', array(
                            'body'=>$this->renderPartial('subscribeMessage', array('model'=>$model, 'password'=>$password), true),
                        ),
                    true),
            ));
        }        
        
        /**
         * Проверяет запрос на наличие флага ajax и валидирует модель с завершением приложения
         * 
         */
        protected function ajaxValidation($model) {
            if(Yii::app()->request->getPost('ajax', false)) {
                echo WRemoteForm::validate($model);
                Yii::app()->end();
            }
        }
	
	public function actions() {
            return array(
                'captcha_subscribe'=>array(
                    'class'=>'CCaptchaAction',
                    'backColor'=>0x7c7c7c,
                    'foreColor'=>0xFFFFFF,
                    'transparent' => true,
                    'width' => 190,
                    'height' => 74,
                )
            );
	} 	
}