<?php

/**
 * @package Admin Menu Controller
 * @subpackage RWM Slider Manager
 * @author Randolph
 * @since 1.0.0
 */

class RWMs_Admin_Menu extends RWMs_Base_Controller {
    var $default_options;
    
    function __construct() {
        parent::__construct();
        
        $rwms_pages = array(
            RWMs_SLUG,
            RWMs_PREFIX . 'add_new',
            RWMs_PREFIX . 'import_export'
        );
        
        if ($GLOBALS['pagenow'] == 'admin.php' && in_array($_GET['page'], $rwms_pages))
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
            
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));
        add_action('wp_ajax_rwms_sortable_change', array($this, 'wp_ajax_rwms_sortable_change'));
    }
    
    function admin_enqueue_scripts() {
        if (function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
        }
        
        wp_enqueue_style('bootstrap', RWMs_URL . 'assets/css/bootstrap.min.css');
        wp_enqueue_style('alertify', RWMs_URL . 'assets/css/alertify.core.css');
        wp_enqueue_style('alertify-bootstrap', RWMs_URL . 'assets/css/alertify.bootstrap.css');
        wp_enqueue_style(RWMs_SLUG, RWMs_URL . 'assets/css/admin_style.css');
        
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('bootstrap', RWMs_URL . 'assets/js/bootstrap.min.js');
        wp_enqueue_script('alertify', RWMs_URL . 'assets/js/alertify.min.js');
        wp_enqueue_script(RWMs_SLUG, RWMs_URL . 'assets/js/admin_script.js');
        
        $page = $_GET['page'];
        
        $script = (isset($page) && ! empty($page)) ? RWMs_DIR . "assets/js/$page.js" : '';
        if (file_exists($script))
            wp_enqueue_script($page, RWMs_URL . "assets/js/$page.js");
    }
    
    function admin_menu() {
        add_menu_page(RWMs_NAME, RWMs_SINGULAR, 'manage_options', RWMs_SLUG, array($this, 'all_sliders_page'), RWMs_URL . 'assets/img/admin_icon.png');
        add_submenu_page(RWMs_SLUG, '', '', 'manage_options', RWMs_SLUG, '');
        add_submenu_page(RWMs_SLUG, RWMs_NAME, 'All Sliders', 'manage_options', RWMs_SLUG, array($this, 'all_sliders_page'));
        add_submenu_page(RWMs_SLUG, RWMs_NAME, 'Add New', 'manage_options', RWMs_PREFIX . 'add_new', array($this, 'add_new_page'));
    }
    
    function all_sliders_page() {
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            if ( ! empty($_GET['id'])) {
                $sorted_sliders = get_option(RWMs_PREFIX . 'sliders');
                $sorted_sliders = ( ! empty($sorted_sliders)) ? explode(',', $sorted_sliders) : '';
                
                foreach ($sorted_sliders as $key => $value) {
                    if ($value == $_GET['id']) {
                        unset($sorted_sliders[$key]);
                    }
                }
                
                $this->slider->delete($_GET['id']);
                update_option(RWMs_PREFIX . 'sliders', implode(',', $sorted_sliders));
            }
        }
        
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $type_array = array(
                'image' => 'Image',
                'video' => 'Video',
                'text' => 'Text'
            );
            
            $text_pos_array = array(
                'left' => 'Left',
                'right' => 'Right'
            );
            
            $btn_type_array = array(
                'text' => 'Text',
                'square_edge' => 'Square Edge',
                'round_edge' => 'Round Edge'
            );
            
            $alert = array(
                'type' => 'success',
                'message' => ''
            );
            
            if ( ! empty($_GET['id'])) {
                if ( ! empty($_POST) && wp_verify_nonce($_POST[RWMs_PREFIX . 'nonce'], RWMs_PREFIX . 'edit_slider')) {
                    extract($_POST[RWMs_PREFIX . 'fields']);

                    if ( ! $heading) {
                        $alert['type'] = 'error';
                        $alert['message'] .= '<p>The Heading field is required.</p>';
                    }
                    
                    if ($type != 'text') {
                        if ($type == 'image' && empty($source_image)) {
                            $alert['type'] = 'error';
                            $alert['message'] .= '<p>Please choose an image file to upload.</p>';
                        } elseif ($type == 'video' && empty($source_video)) {
                            $alert['type'] = 'error';
                            $alert['message'] .= '<p>The Video ID field is required.</p>';
                        }
                    } elseif ($type == 'text' && empty($text)) {
                        $alert['type'] = 'error';
                        $alert['message'] .= '<p>The Main Text field is required.</p>';
                    }
                    
                    if ($alert['type'] == 'success') {
                        $alert['message'] = '<p>Changes saved.</p>';
                        
                        $this->slider->update($_POST[RWMs_PREFIX . 'fields'], $_GET['id']);
                    }
                }
                
                $slider = $this->slider->get_row($_GET['id']);
                include RWMs_DIR . 'views/edit_slider_page.php';
            }
        } else {
            $sorted_sliders = get_option(RWMs_PREFIX . 'sliders');
            $sorted_sliders = ( ! empty($sorted_sliders)) ? explode(',', $sorted_sliders) : '';
            
            $sliders = $this->slider->get_formatted_data();
            include RWMs_DIR . 'views/all_sliders_page.php';
        }
    }
    
    function add_new_page() {
        $type_array = array(
            'image' => 'Image',
            'video' => 'Video',
            'text' => 'Text'
        );
        
        $text_pos_array = array(
            'left' => 'Left',
            'right' => 'Right'
        );
        
        $btn_type_array = array(
            'text' => 'Text',
            'square_edge' => 'Square Edge',
            'round_edge' => 'Round Edge'
        );
        
        $alert = array(
            'type' => 'success',
            'message' => ''
        );
        
        if ( ! empty($_POST) && wp_verify_nonce($_POST[RWMs_PREFIX . 'nonce'], RWMs_PREFIX . 'add_new')) {
            extract($_POST[RWMs_PREFIX . 'fields']);
            
            if ( ! $heading) {
                $alert['type'] = 'error';
                $alert['message'] .= '<p>The Heading field is required.</p>';
            }
            
            if ($type != 'text') {
                if ($type == 'image' && empty($source_image)) {
                    $alert['type'] = 'error';
                    $alert['message'] .= '<p>Please choose an image file to upload.</p>';
                } elseif ($type == 'video' && empty($source_video)) {
                    $alert['type'] = 'error';
                    $alert['message'] .= '<p>The Video ID field is required.</p>';
                }
            } elseif ($type == 'text' && empty($text)) {
                $alert['type'] = 'error';
                $alert['message'] .= '<p>The Main Text field is required.</p>';
            }
            
            if ($alert['type'] == 'success') {
                $alert['message'] = '<p>Slider created.</p>';
                
                $slider_id = $this->slider->insert($_POST[RWMs_PREFIX . 'fields']);
                $sorted_sliders = get_option(RWMs_PREFIX . 'sliders');
                $new_value = ($sorted_sliders) ? $sorted_sliders . ',' . $slider_id : $slider_id;
                update_option(RWMs_PREFIX . 'sliders', $new_value);
            }
        }
        
        include RWMs_DIR . 'views/add_new_page.php';
    }
    
    function import_export_page() {
        include RWMs_DIR . 'views/import_export_page.php';
    }
    
    function admin_init() {
        register_setting(RWMs_SLUG, RWMs_PREFIX . 'options');
        register_setting(RWMs_SLUG, RWMs_PREFIX . 'sliders');
    }
    
    function wp_ajax_rwms_sortable_change() {
        extract($_POST);
        
        print_r($sliders);
        
        update_option(RWMs_PREFIX . 'sliders', implode(',', $sliders));
        die();
    }
    
    function get_options($option_group = 'options')
    {
        $options = get_option(RWMs_PREFIX . $option_group);
        
        if (empty($options))
            $options = $this->default_options[$option_group];
        
        if (count($this->default_options[$option_group]) != count($options))
            return $options + $this->default_options[$option_group];
            
        $data = array();
        foreach ($options as $key => $option)
            $data[$key] = ( ! empty($option)) ? $options[$key] : $this->default_options[$option_group][$key];
        
        return $data;
    }
}

/**
 * @filesource ./controllers/admin_menu.php
 */