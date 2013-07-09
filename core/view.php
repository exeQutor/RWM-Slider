<?php

/**
 * @package RWM Slider Manager / View
 * @author Randolph
 * @since 1.0.2
 */

class RWMs_View {
    private $vars = array();
    
    function __construct() {}
    
    function __set($index, $value) {
        $this->vars[$index] = $value;
    }
    
    function render($name) {
        if ( ! file_exists(RWMs_DIR . "views/$name.php")) {
            throw new Exception('View file not found in ' . RWMs_DIR . "views/$name.php");
            return false;
        }
        
        foreach ($this->vars as $key => $value) {
            $$key = $value;
        }
        
        include RWMs_DIR . "views/$name.php";
    }
}

/**
 * @filesource ./core/config.php
 */