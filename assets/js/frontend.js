/* Frontend JS for woo-extend-brix-and-masons plugin */
jQuery(document).ready(function ($) {
  // Example AJAX call
  $(".hid-wp-woo-extend-brix-and-masons-ajax-trigger").on(
    "click",
    function (e) {
      e.preventDefault();

      var data = {
        action: "woo_extend_brix_and_masons_example_ajax",
        nonce: woo_extend_brix_and_masons_frontend_obj.nonce,
        some_data: "example data",
      };

      $.post(
        woo_extend_brix_and_masons_frontend_obj.ajax_url,
        data,
        function (response) {
          console.log("AJAX response:", response);
        }
      ).fail(function (xhr, status, error) {
        console.error("AJAX error:", error);
      });
    }
  );

  if ($("#nigeria-location-selector-container").length) {
    // Initialize with the data from PHP
    const nigerianLGAs = {};

    // Transform the data for easier access
    plugin_vars.states_lgas.forEach(function (stateData) {
      nigerianLGAs[stateData.state] = stateData.lgas;
    });

    // State selection handler
    $("#state-select").on("change", function () {
      const state = $(this).val();
      const lgaContainer = $("#lga-display-container");
      const lgaList = $("#lga-list");

      lgaList.empty();

      if (state && nigerianLGAs[state]) {
        // Show the container
        lgaContainer.show();

        // Update selected state name
        $("#selected-state-name").text(state);

        // Create a copy of the LGAs array to avoid modifying the original
        const lgas = [...nigerianLGAs[state]];
        const lgaGroups = [];

        // Split LGAs into groups of 4 for better layout
        while (lgas.length > 0) {
          lgaGroups.push(lgas.slice(0, 4)); // Use slice instead of splice
          lgas.splice(0, 4); // Now we can safely modify our copy
        }

        // Create a responsive grid
        const grid = $('<div class="lga-grid"></div>');

        lgaGroups.forEach(function (group) {
          const row = $('<div class="lga-row"></div>');

          group.forEach(function (lga) {
            row.append('<div class="lga-item">' + lga + "</div>");
          });

          grid.append(row);
        });

        lgaList.append(grid);
      } else {
        // Hide the container if no state selected
        lgaContainer.hide();
      }
    });
  }

  if ($("#bm-product-search-form").length) {
    // Populate LGAs when state changes
    $("#bm-search-state").on("change", function () {
      const state = $(this).val();
      const lgaSelect = $("#bm-search-lga");

      lgaSelect.empty().prop("disabled", true);

      if (state) {
        const selectedState = plugin_vars.states_lgas.find(
          (s) => s.state === state
        );
        if (selectedState && selectedState.lgas) {
          lgaSelect.append('<option value="">Select LGA</option>');
          selectedState.lgas.forEach((lga) => {
            lgaSelect.append(`<option value="${lga}">${lga}</option>`);
          });
          lgaSelect.prop("disabled", false);
        }
      } else {
        lgaSelect.append('<option value="">Select State First</option>');
      }
    });

    // Preselect values if coming from search results
    const urlParams = new URLSearchParams(window.location.search);
    const stateParam = urlParams.get("project_state");

    if (stateParam) {
      $("#bm-search-state").val(stateParam).trigger("change");

      // Need timeout to ensure LGAs are loaded before selecting
      setTimeout(() => {
        const lgaParam = urlParams.get("project_lga");
        if (lgaParam) $("#bm-search-lga").val(lgaParam);
      }, 300);
    }
  }
});
