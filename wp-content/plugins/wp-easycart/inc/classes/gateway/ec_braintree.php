<?php
class ec_braintree extends ec_gateway{
	
	function get_client_token( ){
		
		$headr = array( );
		$headr[] = 'User-Agent: Braintree PHP Library 3.35.0';
        $headr[] = 'X-ApiVersion: 4';
		$headr[] = 'Accept: application/xml';
		
		if( get_option( 'ec_option_braintree_environment' ) == "sandbox" ){
			$url = 'https://api.sandbox.braintreegateway.com:443/merchants/' . get_option( 'ec_option_braintree_merchant_id' ) . '/client_token';
		}else{
			$url = 'https://api.braintreegateway.com:443/merchants/' . get_option( 'ec_option_braintree_merchant_id' ) . '/client_token';
		}
		
		$data = array(
			"client_token"	=> array(
				"version" => 2
			)
		);
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt($ch, CURLOPT_USERPWD, get_option( 'ec_option_braintree_public_key' ) . ':' . get_option( 'ec_option_braintree_private_key' ) );
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, true ); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $data ) );
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		if( $response === false ){
			$this->mysqli->insert_response( 0, 1, "BRAINTREE CURL ERROR", curl_error( $ch ) );
			$response = (object) array( "error" => curl_error( $ch ) );
		}else
			$this->mysqli->insert_response( 0, 0, "Braintree Client Token Response", print_r( $response, true ) );
		curl_close ($ch);
		$xml = new SimpleXMLElement( $response );
		return $xml->value;
	}
	
	function get_gateway_data( ){
		
		$braintree_xml = '<?xml version="1.0" encoding="UTF-8"?>
			<transaction>
			  <type>sale</type>
			  <amount>' . number_format( $this->order_totals->grand_total, 2, ".", "" ) . '</amount>
			  <channel>LevelFourDevelopment_SP_BT</channel>
			  <order-id type="integer">' . $this->order_id . '</order-id>
			  <payment-method-nonce>' . $_POST['braintree_nonce'] . '</payment-method-nonce>
			  <customer>
				<first-name>' . $this->user->billing->first_name . '</first-name>
				<last-name>' . $this->user->billing->last_name . '</last-name>
				<phone>' . $this->user->billing->phone . '</phone>
				<email>' . $this->user->email . '</email>
			  </customer>
			  <billing>
				<first-name>' . $this->user->billing->first_name . '</first-name>
				<last-name>' . $this->user->billing->last_name . '</last-name>
				<street-address>' . $this->user->billing->address_line_1 . '</street-address>
				<locality>' . $this->user->billing->city . '</locality>
				<region>' . $this->user->billing->state . '</region>
				<postal-code>' . $this->user->billing->zip . '</postal-code>
				<country-code-alpha2>' . $this->user->billing->country . '</country-code-alpha2>
			  </billing>
			  <shipping>
				<first-name>' . $this->user->shipping->first_name . '</first-name>
				<last-name>' . $this->user->shipping->last_name . '</last-name>
				<street-address>' . $this->user->shipping->address_line_1 . '</street-address>
				<locality>' . $this->user->shipping->city . '</locality>
				<region>' . $this->user->shipping->state . '</region>
				<postal-code>' . $this->user->shipping->zip . '</postal-code>
				<country-code-alpha2>' . $this->user->shipping->country . '</country-code-alpha2>
			  </shipping>
			  <options>
				<submit-for-settlement type="boolean">true</submit-for-settlement>
			  </options>';
		if( get_option( 'ec_option_braintree_merchant_account_id' ) != '' ){
			$braintree_xml .= '
			  <merchant-account-id>' . get_option( 'ec_option_braintree_merchant_account_id' ) . '</merchant-account-id>';
		}
		$braintree_xml .= '
			</transaction>';
			  
		return $braintree_xml;
	}
	
	function get_gateway_url( ){
		
		if( get_option( 'ec_option_braintree_environment' ) == "sandbox" ){
			return 'https://api.sandbox.braintreegateway.com:443/merchants/' . get_option( 'ec_option_braintree_merchant_id' ) . '/transactions';
		}else{
			return 'https://api.braintreegateway.com:443/merchants/' . get_option( 'ec_option_braintree_merchant_id' ) . '/transactions';
		}

	}
	
	protected function get_gateway_response( $gateway_url, $gateway_data, $gateway_headers ){
		
		$headr = array( );
		$headr[] = 'Accept: application/xml';
		$headr[] = 'User-Agent: Braintree PHP Library 3.35.0';
        $headr[] = 'X-ApiVersion: 4';
        $headr[] = 'Content-Type: application/xml';
		
		$ch = curl_init( );
		curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt( $ch, CURLOPT_USERPWD, get_option( 'ec_option_braintree_public_key' ) . ':' . get_option( 'ec_option_braintree_private_key' ) );
		curl_setopt( $ch, CURLOPT_URL, $gateway_url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
		curl_setopt( $ch, CURLOPT_POST, true ); 
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $gateway_data );
		curl_setopt( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt( $ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		
		if( $response === false ){
			$this->mysqli->insert_response( $this->order_id, 1, "BRAINTREE CURL ERROR", curl_error( $ch ) );
			$response = (object) array( "error" => curl_error( $ch ) );
		}else
			$this->mysqli->insert_response( $this->order_id, 0, "Braintree Response", print_r( $response, true ) );
		curl_close ($ch);
		
		$xml = new SimpleXMLElement( $response );
		return $xml;
	}
	
	function handle_gateway_response( $result ){
		
		if( isset( $result->errors ) ){
			$this->is_success = 0;
			$this->error_message = $result->errors->transaction->errors[0]->error->message;
			
		}else{
			$this->mysqli->update_order_transaction_id( $this->order_id, $result->id );
			$this->is_success = 1;
			
		}
			
	}
	
	public function refund_charge( $gateway_transaction_id, $refund_amount ){
		
		if( get_option( 'ec_option_braintree_environment' ) == "sandbox" ){
			$url = 'https://api.sandbox.braintreegateway.com:443/merchants/' . get_option( 'ec_option_braintree_merchant_id' ) . '/transactions/' . $gateway_transaction_id . '/refund';
		}else{
			$url = 'https://api.braintreegateway.com:443/merchants/' . get_option( 'ec_option_braintree_merchant_id' ) . '/transactions/' . $gateway_transaction_id . '/refund';
		}
		
		$headr = array( );
		$headr[] = 'Accept: application/xml';
		$headr[] = 'User-Agent: Braintree PHP Library 3.35.0';
        $headr[] = 'X-ApiVersion: 4';
        $headr[] = 'Content-Type: application/xml';
		
		$braintree_xml = '<?xml version="1.0" encoding="UTF-8"?>
			<transaction>
			  <amount>' . number_format( $refund_amount, 2, ".", "" ) . '</amount>
			</transaction>';
		
		$ch = curl_init( );
		curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt( $ch, CURLOPT_USERPWD, get_option( 'ec_option_braintree_public_key' ) . ':' . get_option( 'ec_option_braintree_private_key' ) );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
		curl_setopt( $ch, CURLOPT_POST, true ); 
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $braintree_xml );
		curl_setopt( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt( $ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		
		if( $response === false ){
			$this->mysqli->insert_response( 0, 1, "BRAINTREE CURL ERROR", curl_error( $ch ) );
			$response = (object) array( "errors" => curl_error( $ch ) );
		}else{
			$response = new SimpleXMLElement( $response );
			$this->mysqli->insert_response( 0, 0, "Braintree Refund Response", print_r( $response, true ) );
		}
		curl_close ($ch);
		
		if( isset( $response->errors ) && isset( $response->errors->transaction ) && isset( $response->errors->transaction->errors ) && isset( $response->errors->transaction->errors[0] ) && isset( $response->errors->transaction->errors[0]->error ) && isset( $response->errors->transaction->errors[0]->error->code ) && $response->errors->transaction->errors[0]->error->code == '91506' ){
			global $wpdb;
			$order = $wpdb->get_row( $wpdb->prepare( "SELECT ec_order.grand_total FROM ec_order WHERE ec_order.gateway_transaction_id = %s", $gateway_transaction_id ) );
			
			if( $refund_amount == $order->grand_total ){ // probably new charge, try voiding
				return $this->void_charge( $gateway_transaction_id );
				
			}else{
				return false;
			}
			
		}else if( isset( $response->errors ) ){
			return false;
			
		}else{
			return true;
			
		}
		
	}
	
	public function void_charge( $gateway_transaction_id ){
		
		if( get_option( 'ec_option_braintree_environment' ) == "sandbox" ){
			$url = 'https://api.sandbox.braintreegateway.com:443/merchants/' . get_option( 'ec_option_braintree_merchant_id' ) . '/transactions/' . $gateway_transaction_id . '/void';
		}else{
			$url = 'https://api.braintreegateway.com:443/merchants/' . get_option( 'ec_option_braintree_merchant_id' ) . '/transactions/' . $gateway_transaction_id . '/void';
		}
		
		$headr = array( );
		$headr[] = 'Accept: application/xml';
		$headr[] = 'User-Agent: Braintree PHP Library 3.35.0';
        $headr[] = 'X-ApiVersion: 4';
        $headr[] = 'Content-Type: application/xml';
		
		$ch = curl_init( );
		curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt( $ch, CURLOPT_USERPWD, get_option( 'ec_option_braintree_public_key' ) . ':' . get_option( 'ec_option_braintree_private_key' ) );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
		curl_setopt( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt( $ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		
		if( $response === false ){
			$this->mysqli->insert_response( 0, 1, "BRAINTREE CURL ERROR", curl_error( $ch ) );
			$response = (object) array( "errors" => curl_error( $ch ) );
		}else{
			$this->mysqli->insert_response( 0, 0, "Braintree Void Response", print_r( $response, true ) );
			$response = new SimpleXMLElement( $response );
		}
		curl_close ($ch);
		
		if( isset( $response->errors ) ){
			return false;
			
		}else{
			return true;
		}
		
	}
	
}

?>