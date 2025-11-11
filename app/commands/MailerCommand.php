<?php

Yii::import('back.modules.mailer.models.*');
Yii::import('back.modules.mailer.components.*');


/**
 * <pre>
 * Class MailerCommand
 * it has optional parameter 'batchSize' in case
 * if our hosting has restrictions of number of emails sent at once
 * <pre>
 */
class MailerCommand extends CConsoleCommand {
    private $batchSize = 66666;


    public function run($args) {
        if ( !empty($args[0]) ) {
            $this->batchSize = $args[0];
        }

        // we add new mails from task into queue
        $this->putIntoQueue();
        // we send mails from queue as many as value of variable $batchSize
        $this->sendFromQueue();
    }

    private function putIntoQueue() {
        $emailCount=0;

        // get actual tasks
        $criteria = new CDbCriteria;
        $criteria->addCondition('(t.sended_at < t.dosend_at  OR  t.sended_at IS NULL)  AND  t.dosend_at <= NOW()');
        $criteria->order = 't.dosend_at asc';

        $tasks = MailerTask::model()->findAll($criteria);

        foreach ($tasks as $task) {
            $emails = $task->emails;

            foreach ($emails as $email) {
                // put to queue
                $queue = new MailerQueue();

                $queue->email = $email;
                $queue->status = MailStatus::_NEW;
                $queue->task_id = $task->id;
                $queue->dosend_at = $task->dosend_at;

                if ( $queue->save() ) {
                    $emailCount++;
                }
            }

            // update task
            $task->sended_at = date('Y-m-d H:i:s');
            $task->save();
        }

        echo !empty($tasks) ? 'tasks\'ve been put into queue: '.count($tasks).'; emails: '.$emailCount.'. '
                            : 'no actual tasks for mailing. ';
    }

    private function sendFromQueue() {
        $sentCount=0;
        $mailer = new MailService();
        $placeholder = new Placeholder();

        // get actual mails from queue
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.status = "'.MailStatus::_NEW.'"  AND  t.dosend_at <= NOW()');
        $criteria->order = 't.dosend_at asc';
        $criteria->limit = $this->batchSize;

        $items = MailerQueue::model()->findAll($criteria);

        foreach ($items as $item) {
            // sending
            $body = $placeholder->parse( $item->email, $item->task->mail->body );

            $mailer->send(array(
                'email'=>$item->email,
                'subject'=>$item->task->mail->subject,
                'body'=>$body,
            ));

            // update the entry in the queue
            $item->status = MailStatus::_SENT;
            $item->sended_at = date('Y-m-d H:i:s');

            if ( $item->save() ) {
                $sentCount++;
            }
        }

        echo $sentCount>0 ? 'mails\'ve been sent from queue: '.$sentCount.'. '
                          : 'no mails have been sent. ';
    }

} 