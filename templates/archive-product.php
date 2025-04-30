<?php

/**
 * Custom Archive Product Template for Brix & Masons
 */

get_header(); ?>

<div class="bm-archive-container">
    <?php
    // Display the search form at the top
    echo do_shortcode('[bm_product_search]');

    // Handle the product query based on search parameters
    $search_query = get_search_query();
    $project_state = sanitize_text_field($_GET['project_state'] ?? '');
    $project_lga = sanitize_text_field($_GET['project_lga'] ?? '');
    $product_cat = sanitize_text_field($_GET['product_cat'] ?? '');

    // Modify the main query
    add_action('pre_get_posts', function ($query) use ($search_query, $project_state, $project_lga, $product_cat) {
        if (!is_admin() && $query->is_main_query() && is_post_type_archive('product')) {
            // Search keyword
            if (!empty($search_query)) {
                $query->set('s', $search_query);
            }

            // Product category
            if (!empty($product_cat)) {
                $query->set('tax_query', [
                    [
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $product_cat
                    ]
                ]);
            }

            // Location-based sorting would require custom implementation
            // based on how you store vendor locations
        }
    });

    // Display the products
    if (woocommerce_product_loop()) {
        woocommerce_product_loop_start();

        while (have_posts()) {
            the_post();
            wc_get_template_part('content', 'product');
        }

        woocommerce_product_loop_end();

        // Pagination
        woocommerce_pagination();
    } else {
        echo '<div class="bm-no-results">';
        echo '<h3>No products found</h3>';
        echo '<p>Try adjusting your search filters</p>';
        echo '</div>';
    }
    ?>
</div>

<?php get_footer(); ?>