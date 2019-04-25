<div class="ec_admin_list_line_item">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_list_display_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-screenoptions"></div><span>Product List Display</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'product-settings', 'product-list');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'product-settings', 'product-list');?></div>
    
    <div class="ec_admin_settings_input ec_admin_settings_products_section">
        <span>Show Product Sort Box</span>
        <div><select name="ec_option_show_sort_box" id="ec_option_show_sort_box" onchange="ec_admin_sort_box_change( );" style="float:left;">
          <option value="1" <?php if (get_option('ec_option_show_sort_box') == 1) echo ' selected'; ?>>Yes</option>
          <option value="0" <?php if (get_option('ec_option_show_sort_box') == 0) echo ' selected'; ?>>No</option>
        </select></div>
    </div>
    
    <div class="ec_admin_settings_<?php if( get_option( 'ec_option_show_sort_box' ) ){ ?>show<?php }else{?>hide<?php }?>" id="ec_admin_settings_sort_box_options">
    
        <div class="ec_admin_settings_input ec_admin_settings_products_section">
            <span>Default Product Sort</span>
            <div><select name="ec_option_default_store_filter" id="ec_option_default_store_filter" style="float:left;">
            <option value="0" <?php if (get_option('ec_option_default_store_filter') == '0') echo ' selected'; ?>>Default Sorting</option>
            <option value="1" <?php if (get_option('ec_option_default_store_filter') == '1') echo ' selected'; ?>>Price Low-High</option>
            <option value="2" <?php if (get_option('ec_option_default_store_filter') == '2') echo ' selected'; ?>>Price High-Low</option>
            <option value="3" <?php if (get_option('ec_option_default_store_filter') == '3') echo ' selected'; ?>>Title A-Z</option>
            <option value="4" <?php if (get_option('ec_option_default_store_filter') == '4') echo ' selected'; ?>>Title Z-A</option>
            <option value="5" <?php if (get_option('ec_option_default_store_filter') == '5') echo ' selected'; ?>>Newest</option>
            <option value="6" <?php if (get_option('ec_option_default_store_filter') == '6') echo ' selected'; ?>>Best Rating</option>
            <option value="7" <?php if (get_option('ec_option_default_store_filter') == '7') echo ' selected'; ?>>Most Viewed</option>
          </select></div>
        </div>
        
        <div class="ec_admin_settings_input ec_admin_settings_products_section">
            <span>Product sort box options</span>
            <div><input type="checkbox" name="ec_option_product_filter_0" id="ec_option_product_filter_0" value="1"<?php if( get_option('ec_option_product_filter_0') == "1" ){ echo " checked=\"checked\""; }?> /> Display Default Sorting</div>
            <div><input type="checkbox" name="ec_option_product_filter_1" id="ec_option_product_filter_1" value="1"<?php if( get_option('ec_option_product_filter_1') == "1" ){ echo " checked=\"checked\""; }?> /> Display Price Low-High</div>
            <div><input type="checkbox" name="ec_option_product_filter_2" id="ec_option_product_filter_2" value="1"<?php if( get_option('ec_option_product_filter_2') == "1" ){ echo " checked=\"checked\""; }?> /> Display Price High-Low</div>
            <div><input type="checkbox" name="ec_option_product_filter_3" id="ec_option_product_filter_3" value="1"<?php if( get_option('ec_option_product_filter_3') == "1" ){ echo " checked=\"checked\""; }?> /> Display Title A-Z</div>
            <div><input type="checkbox" name="ec_option_product_filter_4" id="ec_option_product_filter_4" value="1"<?php if( get_option('ec_option_product_filter_4') == "1" ){ echo " checked=\"checked\""; }?> /> Display Title Z-A</div>
            <div><input type="checkbox" name="ec_option_product_filter_5" id="ec_option_product_filter_5" value="1"<?php if( get_option('ec_option_product_filter_5') == "1" ){ echo " checked=\"checked\""; }?> /> Display Newest</div>
            <div><input type="checkbox" name="ec_option_product_filter_6" id="ec_option_product_filter_6" value="1"<?php if( get_option('ec_option_product_filter_6') == "1" ){ echo " checked=\"checked\""; }?> /> Display Best Rating</div>
            <div><input type="checkbox" name="ec_option_product_filter_7" id="ec_option_product_filter_7" value="1"<?php if( get_option('ec_option_product_filter_7') == "1" ){ echo " checked=\"checked\""; }?> /> Display Most Viewed</div>
        </div>
    
    </div>
    
    <div class="ec_admin_settings_input ec_admin_settings_products_section">
        <span>Display Options</span>
        <div><input type="checkbox" name="ec_option_short_description_on_product" id="ec_option_short_description_on_product" value="1"<?php if( get_option('ec_option_short_description_on_product') == "1" ){ echo " checked=\"checked\""; }?> /> Show Product Short Description on Grid Layout Type</div>
        <div><input type="checkbox" name="ec_option_show_featured_categories" id="ec_option_show_featured_categories" value="1"<?php if( get_option('ec_option_show_featured_categories') == "1" ){ echo " checked=\"checked\""; }?> /> Show Featured Categories</div>
    </div>
    
    <div class="ec_admin_settings_input ec_admin_settings_products_section">
        <span>Split Products into Record Sets</span>
        <div><select name="ec_option_enable_product_paging" id="ec_option_enable_product_paging" style="float:left;">
          <option value="1" <?php if (get_option('ec_option_enable_product_paging') == 1) echo ' selected'; ?>>Yes, Limit Products per Page</option>
          <option value="0" <?php if (get_option('ec_option_enable_product_paging') == 0) echo ' selected'; ?>>No, Show All Products</option>
        </select></div>
    </div>
    
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_product_list_display_options( );" value="Save Options" />
    </div>
    
</div>