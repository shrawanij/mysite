<?php
/**************************
VAT Tax
***************************/
$vat_tax_rate = $this->wpdb->get_row( "SELECT ec_taxrate.* FROM ec_taxrate WHERE tax_by_vat = 1 OR tax_by_single_vat = 1" );
?>
<div class="ec_admin_list_line_item ec_admin_demo_data_line">
	
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_vat_options_loader" ); ?>
	
	<div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-site"></div><span>Setup VAT Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'taxes', 'vat-setup');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'taxes', 'vat-setup');?></div>
	
	<div class="ec_admin_settings_input ec_admin_settings_tax_section">
		<span>Turn On/Off VAT or Adjust Options</span>
		<div>
			<span>VAT Type</span>
			<select name="ec_vat_type" id="ec_vat_type" onchange="ec_admin_update_vat_tax_display( );" style="margin-right:4px;">
				<option value="0"<?php if( !$vat_tax_rate ){ ?> selected="selected"<?php }?>>VAT Disabled</option>
				<option value="tax_by_single_vat"<?php if( $vat_tax_rate && $vat_tax_rate->tax_by_single_vat ){ ?> selected="selected"<?php }?>>Global VAT Rate</option>
				<option value="tax_by_vat"<?php if( $vat_tax_rate && $vat_tax_rate->tax_by_vat ){ ?> selected="selected"<?php }?>>VAT by Country</option>
			</select>
		</div>
		<div id="ec_admin_vat_pricing_type_row"<?php if( !$vat_tax_rate ){ ?> style="display:none;"<?php }?>>
			<span>VAT Pricing Method</span>
			<select name="ec_vat_pricing_method" id="ec_vat_pricing_method" style="margin-right:4px;">
				<option value="vat_added"<?php if( $vat_tax_rate && $vat_tax_rate->vat_added ){ ?> selected="selected"<?php }?>>Add in Cart</option>
				<option value="vat_included"<?php if( $vat_tax_rate && $vat_tax_rate->vat_included ){ ?> selected="selected"<?php }?>>Included in Price</option>
			</select>
		</div>
		<div id="ec_admin_vat_default_rate_row"<?php if( !$vat_tax_rate ){ ?> style="display:none;"<?php }?>>
			<span>Default Rate</span>
			<span class="ec_admin_settings_tax_percentage">%</span>
			<input name="ec_default_vat_rate" id="ec_default_vat_rate" type="number" value="<?php if( $vat_tax_rate ){ echo $vat_tax_rate->vat_rate; }else{ echo "0.000"; }?>" step=".001" />
		</div>
        <div id="ec_admin_vat_validate_number_rate_row"<?php if( !$vat_tax_rate ){ ?> style="display:none;"<?php }?>>
			<div><input type="checkbox" name="ec_option_no_vat_on_shipping" id="ec_option_no_vat_on_shipping" value="1"<?php if( !get_option( 'ec_option_no_vat_on_shipping' ) ){ echo " checked=\"checked\""; }?> /> Apply VAT to Shipping</div>
		</div>
        <div id="ec_admin_vat_custom_rate_row"<?php if( !$vat_tax_rate ){ ?> style="display:none;"<?php }?>>
			<span>Custom VAT Rate for Businesses</span>
			<span class="ec_admin_settings_tax_percentage">%</span>
			<input name="ec_option_vat_custom_rate" id="ec_option_vat_custom_rate" type="number" value="<?php echo get_option( 'ec_option_vat_custom_rate' ); ?>" step=".001" />
		</div>
        <div id="ec_admin_vat_validate_vat_registration_number"<?php if( !$vat_tax_rate ){ ?> style="display:none;"<?php }?>>
			<div><input type="checkbox" name="ec_option_validate_vat_registration_number" id="ec_option_validate_vat_registration_number" onchange="ec_validate_vat_toggle( );" value="1"<?php if( get_option( 'ec_option_validate_vat_registration_number' ) ){ echo " checked=\"checked\""; }?> /> Validate VAT Registration Number on Checkout</div>
		</div>
        <div id="ec_admin_vatlayer_api_row"<?php if( !$vat_tax_rate || !get_option( 'ec_option_validate_vat_registration_number' ) ){ ?> style="display:none;"<?php }?>>
			Vatlayer API Key (for VAT Number Validation)<input name="ec_option_vatlayer_api_key" id="ec_option_vatlayer_api_key" type="text" value="<?php echo get_option( 'ec_option_vatlayer_api_key' ); ?>" style="float:left; width:100%;" />
		</div>
		
	</div>
	
	<input type="hidden" name="ec_vat_taxrate_id" id="ec_vat_taxrate_id" value="<?php if( $vat_tax_rate ){ echo $vat_tax_rate->taxrate_id; }else{ echo "0"; } ?>" />
	<div class="ec_admin_settings_input">
		<input type="submit" class="ec_admin_settings_simple_button" value="Save Setup" onclick="return ec_admin_update_vat_tax_rate( );" />
	</div>

	<div class="ec_admin_settings_input ec_admin_settings_tax_section">
	
		<div id="ec_admin_vat_country_rates_section"<?php if( !$vat_tax_rate || $vat_tax_rate->tax_by_single_vat ){ ?> style="display:none;"<?php }?>>
			<span><strong>Custom Country VAT Rates</strong></span>
			<?php
			$vat_country_count = 0;
			foreach( wp_easycart_admin( )->countries as $country ){
				if( $country->vat_rate_cnt > 0 ){
					$vat_country_count++;
			?>
			<div class="ec_admin_tax_row" id="ec_admin_vat_country_tax_row_<?php echo $country->id_cnt; ?>">
				<span><?php echo $country->name_cnt; ?></span>
				<span class="ec_admin_settings_tax_percentage">%</span>
				<input type="number" value="<?php echo $country->vat_rate_cnt; ?>" step=".001" name="vat_country_tax_rate_<?php echo $country->id_cnt; ?>" id="vat_country_tax_rate_<?php echo $country->id_cnt; ?>" />
			</div>
			
			<div class="ec_admin_tax_button_row" id="ec_admin_vat_country_tax_button_row_<?php echo $country->id_cnt; ?>">
				<span><input class="ec_admin_tax_link_button" type="submit" value="Save" onclick="return ec_admin_save_vat_country_tax( '<?php echo $country->id_cnt; ?>' );" />
					<span class="ec_admin_tax_button_divider"> | </span>
					<a href="admin.php?page=wp-easycart-settings&subpage=tax&ec_admin_action=delete_vat_country_tax_row&id_cnt=<?php echo $country->id_cnt; ?>" class="ec_admin_tax_link" onclick="return ec_admin_delete_vat_country_tax_rate( '<?php echo $country->id_cnt; ?>' );">Delete</a>
				</span>
			</div>
			
			<div class="ec_admin_settings_light_tax_divider" id="ec_admin_vat_country_tax_divider_<?php echo $country->id_cnt; ?>"></div>
				
			<?php }
			}?>
			<span <?php if( $vat_country_count > 0 ){ ?>style="display:none;" <?php }?>id="modify_vat_country_tax_rates_none_header">No Country VAT Rates Available</span>
			
			<div id="insert_new_vat_country_tax_here"></div>
			
			<div class="ec_admin_tax_row">
				<span>
					<select name="ec_new_vat_country_code" id="ec_new_vat_country_code" style="float:left;">
						<option value="0">Select a Country</option>
						<?php foreach( wp_easycart_admin( )->countries as $country ){ ?>
						<option value="<?php echo $country->id_cnt; ?>"><?php echo $country->name_cnt; ?></option>
						<?php }?>
					</select>
				</span>
				<span class="ec_admin_settings_tax_percentage">%</span>
				<input name="ec_new_vat_country_rate" id="ec_new_vat_country_rate" type="number" value="0.000" step=".001" />
			</div>
			<div class="ec_admin_tax_button_row_last">
				<span><input class="ec_admin_tax_link_button" type="submit" value="+ Add New" onclick="return ec_admin_add_vat_country_tax_rate( );" /></span>
			</div>
			
		</div>
	</div>
	
	<div class="ec_admin_tax_spacer"></div>
	
</div>