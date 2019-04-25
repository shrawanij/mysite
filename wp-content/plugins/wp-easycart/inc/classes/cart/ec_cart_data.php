<?php

class ec_cart_data{
	
	protected $mysqli;										// ec_db structure
	
	public $ec_cart_id;										// VARCHAR 255
	public $cart_data;										// Object from DB
	public $advanced_cart_options;							// Array of Cart Option Rows
	public $product_quantities;								// Array of Cart Product Quantities
	
	function __construct( $ec_cart_id ){
		
		$this->mysqli = new ec_db( );
		$this->ec_cart_id = $ec_cart_id;
		
		if( $ec_cart_id == 'not-set' ){
			$this->cart_data = (object) array(
				"tempcart_data_id"				=> 0,
				"tempcart_time"					=> time( ),
				"session_id" 					=> 'not-set',
				"user_id"						=> '',
				"email"							=> '',
				"username"						=> '',
				"first_name"					=> '',
				"last_name"						=> '',
				"coupon_code"					=> '',
				"giftcard"						=> '',
				"billing_first_name"			=> '',
				"billing_last_name"				=> '',
				"billing_company_name"			=> '',
				"billing_address_line_1"		=> '',
				"billing_address_line_2"		=> '',
				"billing_city"					=> '',
				"billing_state"					=> '',
				"billing_zip"					=> '',
				"billing_country"				=> '',
				"billing_phone"					=> '',
				"shipping_selector"				=> '',
				"shipping_first_name"			=> '',
				"shipping_last_name"			=> '',
				"shipping_company_name"			=> '',
				"shipping_address_line_2"		=> '',
				"shipping_address_line_1"		=> '',
				"shipping_city"					=> '',
				"shipping_state"				=> '',
				"shipping_zip"					=> '',
				"shipping_country"				=> '',
				"shipping_phone"				=> '',
				"create_account"				=> '',
				"order_notes"					=> '',
				"shipping_method"				=> '',
				"estimate_shipping_zip"			=> '',
				"expedited_shipping"			=> '',
				"estimate_shipping_country"		=> '',
				"is_guest"						=> '',
				"guest_key"						=> '',
				"subscription_option1"			=> '',
				"subscription_option2"			=> '',
				"subscription_option3"			=> '',
				"subscription_option4"			=> '',
				"subscription_option5"			=> '',
				"subscription_advanced_option"	=> '',
				"subscription_quantity"			=> '',
				"convert_to"					=> '',
				"translate_to"					=> '',
				"taxcloud_tax_amount"			=> '',
				"taxcloud_address_verified"		=> 0,
				"perpage"						=> '',
				"vat_registration_number"		=> '',
				"card_error"					=> '',
				"payment_type"					=> '',
				"payment_method"				=> ''
			);
		}else{
			$this->cart_data = $this->mysqli->get_cart_data( $ec_cart_id );
		}
		
		$this->advanced_cart_options = $this->mysqli->get_advanced_cart_options( $this->ec_cart_id );
		$this->product_quantities = $this->mysqli->get_tempcart_product_quantities( $this->ec_cart_id );
		if( !$this->product_quantities )
			$this->product_quantities = array( );
			
		add_action( 'wpeasycart_config_loaded', array( $this, 'init_advanced_cart_options' ) );
		
	}
	
	public function save_session_to_db( ){
			
		if( $this->ec_cart_id != '' && $this->ec_cart_id != 'not-set' ){
			/* RUN SQL */
			$this->mysqli->save_cart_data( $this->ec_cart_id, $this->cart_data );
		}
		
	}
	
	public function restore_session_from_db( ){
		
		if( $this->ec_cart_id == 'not-set' ){
			// Do not update from db.
		}else{
			$this->cart_data = $this->mysqli->get_cart_data( $this->ec_cart_id );
		}
		
	}
	
	public function clear_db_session( ){
		
		$this->mysqli->remove_cart_data( $ec_cart_id );
		
	}
	
	public function checkout_session_complete( ){
		
		// Save carry over variables
		$is_guest = $this->cart_data->is_guest;
		$guest_key = $this->cart_data->guest_key;
		$user_id = $this->cart_data->user_id;
		$email = $this->cart_data->email;
		
		// Remove this cart data
		$this->mysqli->remove_cart_data( $this->ec_cart_id );
		unset( $this->ec_cart_id );
		
		// Reset this class
		unset( $this->cart_data );
		$this->generate_new_cart_id( );
		
		$this->cart_data = new stdClass( );
		$this->cart_data->session_id = $this->ec_cart_id;
		$this->cart_data->is_guest = $is_guest;
		$this->cart_data->guest_key = $guest_key;
		$this->cart_data->user_id = $user_id;
		$this->cart_data->email = $email;
		
		// Save back to DB
		$this->save_session_to_db( );
		
	}
	
	public function generate_new_cart_id( ){
		
		global $wpdb;
		
		setcookie('ec_cart_id', "", time( ) - 3600 ); 
		setcookie('ec_cart_id', "", time( ) - 3600, "/" );
		unset( $GLOBALS['ec_cart_id'] );
		
		$vals = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
		$session_cart_id = $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)];
		
		$check_tempcart_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart.* FROM ec_tempcart WHERE ec_tempcart.session_id = %s", $session_cart_id ) );
		$check_tempcart_data_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart_data.* FROM ec_tempcart_data WHERE ec_tempcart_data.session_id = %s", $session_cart_id ) );
		while( $check_tempcart_id || $check_tempcart_data_id ){ // If we get a result, create new and go until we get a unique tempcart id...
			$session_cart_id = $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)];
			$check_tempcart_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart.* FROM ec_tempcart WHERE ec_tempcart.session_id = %s", $session_cart_id ) );
			$check_tempcart_data_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart_data.* FROM ec_tempcart_data WHERE ec_tempcart_data.session_id = %s", $session_cart_id ) );
		}
		
		$this->ec_cart_id = $session_cart_id;
		$GLOBALS['ec_cart_id'] = $this->ec_cart_id;
		setcookie( 'ec_cart_id', $this->ec_cart_id, time( ) + ( 3600 * 24 * 1 ), "/" );
		
	}
	
	public function get_tempcart_product_quantity( $product_id ){
		
		for( $i=0; $i<count( $this->product_quantities ); $i++ ){
			
			if( $this->product_quantities[$i]->product_id == $product_id )
				return $this->product_quantities[$i]->quantity;
			
		}
		
	}
	
	public function init_advanced_cart_options( ){
		
		for( $i=0; $i<count( $this->advanced_cart_options ); $i++ ){
			
			$option = $GLOBALS['ec_advanced_optionsets']->get_advanced_option( $this->advanced_cart_options[$i]->option_id );
			
			$this->advanced_cart_options[$i]->option_name = $option->option_name;
			$this->advanced_cart_options[$i]->option_label = $option->option_label;
			$this->advanced_cart_options[$i]->option_type = $option->option_type;
			
			for( $j=0; $j<count( $option->option_items ); $j++ ){
				if( $option->option_items[$j]->optionitem_id == $this->advanced_cart_options[$i]->optionitem_id ){
					foreach( $option->option_items[$j] as $key=>$value ){
						$this->advanced_cart_options[$i]->{$key} = $value;
					}
				}
			}
			
		}
		
	}
	
	public function get_advanced_cart_options( $tempcart_id ){
		
		$cartitem_optionitems = array( );
		
		for( $i=0; $i<count( $this->advanced_cart_options ); $i++ ){
			
			if( $this->advanced_cart_options[$i]->tempcart_id == $tempcart_id ){
				
				$cartitem_optionitems[] = $this->advanced_cart_options[$i];
			
			}
			
		}
		
		return $cartitem_optionitems;
		
	}
	
}

?>