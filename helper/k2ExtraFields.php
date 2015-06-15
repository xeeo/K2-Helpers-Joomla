<?php

defined( '_JEXEC' ) or die;

jimport('xeeo.core.singleton');

class XeeoHelperK2ExtraFields extends XeeoCoreSingleton
{
    private static $items = array();

    public function prepare($itemId, $rawExtraFields, $identifier = 'name') {

        $extraFields = new \stdClass();

        if (!empty($rawExtraFields)) {

            if (isset(self::$items[$itemId . '-' . $identifier])) {
                return self::$items[$itemId . '-' . $identifier];
            }

            if (!is_array($rawExtraFields)) {
                $rawExtraFields = json_decode($rawExtraFields, false);
            }

            array_walk($rawExtraFields, function($field) use (&$extraFields, $identifier) {
                if (isset($field->{$identifier})) {
                    $extraFields->{$field->{$identifier}} = $field;
                }
            });

        }

        self::$items[$itemId . '-' . $identifier] = $extraFields;

        return self::$items[$itemId . '-' . $identifier];
    }

}
