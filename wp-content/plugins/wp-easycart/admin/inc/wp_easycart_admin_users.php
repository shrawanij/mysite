<?php
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'wp_easycart_admin_users' ) ) :

final class wp_easycart_admin_users{
	
	protected static $_instance = null;
	
	public $users_list_file;
	public $users_details_file;
	public $export_accounts_csv;
	
	public static function instance( ) {
		
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self(  );
		}
		return self::$_instance;
	
	}
	
	public function __construct( ){ 
		$this->users_list_file 					= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/users/users/user-list.php';	
		$this->users_details_file 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/users/users/user-details.php';
		$this->export_accounts_csv				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/exporters/export-accounts-csv.php';
		
		/* Process Admin Messages */
		add_filter( 'wp_easycart_admin_success_messages', array( $this, 'add_success_messages' ) );
		add_filter( 'wp_easycart_admin_error_messages', array( $this, 'add_failure_messages' ) );
		
		/* Process Form Actions */
		add_action( 'wp_easycart_process_post_form_action', array( $this, 'process_add_new_user' ) );
		add_action( 'wp_easycart_process_post_form_action', array( $this, 'process_update_user' ) );
		
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'process_login_as_user' ) );
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'process_delete_user' ) );
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'process_bulk_delete_user' ) );
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'process_export_users' ) );
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'process_force_password_reset' ) );
	}
	
	
	
	public function process_add_new_user( ){
		if( $_POST['ec_admin_form_action'] == "add-new-user" ){
			$result = $this->insert_user( );
			wp_easycart_admin( )->redirect( 'wp-easycart-users', 'accounts', $result );
		}
	}
	
	public function process_update_user( ){
		if( $_POST['ec_admin_form_action'] == "update-user" ){
			$result = $this->update_user( );
			wp_easycart_admin( )->redirect( 'wp-easycart-users', 'accounts', $result );
		}
	}
	
	public function process_login_as_user( ){
		if( $_GET['ec_admin_form_action'] == 'user-login-override' && isset( $_GET['user_id'] ) && !isset( $_GET['bulk'] ) ){
			$result = $this->login_as_user( );
			wp_easycart_admin( )->redirect( 'wp-easycart-users', 'accounts', $result );
		}
	}
	
	public function process_delete_user( ){
		if( $_GET['ec_admin_form_action'] == 'delete-account' && isset( $_GET['user_id'] ) && !isset( $_GET['bulk'] ) ){
			$result = $this->delete_user( );
			wp_easycart_admin( )->redirect( 'wp-easycart-users', 'accounts', $result );
		}
	}
	
	public function process_bulk_delete_user( ){
		if( $_GET['ec_admin_form_action'] == 'delete-account' && !isset( $_GET['user_id'] ) && isset( $_GET['bulk'] ) ){
			$result = $this->bulk_delete_user( );
			wp_easycart_admin( )->redirect( 'wp-easycart-users', 'accounts', $result );
		}
	}
	
	public function process_export_users( ){
		if( $_GET['ec_admin_form_action'] == 'export-accounts-csv' || $_GET['ec_admin_form_action'] == 'export-accounts-csv-all' ){
			include( $this->export_accounts_csv );
			die( );
		}
	}
	
	public function process_force_password_reset( ){
		if( $_GET['ec_admin_form_action'] == 'accounts-force-password-reset' && !isset( $_GET['user_id'] ) && isset( $_GET['bulk'] ) ){
			$result = $this->bulk_force_password_reset( );
			wp_easycart_admin( )->redirect( 'wp-easycart-users', 'accounts', $result );
		}
	}
	
	public function add_success_messages( $messages ){
		if( isset( $_GET['success'] ) && $_GET['success'] == 'user-inserted' ){
			$messages[] = 'User successfully inserted';
		}else if( isset( $_GET['success'] ) && $_GET['success'] == 'user-updated' ){
			$messages[] = 'User successfully updated';
		}else if( isset( $_GET['success'] ) && $_GET['success'] == 'user-deleted' ){
			$messages[] = 'Users(s) successfully deleted';
		}else if( isset( $_GET['success'] ) && $_GET['success'] == 'user-logged-in' ){
			$messages[] = 'You are now logged in as this user. Please use caution when viewing the store.';
		}else if( isset( $_GET['success'] ) && $_GET['success'] == 'user-password-reset' ){
			$messages[] = 'User(s) passwords were successfully reset and emailed with information to update their password.';
		}
		return $messages;
	}
	
	public function add_failure_messages( $messages ){
		if( isset( $_GET['error'] ) && $_GET['error'] == 'user-duplicate' ){
			$messages[] = 'User email already exists';
		}
		return $messages;
	}
	
	public function load_users_list( ){
		//add new or edit, show details page
		if( ( isset( $_GET['user_id'] ) && isset( $_GET['ec_admin_form_action'] ) && $_GET['ec_admin_form_action'] == 'edit' ) || 
			( isset( $_GET['ec_admin_form_action'] ) && $_GET['ec_admin_form_action'] == 'add-new' ) ){
			
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/inc/wp_easycart_admin_details_user.php' );
			$details = new wp_easycart_admin_details_user( );
			$details->output( esc_attr( $_GET['ec_admin_form_action'] ) );
		
		}else{
			include( $this->users_list_file );
		
		}
	}
	
	public function insert_user( ){
		global $wpdb;
		
		$email = stripslashes_deep( $_POST['email'] );
		$password = md5( stripslashes_deep( $_POST['password'] ) );
		$first_name = stripslashes_deep( $_POST['first_name'] );
		$last_name = stripslashes_deep( $_POST['last_name'] );
		$user_level = stripslashes_deep( $_POST['user_level'] );
		$user_notes = stripslashes_deep( $_POST['user_notes'] );
		$vat_registration_number = stripslashes_deep( $_POST['vat_registration_number'] );
		
		$is_subscriber = $exclude_tax = $exclude_shipping = 0;
		if( isset( $_POST['is_subscriber'] ) )
			$is_subscriber = 1;
		if( isset( $_POST['exclude_tax'] ) )
			$exclude_tax = 1;
		if( isset( $_POST['exclude_shipping'] ) )
			$exclude_shipping = 1;
		
		$billing_first_name = stripslashes_deep( $_POST['billing_first_name'] );
		$billing_last_name = stripslashes_deep( $_POST['billing_last_name'] );
		$billing_company_name = stripslashes_deep( $_POST['billing_company_name'] );
		$billing_address_line_1 = stripslashes_deep( $_POST['billing_address_line_1'] );
		$billing_address_line_2 = stripslashes_deep( $_POST['billing_address_line_2'] );
		$billing_city = stripslashes_deep( $_POST['billing_city'] );
		$billing_state = stripslashes_deep( $_POST['billing_state'] );
		$billing_zip = stripslashes_deep( $_POST['billing_zip'] );
		$billing_country = stripslashes_deep( $_POST['billing_country'] );
		$billing_phone = stripslashes_deep( $_POST['billing_phone'] );
		
		$shipping_first_name = stripslashes_deep( $_POST['shipping_first_name'] );
		$shipping_last_name = stripslashes_deep( $_POST['shipping_last_name'] );
		$shipping_company_name = stripslashes_deep( $_POST['shipping_company_name'] );
		$shipping_address_line_1 = stripslashes_deep( $_POST['shipping_address_line_1'] );
		$shipping_address_line_2 = stripslashes_deep( $_POST['shipping_address_line_2'] );
		$shipping_city = stripslashes_deep( $_POST['shipping_city'] );
		$shipping_state = stripslashes_deep( $_POST['shipping_state'] );
		$shipping_zip = stripslashes_deep( $_POST['shipping_zip'] );
		$shipping_country = stripslashes_deep( $_POST['shipping_country'] );
		$shipping_phone = stripslashes_deep( $_POST['shipping_phone'] );
		
		$duplicate = $wpdb->query( $wpdb->prepare( "SELECT * FROM ec_user WHERE ec_user.email = %s", $email ) );
		
		if( !$duplicate ){
			
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_user( email, password, first_name, last_name, user_level, is_subscriber, exclude_tax, exclude_shipping, user_notes, vat_registration_number ) VALUES( %s, %s, %s, %s, %s, %d, %d, %d, %s, %s )", $email, $password, $first_name, $last_name, $user_level, $is_subscriber, $exclude_tax, $exclude_shipping, $user_notes, $vat_registration_number ) );
			$user_id = $wpdb->insert_id;
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_address( user_id, first_name, last_name, company_name, address_line_1, address_line_2, city, state, zip, country, phone ) VALUES( %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", $user_id, $billing_first_name, $billing_last_name, $billing_company_name, $billing_address_line_1, $billing_address_line_2, $billing_city, $billing_state, $billing_zip, $billing_country, $billing_phone ) );
			$billing_id = $wpdb->insert_id;
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_address( user_id, first_name, last_name, company_name, address_line_1, address_line_2, city, state, zip, country, phone ) VALUES( %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", $user_id, $shipping_first_name, $shipping_last_name, $shipping_company_name, $shipping_address_line_1, $shipping_address_line_2, $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $shipping_phone ) );
			$shipping_id = $wpdb->insert_id;
			$wpdb->query( $wpdb->prepare( "UPDATE ec_user SET default_billing_address_id = %d, default_shipping_address_id = %d WHERE user_id = %d", $billing_id, $shipping_id, $user_id ) );
			
			if( $is_subscriber ){
				$wpdb->query( $wpdb->prepare( "DELETE FROM ec_subscriber WHERE ec_subscriber.email = %s", $email ) );
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_subscriber( email, first_name, last_name ) VALUES( %s, %s, %s )", $email, $first_name, $last_name ) );
			}else{
				$remove_subscriber = $wpdb->query( $wpdb->prepare( "DELETE FROM ec_subscriber WHERE email = %s", $email ) );	
			}
			
			if( function_exists( 'mymail' ) ){
				mymail( 'subscribers' )->add( array(
					'firstname' => $first_name,
					'lastname' 	=> $last_name,
					'email'		=> $email,
					'status' 	=> 1
				), false );
			}
			
			if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
				$quickbooks = new ec_quickbooks( );
				$quickbooks->add_user( $user_id );
			}
				
			do_action( 'wpeasycart_account_added', $user_id );
			
			return array( 'success' => 'user-inserted' );

		}else{
			return array( 'error' => 'user-duplicate' );
		}
	}
	
	public function update_user( ){	
		global $wpdb;
		
		$user_id = $_POST['user_id'];			
		$first_name = stripslashes_deep( $_POST['first_name'] );
		$last_name = stripslashes_deep( $_POST['last_name'] );
		$email = stripslashes_deep( $_POST['email'] );
		$user_level = stripslashes_deep( $_POST['user_level'] );
		$password = stripslashes_deep( $_POST['password'] );
		
		$user_notes = stripslashes_deep( $_POST['user_notes'] );
		$vat_registration_number = stripslashes_deep( $_POST['vat_registration_number'] );
		$is_subscriber = $exclude_tax = $exclude_shipping = 0;
		if( isset( $_POST['is_subscriber'] ) )
			$is_subscriber = 1;
		if( isset( $_POST['exclude_tax'] ) )
			$exclude_tax = 1;
		if( isset( $_POST['exclude_shipping'] ) )
			$exclude_shipping = 1;
		
		$default_billing_address_id = $_POST['default_billing_address_id'];
		$billing_first_name = stripslashes_deep( $_POST['billing_first_name'] );
		$billing_last_name = stripslashes_deep( $_POST['billing_last_name'] );
		$billing_company_name = stripslashes_deep( $_POST['billing_company_name'] );
		$billing_address_line_1 = stripslashes_deep( $_POST['billing_address_line_1'] );
		$billing_address_line_2 = stripslashes_deep( $_POST['billing_address_line_2'] );
		$billing_city = stripslashes_deep( $_POST['billing_city'] );
		$billing_state = stripslashes_deep( $_POST['billing_state'] );
		$billing_zip = stripslashes_deep( $_POST['billing_zip'] );
		$billing_country = stripslashes_deep( $_POST['billing_country'] );
		$billing_phone = stripslashes_deep( $_POST['billing_phone'] );
		
		$default_shipping_address_id = $_POST['default_shipping_address_id'];
		$shipping_first_name = stripslashes_deep( $_POST['shipping_first_name'] );
		$shipping_last_name = stripslashes_deep( $_POST['shipping_last_name'] );
		$shipping_company_name = stripslashes_deep( $_POST['shipping_company_name'] );
		$shipping_address_line_1 = stripslashes_deep( $_POST['shipping_address_line_1'] );
		$shipping_address_line_2 = stripslashes_deep( $_POST['shipping_address_line_2'] );
		$shipping_city = stripslashes_deep( $_POST['shipping_city'] );
		$shipping_state = stripslashes_deep( $_POST['shipping_state'] );
		$shipping_zip = stripslashes_deep( $_POST['shipping_zip'] );
		$shipping_country = stripslashes_deep( $_POST['shipping_country'] );
		$shipping_phone = stripslashes_deep( $_POST['shipping_phone'] );
		
		$old_email = $wpdb->get_var( $wpdb->prepare( "SELECT email FROM ec_user WHERE user_id = %d", $user_id ) );
		
		if( $old_email != $email ){
			$duplicate = $wpdb->query( $wpdb->prepare( "SELECT * FROM ec_user WHERE ec_user.email = %s", $email ) );
			if( $duplicate ){
				return array( 'error' => 'user-duplicate' );
			}
		}
		
		if( $default_billing_address_id == 0 ){
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_address( user_id, first_name, last_name,  company_name, address_line_1, address_line_2, city, state, zip, country, phone ) VALUES( %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", $user_id, $billing_first_name, $billing_last_name, $billing_company_name, $billing_address_line_1, $billing_address_line_2, $billing_city, $billing_state, $billing_zip, $billing_country, $billing_phone) );
			$billing_id = $wpdb->insert_id;
			$wpdb->query( $wpdb->prepare( "UPDATE ec_user SET default_billing_address_id = %d WHERE user_id = %d", $billing_id, $user_id ) );
		
		}else{
			$wpdb->query( $wpdb->prepare( "UPDATE ec_address SET first_name = %s, last_name = %s, company_name = %s, address_line_1 = %s, address_line_2 = %s, city = %s, state = %s, zip = %s, country = %s, phone = %s WHERE address_id = %d", $billing_first_name, $billing_last_name, $billing_company_name, $billing_address_line_1, $billing_address_line_2, $billing_city, $billing_state, $billing_zip, $billing_country, $billing_phone, $default_billing_address_id ) );
			
		}
		
		if( $default_shipping_address_id == 0 ){
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_address( user_id, first_name, last_name,  company_name, address_line_1, address_line_2, city, state, zip, country, phone ) VALUES( %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", $user_id, $shipping_first_name, $shipping_last_name, $shipping_company_name, $shipping_address_line_1, $shipping_address_line_2, $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $shipping_phone) );
			$shipping_id = $wpdb->insert_id;
			$wpdb->query( $wpdb->prepare( "UPDATE ec_user SET default_shipping_address_id = %d WHERE user_id = %d", $shipping_id, $user_id ) );
		
		}else{
			$wpdb->query( $wpdb->prepare( "UPDATE ec_address SET first_name = %s, last_name = %s, company_name = %s, address_line_1 = %s, address_line_2 = %s, city = %s, state = %s, zip = %s, country = %s, phone = %s WHERE address_id = %d", $shipping_first_name, $shipping_last_name, $shipping_company_name, $shipping_address_line_1, $shipping_address_line_2, $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $shipping_phone, $default_shipping_address_id ) );
			
		}
			
		if( $is_subscriber ){
			$wpdb->query( $wpdb->prepare( "DELETE FROM ec_subscriber WHERE ec_subscriber.email = %s", $email ) );
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_subscriber( email, first_name , last_name ) VALUES( %s, %s, %s )", $email, $first_name, $last_name ) );
		
		}else{
			$wpdb->query( $wpdb->prepare( "DELETE FROM ec_subscriber WHERE ec_subscriber.email = %s", $email ) );
		}
		
		if( $password == "" ){
			$wpdb->query( $wpdb->prepare( "UPDATE ec_user SET email = %s, first_name = %s, last_name = %s, user_level = %s, is_subscriber = %d, exclude_tax = %d, exclude_shipping = %d, user_notes = %s, vat_registration_number = %s WHERE ec_user.user_id = %d", $email, $first_name, $last_name, $user_level, $is_subscriber, $exclude_tax, $exclude_shipping, $user_notes, $vat_registration_number, $user_id ) );
			
		}else{
			$wpdb->query( $wpdb->prepare( "UPDATE ec_user SET email = %s, password = %s, first_name = %s, last_name = %s, user_level = %s, is_subscriber = %d, exclude_tax = %d, exclude_shipping = %d, user_notes = %s, vat_registration_number = %s WHERE user_id = %d", $email, md5( $password ), $first_name, $last_name, $user_level, $is_subscriber, $exclude_tax, $exclude_shipping, $user_notes, $vat_registration_number, $user_id ) );
		}
		
		if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
			$quickbooks = new ec_quickbooks( );
			$quickbooks->update_user_admin( $user_id );	
		}	
		
		do_action( 'wpeasycart_account_updated', $user_id );
		
		return array( 'success' => 'user-updated' );
	}
	
	public function login_as_user( ){
		global $wpdb;
		wpeasycart_session( )->handle_session( );
		
		$user_id = $_GET['user_id'];
		$user = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ec_user WHERE user_id = %d", $user_id ) );
		$GLOBALS['ec_cart_data']->cart_data->user_id = $user->user_id;
		$GLOBALS['ec_cart_data']->cart_data->email = $user->email;
		$GLOBALS['ec_cart_data']->cart_data->username = $user->first_name . " " . $user->last_name;
		$GLOBALS['ec_cart_data']->cart_data->first_name = $user->first_name;
		$GLOBALS['ec_cart_data']->cart_data->last_name = $user->last_name;
		$GLOBALS['ec_cart_data']->cart_data->is_guest = "";
		$GLOBALS['ec_cart_data']->cart_data->guest_key = "";
		$GLOBALS['ec_cart_data']->save_session_to_db( );
		
		wp_cache_flush( );
		do_action( 'wpeasycart_login_success', $user->email );
		
		return array( 'ec_admin_form_action' => 'edit', 'user_id' => $user_id, 'success' => 'user-logged-in' );
	}
	
	public function delete_user( ){
		global $wpdb;
		$user_id = $_GET['user_id'];
		$wpdb->query( $wpdb->prepare( "DELETE FROM ec_address WHERE user_id = %d", $user_id ) );
		$wpdb->query( $wpdb->prepare( "DELETE FROM ec_user WHERE user_id = %d", $user_id ) );
		return array( 'success' => 'user-deleted' );
	}
	
	public function bulk_delete_user( ){
		global $wpdb;
		
		$bulk_ids = $_GET['bulk'];
		foreach( $bulk_ids as $bulk_id ){
			$wpdb->query( $wpdb->prepare( "DELETE FROM ec_address WHERE user_id = %d", $bulk_id ) );
			$wpdb->query( $wpdb->prepare( "DELETE FROM ec_user WHERE user_id = %d", $bulk_id ) );
		}
		
		return array( 'success' => 'user-deleted' );
	}
	
	public function bulk_force_password_reset( ){
		global $wpdb;
		
		$bulk_ids = $_GET['bulk'];
		foreach( $bulk_ids as $bulk_id ){
			$user = $wpdb->get_row( $wpdb->prepare( "SELECT email, first_name, last_name FROM ec_user WHERE user_id = %d", $bulk_id ) );
			if( $user ){
				$new_password = $this->get_random_password( );
				$password = md5( $new_password );
				$password = apply_filters( 'wpeasycart_password_hash', $password, $new_password );
				$wpdb->query( $wpdb->prepare( "UPDATE ec_user SET password = %s WHERE user_id = %d", $password, $bulk_id ) );
				$this->send_new_password_email( $user, $new_password );
			}
		}
		
		return array( 'success' => 'user-password-reset' );
	}
	
	private function send_new_password_email( $user, $new_password ){
		
		$email = $user->email;
		$email_logo_url = get_option( 'ec_option_email_logo' );
	 	
		// Get receipt
		ob_start();
        if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_retrieve_password_email.php' ) )	
			include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_retrieve_password_email.php' );	
		else
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_account_retrieve_password_email.php' );
		$message = ob_get_contents();
		ob_end_clean();
		
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-Type: text/html; charset=utf-8";
		$headers[] = "From: " . stripslashes( get_option( 'ec_option_password_from_email' ) );
		$headers[] = "Reply-To: " . stripslashes( get_option( 'ec_option_password_from_email' ) );
		$headers[] = "X-Mailer: PHP/" . phpversion( );
		
		$email_send_method = get_option( 'ec_option_use_wp_mail' );
		$email_send_method = apply_filters( 'wpeasycart_email_method', $email_send_method );
		
		if( $email_send_method == "1" ){
			wp_mail( $email, $GLOBALS['language']->get_text( "account_forgot_password_email", "account_forgot_password_email_title" ), $message, implode("\r\n", $headers));
		
		}else if( $email_send_method == "0" ){
			$to = $email;
			$subject = $GLOBALS['language']->get_text( "account_forgot_password_email", "account_forgot_password_email_title" );
			$mailer = new wpeasycart_mailer( );
			$mailer->send_customer_email( $to, $subject, $message );
		
		}else{
			do_action( 'wpeasycart_custom_forgot_password_email', stripslashes( get_option( 'ec_option_password_from_email' ) ), $email, "", $GLOBALS['language']->get_text( "account_forgot_password_email", "account_forgot_password_email_title" ), $message );
			
		}
		
	}
	
	private function get_random_password( ){
		$rand_chars = array( "A", "B", "C", "D", "E", "F", "G", "H", "I", "J" );
		$rand_password = $rand_chars[ rand( 0, 9 ) ] . $rand_chars[ rand( 0, 9 ) ] . $rand_chars[ rand( 0, 9 ) ] . $rand_chars[ rand( 0, 9 ) ] . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 );
		return $rand_password;
	}
	
	public function check_existing_email( ) {
		global $wpdb;
		if( isset( $_POST['email'] ) ){
			 $email = $_POST['email'];
			 $emails = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ec_user WHERE ec_user.email = %s", $email ) );

			 if( count( $emails ) > 0 )
			  	echo "Email Already Exist";
			 else
			  	echo "OK";
		}
	}
	
}
endif; // End if class_exists check

function wp_easycart_admin_users( ){
	return wp_easycart_admin_users::instance( );
}
wp_easycart_admin_users( );

/* Hooks for ajax email check */
add_action( 'wp_ajax_ec_admin_check_email_exists', 'ec_admin_check_email_exists' );
function ec_admin_check_email_exists( ){
	$users = new wp_easycart_admin_users( );
	$users->check_existing_email( );
	die( );

}