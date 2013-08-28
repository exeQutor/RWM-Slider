<?php

/**
 * @package RWMs Slider Model
 * @subpackage RWM Slider Manager
 * @author Randolph
 * @since 1.0.0
 */

class RWMs_Slider_Model {
    var $table;
    var $table2;
    
    function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . RWMs_PREFIX . 'sliders';
        $this->table2 = $wpdb->prefix . RWMs_PREFIX . 'slider_groups';
    }
    
    function get_row($id) {
        global $wpdb;
        
        return $wpdb->get_row("SELECT * FROM {$this->table} WHERE slider_id = $id");
    }
    
    function get_group($id) {
        global $wpdb;
        
        return $wpdb->get_row("SELECT * FROM {$this->table2} WHERE slider_group_id = $id");
    }
    
    function get_results($set_id = '') {
        global $wpdb;
        
        $where = ( ! empty($set_id)) ? ' WHERE slider_group_id = ' . $set_id : '';
            
        return $wpdb->get_results("SELECT * FROM {$this->table}$where");
    }
    
    function get_groups() {
        global $wpdb;
        
        return $wpdb->get_results("SELECT * FROM {$this->table2}");
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
            'slider_group_id' => $group,
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
    
    function create_group($post_data) {
        global $wpdb;
        
        extract($post_data);
        
        $data = array(
            'slider_group_name' => esc_attr($name),
            'slider_group_description' => esc_attr($description)
        );
        $wpdb->insert($this->table2, $data);
        
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
            'slider_group_id' => $group,
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
    
    function update_group($post_data, $id) {
        global $wpdb;
        
        extract($post_data);
        
        $data = array(
            'slider_group_name' => esc_attr($name),
            'slider_group_description' => esc_attr($description)
        );
        $wpdb->update($this->table2, $data, array('slider_group_id' => $id));
        
        return $data;
    }
    
    function get_formatted_data($set_id = '') {
        $results = $this->get_results($set_id);
        
        $data = array();
        foreach ($results as $result)
        {
            $data[$result->slider_id] = $result;
        }
        
        return $data;
    }
    
    function exists($slider_id) {
        global $wpdb;
        
        return $wpdb->query($wpdb->prepare("SELECT COUNT(*) FROM {$this->table} WHERE slider_id = %d", $slider_id));
    }
    
    function import($data) {
        global $wpdb;
        $wpdb->insert($this->table, $data);
        
        return $wpdb->insert_id;
    }
    
    function delete($slider_id) {
        global $wpdb;
        return $wpdb->delete($this->table, array('slider_id' => $slider_id));
    }
    
    function delete_group($slider_group_id) {
        global $wpdb;
        return $wpdb->delete($this->table2, array('slider_group_id' => $slider_group_id));
    }
}

// ./models/slider_model.php