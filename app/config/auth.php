<?php

return array(

	'guest' => array(
		'type' => CAuthItem::TYPE_ROLE,
		'description' => 'Guest',
		'bizRule' => null,
		'data' => null
	),

	'user' => array(
		'type' => CAuthItem::TYPE_ROLE,
		'description' => 'User',
		'children' => array(
			'guest',
		),
		'bizRule' => null,
		'data' => null
    ),

	'blog.moderate' => array(
			'type' => CAuthItem::TYPE_ROLE,
			'description' => 'Blog moderate',
			'bizRule' => null,
			'data' => null
	),
	'blog.moderator' => array(
			'type' => CAuthItem::TYPE_ROLE,
			'description' => 'Blog moderator',
			'children' => array(
					'blog.moderate',
			),
			'bizRule' => null,
			'data' => null
	),

    'comment.moderate' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Comments moderator',
        'bizRule' => null,
        'data' => null
    ),
    'comment.moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Comments moderator',
        'children' => array(
            'comment.moderate',
        ),
        'bizRule' => null,
        'data' => null
    ),

    'contentblock.moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Text blocks moderator',
        'bizRule' => null,
        'data' => null
    ),

	'client' => array(
		'type' => CAuthItem::TYPE_ROLE,
		'description' => 'Client',
		'children' => array(
				'user'
				//'blog.moderate',
		),
		'bizRule' => null,
		'data' => null
	),
    'employee' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Employee',
        'children' => array(
            'user'
        ),
        'bizRule' => null,
        'data' => null
    ),
    'signature.moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Signatures moderator',
        'children' => array(
            'user',
        ),
        'bizRule' => null,
        'data' => null
    ),

	'admin' => array(
		'type' => CAuthItem::TYPE_ROLE,
		'description' => 'Administrator',
		'children' => array(
			'user', 'blog.moderate', 'comment.moderator', 'contentblock.moderator'
		),
		'bizRule' => null,
		'data' => null
	),
);
