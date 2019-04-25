<div class="ec_admin_list_line_item">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_shipping_zone_list_display_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-networking"></div><span>Manage Shipping Zones</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'shipping-rates', 'shipping-zones');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'shipping-rates', 'shipping-zones');?>
    <span class="ec_admin_label_button"><a href="admin.php?page=wp-easycart-settings&subpage=shipping-settings&action=add-zone" class="ec_admin_settings_simple_button" onclick="return ec_admin_open_add_zone( );">Add Zone</a></span></div>
    
    <div class="ec_admin_line_item_no_scroll<?php if( !isset( $_GET['action'] ) || $_GET['action'] == "add-zone" ){ ?> ec_admin_initial_hide<?php }?>" id="shipping_zone_add">
    	<div class="ec_admin_settings_input">
            <span>Zone Name</span>
            <div><input type="text" name="ec_option_add_zone_name" id="ec_option_add_zone_name" value="" /></div>
        </div>
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_add_shipping_zone( );" value="Add Zone" />
        </div>
    </div>
    
    <div class="ec_admin_line_item_no_scroll<?php if( !isset( $_GET['action'] ) || $_GET['action'] == "edit-zone" ){ ?> ec_admin_initial_hide<?php }?>" id="shipping_zone_edit">
    	<div class="ec_admin_settings_input">
            <span>Zone Name</span>
            <div><input type="text" name="ec_option_edit_zone_name" id="ec_option_edit_zone_name" value="<?php if( isset( $this->edit_zone ) ){ echo $this->edit_zone->zone_name; } ?>" /></div>
        </div>
        <div class="ec_admin_settings_input">
        	<input type="hidden" name="ec_option_edit_zone_id" id="ec_option_edit_zone_id" value="<?php if( isset( $this->edit_zone ) ){ echo $this->edit_zone->zone_id; } ?>" />
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_edit_shipping_zone( );" value="Save Zone" />
        </div>
    </div>
    
    <div class="ec_admin_line_item_no_scroll<?php if( !isset( $_GET['action'] ) || $_GET['action'] == "add-zone-item" ){ ?> ec_admin_initial_hide<?php }?>" id="shipping_zone_item_add">
    	<div class="ec_admin_settings_input">
            <span>Country</span>
            <div><select name="ec_option_add_zone_item_country" id="ec_option_add_zone_item_country">
            	<option value="">Select a Country</option>
                <?php foreach( wp_easycart_admin( )->countries as $country ){ ?>
                <option value="<?php echo $country->iso2_cnt; ?>"><?php echo $country->name_cnt; ?></option>
                <?php }?>
            </select></div>
        </div>
        
        <div class="ec_admin_settings_input">
            <span>Country Division (Optional)</span>
            <div><select name="ec_option_add_zone_item_state" id="ec_option_add_zone_item_state">
            	<option value="">Select Country Division (Optional)</option>
                <?php foreach( wp_easycart_admin( )->states as $state ){ ?>
                <option value="<?php echo $state->code_sta; ?>"><?php echo $state->name_sta; ?></option>
                <?php }?>
            </select></div>
        </div>
        
        <div class="ec_admin_settings_input">
        	<input type="hidden" name="ec_option_add_zone_item_id" id="ec_option_add_zone_item_id" value="<?php if( isset( $this->edit_zone ) ){ echo $this->edit_zone->zone_id; } ?>" />
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_add_shipping_zone_item( );" value="Save Zone Item" />
        </div>
    </div>
    
    <div class="ec_admin_line_item_scroller<?php if( !isset( $_GET['action'] ) || $_GET['action'] == "edit-zone-item" ){ ?> ec_admin_initial_hide<?php }?>" id="shipping_zone_item_edit">
    	<span>Edit Shipping Zone Item</span>
    	<div class="ec_admin_settings_input">
            <span>Zone Name</span>
            <div><input type="text" name="ec_option_edit_zone_name" id="ec_option_edit_zone_name" value="<?php if( isset( $this->edit_zone ) ){ echo $this->edit_zone->zone_name; } ?>" /></div>
        </div>
        <div class="ec_admin_settings_input">
            <span>Country</span>
            <div><select name="ec_option_edit_zone_item_country" id="ec_option_edit_zone_item_country">
            	<option value="">Select a Country</option>
                <?php foreach( wp_easycart_admin( )->countries as $country ){ ?>
                <option value="<?php echo $country->iso2_cnt; ?>"><?php echo $country->name_cnt; ?></option>
                <?php }?>
            </select></div>
        </div>
        
        <div class="ec_admin_settings_input">
            <span>Country Division (Optional)</span>
            <div><select name="ec_option_edit_zone_item_state" id="ec_option_edit_zone_item_state">
            	<option value="">Select Country Division (Optional)</option>
                <?php foreach( wp_easycart_admin( )->states as $state ){ ?>
                <option value="<?php echo $state->code_sta; ?>"><?php echo $state->name_sta; ?></option>
                <?php }?>
            </select></div>
        </div>
    </div>
    
    <div class="ec_admin_line_item_scroller" id="shipping_zone_list">
        
        <div class="ec_admin_settings_input ec_admin_settings_products_section">
            <span>Edit Shipping Zones</span>
            <?php 
			$last_country_id = 0;
			foreach( wp_easycart_admin( )->shipping_zones as $shipping_zone ){ ?>
			<div class="ec_admin_shipping_zone" id="shipping_zone_<?php echo $shipping_zone->zone_id; ?>">
            	<a class="ec_admin_shipping_zone_toggle" onclick="return shipping_zone_toggle( '<?php echo $shipping_zone->zone_id; ?>' );" href="admin.php?page=wp-easycart-settings&subpage=shipping-settings&action=edit-zone&zone_id=<?php echo $shipping_zone->zone_id; ?>">
                	<div class="dashicons-before dashicons-arrow-up"></div>
                	<div class="dashicons-before dashicons-arrow-down"></div>
                </a> <span class="ec_admin_shipping_zone_label"><?php echo $shipping_zone->zone_name; ?></span> <span class="ec_admin_shipping_zone_actions"><a href="admin.php?page=wp-easycart-settings&subpage=shipping-settings&action=add-zone-item&zone_id=<?php echo $shipping_zone->zone_id; ?>" onclick="return ec_admin_open_add_shipping_zone_item( '<?php echo $shipping_zone->zone_id; ?>' );">add zone item</a> | <a href="admin.php?page=wp-easycart-settings&subpage=shipping-settings&action=edit-zone&zone_id=<?php echo $shipping_zone->zone_id; ?>" onclick="return ec_admin_edit_zone_open( '<?php echo $shipping_zone->zone_name; ?>', '<?php echo $shipping_zone->zone_id; ?>' );">edit</a> | <a href="admin.php?page=wp-easycart-settings&subpage=shipping-settings&action=delete-zone&zone_id=<?php echo $shipping_zone->zone_id; ?>" onclick="return delete_zone( '<?php echo $shipping_zone->zone_id; ?>' );">delete</a></span>
            </div>
            <div id="shipping_zones_<?php echo $shipping_zone->zone_id; ?>" class="ec_admin_shipping_zone_items">
            	<?php foreach( wp_easycart_admin( )->shipping_zones_items as $shipping_zone_item ){ ?>
            		<?php if( $shipping_zone_item->zone_id == $shipping_zone->zone_id ){ ?>
            			<div class="ec_admin_shipping_zone" id="shipping_zone_item_<?php echo $shipping_zone_item->zone_to_location_id; ?>"><span class="ec_admin_shipping_zone_label"><?php if( $shipping_zone_item->code_sta != "" ){ ?><?php echo $shipping_zone_item->state_name; ?>, <?php }?><?php echo $shipping_zone_item->country_name; ?></span> <span class="ec_admin_shipping_zone_actions"><a href="admin.php?page=wp-easycart-settings&subpage=shipping-settings&action=delete-zone-item&zone_to_location_id=<?php echo $shipping_zone_item->zone_to_location_id; ?>" onclick="return delete_zone_item( '<?php echo $shipping_zone_item->zone_to_location_id; ?>' );">delete</a></span></div>
            		<?php }?>
            	<?php }?>
                <div class="ec_admin_settings_tax_clear"></div>
            </div>
            <?php }?>
        </div>
        
    </div>

</div>