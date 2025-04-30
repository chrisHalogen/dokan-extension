<?php
/**
 * Admin file for woo-extend-brix-and-masons plugin.
 *
 * @package hid-wp-woo-extend-brix-and-masons
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Add admin menu page.
 */
function woo_extend_brix_and_masons_add_admin_menu() {
    add_menu_page(
        'woo-extend-brix-and-masons Settings',
        'woo-extend-brix-and-masons',
        'manage_options',
        'hid-wp-woo-extend-brix-and-masons-settings',
        'woo_extend_brix_and_masons_admin_page_callback',
        'dashicons-admin-generic',
        80
    );
}
add_action('admin_menu', 'woo_extend_brix_and_masons_add_admin_menu');

/**
 * Admin page callback.
 */
function woo_extend_brix_and_masons_admin_page_callback() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <div class="hid-wp-woo-extend-brix-and-masons-admin-content">
            <p>Welcome to woo-extend-brix-and-masons plugin settings page.</p>
        </div>
    </div>
    <?php
}
