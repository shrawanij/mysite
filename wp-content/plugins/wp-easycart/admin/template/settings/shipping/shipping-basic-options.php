<div class="ec_admin_list_line_item">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_shipping_options_display_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-screenoptions"></div><span>ADDITIONAL SHIPPING OPTIONS</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'shipping-rates', 'shipping-basic-options');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'shipping-rates', 'shipping-basic-options');?></div>
    
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
    
    	<span>Sitewide Shipping</span>
    	<div><input type="checkbox" name="ec_option_use_shipping" id="ec_option_use_shipping" value="1"<?php if( get_option('ec_option_use_shipping') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Shipping on Site</div>
        <div><input type="checkbox" name="ec_option_hide_shipping_rate_page1" id="ec_option_hide_shipping_rate_page1" value="1"<?php if( get_option('ec_option_hide_shipping_rate_page1') ){ echo " checked=\"checked\""; }?> /> Hide Shipping on Initial Cart Page</div>
        <div>Global Handling Rate <input type="text" name="shipping_handling_rate" id="shipping_handling_rate" value="<?php echo wp_easycart_admin( )->settings->shipping_handling_rate; ?>" /></div>
        <div>Expedited Shipping Cost (N/A Live Rates)<input type="text" name="shipping_expedite_rate" id="shipping_expedite_rate" value="<?php echo wp_easycart_admin( )->settings->shipping_expedite_rate; ?>" /></div>
        
        <span style="float:left; width:100%;">Additional Shipping Options</span>
        <div>Weight Unit <select name="ec_option_weight" id="ec_option_weight">
          <option value="lbs" <?php if (get_option('ec_option_weight') == 'lbs') echo ' selected'; ?>>LBS</option>
          <option value="kgs" <?php if (get_option('ec_option_weight') == 'kgs') echo ' selected'; ?>>KGS</option>
        </select>
        </div>
        <div>Dimension Unit <select name="ec_option_enable_metric_unit_display" id="ec_option_enable_metric_unit_display">
          <option value="0" <?php if (get_option('ec_option_enable_metric_unit_display') == '0') echo ' selected'; ?>>Standard</option>
          <option value="1" <?php if (get_option('ec_option_enable_metric_unit_display') == '1') echo ' selected'; ?>>Metric</option>
        </select>
        </div>
        <div><input type="checkbox" name="ec_option_add_local_pickup" id="ec_option_add_local_pickup" value="1"<?php if( get_option('ec_option_add_local_pickup') == "1" ){ echo " checked=\"checked\""; }?> /> Add Free Local Pickup Option</div>
		<div><input type="checkbox" name="ec_option_collect_tax_on_shipping" id="ec_option_collect_tax_on_shipping" value="1"<?php if( get_option('ec_option_collect_tax_on_shipping') == "1" ){ echo " checked=\"checked\""; }?> /> Tax Shipping</div>
    	<div><input type="checkbox" name="ec_option_show_delivery_days_live_shipping" id="ec_option_show_delivery_days_live_shipping" value="1"<?php if( get_option('ec_option_show_delivery_days_live_shipping') == "1" ){ echo " checked=\"checked\""; }?> /> Show Delivery Days (Live Shipping Only)</div>
		<div><input type="checkbox" name="ec_option_collect_shipping_for_subscriptions" id="ec_option_collect_shipping_for_subscriptions" value="1"<?php if( get_option('ec_option_collect_shipping_for_subscriptions') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Shipping for Subscriptions</div>
    	<div><input type="checkbox" name="ec_option_ship_items_seperately" id="ec_option_ship_items_seperately" value="1"<?php if( get_option('ec_option_ship_items_seperately') == "1" ){ echo " checked=\"checked\""; }?> /> Each Product Ships Separately (Live Shipping)</div>
    	<div><input type="checkbox" name="ec_option_static_ship_items_seperately" id="ec_option_static_ship_items_seperately" value="1"<?php if( get_option('ec_option_static_ship_items_seperately') == "1" ){ echo " checked=\"checked\""; }?> /> Each Product Ships Separately (Method Based)</div>
    	<div><input type="checkbox" name="ec_option_fedex_use_net_charge" id="ec_option_fedex_use_net_charge" value="1"<?php if( get_option('ec_option_fedex_use_net_charge') == "1" ){ echo " checked=\"checked\""; }?> /> Apply FedEx Account Discounts</div>
    </div>
    
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_basic_shipping_options( );" value="Save Options" />
    </div>
    
</div>