<?php

class NestedSetWidget extends CWidget
{
    /** nodes array */
    public $data = array();
    /** GET parameter of current node id <br /> if $currentNodeId is empty we fill it from GET */
    public $paramNameFromGet = 'cat_id';
    /** node id in the DOM */
    public $nodeIdPrefix = 'node-';
    /** render or just return result */
    public $return = false;
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
                $result .= CHtml::openTag('ul')."\n";
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
            $name = $node->is_folder || $leafNumber > 0 ? $node->name_en.' ('.$leafNumber.')' : $node->name;

            $url = str_replace('{{id}}', $node->id, $this->urlTemplate);
            $level = $node->level;

            $result .= CHtml::openTag('li', array(
                    'id'=>$this->nodeIdPrefix.$node->id,
                    'data-id'=>$node->id,
                    'data-jstree'=>$this->getNodeData($node),
                ))."\n";
            $result .= CHtml::link( CHtml::encode($name), $url )."\n";
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
