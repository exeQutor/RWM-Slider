<?php

/**
 * @package RWM Framework\Slider Manager\API
 * @author Randolph
 * @since 1.0.2
 */

if ( ! function_exists('rwm_sliders')) {
    function rwm_sliders($group_id = '') {
        $rwm = RWMs_Base_Controller::get_instance();
        
        $sorted_sliders = get_option(RWMs_PREFIX . 'sliders');
        $sorted_sliders = ( ! empty($sorted_sliders)) ? explode(',', $sorted_sliders) : '';
        
        $sorted_sliders2 = array();
        
        $sliders = $rwm->slider->get_formatted_data($group_id);
        
        foreach ($sorted_sliders as $sorted_slider) {
            if (array_key_exists($sorted_slider, $sliders))
                $sorted_sliders2[] = $sorted_slider;
        }
        
        if ($sorted_sliders) {
            $data = array();
            foreach ($sorted_sliders2 as $sorted_slider) {
                
                /**
                 * @since 1.0.7
                 */
                $sliders[$sorted_slider]->slider_heading = stripslashes($sliders[$sorted_slider]->slider_heading);
                $sliders[$sorted_slider]->slider_subheading = stripslashes($sliders[$sorted_slider]->slider_subheading);
                $sliders[$sorted_slider]->slider_text = stripslashes($sliders[$sorted_slider]->slider_text);
                
                /**
                 * Start resize of slider image
                 */
                $source = str_replace(site_url() . '/', '', $sliders[$sorted_slider]->slider_src);
                
                /**
                 * Resize only if slider type is image
                 * @since 1.0.6
                 */
                if ($sliders[$sorted_slider]->slider_type == 'image')
                    $sliders[$sorted_slider]->slider_src = rwm_resize_slider_image($source);
                
                /**
                 * Textbox background
                 * If inherit, get global equivalent
                 */
                $textbox_bg = $sliders[$sorted_slider]->slider_textbox_bg;
                if ($textbox_bg == 'inherit') {
                    if (function_exists('rwm_option2')) {
                        $textbox_bg = rwm_option2('slider_textbox_bg');
                    } else {
                        $textbox_bg = 'solid';
                    }
                    
                    $sliders[$sorted_slider]->slider_textbox_bg = $textbox_bg;
                }
                
                /**
                 * Filter sliders and format array
                 */
                if ( ! empty($group_id)) {
                    /**
                     * Updated to use slider_group instead of slider_group_id (which is non-existent)
                     * @since 1.0.8
                     */
                    if (in_array($group_id, $sliders[$sorted_slider]->slider_group))
                        $data[] = $sliders[$sorted_slider];
                } else {
                    $data[] = $sliders[$sorted_slider];
                }
            }
            
            return $data;
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
	$imagesize = getimagesize(ABSPATH. $source);
	if( $imagesize[0] <= 1200 ){
		// do nothing
		return site_url() . '/' . $source;
	}else{
		$image = wp_get_image_editor(ABSPATH . $source);

			if( is_wp_error($image) )
				return false;
		
		$image_size = $image->get_size();
		$width = $image_size['width'];
		$height = $image_size['height'];
		
		$max_img_size = ($width > 980 || $height > 980) ? 1200 : 980;
		
		if ($width > $max_img_size || $height > $max_img_size) {
		    if ($width > $height) {
			$x = $width / $max_img_size;
			$h = round($height / $x);
			$image->resize($max_img_size, $h);
		    } else {
			$x = $height / $max_img_size;
			$w = round($width / $x);
			$image->resize($w, $max_img_size);
		    }
		} else {
		    if ($width > $height) {
			$x = $max_img_size / $width;
			$h = round($height * $x);
			$image->resize($max_img_size, $h);
		    } else {
			$x = $max_img_size / $height;
			$w = round($width * $x);
			$image->resize($w, $max_img_size);
		    }
		}
		
		$filename = $image->generate_filename('slider');
		$image->save($filename);
        
		return site_url() . '/' . str_replace(ABSPATH, '', $filename);
	}
    }
}
