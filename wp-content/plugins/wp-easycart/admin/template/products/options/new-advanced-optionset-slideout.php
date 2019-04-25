<div class="ec_admin_slideout_container" id="new_adv_option_box">
    <div class="ec_admin_slideout_container_content">
        <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_new_adv_optionset_display_loader" ); ?>
        <header class="ec_admin_slideout_container_content_header">
            <div class="ec_admin_slideout_container_content_header_inner">
                <h3>Create a Advanced Option Set</h3>
                <div class="ec_admin_slideout_close" onclick="wp_easycart_admin_close_slideout( 'new_adv_option_box' );">
                    <div class="dashicons-before dashicons-no-alt"></div>
                </div>
            </div>
        </header>
        <div class="ec_admin_slideout_container_content_inner">
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_adv_option_type">Option Type</label>
                <div>
                    <select id="ec_new_adv_option_type" name="ec_new_adv_option_type" class="select2-basic" onchange="ec_admin_update_advanced_option_fields( );">
                        <option value="0">Select One</option>
                        <option value="combo">Combo / Select Box</option>
                        <option value="swatch">Swatches</option>
                        <option value="text">Text Input</option>
                        <option value="textarea">Text Area (Multi-line)</option>
                        <option value="number">Number Input</option>
                        <option value="file">File Upload</option>
                        <option value="radio">Radio Group</option>
                        <option value="checkbox">Checkbox Group</option>
                        <option value="grid">Quantity Grid</option>
                        <option value="date">Date Input</option>
                        <option value="dimensions1">Dimensions (Whole Inch)</option>
                        <option value="dimensions2">Dimensions (Sub-Inch)</option>
                    </select>
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_adv_option_name">Option Name (Internal Use)</label>
                <div>
                    <input type="text" id="ec_new_adv_option_name" name="ec_new_adv_option_name" placeholder="Product Shirt Sizes" />
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_adv_option_label">Option Label</label>
                <div>
                    <input type="text" id="ec_new_adv_option_label" name="ec_new_adv_option_label" placeholder="Select a Shirt Size" />
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row" style="display:none;" id="ec_new_adv_option_meta_min_row">
                <label for="ec_new_adv_option_meta_min">Minimum Value (leave blank for no minimum)</label>
                <div>
                    <input type="text" id="ec_new_adv_option_meta_min" name="ec_new_adv_option_meta_min" />
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row" style="display:none;" id="ec_new_adv_option_meta_max_row">
                <label for="ec_new_adv_option_meta_max">Maximum Value (leave blank for no maximum)</label>
                <div>
                    <input type="text" id="ec_new_adv_option_meta_max" name="ec_new_adv_option_meta_max" />
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row" style="display:none;" id="ec_new_adv_option_meta_step_row">
                <label for="ec_new_adv_option_meta_step">Step (e.g. .01 | .1 | 1 | 5...)</label>
                <div>
                    <input type="text" id="ec_new_adv_option_meta_step" name="ec_new_adv_option_meta_step" />
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <input type="checkbox" id="ec_new_adv_option_required" name="ec_new_adv_option_required" value="1" onchange="ec_admin_update_advanced_option_required_field( );" />
                <label for="ec_new_adv_option_required">Is Option Required?</label>
            </div>
            <div class="ec_admin_slideout_container_input_row" style="display:none;" id="ec_new_adv_option_error_text_row">
                <label for="ec_new_adv_option_error_text">Error Message</label>
                <div>
                    <input type="text" id="ec_new_adv_option_error_text" name="ec_new_adv_option_error_text" placeholder="Please select a shirt size" />
                </div>
            </div>
        </div>
        <footer class="ec_admin_slideout_container_content_footer">
            <div class="ec_admin_slideout_container_content_footer_inner">
                <div class="ec_admin_slideout_container_content_footer_inner_body">
                    <ul>
                        <li>
                            <button onclick="ec_admin_save_new_adv_optionset( );">
                                <span>Create Optionset</span>
                            </button>
                        </li>
                        <li>
                            <button class="ec_footer_slideout_button_alt" onclick="wp_easycart_admin_close_slideout( 'new_adv_option_box' );">
                                <span>Cancel</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>jQuery( document.getElementById( 'new_adv_option_box' ) ).appendTo( document.body );</script>