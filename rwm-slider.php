<?php

/*
Plugin Name: RWM Slider Manager
Plugin URI: http://www.realworldmedia.com.au/
Description: Manage your slider entries with this neat plugin. Supports images, videos, and textual slides. 
Author: Real World Media
Version: 1.0.3
Author URI: http://www.realworldmedia.com.au/
*/

define('RWMs_VERSION', '1.0.3');
define('RWMs_DB_VERSION', '1.0.1');
define('RWMs_DIR', trailingslashit(plugin_dir_path(__FILE__)));
define('RWMs_URL', trailingslashit(plugin_dir_url(__FILE__)));
define('RWMs_FILE', __FILE__);
define('RWMs_NAME', 'RWM Slider Manager');
define('RWMs_SINGULAR', 'RWM Slider');
define('RWMs_SLUG', 'rwm_slider');
define('RWMs_PREFIX', 'rwms_');

require_once(RWMs_DIR . 'core/base_controller.php');
require_once(RWMs_DIR . 'core/view.php');
require_once(RWMs_DIR . 'core/config.php');
require_once(RWMs_DIR . 'models/migration_model.php');
require_once(RWMs_DIR . 'models/slider_model.php');
require_once(RWMs_DIR . 'controllers/migration.php'); new RWMs_Migration;
require_once(RWMs_DIR . 'controllers/admin_menu.php'); new RWMs_Admin_Menu;
require_once(RWMs_DIR . 'controllers/import_export.php'); new RWMs_Import_Export;
require_once(RWMs_DIR . 'api.php');

// ./rwm-slider.php