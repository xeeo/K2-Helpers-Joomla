<?php

defined( '_JEXEC' ) or die;

jimport('xeeo.core.singleton');
jimport('xeeo.helper.k2Item');

class XeeoGetK2Item extends XeeoCoreSingleton
{
    public function get($k2ItemId) {

        $db = JFactory::getDBO();
        $db->setQuery("SELECT * FROM #__k2_items WHERE id = " . $k2ItemId );

        $k2RawItem = $db->loadObject();

        $k2ItemHelper = XeeoHelperK2Item::getInstance();
        $k2Item       = $k2ItemHelper->prepare($k2RawItem);

        return $k2Item;
    }
}
