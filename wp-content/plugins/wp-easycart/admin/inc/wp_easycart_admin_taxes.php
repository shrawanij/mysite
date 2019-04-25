<?php
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'wp_easycart_admin_taxes' ) ) :

final class wp_easycart_admin_taxes{
	
	protected static $_instance = null;
	
	private $wpdb;
	
	public $taxes_setup_file;
	public $success_messages_file;
	public $tax_by_state_file;
	public $tax_by_country_file;
	public $global_tax_file;
	public $duty_setup_file;
	public $vat_setup_file;
	public $canada_tax_setup;
	public $upgrade_file;
	
	public static function instance( ) {
		
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self(  );
		}
		return self::$_instance;
	
	}
		
	public function __construct( ){
		// Keep reference to wpdb
		global $wpdb;
		$this->wpdb =& $wpdb;
		
		// Setup File Names 
		$this->tax_setup_file 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/taxes/tax-setup.php';
		$this->success_messages_file 		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/taxes/success-messages.php';
		$this->tax_by_state_setup_file		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/taxes/tax-by-state-setup.php';
		$this->tax_by_country_setup_file 	= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/taxes/tax-by-country-setup.php';
		$this->global_tax_setup_file 		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/taxes/global-tax-setup.php';
		$this->duty_setup_file 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/taxes/duty-tax-setup.php';
		$this->vat_setup_file 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/taxes/vat-setup.php';
		$this->canada_tax_setup_file 		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/taxes/canada-tax-setup.php';
		$this->upgrade_file 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/upgrade/upgrade-simple.php';
		
		// Actions
		add_action( 'wpeasycart_admin_taxes_success', array( $this, 'load_success_messages' ) );
		add_action( 'wpeasycart_admin_tax_setup', array( $this, 'load_tax_by_state_setup' ) );
		add_action( 'wpeasycart_admin_tax_setup', array( $this, 'load_tax_by_country_setup' ) );
		add_action( 'wpeasycart_admin_tax_setup', array( $this, 'load_global_tax_setup' ) );
		add_action( 'wpeasycart_admin_tax_setup', array( $this, 'load_duty_setup' ) );
		add_action( 'wpeasycart_admin_tax_setup', array( $this, 'load_vat_setup' ) );
		add_action( 'wpeasycart_admin_tax_setup', array( $this, 'load_tax_cloud_setup' ) );
		add_action( 'wpeasycart_admin_tax_setup', array( $this, 'load_canada_tax_setup' ) );
		
		add_action( 'init', array( $this, 'save_settings' ) );
	}
	
	public function load_tax_setup( ){
		include( $this->tax_setup_file );
	}
	
	public function load_success_messages( ){
		include( $this->success_messages_file );
	}
	
	public function load_tax_by_state_setup( ){
		include( $this->tax_by_state_setup_file );
	}
	
	public function load_tax_by_country_setup( ){
		include( $this->tax_by_country_setup_file );
	}
	
	public function load_global_tax_setup( ){
		include( $this->global_tax_setup_file );
	}
	
	public function load_duty_setup( ){
		include( $this->duty_setup_file );
	}
	
	public function load_vat_setup( ){
		include( $this->vat_setup_file );
	}
	
	public function load_canada_tax_setup( ){
		include( $this->canada_tax_setup_file );
	}
	
	public function load_tax_cloud_setup( ){
		$upgrade_icon = "dashicons-cloud";
		$upgrade_title = "Tax Cloud for USA";
		$upgrade_subtitle = "TaxCloud API Information";
		$upgrade_checkbox_label = apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; margin-top:5px;"></span>' ) . " Enable TaxCloud";
		$upgrade_button_label = "Save Setup";
		include( $this->upgrade_file );
	}
	
	/* State Tax Rates */
	public function save_state_tax_rate( $taxrate_id, $state_id, $rate ){
		$state = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM ec_state WHERE id_sta = %d", $state_id ) );
		$country = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM ec_country WHERE id_cnt = %d", $state->idcnt_sta ) );
		$this->wpdb->query( $this->wpdb->prepare( "UPDATE ec_taxrate SET state_code = %s, country_code = %s, state_rate = %s WHERE taxrate_id = %d", $state->code_sta, $country->iso2_cnt, $rate, $taxrate_id ) );
	}
	
	public function add_state_tax_rate( $state_id, $rate ){
		$state = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM ec_state WHERE id_sta = %d", $state_id ) );
		$country = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM ec_country WHERE id_cnt = %d", $state->idcnt_sta ) );
		$this->wpdb->query( $this->wpdb->prepare( "INSERT INTO ec_taxrate( tax_by_state, state_code, country_code, state_rate ) VALUES( 1, %s, %s, %s )", $state->code_sta, $country->iso2_cnt, $rate ) );
		return $this->wpdb->insert_id;
	}
	
	public function delete_state_tax_rate( $taxrate_id ){
		$this->wpdb->query( $this->wpdb->prepare( "DELETE FROM ec_taxrate WHERE taxrate_id = %d", $taxrate_id ) );
		$rates = $this->wpdb->get_results( "SELECT * FROM ec_taxrate WHERE tax_by_state = 1" );
		return count( $rates );
	}
	
	/* Country Tax Rates */
	public function save_country_tax_rate( $taxrate_id, $country_id, $rate ){
		$country = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM ec_country WHERE id_cnt = %d", $country_id ) );
		$this->wpdb->query( $this->wpdb->prepare( "UPDATE ec_taxrate SET country_code = %s, country_rate = %s WHERE taxrate_id = %d", $country->iso2_cnt, $rate, $taxrate_id ) );
	}
	
	public function add_country_tax_rate( $country_id, $rate ){
		$country = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM ec_country WHERE id_cnt = %d", $country_id ) );
		$this->wpdb->query( $this->wpdb->prepare( "INSERT INTO ec_taxrate( tax_by_country, country_code, country_rate ) VALUES( 1, %s, %s )", $country->iso2_cnt, $rate ) );
		return $this->wpdb->insert_id;
	}
	
	public function delete_country_tax_rate( $taxrate_id ){
		$this->wpdb->query( $this->wpdb->prepare( "DELETE FROM ec_taxrate WHERE taxrate_id = %d", $taxrate_id ) );
		$rates = $this->wpdb->get_results( "SELECT * FROM ec_taxrate WHERE tax_by_country = 1" );
		return count( $rates );
	}
	
	/* Global Tax Rate */
	public function save_global_tax_rate( ){
		if( !isset( $_POST['ec_option_use_global_tax'] ) || $_POST['ec_option_use_global_tax'] == 0 ){
			$this->wpdb->query( $this->wpdb->prepare( "DELETE FROM ec_taxrate WHERE taxrate_id = %d", $_POST['ec_global_taxrate_id'] ) );
			return 0;
		}if( $_POST['ec_global_taxrate_id'] ){
			$this->wpdb->query( $this->wpdb->prepare( "UPDATE ec_taxrate SET all_rate = %s WHERE taxrate_id = %d", $_POST['ec_global_tax_rate'], $_POST['ec_global_taxrate_id'] ) );
			return $_POST['ec_global_tax_rate'];
		}else{
			$this->wpdb->query( $this->wpdb->prepare( "INSERT INTO ec_taxrate( tax_by_all, all_rate ) VALUES( 1, %s )", $_POST['ec_global_tax_rate'] ) );
			return $this->wpdb->insert_id;
		}
	}
	
	/* Duty Tax Rate */
	public function save_duty_tax_rate( ){
		$country = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT ec_country.* FROM ec_country WHERE id_cnt = %d", $_POST['ec_duty_exempt_country_code'] ) );
		if( !isset( $_POST['ec_option_use_duty_tax'] ) || $_POST['ec_option_use_duty_tax'] == 0 ){
			$this->wpdb->query( $this->wpdb->prepare( "DELETE FROM ec_taxrate WHERE taxrate_id = %d", $_POST['ec_duty_taxrate_id'] ) );
			return 0;
		}if( $_POST['ec_duty_taxrate_id'] ){
			$this->wpdb->query( $this->wpdb->prepare( "UPDATE ec_taxrate SET duty_rate = %s, duty_exempt_country_code = %s WHERE taxrate_id = %d", $_POST['ec_duty_tax_rate'], $country->iso2_cnt, $_POST['ec_duty_taxrate_id'] ) );
			return $_POST['ec_global_tax_rate'];
		}else{
			$this->wpdb->query( $this->wpdb->prepare( "INSERT INTO ec_taxrate( tax_by_duty, duty_rate, duty_exempt_country_code ) VALUES( 1, %s, %s )", $_POST['ec_duty_tax_rate'], $country->iso2_cnt ) );
			return $this->wpdb->insert_id;
		}
	}
	
	/* VAT Tax Rate */
	public function save_vat_tax_rate( ){
		$tax_by_vat = 0;
		$tax_by_single_vat = 0;
		$vat_added = 0;
		$vat_included = 0;
		$ec_option_validate_vat_registration_number = 0;
		$ec_option_vatlayer_api_key = $_POST['ec_option_vatlayer_api_key'];
		
		if( $_POST['ec_vat_type'] == "tax_by_single_vat" )
			$tax_by_single_vat = 1;
		else if( $_POST['ec_vat_type'] == "tax_by_vat" )
			$tax_by_vat = 1;
			
		if( $_POST['ec_vat_pricing_method'] == "vat_added" )
			$vat_added = 1;
		else if( $_POST['ec_vat_pricing_method'] == "vat_included" )
			$vat_included = 1;
			
		if( isset( $_POST['ec_option_validate_vat_registration_number'] ) && $_POST['ec_option_validate_vat_registration_number'] == '1' )
			$ec_option_validate_vat_registration_number = 1;
		
		update_option( 'ec_option_validate_vat_registration_number', $ec_option_validate_vat_registration_number );
		update_option( 'ec_option_vatlayer_api_key', $ec_option_vatlayer_api_key );
		
		if( $_POST['ec_vat_type'] == "0" ){
			$this->wpdb->query( $this->wpdb->prepare( "DELETE FROM ec_taxrate WHERE taxrate_id = %d", $_POST['ec_vat_taxrate_id'] ) );
			return 0;
		
		}else if( $_POST['ec_vat_taxrate_id'] != 0 ){
			$this->wpdb->query( $this->wpdb->prepare( "UPDATE ec_taxrate SET tax_by_vat = %d, tax_by_single_vat = %d, vat_added = %d, vat_included = %d, vat_rate = %d WHERE taxrate_id = %d", $tax_by_vat, $tax_by_single_vat, $vat_added, $vat_included, $_POST['ec_default_vat_rate'], $_POST['ec_vat_taxrate_id'] ) );
			return $_POST['ec_vat_taxrate_id'];
		
		}else{
			$this->wpdb->query( $this->wpdb->prepare( "INSERT INTO ec_taxrate( tax_by_vat, tax_by_single_vat, vat_added, vat_included, vat_rate ) VALUES( %d, %d, %d, %d, %s )", $tax_by_vat, $tax_by_single_vat, $vat_added, $vat_included, $_POST['ec_default_vat_rate'] ) );
			return $this->wpdb->insert_id;
		}
	}
	
	public function save_vat_country_tax_rate( $country_id, $rate ){
		$this->wpdb->query( $this->wpdb->prepare( "UPDATE ec_country SET vat_rate_cnt = %s WHERE id_cnt = %d", $rate, $country_id ) );
	}
	
	/* Canada Tax Rates */
	public function save_canada_tax_rate( ){
		update_option( 'ec_option_enable_easy_canada_tax', $_POST['ec_option_enable_easy_canada_tax'] );
		update_option( 'ec_option_canada_tax_options', $_POST['ec_canada_tax'] );
	}
	
	/* Tax Cloud */
	public function save_tax_cloud( ){
		update_option( 'ec_option_tax_cloud_api_id', $_POST['ec_option_tax_cloud_api_id'] );
		update_option( 'ec_option_tax_cloud_api_key', $_POST['ec_option_tax_cloud_api_key'] );
		update_option( 'ec_option_tax_cloud_address', $_POST['ec_option_tax_cloud_address'] );
		update_option( 'ec_option_tax_cloud_city', $_POST['ec_option_tax_cloud_city'] );
		update_option( 'ec_option_tax_cloud_state', $_POST['ec_option_tax_cloud_state'] );
		update_option( 'ec_option_tax_cloud_zip', $_POST['ec_option_tax_cloud_zip'] );
	}
	
}
endif; // End if class_exists check

function wp_easycart_admin_taxes( ){
	return wp_easycart_admin_taxes::instance( );
}
wp_easycart_admin_taxes( );

/* Tax Rate Hooks - State Tax Rates */
add_action( 'wp_ajax_ec_admin_ajax_save_state_tax_rate', 'ec_admin_ajax_save_state_tax_rate' );
function ec_admin_ajax_save_state_tax_rate( ){
	wp_easycart_admin_taxes( )->save_state_tax_rate( $_POST['taxrate_id'], $_POST['state_id'], $_POST['rate'] );
	die( );

}

add_action( 'wp_ajax_ec_admin_ajax_delete_state_tax_rate', 'ec_admin_ajax_delete_state_tax_rate' );
function ec_admin_ajax_delete_state_tax_rate( ){
	$rate_count = wp_easycart_admin_taxes( )->delete_state_tax_rate( $_POST['taxrate_id'] );
	echo $rate_count;
	die( );

}

add_action( 'wp_ajax_ec_admin_ajax_insert_state_tax_rate', 'ec_admin_ajax_insert_state_tax_rate' );
function ec_admin_ajax_insert_state_tax_rate( ){
	global $wpdb;
	$taxrate_id = wp_easycart_admin_taxes( )->add_state_tax_rate( $_POST['state_id'], $_POST['rate'] );
	if( $taxrate_id ){
		$state_tax_rate = $wpdb->get_row( $wpdb->prepare( "SELECT ec_taxrate.*, ec_state.name_sta, ec_country.name_cnt FROM ec_taxrate LEFT JOIN ec_country ON ( ec_country.iso2_cnt = ec_taxrate.country_code ) LEFT JOIN ec_state ON (ec_state.code_sta = ec_taxrate.state_code AND idcnt_sta = ec_country.iso2_cnt ) WHERE taxrate_id = %d ORDER BY ec_country.`sort_order` ASC, ec_state.name_sta ASC, ec_taxrate.`state_code` ASC", $taxrate_id ) );
		$states = $wpdb->get_results( "SELECT ec_state.*, ec_country.iso2_cnt as country_code FROM ec_state LEFT JOIN ec_country ON ec_country.id_cnt = ec_state.idcnt_sta ORDER BY ec_country.sort_order ASC, ec_state.name_sta ASC" );
					
		echo '<div class="ec_admin_tax_row" id="ec_admin_state_tax_row_' . $taxrate_id . '">
					<span>
					<select name="ec_state_code_' . $taxrate_id . '" id="ec_state_code_' . $taxrate_id . '" style="float:left;">
						<option value="0">Select a State</option>';
						foreach( $states as $state ){
							echo '<option value="' . $state->id_sta . '"';
							if( $state->code_sta == $state_tax_rate->state_code && ( $state_tax_rate->country_code == "" || $state_tax_rate->country_code == $state->country_code ) ){
								echo ' selected="selected"';
							}
							echo '>' . $state->name_sta . '</option>';
						}
					echo '</select>
					</span>
					<span class="ec_admin_settings_tax_percentage">%</span>
					<input type="number" value="' . $state_tax_rate->state_rate . '" step=".001" name="state_tax_rate_' . $state_tax_rate->taxrate_id . '" id="state_tax_rate_' . $state_tax_rate->taxrate_id . '" />
				</div>
				<div class="ec_admin_tax_button_row" id="ec_admin_state_tax_button_row_' . $taxrate_id . '">
					<span><input class="ec_admin_tax_link_button" type="submit" value="Save" onclick="return ec_admin_save_state_tax( \'' . $taxrate_id . '\' );" />
					<span class="ec_admin_tax_button_divider"> | </span>
					<a href="admin.php?page=wp-easycart-settings&subpage=tax&ec_admin_action=delete_tax_row&taxrate_id=' . $state_tax_rate->taxrate_id . '" class="ec_admin_tax_link" onclick="return ec_admin_delete_state_tax_rate( \'' . $state_tax_rate->taxrate_id . '\' );">Delete</a></span>
				</div>
				<div class="ec_admin_settings_light_tax_divider" id="ec_admin_state_tax_divider_' . $taxrate_id . '"></div>';
						
	}else{
		echo "error";
	}
	die( );

}

/* Tax Rate Hooks - Country Tax Rates */
add_action( 'wp_ajax_ec_admin_ajax_save_country_tax_rate', 'ec_admin_ajax_save_country_tax_rate' );
function ec_admin_ajax_save_country_tax_rate( ){
	wp_easycart_admin_taxes( )->save_country_tax_rate( $_POST['taxrate_id'], $_POST['country_id'], $_POST['rate'] );
	die( );

}

add_action( 'wp_ajax_ec_admin_ajax_delete_country_tax_rate', 'ec_admin_ajax_delete_country_tax_rate' );
function ec_admin_ajax_delete_country_tax_rate( ){
	$rate_count = wp_easycart_admin_taxes( )->delete_country_tax_rate( $_POST['taxrate_id'] );
	echo $rate_count;
	die( );

}

add_action( 'wp_ajax_ec_admin_ajax_insert_country_tax_rate', 'ec_admin_ajax_insert_country_tax_rate' );
function ec_admin_ajax_insert_country_tax_rate( ){
	global $wpdb;
	$taxrate_id = wp_easycart_admin_taxes( )->add_country_tax_rate( $_POST['country_id'], $_POST['rate'] );
	if( $taxrate_id ){
		$country_tax_rate = $wpdb->get_row( $wpdb->prepare( "SELECT ec_taxrate.*, ec_country.name_cnt FROM ec_taxrate LEFT JOIN ec_country ON ec_country.iso2_cnt = ec_taxrate.country_code WHERE ec_taxrate.taxrate_id = %d ORDER BY ec_country.sort_order ASC", $taxrate_id ) );
		$countries = $wpdb->get_results( "SELECT * FROM ec_country ORDER BY sort_order ASC" );
					
		echo '<div class="ec_admin_tax_row" id="ec_admin_country_tax_row_' . $taxrate_id . '">
					<span>
					<select name="ec_country_code_' . $taxrate_id . '" id="ec_country_code_' . $taxrate_id . '" style="float:left;">
						<option value="0">Select a country</option>';
						foreach( $countries as $country ){
							echo '<option value="' . $country->id_cnt . '"';
							if( $country->iso2_cnt == $country_tax_rate->country_code && ( $country_tax_rate->country_code == "" || $country_tax_rate->country_code == $country->iso2_cnt ) ){
								echo ' selected="selected"';
							}
							echo '>' . $country->name_cnt . '</option>';
						}
					echo '</select>
					</span>
					<span class="ec_admin_settings_tax_percentage">%</span>
					<input type="number" value="' . $country_tax_rate->country_rate . '" step=".001" name="country_tax_rate_' . $country_tax_rate->taxrate_id . '" id="country_tax_rate_' . $country_tax_rate->taxrate_id . '" />
				</div>
				<div class="ec_admin_tax_button_row" id="ec_admin_country_tax_button_row_' . $taxrate_id . '">
					<span><input class="ec_admin_tax_link_button" type="submit" value="Save" onclick="return ec_admin_save_country_tax( \'' . $taxrate_id . '\' );" />
					<span class="ec_admin_tax_button_divider"> | </span>
					<a href="admin.php?page=wp-easycart-settings&subpage=tax&ec_admin_action=delete_tax_row&taxrate_id=' . $country_tax_rate->taxrate_id . '" class="ec_admin_tax_link" onclick="return ec_admin_delete_country_tax_rate( \'' . $country_tax_rate->taxrate_id . '\' );">Delete</a></span>
				</div>
				<div class="ec_admin_settings_light_tax_divider" id="ec_admin_country_tax_divider_' . $taxrate_id . '"></div>';
						
	}else{
		echo "error";
	}
	die( );

}

/* Tax Rate Hooks - Global Tax Rates */
add_action( 'wp_ajax_ec_admin_ajax_update_global_tax_rate', 'ec_admin_ajax_update_global_tax_rate' );
function ec_admin_ajax_update_global_tax_rate( ){
	$taxrate_id = wp_easycart_admin_taxes( )->save_global_tax_rate( );
	echo $taxrate_id;
	die( );

}

/* Tax Rate Hooks - Duty Tax Rates */
add_action( 'wp_ajax_ec_admin_ajax_update_duty_tax_rate', 'ec_admin_ajax_update_duty_tax_rate' );
function ec_admin_ajax_update_duty_tax_rate( ){
	$taxrate_id = wp_easycart_admin_taxes( )->save_duty_tax_rate( );
	echo $taxrate_id;
	die( );

}

/* Tax Rate Hooks - VAT Tax Rates */
add_action( 'wp_ajax_ec_admin_ajax_update_vat_tax_rate', 'ec_admin_ajax_update_vat_tax_rate' );
function ec_admin_ajax_update_vat_tax_rate( ){
	$taxrate_id = wp_easycart_admin_taxes( )->save_vat_tax_rate( );
	echo $taxrate_id;
	die( );

}

add_action( 'wp_ajax_ec_admin_ajax_insert_vat_country_tax_rate', 'ec_admin_ajax_insert_vat_country_tax_rate' );
function ec_admin_ajax_insert_vat_country_tax_rate( ){
	global $wpdb;
	wp_easycart_admin_taxes( )->save_vat_country_tax_rate( $_POST['ec_new_vat_country_code'], $_POST['ec_new_vat_country_rate'] );
	
	$country = $wpdb->get_row( $wpdb->prepare( "SELECT ec_country.* FROM ec_country WHERE id_cnt = %d", $_POST['ec_new_vat_country_code'] ) );
	echo '<div class="ec_admin_tax_row" id="ec_admin_vat_country_tax_row_' . $country->id_cnt . '">
					<span>' . $country->name_cnt . '</span>
					<span class="ec_admin_settings_tax_percentage">%</span>
					<input type="number" value="' . $country->vat_rate_cnt . '" step=".001" name="vat_country_tax_rate_' . $country->id_cnt . '" id="vat_country_tax_rate_' . $country->taxrate_id . '" />
				</div>
				<div class="ec_admin_tax_button_row" id="ec_admin_vat_country_tax_button_row_' . $country->id_cnt . '">
					<span><input class="ec_admin_tax_link_button" type="submit" value="Save" onclick="return ec_admin_save_vat_country_tax( \'' . $country->id_cnt . '\' );" />
					<span class="ec_admin_tax_button_divider"> | </span>
					<a href="admin.php?page=wp-easycart-settings&subpage=tax&ec_admin_action=delete_vat_country_tax_row&id_cnt=' . $country_tax_rate->taxrate_id . '" class="ec_admin_tax_link" onclick="return ec_admin_delete_vat_country_tax_rate( \'' . $country->id_cnt . '\' );">Delete</a></span>
				</div>
				<div class="ec_admin_settings_light_tax_divider" id="ec_admin_vat_country_tax_divider_' . $country->id_cnt . '"></div>';
	die( );

}

add_action( 'wp_ajax_ec_admin_ajax_save_vat_country_tax_rate', 'ec_admin_ajax_save_vat_country_tax_rate' );
function ec_admin_ajax_save_vat_country_tax_rate( ){
	wp_easycart_admin_taxes( )->save_vat_country_tax_rate( $_POST['country_id'], $_POST['rate'] );
	die( );

}

add_action( 'wp_ajax_ec_admin_ajax_delete_vat_country_tax_rate', 'ec_admin_ajax_delete_vat_country_tax_rate' );
function ec_admin_ajax_delete_vat_country_tax_rate( ){
	global $wpdb;
	wp_easycart_admin_taxes( )->save_vat_country_tax_rate( $_POST['country_id'], 0 );
	$rows = $wpdb->get_results( "SELECT * FROM ec_country WHERE vat_rate_cnt > 0" );
	echo count( $rows );
	die( );

}

/* Tax Rate Hooks - Canada Tax Rates */
add_action( 'wp_ajax_ec_admin_ajax_update_canada_country_tax_rate', 'ec_admin_ajax_update_canada_country_tax_rate' );
function ec_admin_ajax_update_canada_country_tax_rate( ){
	wp_easycart_admin_taxes( )->save_canada_tax_rate( );
	die( );

}