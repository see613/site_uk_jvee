<?php

/**
 * helper class for constants <br>
 * you can define some constants here <br>
 * and use methods to get array of constants
 */
abstract class BaseConstantList
{

    /**
     * result is array('CONST_NAME' => 'const_value', ... )
     * @return array
     */
    public static function getAssociatedList() {
        $reflector = new ReflectionClass( get_called_class() );

        return $reflector->getConstants();
    }

    /**
     * result is array('const_value', ... )
     * @return array
     */
    public static function getList() {
        return array_values( static::getAssociatedList() );
    }

    /**
     * result is array('const_value' => 'const_value', ... )
     * @return array
     */
    public static function getIdenticalKeyValueList() {
        $list = static::getAssociatedList();

        return array_combine( $list, $list );
    }

}
