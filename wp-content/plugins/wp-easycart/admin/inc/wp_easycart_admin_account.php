<?php
class wp_easycart_admin_account{
	
	private $wpdb;
	
	public $account_file;
	public $settings_file;
		
	public function __construct( ){
		// Keep reference to wpdb
		global $wpdb;
		$this->wpdb =& $wpdb;
		
		// Setup File Names 
		$this->account_file	 						= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/account/account.php';
		$this->settings_file		 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/account/settings.php';
		
		// Actions
		add_action( 'wpeasycart_admin_account_settings', array( $this, 'load_success_messages' ) );
		add_action( 'wpeasycart_admin_account_settings', array( $this, 'load_account_settings' ) );
		add_action( 'init', array( $this, 'save_settings' ) );
	}
	
	public function load_account( ){
		include( $this->account_file );
	}
	
	public function load_success_messages( ){
		//include( $this->success_messages_file );
	}
	
	public function load_account_settings( ){
		include( $this->settings_file );
	}
	
	public function save_account_settings( ) {
		$ec_option_require_account_terms = 0;
		$ec_option_require_account_address = 0;
		$ec_option_require_email_validation = 0;
		$ec_option_enable_recaptcha = 0;
		$ec_option_recaptcha_site_key = $_POST['ec_option_recaptcha_site_key'];
		$ec_option_recaptcha_secret_key = $_POST['ec_option_recaptcha_secret_key'];
		$ec_option_show_account_subscriptions_link = 0;
		$ec_option_enable_user_notes = 0;
		$ec_option_show_subscriber_feature = 0;
		$ec_subscriptions_use_first_order_details = 0;
		
		if( isset( $_POST['ec_option_require_account_terms'] ) && $_POST['ec_option_require_account_terms'] == '1')
			$ec_option_require_account_terms = 1 ;
		if( isset( $_POST['ec_option_require_account_address'] ) && $_POST['ec_option_require_account_address'] == '1')
			$ec_option_require_account_address = 1 ;
		if( isset( $_POST['ec_option_require_email_validation'] ) && $_POST['ec_option_require_email_validation'] == '1')
			$ec_option_require_email_validation = 1 ;
		if( isset( $_POST['ec_option_enable_recaptcha'] ) && $_POST['ec_option_enable_recaptcha'] == '1')
			$ec_option_enable_recaptcha = 1 ;
		if( isset( $_POST['ec_option_show_account_subscriptions_link'] ) && $_POST['ec_option_show_account_subscriptions_link'] == '1')
			$ec_option_show_account_subscriptions_link = 1 ;
		if( isset( $_POST['ec_option_enable_user_notes'] ) && $_POST['ec_option_enable_user_notes'] == '1')
			$ec_option_enable_user_notes = 1 ;
		if( isset( $_POST['ec_option_show_subscriber_feature'] ) && $_POST['ec_option_show_subscriber_feature'] == '1')
			$ec_option_show_subscriber_feature = 1 ;
		if( isset( $_POST['ec_subscriptions_use_first_order_details'] ) && $_POST['ec_subscriptions_use_first_order_details'] == '1')
			$ec_subscriptions_use_first_order_details = 1 ;

		update_option( 'ec_option_require_account_terms', $ec_option_require_account_terms );
		update_option( 'ec_option_require_account_address', $ec_option_require_account_address );
		update_option( 'ec_option_require_email_validation', $ec_option_require_email_validation );
		update_option( 'ec_option_enable_recaptcha', $ec_option_enable_recaptcha );
		update_option( 'ec_option_recaptcha_site_key', $ec_option_recaptcha_site_key );
		update_option( 'ec_option_recaptcha_secret_key', $ec_option_recaptcha_secret_key );
		update_option( 'ec_option_show_account_subscriptions_link', $ec_option_show_account_subscriptions_link );
		update_option( 'ec_option_enable_user_notes', $ec_option_enable_user_notes );
		update_option( 'ec_option_show_subscriber_feature', $ec_option_show_subscriber_feature );
		update_option( 'ec_subscriptions_use_first_order_details', $ec_subscriptions_use_first_order_details );
	}
	
	public function save_settings( ){
		
	}
	
}

add_action( 'wp_ajax_ec_admin_ajax_save_account_settings', 'ec_admin_ajax_save_account_settings' );
function ec_admin_ajax_save_account_settings( ){
	$google_analytics = new wp_easycart_admin_account( );
	$google_analytics->save_account_settings( );
	die( );
}