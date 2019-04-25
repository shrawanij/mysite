<?php
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'wp_easycart_admin_live_shipping_rates' ) ) :

final class wp_easycart_admin_live_shipping_rates{
	
	protected static $_instance = null;
	
	public $upgrade_file;
	public $upgrade_live_shipping_file;
	
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
		
		// Setup Files and Actions
		$this->upgrade_file = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/upgrade/upgrade-screen.php';
		$this->upgrade_live_shipping_file	= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/shipping/live-shipping-upgrade.php';
		
		add_action( 'wpeasycart_admin_shipping_rates', array( $this, 'load_live_rates' ) );
		
		add_action( 'wpeasycart_admin_shipping_setup', array( $this, 'load_australia_post_setup' ) );
		add_action( 'wpeasycart_admin_shipping_setup', array( $this, 'load_canada_post_setup' ) );
		add_action( 'wpeasycart_admin_shipping_setup', array( $this, 'load_dhl_setup' ) );
		add_action( 'wpeasycart_admin_shipping_setup', array( $this, 'load_fedex_setup' ) );
		add_action( 'wpeasycart_admin_shipping_setup', array( $this, 'load_ups_setup' ) );
		add_action( 'wpeasycart_admin_shipping_setup', array( $this, 'load_usps_setup' ) );
		
	}
	
	public function load_live_rates( ){
		echo '<div style="width:100% !important;" class="ec_admin_settings_input ec_admin_settings_shipping_section ec_admin_settings_';
		if( wp_easycart_admin( )->settings->shipping_method == "live" ){
			echo 'show';
		}else{
			echo 'hide';
		}
		echo '" id="live">';
		include( $this->upgrade_file );
		echo '</div>';
	}
	
	public function load_australia_post_setup( ){
		$live_rate_upgrade_title = 'Australia Post Live Rates';
		$live_rate_upgrade_label = 'Enable Australia Post Live Shipping Rates';
		$live_rate_upgrade_var = 'australia_post';
		include( $this->upgrade_live_shipping_file );
	}
	
	public function load_canada_post_setup( ){
		$live_rate_upgrade_title = 'Canada Post Live Rates';
		$live_rate_upgrade_label = 'Enable Canada Post Live Shipping Rates';
		$live_rate_upgrade_var = 'canada_post';
		include( $this->upgrade_live_shipping_file );
	}
	
	public function load_dhl_setup( ){
		$live_rate_upgrade_title = 'DHL Live Rates';
		$live_rate_upgrade_label = 'Enable DHL Live Shipping Rates';
		$live_rate_upgrade_var = 'dhl';
		include( $this->upgrade_live_shipping_file );
	}
	
	public function load_fedex_setup( ){
		$live_rate_upgrade_title = 'FedEx Live Rates';
		$live_rate_upgrade_label = 'Enable FedEx Live Shipping Rates';
		$live_rate_upgrade_var = 'fedex';
		include( $this->upgrade_live_shipping_file );
	}
	
	public function load_ups_setup( ){
		$live_rate_upgrade_title = 'UPS Live Rates';
		$live_rate_upgrade_label = 'Enable UPS Live Shipping Rates';
		$live_rate_upgrade_var = 'ups';
		include( $this->upgrade_live_shipping_file );
	}
	
	public function load_usps_setup( ){
		$live_rate_upgrade_title = 'USPS Live Rates';
		$live_rate_upgrade_label = 'Enable USPS Live Shipping Rates';
		$live_rate_upgrade_var = 'usps';
		include( $this->upgrade_live_shipping_file );
	}
}
endif; // End if class_exists check

function wp_easycart_admin_live_shipping_rates( ){
	return wp_easycart_admin_live_shipping_rates::instance( );
}
wp_easycart_admin_live_shipping_rates( );