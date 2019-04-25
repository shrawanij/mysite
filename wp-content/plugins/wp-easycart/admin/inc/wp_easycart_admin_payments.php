<?php
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'wp_easycart_admin_payments' ) ) :

final class wp_easycart_admin_payments{
	
	protected static $_instance = null;
	
	private $wpdb;
	
	public $payments_file;
	public $payment_free_header_file;
	public $payment_free_foooter_file;
	public $manual_bill_file;
	public $paypal_file;
	public $stripe_file;
	public $square_file;
	public $upgrade_file;
	public $payments_dir;
		
	public $third_party_gateways;
	public $live_gateways;
	
	public $cart_page;
	public $permalink_divider;
	
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
		$this->payments_file 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/payments/payment.php';
		$this->payment_free_header_file 	= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/payments/payment-free-header.php';
		$this->payment_free_foooter_file 	= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/payments/payment-free-footer.php';
		$this->manual_bill_file 			= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/payments/manual-bill.php';
		$this->paypal_file 					= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/payments/paypal.php';
		$this->stripe_file 					= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/payments/stripe_connect.php';
		$this->square_file 					= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/payments/square.php';
		$this->upgrade_file 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/upgrade/upgrade-simple.php';
		$this->payments_dir					= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/payments/';
		
		// Link Information
		$cart_page_id = get_option('ec_option_cartpage');
		if( function_exists( 'icl_object_id' ) ){
			$cart_page_id = icl_object_id( $cart_page_id, 'page', true, ICL_LANGUAGE_CODE );
		}
		$this->cart_page = get_permalink( $cart_page_id );
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$this->cart_page = $https_class->makeUrlHttps( $this->cart_page );
		}
		if( substr_count( $this->cart_page, '?' ) )					$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
		
		// Setup Default Payment Options
		$this->third_party_gateways 		= array( "2checkout_thirdparty"			=> "2Checkout",
													 "dwolla_thirdparty"			=> "Dwolla",
													 "nets"							=> "Nets Nexaxept",
													 "payfast_thirdparty"			=> "PayFast",
													 "payfort"						=> "Payfort",
													 "paymentexpress_thirdparty" 	=> "Payment Express PxPay 2.0",
													 "realex_thirdparty"			=> "Realex",
													 "redsys"						=> "Redsys",
													 "sagepay_paynow_za"			=> "SagePay Pay Now South Africa",
													 "skrill"						=> "Skrill",
													 "custom_thirdparty"			=> "Custom Gateway"
										    );
		$this->live_gateways 				= array( "authorize"					=> "Authorize.net",
													 "beanstream"					=> "Bambora",
													 "braintree"					=> "Braintree S2S",
													 "chronopay"					=> "Chronopay",
													 "virtualmerchant"				=> "Converge (Virtual Merchant)",
													 "eway"							=> "Eway",
													 "firstdata"					=> "First Date Payeezy (e4)",
													 "goemerchant"					=> "GoeMerchant",
													 "intuit"						=> "Intuit Payments",
													 "migs"							=> "MIGS", 
													 "moneris_ca"					=> "Moneris Canada",
													 "moneris_us"					=> "Moneris USA",
													 "nmi"							=> "Network Merchants (NMI)",
													 "sagepayus"					=> "Paya (Previously Sagepay US)",
													 "payline"						=> "Payline",
													 "paymentexpress"				=> "Payment Express PxPost",
													 "paypal_pro"					=> "PayPal PayFlow Pro",
													 "paypal_payments_pro"			=> "PayPal Payments Pro",
													 "paypoint"						=> "PayPoint", 
													 "realex"						=> "Realex",
													 "sagepay"						=> "Sagepay",
													 "securepay"					=> "SecurePay",
													 "stripe"						=> "Stripe",
													 "square"						=> "Square",
													 "securenet"					=> "WorldPay",
													 "custom"						=> "Custom Payment Gateway" 
											);
		
		add_filter( 'wp_easycart_admin_success_messages', array( $this, 'add_success_messages' ) );
		add_filter( 'wp_easycart_admin_error_messages', array( $this, 'add_failure_messages' ) );
		
		// Actions
		add_action( 'wp_easycart_admin_payment_options_top', array( $this, 'load_free_header' ) );
		add_action( 'wp_easycart_admin_payment_options_top', array( $this, 'load_free_bill_later' ) );
		add_action( 'wp_easycart_admin_payment_options_top', array( $this, 'load_free_paypal' ) );
		add_action( 'wp_easycart_admin_payment_options_top', array( $this, 'load_free_stripe' ) );
		add_action( 'wp_easycart_admin_payment_options_top', array( $this, 'load_free_square' ) );
		add_action( 'wp_easycart_admin_payment_options_top', array( $this, 'load_free_footer' ) );
		
		add_action( 'wpeasycart_admin_load_third_party_select_options', array( $this, 'load_third_party_combo' ) );
		add_action( 'wpeasycart_admin_load_third_party_settings', array( $this, 'load_third_party_settings' ) );
		add_action( 'wpeasycart_admin_load_live_gateway_select_options', array( $this, 'load_live_gateway_combo' ) );
		add_action( 'wpeasycart_admin_load_live_gateway_settings', array( $this, 'load_live_gateway_settings' ) );
		
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'disconnect_paypal' ) );
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'onboard_stripe' ) );
		
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'process_square_app' ) );
	}
	
	public function add_success_messages( $messages ){
		if( isset( $_GET['success'] ) && $_GET['success'] == 'stripe-sandbox-connected' ){
			$messages[] = 'Connected to Stripe Sandbox Successfully!';
		}else if( isset( $_GET['success'] ) && $_GET['success'] == 'stripe-live-connected' ){
			$messages[] = 'Connected to Stripe Successfully! You can now process live transactions.';
		}else if( isset( $_GET['success'] ) && $_GET['success'] == 'stripe-sandbox-mode' ){
			$messages[] = 'Stripe is now in Sandbox Mode, test orders only!';
		}else if( isset( $_GET['success'] ) && $_GET['success'] == 'stripe-live-mode' ){
			$messages[] = 'Stripe is now in Live Mode, you can process live transactions';
		}else if( isset( $_GET['success'] ) && $_GET['success'] == 'stripe-sandbox-disconnected' ){
			$messages[] = 'Sandbox keys have been removed from your site. You will still have to revoke access from your Stripe account.';
		}else if( isset( $_GET['success'] ) && $_GET['success'] == 'stripe-live-disconnected' ){
			$messages[] = 'Live keys have been removed from your site. You will still have to revoke access from your Stripe account.';
		}
		return $messages;
	}
	
	public function add_failure_messages( $messages ){
		if( isset( $_GET['error'] ) && $_GET['error'] == 'stripe-onboarding-error' ){
			$messages[] = 'An error occured during the authorization of your Stripe account. Please try again or contact WP EasyCart for assistence.';
		}
		return $messages;
	}
	
	public function load_payments( ){
		include( $this->payments_file );
	}
	
	public function load_free_header( ){
		include( $this->payment_free_header_file );
	}
	
	public function load_free_bill_later( ){
		include( $this->manual_bill_file );
	}
	
	public function load_free_paypal( ){
		include( $this->paypal_file );
	}
	
	public function load_free_stripe( ){
		include( $this->stripe_file );
	}
	
	public function load_free_square( ){
		include( $this->square_file );
	}
	
	public function load_free_footer( ){
		include( $this->payment_free_foooter_file );
	}
	
	public function load_third_party_combo( ){
		$third_party_gateways = apply_filters( 'wp_easycart_admin_third_party_gateways', $this->third_party_gateways );
		foreach( $third_party_gateways as $gateway => $gateway_name ){ 
			echo '<option value="' . $gateway . '" ';
			if( get_option( 'ec_option_payment_third_party' ) == $gateway ){ 
				echo ' selected'; 
			}
			echo '>' . $gateway_name . '</option>';
		}
	}
	
	public function load_third_party_settings( ){
		$third_party_gateways = apply_filters( 'wp_easycart_admin_third_party_gateways', $this->third_party_gateways );
		foreach( $this->third_party_gateways as $gateway => $gateway_name ){
    		$this->load_third_party_payment_form( $gateway );
    	}
	}
	
	public function load_free_paypal_credit_field( ){
		echo '<div style="font-weight:bold; margin:15px 0 0;">Add PayPal Express</div>';
		echo '<div>Enable PayPal Express <span class="dashicons dashicons-lock" style="color:#FC0; float:left; margin-top:5px;"></span><select onchange="show_pro_required( ); return false;">';
        echo '<option value="0"';
		if( get_option( 'ec_option_paypal_enable_pay_now' ) == '0' ) 
			echo ' selected';
		echo '>Keep PayPal Standard, Redirect Users to PayPal for Payment</option>';
        echo '<option value="1"';
		if( get_option( 'ec_option_paypal_enable_pay_now' ) == '1' )
			echo ' selected';
		echo '>YES! Enable PayPal Express and Keep Customers on My Site</option>';
        echo '</select></div>';
		
		echo '<div>Advertise PayPal Credit <span class="dashicons dashicons-lock" style="color:#FC0; float:left; margin-top:5px;"></span><select onchange="show_pro_required( ); return false;">';
        echo '<option value="0"';
		if( get_option( 'ec_option_paypal_enable_credit' ) == '0' ) 
			echo ' selected';
		echo '>Do Not Advertise PayPal Credit</option>';
        echo '<option value="1"';
		if( get_option( 'ec_option_paypal_enable_credit' ) == '1' )
			echo ' selected';
		echo '>Advertise PayPal Credit</option>';
        echo '</select></div>';
	}
	
	public function load_live_gateway_combo( ){
		$live_gateways = apply_filters( 'wp_easycart_admin_live_gateways', $this->live_gateways );
		foreach( $this->live_gateways as $gateway => $gateway_name ){ 
			echo '<option value="' . $gateway . '" ';
			if( get_option( 'ec_option_payment_process_method' ) == $gateway ){ 
				echo ' selected'; 
			}
			echo '>' . $gateway_name . '</option>';
		}
	}
	
	public function load_live_gateway_settings( ){
		$live_gateways = apply_filters( 'wp_easycart_admin_live_gateways', $this->live_gateways );
		foreach( $live_gateways as $gateway => $gateway_name ){
			$this->load_live_payment_form( $gateway );
		}
		
	}
	
	public function load_third_party_payment_form( $payment_type ){
		$file = apply_filters( 'wp_easycart_admin_payment_file', $this->payments_dir . $payment_type . '.php', $payment_type );
		if( file_exists( $file ) ){
			include( $file );
		}else{
			echo '<div class="ec_admin_settings_input ec_admin_settings_third_party_section ec_admin_settings_';
			if( get_option( 'ec_option_payment_third_party' ) == $payment_type ){
				echo 'show';
			}else{
				echo 'hide';
			}
			echo '" id="' . $payment_type . '">';
			$upgrade_icon = "dashicons-lock";
			$upgrade_title = "Enable " . $this->third_party_gateways[$payment_type];
			$upgrade_subtitle = "";
			$upgrade_checkbox_label = apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; margin-top:5px;"></span>' ) . " Select Box to Enable " . $this->third_party_gateways[$payment_type];
			$upgrade_button_label = "Save Setup";
			include( $this->upgrade_file );
			echo '</div>';
		}
	}
	
	public function load_live_payment_form( $payment_type ){
		$file = apply_filters( 'wp_easycart_admin_payment_file', $this->payments_dir . $payment_type . '.php', $payment_type );
		if( file_exists( $file ) ){
			include( $file );
		}else{
			echo '<div class="ec_admin_settings_input ec_admin_settings_live_payment_section ec_admin_settings_';
			if( get_option( 'ec_option_payment_process_method' ) == $payment_type ){
				echo 'show';
			}else{
				echo 'hide';
			}
			echo '" id="' . $payment_type . '">';
			$upgrade_icon = "dashicons-lock";
			$upgrade_title = "Enable " . $this->live_gateways[$payment_type];
			$upgrade_subtitle = "";
			$upgrade_checkbox_label = apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; margin-top:5px;"></span>' ) . " Select Box to Enable " . $this->live_gateways[$payment_type];
			$upgrade_button_label = "Save Setup";
			include( $this->upgrade_file );
			echo '</div>';
		}
	}
	
	public function update_manual_billing_settings( ){
		update_option( 'ec_option_use_direct_deposit', $_POST['ec_option_use_direct_deposit'] );
		update_option( 'ec_option_direct_deposit_message', stripslashes_deep( $_POST['ec_option_direct_deposit_message'] ) );
		$language = new ec_language( );
		$language->update_language_data( );
		do_action( 'wpeasycart_manual_billing_updated', esc_attr( $_POST['ec_option_use_direct_deposit'] ) );
	}
	
	public function update_third_party_selection( ){
		update_option( 'ec_option_payment_third_party', $_POST['ec_option_payment_third_party'] );
		do_action( 'wpeasycart_third_party_payment_updated', esc_attr( $_POST['ec_option_payment_third_party'] ) );
	}
	
	public function update_paypal( ){
		update_option( 'ec_option_paypal_email', stripslashes_deep( $_POST['ec_option_paypal_email'] ) );
		
		update_option( 'ec_option_paypal_enable_pay_now', stripslashes_deep( $_POST['ec_option_paypal_enable_pay_now'] ) );
		update_option( 'ec_option_paypal_enable_credit', stripslashes_deep( $_POST['ec_option_paypal_enable_credit'] ) );
		update_option( 'ec_option_paypal_sandbox_access_token_expires', 0 );
		update_option( 'ec_option_paypal_production_access_token_expires', 0 );
		
		update_option( 'ec_option_paypal_currency_code', $_POST['ec_option_paypal_currency_code'] );
		update_option( 'ec_option_paypal_use_selected_currency', $_POST['ec_option_paypal_use_selected_currency'] );
		update_option( 'ec_option_paypal_lc', $_POST['ec_option_paypal_lc'] );
		update_option( 'ec_option_paypal_charset', $_POST['ec_option_paypal_charset'] );
		update_option( 'ec_option_paypal_weight_unit', $_POST['ec_option_paypal_weight_unit'] );
		update_option( 'ec_option_paypal_use_sandbox', $_POST['ec_option_paypal_use_sandbox'] );
		update_option( 'ec_option_paypal_collect_shipping', $_POST['ec_option_paypal_collect_shipping'] );
		
		update_option( 'ec_option_paypal_button_color', $_POST['ec_option_paypal_button_color'] );
		update_option( 'ec_option_paypal_button_shape', $_POST['ec_option_paypal_button_shape'] );
		
		update_option( 'ec_option_paypal_marketing_solution_cid_sandbox', $_POST['ec_option_paypal_marketing_solution_cid_sandbox'] );
		update_option( 'ec_option_paypal_marketing_solution_cid_production', $_POST['ec_option_paypal_marketing_solution_cid_production'] );
		
		do_action( 'wp_easycart_paypal_standard_updated' );
	}
	
	public function update_pro_paypal( ){
		update_option( 'ec_option_paypal_email', stripslashes_deep( $_POST['ec_option_paypal_email'] ) );
		
		update_option( 'ec_option_paypal_enable_pay_now', stripslashes_deep( $_POST['ec_option_paypal_enable_pay_now'] ) );
		update_option( 'ec_option_paypal_enable_credit', stripslashes_deep( $_POST['ec_option_paypal_enable_credit'] ) );
		update_option( 'ec_option_paypal_sandbox_access_token_expires', 0 );
		update_option( 'ec_option_paypal_production_access_token_expires', 0 );
		
		update_option( 'ec_option_paypal_sandbox_app_id', stripslashes_deep( $_POST['ec_option_paypal_sandbox_app_id'] ) );
		update_option( 'ec_option_paypal_sandbox_secret', stripslashes_deep( $_POST['ec_option_paypal_sandbox_secret'] ) );
		
		update_option( 'ec_option_paypal_production_app_id', stripslashes_deep( $_POST['ec_option_paypal_production_app_id'] ) );
		update_option( 'ec_option_paypal_production_secret', stripslashes_deep( $_POST['ec_option_paypal_production_secret'] ) );
		
		update_option( 'ec_option_paypal_currency_code', $_POST['ec_option_paypal_currency_code'] );
		update_option( 'ec_option_paypal_use_selected_currency', $_POST['ec_option_paypal_use_selected_currency'] );
		update_option( 'ec_option_paypal_lc', $_POST['ec_option_paypal_lc'] );
		update_option( 'ec_option_paypal_charset', $_POST['ec_option_paypal_charset'] );
		update_option( 'ec_option_paypal_weight_unit', $_POST['ec_option_paypal_weight_unit'] );
		update_option( 'ec_option_paypal_use_sandbox', $_POST['ec_option_paypal_use_sandbox'] );
		update_option( 'ec_option_paypal_collect_shipping', $_POST['ec_option_paypal_collect_shipping'] );
		
		update_option( 'ec_option_paypal_button_color', $_POST['ec_option_paypal_button_color'] );
		update_option( 'ec_option_paypal_button_shape', $_POST['ec_option_paypal_button_shape'] );
		update_option( 'ec_option_paypal_express_page1_checkout', $_POST['ec_option_paypal_express_page1_checkout'] );
		
		update_option( 'ec_option_paypal_marketing_solution_cid_sandbox', $_POST['ec_option_paypal_marketing_solution_cid_sandbox'] );
		update_option( 'ec_option_paypal_marketing_solution_cid_production', $_POST['ec_option_paypal_marketing_solution_cid_production'] );
		
		do_action( 'wp_easycart_paypal_standard_updated' );
	}
	
	public function disconnect_paypal( ){
		if( $_GET['ec_admin_form_action'] == 'paypal-express-sandbox-disconnect' ){
			update_option( 'ec_option_paypal_sandbox_webhook_id', '' );
			update_option( 'ec_option_paypal_sandbox_merchant_id', '' );
			wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', $result );
		
		}else if( $_GET['ec_admin_form_action'] == 'paypal-express-production-disconnect' ){
			update_option( 'ec_option_paypal_production_webhook_id', '' );
			update_option( 'ec_option_paypal_production_merchant_id', '' );
			wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', $result );
		
		}else if( $_GET['ec_admin_form_action'] == 'paypal-marketing-sandbox-disconnect' ){
			update_option( 'ec_option_paypal_marketing_solution_cid_sandbox', '' );
			wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', $result );
		
		}else if( $_GET['ec_admin_form_action'] == 'paypal-marketing-production-disconnect' ){
			update_option( 'ec_option_paypal_marketing_solution_cid_production', '' );
			wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', $result );
		
		}
	}
	
	public function save_stripe_connect( ){
		update_option( 'ec_option_stripe_connect_use_sandbox', $_POST['ec_option_stripe_connect_use_sandbox'] );
		update_option( 'ec_option_payment_process_method', $_POST['ec_option_payment_process_method'] );
		update_option( 'ec_option_stripe_currency', $_POST['ec_option_stripe_currency'] );
		update_option( 'ec_option_stripe_enable_ideal', $_POST['ec_option_stripe_enable_ideal'] );
	}
	
	public function onboard_stripe( ){
		if( $_GET['ec_admin_form_action'] == 'stripe_onboard' && isset( $_GET['error'] ) ){
			if( isset( $_GET['goto'] ) && $_GET['goto'] == 'wizard' ){
				echo '<script>self.close();</script>';
			}else{
				wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', array( "error" => "stripe-onboarding-error" ) );
			}
			die( );
			
		}if( $_GET['ec_admin_form_action'] == 'stripe_onboard' && $_GET['env'] == 'sandbox' ){
			update_option( 'ec_option_stripe_connect_use_sandbox', 1 );
			update_option( 'ec_option_stripe_connect_sandbox_access_token', esc_attr( $_GET['access_token'] ) );
			update_option( 'ec_option_stripe_connect_sandbox_refresh_token', esc_attr( $_GET['refresh_token'] ) );
			update_option( 'ec_option_stripe_connect_sandbox_publishable_key', esc_attr( $_GET['stripe_publishable_key'] ) );
			update_option( 'ec_option_stripe_connect_sandbox_user_id', esc_attr( $_GET['stripe_user_id'] ) );
			update_option( 'ec_option_payment_process_method', 'stripe_connect' );
			update_option( 'ec_option_default_payment_type', 'credit_card' );
			do_action( 'wpeasycart_live_gateway_updated', get_option( 'ec_option_payment_process_method' ) );
			if( isset( $_GET['goto'] ) && $_GET['goto'] == 'wizard' ){
				echo '<script>self.close();</script>';
			}else{
				wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', array( "success" => "stripe-sandbox-connected" ) );
			}
			die( );
		
		}else if( $_GET['ec_admin_form_action'] == 'stripe_onboard' && $_GET['env'] == 'production' ){
			update_option( 'ec_option_stripe_connect_use_sandbox', 0 );
			update_option( 'ec_option_stripe_connect_production_access_token', esc_attr( $_GET['access_token'] ) );
			update_option( 'ec_option_stripe_connect_production_refresh_token', esc_attr( $_GET['refresh_token'] ) );
			update_option( 'ec_option_stripe_connect_production_publishable_key', esc_attr( $_GET['stripe_publishable_key'] ) );
			update_option( 'ec_option_stripe_connect_production_user_id', esc_attr( $_GET['stripe_user_id'] ) );
			update_option( 'ec_option_payment_process_method', 'stripe_connect' );
			update_option( 'ec_option_default_payment_type', 'credit_card' );
			do_action( 'wpeasycart_live_gateway_updated', get_option( 'ec_option_payment_process_method' ) );
			if( isset( $_GET['goto'] ) && $_GET['goto'] == 'wizard' ){
				echo '<script>self.close();</script>';
			}else{
				wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', array( "success" => "stripe-live-connected" ) );
			}
			die( );
			
		}else if( $_GET['ec_admin_form_action'] == 'stripe-connect-use-sandbox' ){
			update_option( 'ec_option_stripe_connect_use_sandbox', 1 );
			if( isset( $_GET['goto'] ) && $_GET['goto'] == 'wizard' ){
				echo '<script>self.close();</script>';
			}else{
				wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', array( "success" => "stripe-sandbox-mode" ) );
			}
			die( );
			
		}else if( $_GET['ec_admin_form_action'] == 'stripe-connect-use-production' ){
			update_option( 'ec_option_stripe_connect_use_sandbox', 0 );
			if( isset( $_GET['goto'] ) && $_GET['goto'] == 'wizard' ){
				echo '<script>self.close();</script>';
			}else{
				wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', array( "success" => "stripe-live-mode" ) );
			}
			die( );
			
		}else if( $_GET['ec_admin_form_action'] == 'stripe-connect-sandbox-disconnect' ){
			update_option( 'ec_option_stripe_connect_use_sandbox', 0 );
			update_option( 'ec_option_stripe_connect_sandbox_access_token', '' );
			update_option( 'ec_option_stripe_connect_sandbox_refresh_token', '' );
			update_option( 'ec_option_stripe_connect_sandbox_publishable_key', '' );
			update_option( 'ec_option_stripe_connect_sandbox_user_id', '' );
			update_option( 'ec_option_payment_process_method', '0' );
			if( isset( $_GET['goto'] ) && $_GET['goto'] == 'wizard' ){
				echo '<script>self.close();</script>';
			}else{
				wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', array( "success" => "stripe-sandbox-disconnected" ) );
			}
			die( );
			
		}else if( $_GET['ec_admin_form_action'] == 'stripe-connect-production-disconnect' ){
			update_option( 'ec_option_stripe_connect_use_sandbox', 0 );
			update_option( 'ec_option_stripe_connect_production_access_token', '' );
			update_option( 'ec_option_stripe_connect_production_refresh_token', '' );
			update_option( 'ec_option_stripe_connect_production_publishable_key', '' );
			update_option( 'ec_option_stripe_connect_production_user_id', '' );
			update_option( 'ec_option_payment_process_method', '0' );
			if( isset( $_GET['goto'] ) && $_GET['goto'] == 'wizard' ){
				echo '<script>self.close();</script>';
			}else{
				wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', array( "success" => "stripe-live-disconnected" ) );
			}
			die( );
			
		}
	}
	
	public function process_square_app( ){
		// Handle a Failed Connect Attempt
		if( $_GET['ec_admin_form_action'] == 'handle-square' && isset( $_GET['wpeasycart_square_failed'] ) ){
			if( isset( $_GET['goto'] ) && $_GET['goto'] == 'wizard' ){
				echo '<script>self.close();</script>';
			}else{
				wp_redirect( 'admin.php?page=wp-easycart-settings&subpage=payment&error=square-failed-to-connect' );
			}
			die( );
		
		// Handle a Successful Connect Attempt
		}else if( $_GET['ec_admin_form_action'] == 'handle-square' && isset( $_GET['wpeasycart_square_state'] ) ){
			$access_token = preg_replace( "/[^A-Za-z0-9 \-\._\~\+\/]/", '', $_GET['access_token'] );
			$expires = preg_replace( "/[^A-Za-z0-9 \-\:]/", '', $_GET['expires'] );
			
			update_option( 'ec_option_payment_process_method', 'square' );
			update_option( 'ec_option_square_application_id', '' );			
			update_option( 'ec_option_square_access_token', $access_token );
			update_option( 'ec_option_square_token_expires', $expires );
			do_action( 'wpeasycart_live_gateway_updated', get_option( 'ec_option_payment_process_method' ) );
			
			$square = new ec_square( );
			$square->set_currency( );
			
			if( isset( $_GET['goto'] ) && $_GET['goto'] == 'wizard' ){
				echo '<script>self.close();</script>';
			}else{
				wp_redirect( 'admin.php?page=wp-easycart-settings&subpage=payment&success=square-connected' );
			}
			die( );
		
		}else if( $_GET['ec_admin_form_action'] == 'square-disconnect' ){
			$access_token = get_option( 'ec_option_square_access_token' );
			$response = file_get_contents( "https://support.wpeasycart.com/square/disconnect.php?access_token=" . $access_token );
			
			update_option( 'ec_option_payment_process_method', '0' );
			update_option( 'ec_option_square_application_id', '' );
			update_option( 'ec_option_square_access_token', '' );
			update_option( 'ec_option_square_token_expires', '' );
			
			wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', array( ) );
		
		}else if( $_GET['ec_admin_form_action'] == 'square-renew' ){
			$square = new ec_square( );
			$square->renew_token( );
			wp_easycart_admin( )->redirect( 'wp-easycart-settings', 'payment', array( ) );
		}
	}
	
	public function update_square( ){
		update_option( 'ec_option_payment_process_method', $_POST['payment_method'] );
		update_option( 'ec_option_square_location_id', $_POST['ec_option_square_location_id'] );
		update_option( 'ec_option_square_location_country', stripslashes_deep( $_POST['ec_option_square_location_country'] ) );
		$square = new ec_square( );
		$square->set_currency( );
	}
	
}
endif; // End if class_exists check

function wp_easycart_admin_payments( ){
	return wp_easycart_admin_payments::instance( );
}
wp_easycart_admin_payments( );

add_action( 'wp_ajax_ec_admin_ajax_save_third_party_selection', 'ec_admin_ajax_save_third_party_selection' );
function ec_admin_ajax_save_third_party_selection( ){
	wp_easycart_admin_payments( )->update_third_party_selection( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_direct_deposit', 'ec_admin_ajax_save_direct_deposit' );
function ec_admin_ajax_save_direct_deposit( ){
	wp_easycart_admin_payments( )->update_manual_billing_settings( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_paypal', 'ec_admin_ajax_save_paypal' );
function ec_admin_ajax_save_paypal( ){
	wp_easycart_admin_payments( )->update_third_party_selection( );
	wp_easycart_admin_payments( )->update_paypal( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_pro_paypal', 'ec_admin_ajax_save_pro_paypal' );
function ec_admin_ajax_save_pro_paypal( ){
	wp_easycart_admin_payments( )->update_third_party_selection( );
	wp_easycart_admin_payments( )->update_pro_paypal( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_stripe_connect', 'ec_admin_ajax_save_stripe_connect' );
function ec_admin_ajax_save_stripe_connect( ){
	wp_easycart_admin_payments( )->save_stripe_connect( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_square_free', 'ec_admin_ajax_save_square_free' );
function ec_admin_ajax_save_square_free( ){
	wp_easycart_admin_payments( )->update_square( );
	die( );
}