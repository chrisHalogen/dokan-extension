<?php
/**
 * Database related functions for woo-extend-brix-and-masons plugin.
 *
 * @package hid-wp-woo-extend-brix-and-masons
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Create custom tables on plugin activation.
 */
function woo_extend_brix_and_masons_create_tables() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . "woo_extend_brix_and_masons_data";

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        value longtext NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
// register_activation_hook(__FILE__, 'woo_extend_brix_and_masons_create_tables');
