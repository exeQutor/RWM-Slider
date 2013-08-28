<?php

/**
 * @package RWMs API
 * @subpackage RWM Slider Manager
 * @author Randolph
 * @since 1.0.0
 */

if ( ! function_exists('rwm_sliders')) {
    function rwm_sliders($set_id = '') {
        $rwm = RWMs_Base_Controller::get_instance();
        
        $sorted_sliders = get_option(RWMs_PREFIX . 'sliders');
        $sorted_sliders = ( ! empty($sorted_sliders)) ? explode(',', $sorted_sliders) : '';
        
        $sliders = $rwm->slider->get_formatted_data($set_id);
        
        if ($sorted_sliders) {
            $data = array();
            foreach ($sorted_sliders as $sorted_slider) {
                if ( ! empty($set_id)) {
                    if ($sliders[$sorted_slider]->slider_group_id == $set_id)
                        $data[] = $sliders[$sorted_slider];
                } else {
                    $data[] = $sliders[$sorted_slider];
                }
            }
            
            return $sliders;
        }
    }
}

if ( ! function_exists('rwm_slider_groups')) {
    function rwm_slider_groups() {
        $rwm = RWMs_Base_Controller::get_instance();
        
        $groups = $rwm->slider->get_groups();
        
        return $groups;
        
        //if ($sorted_sliders) {
//            $data = array();
//            foreach ($sorted_sliders as $sorted_slider) {
//                $data[] = $sliders[$sorted_slider];
//            }
//            
//            return $data;
//        }
    }
}

/**
 * @filesource ./api.php
 */