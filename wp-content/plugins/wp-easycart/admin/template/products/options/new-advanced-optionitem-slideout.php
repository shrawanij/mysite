<div class="ec_admin_slideout_container" id="new_adv_optionitem_box">
    <div class="ec_admin_slideout_container_content">
        <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_new_adv_optionitem_display_loader" ); ?>
        <header class="ec_admin_slideout_container_content_header">
            <div class="ec_admin_slideout_container_content_header_inner">
                <h3>Create an Option Item</h3>
                <div class="ec_admin_slideout_close" onclick="wp_easycart_admin_close_slideout( 'new_adv_optionitem_box' );">
                    <div class="dashicons-before dashicons-no-alt"></div>
                </div>
            </div>
        </header>
        <input type="hidden" id="ec_new_adv_optionitem_option_id" value="0" />
        <input type="hidden" id="ec_new_adv_optionitem_option_type" value="" />
        <input type="hidden" id="ec_new_adv_optionitem_sort_order" value="0" />
        <div class="ec_admin_slideout_container_content_inner">
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_adv_optionitem_name">Option Item Name</label>
                <div>
                    <input type="text" id="ec_new_adv_optionitem_name" name="ec_new_adv_optionitem_name" placeholder="Small" />
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_adv_optionitem_model_number_extension">Model Number Extension (Optional - Extends Model Number in Cart)</label>
                <div>
                    <input type="text" id="ec_new_adv_optionitem_model_number_extension" name="ec_new_adv_optionitem_model_number_extension" placeholder="XL" />
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row" id="ec_admin_adv_optionitem_initially_selected_row" style="display:none;">
                <input type="checkbox" id="ec_admin_adv_optionitem_initially_selected" name="ec_admin_adv_optionitem_initially_selected" value="1" />
                <label for="ec_admin_adv_optionitem_initially_selected">Initially Selected?</label>
            </div>
            <div class="ec_admin_slideout_container_input_row" id="ec_admin_adv_optionitem_allows_download_row" style="display:none;">
                <input type="checkbox" id="ec_admin_adv_optionitem_allows_download" name="ec_admin_adv_optionitem_allows_download" value="1" />
                <label for="ec_admin_adv_optionitem_allows_download">Option Allows Product Download?</label>
            </div>
            <div class="ec_admin_slideout_container_input_row" id="ec_admin_adv_optionitem_no_shipping_row" style="display:none;">
                <input type="checkbox" id="ec_admin_adv_optionitem_no_shipping" name="ec_admin_adv_optionitem_no_shipping" value="1" />
                <label for="ec_admin_adv_optionitem_no_shipping">Option Makes NO Shipping on Product</label>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_adv_optionitem_price">Price Adjustment Type</label>
                <div>
                    <select id="ec_new_adv_optionitem_price" name="ec_new_adv_optionitem_price" class="select2-basic" onchange="ec_admin_update_advanced_optionitem_price_fields( );">
                        <option value="0">No Price Adjustments</option>
                        <option value="basic_price">Basic Price Adjustment</option>
                        <option value="one_time_price">One-Time Price Adjustment</option>
                        <option value="override_price">Product Price Override</option>
                        <option value="multiplier_price">Product Price Multiplier</option>
                    </select>
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row" id="ec_new_adv_optionitem_price_adjustment_row" style="display:none;">
                <label for="ec_new_adv_optionitem_price_adjustment">Price Adjustment (+/-)</label>
                <div>
                    <input type="text" id="ec_new_adv_optionitem_price_adjustment" name="ec_new_adv_optionitem_price_adjustment" placeholder="0.00" />
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_adv_optionitem_weight">Weight Adjustment Type</label>
                <div>
                    <select id="ec_new_adv_optionitem_weight" name="ec_new_adv_optionitem_weight" class="select2-basic" onchange="ec_admin_update_advanced_optionitem_weight_fields( );">
                        <option value="0">No Price Adjustments</option>
                        <option value="basic_weight">Basic Weight Adjustment</option>
                        <option value="one_time_weight">One-Time Weight Adjustment</option>
                        <option value="override_weight">Product Weight Override</option>
                        <option value="multiplier_weight">Product Weight Multiplier</option>
                    </select>
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row" id="ec_new_adv_optionitem_weight_adjustment_row" style="display:none;">
                <label for="ec_new_adv_optionitem_weight_adjustment">Weight Adjustment (+/-)</label>
                <div>
                    <input type="text" id="ec_new_adv_optionitem_weight_adjustment" name="ec_new_adv_optionitem_weight_adjustment" placeholder="0.00" />
                </div>
            </div>
        </div>
        <footer class="ec_admin_slideout_container_content_footer">
            <div class="ec_admin_slideout_container_content_footer_inner">
                <div class="ec_admin_slideout_container_content_footer_inner_body">
                    <ul>
                        <li>
                            <button onclick="ec_admin_save_new_adv_optionitem( true );">
                                <span>Create and add another</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="ec_admin_save_new_adv_optionitem( false );">
                                <span>Create and Close</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>jQuery( document.getElementById( 'new_adv_optionitem_box' ) ).appendTo( document.body );</script>