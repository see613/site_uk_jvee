<?php

Yii::import('back.modules.comment.components.CommentStates');
Yii::import('back.modules.mailer.components.MailService');

class NewCommentCommand extends CConsoleCommand {

    public function run($args) {
        // get new comments
        $criteria = new CDbCriteria;
        $criteria->compare('state', CommentStates::_NEW);
        $criteria->order = 'created_at desc';
        $comments = Comment::model()->findAll($criteria);

        $users = $this->getUsers();

        if ( !empty($comments) ) {
            if ( !empty($users) ) {
                $this->sendEmail($users, $comments);
                echo 'new comments have been sent to moderator email: '.count($comments);
            }
            else {
                echo 'we don\'t have any users with rights to moderate comments';
            }
        }
        else {
            echo 'no new comments for sending to moderator email';
        }
    }

    /** get users who have rights to moderate comments */
    private function getUsers() {
        // get auth manager
        $auth = new CPhpAuthManager();
        $auth->authFile = Yii::getPathOfAlias('application.config.auth').'.php';
        $auth->init();

        // get roles
        $roles = $auth->getRoles();
        $rolesWithAccess = array();
        $users = array();

        // check roles have access to moderation comments
        foreach ($roles as $role) {
            /** @var $role CAuthItem */
            if ( $role->checkAccess('comment.moderate') ) {
                $rolesWithAccess[] = $role->name;
            }
        }

        // get users with roles which have access to moderation comments
        if ( !empty($rolesWithAccess) ) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('role_id', $rolesWithAccess);
            $users = User::model()->findAll($criteria);
        }

        return $users;
    }

    private function sendEmail($users, $comments) {
        $mailer = new MailService();
        $message = 'Новые комментарии: <br><br>';

        foreach ($comments as $comment) {
            $url = $comment->url.'#comment-'.$comment->id;

            $message .= '<a href="'.$url.'">'.$url.'</a> <br>';
        }

        foreach ($users as $user) {
            $mailer->send(array(
                'email'=>$user->email,
                'subject'=>'Новые комментарии',
                'body'=>$message,
            ));
        }
    }


}
