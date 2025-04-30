/* Admin JS for woo-extend-brix-and-masons plugin */
jQuery(document).ready(function($) {
    // Example admin AJAX call
    $(".hid-wp-woo-extend-brix-and-masons-admin-ajax-trigger").on("click", function(e) {
        e.preventDefault();
        
        var data = {
            action: "woo_extend_brix_and_masons_admin_example_ajax",
            nonce: woo_extend_brix_and_masons_admin_obj.nonce,
            admin_data: "example admin data"
        };
        
        $.post(woo_extend_brix_and_masons_admin_obj.ajax_url, data, function(response) {
            console.log("Admin AJAX response:", response);
        }).fail(function(xhr, status, error) {
            console.error("Admin AJAX error:", error);
        });
    });
});
