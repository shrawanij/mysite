<div class="ec_admin_slideout_container" id="new_option_box">
    <div class="ec_admin_slideout_container_content">
        <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_new_optionset_display_loader" ); ?>
        <header class="ec_admin_slideout_container_content_header">
            <div class="ec_admin_slideout_container_content_header_inner">
                <h3>Create a Basic Option Set</h3>
                <div class="ec_admin_slideout_close" onclick="wp_easycart_admin_close_slideout( 'new_option_box' );">
                    <div class="dashicons-before dashicons-no-alt"></div>
                </div>
            </div>
        </header>
        <div class="ec_admin_slideout_container_content_inner">
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_option_type">Option Type</label>
                <div>
                    <select id="ec_new_option_type" name="ec_new_option_type" class="select2-basic">
                        <option value="0">Select One</option>
                        <option value="basic-combo">Combo / Select Box</option>
                        <option value="basic-swatch">Swatches</option>
                    </select>
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_option_name">Option Name (Internal Use)</label>
                <div>
                    <input type="text" id="ec_new_option_name" name="ec_new_option_name" placeholder="Product Shirt Sizes" />
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_option_label">Option Label</label>
                <div>
                    <input type="text" id="ec_new_option_label" name="ec_new_option_label" placeholder="Select a Shirt Size" />
                </div>
            </div>
        </div>
        <footer class="ec_admin_slideout_container_content_footer">
            <div class="ec_admin_slideout_container_content_footer_inner">
                <div class="ec_admin_slideout_container_content_footer_inner_body">
                    <ul>
                        <li>
                            <button onclick="ec_admin_save_new_optionset( );">
                                <span>Create Optionset</span>
                            </button>
                        </li>
                        <li>
                            <button class="ec_footer_slideout_button_alt" onclick="wp_easycart_admin_close_slideout( 'new_option_box' );">
                                <span>Cancel</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>jQuery( document.getElementById( 'new_option_box' ) ).appendTo( document.body );</script>