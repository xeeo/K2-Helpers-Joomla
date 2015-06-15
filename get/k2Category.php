<?php

defined( '_JEXEC' ) or die;

jimport('xeeo.core.singleton');

class XeeoGetK2Category extends XeeoCoreSingleton
{
    public function getTopParent($k2CategoryId)
    {
        $db    = JFactory::getDBO();
        $query = "SELECT * FROM #__k2_categories WHERE id = {$k2CategoryId} LIMIT 1";

        $db->setQuery($query);

        $category = $db->loadObject();

        if ($category->parent != 0) {
            return $this->getTopParent($category->parent);
        }

        return $category;
    }

    public function getRawK2Category($k2CategoryId) {
        $row = JTable::getInstance('K2Category', 'Table');
        $row->load($k2CategoryId);

        return $row;
    }

    public function getK2Categroy($k2CategoryId) {

        $user  = JFactory::getUser();
        $aid   = (int)$user->get('aid');
        $id    = (int)$k2CategoryId;
        $db    = JFactory::getDBO();
        $query = "SELECT * FROM #__k2_categories WHERE id={$id} AND published=1 AND trash=0 AND access<={$aid} ";

        $db->setQuery($query);

        $row = $db->loadObject();

        return $row;
    }

    public function getK2SubCategroies($k2CategoryId) {

        $user  = JFactory::getUser();
        $aid   = (int)$user->get('aid');
        $id    = (int)$k2CategoryId;
        $db    = JFactory::getDBO();
        $query = "SELECT * FROM #__k2_categories WHERE parent={$id} AND published=1 AND trash=0 AND access<={$aid} ";

        $db->setQuery($query);

        $rows = $db->loadObjectList();

        return $rows;
    }

    public function get($k2CategoryId) {

        $db = JFactory::getDBO();
        $db->setQuery("SELECT * FROM #__k2_items WHERE id = " . $k2ItemId );

        $k2RawItem = $db->loadObject();

        return $k2Item;
    }
}
