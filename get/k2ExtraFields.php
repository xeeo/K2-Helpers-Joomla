<?php

defined( '_JEXEC' ) or die;

jimport('xeeo.core.singleton');
jimport('xeeo.helper.k2ExtraFields');

class XeeoGetExtrafields extends XeeoCoreSingleton
{
    public $item = null;

    public function setItem($item) {

        $this->item = $item;

        return $this;
    }

    public function get($identifier, $item = null) {

        $extraField = $this->getObject($identifier, $item);

        $value = (!is_null($extraField)) ?
            $extraField->value : '';

        return $value;
    }

    public function getObject($identifier, $item = null) {

        $extraFieldsHelper = XeeoHelperK2ExtraFields::getInstance();

        if (is_null($item)) {
            if (is_null($this->item)) {
                $object        = new \stdClass();
                $objext->value = 'No Item set!';
                return $object;
            } else {
                $item = $this->item;
            }
        }

        $extraFields = (is_numeric($identifier)) ?
            $extraFieldsHelper->prepare($item->id, $item->extra_fields, 'id') :
            $extraFieldsHelper->prepare($item->id, $item->extra_fields, 'name');

        $object = (isset($extraFields->{$identifier})) ?
            $extraFields->{$identifier} : null;

        return $object;
    }

    public function getExtraFieldsByGroup($groupId) {

        include JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_k2' . DS . 'models' . DS . 'extrafield.php';

        $extraFieldModel = new K2ModelExtraField();
        $extraFields     = $extraFieldModel->getExtraFieldsByGroup($groupId);

        return $extraFields;
    }
}
