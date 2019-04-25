<?php
/**************************
Duty Tax
***************************/
$duty_tax_rate = $this->wpdb->get_row( "SELECT ec_taxrate.* FROM ec_taxrate WHERE tax_by_duty = 1" );
$countries = $this->wpdb->get_results( "SELECT ec_country.* FROM ec_country" );
?>
<div class="ec_admin_list_line_item">
	
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_duty_options_loader" ); ?>
	
	<div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-site"></div><span>Setup Duty Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'taxes', 'duty-tax-setup');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'taxes', 'duty-tax-setup');?></div>
	
	<div class="ec_admin_settings_input ec_admin_settings_tax_section">
		<span>Turn On/Off Duty or Adjust Options</span>
		<div><input type="checkbox" name="ec_option_use_duty_tax" id="ec_option_use_duty_tax" onchange="ec_admin_update_duty_tax_display( );" value="1"<?php if( $duty_tax_rate ){ echo " checked=\"checked\""; }?> /> Enable Duty</div>
		<div<?php if( !$duty_tax_rate ){ ?> style="display:none;"<?php }?> id="ec_duty_tax_row">
			<div><span>Duty Exempt Country</span><select name="ec_duty_exempt_country_code" id="ec_duty_exempt_country_code" style="margin-right:4px;">
					<option value="0">Select a Country</option>
					<?php foreach( $countries as $country ){ ?>
					<option value="<?php echo $country->id_cnt; ?>"<?php if( $duty_tax_rate && $country->iso2_cnt == $duty_tax_rate->duty_exempt_country_code ){?> selected="selected"<?php }?>><?php echo $country->name_cnt; ?></option>
					<?php }?>
				</select></div>
			<div>
			<span>Duty Rate</span>
			<span class="ec_admin_settings_tax_percentage">%</span>
			<input name="ec_duty_tax_rate" id="ec_duty_tax_rate" type="number" value="<?php if( $duty_tax_rate ){ echo $duty_tax_rate->duty_rate; }else{ echo "0.000"; }?>" step=".001" /></div>
		</div>
	</div>
	
	<input type="hidden" name="ec_duty_taxrate_id" id="ec_duty_taxrate_id" value="<?php if( $duty_tax_rate ){ echo $duty_tax_rate->taxrate_id; }else{ echo "0"; } ?>" />
	<div class="ec_admin_settings_input">
		<input type="submit" class="ec_admin_settings_simple_button" value="Save Setup" onclick="return ec_admin_update_duty_tax_rate( );" />
	</div>
	
	<div class="ec_admin_tax_spacer"></div>
	
</div>

<div class="ec_admin_settings_tax_clear"></div>