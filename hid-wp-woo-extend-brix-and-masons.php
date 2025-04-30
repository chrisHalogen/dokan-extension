<?php

/**
 * Plugin Name: HID WP woo-extend-brix-and-masons
 * Plugin URI:  https://github.com/chrisHalogen
 * Description: A wordpress plugin built to solve problems.
 * Version:     1.0.0
 * Author:      Christian Chi Nwikpo
 * Author URI:  https://github.com/chrisHalogen
 * License:     GPL-2.0+
 * Text Domain: hid-wp-woo-extend-brix-and-masons
 * Domain Path: /languages
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WOO_EXTEND_BRIX_AND_MASONS_VERSION', '1.0.0');
define('WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Include required files
require_once WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_DIR . 'functions.php';
require_once WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_DIR . 'ajax-functions.php';
require_once WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_DIR . 'db-functions.php';
require_once WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_DIR . 'includes/class-product-search.php';

// Include admin files
if (is_admin()) {
    require_once WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_DIR . 'admin/admin-functions.php';
}
