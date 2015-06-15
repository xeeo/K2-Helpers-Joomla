<?php

defined( '_JEXEC' ) or die;

abstract class XeeoCoreSingleton {

    private static $instance = null;

    protected function __construct() {}
    protected function __deconstruct() {}
    protected function __clone() {}

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

}
