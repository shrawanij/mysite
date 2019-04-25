<?php
/**************************
Global Tax
***************************/
$global_tax_rate = $this->wpdb->get_row( "SELECT ec_taxrate.* FROM ec_taxrate WHERE tax_by_all = 1" );
?>
<div class="ec_admin_list_line_item ec_admin_demo_data_line" style="float:left;">
	
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_global_tax_rate_loader" ); ?>
	
	<div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-site"></div><span>Setup Global Tax Rate</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'taxes', 'global-tax-setup');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'taxes', 'global-tax-setup');?></div>
	
	<div class="ec_admin_settings_input ec_admin_settings_tax_section">
		<span>Turn On/Off or Adjust Rate</span>
		<div><input type="checkbox" name="ec_option_use_global_tax" id="ec_option_use_global_tax" onchange="ec_admin_update_global_tax_display( );" value="1"<?php if( $global_tax_rate ){ echo " checked=\"checked\""; }?> /> Apply Global Tax Rate</div>
		<div<?php if( !$global_tax_rate ){ ?> style="display:none;"<?php }?> id="ec_global_tax_row">Global Tax Rate 
		<span class="ec_admin_settings_tax_percentage">%</span>
			<input name="ec_global_tax_rate" id="ec_global_tax_rate" type="number" value="<?php if( $global_tax_rate ){ echo $global_tax_rate->all_rate; }else{ echo "0.000"; }?>" step=".001" /></div>
	</div>
	
	<input type="hidden" name="ec_global_taxrate_id" id="ec_global_taxrate_id" value="<?php if( $global_tax_rate ){ echo $global_tax_rate->taxrate_id; }else{ echo "0"; } ?>" />
	<div class="ec_admin_settings_input">
		<input type="submit" class="ec_admin_settings_simple_button" value="Save Setup" onclick="return ec_admin_update_global_tax_rate( );" />
	</div>
	
</div>