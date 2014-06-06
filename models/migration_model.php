<?php

/**
 * @package RWM Slider Manager/Migration Model
 * @author Randolph
 * @since 1.0.1
 */

class RWMs_Migration_Model {
    var $table;
    
    function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . RWMs_PREFIX . 'sliders';
        $this->table2 = $wpdb->prefix . RWMs_PREFIX . 'slider_groups';
        $this->table3 = $wpdb->prefix . RWMs_PREFIX . 'relationships';
    }
    
    function up() {
        global $wpdb;
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$this->table} (
            slider_id int(11) NOT NULL AUTO_INCREMENT,
            slider_type varchar(10) NOT NULL,
            slider_src varchar(255) NOT NULL,
            slider_preview varchar(255) NOT NULL,
            slider_heading varchar(255) NOT NULL,
            slider_subheading varchar(255) NOT NULL,
            slider_text text NOT NULL,
            slider_text_pos varchar(10) NOT NULL,
            slider_textbox_bg varchar(24) NOT NULL,
            slider_btn_type varchar(24) NOT NULL,
            slider_btn_text varchar(255) NOT NULL,
            slider_btn_url varchar(255) NOT NULL,
            PRIMARY KEY (slider_id)
        );");
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$this->table2} (
            slider_group_id int(11) NOT NULL AUTO_INCREMENT,
            slider_group_name varchar(255) NOT NULL,
            slider_group_description text NOT NULL,
            PRIMARY KEY (slider_group_id)
        );");
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$this->table3} (
            object_id int(11) NOT NULL AUTO_INCREMENT,
            slider_id int(11) NOT NULL,
            slider_group_id int(11) NOT NULL,
            PRIMARY KEY (object_id)
        );");
    }
    
    function down() {
        global $wpdb;
        
        $wpdb->query("DROP TABLE IF EXISTS {$this->table}");
        $wpdb->query("DROP TABLE IF EXISTS {$this->table2}");
        $wpdb->query("DROP TABLE IF EXISTS {$this->table3}");
    }
}
