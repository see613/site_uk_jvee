<?php

class NestedSetExtBehavior extends CActiveRecordBehavior
{
    public $leftAttribute='lft';
    public $rightAttribute='rgt';
    public $levelAttribute='level';


    public function findTree($showDocsInTree = true)
    {
        $owner = $this->owner;
        $criteria = new CDbCriteria;
        $criteria->order = 't.lft';

        if (!$showDocsInTree) {
            $criteria->compare('is_folder', 1);
        }

        return $owner::model()->findAll($criteria);
    }

    public function withLeafNumber()
    {
        $owner = $this->owner;

        $criteria = new CDbCriteria;
        $criteria->select = array('t.*',
            '(select count(*) from `'.$owner->tableName().'` `leafStats` '.
            'where t.lft < leafStats.lft and t.rgt > leafStats.rgt '.
            //'and t.level = leafStats.level - 1 '. // if node doesn't inherit child node leaf number
            'and is_folder = 0'. // if we count only docs
            ') as leafNumber');

        $owner::model()->getDbCriteria()->mergeWith($criteria);
        return $owner::model();
    }


    public function leafMayNotHaveChildrenValidator($attribute, $params)
    {
        $owner = $this->owner;

        if ( !empty($owner->id) && isset($owner->is_folder) && $owner->is_folder < 1 ){
            $childrenNumber = $owner::model()->findByPk( $owner->id )
                                                ->children()->count();

            if ( $childrenNumber > 0 ) {
                $owner->addError($attribute, 'This element contains child elements so it may be category only');
            }
        }
    }

    public function attach($owner) {
        parent::attach($owner);

        if (!($owner instanceof CActiveRecord)) {
            throw new Exception('Owner must be a CActiveRecord class');
        }

        /** @var $owner CActiveRecord */
        $validators = $owner->getValidatorList();
        $validators->add( CValidator::createValidator('leafMayNotHaveChildrenValidator', $this, 'is_folder') );
    }




}