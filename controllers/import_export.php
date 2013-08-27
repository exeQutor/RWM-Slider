<?php

/**
 * @package RWM Slider Manager / Import and Export Controller
 * @author Randolph
 * @since 1.0.2
 */

class RWMs_Import_Export extends RWMs_Base_Controller {
    function __construct() {
        parent::__construct();
        
        if ($GLOBALS['pagenow'] == 'admin.php' && in_array($_GET['page'], $this->config->pages))
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        
        add_action('admin_menu', array($this, 'admin_menu'));
    }
    
    function admin_enqueue_scripts() {
        if (function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
        }
        
        wp_enqueue_style('bootstrap-fileupload', RWMs_URL . 'assets/css/bootstrap-fileupload.min.css');
        wp_enqueue_script('bootstrap-fileupload', RWMs_URL . 'assets/js/bootstrap-fileupload.min.js');
    }
    
    function admin_menu() {
        add_submenu_page(RWMs_SLUG, RWMs_NAME, 'Import / Export', 'manage_options', RWMs_PREFIX . 'import_export', array($this, 'render'));
    }
    
    function render() {
        global $pagenow;
        
        if ($pagenow == 'admin.php' && isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'export':
                    $rows = $this->slider->get_results();
            
                    $data = array();
                    foreach ($rows as $row) {
                        $data[] = (array) $row;
                    }
                    
                    header("Content-type: text/json");
                    header("Content-Disposition: attachment; filename=\"sliders.json\"");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    
                    echo json_encode($data);
                    
                    exit();
                    
                    break;
                    
                case 'import':
                    $upload_dir = wp_upload_dir();
                    $allowed_ext = array('json');
                    
                    $target = $upload_dir['basedir'] . '/' . basename($_FILES['uploadedfile']['name']);
                    
                    if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target)) {
                        $pathinfo = pathinfo($target);
                        if (in_array($pathinfo['extension'], $allowed_ext)) {
                            $json = json_decode(file_get_contents($target));
                            
                            $new_sliders = array();
                            foreach ($json as $obj) {
                                if ($this->slider->exists($obj->slider_id)) {
                                    $data = array(
                                        'slider_group_id' => $obj->slider_group_id,
                                        'slider_type' => $obj->slider_type,
                                        'slider_src' => $obj->slider_src,
                                        'slider_heading' => $obj->slider_heading . ' (Imported ' . date('Y-m-d @ h:i:s A', time()) . ')',
                                        'slider_subheading' => $obj->slider_subheading,
                                        'slider_text' => $obj->slider_text,
                                        'slider_text_pos' => $obj->slider_text_pos,
                                        'slider_btn_type' => $obj->slider_btn_type,
                                        'slider_btn_text' => $obj->slider_btn_text,
                                        'slider_btn_url' => $obj->slider_btn_url
                                    );
                                    
                                    $new_slider_id = $this->slider->import($data);
                                    $new_sliders[] = $new_slider_id;
                                }
                            }
                            
                            $sorted_sliders = get_option(RWMs_PREFIX . 'sliders');
                            $sorted_sliders = ( ! empty($sorted_sliders)) ? explode(',', $sorted_sliders) : '';
                            $merged_sliders = array_merge($sorted_sliders, $new_sliders);
                            update_option(RWMs_PREFIX . 'sliders', implode(',', $merged_sliders));
                            
                            $this->view->form_alert = 'success';
                            $this->view->form_message = '<strong>Success!</strong> All slider data has been successfully imported.';
                        }
                    } else {
                        $this->view->form_alert = 'error';
                        $this->view->form_message = '<strong>Error!</strong> Please select a file to import.';
                    }
                    
                    break;
            } // switch
        }
        
        $this->view->page = $_GET['page'];
        $this->view->render('import_export_page');
    }
}

/**
 * @filesource ./controllers/import_export.php
 */