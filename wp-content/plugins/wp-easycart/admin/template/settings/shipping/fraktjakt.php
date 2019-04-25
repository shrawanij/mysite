<div class="ec_admin_settings_panel ec_admin_settings_shipping_section ec_admin_settings_<?php if( wp_easycart_admin( )->settings->shipping_method == "fraktjakt" ){ ?>show<?php }else{?>hide<?php }?>" id="fraktjakt">

	<div class="ec_admin_flex_row" style="padding:5px 15px;">
        
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
                    
            <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-site"></div><span>Fraktjakt Setup</span></div>
            
            <div class="ec_admin_settings_input ec_admin_settings_fraktjakt_section">
                <span>Customer ID</span>
                <div><input type="text" class="ec_admin_live_label_input ec_admin_input_no_upper" name="fraktjakt_customer_id" id="fraktjakt_customer_id" value="<?php echo wp_easycart_admin( )->settings->fraktjakt_customer_id; ?>" /></div>
            </div>
            
            <div class="ec_admin_settings_input ec_admin_settings_fraktjakt_section">
                <span>Login Key</span>
                <div><input type="text" class="ec_admin_live_label_input ec_admin_input_no_upper" name="fraktjakt_login_key" id="fraktjakt_login_key" value="<?php echo wp_easycart_admin( )->settings->fraktjakt_login_key; ?>" /></div>
            </div>
            
            <div class="ec_admin_settings_input ec_admin_settings_fraktjakt_section">
                <span>Conversion Rate</span>
                <div><input type="text" name="fraktjakt_conversion_rate" id="fraktjakt_conversion_rate" value="<?php echo wp_easycart_admin( )->settings->fraktjakt_conversion_rate; ?>" placeholder="1.000" /></div>
            </div>
            
            <div class="ec_admin_settings_input ec_admin_settings_fraktjakt_section">
                <span><input type="checkbox" name="fraktjakt_test_mode" id="fraktjakt_test_mode" value="1"<?php if( wp_easycart_admin( )->settings->fraktjakt_test_mode ){ ?> checked="checked"<?php }?> />Test Mode</span>
            </div>
            
            <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-location-alt"></div><span>Initial Shipping Address</span></div>
            
            <div class="ec_admin_settings_input ec_admin_settings_fraktjakt_section">
                <span>Address</span>
                <div><input type="text" name="fraktjakt_address" id="fraktjakt_address" value="<?php echo wp_easycart_admin( )->settings->fraktjakt_address; ?>" /></div>
            </div>
            
            <div class="ec_admin_settings_input ec_admin_settings_fraktjakt_section">
                <span>City</span>
                <div><input type="text" name="fraktjakt_city" id="fraktjakt_city" value="<?php echo wp_easycart_admin( )->settings->fraktjakt_city; ?>" /></div>
            </div>
            
            <div class="ec_admin_settings_input ec_admin_settings_fraktjakt_section">
                <span>State</span>
                <div><input type="text" name="fraktjakt_state" id="fraktjakt_state" value="<?php echo wp_easycart_admin( )->settings->fraktjakt_state; ?>" maxlength="2" /></div>
                <div>2 Digit State Code</div>
            </div>
            
            <div class="ec_admin_settings_input ec_admin_settings_fraktjakt_section">
                <span>Postal Code</span>
                <div><input type="text" name="fraktjakt_zip" id="fraktjakt_zip" value="<?php echo wp_easycart_admin( )->settings->fraktjakt_zip; ?>" /></div>
            </div>
            
            <div class="ec_admin_settings_input ec_admin_settings_fraktjakt_section">
                <span>Country</span>
                <div><input type="text" name="fraktjakt_country" id="fraktjakt_country" value="<?php echo wp_easycart_admin( )->settings->fraktjakt_country; ?>" maxlength="2" /></div>
                <div>2 Digit Country Code</div>
            </div>
            
            <div class="ec_admin_settings_input">
                <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_fraktjakt_options( );" value="Save Options" />
            </div>
            
        </div>
            
    </div>
    
</div>