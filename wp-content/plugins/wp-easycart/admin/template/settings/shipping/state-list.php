<div class="ec_admin_list_line_item">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_state_list_display_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-networking"></div><span>Country Division Shipping List</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'shipping-rates', 'state-list');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'shipping-rates', 'state-list');?></div>
    
    <div class="ec_admin_line_item_scroller">
        
        <div class="ec_admin_settings_input ec_admin_settings_products_section">
            <span>Country Divisions You Will Sell To</span>
            <?php 
			$last_country_id = 0;
			foreach( wp_easycart_admin( )->states as $state ){ 
			if( $state->idcnt_sta != $last_country_id ){
			?>
            <div><strong><?php echo $state->country_name; ?></strong></div>
            <?php 
			$last_country_id = $state->idcnt_sta;
			}?>
            <div><input type="checkbox" class="ec_admin_state_list" data-id-cnt="<?php echo $state->idcnt_sta; ?>" data-id-sta="<?php echo $state->id_sta; ?>" name="state_list[<?php echo $state->id_sta; ?>]" id="state_list_<?php echo $state->id_sta; ?>" value="1"<?php if( $state->ship_to_active ){ echo " checked=\"checked\""; }?> /> <?php echo $state->name_sta; ?></div>
            <?php }?>
        </div>
        
    </div>
        
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_state_list( );" value="Save Options" />
    </div>

</div>