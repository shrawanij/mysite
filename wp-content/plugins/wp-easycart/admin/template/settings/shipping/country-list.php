<div class="ec_admin_list_line_item">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_country_list_display_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-site"></div><span>Country Shipping List</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'shipping-rates', 'country-list');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'shipping-rates', 'country-list');?></div>
    
    <div class="ec_admin_line_item_scroller">
        
        <div class="ec_admin_settings_input ec_admin_settings_products_section">
            <span>Countries You Will Sell To</span>
            <?php foreach( wp_easycart_admin( )->countries as $country ){ ?>
            <div><input type="checkbox" onchange="ec_admin_toggle_shipping_country( '<?php echo $country->id_cnt; ?>' );" class="ec_admin_country_list" data-id-cnt="<?php echo $country->id_cnt; ?>" name="country_list[<?php echo $country->id_cnt; ?>]" id="country_list_<?php echo $country->id_cnt; ?>" value="1"<?php if( $country->ship_to_active ){ echo " checked=\"checked\""; }?> /> <?php echo $country->name_cnt; ?></div>
            <?php }?>
        </div>
        
    </div>
        
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_country_list( );" value="Save Options" />
    </div>

</div>