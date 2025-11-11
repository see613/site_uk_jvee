<?php

class ContactController extends Controller {

    public function actionSubmitwidget() {
        $this->actionIndex('widget');
    }

    public function actionIndex($scenario = 'send') {
        $form = new Feedback($scenario);
        $error = '[]';
        $this->validateAjax($scenario.'-check');

        if (isset($_POST['Feedback'])) {
            $form->attributes = $_POST['Feedback'];

            if ($form->save()) {
                $this->sendEmail($form);

                echo CJSON::encode(array(
                    'status'=>'success'
                ));
            }
            else {
                $error = CActiveForm::validate($form);
            }

            if($error != '[]') {
                echo $error;
            }

            Yii::app()->end();
        }

        throw new CHttpException(404, 'The specified page cannot be found');
    }

    private function validateAjax($scenario) {
        if (isset($_POST['ajax']) && in_array($_POST['ajax'], array('feedback-form', 'contact-form', 'showroom-form', 'brochure-form'))) {
            $form = new Feedback($scenario);

            echo CActiveForm::validate($form);
            Yii::app()->end();
        }
    }

    private function sendEmail($model) {
        $mailer = new MailService();
        $message =
            'New feedback from '.CHtml::link($_SERVER['HTTP_HOST'], Yii::app()->createAbsoluteUrl('/')).':<br /><br />'.

            (!empty($model->name) ? 'Name: '.$model->name.'<br />' : '').
            (!empty($model->phone) ? 'Phone: '.$model->phone.'<br />' : '').
            (!empty($model->email) ? 'Email: '.$model->email.'<br />' : '').
            (!empty($model->message) ? 'Message: <br />'.$model->message : '');

        $mailer->send(array(
            'email'=>FEEDBACK_EMAIL,
            'subject'=>'New feedback from '.$_SERVER['HTTP_HOST'],
            'body'=>nl2br($message),
        ));
    }
}