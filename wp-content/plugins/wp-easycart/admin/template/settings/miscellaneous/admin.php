<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_miscellaneous_admin_options_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-tools"></div><span>Product Quick Add Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'additional-settings', 'admin-options');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'additional-settings', 'admin-options');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
    	<p>This section allows you to enable/disable options within the product quick add slide-out. Customize the admin display to fit your needs!</p>
        <div><input type="checkbox" name="ec_option_admin_product_show_stock_option" id="ec_option_admin_product_show_stock_option" value="1"<?php if( get_option( 'ec_option_admin_product_show_stock_option' ) == "1" ){ echo " checked=\"checked\""; }?> /> Show Stock Options</div>
        <div><input type="checkbox" name="ec_option_admin_product_show_shipping_option" id="ec_option_admin_product_show_shipping_option" value="1"<?php if( get_option( 'ec_option_admin_product_show_shipping_option' ) == "1" ){ echo " checked=\"checked\""; }?> /> Show Shipping Options</div>
        <div><input type="checkbox" name="ec_option_admin_product_show_tax_option" id="ec_option_admin_product_show_tax_option" value="1"<?php if( get_option( 'ec_option_admin_product_show_tax_option' ) == "1" ){ echo " checked=\"checked\""; }?> /> Show Tax Options</div>
        <div><input type="checkbox" name="ec_option_admin_product_show_variant_option" id="ec_option_admin_product_show_variant_option" value="1"<?php if( get_option( 'ec_option_admin_product_show_variant_option' ) == "1" ){ echo " checked=\"checked\""; }?> /> Show Product Options (Variants)</div>
    	
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_admin_options( );" value="Save Options" />
        </div>
    </div>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-rss"></div><span>Admin Apps Options (Premium Only)</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'additional-settings', 'admin-options');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'additional-settings', 'admin-options');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
    	<div><input type="checkbox" name="ec_option_enable_push_notifications" id="ec_option_enable_push_notifications" value="1"<?php if( get_option( 'ec_option_enable_push_notifications' ) == "1" ){ echo " checked=\"checked\""; }?> /> Enable Admin App Notifications (must have push notifications enabled!)</div>
    	
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_admin_options( );" value="Save Options" />
        </div>
    </div>
</div>