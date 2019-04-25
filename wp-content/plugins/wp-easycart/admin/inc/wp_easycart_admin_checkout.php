<?php
class wp_easycart_admin_checkout{
	
	private $wpdb;
	
	public $checkout_file;
	public $checkout_form_settings_file;
	public $checkout_settings_file;
	public $checkout_email_settings_file;
	public $checkout_abandoned_cart_file;
		
	public function __construct( ){
		// Keep reference to wpdb
		global $wpdb;
		$this->wpdb =& $wpdb;
		
		// Setup File Names 
		$this->checkout_file 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/checkout/checkout.php';
		$this->checkout_form_settings_file 	= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/checkout/checkout-form-settings.php';
		$this->checkout_settings_file 		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/checkout/checkout-settings.php';
		$this->checkout_stock_control_file = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/checkout/checkout-stock-control.php';
		
		// Actions
		add_action( 'wpeasycart_admin_checkout_success', array( $this, 'load_success_messages' ) );
		add_action( 'wpeasycart_admin_checkout_settings', array( $this, 'load_checkout_form_settings' ) );
		add_action( 'wpeasycart_admin_checkout_settings', array( $this, 'load_stock_control_settings' ) );
		add_action( 'wpeasycart_admin_checkout_settings', array( $this, 'load_checkout_settings' ) );	
		
	
		add_action( 'init', array( $this, 'save_settings' ) );
	}
	
	public function load_checkout( ){
		include( $this->checkout_file );
	}
	
	public function load_success_messages( ){
		include( $this->success_messages_file );
	}
	
	public function load_checkout_form_settings( ){
		include( $this->checkout_form_settings_file );
	}
	
	public function load_checkout_settings( ){
		include( $this->checkout_settings_file );
	}
	
	public function load_stock_control_settings( ){
		include( $this->checkout_stock_control_file );
	}
	
	public function save_checkout_form( ){
		$ec_option_load_ssl = $ec_option_display_country_top = $ec_option_use_address2 = $ec_option_collect_user_phone = $ec_option_enable_company_name = $ec_option_collect_vat_registration_number = $ec_option_user_order_notes = $ec_option_require_terms_agreement = $ec_option_use_contact_name = $ec_option_show_card_holder_name = 0;
		if( isset( $_POST['ec_option_load_ssl'] ) && $_POST['ec_option_load_ssl'] == '1' )
			$ec_option_load_ssl = 1;
		if( isset( $_POST['ec_option_display_country_top'] ) && $_POST['ec_option_display_country_top'] == '1' )
			$ec_option_display_country_top = 1;
		if( isset( $_POST['ec_option_use_address2'] ) && $_POST['ec_option_use_address2'] == '1' )
			$ec_option_use_address2 = 1;
		if( isset( $_POST['ec_option_collect_user_phone'] ) && $_POST['ec_option_collect_user_phone'] == '1' )
			$ec_option_collect_user_phone = 1;
		if( isset( $_POST['ec_option_enable_company_name'] ) && $_POST['ec_option_enable_company_name'] == '1' )
			$ec_option_enable_company_name = 1;
		if( isset( $_POST['ec_option_collect_vat_registration_number'] ) && $_POST['ec_option_collect_vat_registration_number'] == '1' )
			$ec_option_collect_vat_registration_number = 1;
		if( isset( $_POST['ec_option_user_order_notes'] ) && $_POST['ec_option_user_order_notes'] == '1' )
			$ec_option_user_order_notes = 1;
		if( isset( $_POST['ec_option_require_terms_agreement'] ) && $_POST['ec_option_require_terms_agreement'] == '1' )
			$ec_option_require_terms_agreement = 1;
		if( isset( $_POST['ec_option_use_contact_name'] ) && $_POST['ec_option_use_contact_name'] == '1' )
			$ec_option_use_contact_name = 1;
		if( isset( $_POST['ec_option_show_card_holder_name'] ) && $_POST['ec_option_show_card_holder_name'] == '1' )
			$ec_option_show_card_holder_name = 1;
		
		update_option( 'ec_option_load_ssl', $ec_option_load_ssl );
		update_option( 'ec_option_display_country_top', $ec_option_display_country_top );
		update_option( 'ec_option_use_address2', $ec_option_use_address2 );
		update_option( 'ec_option_collect_user_phone', $ec_option_collect_user_phone );
		update_option( 'ec_option_enable_company_name', $ec_option_enable_company_name );
		update_option( 'ec_option_collect_vat_registration_number', $ec_option_collect_vat_registration_number );
		update_option( 'ec_option_user_order_notes', $ec_option_user_order_notes );
		update_option( 'ec_option_require_terms_agreement', $ec_option_require_terms_agreement );
		update_option( 'ec_option_use_contact_name', $ec_option_use_contact_name );
		update_option( 'ec_option_show_card_holder_name', $ec_option_show_card_holder_name );
	}
	
	public function save_checkout_options( ){
		$ec_option_terms_link = stripslashes_deep( $_POST['ec_option_terms_link'] );
		$ec_option_privacy_link = stripslashes_deep( $_POST['ec_option_privacy_link'] );
		$ec_option_return_to_store_page_url = stripslashes_deep( $_POST['ec_option_return_to_store_page_url'] );
		$ec_option_weight = $_POST['ec_option_weight'];
		$ec_option_enable_metric_unit_display = $_POST['ec_option_enable_metric_unit_display'];
		$ec_option_default_payment_type = $_POST['ec_option_default_payment_type'];
		$ec_option_default_country = $_POST['ec_option_default_country'];
		$ec_option_minimum_order_total = $_POST['ec_option_minimum_order_total'];
		$ec_option_current_order_id = $_POST['ec_option_current_order_id'];
		
		$ec_option_skip_shipping_page = $ec_option_use_estimate_shipping = $ec_option_estimate_shipping_zip = $ec_option_estimate_shipping_country = $ec_option_allow_guest = $ec_option_show_giftcards = $ec_option_show_coupons = $ec_option_addtocart_return_to_product = $ec_option_use_smart_states = $ec_option_use_state_dropdown = $ec_option_use_country_dropdown = $ec_option_skip_cart_login = $ec_option_gift_card_shipping_allowed = 0;
		
		if( isset( $_POST['ec_option_skip_shipping_page'] ) && $_POST['ec_option_skip_shipping_page'] == "1" )
			$ec_option_skip_shipping_page = 1;
		if( isset( $_POST['ec_option_skip_cart_login'] ) && $_POST['ec_option_skip_cart_login'] == "1" )
			$ec_option_skip_cart_login = 1;
		if( isset( $_POST['ec_option_use_estimate_shipping'] ) && $_POST['ec_option_use_estimate_shipping'] == "1" )
			$ec_option_use_estimate_shipping = 1;
		if( isset( $_POST['ec_option_estimate_shipping_zip'] ) && $_POST['ec_option_estimate_shipping_zip'] == "1" )
			$ec_option_estimate_shipping_zip = 1;
		if( isset( $_POST['ec_option_estimate_shipping_country'] ) && $_POST['ec_option_estimate_shipping_country'] == "1" )
			$ec_option_estimate_shipping_country = 1;
		if( isset( $_POST['ec_option_allow_guest'] ) && $_POST['ec_option_allow_guest'] == "1" )
			$ec_option_allow_guest = 1;
		if( isset( $_POST['ec_option_show_giftcards'] ) && $_POST['ec_option_show_giftcards'] == "1" )
			$ec_option_show_giftcards = 1;
		if( isset( $_POST['ec_option_gift_card_shipping_allowed'] ) && $_POST['ec_option_gift_card_shipping_allowed'] == "1" )
			$ec_option_gift_card_shipping_allowed = 1;
		if( isset( $_POST['ec_option_show_coupons'] ) && $_POST['ec_option_show_coupons'] == "1" )
			$ec_option_show_coupons = 1;
		if( isset( $_POST['ec_option_addtocart_return_to_product'] ) && $_POST['ec_option_addtocart_return_to_product'] == "1" )
			$ec_option_addtocart_return_to_product = 1;
		if( isset( $_POST['ec_option_use_smart_states'] ) && $_POST['ec_option_use_smart_states'] == "1" )
			$ec_option_use_smart_states = 1;
		if( isset( $_POST['ec_option_use_state_dropdown'] ) && $_POST['ec_option_use_state_dropdown'] == "1" )
			$ec_option_use_state_dropdown = 1;
		if( isset( $_POST['ec_option_use_country_dropdown'] ) && $_POST['ec_option_use_country_dropdown'] == "1" )
			$ec_option_use_country_dropdown = 1;
			
		update_option( 'ec_option_terms_link', $ec_option_terms_link );
		update_option( 'ec_option_privacy_link', $ec_option_privacy_link );
		update_option( 'ec_option_return_to_store_page_url', $ec_option_return_to_store_page_url );
		update_option( 'ec_option_weight', $ec_option_weight );
		update_option( 'ec_option_enable_metric_unit_display', $ec_option_enable_metric_unit_display );
		update_option( 'ec_option_default_payment_type', $ec_option_default_payment_type );
		update_option( 'ec_option_default_country', $ec_option_default_country );
		update_option( 'ec_option_minimum_order_total', $ec_option_minimum_order_total );
		update_option( 'ec_option_skip_shipping_page', $ec_option_skip_shipping_page );
		update_option( 'ec_option_skip_cart_login', $ec_option_skip_cart_login );
		update_option( 'ec_option_use_estimate_shipping', $ec_option_use_estimate_shipping );
		update_option( 'ec_option_estimate_shipping_zip', $ec_option_estimate_shipping_zip );
		update_option( 'ec_option_estimate_shipping_country', $ec_option_estimate_shipping_country );
		update_option( 'ec_option_allow_guest', $ec_option_allow_guest );
		update_option( 'ec_option_show_giftcards', $ec_option_show_giftcards );
		update_option( 'ec_option_gift_card_shipping_allowed', $ec_option_gift_card_shipping_allowed );
		update_option( 'ec_option_show_coupons', $ec_option_show_coupons );
		update_option( 'ec_option_addtocart_return_to_product', $ec_option_addtocart_return_to_product );
		update_option( 'ec_option_use_smart_states', $ec_option_use_smart_states );
		update_option( 'ec_option_use_state_dropdown', $ec_option_use_state_dropdown );
		update_option( 'ec_option_use_country_dropdown', $ec_option_use_country_dropdown );
		
		//alter table to new order ID
		$this->wpdb->query( $this->wpdb->prepare( "ALTER TABLE ec_order AUTO_INCREMENT = %d", $ec_option_current_order_id) );
	}
	
	public function save_stock_control( ){

		$ec_option_low_stock_trigger_total = '';
		$ec_option_send_low_stock_emails = $ec_option_send_out_of_stock_emails =  0;
		
		if( isset( $_POST['ec_option_send_low_stock_emails'] ) && $_POST['ec_option_send_low_stock_emails'] == "1" )
			$ec_option_send_low_stock_emails = 1;
		if( isset( $_POST['ec_option_send_out_of_stock_emails'] ) && $_POST['ec_option_send_out_of_stock_emails'] == "1" )
			$ec_option_send_out_of_stock_emails = 1;
		if( isset( $_POST['ec_option_low_stock_trigger_total'] ) )
			$ec_option_low_stock_trigger_total = $_POST['ec_option_low_stock_trigger_total'];

			
		update_option( 'ec_option_send_low_stock_emails', $ec_option_send_low_stock_emails );
		update_option( 'ec_option_send_out_of_stock_emails', $ec_option_send_out_of_stock_emails );
		update_option( 'ec_option_low_stock_trigger_total', $ec_option_low_stock_trigger_total );

	}
	
	public function save_settings( ){
		if( current_user_can( 'manage_options' ) && isset( $_POST['ec_admin_form_action'] ) && $_POST['ec_admin_form_action'] == "save-checkout-setup" ){
			$this->save_checkout_form( );
			$this->save_checkout_options( );
			$this->save_stock_control();
		}
	}
	
}

add_action( 'wp_ajax_ec_admin_ajax_save_checkout_form', 'ec_admin_ajax_save_checkout_form' );
function ec_admin_ajax_save_checkout_form( ){
	$checkout = new wp_easycart_admin_checkout( );
	$checkout->save_checkout_form( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_checkout_options', 'ec_admin_ajax_save_checkout_options' );
function ec_admin_ajax_save_checkout_options( ){
	$checkout = new wp_easycart_admin_checkout( );
	$checkout->save_checkout_options( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_stock_control', 'ec_admin_ajax_save_stock_control' );
function ec_admin_ajax_save_stock_control( ){
	$checkout = new wp_easycart_admin_checkout( );
	$checkout->save_stock_control( );
	die( );
}
