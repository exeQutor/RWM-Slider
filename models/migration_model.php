<?php

/**
 * @package RWMs Migration Model
 * @subpackage RWM Slider Manager
 * @author Randolph
 * @since 1.0.0
 */

class RWMs_Migration_Model {
    var $table;
    
    function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . RWMs_PREFIX . 'sliders';
    }
    
    function up() {
        global $wpdb;
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$this->table} (
            slider_id int(11) NOT NULL AUTO_INCREMENT,
            slider_type varchar(10) NOT NULL,
            slider_src varchar(255) NOT NULL,
            slider_heading varchar(255) NOT NULL,
            slider_subheading varchar(255) NOT NULL,
            slider_text text NOT NULL,
            slider_text_pos varchar(10) NOT NULL,
            slider_btn_type varchar(24) NOT NULL,
            slider_btn_text varchar(255) NOT NULL,
            slider_btn_url varchar(255) NOT NULL,
            PRIMARY KEY (slider_id)
        );");
    }
    
    function down() {
        global $wpdb;
        
        $wpdb->query("DROP TABLE IF EXISTS {$this->table}");
    }
}

/**
 * @filesource ./models/migration_model.php
 */