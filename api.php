<?php

if ( ! function_exists('rwm_sliders')) {
    function rwm_sliders() {
        $rwm = RWMs_Base_Controller::get_instance();
        
        $sorted_sliders = get_option(RWMs_PREFIX . 'sliders');
        $sorted_sliders = ( ! empty($sorted_sliders)) ? explode(',', $sorted_sliders) : '';
        
        $sliders = $rwm->slider->get_formatted_data();
        
        $data = array();
        foreach ($sorted_sliders as $sorted_slider) {
            $data[] = $sliders[$sorted_slider];
        }
        
        return $data;
    }
}

/**
 * @filesource ./api.php
 */