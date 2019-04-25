<?php
// This is a payment gateway basic structure,
// child classes will be based on this class.

class ec_square extends ec_gateway{
	
	/****************************************
	* GATEWAY SPECIFIC HELPER FUNCTIONS
	*****************************************/
	
	function get_gateway_data( ){
		
		if( get_option( 'ec_option_square_currency' ) == '' ){
			$this->set_currency( );
		}
		
		$json_arr = array( 	"card_nonce"			=> $_POST['nonce'],
							"amount_money"			=> array(
								"amount"				=> (integer) number_format( $this->order_totals->grand_total * 100, 0, "", "" ),
								"currency"				=> get_option( 'ec_option_square_currency' )
							),
							"idempotency_key"		=> uniqid( ),
							"reference_id"			=> (string) $this->order_id,
							"note"					=> 'EasyCart - Order ' . (string) $this->order_id,
							"billing_address"		=> array( 
								"address_line_1"	=> (string) $this->user->billing->address_line_1,
								"address_line_2"	=> (string) $this->user->billing->address_line_2,
								"locality"			=> (string) $this->user->billing->city,
								"administrative_district_level_1"	=> (string) $this->user->billing->state,
								"postal_code"		=> (string) $this->user->billing->zip,
								"country"			=> (string) $this->user->billing->country
							),
							"shipping_address"		=> array( 
								"address_line_1"	=> (string) $this->user->shipping->address_line_1,
								"address_line_2"	=> (string) $this->user->shipping->address_line_2,
								"locality"			=> (string) $this->user->shipping->city,
								"administrative_district_level_1"	=> (string) $this->user->shipping->state,
								"postal_code"		=> (string) $this->user->shipping->zip,
								"country"			=> (string) $this->user->shipping->country
							),
							"buyer_email_address"	=> (string) $this->user->email );
		
		$application_fee = number_format( $this->order_totals->grand_total * 100 * apply_filters( 'wp_easycart_stripe_connect_fee_rate', 2 ) * .01, 0, '', '' );
		if( $application_fee > 0 && get_option( 'ec_option_square_currency' ) == 'USD' ){
			$json_arr["additional_recipients"] = array(
				(object) array(
								"location_id"		=> "D3G74XXQYM8Y5",
								"description"		=> "Application Fees",
								"amount_money"		=> (object) array(
									"amount"		=> (int) $application_fee,
									"currency"		=> get_option( 'ec_option_square_currency' )
								)
				)
			);
		}
		
		return $json_arr;
		
	}
	
	function get_gateway_url( ){
		
		$location_id = get_option( 'ec_option_square_location_id' );
		if( !$location_id )
			$location_id = $this->get_location_id( );
		return "https://connect.squareup.com/v2/locations/" . $location_id . "/transactions";

	}
	
	function handle_gateway_response( $response ){
		
		$response_arr = json_decode( $response );
		
		$error_text = "";
		if( isset( $response_arr->errors ) && count( $response_arr->errors ) > 0 ){
			$this->is_success = 0;
			$error_text = $response_arr->errors[0]->detail;
		}else{
			$this->is_success = 1;
			$ids = array( "transaction_id"	=> $response_arr->transaction->id, "tender_id" => $response_arr->transaction->tenders[0]->id );
			$this->mysqli->update_order_transaction_id( $this->order_id, json_encode( $ids ) );
		}
		
		$this->mysqli->insert_response( $this->order_id, !$this->is_success, "Square", $error_text );
		
		if( !$this->is_success )
			$this->error_message = $error_text;
			
	}
	
	function get_gateway_response( $gateway_url, $gateway_data, $gateway_headers ){
		
		if( get_option( 'ec_option_square_application_id' ) == '' ){
			$this->renew_token( );
		}
		
		$access_token = get_option( 'ec_option_square_access_token' );
		$headr = array();
		$headr[] = 'Accept: application/json';
		$headr[] = 'Content-Type: application/json';
		$headr[] = 'Authorization: Bearer ' . $access_token;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, $gateway_url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, true ); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $gateway_data ) );
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		if( $response === false )
			$this->mysqli->insert_response( 0, 1, "SQUARE CURL ERROR", curl_error( $ch ) );
		else
			$this->mysqli->insert_response( 0, 0, "Square Charge Response", print_r( $response, true ) );
		
		curl_close ($ch);
		
		return $response;
		
	}
	
	function get_location_id( ){
		$access_token = get_option( 'ec_option_square_access_token' );
		$headr = array();
		$headr[] = 'Accept: application/json';
		$headr[] = 'Authorization: Bearer ' . $access_token;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, "https://connect.squareup.com/v2/locations" );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, false ); 
		curl_setopt($ch, CURLOPT_HTTPGET, true );
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		if( $response === false )
			$this->mysqli->insert_response( 0, 1, "SQUARE CURL ERROR", curl_error( $ch ) );
		else
			$this->mysqli->insert_response( 0, 0, "Square Location Response", print_r( $response, true ) );
		
		curl_close ($ch);
		
		$response_arr = json_decode( $response );
		
		return $response_arr->locations[0]->id;
	}
	
	function set_currency( ){
		$locations = $this->get_locations( );
		if( count( $locations ) > 0 ){
			$found = false;
			for( $i=0; $i<count( $locations ); $i++ ){
				if( $locations[$i]->id == get_option( 'ec_option_square_location_id' ) ){
					$found = true;
					update_option( 'ec_option_square_currency', $locations[$i]->currency );
				}
			}
			if( !$found ){
				update_option( 'ec_option_square_currency', $locations[0]->currency );
			}
		}else{
			update_option( 'ec_option_square_currency', 'USD' );
		}
	}
	
	function get_locations( ){
		$access_token = get_option( 'ec_option_square_access_token' );
		$headr = array();
		$headr[] = 'Accept: application/json';
		$headr[] = 'Authorization: Bearer ' . $access_token;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, "https://connect.squareup.com/v2/locations" );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, false ); 
		curl_setopt($ch, CURLOPT_HTTPGET, true );
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		if( $response === false )
			$this->mysqli->insert_response( 0, 1, "SQUARE CURL ERROR", curl_error( $ch ) );
		else
			$this->mysqli->insert_response( 0, 0, "Square Location Response", print_r( $response, true ) );
		
		curl_close ($ch);
		
		$response_arr = json_decode( $response );
		
		return $response_arr->locations;
	}
	
	function refund_charge( $transaction_id, $refund_amount ){
		
		if( get_option( 'ec_option_square_application_id' ) == '' ){
			$this->renew_token( );
		}
		
		$ids = json_decode( $transaction_id );
		$access_token = get_option( 'ec_option_square_access_token' );
		$location_id = get_option( 'ec_option_square_location_id' );
		if( !$location_id )
			$location_id = $this->get_location_id( );
		$gateway_url = "https://connect.squareup.com/v2/locations/" . $location_id . "/transactions/" . $ids->transaction_id . "/refund";
		$gateway_data = array( 	"idempotency_key"	=> uniqid( ),
								"tender_id"			=> $ids->tender_id,
								"amount_money"		=> array(
									"amount"			=> (integer) number_format( $refund_amount * 100, 0, "", "" ),
									"currency"			=> get_option( 'ec_option_square_currency' )
								)
						);
		
		$headr = array();
		$headr[] = 'Accept: application/json';
		$headr[] = 'Content-Type: application/json';
		$headr[] = 'Authorization: Bearer ' . $access_token;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, $gateway_url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, true ); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $gateway_data ) );
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		if( $response === false )
			$this->mysqli->insert_response( 0, 1, "SQUARE CURL ERROR", curl_error( $ch ) );
		else
			$this->mysqli->insert_response( 0, 0, "Square Refund Response", print_r( $response, true ) );
		
		curl_close ($ch);
		
		$response_arr = json_decode( $response );
		
		if( isset( $response_arr->errors ) && count( $response_arr->errors ) > 0 ){
			return false;
		}else{
			return true;
		}
		
	}
	
	function renew_token( ){
		$access_token = get_option( 'ec_option_square_access_token' );
		$ch = curl_init( );
		curl_setopt( $ch, CURLOPT_URL, "https://support.wpeasycart.com/square/refresh.php?access_token=" . $access_token );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$response = curl_exec( $ch );
		if( $response === false) {
    		$response = file_get_contents( "https://support.wpeasycart.com/square/refresh.php?access_token=" . $access_token );
		}
		curl_close( $ch );
		$json = json_decode( $response );
		$response_obj = json_decode( $response );
		
		$access_token = preg_replace( "/[^A-Za-z0-9 \-\._\~\+\/]/", '', $response_obj->access_token );
		$expires = preg_replace( "/[^A-Za-z0-9 \:\-]/", '', $response_obj->expires );
		
		update_option( 'ec_option_square_access_token', $access_token );
		update_option( 'ec_option_square_token_expires', $expires );
	}
	
	function get_catalog( $cursor = false ){
		
		if( get_option( 'ec_option_square_application_id' ) == '' ){
			$this->renew_token( );
		}
		$access_token = get_option( 'ec_option_square_access_token' );
		$location_id = get_option( 'ec_option_square_location_id' );
		if( !$location_id )
			$location_id = $this->get_location_id( );
		
		$gateway_url = "https://connect.squareup.com/v2/catalog/list?types=item,item_variation,category";
		if( $cursor )
			$gateway_url .= "&cursor=" . $cursor;
		$headr = array();
		$headr[] = 'Accept: application/json';
		$headr[] = 'Content-Type: application/json';
		$headr[] = 'Authorization: Bearer ' . $access_token;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, $gateway_url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, false ); 
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		if( $response === false )
			$this->mysqli->insert_response( 0, 1, "SQUARE Catalog CURL ERROR", curl_error( $ch ) );
		else
			$this->mysqli->insert_response( 0, 0, "Square Catalog Response", print_r( $response, true ) );
		
		curl_close ($ch);
		
		return json_decode( $response );
		
		
	}
	
	function insert_category( $object ){
		if( $this->allowed_at_location( $object ) && !$object->is_deleted ){
			global $wpdb;
		
			$featured_category = 1;
			$category_name = stripslashes_deep( $object->category_data->name );
			$priority = 0;
			$parent_id = 0;
			$image = "";
			$short_description = "";
			$square_id = $object->id;
			
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_category( featured_category, category_name, parent_id, image, short_description, priority, square_id ) VALUES( %d, %s, %d, %s, %s, %d, %s )", $featured_category, $category_name, $parent_id, $image, $short_description, $priority, $square_id ) );
			$category_id = $wpdb->insert_id;
			
			$post = array(	
				'post_content'	=> "[ec_store groupid=\"" . $category_id . "\"]",
				'post_status'	=> "publish",
				'post_title'	=> $GLOBALS['language']->convert_text( $category_name ),
				'post_type'		=> "ec_store"
			);
			$post_id = wp_insert_post( $post );
			$wpdb->query( $wpdb->prepare( "UPDATE ec_category SET post_id = %d WHERE category_id = %d", $post_id, $category_id ) );
			
			return array( 'success' => 'category-inserted' );
		}
	}
	
	function insert_product( $object ){
		if( $this->allowed_at_location( $object ) && !$object->is_deleted ){
			global $wpdb;
			$square_id = $object->id;
			
			$activate_in_store = 1;
			$post_status = ( $activate_in_store ) ? 'publish' : 'private';
			
			$title = $object->item_data->name;
			$description = $object->item_data->description;
			$image1 = $object->item_data->image_url;
			$option_items = array( );
			if( $object->item_data->variations )
				$option_items = $object->item_data->variations;
			$is_giftcard = 0;
			$is_shippable = $is_taxable = 1;
			if( $object->product_type == "GIFT_CARD" ){
				$is_giftcard = 1;
			}
			$model_number = rand( 10000000, 99999999 );
			$price = 0;
			$show_stock_quantity = $use_optionitem_quantity_tracking = 0;
			
			if( $object->product_type == "GIFT_CARD" || $object->product_type == "APPOINTMENTS_SERVICE" ){
				$is_shippable = 0;
			}
			
			$category_stripe_id = $object->item_data->category_id;
			
			// Get a default manufacturer
			$manufacturer_id = $wpdb->get_var( $wpdb->prepare( "SELECT manufacturer_id FROM ec_manufacturer" ) );
			
			// Maybe insert option set
			$option_id = 0;
			if( count( $option_items ) > 1 ){
				$optionitem_added_count = 0;
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_option( option_name, option_label, option_type ) VALUES( %s, %s, 'combo' )", $title . " Variation", $title ) );
				$option_id = $wpdb->insert_id;
				$order = 0;
				foreach( $option_items as $optionitem ){
					if( $this->allowed_at_location( $optionitem ) && !$optionitem->is_deleted ){
						$initially_selected = 0;
						if( $order == 0 ){
							$initially_selected = 1;
							$model_number = $optionitem->item_variation_data->sku;
							$price = $optionitem->item_variation_data->price_money->amount / 100;
						}
						$wpdb->query( $wpdb->prepare( "INSERT INTO ec_optionitem( option_id, optionitem_name, optionitem_price_override, optionitem_order, optionitem_initially_selected, square_id ) VALUES( %d, %s, %s, %d, %d, %s )", $option_id, $optionitem->item_variation_data->name, $optionitem->item_variation_data->price_money->amount / 100, $order, $initially_selected, $optionitem->id ) );
						$optionitem_added_count++;
						$order++;
					}
				}
				
				if( $optionitem_added_count == 0 ){
					$wpdb->query( $wpdb->prepare( "DELETE FROM ec_option WHERE option_id = %d", $option_id ) );
					$option_id = 0;
				}
			}else if( count( $option_items ) == 1 ){
				$model_number = $option_items[0]->item_variation_data->sku;
				$price = $option_items[0]->item_variation_data->price_money->amount / 100;
			}
			
			// Create Post Slug
			$post_slug = preg_replace( '/(\-+)/', '-', preg_replace( "/[^A-Za-z0-9\-]/", '', str_replace( ' ', '-', stripslashes_deep( strtolower( $title ) ) ) ) );
			while( substr( $post_slug, -1 ) == '-' ){
				$post_slug = substr( $post_slug, 0, strlen( $post_slug ) - 1 );
			}
			while( substr( $post_slug, 0, 1 ) == '-' ){
				$post_slug = substr( $post_slug, 1, strlen( $post_slug ) );
			}
			if( $post_slug == '' ){
				$post_slug = rand( 1000000, 9999999 );
			}
			
			// Get URL
			$store_page = get_permalink( get_option( 'ec_option_storepage' ) );
			if( strstr( $store_page, '?' ) )									$guid = $store_page . '&model_number=' . $model_number;
			else if( substr( $store_page, strlen( $store_page ) - 1 ) == '/' )	$guid = $store_page . $post_slug;
			else																$guid = $store_page . '/' . $post_slug;
			
			$guid = strtolower( $guid );
			$post_slug_orig = $post_slug;
			$guid_orig = $guid;
			$guid = $guid . '/';
			
			/* Fix for Duplicate GUIDs */
			$i=1;
			while( $guid_check = $wpdb->get_row( $wpdb->prepare( "SELECT " . $wpdb->prefix . "posts.guid FROM " . $wpdb->prefix . "posts WHERE " . $wpdb->prefix . "posts.guid = %s", $guid ) ) ){
				$guid = $guid_orig . '-' . $i . '/';
				$post_slug = $post_slug_orig . '-' . $i;
				$i++;
			} 
			
			/* Manually Insert Post */
			$wpdb->query( $wpdb->prepare( "INSERT INTO " . $wpdb->prefix . "posts( post_content, post_status, post_title, post_name, guid, post_type, post_excerpt, post_date, post_date_gmt, post_modified, post_modified_gmt ) VALUES( %s, %s, %s, %s, %s, %s, %s, NOW( ), UTC_TIMESTAMP( ), NOW( ), UTC_TIMESTAMP( ) )", "[ec_store modelnumber=\"" . $model_number . "\"]", $post_status, $GLOBALS['language']->convert_text( $title ), $post_slug, $guid, "ec_store", '' ) );
			$post_id = $wpdb->insert_id;
			
			// Insert product
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product( activate_in_store, show_on_startup, post_id, manufacturer_id, title, model_number, description, price, image1, is_giftcard, is_shippable, is_taxable, show_stock_quantity, use_optionitem_quantity_tracking, use_advanced_optionset, square_id ) VALUES( %d, %d, %d, %d, %s, %s, %s, %s, %s, %d, %d, %d, %d, %d, 1, %s )", $activate_in_store, 1, $post_id, $manufacturer_id, $title, $model_number, $description, $price, $image1, $is_giftcard, $is_shippable, $is_taxable, $show_stock_quantity, $use_optionitem_quantity_tracking, $square_id ) );
			$product_id = $wpdb->insert_id;
			
			// Maybe connect option set to product
			if( $option_id ){
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_option_to_product( option_id, product_id ) VALUES( %d, %d )", $option_id, $product_id ) );
			}
			
			// Maybe add product to category
			if( $category_stripe_id ){
				$category_id = $wpdb->get_var( $wpdb->prepare( "SELECT category_id FROM ec_category WHERE square_id = %s", $category_stripe_id ) );
				if( $category_id ){
					$wpdb->query( $wpdb->prepare( "INSERT INTO ec_categoryitem( category_id, product_id ) VALUES( %d, %d )", $category_id, $product_id ) );
				}
			}
		}
	}
	
	function allowed_at_location( $object ){
		$this_location_id = $this->get_location_id( );
		if( isset( $object->absent_at_location_ids ) && in_array( $this_location_id, $object->absent_at_location_ids ) )
			return false;
		
		if( isset( $object->present_at_all_locations ) && $object->present_at_all_locations )
			return true;
			
		if( isset( $object->present_at_location_ids ) && in_array( $this_location_id, $object->present_at_location_ids ) )
			return true;
			
		return false;
	}
	
}

?>