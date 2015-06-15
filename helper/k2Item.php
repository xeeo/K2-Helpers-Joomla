<?php

defined( '_JEXEC' ) or die;

jimport('xeeo.core.singleton');

class XeeoHelperK2Item extends XeeoCoreSingleton
{
    public function prepare($k2RawItem) {

        $k2ModelItem = new K2ModelItem();

        $k2Item = $k2ModelItem->prepareItem($k2RawItem, 'item', 'item');
        $k2Item = $k2ModelItem->execPlugins($k2Item, 'item', 'item');

        $extraFields = XeeoHelperK2ExtraFields::getInstance();

        $k2Item->extraFields = $extraFields->prepare($k2Item->id, $k2Item->extra_fields, 'id');
        $k2Item->text        = $k2Item->introtext . ' ' . $k2Item->fulltext;

        return $k2Item;
    }

}
