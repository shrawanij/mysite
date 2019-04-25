<div class="ec_admin_list_line_item">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_customer_review_display_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-edit"></div><span>Customer Review Display</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'product-settings', 'customer-review');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'product-settings', 'customer-review');?>
    </div>
    
    <div class="ec_admin_settings_input ec_admin_settings_products_section">
        <span>Turn Display Items On/Off</span>
        <div><input type="checkbox" name="ec_option_customer_review_require_login" id="ec_option_customer_review_require_login" value="1"<?php if( get_option('ec_option_customer_review_require_login') == "1" ){ echo " checked=\"checked\""; }?> /> User Must be Logged in to Review</div>
        <div><input type="checkbox" name="ec_option_customer_review_show_user_name" id="ec_option_customer_review_show_user_name" value="1"<?php if( get_option('ec_option_customer_review_show_user_name') == "1" ){ echo " checked=\"checked\""; }?> /> Show User's Name on Review</div>
    </div>
    
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_customer_review_display_options( );" value="Save Options" />
    </div>
    
</div>