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

        $id    = (int)$k2CategoryId;
        $db    = JFactory::getDBO();
        $query = "SELECT * FROM #__k2_categories WHERE id={$id} ORDER BY ordering ASC";

        $db->setQuery($query);

        $row = $db->loadObject();
        $row->link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($row->id.':'.urlencode($row->alias))));

        return $row;
    }

    public function getK2Category($k2CategoryId) {

        $mainframe = JFactory::getApplication();
        $user      = JFactory::getUser();
        $aid       = (int)$user->get('aid');

        $id    = (int)$k2CategoryId;
        $db    = JFactory::getDBO();
        $query = "SELECT * FROM #__k2_categories WHERE id={$id}";

        $query .= " AND published=1  AND trash=0";
        if (K2_JVERSION != '15') {
            $query .= " AND access IN(" . implode(',', $user->getAuthorisedViewLevels()) . ")";
            if ($mainframe->getLanguageFilter()) {
                $query .= " AND language IN(" . $db->Quote(JFactory::getLanguage()->getTag()) . ", " . $db->Quote('*') . ")";
            }
        } else {
            $query .= " AND access<={$aid}";
        }

        $query .= " ORDER BY ordering ASC";

        $db->setQuery($query);

        $row = $db->loadObject();
        $row->link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($row->id.':'.urlencode($row->alias))));

        return $row;
    }

    public function getK2SubCategories($k2CategoryId) {

        $mainframe = JFactory::getApplication();
        $user      = JFactory::getUser();
        $aid       = (int)$user->get('aid');

        $id    = (int)$k2CategoryId;
        $db    = JFactory::getDBO();
        $query = "SELECT * FROM #__k2_categories WHERE parent={$id}";

        $query .= " AND published=1  AND trash=0";
        if (K2_JVERSION != '15') {
            $query .= " AND access IN(" . implode(',', $user->getAuthorisedViewLevels()) . ")";
            if ($mainframe->getLanguageFilter()) {
                $query .= " AND language IN(" . $db->Quote(JFactory::getLanguage()->getTag()) . ", " . $db->Quote('*') . ")";
            }
        } else {
            $query .= " AND access<={$aid}";
        }

        $query .= " ORDER BY ordering ASC";

        $db->setQuery($query);

        $rows = $db->loadObjectList();

        $categoryList = array();

        foreach ($rows as $row) {
            $row->link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($row->id.':'.urlencode($row->alias))));
            $categoryList[] = $row;
        }

        return $categoryList;
    }
}
