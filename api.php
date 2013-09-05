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
                
                /**
                 * Resize slider image
                 */
                $source = str_replace(site_url() . '/', '', $sliders[$sorted_slider]->slider_src);
                $sliders[$sorted_slider]->slider_src = rwm_resize_slider_image($source);
                
                /**
                 * Filter sliders and format array
                 */
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
    }
}

if ( ! function_exists('rwm_resize_slider_image')) {
    function rwm_resize_slider_image($source) {
        $image = wp_get_image_editor(ABSPATH . $source);
        
        $image_size = $image->get_size();
        $width = $image_size['width'];
        $height = $image_size['height'];
        
        if ($width > 900 || $height > 900) {
            if ($width > $height) {
                echo '> 900 / w > h';
                $x = $width / 900;
                $h = round($height / $x);
                //$image->crop(0, 0, 900, $h, 900, $h, false);
                $image->resize(900, $h);
                $filename = $image->generate_filename('slider');
                $image->save($filename);
            } else {
                echo '> 900 / h > w';
                $x = $height / 900;
                $w = round($width / $x);
                //$image->crop(0, 0, $w, 900, $w, 900, false);
                $image->resize($w, 900);
                $filename = $image->generate_filename('slider');
                $image->save($filename);
            }
        } else {
            if ($width > $height) {
                echo '< 900 / w > h';
                $x = 900 / $width;
                $h = round($height * $x);
                //$image->crop(0, 0, 900, $h, 900, $h, false);
                $image->resize(900, $h);
                $filename = $image->generate_filename('slider');
                $image->save($filename);
            } else {
                echo '< 900 / h > w';
                $x = 900 / $height;
                $w = round($width * $x);
                //$image->crop(0, 0, $w, 900, $w, 900, false);
                $image->resize($w, 900);
                $filename = $image->generate_filename('slider');
                $image->save($filename);
            }
        }
        
        return site_url() . '/' . str_replace(ABSPATH, '', $filename);
    }
}

/**
 * @filesource ./api.php
 */