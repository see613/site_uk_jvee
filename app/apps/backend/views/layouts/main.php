<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<?php
    $role = Yii::app()->user->role;
    $items = array(
        'admin'=> array(
            array('label' => 'Feedback', 'url' => array('/feedback/feedback/index')),
        ),
    );

    $items = array_key_exists($role, $items) ? $items[$role] : array();


$this->widget('bootstrap.widgets.TbNavbar',array(
    //'type'=>'inverse', // null or 'inverse'
	'brand'=> 'JV Electrical Essex Ltd',
	'collapse' => true,
	'fluid' => true,

    'items'=>array(
			array(
					'class' => 'booster.widgets.TbMenu',
					'type' => 'navbar',
					'items' => $items
			),

			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'htmlOptions'=>array('class'=>'pull-right'),

				'items' => array(
					array(
						'label'=>Yii::t('Phrases', 'LOGOUT'),
						'url'=>array('/user/login/logout'),
						'icon' => 'off',
					),
				),


			),
    ),
)); ?>

<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

    <!--
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
	</div>
	-->
	<!-- footer -->

</div><!-- page -->

</body>
</html>
