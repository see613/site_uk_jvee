<?php

class BackendJsTreeWidget extends CWidget
{
    /** html element id */
	public $elementId;
    /** nodes array */
	public $treeHtml = '';
    /** current node id */
    public $currentNodeId;
    /** GET parameter of current node id <br /> if $currentNodeId is empty we fill it from GET */
    public $paramNameFromGet = 'cat_id';
    public $nodeIdPrefix = 'node-';
    public $assetsUrl;
    public $showDocs = false;



	public function init()
	{
		$this->assetsUrl = Yii::app()->getAssetManager()->publish(
			Yii::getPathOfAlias('ext.backendJsTree.assets.dist'),
			false,
			-1,
			YII_DEBUG
		);

        Yii::app()->getClientScript()->registerCssFile($this->assetsUrl.'/themes/default/style.css');
        Yii::app()->getClientScript()->registerScriptFile($this->assetsUrl.'/jstree.js');
	}

	public function run()
	{
        $this->fillCurrentNodeId();

        $this->render('backendJsTreeWidget', array(
            'treeHtml' => $this->treeHtml
        ));
	}

    private function fillCurrentNodeId()
    {
        if ( empty($this->currentNodeId) ) {
            $this->currentNodeId = !empty($_GET[$this->paramNameFromGet]) ? $_GET[$this->paramNameFromGet] : 1;
        }
    }

    public function getCurrentNodeFullId() {
        return !empty($this->currentNodeId) ? $this->nodeIdPrefix.$this->currentNodeId : null;
    }

    public static function getBulkGridViewButtons() {
        return array(
            array(
                'id' => 'bulk-move-docs',
                'buttonType' => 'button',
                //'type' => 'primary',
                'size' => 'small',
                'label' => Yii::t('Bootstrap', 'GRID.Move_selected'),
                'htmlOptions' => array(

                )
            )
        );
    }

}
