<div class="ec_admin_list_line_item">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_inventory_options_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-chart-bar"></div><span>Product Inventory Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'product-settings', 'inventory');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'product-settings', 'inventory');?></div>
    
    <div class="ec_admin_settings_input ec_admin_settings_products_section">
        <div><input type="checkbox" name="ec_option_stock_removed_in_cart" id="ec_option_stock_removed_in_cart" value="1"<?php if( get_option('ec_option_stock_removed_in_cart') == "1" ){ echo " checked=\"checked\""; }?> /> Remove Stock When Added to Cart</div>
    	<div>
        	<input style="float:left; clear:both;" name="ec_option_tempcart_stock_hours" id="ec_option_tempcart_stock_hours" type="number" min="1" step="1" value="<?php echo get_option( 'ec_option_tempcart_stock_hours' ); ?>">
            <select name="ec_option_tempcart_stock_timeframe" id="ec_option_tempcart_stock_timeframe" style="float:left;">
                <option value="SECOND" <?php if( get_option( 'ec_option_tempcart_stock_timeframe' ) == 'SECOND') echo ' selected'; ?>>Seconds in Cart Before Returning to Stock</option>
                <option value="MINUTE" <?php if( get_option( 'ec_option_tempcart_stock_timeframe' ) == 'MINUTE') echo ' selected'; ?>>Minutes in Cart Before Returning to Stock</option>
                <option value="HOUR" <?php if( get_option( 'ec_option_tempcart_stock_timeframe' ) == 'HOUR') echo ' selected'; ?>>Hours in Cart Before Returning to Stock</option>
            </select>
        </div>
    </div>
    
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_inventory_options( );" value="Save Options" />
    </div>
    
</div>