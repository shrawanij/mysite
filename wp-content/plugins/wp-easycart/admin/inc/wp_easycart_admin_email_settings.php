<?php
class wp_easycart_admin_email_settings{ 
	
	private $wpdb;
	
	public $email_file;
	public $settings_file;
		
	public function __construct( ){
		// Keep reference to wpdb
		global $wpdb;
		$this->wpdb =& $wpdb;
		
		// Setup File Names 
		$this->settings_file		 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/email-setup/settings.php';
		$this->email_settings_file	 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/email-setup/email-settings.php';
		$this->account_email_file	 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/email-setup/account-emails.php';
		$this->order_receipt_file	 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/email-setup/order-receipt.php';
		$this->order_receipt_language_file			= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/email-setup/order-receipt-language.php';
		
		// Actions
		//add_action( 'wpeasycart_admin_email_settings', array( $this, 'load_success_messages' ) );
		add_action( 'wpeasycart_admin_email_settings', array( $this, 'load_email_settings' ) );
		add_action( 'wpeasycart_admin_email_settings', array( $this, 'load_order_receipt' ) );
		add_action( 'wpeasycart_admin_email_settings', array( $this, 'load_account_email' ) );
		
		add_action( 'wpeasycart_admin_email_settings', array( $this, 'load_order_receipt_language' ) );
		add_action( 'init', array( $this, 'save_settings' ) );
	}
	
	public function load_email( ){
		include( $this->settings_file );
	}
	
	public function load_success_messages( ){
		//include( $this->success_messages_file );
	}
	public function load_order_receipt_language( ){
		include( $this->order_receipt_language_file );
	}
	public function load_order_receipt( ){
		include( $this->order_receipt_file );
	}
	public function load_account_email( ){
		include( $this->account_email_file );
	}
	
	public function load_email_settings( ){
		include( $this->email_settings_file );
	}
	
	public function wpeasycart_smtp_test1( ){
		
		$to = stripslashes( get_option( 'ec_option_bcc_email_addresses' ) );
		$subject = "WP EasyCart Order Receipt Email Test";
		$message = "This is a simple test from WP EasyCart to make sure your email setup is correct. If you receive this your order type emails should be working properly!";
		
		if( get_option( 'ec_option_use_wp_mail' ) == "0" ){
			$mailer = new wpeasycart_mailer( );
			return $mailer->send_order_email( $to, $subject, $message );
		}else{
			$headers   = array();
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-Type: text/html; charset=utf-8";
			$headers[] = "From: " . stripslashes( get_option( 'ec_option_order_from_email' ) );
			$headers[] = "Reply-To: " . stripslashes( get_option( 'ec_option_order_from_email' ) );
			$headers[] = "X-Mailer: PHP/".phpversion();
			
			wp_mail( $to, $subject, $message, implode("\r\n", $headers) );
			return false;
		}
	
	}
	
	public function wpeasycart_smtp_test2( ){
		
		$to = stripslashes( get_option( 'ec_option_bcc_email_addresses' ) );
		$subject = "WP EasyCart Account Test Email";
		$message = "This is a simple test from WP EasyCart to make sure your email setup is correct. If you receive this your account type emails should be working properly!";
		
		if( get_option( 'ec_option_use_wp_mail' ) == "0" ){
			$mailer = new wpeasycart_mailer( );
			return $mailer->send_customer_email( $to, $subject, $message );
		}else{
			$headers   = array();
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-Type: text/html; charset=utf-8";
			$headers[] = "From: " . stripslashes( get_option( 'ec_option_password_from_email' ) );
			$headers[] = "Reply-To: " . stripslashes( get_option( 'ec_option_password_from_email' ) );
			$headers[] = "X-Mailer: PHP/".phpversion();
			
			wp_mail( $to, $subject, $message, implode("\r\n", $headers) );
			return false;
		}
		
	}

	public function save_account_email_settings( ) {
		$ec_option_password_from_email = stripslashes_deep( $_POST['ec_option_password_from_email'] );
		$ec_option_password_use_smtp = $_POST['ec_option_password_use_smtp'];
		$ec_option_password_from_smtp_host = stripslashes_deep( $_POST['ec_option_password_from_smtp_host'] );
		$ec_option_password_from_smtp_encryption_type = $_POST['ec_option_password_from_smtp_encryption_type'];
		$ec_option_password_from_smtp_port = $_POST['ec_option_password_from_smtp_port'];
		$ec_option_password_from_smtp_username = stripslashes_deep( $_POST['ec_option_password_from_smtp_username'] );
		$ec_option_password_from_smtp_password = stripslashes_deep( $_POST['ec_option_password_from_smtp_password'] );
		
		
		if( isset( $_POST['ec_option_password_from_email'] ))
			$ec_option_password_from_email =  $_POST['ec_option_password_from_email'];
		if( isset( $_POST['ec_option_password_use_smtp'] ))
			$ec_option_password_use_smtp =  $_POST['ec_option_password_use_smtp'];
		if( isset( $_POST['ec_option_password_from_smtp_host'] ))
			$ec_option_password_from_smtp_host =  $_POST['ec_option_password_from_smtp_host'];
		if( isset( $_POST['ec_option_password_from_smtp_encryption_type'] ))
			$ec_option_password_from_smtp_encryption_type =  $_POST['ec_option_password_from_smtp_encryption_type'];
		if( isset( $_POST['ec_option_password_from_smtp_port'] ))
			$ec_option_password_from_smtp_port =  $_POST['ec_option_password_from_smtp_port'];
		if( isset( $_POST['ec_option_password_from_smtp_username'] ))
			$ec_option_password_from_smtp_username =  $_POST['ec_option_password_from_smtp_username'];
		if( isset( $_POST['ec_option_password_from_smtp_password'] ))
			$ec_option_password_from_smtp_password =  $_POST['ec_option_password_from_smtp_password'];
		
		update_option( 'ec_option_password_from_email', $ec_option_password_from_email );
		update_option( 'ec_option_password_use_smtp', $ec_option_password_use_smtp );
		update_option( 'ec_option_password_from_smtp_host', $ec_option_password_from_smtp_host );
		update_option( 'ec_option_password_from_smtp_encryption_type', $ec_option_password_from_smtp_encryption_type );
		update_option( 'ec_option_password_from_smtp_port', $ec_option_password_from_smtp_port );
		update_option( 'ec_option_password_from_smtp_username', $ec_option_password_from_smtp_username );
		update_option( 'ec_option_password_from_smtp_password', $ec_option_password_from_smtp_password );
	}
		
	public function save_order_receipt_settings( ) {
		$ec_option_order_from_email = stripslashes_deep( $_POST['ec_option_order_from_email'] );
		$ec_option_order_use_smtp = $_POST['ec_option_order_use_smtp'];
		$ec_option_order_from_smtp_host = stripslashes_deep( $_POST['ec_option_order_from_smtp_host'] );
		$ec_option_order_from_smtp_encryption_type = $_POST['ec_option_order_from_smtp_encryption_type'];
		$ec_option_order_from_smtp_port = $_POST['ec_option_order_from_smtp_port'];
		$ec_option_order_from_smtp_username = stripslashes_deep( $_POST['ec_option_order_from_smtp_username'] );
		$ec_option_order_from_smtp_password = stripslashes_deep( $_POST['ec_option_order_from_smtp_password'] );
		$ec_option_bcc_email_addresses = stripslashes_deep( $_POST['ec_option_bcc_email_addresses'] );
		$ec_option_show_email_on_receipt = 0;
		$ec_option_show_image_on_receipt = 0;
		$ec_option_email_logo = strip_tags( stripslashes_deep( $_POST['ec_option_email_logo'] ) );
		$ec_option_current_order_id = $_POST['ec_option_current_order_id'];
		
		
		if( isset( $_POST['ec_option_order_from_email'] ))
			$ec_option_order_from_email =  $_POST['ec_option_order_from_email'];
		if( isset( $_POST['ec_option_order_use_smtp'] ))
			$ec_option_order_use_smtp =  $_POST['ec_option_order_use_smtp'];
		if( isset( $_POST['ec_option_order_from_smtp_host'] ))
			$ec_option_order_from_smtp_host =  $_POST['ec_option_order_from_smtp_host'];
		if( isset( $_POST['ec_option_order_from_smtp_encryption_type'] ))
			$ec_option_order_from_smtp_encryption_type =  $_POST['ec_option_order_from_smtp_encryption_type'];
		if( isset( $_POST['ec_option_order_from_smtp_port'] ))
			$ec_option_order_from_smtp_port =  $_POST['ec_option_order_from_smtp_port'];
		if( isset( $_POST['ec_option_order_from_smtp_username'] ))
			$ec_option_order_from_smtp_username =  $_POST['ec_option_order_from_smtp_username'];
		if( isset( $_POST['ec_option_order_from_smtp_password'] ))
			$ec_option_order_from_smtp_password =  $_POST['ec_option_order_from_smtp_password'];
		if( isset( $_POST['ec_option_bcc_email_addresses'] ))
			$ec_option_bcc_email_addresses =  $_POST['ec_option_bcc_email_addresses'];
		if( isset( $_POST['ec_option_show_email_on_receipt'] ) && $_POST['ec_option_show_email_on_receipt'] == '1')
			$ec_option_show_email_on_receipt = 1 ;
		if( isset( $_POST['ec_option_show_image_on_receipt'] ) && $_POST['ec_option_show_image_on_receipt'] == '1')
			$ec_option_show_image_on_receipt = 1 ;
		if( isset( $_POST['ec_option_use_wp_mail'] ))
			$ec_option_use_wp_mail =  $_POST['ec_option_use_wp_mail'];

		
		update_option( 'ec_option_order_from_email', $ec_option_order_from_email );
		update_option( 'ec_option_order_use_smtp', $ec_option_order_use_smtp );
		update_option( 'ec_option_order_from_smtp_host', $ec_option_order_from_smtp_host );
		update_option( 'ec_option_order_from_smtp_encryption_type', $ec_option_order_from_smtp_encryption_type );
		update_option( 'ec_option_order_from_smtp_port', $ec_option_order_from_smtp_port );
		update_option( 'ec_option_order_from_smtp_username', $ec_option_order_from_smtp_username );
		update_option( 'ec_option_order_from_smtp_password', $ec_option_order_from_smtp_password );
		update_option( 'ec_option_bcc_email_addresses', $ec_option_bcc_email_addresses );
		update_option( 'ec_option_show_email_on_receipt', $ec_option_show_email_on_receipt );
		update_option( 'ec_option_show_image_on_receipt', $ec_option_show_image_on_receipt );
		update_option( 'ec_option_email_logo', $ec_option_email_logo );
		
		//alter table to new order ID
		$this->wpdb->query( $this->wpdb->prepare( "ALTER TABLE ec_order AUTO_INCREMENT = %d", $ec_option_current_order_id) );
		
	}
	
	public function save_email_settings( ) {
		$ec_option_use_wp_mail =  $_POST['ec_option_use_wp_mail'];
		$ec_option_send_signup_email = 0;
		
		if( isset( $_POST['ec_option_use_wp_mail'] ))
			$ec_option_use_wp_mail =  $_POST['ec_option_use_wp_mail'];
		if( isset( $_POST['ec_option_send_signup_email'] ) && $_POST['ec_option_send_signup_email'] == '1')
			$ec_option_send_signup_email = 1 ;

		
		update_option( 'ec_option_use_wp_mail', $ec_option_use_wp_mail );
		update_option( 'ec_option_send_signup_email', $ec_option_send_signup_email );
	}
	
	public function ec_send_test_email( ){
		$order_id = $_POST['ec_order_id'];
		$mysqli = new ec_db_admin( );
					
		// send email
		$order_row = $mysqli->get_order_row_admin( $order_id );
		if( $order_row ){
			$order_display = new ec_orderdisplay( $order_row, true, true );
			$order_display->send_email_receipt( );
			return true;
		}else{
			return false;
		}
	}
	
	public function save_settings( ){
		
	}
	
}

add_action( 'wp_ajax_ec_admin_ajax_save_account_email_settings', 'ec_admin_ajax_save_account_email_settings' );
function ec_admin_ajax_save_account_email_settings( ){
	$account_email_settings = new wp_easycart_admin_email_settings( );
	$account_email_settings->save_account_email_settings( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_order_receipt_settings', 'ec_admin_ajax_save_order_receipt_settings' );
function ec_admin_ajax_save_order_receipt_settings( ){
	$order_receipt_settings = new wp_easycart_admin_email_settings( );
	$order_receipt_settings->save_order_receipt_settings( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_email_settings', 'ec_admin_ajax_save_email_settings' );
function ec_admin_ajax_save_email_settings( ){
	$email_settings = new wp_easycart_admin_email_settings( );
	$email_settings->save_email_settings( );
	die( );
}