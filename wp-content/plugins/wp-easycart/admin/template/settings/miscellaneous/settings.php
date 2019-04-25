<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_miscellaneous_additional_options_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-generic"></div><span>Additional Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'additional-settings', 'additional-options');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'additional-settings', 'additional-options');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        <div>Show Cart Icon in Menu<select multiple name="ec_option_cart_menu_id" id="ec_option_cart_menu_id">
            <option value="0"<?php if( get_option('ec_option_cart_menu_id') == "0" ){ echo " selected=\"selected\""; }?>>No Menu</option>
            <?php 
            $ids = explode( '***', get_option('ec_option_cart_menu_id') );
            
            $menus = get_registered_nav_menus( );
            $keys = array_keys( $menus );
            foreach ( $keys as $key ) {
                echo '<option value="' . $key . '"';
                if( in_array( $key, $ids ) ){ 
                    echo " selected=\"selected\""; 
                }
                echo '>' . $menus[$key] . '</option>';
            }
            ?>
    	</select>
        </div>
        <div><input type="checkbox" name="ec_option_hide_cart_icon_on_empty" id="ec_option_hide_cart_icon_on_empty" value="1"<?php if( get_option('ec_option_hide_cart_icon_on_empty') == "1" ){ echo " checked=\"checked\""; }?> /> Hide Menu's Cart Icon for Empty Cart</div>
    	<div><input type="checkbox" name="ec_option_enable_newsletter_popup" id="ec_option_enable_newsletter_popup" value="1"<?php if( get_option('ec_option_enable_newsletter_popup') == "1" ){ echo " checked=\"checked\""; }?> /> Show Newsletter Signup Popup</div>
    	<div><input type="checkbox" name="ec_option_enable_gateway_log" id="ec_option_enable_gateway_log" value="0"<?php if( get_option('ec_option_enable_gateway_log') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Gateway Log
        <a href="admin.php?page=wp-easycart-settings&subpage=logs" >View Log</a> |  
        <a href="admin.php?page=wp-easycart-settings&subpage=miscellaneous&ec_admin_form_action=ec_delete_gateway_log">Delete Log File</a>
        </div>
    	<div><input type="checkbox" name="ec_option_use_inquiry_form" id="ec_option_use_inquiry_form" value="1"<?php if( get_option('ec_option_use_inquiry_form') == "1" ){ echo " checked=\"checked\""; }?> /> Inquiry Submit POST Variables</div>
        <div><input type="checkbox" name="ec_option_packing_slip_show_pricing" id="ec_option_packing_slip_show_pricing" value="1"<?php if( get_option('ec_option_packing_slip_show_pricing') == "1" ){ echo " checked=\"checked\""; }?> /> Show pricing on packing slip</div>
        <div><input type="checkbox" name="ec_option_use_old_linking_style" id="ec_option_use_old_linking_style" value="1"<?php if( get_option('ec_option_use_old_linking_style') == "0" ){ echo " checked=\"checked\""; }?> /> Use Custom Post Type Linking (recommended)</div>
    	<div><input type="checkbox" name="ec_option_deconetwork_allow_blank_products" id="ec_option_deconetwork_allow_blank_products" value="1"<?php if( get_option('ec_option_deconetwork_allow_blank_products') == "1" ){ echo " checked=\"checked\""; }?> /> DecoNetwork - Allow Blank Item Purchase</div>
    	<div><input type="checkbox" name="ec_option_allow_tracking" id="ec_option_allow_tracking" value="1"<?php if( get_option('ec_option_allow_tracking') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Basic Usage Data Tracking for WP EasyCart</div>
    	<div>Abandoned Cart Email, Send After x Days<input type="number" style="float:left;" name="ec_option_abandoned_cart_days" id="ec_option_abandoned_cart_days" value="<?php echo get_option( 'ec_option_abandoned_cart_days' ); ?>" min="1" placeholder="Enter an Integer" /></div>
    	<div>Clear statistics for product views and menu clicks?  <a href="#" onclick="return ec_admin_ajax_clear_stats( );">Clear Stats</a></div>
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_additional_options( );" value="Save Options" />
        </div>
    </div>
</div>