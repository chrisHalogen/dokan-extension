jQuery(document).ready(function ($) {
  // Populate LGAs when state changes
  $("#bm-search-state").on("change", function () {
    const state = $(this).val();
    const lgaSelect = $("#bm-search-lga");

    lgaSelect.empty().prop("disabled", true);

    if (state) {
      const selectedState = bmSearchVars.states.find((s) => s.state === state);
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
});
