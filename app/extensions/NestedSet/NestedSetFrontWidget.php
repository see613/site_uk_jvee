<?php

class NestedSetFrontWidget extends CWidget
{
    public $currentId = null;
    /** nodes array */
    public $data = array();
    /** render or just return result */
    public $return = false;
    /** node id in the DOM */
    public $nodeIdPrefix = 'node-';
    /** draw with root category */
    public $withRoot = false;
    /** url template in where in every node we replace {{id}} to node id */
    public $urlTemplate = null;


    public function init()
    {

    }

    public function run()
    {
        $tree = $this->createHtmlTree($this->data, $this->withRoot);

        if ($this->return) {
            return $tree;
        }
        else {
            echo $tree;
        }
    }

    private function createHtmlTree($data, $withRoot)
    {
        $result = '';
        $level=0;

        foreach($data as $node)
        {
            if ($node->level == 1 && !$withRoot) {
                continue;
            }

            if($node->level == $level) {
                $result .= CHtml::closeTag('li')."\n";
            }
            else if($node->level > $level) {
                $htmlOptions = array();

                if ($node->level == 2) {
                    $htmlOptions = array(
                        'class'=>'nav nav-list mb-xlg'
                    );
                }

                $result .= CHtml::openTag('ul', $htmlOptions)."\n";
            }
            else
            {
                $result .= CHtml::closeTag('li')."\n";

                for($i=$level-$node->level; $i; $i--)
                {
                    $result .= CHtml::closeTag('ul')."\n";
                    $result .= CHtml::closeTag('li')."\n";
                }
            }

            $leafNumber = !empty($node->leafNumber) ? $node->leafNumber : 0;
            //$name = $node->is_folder || $leafNumber > 0 ? $node->name_en.' ('.$leafNumber.')' : $node->name_en;

            $url = str_replace(array('{{id}}', '{{slug}}'), array($node->id, $node->slug), $this->urlTemplate);
            $level = $node->level;

            $result .= CHtml::openTag('li', array(
                    'id'=>$this->nodeIdPrefix.$node->id,
                    'class'=>($node->id == $this->currentId ? 'active' : '')
                ))."\n";
            $result .= CHtml::link( CHtml::encode($node->name), $url )."\n";
        }

        if (!$withRoot) {
            $level--;
        }

        for($i=$level; $i; $i--)
        {
            $result .= CHtml::closeTag('li')."\n";
            $result .= CHtml::closeTag('ul')."\n";
        }

        return $result;
    }

    private function getNodeData($node)
    {
        $data = array();

        if (!$node->is_folder) {
            $data['type'] = 'file';
        }

        return json_encode($data);
    }

}
