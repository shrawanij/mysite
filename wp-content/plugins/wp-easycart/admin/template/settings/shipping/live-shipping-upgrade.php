<div class="ec_admin_list_line_item" style="min-height:125px;">
            
	<div class="ec_admin_settings_label"><div class="dashicons-before dashicons-backup"></div><span><?php echo $live_rate_upgrade_title; ?></span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'shipping-rates', 'shipping-basic-options');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a></div>
    
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
    
    	<div><input type="checkbox" id="live_shipping_upgrade_toggle" value="1" onclick="return show_pro_required( '<?php echo $live_rate_upgrade_var; ?>' );" /><?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; margin-top:5px;"></span>' ); ?><?php echo $live_rate_upgrade_label; ?></div>
        
    </div>
    
</div>