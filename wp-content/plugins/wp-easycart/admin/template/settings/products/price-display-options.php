<div class="ec_admin_list_line_item">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_price_display_options_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-vault"></div><span>Price Display Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'product-settings', 'price-display');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'product-settings', 'price-display');?></div>
    
    <div class="ec_admin_settings_input ec_admin_settings_products_section">
        <span>Turn On/Off Pricing Display Options</span>
        <div><input type="checkbox" name="ec_option_hide_price_seasonal" id="ec_option_hide_price_seasonal" value="1"<?php if( get_option('ec_option_hide_price_seasonal') == "1" ){ echo " checked=\"checked\""; }?> /> Hide Price for Seasonal Products</div>
        <div><input type="checkbox" name="ec_option_hide_price_inquiry" id="ec_option_hide_price_inquiry" value="1"<?php if( get_option('ec_option_hide_price_inquiry') == "1" ){ echo " checked=\"checked\""; }?> /> Hide Price for Inquiry Products</div>
        <div><input type="checkbox" name="ec_option_show_multiple_vat_pricing" id="ec_option_show_multiple_vat_pricing" value="1"<?php if( get_option('ec_option_show_multiple_vat_pricing') == "1" ){ echo " checked=\"checked\""; }?> /> Show BOTH VAT Included and VAT Excluded Prices</div>
		<div><input type="checkbox" name="ec_option_tiered_price_format" id="ec_option_tiered_price_format" value="1"<?php if( get_option('ec_option_tiered_price_format') == "1" ){ echo " checked=\"checked\""; }?> /> Volume Price Format (EX: As Low As $X.XX)</div>
    	<div><input type="checkbox" name="ec_option_tiered_price_by_option" id="ec_option_tiered_price_by_option" value="1"<?php if( get_option('ec_option_tiered_price_by_option') == "1" ){ echo " checked=\"checked\""; }?> /> Volume Pricing Applies Individually</div>
    </div>
    
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_price_display_options( );" value="Save Options" />
    </div>
    
</div>