<?php

/**
 * @package RWMs Migration Controller
 * @subpackage RWM Slider Manager
 * @author Randolph
 * @since 1.0.0
 */

class RWMs_Migration extends RWMs_Base_Controller {
    
    function __construct() {
        parent::__construct();
        
        register_activation_hook(RWMs_FILE, array($this, 'activate'));
        register_deactivation_hook(RWMs_FILE, array($this, 'deactivate'));
    }
    
    public function activate()
    {
        $this->migration->up();
    }
    
    public function deactivate()
    {
        $this->migration->down();
    }
}

/**
 * @filesource ./controllers/migration.php
 */