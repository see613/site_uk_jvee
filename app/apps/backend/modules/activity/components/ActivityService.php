<?php

class ActivityService{

    /**
     * Список активностей
     */
    private $_list = array();

    /**
     * Параметры активности
     */
    private $_keys = array('name', 'key', 'user', 'score', 'max', 'max_global', 'comment');

    /**
     *
     */
    public function init(){
        $this->_list = $this->_activityList();
    }

    /**
     * Извлекаем список активностей
     */

	private function _activityList(){

	    return array(

            // новый участник в команде
	        'new_member' => array('score' => 50, 'key' => array('user_id' => true), 'max' => 1 ),
	        'new_team_user' => array('score' => 20, 'key' => array('captain_id' => true), 'max_global' => 1, 'max' => 1 ),

            // публикация приглашения на стене в соцсети = 10 баллов
            // stype = vk, fb, ok
            'social_post' => array('score' => 10, 'max_global' => 3, 'max' => 1, 'key' => array('stype' => true) ),

            // авторизация через соц сеть
            'auth_social' => array('score' => 10, 'max_global' => 10, 'max' => 1, 'key' => array('stype' => true) ),

            // чекин пользователя
            // stype = vk, fb, 4sq
            'user_checkin' => array('score' => 25, 'max_global' => 3, 'max' => 1, 'key' => array('stype' => true) ),

            // вход в социальную группу Мегафон
            // stype = vk, fb, ok
            'social_group_in' => array('score' => 10, 'max_global' => 3, 'max' => 1, 'key' => array('stype' => true)),

            // баллы от участников команды
            'from_member' => array('score' => true, 'key' => array('from_user_id' => true)),
	    );
	}

	private function _prizeCheck($user){

	    if( isset($list['ac']) )

	    return array(
	        array(
	            'prize_name' => '',
	            'name' => 'auth_social',
	            'count' => 5,
	        ),


	    );

	}

    /**
     * Извлелекаем список активностей пользователя
     */
    public function loadList($user_id, $activity_name = null, $offset = 0, $limit = 100){

        $cmd = Yii::app()->db->createCommand(
            "select log.name, log.score, log.user_id, log.key, created_at " .
            "from {{activity_log}} log " .
            "where log.user_id = " . intval($user_id) . ' ' .
            ( $activity_name ? 'and log.name = :name ' : '') .
            'order by created_at desc ' .
            'limit :offset, :limit'
        );

        if($activity_name){
            $cmd->bindParam(':name', $activity_name);
        }

        $cmd->bindParam(':offset', $offset);
        $cmd->bindParam(':limit', $limit);

        $list = $cmd->queryAll();

        return $list;
    }

    /**

        Логируем дейтвие пользователя

        user - идентификатор юзера
        name - имя события
        score - кол-во баллов за действие, получиться поставить, только если в конфигурации установлен 'score' => true
        key - уникальный ключ, необязательное поле, нужен для указания дополнительной уникальности действию, например ответ на вопрос с id=4 ( 'answer_3' )
        max - сколько раз юзер может получить баллы за данное событие - учитывается name события и key
        max_global - сколько раз юзер может получить баллы за данное событие - учитывается только name
        comment - дополнительные данные по событию, пожно написать текстом за что именно юзер получил свои баллы, скажем "Ответ на вопрос #3 - вариант #1"

        Yii::app()->activity->add( array(
            'user' => $userId,
            'score' => 75,
            'name' => 'video_answer_0_20',
            'key' => 'video_answer_id_100',
            'max' => 5,
            'max_global' => 10,
            'comment' => 'Произвольные текстовый комментарий'
        );

	*/
	public function add($data){

        $activity = $this->_check($data);

        // кол-во баллов
        $score = $activity['score'];

        if( array_key_exists('max', $activity) || array_key_exists('max_global', $activity) ){

            $cmd = Yii::app()->db->createCommand()
                ->select('count(*)')
                ->from('{{activity_log}} log')
                ->where('log.name = :name and log.user_id = :user_id', array(
                    'name' => $activity['name'],
                    'user_id' => $activity['user']
                ));

            // Проверяем кол-во указанных действий по name и key
            if( array_key_exists('max', $activity) && $activity['max'] > 0 ){

                if( !empty($activity['key']) ){
                    $cmd->andWhere('log.key = :key', array( 'key' => $activity['key']) );
                }

                $count = $cmd->queryScalar();

                // Указанных действий больше установленного лимита
                if( $count >= $activity['max'] ){
                    $score = 0;
                }
            }

            // Проверяем кол-во указанных действий только по name
            if( array_key_exists('max_global', $activity) && $activity['max_global'] > 0 ){
                $count = $cmd->queryScalar();
                if( $count >= $activity['max_global'] ){
                    $score = 0;
                }
            }

        }

        // Добавляем активность
        $item = new ActivityLog();

        $item->user_id = $activity['user'];
        $item->name = $activity['name'];
        $item->score = $score;
        $item->key = $activity['key'];
        $item->comment = isset($activity['comment']) ? $activity['comment'] : null;
        $item->save();

        // Обновляем поле score юзера
        if( $item->id > 0 ){
            $user = User::model()->findByPk($activity['user']);
            $user->addScore( $activity['score'] );
	    }
	}

    /**
     * Проверяем корректность начисления активности
     */
    private function _check($data){

        foreach( $data as $key => $name ){
            if( !in_array($key, $this->_keys) ){
                throw new Exception('Некорректный параметр в массиве активности: ' . $key );
            }
        }

        if( !isset($data['user']) ){
            throw new Exception('Начисление баллов: не указан идентификатор пользователя (user)');
        }

        if( !isset($data['name']) ){
            throw new Exception('Начисление баллов: не указано имя действия (name)');
        }

        if( !isset($this->_list[$data['name']]) ){
            throw new Exception('Начисление баллов: действия с указанным именем ("'.$data['name'].'") не существует');
        }

        // Получаем конфиг активности
        $activity = $this->_list[$data['name']];

        if( !isset($data['score']) && $activity['score'] === true ){
            throw new Exception('Начисление баллов: для действия с указанным именем ("'.$data['name'].'") необходимо указать кол-во баллов');
        }

        if( isset($data['score']) && $data['score'] > 0 && $activity['score'] > 0 ){
            throw new Exception('Начисление баллов: для действия с указанным именем ("'.$data['name'].'") нельзя задавать произвольное количество баллов');
        }

        // проверка суррогатного ключа - массива, с переводом в строку
        if( isset($activity['key']) && is_array($activity['key']) ){

            if( !is_array($data['key']) ){
                throw new Exception('Для активности "'.$data['name'].'" ключ должен быть указан в виде массива с элементами "' . join(', ', array_keys($activity['key']))  . '"');
            }

            foreach($activity['key'] as $k => $v){
                if( !isset($data['key'][$k]) ){
                    throw new Exception('Для активности "'.$data['name'].'" должен быть указан ключ "' . $k . '"');
                }
                // переводим все значения в строковый формат для единообразия
                $data['key'][$k] = (string) $data['key'][$k];
            }
            $data['key'] = $activity['key'] = json_encode( $data['key'] );
        }

        return $data + $activity;
    }

}