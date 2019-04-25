<div class="ec_admin_list_line_item">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_display_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-analytics"></div><span>Product Details Display</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'product-settings', 'product-details');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'product-settings', 'product-details');?></div>
    
    <div class="ec_admin_settings_input ec_admin_settings_products_section">
        <span>Basic Options</span>
        <div>Model Number Extension <input name="ec_option_model_number_extension" id="ec_option_model_number_extension" type="text" value="<?php echo get_option('ec_option_model_number_extension'); ?>" /></div>
    </div>
        
    <div class="ec_admin_settings_input ec_admin_settings_products_section">
        <span>Turn Display Items On/Off</span>
        <div><input type="checkbox" name="ec_option_show_breadcrumbs" id="ec_option_show_breadcrumbs" value="1"<?php if( get_option('ec_option_show_breadcrumbs') == "1" ){ echo " checked=\"checked\""; }?> /> Show Breadcrumbs</div>
        <div><input type="checkbox" name="ec_option_show_magnification" id="ec_option_show_magnification" value="1"<?php if( get_option('ec_option_show_magnification') == "1" ){ echo " checked=\"checked\""; }?> /> Show Magnification Box</div>
        <div><input type="checkbox" name="ec_option_show_large_popup" id="ec_option_show_large_popup" value="1"<?php if( get_option('ec_option_show_large_popup') == "1" ){ echo " checked=\"checked\""; }?> /> Show Large Image Popup</div>
        <div><input type="checkbox" name="ec_option_show_model_number" id="ec_option_show_model_number" value="1"<?php if( get_option('ec_option_show_model_number') == "1" ){ echo " checked=\"checked\""; }?> /> Show Model Number</div>
        <div><input type="checkbox" name="ec_option_show_categories" id="ec_option_show_categories" value="1"<?php if( get_option('ec_option_show_categories') == "1" ){ echo " checked=\"checked\""; }?> /> Show Product Categories</div>
        <div><input type="checkbox" name="ec_option_show_manufacturer" id="ec_option_show_manufacturer" value="1"<?php if( get_option('ec_option_show_manufacturer') == "1" ){ echo " checked=\"checked\""; }?> /> Show Manufacturer</div>
        <div><input type="checkbox" name="ec_option_show_stock_quantity" id="ec_option_show_stock_quantity" value="1"<?php if( get_option('ec_option_show_stock_quantity') == "1" ){ echo " checked=\"checked\""; }?> /> Show Stock Quantity</div>
        
    </div>
    
    <div class="ec_admin_settings_input ec_admin_settings_products_section">
        <span>Social Icon Display</span>
        <div><input type="checkbox" name="ec_option_use_facebook_icon" id="ec_option_use_facebook_icon" value="1"<?php if( get_option('ec_option_use_facebook_icon') == "1" ){ echo " checked=\"checked\""; }?> /> Display Facebook Icon Link</div>
        <div><input type="checkbox" name="ec_option_use_twitter_icon" id="ec_option_use_twitter_icon" value="1"<?php if( get_option('ec_option_use_twitter_icon') == "1" ){ echo " checked=\"checked\""; }?> /> Display Twitter Icon Link</div>
        <div><input type="checkbox" name="ec_option_use_delicious_icon" id="ec_option_use_delicious_icon" value="1"<?php if( get_option('ec_option_use_delicious_icon') == "1" ){ echo " checked=\"checked\""; }?> /> Display Delicious Icon Link</div>
        <div><input type="checkbox" name="ec_option_use_myspace_icon" id="ec_option_use_myspace_icon" value="1"<?php if( get_option('ec_option_use_myspace_icon') == "1" ){ echo " checked=\"checked\""; }?> /> Display MySpace Icon Link</div>
        <div><input type="checkbox" name="ec_option_use_linkedin_icon" id="ec_option_use_linkedin_icon" value="1"<?php if( get_option('ec_option_use_linkedin_icon') == "1" ){ echo " checked=\"checked\""; }?> /> Display LinkedIn Icon Link</div>
        <div><input type="checkbox" name="ec_option_use_email_icon" id="ec_option_use_email_icon" value="1"<?php if( get_option('ec_option_use_email_icon') == "1" ){ echo " checked=\"checked\""; }?> /> Display Email Icon Link</div>
        <div><input type="checkbox" name="ec_option_use_digg_icon" id="ec_option_use_digg_icon" value="1"<?php if( get_option('ec_option_use_digg_icon') == "1" ){ echo " checked=\"checked\""; }?> /> Display Digg Icon Link</div>
        <div><input type="checkbox" name="ec_option_use_googleplus_icon" id="ec_option_use_googleplus_icon" value="1"<?php if( get_option('ec_option_use_googleplus_icon') == "1" ){ echo " checked=\"checked\""; }?> /> Display Google+ Icon Link</div>
        <div><input type="checkbox" name="ec_option_use_pinterest_icon" id="ec_option_use_pinterest_icon" value="1"<?php if( get_option('ec_option_use_pinterest_icon') == "1" ){ echo " checked=\"checked\""; }?> /> Display Pinterest Icon Link</div>
    </div>
    
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_product_details_display_options( );" value="Save Options" />
    </div>
    
</div>