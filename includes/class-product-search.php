<?php

class BM_Product_Search
{
    public function __construct()
    {
        add_shortcode('bm_product_search', [$this, 'search_form_shortcode']);
        // add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets()
    {
        wp_enqueue_style('bm-product-search', WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_DIR . 'assets/css/product-search.css');

        wp_enqueue_script('bm-product-search', WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_DIR . 'assets/js/product-search.js', ['jquery'], null, true);

        wp_localize_script('bm-product-search', 'bmSearchVars', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'states' => $this->get_nigerian_states()
        ]);
    }

    public function search_form_shortcode()
    {
        ob_start();
?>
        <form id="bm-product-search-form" class="bm-product-search-form" action="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" method="get">
            <div class="bm-search-field">
                <label for="bm-search-keyword">Product Name</label>
                <input type="text" id="bm-search-keyword" name="s" placeholder="Search for products...">
            </div>

            <div class="bm-search-field">
                <label for="bm-search-state">Project State</label>
                <select id="bm-search-state" name="project_state">
                    <option value="">Select State</option>
                    <?php foreach ($this->get_nigerian_states() as $state): ?>
                        <option value="<?php echo esc_attr($state['state']); ?>">
                            <?php echo esc_html($state['state']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="bm-search-field">
                <label for="bm-search-lga">Project LGA</label>
                <select id="bm-search-lga" name="project_lga" disabled>
                    <option value="">Select State First</option>
                </select>
            </div>

            <div class="bm-search-field">
                <label for="bm-search-category">Product Category</label>
                <?php
                wp_dropdown_categories([
                    'show_option_all' => 'All Categories',
                    'taxonomy' => 'product_cat',
                    'name' => 'product_cat',
                    'id' => 'bm-search-category',
                    'value_field' => 'slug',
                    'hierarchical' => true
                ]);
                ?>
            </div>

            <input type="hidden" name="post_type" value="product">
            <button type="submit" class="bm-search-button">Find Products</button>
        </form>
<?php
        return ob_get_clean();
    }

    private function get_nigerian_states()
    {
        $json = file_get_contents(WOO_EXTEND_BRIX_AND_MASONS_PLUGIN_DIR . 'assets/data/nigeria-states-and-local-govts.json');
        return json_decode($json, true);
    }
}
new BM_Product_Search();
