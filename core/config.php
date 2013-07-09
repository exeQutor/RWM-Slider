<?php

/**
 * @package RWM Slider Manager / Configuration
 * @author Randolph
 * @since 1.0.2
 */

class RWMs_Config {
    public $pages;
    
    function __construct() {
        $this->pages = array();
        $this->pages[0] = RWMs_SLUG;
        $this->pages[1] = RWMs_PREFIX . 'add_new';
        $this->pages[2] = RWMs_PREFIX . 'import_export';
    }
}

/**
 * @filesource ./core/config.php
 */