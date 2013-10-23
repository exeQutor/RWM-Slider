<?php

/**
 * @package RWM Slider Manager/Slider Model
 * @author Randolph
 * @since 1.0.1
 */

class RWMs_Slider_Model {
    var $table;
    var $table2;
    var $table3;
    
    function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . RWMs_PREFIX . 'sliders';
        $this->table2 = $wpdb->prefix . RWMs_PREFIX . 'slider_groups';
        $this->table3 = $wpdb->prefix . RWMs_PREFIX . 'relationships';
    }
    
    function get_row($id) {
        global $wpdb;
        
        return $wpdb->get_row("SELECT * FROM {$this->table} WHERE slider_id = $id");
    }
    
    function get_group($id) {
        global $wpdb;
        
        return $wpdb->get_row("SELECT * FROM {$this->table2} WHERE slider_group_id = $id");
    }
    
    function get_results($group_id = '') {
        global $wpdb;
        
        //$where = ( ! empty($group_id)) ? ' WHERE slider_group_id = ' . $group_id : '';
            
        //return $wpdb->get_results("SELECT * FROM {$this->table}$where");
        
        $results = array();
        $sliders = $wpdb->get_results("SELECT * FROM $this->table");
        
        foreach ($sliders as $slider) {
            $groups = array();
            $relationships = $this->fetch_relationships($slider->slider_id);
            foreach ($relationships as $relationship)
                $groups[] = $relationship->slider_group_id;
                
            $slider->slider_group = $groups;
            
            $results[] = $slider;
        }
        
//        echo '<pre>';
//		print_r($results);
//		echo '</pre>';
        
        return $results;
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
            //'slider_group_id' => $group,
            'slider_type' => $type,
            'slider_src' => $source,
            'slider_heading' => esc_attr($heading),
            'slider_subheading' => esc_attr($subheading),
            'slider_text' => esc_attr($text),
            'slider_text_pos' => $text_pos,
            'slider_textbox_bg' => $textbox_bg,
            'slider_btn_type' => $btn_type,
            'slider_btn_text' => esc_attr($btn_text),
            'slider_btn_url' => esc_url($btn_url)
        );
        $wpdb->insert($this->table, $data);
        
        return $wpdb->insert_id;
    }
    
    function delete_relationships($slider_id) {
        global $wpdb;
        
        $wpdb->delete($this->table3, array('slider_id' => $slider_id));
    }
    
//    function fetch_relationship($slider_id, $slider_group_id) {
//        global $wpdb;
//        
//        return $wpdb->get_row("SELECT * FROM $this->table3 WHERE slider_id = $slider_id AND slider_group_id = $slider_group_id");
//    }
//    
//    function update_relationship($object_id, $slider_id, $slider_group_id) {
//        global $wpdb;
//        
//        $data = array(
//            'slider_id' => $slider_id,
//            'slider_group_id' => $slider_group_id
//        );
//        $wpdb->update($this->table3, $data, array('object_id' => $object_id));
//    }
    
    function insert_relationship($slider_id, $slider_group_id) {
        global $wpdb;
        
        $data = array(
            'slider_id' => $slider_id,
            'slider_group_id' => $slider_group_id
        );
        $wpdb->insert($this->table3, $data);
    }
    
    function fetch_relationships($slider_id) {
        global $wpdb;
        
        return $wpdb->get_results("SELECT * FROM $this->table3 INNER JOIN $this->table2 ON $this->table3.slider_group_id = $this->table2.slider_group_id WHERE $this->table3.slider_id = $slider_id");
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
            //'slider_group_id' => $group,
            'slider_type' => $type,
            'slider_src' => $source,
            'slider_heading' => esc_attr($heading),
            'slider_subheading' => esc_attr($subheading),
            'slider_text' => esc_attr($text),
            'slider_text_pos' => $text_pos,
            'slider_textbox_bg' => $textbox_bg,
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
    
    function get_formatted_data($group_id = '') {
        $results = $this->get_results();
        
        $data = array();
        foreach ($results as $result)
        {
            if ( ! empty($group_id) && in_array($group_id, $result->slider_group))
                $data[$result->slider_id] = $result;
        }
        
//        echo '<pre>';
//		print_r($data);
//		echo '</pre>';
        
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
