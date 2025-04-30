<?php

/**
 * Main functions file for woo-extend-brix-and-masons plugin.
 *
 * @package hid-wp-woo-extend-brix-and-masons
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Enqueue scripts and styles.
 */
function woo_extend_brix_and_masons_enqueue_scripts()
{
    // Frontend CSS
    wp_enqueue_style(
        'hid-wp-woo-extend-brix-and-masons-frontend-style',
        WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_URL . 'assets/css/frontend.css',
        array(),
        WOO_EXTEND_BRIX_AND_MASONS_VERSION
    );

    // Frontend JS
    wp_enqueue_script(
        'hid-wp-woo-extend-brix-and-masons-frontend-script',
        WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_URL . 'assets/js/frontend.js',
        array('jquery'),
        WOO_EXTEND_BRIX_AND_MASONS_VERSION,
        true
    );

    // Get the states/LGAs data
    $states_lgas = json_decode(file_get_contents(plugin_dir_path(__FILE__) . 'assets/data/nigeria-states-and-local-govts.json'), true);

    // Localize script
    wp_localize_script(
        'hid-wp-woo-extend-brix-and-masons-frontend-script',
        'plugin_vars',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('hid-wp-woo-extend-brix-and-masons-frontend-nonce'),
            'states_lgas' => $states_lgas
        )
    );

    // Admin assets
    if (is_admin()) {
        wp_enqueue_style(
            'hid-wp-woo-extend-brix-and-masons-admin-style',
            WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            WOO_EXTEND_BRIX_AND_MASONS_VERSION
        );

        wp_enqueue_script(
            'hid-wp-woo-extend-brix-and-masons-admin-script',
            WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            WOO_EXTEND_BRIX_AND_MASONS_VERSION,
            true
        );

        wp_localize_script(
            'hid-wp-woo-extend-brix-and-masons-admin-script',
            'woo_extend_brix_and_masons_admin_obj',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('hid-wp-woo-extend-brix-and-masons-admin-nonce'),
            )
        );
    }
}
add_action('wp_enqueue_scripts', 'woo_extend_brix_and_masons_enqueue_scripts');
add_action('admin_enqueue_scripts', 'woo_extend_brix_and_masons_enqueue_scripts');

// Register shortcode
add_shortcode('nigeria_location_selector', 'hid_render_location_selector');

function hid_render_location_selector()
{
    // Get the states/LGAs data
    $states_lgas = json_decode(file_get_contents(plugin_dir_path(__FILE__) . 'assets/data/nigeria-states-and-local-govts.json'), true);

    // Start output buffering
    ob_start();

    // Include the template file
    include plugin_dir_path(__FILE__) . 'templates/nigeria-location-selector.php';

    // Return the buffered content
    return ob_get_clean();
}


/**
 * Override shop page template
 */
add_filter('template_include', 'hid_woo_custom_shop_template', 99);

function hid_woo_custom_shop_template($template)
{
    if (is_shop() || is_product_category() || is_product_tag()) {
        $plugin_path = plugin_dir_path(__FILE__) . 'templates/archive-product.php';

        if (file_exists($plugin_path)) {
            return $plugin_path;
        }
    }

    return $template;
}


// Location Based Sorting
add_filter('posts_clauses', 'bm_sort_by_location', 10, 2);
function bm_sort_by_location($clauses, $query)
{
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('product')) {
        $state = sanitize_text_field($_GET['project_state'] ?? '');
        $lga = sanitize_text_field($_GET['project_lga'] ?? '');

        if ($state || $lga) {
            global $wpdb;

            // This is a simplified example - you'll need to:
            // 1. Store vendor locations (state/LGA) in user meta
            // 2. Join with user data
            // 3. Add sorting logic

            $clauses['join'] .= " LEFT JOIN {$wpdb->usermeta} AS vendor_state ON (
                {$wpdb->posts}.post_author = vendor_state.user_id 
                AND vendor_state.meta_key = 'vendor_state'
            )";

            $clauses['join'] .= " LEFT JOIN {$wpdb->usermeta} AS vendor_lga ON (
                {$wpdb->posts}.post_author = vendor_lga.user_id 
                AND vendor_lga.meta_key = 'vendor_lga'
            )";

            // Simple sorting - prioritize exact matches first
            $clauses['orderby'] = " 
                CASE 
                    WHEN vendor_state.meta_value = '{$state}' AND vendor_lga.meta_value = '{$lga}' THEN 0
                    WHEN vendor_state.meta_value = '{$state}' THEN 1
                    ELSE 2
                END, " . $clauses['orderby'];
        }
    }
    return $clauses;
}
