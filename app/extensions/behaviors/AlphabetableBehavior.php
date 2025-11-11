<?php


class AlphabetableBehavior extends CActiveRecordBehavior
{
    public $column = null;


    function byAlphabet()
    {
        $criteria = new CDbCriteria;
        $criteria->order = $this->column." asc";

        $this->owner->getDbCriteria()->mergeWith($criteria);
        return $this->owner;
    }

    function findAllByAlphabet() {
        return $this->owner->byAlphabet()->findAll();
    }

}

