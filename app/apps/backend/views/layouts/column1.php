<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">

    <div class="span12">
        <div id="sidebar">
        <?php

        $tabs = array();

        foreach($this->menu as $name => $path){
            $tabs[] = array(
                'label' => $name,
                //'url' => array($path),
            );
        }

        $this->widget(
            'bootstrap.widgets.TbTabs',
            array(
                'type' => 'pills', // 'tabs' or 'pills'
                'tabs' => $this->menu,
                /*array(
                    array(
                        'label' => 'Home',
                        'content' => 'Home Content',
                        'active' => true
                    ),
                    array('label' => 'Profile', 'content' => 'Profile Content'),
                    array('label' => 'Messages', 'content' => 'Messages Content'),
                ),*/
            )
        );
        ?>
        <?php
        /*
            $this->widget('bootstrap.widgets.TbMenu', array(
                'items'=>$this->menu,
                //'htmlOptions'=>array('class'=>'operations'),
            ));
        */
        ?>
        </div><!-- sidebar -->
    </div>
    <div class="span12">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
</div>
<?php $this->endContent(); ?>