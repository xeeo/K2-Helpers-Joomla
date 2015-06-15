<?php
defined( '_JEXEC' ) or die;

jimport('xeeo.core.singleton');

class XeeoGetModules extends XeeoCoreSingleton
{
    public function get($moduleTitle, $moduleType, $params = array()) {

        $module = JModuleHelper::getModule($moduleType, $moduleTitle);

        if (empty($module)) {
            return 'Module not found or not visible.';
        }

        $moduleParams   = json_decode($module->params, true);
        $moduleParams   = array_merge($moduleParams, $params);
        $module->params = json_encode($moduleParams);

        return $module;
    }

    public function render($moduleTitle, $moduleType, $params = array(), $attribs = array()) {

        $module = $this->get($moduleTitle, $moduleType, $params);

        return JModuleHelper::renderModule($module, $attribs);
    }
}
