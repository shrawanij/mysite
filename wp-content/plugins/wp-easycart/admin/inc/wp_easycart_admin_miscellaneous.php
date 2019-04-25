<?php
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'wp_easycart_admin_miscellaneous' ) ) :

final class wp_easycart_admin_miscellaneous{
	
	protected static $_instance = null;
	
	private $wpdb;
	
	public $miscellaneous_file;
	public $settings_file;
	public $search_file;
	public $admin_file;
	
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
		$this->miscellaneous_file	 = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/miscellaneous/miscellaneous.php';
		$this->settings_file		 = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/miscellaneous/settings.php';
		$this->search_file		 	 = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/miscellaneous/search.php';
		$this->admin_file		 	 = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/miscellaneous/admin.php';
		
		// Actions
		add_filter( 'wp_easycart_admin_success_messages', array( $this, 'add_success_messages' ) );
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'process_enable_usage_tracking' ) );
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'process_disable_usage_tracking' ) );
		
		// Loaders
		add_action( 'wpeasycart_admin_miscellaneous', array( $this, 'load_miscellaneous_settings' ) );
		add_action( 'wpeasycart_admin_miscellaneous', array( $this, 'load_search_settings' ) );
		add_action( 'wpeasycart_admin_miscellaneous', array( $this, 'load_admin_settings' ) );
	}
	
	public function process_enable_usage_tracking( ){
		if( $_GET['ec_admin_form_action'] == "allow-usage-tracking" ){
			update_option( 'ec_option_allow_tracking', '1' );
			if( !function_exists( 'wp_easycart_admin_tracking' ) ){
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/inc/wp_easycart_admin_tracking.php' );
			}
			do_action( 'wpeasycart_admin_usage_tracking_accepted' );
			wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'initial-setup', array( 'success' => 'tracking-enabled' ) );
		}
	}
	
	public function process_disable_usage_tracking( ){
		if( $_GET['ec_admin_form_action'] == "deny-usage-tracking" ){
			update_option( 'ec_option_allow_tracking', '-1' );
			wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'miscellaneous', array( 'success' => 'tracking-disabled' ) );
		}
	}
	
	public function add_success_messages( $messages ){
		if( isset( $_GET['success'] ) && $_GET['success'] == 'tracking-enabled' ){
			$messages[] = 'Thank you for enabling usage data, we really appreciate it!';
		}else if( isset( $_GET['success'] ) && $_GET['success'] == 'tracking-disabled' ){
			$messages[] = 'Usage data has been disabled. If you change your mind you can always enable it here in the additional settings.';
		}
		return $messages;
	}
	
	public function load_miscellaneous( ){
		include( $this->miscellaneous_file );
	}
	
	public function load_miscellaneous_settings( ){
		include( $this->settings_file );
	}
	
	public function load_search_settings( ){
		include( $this->search_file );
	}
	
	public function load_admin_settings( ){
		include( $this->admin_file );
	}
	
	public function save_miscellaneous_admin_options( ){
		$ec_option_admin_product_show_stock_option  =  0;
		$ec_option_admin_product_show_shipping_option  =  0;
		$ec_option_admin_product_show_tax_option  =  0;
		$ec_option_admin_product_show_variant_option  =  0;
		$ec_option_enable_push_notifications = 0;
		
		if( isset( $_POST['ec_option_admin_product_show_stock_option'] ) && $_POST['ec_option_admin_product_show_stock_option'] == '1')
			$ec_option_admin_product_show_stock_option = 1;
		if( isset( $_POST['ec_option_admin_product_show_shipping_option'] ) && $_POST['ec_option_admin_product_show_shipping_option'] == '1')
			$ec_option_admin_product_show_shipping_option = 1;
		if( isset( $_POST['ec_option_admin_product_show_tax_option'] ) && $_POST['ec_option_admin_product_show_tax_option'] == '1')
			$ec_option_admin_product_show_tax_option = 1;
		if( isset( $_POST['ec_option_admin_product_show_variant_option'] ) && $_POST['ec_option_admin_product_show_variant_option'] == '1')
			$ec_option_admin_product_show_variant_option = 1;
		if( isset( $_POST['ec_option_enable_push_notifications'] ) && $_POST['ec_option_enable_push_notifications'] == '1')
			$ec_option_enable_push_notifications = 1;
		
		update_option( 'ec_option_admin_product_show_stock_option', $ec_option_admin_product_show_stock_option );
		update_option( 'ec_option_admin_product_show_shipping_option', $ec_option_admin_product_show_shipping_option );
		update_option( 'ec_option_admin_product_show_tax_option', $ec_option_admin_product_show_tax_option );
		update_option( 'ec_option_admin_product_show_variant_option', $ec_option_admin_product_show_variant_option );
		update_option( 'ec_option_enable_push_notifications', $ec_option_enable_push_notifications );
	}
	
	public function save_miscellaneous_search_options( ){
		$ec_option_use_live_search  =  0;
		$ec_option_search_title  =  0;
		$ec_option_search_model_number  =  0;
		$ec_option_search_manufacturer  =  0;
		$ec_option_search_description  =  0;
		$ec_option_search_short_description =  0;
		$ec_option_search_menu =  0;
		$ec_option_search_by_or =  0;
		
		if( isset( $_POST['ec_option_use_live_search'] ) && $_POST['ec_option_use_live_search'] == '1')
			$ec_option_use_live_search = 1 ;
		if( isset( $_POST['ec_option_search_title'] ) && $_POST['ec_option_search_title'] == '1')
			$ec_option_search_title = 1 ;
		if( isset( $_POST['ec_option_search_model_number'] ) && $_POST['ec_option_search_model_number'] == '1')
			$ec_option_search_model_number = 1 ;
		if( isset( $_POST['ec_option_search_manufacturer'] ) && $_POST['ec_option_search_manufacturer'] == '1')
			$ec_option_search_manufacturer = 1 ;
		if( isset( $_POST['ec_option_search_description'] ) && $_POST['ec_option_search_description'] == '1')
			$ec_option_search_description = 1 ;
		if( isset( $_POST['ec_option_search_short_description'] ) && $_POST['ec_option_search_short_description'] == '1')
			$ec_option_search_short_description = 1 ;
		if( isset( $_POST['ec_option_search_menu'] ) && $_POST['ec_option_search_menu'] == '1')
			$ec_option_search_menu = 1 ;
		if( isset( $_POST['ec_option_search_by_or'] ) && $_POST['ec_option_search_by_or'] == '1')
			$ec_option_search_by_or = 1 ;
		
		update_option( 'ec_option_use_live_search', $ec_option_use_live_search );
		update_option( 'ec_option_search_title', $ec_option_search_title );
		update_option( 'ec_option_search_model_number', $ec_option_search_model_number );
		update_option( 'ec_option_search_manufacturer', $ec_option_search_manufacturer );
		update_option( 'ec_option_search_description', $ec_option_search_description );
		update_option( 'ec_option_search_short_description', $ec_option_search_short_description );
		update_option( 'ec_option_search_menu', $ec_option_search_menu );
		update_option( 'ec_option_search_by_or', $ec_option_search_by_or );
	}
	
	public function save_miscellaneous_additional_options( ){
		$ec_option_cart_menu_id  =  '';
		$ec_option_hide_cart_icon_on_empty  =  0;
		$ec_option_enable_newsletter_popup  =  0;
		$ec_option_enable_gateway_log  =  0;
		$ec_option_use_inquiry_form  =  0;
		$ec_option_use_old_linking_style = 1;
		$ec_option_deconetwork_allow_blank_products  =  0;
		$ec_option_show_menu_cart_icon = 0;
		$ec_option_allow_tracking = -1;

		if( isset( $_POST['ec_option_cart_menu_id'] ))
			$ec_option_cart_menu_id = implode( '***', $_POST['ec_option_cart_menu_id'] )  ;
		if( isset( $_POST['ec_option_hide_cart_icon_on_empty'] ) && $_POST['ec_option_hide_cart_icon_on_empty'] == '1')
			$ec_option_hide_cart_icon_on_empty = 1;
		if( isset( $_POST['ec_option_enable_newsletter_popup'] ) && $_POST['ec_option_enable_newsletter_popup'] == '1')
			$ec_option_enable_newsletter_popup = 1;
		if( isset( $_POST['ec_option_enable_gateway_log'] ) && $_POST['ec_option_enable_gateway_log'] == '1')
			$ec_option_enable_gateway_log = 1;
		if( isset( $_POST['ec_option_use_inquiry_form'] ) && $_POST['ec_option_use_inquiry_form'] == '1')
			$ec_option_use_inquiry_form = 1;
		if( isset( $_POST['ec_option_packing_slip_show_pricing'] ) && $_POST['ec_option_packing_slip_show_pricing'] == '1')
			$ec_option_packing_slip_show_pricing = 1;
		if( isset( $_POST['ec_option_use_old_linking_style'] ) && $_POST['ec_option_use_old_linking_style'] == '1')
			$ec_option_use_old_linking_style = 0;
		if( isset( $_POST['ec_option_deconetwork_allow_blank_products'] ) && $_POST['ec_option_deconetwork_allow_blank_products'] == '1')
			$ec_option_deconetwork_allow_blank_products = 1;
		if( isset( $_POST['ec_option_allow_tracking'] ) && $_POST['ec_option_allow_tracking'] == '1')
			$ec_option_allow_tracking = 1;
		if( $ec_option_cart_menu_id != '0' )
			$ec_option_show_menu_cart_icon = 1;
			
		update_option( 'ec_option_show_menu_cart_icon', $ec_option_show_menu_cart_icon );
		update_option( 'ec_option_cart_menu_id', $ec_option_cart_menu_id );
		update_option( 'ec_option_hide_cart_icon_on_empty', $ec_option_hide_cart_icon_on_empty );
		update_option( 'ec_option_enable_newsletter_popup', $ec_option_enable_newsletter_popup );
		update_option( 'ec_option_enable_gateway_log', $ec_option_enable_gateway_log );
		update_option( 'ec_option_use_inquiry_form', $ec_option_use_inquiry_form );
		update_option( 'ec_option_packing_slip_show_pricing', $ec_option_packing_slip_show_pricing );
		update_option( 'ec_option_use_old_linking_style', $ec_option_use_old_linking_style );
		update_option( 'ec_option_allow_tracking', $ec_option_allow_tracking );
		update_option( 'ec_option_deconetwork_allow_blank_products', $ec_option_deconetwork_allow_blank_products );
		update_option( 'ec_option_abandoned_cart_days', $_POST['ec_option_abandoned_cart_days'] );
	}
	
	public function clear_stats( ) {
		global $wpdb;
		$results = $wpdb->query( $wpdb->prepare( "UPDATE ec_menulevel1, ec_menulevel2, ec_menulevel3 SET ec_menulevel1.clicks = 0, ec_menulevel2.clicks = 0, ec_menulevel3.clicks = 0"));
		$results = $wpdb->query( $wpdb->prepare( "UPDATE ec_product SET ec_product.views = 0"));
	}
	
	public function delete_gateway_log( ) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "DELETE FROM ec_webhook" ) );
		$wpdb->query( $wpdb->prepare( "DELETE FROM ec_response") );
	}
	
	public function download_gateway_log( ) {
		global $wpdb;
		$header = "";
		$data = "";
		$results = $wpdb->get_results( "SELECT * FROM ec_response ORDER BY ec_response.response_id ASC", ARRAY_A );
		
		if( count( $results ) > 0 ){
		
			$keys = array_keys( $results[0] );
			
			foreach( $keys as $key ){
				$header .= $key."\t";
			}
		
			foreach( $results as $result ){
				//echo 'data3';
				$line = '';
				foreach( $result as $value ){
		
					if( !isset( $value ) || $value == "" ){
						$value = "\t";
		
					}else{
						$value = str_replace( '"', '""', $value);
						$value = '"' . utf8_decode($value) . '"' . "\t";
		
					}
		
					$line .= $value;
		
				}
		
				$data .= trim( $line )."\n";
		
			}
			
			$data = str_replace( "\r", "", $data );
		
		}else{
			$data = "\nno matching records found\n";
		}
		
		header("Content-type: application/vnd.ms-excel");
		header("Content-Transfer-Encoding: binary"); 
		header("Content-Disposition: attachment; filename=gatewaylog.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $header."\n".$data; 
		die();
	}
}
endif; // End if class_exists check

function wp_easycart_admin_miscellaneous( ){
	return wp_easycart_admin_miscellaneous::instance( );
}
wp_easycart_admin_miscellaneous( );

add_action( 'wp_ajax_ec_admin_ajax_clear_stats', 'ec_admin_ajax_clear_stats' );
function ec_admin_ajax_clear_stats( ) {
	wp_easycart_admin_miscellaneous( )->clear_stats( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_miscellaneous_search_options', 'ec_admin_ajax_save_miscellaneous_search_options' );
function ec_admin_ajax_save_miscellaneous_search_options( ){
	wp_easycart_admin_miscellaneous( )->save_miscellaneous_search_options( );
	die( );
}
add_action( 'wp_ajax_ec_admin_ajax_save_miscellaneous_additional_options', 'ec_admin_ajax_save_miscellaneous_additional_options' );
function ec_admin_ajax_save_miscellaneous_additional_options( ){
	wp_easycart_admin_miscellaneous( )->save_miscellaneous_additional_options( );
	die( );
}
add_action( 'wp_ajax_ec_admin_ajax_save_miscellaneous_admin_options', 'ec_admin_ajax_save_miscellaneous_admin_options' );
function ec_admin_ajax_save_miscellaneous_admin_options( ){
	wp_easycart_admin_miscellaneous( )->save_miscellaneous_admin_options( );
	die( );
}