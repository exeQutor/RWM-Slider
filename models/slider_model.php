<?php

/**
 * @package RWMs Slider Model
 * @subpackage RWM Slider Manager
 * @author Randolph
 * @since 1.0.0
 */

class RWMs_Slider_Model {
    var $table;
    
    function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . RWMs_PREFIX . 'sliders';
    }
    
    function get_row($id) {
        global $wpdb;
        
        return $wpdb->get_row("SELECT * FROM {$this->table} WHERE slider_id = $id");
    }
    
    function get_results() {
        global $wpdb;
        
        return $wpdb->get_results("SELECT * FROM {$this->table}");
    }
    
    function insert($post_data) {
        global $wpdb;
        
        extract($post_data);
        
        $source = ($type != 'text')
                    ? ($type == 'image')
                        ? $source_image
                        : $source_video
                    : '';
        
        $data = array(
            'slider_type' => $type,
            'slider_src' => $source,
            'slider_heading' => esc_attr($heading),
            'slider_subheading' => esc_attr($subheading),
            'slider_text' => esc_attr($text),
            'slider_text_pos' => $text_pos,
            'slider_btn_type' => $btn_type,
            'slider_btn_text' => esc_attr($btn_text),
            'slider_btn_url' => esc_url($btn_url)
        );
        $wpdb->insert($this->table, $data);
        
        return $wpdb->insert_id;
    }
    
    function update($post_data, $id) {
        global $wpdb;
        
        extract($post_data);
        
        $source = ($type != 'text')
                    ? ($type == 'image')
                        ? $source_image
                        : $source_video
                    : '';
        
        $data = array(
            'slider_type' => $type,
            'slider_src' => $source,
            'slider_heading' => esc_attr($heading),
            'slider_subheading' => esc_attr($subheading),
            'slider_text' => esc_attr($text),
            'slider_text_pos' => $text_pos,
            'slider_btn_type' => $btn_type,
            'slider_btn_text' => esc_attr($btn_text),
            'slider_btn_url' => esc_url($btn_url)
        );
        $wpdb->update($this->table, $data, array('slider_id' => $id));
        
        $data['slider_id'] = $wpdb->insert_id;
        
        return $data;
    }
    
    function get_formatted_data() {
        $results = $this->get_results();
        
        $data = array();
        foreach ($results as $result)
        {
            $data[$result->slider_id] = $result;
        }
        
        return $data;
    }
    
}

/**
 * @filesource ./models/slider_model.php
 */