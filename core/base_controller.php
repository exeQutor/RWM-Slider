<?php

/**
 * @package RWMs Base Controller
 * @subpackage RWM Slider Manager
 * @author Randolph
 * @since 1.0.0
 */

class RWMs_Base_Controller {
    var $migration;
    var $slider;
    
    static $instance = NULL;
    
    function __construct() {
        $this->migration = new RWMs_Migration_Model();
        $this->slider = new RWMs_Slider_Model();
    }
    
    static function get_instance() {
        if ( ! isset(self::$instance)) {
            self::$instance = new RWMs_Base_Controller();
        }
        
        return self::$instance;
    }
}

/**
 * @filesource ./core/base_controller.php
 */