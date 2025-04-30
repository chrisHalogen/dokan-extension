<?php

/**
 * Nigeria States/LGAs Display Template
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="nigeria-location-selector-container" id="nigeria-location-selector-container">
    <h2>Nigeria Location Selector</h2>

    <div class="location-selector-form">
        <div class="form-group">
            <label for="state-select">Select State:</label>
            <select id="state-select" class="form-control">
                <option value="">-- Choose a State --</option>
                <?php foreach ($states_lgas as $state_data) : ?>
                    <option value="<?php echo esc_attr($state_data['state']); ?>">
                        <?php echo esc_html($state_data['state']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div id="lga-display-container" class="lga-display-container" style="display: none;">
        <h3>Local Governments in <span id="selected-state-name"></span></h3>
        <div id="lga-list" class="lga-list"></div>
    </div>
</div>

<?php
