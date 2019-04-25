<div class="ec_admin_list_line_item">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_settings_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-edit"></div><span>Product Display</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'product-settings', 'product-display');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
     <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'product-settings', 'product-display');?>
    </div>
    
    <div class="ec_admin_settings_input ec_admin_settings_products_section">
        <div><input type="checkbox" name="ec_option_display_as_catalog" id="ec_option_display_as_catalog" value="1"<?php if( get_option('ec_option_display_as_catalog') == "1" ){ echo " checked=\"checked\""; }?> onclick="return ec_admin_disable_cart_check( );" /> Display Products in Catalog Mode (Remove Cart)</div>
        <div><input type="checkbox" name="ec_option_subscription_one_only" id="ec_option_subscription_one_only" value="1"<?php if( get_option('ec_option_subscription_one_only') == "1" ){ echo " checked=\"checked\""; }?> /> Hide Quantity from Subscription Purchase</div>
        <span>Restrict Store to User Level</span>
        <div><?php
		global $wpdb;
		$user_roles = $wpdb->get_results( "SELECT * FROM ec_role WHERE admin_access = 0" );
		$restricted_roles = explode( "***", get_option('ec_option_restrict_store' ) );
		?><select multiple name="ec_option_restrict_store" id="ec_option_restrict_store" style="float:left; width:97%;">
        	<option value="0"<?php if( get_option('ec_option_restrict_store') == "0" ){ echo " selected=\"selected\""; }?>>No Restrictions</option>
            <?php foreach( $user_roles as $user_role ){ ?>
            <option value="<?php echo $user_role->role_label; ?>"<?php if( in_array( $user_role->role_label, $restricted_roles ) ){ echo " selected=\"selected\""; }?>><?php echo $user_role->role_label; ?></option>
            <?php }?>
        </select>
        </div><br />
        
    </div>
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_product_settings( );" value="Save Options" />
    </div>
    
</div>