<?php
/**************************
Canada Tax
***************************/
$canada_tax_options = get_option( 'ec_option_canada_tax_options' );
$user_roles = $this->wpdb->get_results( "SELECT ec_role.* FROM ec_role WHERE ec_role.role_label != 'admin'" );
$provinces = array( "alberta", "british_columbia", "manitoba", "new_brunswick", "newfoundland", "northwest_territories", "nova_scotia", "nunavut", "ontario", "prince_edward_island", "quebec", "saskatchewan", "yukon" );
$canada_tax_defaults = array( 
	"alberta" => array(
		"name" => "Alberta", 
		"gst" => .05,
		"pst" => .00,
		"hst" => .00
	),
	"british_columbia" => array( 
		"name" => "British Columbia",
		"gst" => .05,
		"pst" => .07,
		"hst" => .00
	),
	"manitoba" => array( 
		"name" => "Manitoba",
		"gst" => .05,
		"pst" => .08,
		"hst" => .00
	),
	"new_brunswick" => array( 
		"name" => "New Brunswick",
		"gst" => .00,
		"pst" => .00,
		"hst" => .13
	),
	"newfoundland" => array( 
		"name" => "Newfoundland and Labrador",
		"gst" => .00,
		"pst" => .00,
		"hst" => .13
	),
	"northwest_territories" => array( 
		"name" => "Northwest Territories",
		"gst" => .05,
		"pst" => .00,
		"hst" => .00
	),
	"nova_scotia" => array( 
		"name" => "Nova Scotia",
		"gst" => .00,
		"pst" => .00,
		"hst" => .15
	),
	"nunavut" => array( 
		"name" => "Nunavut",
		"gst" => .05,
		"pst" => .00,
		"hst" => .00
	),
	"ontario" => array( 
		"name" => "Ontario",
		"gst" => .00,
		"pst" => .00,
		"hst" => .13
	),
	"prince_edward_island" => array( 
		"name" => "Price Edward Island",
		"gst" => .00,
		"pst" => .00,
		"hst" => .14
	),
	"quebec" => array( 
		"name" => "Quebec",
		"gst" => .05,
		"pst" => .09975,
		"hst" => .00
	),
	"saskatchewan" => array( 
		"name" => "Saskatchewan",
		"gst" => .05,
		"pst" => .05,
		"hst" => .00
	),
	"yukon" => array( 
		"name" => "Yukon",
		"gst" => .05,
		"pst" => .00,
		"hst" => .00
	)
);
			
?>
<div class="ec_admin_list_line_item">
	
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_canada_tax_options_loader" ); ?>
	
	<div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-site"></div><span>Canada Tax Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'taxes', 'canada-tax-setup');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'taxes', 'canada-tax-setup');?></div>
	
	<div class="ec_admin_settings_input ec_admin_settings_tax_section">
		<span>Setup Canada Taxation Options</span>
		<div><input type="checkbox" name="ec_option_enable_easy_canada_tax" id="ec_option_enable_easy_canada_tax" onchange="ec_admin_update_canada_tax_display( );" value="1"<?php if( get_option('ec_option_enable_easy_canada_tax') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Advanced Canada Tax</div>
		<div id="ec_admin_use_canada_tax_section"<?php if( !get_option( 'ec_option_enable_easy_canada_tax' ) ){ ?> style="display:none;"<?php }?>>
			<span><strong>Province Rates</strong></span>
			<?php foreach( $provinces as $province ){
				foreach( $user_roles as $user_role ){ ?>
				<div class="ec_admin_canada_tax_label_row">
					<input type="checkbox" class="ec_admin_canada_tax_checkbox" name="ec_canada_tax[ec_option_collect_<?php echo $province; ?>_tax_<?php echo $user_role->role_label; ?>]" id="ec_canada_tax_<?php echo $province; ?>_<?php echo $user_role->role_label; ?>" value="1"<?php if( $canada_tax_options && isset( $canada_tax_options['ec_option_collect_' . $province . '_tax_' . $user_role->role_label] ) ){ echo ' checked="checked"'; } ?> onchange="ec_admin_update_province_canada_tax_display( '<?php echo $province; ?>', '<?php echo $user_role->role_label; ?>' );" />
					<span><?php echo $canada_tax_defaults[$province]['name']; ?> (<?php echo $user_role->role_label; ?>)</span>
				</div>
				<div class="ec_admin_canada_tax_rate_row" id="ec_admin_canada_tax_row_<?php echo $province; ?>_<?php echo $user_role->role_label; ?>"<?php if( !$canada_tax_options || !isset( $canada_tax_options['ec_option_collect_' . $province . '_tax_' . $user_role->role_label] ) ){ ?> style="display:none;"<?php }?>>
					<span>GST: </span><input class="ec_admin_canada_tax_gst_input" type="number" step=".01" name="ec_canada_tax[ec_option_<?php echo $province; ?>_tax_<?php echo $user_role->role_label; ?>_gst]" value="<?php if( $canada_tax_options ){ echo $canada_tax_options['ec_option_' . $province . '_tax_' . $user_role->role_label . '_gst']; }else{ echo $canada_tax_defaults[$province]['gst']; } ?>" />
					<span>PST: </span><input class="ec_admin_canada_tax_pst_input" type="number" step=".01" name="ec_canada_tax[ec_option_<?php echo $province; ?>_tax_<?php echo $user_role->role_label; ?>_pst]" value="<?php if( $canada_tax_options ){ echo $canada_tax_options['ec_option_' . $province . '_tax_' . $user_role->role_label . '_pst']; }else{ echo $canada_tax_defaults[$province]['pst']; } ?>" />
					<span>HST: </span><input class="ec_admin_canada_tax_hst_input" type="number" step=".01" name="ec_canada_tax[ec_option_<?php echo $province; ?>_tax_<?php echo $user_role->role_label; ?>_hst]" value="<?php if( $canada_tax_options ){ echo $canada_tax_options['ec_option_' . $province . '_tax_' . $user_role->role_label . '_hst']; }else{ echo $canada_tax_defaults[$province]['hst']; } ?>" />
				</div>
			
				<div class="ec_admin_settings_light_tax_divider" id="ec_admin_vat_country_tax_divider_<?php echo $province; ?>"></div>
			<?php
				}
			} ?>
		</div>
	</div>
	
	<div class="ec_admin_settings_input">
		<input type="submit" class="ec_admin_settings_simple_button" value="Save Setup" onclick="return ec_admin_update_canada_tax_rate( );" />
	</div>
	
	<div class="ec_admin_tax_spacer"></div>
	
</div>

<div class="ec_admin_settings_tax_clear"></div>