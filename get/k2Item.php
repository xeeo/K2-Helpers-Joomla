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

    public function findByCategory($k2CategoryIdentifier, $limit = -1) {

        $db = JFactory::getDBO();

        $query = "SELECT items.* FROM #__k2_items as items ";

        if (is_numeric($k2CategoryIdentifier)) {
            $query .= "WHERE items.catid = " . $k2CategoryIdentifier;
        } else {

            $query .= "LEFT JOIN #__k2_categories as categories ON items.catid = categories.id ";
            $query .= "WHERE categories.name = '" . $k2CategoryIdentifier . "'";
            $query .= " AND categories.published=1  AND categories.trash=0";
            if (K2_JVERSION != '15') {
                $query .= " AND categories.access IN(" . implode(',', $user->getAuthorisedViewLevels()) . ")";
                if ($mainframe->getLanguageFilter()) {
                    $query .= " AND categories.language IN(" . $db->Quote(JFactory::getLanguage()->getTag()) . ", " . $db->Quote('*') . ")";
                }
            } else {
                $query .= " AND categories.access<={$aid}";
            }

        }

        if ($limit > 0) {
            $query .= " LIMIT " . $limit;
        }

        $db->setQuery($query);
        $k2Items = $db->loadObjectList();

        $collection   = array();
        $k2ItemHelper = XeeoHelperK2Item::getInstance();

        foreach($k2Items as $k2RawItem) {

            $k2Item = $k2ItemHelper->prepare($k2RawItem);

            $collection[] = $k2Item;
        }

        return $collection;
    }
}
