<?php
if( !defined( 'ABSPATH' ) ) exit;

class wp_easycart_admin_details_user extends wp_easycart_admin_details{
	
	public $user;
	public $billing_info;
	public $shipping_info;
	public $user_roles;
	
	public function __construct( ){
		parent::__construct( );
		add_action( 'wp_easycart_admin_user_details_basic_fields', array( $this, 'basic_fields' ) );
		add_action( 'wp_easycart_admin_user_details_optional_fields', array( $this, 'optional_fields' ) );
		add_action( 'wp_easycart_admin_user_details_billing_fields', array( $this, 'billing_fields' ) );
		add_action( 'wp_easycart_admin_user_details_shipping_fields', array( $this, 'shipping_fields' ) );
	}
	
	protected function init( ){
		$this->docs_link = 'http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=user-accounts';
		$this->id = 0;
		$this->page = 'wp-easycart-users';
		$this->subpage = 'accounts';
		$this->action = 'admin.php?page=' . $this->page . '&subpage=' . $this->subpage;
		$this->form_action = 'add-new-user';
		$this->user = (object) array(
			"user_id"						=> "",
			"email"							=> "",
			"first_name"					=> "",
			"last_name"						=> "",
			"default_billing_address_id"	=> "",
			"default_shipping_address_id"	=> "",
			"user_level"					=> "",
			"is_subscriber"					=> "",
			"stripe_customer_id"			=> "",
			"default_card_type"				=> "",
			"default_card_last4"			=> "",
			"exclude_tax"					=> "",
			"exclude_shipping"				=> "",
			"user_notes"					=> "",
			"vat_registration_number"		=> ""
		);
		$this->billing_info = $this->shipping_info = (object) array(
			"address_id"					=> "",
			"first_name"					=> "",
			"last_name"						=> "",
			"company_name"					=> "",
			"address_line_1"				=> "",
			"address_line_2"				=> "",
			"city"							=> "",
			"state"							=> "",
			"zip"							=> "",
			"country"						=> "",
			"phone"							=> ""
		);
	}
	
	protected function init_data( ){
		$this->form_action = 'update-user';
		$this->user = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT ec_user.* FROM ec_user WHERE user_id = %d", $_GET['user_id'] ) );
		$this->id = $this->user->user_id;
		$this->billing_info = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT ec_address.* FROM ec_address WHERE address_id = %d", $this->user->default_billing_address_id ) );
		$this->shipping_info = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT ec_address.* FROM ec_address WHERE address_id = %d", $this->user->default_shipping_address_id ) );
		
	}

	public function output( $type = 'edit' ){
		$this->init( );
		if( $type == 'edit' )
			$this->init_data( );
		
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/users/users/user-details.php' );
	}
	
	public function basic_fields( ){
		
		$this->user_roles = $this->wpdb->get_results( "SELECT * FROM ec_role ORDER BY role_label ASC" );
		$user_level_select_data = array( );
		foreach( $this->user_roles as $user_role ){
			$user_level_select_data[] = (object) array(
				"id"				=> $user_role->role_label,
				"value"				=> $user_role->role_label
			);
		}
		$fields = apply_filters( 'wp_easycart_admin_user_details_basic_fields_list', array(
			array(
				"name"				=> "default_billing_address_id",
				"alt_name"			=> "default_billing_address_id",
				"type"				=> "hidden",
				"value"				=> $this->user->default_billing_address_id
			),
			array(
				"name"				=> "default_shipping_address_id",
				"alt_name"			=> "default_shipping_address_id",
				"type"				=> "hidden",
				"value"				=> $this->user->default_shipping_address_id
			),
			array(
				"name"				=> "first_name",
				"type"				=> "text",
				"label"				=> "First Name",
				"required" 			=> true,
				"message" 			=> "Please enter a first name.",
				"validation_type" 	=> 'text',
				"value"				=> $this->user->first_name
			),
			array(
				"name"				=> "last_name",
				"type"				=> "text",
				"label"				=> "Last Name",
				"required" 			=> true,
				"message" 			=> "Please enter a last name.",
				"validation_type" 	=> 'text',
				"value"				=> $this->user->last_name
			),
			array(
				"name"				=> "email",
				"type"				=> "text",
				"label"				=> "Email Address",
				"required" 			=> true,
				"message" 			=> "Please enter a valid email address.",
				"validation_type" 	=> 'email',
				"onchange"			=> "ec_admin_check_email_exists",
				"value"				=> $this->user->email
			),
			array(
				"name"				=> "user_level",
				"type"				=> "select",
				"data"				=> $user_level_select_data,
				"data_label" 		=> "Select a User Access Level",
				"label" 			=> "User Access Level",
				"required" 			=> true,
				"message" 			=> "Please select a user access level.",
				"validation_type" 	=> "select",
				"value"				=> $this->user->user_level
			),
			array(
				"name"				=> "password",
				"type"				=> "password_new",
				"label"				=> "Password",
				"required" 			=> true,
				"message" 			=> "Please enter a valid password 8 characters or greater.",
				"validation_type" 	=> "password",
				"value"				=> ""
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function optional_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_user_details_optional_fields_list', array(
			array(
				"name"	=> "user_notes",
				"type"	=> "textarea",
				"label"	=> "Admin User Notes",
				"required" => false,
				"message" => "",
				"value" => $this->user->user_notes
			),
			array(
				"name"	=> "vat_registration_number",
				"type"	=> "text",
				"label"	=> "VAT Registration Number",
				"required" => false,
				"message" => "",
				"value" => $this->user->vat_registration_number
			),
			array(
				"name"	=> "is_subscriber",
				"type"	=> "checkbox",
				"label"	=> "Is Subscriber",
				"required" => false,
				"message" => "",
				"selected" => false,
				"value" => $this->user->is_subscriber
			),
			array(
				"name"	=> "exclude_tax",
				"type"	=> "checkbox",
				"label"	=> "Exclude from Tax",
				"required" => false,
				"message" => "",
				"selected" => false,
				"value" => $this->user->exclude_tax
			),
			array(
				"name"	=> "exclude_shipping",
				"type"	=> "checkbox",
				"label"	=> "Exclude from Shipping",
				"required" => false,
				"message" => "",
				"selected" => false,
				"value" => $this->user->exclude_shipping
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function billing_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_user_details_billing_fields_list', array(
			array(
				"name"	=> "billing_first_name",
				"type"	=> "text",
				"label"	=> "First Name",
				"required" => false,
				"message" => "",
				"value" => $this->billing_info->first_name
			),
			array(
				"name"	=> "billing_last_name",
				"type"	=> "text",
				"label"	=> "Last Name",
				"required" => false,
				"message" => "",
				"value" => $this->billing_info->last_name
			),
			array(
				"name"	=> "billing_company_name",
				"type"	=> "text",
				"label"	=> "Company Name",
				"required" => false,
				"message" => "",
				"value" => $this->billing_info->company_name
			),
			array(
				"name"	=> "billing_address_line_1",
				"type"	=> "text",
				"label"	=> "Address Line 1",
				"required" => false,
				"message" => "",
				"value" => $this->billing_info->address_line_1
			),
			array(
				"name"	=> "billing_address_line_2",
				"type"	=> "text",
				"label"	=> "Address Line 2",
				"required" => false,
				"message" => "",
				"value" => $this->billing_info->address_line_2
			),
			array(
				"name"	=> "billing_city",
				"type"	=> "text",
				"label"	=> "City",
				"required" => false,
				"message" => "",
				"value" => $this->billing_info->city
			),
			array(
				"name"	=> "billing_state",
				"type"	=> "text",
				"label"	=> "State/Province",
				"required" => false,
				"message" => "",
				"value" => $this->billing_info->state
			),
			array(
				"name"	=> "billing_zip",
				"type"	=> "text",
				"label"	=> "Zip/Postal Code",
				"required" => false,
				"message" => "",
				"value" => $this->billing_info->zip
			),
			array(
				"name"	=> "billing_country",
				"type"	=> "text",
				"label"	=> "Country",
				"required" => false,
				"message" => "",
				"value" => $this->billing_info->country
			),
			array(
				"name"	=> "billing_phone",
				"type"	=> "text",
				"label"	=> "Phone Number",
				"required" => false,
				"message" => "",
				"value" => $this->billing_info->phone
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function shipping_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_user_details_shipping_fields_list', array(
			array(
				"name"	=> "shipping_first_name",
				"type"	=> "text",
				"label"	=> "First Name",
				"required" => false,
				"message" => "",
				"value" => $this->shipping_info->first_name
			),
			array(
				"name"	=> "shipping_last_name",
				"type"	=> "text",
				"label"	=> "Last Name",
				"required" => false,
				"message" => "",
				"value" => $this->shipping_info->last_name
			),
			array(
				"name"	=> "shipping_company_name",
				"type"	=> "text",
				"label"	=> "Company Name",
				"required" => false,
				"message" => "",
				"value" => $this->shipping_info->company_name
			),
			array(
				"name"	=> "shipping_address_line_1",
				"type"	=> "text",
				"label"	=> "Address Line 1",
				"required" => false,
				"message" => "",
				"value" => $this->shipping_info->address_line_1
			),
			array(
				"name"	=> "shipping_address_line_2",
				"type"	=> "text",
				"label"	=> "Address Line 2",
				"required" => false,
				"message" => "",
				"value" => $this->shipping_info->address_line_2
			),
			array(
				"name"	=> "shipping_city",
				"type"	=> "text",
				"label"	=> "City",
				"required" => false,
				"message" => "",
				"value" => $this->shipping_info->city
			),
			array(
				"name"	=> "shipping_state",
				"type"	=> "text",
				"label"	=> "State/Province",
				"required" => false,
				"message" => "",
				"value" => $this->shipping_info->state
			),
			array(
				"name"	=> "shipping_zip",
				"type"	=> "text",
				"label"	=> "Zip/Postal Code",
				"required" => false,
				"message" => "",
				"value" => $this->shipping_info->zip
			),
			array(
				"name"	=> "shipping_country",
				"type"	=> "text",
				"label"	=> "Country",
				"required" => false,
				"message" => "",
				"value" => $this->shipping_info->country
			),
			array(
				"name"	=> "shipping_phone",
				"type"	=> "text",
				"label"	=> "Phone Number",
				"required" => false,
				"message" => "",
				"value" => $this->shipping_info->phone
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function print_password_new_field( $column ){
		if( $this->user->user_id != 0 ){
			echo '<div id="ec_admin_row_update_password"><input type="checkbox" name="update_password" id="update_password" value="1" onclick="return ec_admin_show_password_update( );"> Update User Password?</div>';
			echo '<div id="ec_admin_row_update_user_password" class="ec_admin_hidden">';
			echo '<div id="ec_admin_row_password">New Password<input type="password" name="password" id="password" value=""></div>';
			echo '<div id="ec_admin_row_retype_password">Retype Password<input type="password" name="retype_password" id="retype_password" value=""></div>';
			echo '</div>';
		}else{
			$fields = array(
				array(
					"name"				=> "password",
					"type"				=> "password",
					"label"				=> "Password",
					"required" 			=> true,
					"validation_type" 	=> 'password',
					"message" 			=> "Please enter a password with at least 8 characters.",
					"value"				=> ''
				),
				array(
					"name"				=> "retype_password",
					"type"				=> "password",
					"label"				=> "Retype Password",
					"required" 			=> false,
					"validation_type" 	=> 'password',
					"message" 			=> "Passwords do not match.  Please retype your password.",
					"value"				=> ''
				)
			);
			$this->print_fields( $fields );
		}
	}
	
}