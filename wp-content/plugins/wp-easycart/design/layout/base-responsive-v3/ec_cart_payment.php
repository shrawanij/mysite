<?php
if( trim( get_option( 'ec_option_fb_pixel' ) ) != '' ){
	echo "<script>
		fbq('track', 'AddPaymentInfo', {value: " . number_format( $this->order_totals->grand_total, 2, '.', '' ) . ", currency: '" . $GLOBALS['currency']->get_currency_code( ) . "', contents: [";
		for( $i=0; $i<count( $this->cart->cart ); $i++ ){
			if( $i > 0 )
				echo ", ";
			echo "{ id: '" . $this->cart->cart[$i]->product_id . "', quantity: " . $this->cart->cart[$i]->quantity . ", price: " . $this->cart->cart[$i]->unit_price . " }";
		}		
		echo "]});
	</script>";
}
?>
<?php if( isset( $_GET['ideal'] ) && isset( $_GET['client_secret'] ) && isset( $_GET['source'] ) && $_GET['ideal'] == 'returning' ){ ?>
<style>
.ec_third_party_loader{ display:block; position:absolute !important; top:50% !important; left:50% !important; z-index:999999; }
.ec_third_party_loader_bg{ display:block; position:absolute !important; top:0 !important; left:0 !important; width:100%; height:100%; background:rgba(255, 255, 255, 0.85); z-index:999998;  }
@-webkit-keyframes ec_third_party_loader {
  0% {
	-webkit-transform: rotate(0deg);
	-moz-transform: rotate(0deg);

	-ms-transform: rotate(0deg);
	-o-transform: rotate(0deg);
	transform: rotate(0deg);
  }

  100% {
	-webkit-transform: rotate(360deg);
	-moz-transform: rotate(360deg);
	-ms-transform: rotate(360deg);
	-o-transform: rotate(360deg);
	transform: rotate(360deg);
  }
}

@-moz-keyframes ec_third_party_loader {
  0% {
	-webkit-transform: rotate(0deg);
	-moz-transform: rotate(0deg);
	-ms-transform: rotate(0deg);
	-o-transform: rotate(0deg);
	transform: rotate(0deg);
  }

  100% {
	-webkit-transform: rotate(360deg);
	-moz-transform: rotate(360deg);
	-ms-transform: rotate(360deg);
	-o-transform: rotate(360deg);
	transform: rotate(360deg);
  }
}

@-o-keyframes ec_third_party_loader {
  0% {
	-webkit-transform: rotate(0deg);
	-moz-transform: rotate(0deg);
	-ms-transform: rotate(0deg);
	-o-transform: rotate(0deg);
	transform: rotate(0deg);
  }

  100% {
	-webkit-transform: rotate(360deg);
	-moz-transform: rotate(360deg);
	-ms-transform: rotate(360deg);
	-o-transform: rotate(360deg);
	transform: rotate(360deg);
  }
}

@keyframes ec_third_party_loader {
  0% {
	-webkit-transform: rotate(0deg);
	-moz-transform: rotate(0deg);
	-ms-transform: rotate(0deg);
	-o-transform: rotate(0deg);
	transform: rotate(0deg);
  }

  100% {
	-webkit-transform: rotate(360deg);
	-moz-transform: rotate(360deg);
	-ms-transform: rotate(360deg);
	-o-transform: rotate(360deg);
	transform: rotate(360deg);
  }
}

/* Styles for old versions of IE */
.ec_third_party_loader {
  font-family: sans-serif;
  font-weight: 100;
}

/* :not(:required) hides this rule from IE9 and below */
.ec_third_party_loader:not(:required) {
  -webkit-animation: ec_third_party_loader 1250ms infinite linear;
  -moz-animation: ec_third_party_loader 1250ms infinite linear;
  -ms-animation: ec_third_party_loader 1250ms infinite linear;
  -o-animation: ec_third_party_loader 1250ms infinite linear;
  animation: ec_third_party_loader 1250ms infinite linear;
  border: 8px solid #3388ee;
  border-right-color: transparent;
  border-radius: 16px;
  box-sizing: border-box;
  display: inline-block;
  position: relative;
  overflow: hidden;
  text-indent: -9999px;
  width: 32px;
  height: 32px;
}
</style>

<div class="ec_third_party_loader" id="ideal_loader">Loading...</div>
<div class="ec_third_party_loader_bg" id="ideal_loader_bg"></div>
<script>
	jQuery( document.getElementById( 'ideal_loader' ) ).appendTo( document.body );
	jQuery( document.getElementById( 'ideal_loader_bg' ) ).appendTo( document.body );
	var ec_ideal_timer = window.setInterval( ec_ideal_waiting_for_response, 5000 );
	
	function ec_ideal_waiting_for_response( ){
		var data = {
			action: 'ec_ajax_check_stripe_ideal_order',
			source: '<?php echo htmlspecialchars( $_GET['source'], ENT_QUOTES ); ?>',
			client_secret: '<?php echo htmlspecialchars( $_GET['client_secret'], ENT_QUOTES ); ?>'
		};
		
		jQuery.ajax({url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
			if( data == 'failed' ){
				clearInterval( ec_ideal_timer );
				jQuery( document.getElementById( 'ideal_loader' ) ).hide( );
				jQuery( document.getElementById( 'ideal_loader_bg' ) ).hide( );
				jQuery( document.getElementById( 'ec_ideal_error' ) ).show( );
				
			}else if( data != '0' ){
				clearInterval( ec_ideal_timer );
				window.location.href = '<?php echo $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" ?>' + data
			
			}
		} } );
	}
</script>
<?php } ?>
<?php $this->display_page_three_form_start( ); ?>
<div class="ec_cart_left">
    
    <?php if( $this->order_totals->grand_total > 0 ){ ?>
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_payment_method' ); ?>
    </div>
    
    <div class="ec_cart_error_row" id="ec_payment_method_error">
        <?php echo $GLOBALS['language']->get_text( 'ec_errors', 'missing_payment_method' )?> 
    </div>
    
    <?php if( $this->use_manual_payment( ) ){?>
    <div class="ec_cart_option_row">
		<input type="radio" class="no_wrap" name="ec_cart_payment_selection" id="ec_payment_manual" value="manual_bill"<?php if( $this->get_selected_payment_method( ) == "manual_bill" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_manual_payment' )?>
    </div>
    
    <div id="ec_manual_payment_form"<?php if( $this->get_selected_payment_method( ) == "manual_bill" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section">
        	<?php $this->display_manual_payment_text( ); ?>
        </div>
    </div>
    <?php } ?>
    
    <?php if( get_option( 'ec_option_use_affirm' ) ){ ?>
    <div class="ec_cart_option_row">
		<input type="radio" class="no_wrap" name="ec_cart_payment_selection" id="ec_payment_affirm" value="affirm"<?php if( $this->get_selected_payment_method( ) == "affirm" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_affirm' ); ?>
    </div>
    
    <div id="ec_affirm_form"<?php if( $this->get_selected_payment_method( ) == "affirm" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section ec_affirm_box">
        	<script>
				function ec_checkout_with_affirm( ){
				// setup and configure checkout
				affirm.checkout({
				
					config: {
						financial_product_key:		"<?php echo get_option( 'ec_option_affirm_financial_product' ); ?>"
					},
					
					merchant: {
						user_confirmation_url:		"<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=process_affirm",
						user_cancel_url:			"<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_payment"
					},
					
					billing: {
						name: {
							first:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->first_name, ENT_QUOTES ); ?>",
							last:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->last_name, ENT_QUOTES ); ?>"
						},
						address: {
							line1:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_1, ENT_QUOTES ); ?>",
							line2:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_2, ENT_QUOTES ); ?>",
							city:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->city, ENT_QUOTES ); ?>",
							state:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->state, ENT_QUOTES ); ?>",
							zipcode:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->zip, ENT_QUOTES ); ?>",
							country:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->country, ENT_QUOTES ); ?>"
						},
						phone_number:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->phone, ENT_QUOTES ); ?>",
						email:						"<?php echo htmlspecialchars( $GLOBALS['ec_user']->email, ENT_QUOTES ); ?>"
					},
					
					shipping: {
						name: {
							first:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->first_name, ENT_QUOTES ); ?>",
							last:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->last_name, ENT_QUOTES ); ?>"
						},
						address: {
							line1:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_1, ENT_QUOTES ); ?>",
							line2:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_2, ENT_QUOTES ); ?>",
							city:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->city, ENT_QUOTES ); ?>",
							state:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->state, ENT_QUOTES ); ?>",
							zipcode:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->zip, ENT_QUOTES ); ?>",
							country:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->country, ENT_QUOTES ); ?>"
						},
						phone_number:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->phone, ENT_QUOTES ); ?>"
					},
					
					items: [<?php for( $i=0; $i<count( $this->cart->cart ); $i++ ){ ?>{
						display_name:         		"<?php echo $this->cart->cart[$i]->title; ?>",
						sku:                  		"<?php echo $this->cart->cart[$i]->model_number; ?>",
						unit_price:           		<?php echo number_format( ( 100 * $this->cart->cart[$i]->unit_price ), 0, '', '' ); ?>,
						qty:                  		<?php echo $this->cart->cart[$i]->quantity; ?>,
						item_image_url:       		"<?php echo $this->cart->cart[$i]->get_image_url( ); ?>",
						item_url:             		"<?php echo $this->cart->cart[$i]->get_product_url( ); ?>"
					},<?php }?>],
					
					tax_amount:						<?php echo number_format( ( 100 * $this->order_totals->tax_total ), 0, '', '' ); ?>,
					shipping_amount:				<?php echo number_format( ( 100 * $this->order_totals->shipping_total ), 0, '', '' ); ?>
				
				});
				
				affirm.checkout.open( ); 
				
				}
			</script>
            
            <a href="https://www.affirm.com" target="_blank"><img src="<?php echo $this->get_payment_image_source( "affirm-banner-540x200.png" ); ?>" alt="Affirm Split Pay" /></a>
        </div>
    </div>
    <?php }?>
    
	<?php if( $this->use_third_party( ) ){?>
    <div class="ec_cart_option_row">
		<input type="radio" class="no_wrap" name="ec_cart_payment_selection" id="ec_payment_third_party" value="third_party"<?php if( $this->get_selected_payment_method( ) == "third_party" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party' )?> <?php $this->ec_cart_display_current_third_party_name( ); ?>
    </div>
    
    
    <div id="ec_third_party_form"<?php if( $this->get_selected_payment_method( ) == "third_party" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section">
        	<?php if( get_option( 'ec_option_payment_third_party' ) != "paypal" || get_option( 'ec_option_paypal_enable_pay_now' ) != '1' ){
				echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party_first' )?> <?php $this->ec_cart_display_current_third_party_name( ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party_second' ) . '<br />';
			}?>
			
			<?php if( get_option( 'ec_option_payment_third_party' ) == "paypal" ){ ?>
            	<img src="<?php echo $this->get_payment_image_source( "paypal.jpg" ); ?>" alt="PayPal" />
            
            <?php }else if( get_option( 'ec_option_payment_third_party' ) == "skrill" ){ ?>
            	<img src="<?php echo $this->get_payment_image_source( "skrill-logo.gif" ); ?>" alt="Skrill" />
            
			<?php }else if( get_option( 'ec_option_realex_thirdparty_type' ) == 'hpp' && get_option( 'ec_option_payment_third_party' ) == "realex_thirdparty" ){  ?>
				<script>
                jQuery( document ).ready( function( ){
                    var data = {
                        action: "ec_ajax_realex_hpp_init",
                        total: "<?php echo $this->order_totals->grand_total; ?>"
                    };
                    jQuery.ajax( { url: wpeasycart_ajax_object.ajax_url, type: "post", data: data, success: function( data ){
                        <?php if( get_option( 'ec_option_realex_thirdparty_test_mode' ) ){ ?>RealexHpp.setHppUrl('https://pay.sandbox.realexpayments.com/pay');
						<?php }?>RealexHpp.init( "ec_cart_submit_order", "<?php echo $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id="; ?>" + data.order_id, data.response );
                    } } );
                } );
                </script>
            
            <?php }?>
            
            <?php do_action( 'wpeasycart_third_party_checkout_box' ); ?>
        
        </div>
    </div>
    <?php }?>
    
    <?php if( $this->use_payment_gateway( ) ){?>
    
    <?php if( get_option( 'ec_option_payment_process_method' ) == "square" ){ ?>
    <script type="text/javascript" src="https://js.squareup.com/v2/paymentform"></script>
	<script>
	
	var applicationId = '<?php if( get_option( 'ec_option_square_application_id' ) != '' ){ echo get_option( 'ec_option_square_application_id' ); }else{ echo 'sq0idp-H8Mnz1zzbv1mOyeWyKpF6Q'; } ?>';
	
	try {
		var paymentForm = new SqPaymentForm({
			applicationId: applicationId,
			inputClass: 'sq-input',
			inputStyles: [{
				fontSize: '15px'
			}],
			cardNumber: {
				elementId: 'sq-card-number',
				placeholder: '•••• •••• •••• ••••'
			},
		cvv: {
		  elementId: 'sq-cvv',
		  placeholder: 'CVV'
		},
		expirationDate: {
		  elementId: 'sq-expiration-date',
		  placeholder: 'MM/YY'
		},<?php if( get_option( 'ec_option_square_location_country' ) != 'AU' ){ ?>
		postalCode: {
		  elementId: 'sq-postal-code'
		},<?php }else{ ?>
		postalCode:false,<?php }?>
		callbacks: {
			cardNonceResponseReceived: function(errors, nonce, cardData) {
				if (errors) {
					console.log("Encountered errors:");
					errors.forEach(function(error) {
						console.log('  ' + error.message);
					});
				}else{
					document.getElementById('card-nonce').value = nonce;
					document.getElementById('ec_submit_order_form').submit();			
				}
			},
			unsupportedBrowserDetected: function() {
				// Fill in this callback to alert buyers when their browser is not supported.
			},
			// Fill in these cases to respond to various events that can occur while a
			// buyer is using the payment form.
			inputEventReceived: function(inputEvent) {
				switch (inputEvent.eventType) {
					case 'focusClassAdded':
						// Handle as desired
						break;
					case 'focusClassRemoved':
						// Handle as desired
						break;
					case 'errorClassAdded':
						// Handle as desired
						break;
					case 'errorClassRemoved':
						// Handle as desired
						break;
					case 'cardBrandChanged':
						// Handle as desired
						break;
					case 'postalCodeChanged':
						// Handle as desired
						break;
				}
			},
	
			paymentFormLoaded: function() {
				paymentForm.setPostalCode('<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->zip, ENT_QUOTES ); ?>');
			}
		}
		});
		
	}catch( err ){
		alert( "Your WP EasyCart with Square payments is not setup correctly. " + err.message );
	}
	
	function requestCardNonce( event ){
		if( jQuery( document.getElementById( 'ec_payment_credit_card' ) ).is( ":checked" ) ){
			
			event.preventDefault( );
			
			if( !ec_validate_terms( ) )
				return false;
			
			if( document.getElementById( 'ec_card_holder_name' ) && jQuery( document.getElementById( 'ec_card_holder_name' ) ).val( ) == '' ){
				ec_show_error( 'ec_card_holder_name' );
				return false;
			}else{
				ec_hide_error( 'ec_card_holder_name' );
			}
			
			paymentForm.requestCardNonce( );
			return false;
			
		}else{
			return true;
		}
	}
	</script>
	
	<!--
	These styles can live in a separate .css file. They're just here to keep this
	example to a single file.
	-->
	<style type="text/css">
	.sq-input {
		border: 1px solid rgb(223, 223, 223);
		outline-offset: -2px;
	  	margin-bottom: 5px;
		border-color: #e1e1e1;
		background-color: #fcfcfc;
		color: #919191;
		padding: 8px 6px;
		outline: none;
		font: 1em "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
		height:35px;
	}
	.sq-input--focus {
	  /* Indicates how form inputs should appear when they have focus */
	  outline: 5px auto rgb(59, 153, 252);
	}
	.sq-input--error {
	  /* Indicates how form inputs should appear when they contain invalid values */
	  outline: 5px auto rgb(255, 97, 97);
	}
	</style>
    <input type="hidden" id="card-nonce" name="nonce">
    <?php }?>
    
    <div class="ec_cart_option_row">
		<input type="radio" class="no_wrap" name="ec_cart_payment_selection" id="ec_payment_credit_card" value="credit_card"<?php if( $this->get_selected_payment_method( ) == "credit_card" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_credit_card' )?>
    </div>
    
    <div id="ec_credit_card_form"<?php if( $this->get_selected_payment_method( ) == "credit_card" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section">
        	<?php if( get_option( 'ec_option_payment_process_method' ) == "square"  && $this->order_totals->grand_total < 1 ){ ?>
            <p style="font-size:18px; color:red">Minimum Order Total of $1.00 is Required!</h1>
			<?php }else if( ( get_option( 'ec_option_payment_process_method' ) == "stripe" || get_option( 'ec_option_payment_process_method' ) == "stripe_connect" ) && $this->order_totals->grand_total < .5 ){ ?>
            <p style="font-size:18px; color:red">Minimum Order Total of $0.50 is Required!</h1>
            <?php }?>
            
			<?php if( ( get_option( 'ec_option_payment_process_method' ) == 'stripe' && get_option( 'ec_option_stripe_public_api_key' ) != "" ) || ( get_option( 'ec_option_payment_process_method' ) == 'stripe_connect' ) ){ ?>
            <input type="hidden" name="stripeToken" id="stripeToken" value="" />
            <div class="form-row" style="margin-top:12px;">
            	<div id="ec_stripe_card_row">
            	  <!-- a Stripe Element will be inserted here. -->
            	</div>
        
            	<!-- Used to display form errors -->
            	<div id="ec_card_errors" role="alert"></div>
          	</div>
            <script><?php
				if( get_option( 'ec_option_payment_process_method' ) == 'stripe' )
					$pkey = get_option( 'ec_option_stripe_public_api_key' );
				else if( get_option( 'ec_option_payment_process_method' ) == 'stripe_connect' && get_option( 'ec_option_stripe_connect_use_sandbox' ) )
					$pkey = get_option( 'ec_option_stripe_connect_sandbox_publishable_key' );
				else
					$pkey = get_option( 'ec_option_stripe_connect_production_publishable_key' );	
				?>
				try {
					var stripe = Stripe( '<?php echo $pkey; ?>' );
					var elements = stripe.elements( );
					var style = {
						base: {
							color: '#32325d',
							lineHeight: '24px',
							fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
							fontSmoothing: 'antialiased',
							fontSize: '16px',
							'::placeholder': {
							  color: '#aab7c4'
							}
						},
						invalid: {
							color: '#fa755a',
							iconColor: '#fa755a'
						}
					};
					var card = elements.create( 'card', {style: style, hidePostalCode: true} );
					card.mount( '#ec_stripe_card_row' );
					card.addEventListener( 'change', function( event ){
						var displayError = document.getElementById( 'ec_card_errors' );
						if( event.error ){
							displayError.textContent = event.error.message;
						}else{
							displayError.textContent = '';
						}
					} );
					var form = document.getElementById( 'ec_submit_order_form' );
					form.addEventListener( 'submit', function( event ){
						var payment_method = "credit_card";
						if( jQuery( 'input:radio[name=ec_cart_payment_selection]:checked' ).length )
							payment_method = jQuery( 'input:radio[name=ec_cart_payment_selection]:checked' ).val( );
						if( payment_method != 'credit_card' ){
							jQuery( document.getElementById( 'ec_submit_order_error' ) ).hide( );
						}else{
							event.preventDefault( );
							var name = '<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->first_name, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->last_name, ENT_QUOTES ); ?>';
							var address1 = '<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_1, ENT_QUOTES ); ?>';
							var city = '<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->city, ENT_QUOTES ); ?>';
							var state = '<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->state, ENT_QUOTES ); ?>';
							var zip = '<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->zip, ENT_QUOTES ); ?>';
							var additionalData = {
								name: name,
								address_line1: address1,
								address_city: city,
								address_state: state,
								address_zip: zip
							};
							stripe.createToken( card, additionalData ).then( function( result ){
								if( result.error ){
									var errorElement = document.getElementById( 'ec_card_errors' );
									errorElement.textContent = result.error.message;
									jQuery( document.getElementById( 'ec_submit_order_error' ) ).show( );
								}else{
									var token = result.token;
									var form = document.getElementById( 'ec_submit_order_form' );
									// Token Input
									jQuery( document.getElementById( 'stripeToken' ) ).val( token.id );
									// Card Number Input
									var card_number_input = document.createElement( 'input' );
									card_number_input.setAttribute( 'type', 'hidden' );
									card_number_input.setAttribute( 'name', 'ec_card_number' );
									card_number_input.setAttribute( 'value', token.card.last4 );
									form.appendChild( card_number_input );
									// Expiration Input
									var expiration_month_input = document.createElement( 'input' );
									expiration_month_input.setAttribute( 'type', 'hidden' );
									expiration_month_input.setAttribute( 'name', 'ec_expiration_month' );
									expiration_month_input.setAttribute( 'value', token.card.exp_month );
									form.appendChild( expiration_month_input );
									var expiration_year_input = document.createElement( 'input' );
									expiration_year_input.setAttribute( 'type', 'hidden' );
									expiration_year_input.setAttribute( 'name', 'ec_expiration_year' );
									expiration_year_input.setAttribute( 'value', token.card.exp_year );
									form.appendChild( expiration_year_input );
									// Submit Form
									jQuery( document.getElementById( 'ec_cart_submit_order' ) ).hide( );
									jQuery( document.getElementById( 'ec_cart_submit_order_working' ) ).show( );
									jQuery( document.getElementById( 'ec_submit_order_error' ) ).hide( );
									form.submit( );
								}
							} );
						}
					} );
				}catch( err ){
					alert( "Your WP EasyCart with Stripe has a problem: " + err.message + ". Contact WP EasyCart for assistance." );
				}
			</script>
            
            <?php }else if( get_option( 'ec_option_payment_process_method' ) == "braintree" ){ // Close if Stripe Only Form ?>
			<?php $braintree_gateway = new ec_braintree( ); ?>
            <div id="wpec_braintree_dropin"></div>
            <input type="hidden" id="braintree_nonce" name="braintree_nonce" value="" />
            <style>
            .braintree-large-button.braintree-toggle{ display:none !important; }
            </style>
            <script>
                var form = document.querySelector( '#ec_submit_order_form' );
                var client_token = "<?php echo $braintree_gateway->get_client_token( ); ?>";
                braintree.dropin.create(
                    {
                        authorization: client_token,
                        selector: '#wpec_braintree_dropin'
                    }, 
                    function( createErr, instance ){
                        if( createErr ){
                            console.log( 'Create Error', createErr );
                            return;
                        }
                        form.addEventListener(
                            'submit', 
                            function( event ){
								var payment_method = "credit_card";
								if( jQuery( 'input:radio[name=ec_cart_payment_selection]:checked' ).length )
									payment_method = jQuery( 'input:radio[name=ec_cart_payment_selection]:checked' ).val( );
								
								if( payment_method != 'credit_card' ){
									jQuery( document.getElementById( 'ec_submit_order_error' ) ).hide( );
								
								}else{
									event.preventDefault( );
									instance.requestPaymentMethod(
										function( err, payload ){
							
											if (err) {
												jQuery( document.getElementById( 'ec_submit_order_error' ) ).show( );
												jQuery( document.getElementById( 'ec_cart_submit_order' ) ).show( );
												jQuery( document.getElementById( 'ec_cart_submit_order_working' ) ).hide( );
												console.log( 'Request Payment Method Error', err );
												return;
											}
											// Add the nonce to the form and submit
											document.querySelector( '#braintree_nonce' ).value = payload.nonce;
											
											// Submit Form
											jQuery( document.getElementById( 'ec_cart_submit_order' ) ).hide( );
											jQuery( document.getElementById( 'ec_cart_submit_order_working' ) ).show( );
											jQuery( document.getElementById( 'ec_submit_order_error' ) ).hide( );
											form.submit();
										}
									);
								}
                            }
                        );
                    }
                );
            </script>
			<?php }else{ // Close if Braintree Only Form ?>
           
            <div class="ec_cart_input_row" style="margin-top:-10px;">
				<?php if( get_option('ec_option_use_visa') || get_option('ec_option_use_delta') || get_option('ec_option_use_uke') ){ ?>
					<img src="<?php echo $this->get_payment_image_source( "visa.png" ); ?>" alt="Visa" class="ec_card_active" id="ec_card_visa" />
                	<img src="<?php echo $this->get_payment_image_source( "visa_inactive.png" ); ?>" alt="Visa" class="ec_card_inactive" id="ec_card_visa_inactive" />
            	<?php }?>
            
                <?php if( get_option('ec_option_use_discover') ){ ?>
                    <img src="<?php echo $this->get_payment_image_source( "discover.png" ); ?>" alt="Discover" class="ec_card_active" id="ec_card_discover" />
                    <img src="<?php echo $this->get_payment_image_source( "discover_inactive.png" ); ?>" alt="Discover" class="ec_card_inactive" id="ec_card_discover_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_mastercard') || get_option('ec_option_use_mcdebit') ){ ?>
                    <img src="<?php echo $this->get_payment_image_source( "mastercard.png"); ?>" alt="Mastercard" class="ec_card_active" id="ec_card_mastercard" />
					<img src="<?php echo $this->get_payment_image_source( "mastercard_inactive.png"); ?>" alt="Mastercard" class="ec_card_inactive" id="ec_card_mastercard_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_amex') ){ ?>
                    <img src="<?php echo $this->get_payment_image_source( "american_express.png"); ?>" alt="AMEX" class="ec_card_active" id="ec_card_amex" />
					<img src="<?php echo $this->get_payment_image_source( "american_express_inactive.png"); ?>" alt="AMEX" class="ec_card_inactive" id="ec_card_amex_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_jcb') ){ ?>
                    <img src="<?php echo $this->get_payment_image_source( "jcb.png"); ?>" alt="JCB" class="ec_card_active" id="ec_card_jcb" />
					<img src="<?php echo $this->get_payment_image_source( "jcb_inactive.png"); ?>" alt="JCB" class="ec_card_inactive" id="ec_card_jcb_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_diners') ){ ?>
                    <img src="<?php echo $this->get_payment_image_source( "diners.png"); ?>" alt="Diners" class="ec_card_active" id="ec_card_diners" />
					<img src="<?php echo $this->get_payment_image_source( "diners_inactive.png"); ?>" alt="Diners" class="ec_card_inactive" id="ec_card_diners_inactive" />
            	<?php }?>
                
            	<?php if( get_option('ec_option_use_maestro') || get_option('ec_option_use_laser')){ ?>
                	<img src="<?php echo $this->get_payment_image_source( "maestro.png"); ?>" alt="Maestro" class="ec_card_active" id="ec_card_maestro" />
					<img src="<?php echo $this->get_payment_image_source( "maestro_inactive.png"); ?>" alt="Maestro" class="ec_card_inactive" id="ec_card_maestro_inactive" />
            	<?php }?>
            </div>
            
			<?php if( get_option( 'ec_option_show_card_holder_name' ) ){ ?>
            <div class="ec_cart_input_row">
                <input name="ec_card_holder_name" id="ec_card_holder_name" type="text" class="input-lg form-control" placeholder="<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_holder_name' )?>">
                <div class="ec_cart_error_row" id="ec_card_holder_name_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_holder_name' )?>
                </div>
            </div>
			<?php }else{ ?>
            <?php $this->ec_cart_display_card_holder_name_hidden_input(); ?>
            <?php } ?>
			<div class="ec_cart_input_row"<?php if( get_option( 'ec_option_payment_process_method' ) == "square" ){ ?> id="sq-card-number"<?php }?>>
				<input name="ec_card_number" id="ec_card_number"<?php if( get_option( 'ec_option_payment_process_method' ) == "eway" && get_option( 'ec_option_eway_use_rapid_pay' ) ){?> data-eway-encrypt-name="ec_card_number"<?php }?> type="tel" class="input-lg form-control cc-number" autocomplete="cc-number" placeholder="<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?>">
                <div class="ec_cart_error_row" id="ec_card_number_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?>
                </div>
            </div>
           	<div class="ec_cart_input_row">
				<div class="ec_cart_input_left_half"<?php if( get_option( 'ec_option_payment_process_method' ) == "square" ){ ?> id="sq-expiration-date"<?php }?>>
                	<input name="ec_cc_expiration" id="ec_cc_expiration" type="tel" class="input-lg form-control cc-exp" autocomplete="cc-exp" placeholder="MM / YYYY">
					<div class="ec_cart_error_row" id="ec_expiration_date_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?>
                    </div>
            	</div>
			    <div class="ec_cart_input_right_half"<?php if( get_option( 'ec_option_payment_process_method' ) == "square" ){ ?> id="sq-cvv"<?php }?>>
                	<input name="ec_security_code" id="ec_security_code"<?php if( get_option( 'ec_option_payment_process_method' ) == "eway" && get_option( 'ec_option_eway_use_rapid_pay' ) ){?> data-eway-encrypt-name="ec_security_code"<?php }?> type="tel" class="input-lg form-control cc-cvc" autocomplete="off" placeholder="CVV">
                	<div class="ec_cart_error_row" id="ec_security_code_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?>
                    </div>
            	</div>
            </div>
            <?php if( get_option( 'ec_option_payment_process_method' ) == "square" && get_option( 'ec_option_square_location_country' ) != 'AU' ){ ?><div style="display:none !important;"><div class="ec_cart_input_row" id="sq-postal-code"></div></div><?php }?>
        	
            <?php } //else from Stripe only check ?>
        
        </div>
    </div>
    
    <?php if( get_option( 'ec_option_stripe_currency' ) == 'EUR' && get_option( 'ec_option_stripe_enable_ideal' ) && ( ( get_option( 'ec_option_payment_process_method' ) == 'stripe' && get_option( 'ec_option_stripe_public_api_key' ) != "" ) || ( get_option( 'ec_option_payment_process_method' ) == 'stripe_connect' ) ) ){ ?>
    <div class="ec_cart_option_row">
		<input type="radio" class="no_wrap" name="ec_cart_payment_selection" id="ec_payment_ideal" value="ideal"<?php if( $this->get_selected_payment_method( ) == "ideal" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party' )?> iDEAL
    </div>
    
    <div id="ec_ideal_form"<?php if( $this->get_selected_payment_method( ) == "ideal" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section">
        	
            <div class="ec_cart_error" id="ec_ideal_error" style="display:none;"><div><?php echo $GLOBALS['language']->get_text( "ec_errors", "ideal_failed" ); ?></div></div>
            
            <div class="ec_cart_input_row">
            	<label for="ec_stripe_ideal_name" style="font-size:14px; font-weight:normal;"><?php echo ucwords( $GLOBALS['language']->get_text( 'ec_newsletter_popup', 'signup_form_name_placeholder' ) ); ?></label>
				<input type="text" id="ec_stripe_ideal_name" name="ec_stripe_ideal_name" placeholder="" class="ec_cart_billing_input_text" style='font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; color:#6b7c93; font-size:16px; padding:10px 12px;'>
            </div>
            <div class="ec_cart_input_row" style="margin-top:12px; border:1px solid #efefef; background:#fcfcfc;">
            	<div id="ideal-bank-element">
                  <!-- a Stripe Element for iDEAL will be inserted here. -->
                </div><!-- Used to display form errors -->
        
            	<!-- Used to display form errors -->
            	<div id="ec_ideal_errors" role="alert"></div>
          	</div>
            <script>
				function showLoading( ){
					jQuery( document.getElementById( 'ec_cart_submit_order' ) ).hide( );
					jQuery( document.getElementById( 'ec_cart_submit_order_working' ) ).show( );
					ec_hide_error( 'ec_submit_order' );
				}
				try {
					var elements = stripe.elements( );
					
					var style = {
					  base: {
						padding: '10px 12px',
						color: '#32325d',
						fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
						fontSmoothing: 'antialiased',
						fontSize: '16px',
						'::placeholder': {
						  color: '#aab7c4'
						},
					  },
					  invalid: {
						color: '#fa755a',
					  }
					};

					
					// Create an instance of the idealBank Element.
					var idealBank = elements.create( 'idealBank', {style: style});
					idealBank.mount( '#ideal-bank-element' );
					
					var errorMessage = document.getElementById('ec_ideal_errors');
					var form = document.getElementById( 'ec_submit_order_form' );
					form.addEventListener( 'submit', function( event ){
						if( jQuery( document.getElementById( 'ec_payment_ideal' ) ).is( ':checked' ) ){
							event.preventDefault( );
							
							if( jQuery( document.getElementById( 'ec_stripe_ideal_name' ) ).val( ).length == 0 ){
								jQuery( document.getElementById( 'ec_stripe_ideal_name' ) ).css( 'border', '1px solid red' );
							}else{
								jQuery( document.getElementById( 'ec_stripe_ideal_name' ) ).css( 'border', '1px solid #e1e1e1' );
								showLoading( );
							
								var sourceData = {
									type: 'ideal',
									amount: <?php echo number_format( $this->order_totals->grand_total * 100, 0, '', '' ); ?>,
									currency: '<?php echo get_option( 'ec_option_stripe_currency' ); ?>',
									owner: {
										name: jQuery( document.getElementById( 'ec_stripe_ideal_name' ) ).val( ),
									},
									redirect: {
										return_url: '<?php echo $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ideal=returning"; ?>',
									},
								};
								stripe.createSource(idealBank, sourceData).then(
									function(result) {
										if (result.error) {
											// Inform the customer that there was an error.
											errorMessage.textContent = result.error.message;
											jQuery( document.getElementById( 'ec_cart_submit_order' ) ).show( );
											jQuery( document.getElementById( 'ec_cart_submit_order_working' ) ).hide( );
											errorMessage.classList.add('visible');
											ec_show_error( 'ec_submit_order' );
											
										} else {
											// Redirect the customer to the authorization URL.
											errorMessage.classList.remove('visible');
											ec_create_ideal_order_redirect( result.source );
										}
									}
								);
							}
						}
					});
				}catch( err ){
					alert( "Your WP EasyCart with Stripe has a problem: " + err.message + ". Contact WP EasyCart for assistance." );
				}
			</script>
        
        </div>
    </div>
    <?php } //close if/else for allow ideal ?>
   
    <?php } //close if/else check for live gateway ?>
    
	<?php } //close if/else check for free order ?>
	
    <div class="ec_cart_header<?php if( $this->order_totals->grand_total <= 0 ){ ?> ec_top<?php }?>">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_review_title' )?>
    </div>
    
    <?php for( $cartitem_index = 0; $cartitem_index<count( $this->cart->cart ); $cartitem_index++ ){ ?>
    
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php $this->cart->cart[$cartitem_index]->display_title( ); ?><?php if( $this->cart->cart[$cartitem_index]->grid_quantity > 1 ){ ?> x <?php echo $this->cart->cart[$cartitem_index]->grid_quantity; ?><?php }else if( $this->cart->cart[$cartitem_index]->quantity > 1 ){ ?> x <?php echo $this->cart->cart[$cartitem_index]->quantity; ?><?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->stock_quantity <= 0 && $this->cart->cart[$cartitem_index]->allow_backorders ){ ?>
        <div class="ec_cart_backorder_date"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_backordered' ); ?><?php if( $this->cart->cart[$cartitem_index]->backorder_fill_date != "" ){ ?> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_backorder_until' ); ?> <?php echo $this->cart->cart[$cartitem_index]->backorder_fill_date; ?><?php }?></div>
        <?php }?>
        <?php if( $this->cart->cart[$cartitem_index]->optionitem1_name ){ ?>
        <dl>
            <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem1_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem1_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem1_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem1_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem1_price ); ?> )<?php } ?></dt>
        
        <?php if( $this->cart->cart[$cartitem_index]->optionitem2_name ){ ?>
            <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem2_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem2_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem2_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem2_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem2_price ); ?> )<?php } ?></dt>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->optionitem3_name ){ ?>
            <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem3_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem3_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem3_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem3_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem3_price ); ?> )<?php } ?></dt>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->optionitem4_name ){ ?>
            <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem4_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem4_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem4_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem4_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem4_price ); ?> )<?php } ?></dt>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->optionitem5_name ){ ?>
            <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem5_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem5_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem5_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem5_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem5_price ); ?> )<?php } ?></dt>
        <?php }?>
        </dl>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->use_advanced_optionset ){ ?>
        <dl>
        <?php foreach( $this->cart->cart[$cartitem_index]->advanced_options as $advanced_option_set ){ ?>
            <?php if( $advanced_option_set->option_type == "grid" ){ ?>
            <dt><?php echo $advanced_option_set->optionitem_name; ?>: <?php echo $advanced_option_set->optionitem_value; ?><?php if( $advanced_option_set->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_override ) . ')'; } ?></dt>
            <?php }else if( $advanced_option_set->option_type == "dimensions1" || $advanced_option_set->option_type == "dimensions2" ){ ?>
            <strong><?php echo $advanced_option_set->option_label; ?>:</strong><br /><?php $dimensions = json_decode( $advanced_option_set->optionitem_value ); if( count( $dimensions ) == 2 ){ echo $dimensions[0]; if( !get_option( 'ec_option_enable_metric_unit_display' ) ){ echo "\""; } echo " x " . $dimensions[1]; if( !get_option( 'ec_option_enable_metric_unit_display' ) ){ echo "\""; } }else if( count( $dimensions ) == 4 ){ echo $dimensions[0] . " " . $dimensions[1] . "\" x " . $dimensions[2] . " " . $dimensions[3] . "\""; } ?><br />
            
            <?php }else{ ?>
            <dt><?php echo $advanced_option_set->option_label; ?>: <?php echo htmlspecialchars( $advanced_option_set->optionitem_value, ENT_QUOTES ); ?><?php if( $advanced_option_set->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_override ) . ')'; } ?></dt>
            <?php } ?>
        <?php }?>
        </dl>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->is_giftcard ){ ?>
        <dl>
        <dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_recipient_name' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_to_name, ENT_QUOTES ); ?></dt>
        <dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_recipient_email' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_email, ENT_QUOTES ); ?></dt>
        <dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_sender_name' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_from_name, ENT_QUOTES ); ?></dt>
        <dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_message' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_message, ENT_QUOTES ); ?></dt>
        </dl>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->is_deconetwork ){ ?>
        <dl>
        <dt><?php echo $this->cart->cart[$cartitem_index]->deconetwork_options; ?></dt>
        <dt><?php echo "<a href=\"https://" . get_option( 'ec_option_deconetwork_url' ) . $this->cart->cart[$cartitem_index]->deconetwork_edit_link . "\">" . $GLOBALS['language']->get_text( 'cart', 'deconetwork_edit' ) . "</a>"; ?></dt>
        </dl>
        <?php }?>
        
        </div>
        <div class="ec_cart_price_row_total" id="ec_cart_subtotal"><?php echo $this->cart->cart[$cartitem_index]->get_total( ); ?></div>
    </div>
    
    <?php }?>
    
    <div class="ec_cart_price_row ec_order_total">
        <div class="ec_cart_price_row_label"></div>
        <div class="ec_cart_price_row_total"><a href="<?php echo $this->cart_page; ?>"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_cart_link' ); ?></a></div>
    </div>
    
    <?php if( get_option( 'ec_option_user_order_notes' ) && $GLOBALS['ec_cart_data']->cart_data->order_notes != "" && strlen( $GLOBALS['ec_cart_data']->cart_data->order_notes ) > 0 ){ ?>
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ); ?>
    </div>
    <div class="ec_cart_input_row">
    	<?php echo nl2br( htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->order_notes, ENT_QUOTES ) ); ?>
    </div>
    <?php }?>
    
    <div id="ec_cart_payment_one_column">
    	<div class="ec_cart_header ec_top">
            <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_title' ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->first_name, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->last_name, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->billing->company_name ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->company_name, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_1, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->billing->address_line_2 ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_2, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->city, ENT_QUOTES ); ?>, <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->state, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->zip, ENT_QUOTES ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->country_name, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->billing->phone ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->phone, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <?php if( strlen( $GLOBALS['ec_user']->vat_registration_number ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <strong><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_vat_registration_number' ); ?>:</strong> <?php echo htmlspecialchars( $GLOBALS['ec_user']->vat_registration_number, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_billing_link' ); ?></a>
        </div>
        
        <?php if( get_option( 'ec_option_use_shipping' ) && ( $this->cart->shippable_total_items > 0 || $this->order_totals->handling_total > 0 ) ){ ?>
        
        <div class="ec_cart_header ec_top">
            <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_title' ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->first_name, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->last_name, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->shipping->company_name ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->company_name, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_1, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->shipping->address_line_2 ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_2, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->city, ENT_QUOTES ); ?>, <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->state, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->zip, ENT_QUOTES ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->country_name, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->shipping->phone ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->phone, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_shipping_link' ); ?></a>
        </div>
        
        <div class="ec_cart_header">
            <?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_method_title' ); ?> 
        </div>
        <div class="ec_cart_input_row">
            <strong><?php $this->ec_cart_display_shipping_methods( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ),$GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" ); ?></strong>
        </div>
        
        <?php }?>
    </div>
    
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_review_totals_title' ); ?>
    </div>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_subtotal' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_subtotal"><?php echo $this->get_subtotal( ); ?></div>
    </div>
    <?php if( $this->order_totals->tax_total > 0 ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_tax' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_tax"><?php echo $this->get_tax_total( ); ?></div>
    </div>
    <?php }?>
    <?php if( get_option( 'ec_option_use_shipping' ) && ( $this->cart->shippable_total_items > 0 || $this->order_totals->handling_total > 0 ) ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_shipping' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_shipping"><?php echo $this->get_shipping_total( ); ?></div>
    </div>
    <?php }?>
    <div class="ec_cart_price_row<?php if( $this->order_totals->discount_total == 0 ){ ?> ec_no_discount<?php }else{ ?> ec_has_discount<?php }?>">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_discounts' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_discount"><?php echo $this->get_discount_total( ); ?></div>
    </div>
    <?php if( $this->tax->is_duty_enabled( ) ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_duty' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_duty"><?php echo $this->get_duty_total( ); ?></div>
    </div>
    <?php }?>
    <?php if( $this->tax->is_vat_enabled( ) ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_vat' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_vat"><?php echo $this->get_vat_total_formatted( ); ?></div>
    </div>
    <?php }?>
	<?php if( get_option( 'ec_option_enable_easy_canada_tax' ) && $this->order_totals->gst_total > 0 ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label">GST (<?php echo $this->tax->gst_rate; ?>%)</div>
        <div class="ec_cart_price_row_total" id="ec_cart_tax"><?php echo $this->get_gst_total( ); ?></div>
    </div>
    <?php }?>
    <?php if( get_option( 'ec_option_enable_easy_canada_tax' ) && $this->order_totals->pst_total > 0 ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label">PST (<?php echo $this->tax->pst_rate; ?>%)</div>
        <div class="ec_cart_price_row_total" id="ec_cart_tax"><?php echo $this->get_pst_total( ); ?></div>
    </div>
    <?php }?>
    <?php if( get_option( 'ec_option_enable_easy_canada_tax' ) && $this->order_totals->hst_total > 0 ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label">HST (<?php echo $this->tax->hst_rate; ?>%)</div>
        <div class="ec_cart_price_row_total" id="ec_cart_tax"><?php echo $this->get_hst_total( ); ?></div>
    </div>
    <?php }?>
    <div class="ec_cart_price_row ec_order_total">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_grand_total' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_total"><?php echo $this->get_grand_total( ); ?></div>
    </div>
		
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' )?>
    </div>
    
    <div class="ec_cart_error_row" id="ec_terms_error">
        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_accept_terms' )?> 
    </div>
    <div class="ec_cart_input_row" id="ec_terms_row"<?php if( get_option( 'ec_option_payment_third_party' ) == "paypal" && $this->get_selected_payment_method( ) == "third_party" && get_option( 'ec_option_paypal_enable_pay_now' ) == '1' && $this->order_totals->grand_total > 0 ){ ?> style="display:none;"<?php }?>>
		<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_checkout_text' )?>
    </div>
    
	<?php if( get_option( 'ec_option_require_terms_agreement' ) ){ ?>
    <div class="ec_cart_input_row ec_agreement_section" id="ec_terms_agreement_row"<?php if( get_option( 'ec_option_payment_third_party' ) == "paypal" && $this->get_selected_payment_method( ) == "third_party" && get_option( 'ec_option_paypal_enable_pay_now' ) == '1' && $this->order_totals->grand_total > 0 ){ ?> style="display:none;"<?php }?>>
        <input type="checkbox" name="ec_terms_agree" id="ec_terms_agree" value="1"  /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_review_agree' )?>
    </div>
    <?php }else{ ?>
    	<input type="hidden" name="ec_terms_agree" id="ec_terms_agree" value="2"  />
    <?php }?>
    
    <?php if( get_option( 'ec_option_show_subscriber_feature' ) && ( !$GLOBALS['ec_user']->user_id || !$GLOBALS['ec_user']->is_subscriber ) ){ ?>
    <div class="ec_cart_input_row ec_agreement_section"<?php if( get_option( 'ec_option_require_terms_agreement' ) ){ ?> style="margin-top:-10px;"<?php }?>>
        <input type="checkbox" name="ec_cart_is_subscriber" id="ec_cart_is_subscriber" class="ec_account_register_input_field" />
        <?php echo $GLOBALS['language']->get_text( 'account_register', 'account_register_subscribe' )?>
    </div>
    <?php }?>
    
    <div class="ec_cart_error_row" id="ec_submit_order_error">
        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_correct_errors' )?> 
    </div>
    
    <?php if( get_option( 'ec_option_payment_third_party' ) == "paypal" && get_option( 'ec_option_paypal_enable_pay_now' ) == '1' && $this->order_totals->grand_total > 0 ){ ?>
        <div style="float:left; width:100%; margin:10px 0 0;<?php if( $this->get_selected_payment_method( ) != "third_party" ){ ?> display:none;<?php }?>" id="wpeasycart_submit_paypal_order_row">
        	<div id="paypal-button-container" style="width:100%; max-width:350px; margin:0;"></div>
        </div>
        <div id="paypal-success-cover" style="display:none; cursor:default; position:fixed; top:0; left:0; width:100%; height:100%; z-index:999999; background-color: rgba(0, 0, 0, 0.8); color:#FFF;">
            <style>
            @keyframes rotation{
                0%  { transform:rotate(0deg); }
                100%{ transform:rotate(359deg); }
            }
            </style>
            <div style='font-family: "HelveticaNeue", "HelveticaNeue-Light", "Helvetica Neue Light", helvetica, arial, sans-serif; font-size: 14px; text-align: center; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; width: 350px; top: 50%; left: 50%; position: absolute; margin-left: -165px; margin-top: -80px; cursor: pointer; text-align: center;'>
                <div class="paypal-checkout-logo">
                    <img class="paypal-checkout-logo-pp" alt="pp" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAyNCAzMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJ4TWluWU1pbiBtZWV0Ij4KICAgIDxwYXRoIGZpbGw9IiNmZmZmZmYiIG9wYWNpdHk9IjAuNyIgZD0iTSAyMC43MDIgOS40NDYgQyAyMC45ODIgNy4zNDcgMjAuNzAyIDUuOTQ3IDE5LjU3OCA0LjU0OCBDIDE4LjM2MSAzLjE0OCAxNi4yMDggMi41NDggMTMuNDkzIDIuNTQ4IEwgNS41MzYgMi41NDggQyA0Ljk3NCAyLjU0OCA0LjUwNiAyLjk0OCA0LjQxMiAzLjU0OCBMIDEuMTM2IDI1Ljc0IEMgMS4wNDIgMjYuMjM5IDEuMzIzIDI2LjYzOSAxLjc5MSAyNi42MzkgTCA2Ljc1MyAyNi42MzkgTCA2LjM3OCAyOC45MzggQyA2LjI4NSAyOS4yMzggNi42NTkgMjkuNjM4IDYuOTQgMjkuNjM4IEwgMTEuMTUzIDI5LjYzOCBDIDExLjYyMSAyOS42MzggMTEuOTk1IDI5LjIzOCAxMi4wODkgMjguNzM5IEwgMTIuMTgyIDI4LjUzOSBMIDEyLjkzMSAyMy4zNDEgTCAxMy4wMjUgMjMuMDQxIEMgMTMuMTE5IDIyLjQ0MSAxMy40OTMgMjIuMTQxIDEzLjk2MSAyMi4xNDEgTCAxNC42MTYgMjIuMTQxIEMgMTguNjQyIDIyLjE0MSAyMS43MzEgMjAuMzQyIDIyLjY2OCAxNS40NDMgQyAyMy4wNDIgMTMuMzQ0IDIyLjg1NSAxMS41NDUgMjEuODI1IDEwLjM0NSBDIDIxLjQ1MSAxMC4wNDYgMjEuMDc2IDkuNjQ2IDIwLjcwMiA5LjQ0NiBMIDIwLjcwMiA5LjQ0NiI+PC9wYXRoPgogICAgPHBhdGggZmlsbD0iI2ZmZmZmZiIgb3BhY2l0eT0iMC43IiBkPSJNIDIwLjcwMiA5LjQ0NiBDIDIwLjk4MiA3LjM0NyAyMC43MDIgNS45NDcgMTkuNTc4IDQuNTQ4IEMgMTguMzYxIDMuMTQ4IDE2LjIwOCAyLjU0OCAxMy40OTMgMi41NDggTCA1LjUzNiAyLjU0OCBDIDQuOTc0IDIuNTQ4IDQuNTA2IDIuOTQ4IDQuNDEyIDMuNTQ4IEwgMS4xMzYgMjUuNzQgQyAxLjA0MiAyNi4yMzkgMS4zMjMgMjYuNjM5IDEuNzkxIDI2LjYzOSBMIDYuNzUzIDI2LjYzOSBMIDcuOTcgMTguMzQyIEwgNy44NzYgMTguNjQyIEMgOC4wNjMgMTguMDQzIDguNDM4IDE3LjY0MyA5LjA5MyAxNy42NDMgTCAxMS40MzMgMTcuNjQzIEMgMTYuMDIxIDE3LjY0MyAxOS41NzggMTUuNjQzIDIwLjYwOCA5Ljk0NiBDIDIwLjYwOCA5Ljc0NiAyMC42MDggOS41NDYgMjAuNzAyIDkuNDQ2Ij48L3BhdGg+CiAgICA8cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNIDkuMjggOS40NDYgQyA5LjI4IDkuMTQ2IDkuNDY4IDguODQ2IDkuODQyIDguNjQ2IEMgOS45MzYgOC42NDYgMTAuMTIzIDguNTQ2IDEwLjIxNiA4LjU0NiBMIDE2LjQ4OSA4LjU0NiBDIDE3LjIzOCA4LjU0NiAxNy44OTMgOC42NDYgMTguNTQ4IDguNzQ2IEMgMTguNzM2IDguNzQ2IDE4LjgyOSA4Ljc0NiAxOS4xMSA4Ljg0NiBDIDE5LjIwNCA4Ljk0NiAxOS4zOTEgOC45NDYgMTkuNTc4IDkuMDQ2IEMgMTkuNjcyIDkuMDQ2IDE5LjY3MiA5LjA0NiAxOS44NTkgOS4xNDYgQyAyMC4xNCA5LjI0NiAyMC40MjEgOS4zNDYgMjAuNzAyIDkuNDQ2IEMgMjAuOTgyIDcuMzQ3IDIwLjcwMiA1Ljk0NyAxOS41NzggNC42NDggQyAxOC4zNjEgMy4yNDggMTYuMjA4IDIuNTQ4IDEzLjQ5MyAyLjU0OCBMIDUuNTM2IDIuNTQ4IEMgNC45NzQgMi41NDggNC41MDYgMy4wNDggNC40MTIgMy41NDggTCAxLjEzNiAyNS43NCBDIDEuMDQyIDI2LjIzOSAxLjMyMyAyNi42MzkgMS43OTEgMjYuNjM5IEwgNi43NTMgMjYuNjM5IEwgNy45NyAxOC4zNDIgTCA5LjI4IDkuNDQ2IFoiPjwvcGF0aD4KICAgIDxnIHRyYW5zZm9ybT0ibWF0cml4KDAuNDk3NzM3LCAwLCAwLCAwLjUyNjEyLCAxLjEwMTQ0LCAwLjYzODY1NCkiIG9wYWNpdHk9IjAuMiI+CiAgICAgICAgPHBhdGggZmlsbD0iIzIzMWYyMCIgZD0iTTM5LjMgMTYuN2MwLjkgMC41IDEuNyAxLjEgMi4zIDEuOCAxIDEuMSAxLjYgMi41IDEuOSA0LjEgMC4zLTMuMi0wLjItNS44LTEuOS03LjgtMC42LTAuNy0xLjMtMS4yLTIuMS0xLjdDMzkuNSAxNC4yIDM5LjUgMTUuNCAzOS4zIDE2Ljd6Ij48L3BhdGg+CiAgICAgICAgPHBhdGggZmlsbD0iIzIzMWYyMCIgZD0iTTAuNCA0NS4yTDYuNyA1LjZDNi44IDQuNSA3LjggMy43IDguOSAzLjdoMTZjNS41IDAgOS44IDEuMiAxMi4yIDMuOSAxLjIgMS40IDEuOSAzIDIuMiA0LjggMC40LTMuNi0wLjItNi4xLTIuMi04LjRDMzQuNyAxLjIgMzAuNCAwIDI0LjkgMEg4LjljLTEuMSAwLTIuMSAwLjgtMi4zIDEuOUwwIDQ0LjFDMCA0NC41IDAuMSA0NC45IDAuNCA0NS4yeiI+PC9wYXRoPgogICAgICAgIDxwYXRoIGZpbGw9IiMyMzFmMjAiIGQ9Ik0xMC43IDQ5LjRsLTAuMSAwLjZjLTAuMSAwLjQgMC4xIDAuOCAwLjQgMS4xbDAuMy0xLjdIMTAuN3oiPjwvcGF0aD4KICAgIDwvZz4KPC9zdmc+Cg=="><img class="paypal-checkout-logo-paypal" alt="paypal" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjMyIiB2aWV3Qm94PSIwIDAgMTAwIDMyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaW5ZTWluIG1lZXQiPgogICAgPHBhdGggZmlsbD0iI2ZmZmZmZiIgZD0iTSAxMiA1LjMxNSBMIDQuMiA1LjMxNSBDIDMuNyA1LjMxNSAzLjIgNS43MTUgMy4xIDYuMjE1IEwgMCAyNi4yMTUgQyAtMC4xIDI2LjYxNSAwLjIgMjYuOTE1IDAuNiAyNi45MTUgTCA0LjMgMjYuOTE1IEMgNC44IDI2LjkxNSA1LjMgMjYuNTE1IDUuNCAyNi4wMTUgTCA2LjIgMjAuNjE1IEMgNi4zIDIwLjExNSA2LjcgMTkuNzE1IDcuMyAxOS43MTUgTCA5LjggMTkuNzE1IEMgMTQuOSAxOS43MTUgMTcuOSAxNy4yMTUgMTguNyAxMi4zMTUgQyAxOSAxMC4yMTUgMTguNyA4LjUxNSAxNy43IDcuMzE1IEMgMTYuNiA2LjAxNSAxNC42IDUuMzE1IDEyIDUuMzE1IFogTSAxMi45IDEyLjYxNSBDIDEyLjUgMTUuNDE1IDEwLjMgMTUuNDE1IDguMyAxNS40MTUgTCA3LjEgMTUuNDE1IEwgNy45IDEwLjIxNSBDIDcuOSA5LjkxNSA4LjIgOS43MTUgOC41IDkuNzE1IEwgOSA5LjcxNSBDIDEwLjQgOS43MTUgMTEuNyA5LjcxNSAxMi40IDEwLjUxNSBDIDEyLjkgMTAuOTE1IDEzLjEgMTEuNjE1IDEyLjkgMTIuNjE1IFoiPjwvcGF0aD4KICAgIDxwYXRoIGZpbGw9IiNmZmZmZmYiIGQ9Ik0gMzUuMiAxMi41MTUgTCAzMS41IDEyLjUxNSBDIDMxLjIgMTIuNTE1IDMwLjkgMTIuNzE1IDMwLjkgMTMuMDE1IEwgMzAuNyAxNC4wMTUgTCAzMC40IDEzLjYxNSBDIDI5LjYgMTIuNDE1IDI3LjggMTIuMDE1IDI2IDEyLjAxNSBDIDIxLjkgMTIuMDE1IDE4LjQgMTUuMTE1IDE3LjcgMTkuNTE1IEMgMTcuMyAyMS43MTUgMTcuOCAyMy44MTUgMTkuMSAyNS4yMTUgQyAyMC4yIDI2LjUxNSAyMS45IDI3LjExNSAyMy44IDI3LjExNSBDIDI3LjEgMjcuMTE1IDI5IDI1LjAxNSAyOSAyNS4wMTUgTCAyOC44IDI2LjAxNSBDIDI4LjcgMjYuNDE1IDI5IDI2LjgxNSAyOS40IDI2LjgxNSBMIDMyLjggMjYuODE1IEMgMzMuMyAyNi44MTUgMzMuOCAyNi40MTUgMzMuOSAyNS45MTUgTCAzNS45IDEzLjExNSBDIDM2IDEyLjkxNSAzNS42IDEyLjUxNSAzNS4yIDEyLjUxNSBaIE0gMzAuMSAxOS44MTUgQyAyOS43IDIxLjkxNSAyOC4xIDIzLjQxNSAyNS45IDIzLjQxNSBDIDI0LjggMjMuNDE1IDI0IDIzLjExNSAyMy40IDIyLjQxNSBDIDIyLjggMjEuNzE1IDIyLjYgMjAuODE1IDIyLjggMTkuODE1IEMgMjMuMSAxNy43MTUgMjQuOSAxNi4yMTUgMjcgMTYuMjE1IEMgMjguMSAxNi4yMTUgMjguOSAxNi42MTUgMjkuNSAxNy4yMTUgQyAzMCAxNy44MTUgMzAuMiAxOC43MTUgMzAuMSAxOS44MTUgWiI+PC9wYXRoPgogICAgPHBhdGggZmlsbD0iI2ZmZmZmZiIgZD0iTSA1NS4xIDEyLjUxNSBMIDUxLjQgMTIuNTE1IEMgNTEgMTIuNTE1IDUwLjcgMTIuNzE1IDUwLjUgMTMuMDE1IEwgNDUuMyAyMC42MTUgTCA0My4xIDEzLjMxNSBDIDQzIDEyLjgxNSA0Mi41IDEyLjUxNSA0Mi4xIDEyLjUxNSBMIDM4LjQgMTIuNTE1IEMgMzggMTIuNTE1IDM3LjYgMTIuOTE1IDM3LjggMTMuNDE1IEwgNDEuOSAyNS41MTUgTCAzOCAzMC45MTUgQyAzNy43IDMxLjMxNSAzOCAzMS45MTUgMzguNSAzMS45MTUgTCA0Mi4yIDMxLjkxNSBDIDQyLjYgMzEuOTE1IDQyLjkgMzEuNzE1IDQzLjEgMzEuNDE1IEwgNTUuNiAxMy40MTUgQyA1NS45IDEzLjExNSA1NS42IDEyLjUxNSA1NS4xIDEyLjUxNSBaIj48L3BhdGg+CiAgICA8cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNIDY3LjUgNS4zMTUgTCA1OS43IDUuMzE1IEMgNTkuMiA1LjMxNSA1OC43IDUuNzE1IDU4LjYgNi4yMTUgTCA1NS41IDI2LjExNSBDIDU1LjQgMjYuNTE1IDU1LjcgMjYuODE1IDU2LjEgMjYuODE1IEwgNjAuMSAyNi44MTUgQyA2MC41IDI2LjgxNSA2MC44IDI2LjUxNSA2MC44IDI2LjIxNSBMIDYxLjcgMjAuNTE1IEMgNjEuOCAyMC4wMTUgNjIuMiAxOS42MTUgNjIuOCAxOS42MTUgTCA2NS4zIDE5LjYxNSBDIDcwLjQgMTkuNjE1IDczLjQgMTcuMTE1IDc0LjIgMTIuMjE1IEMgNzQuNSAxMC4xMTUgNzQuMiA4LjQxNSA3My4yIDcuMjE1IEMgNzIgNi4wMTUgNzAuMSA1LjMxNSA2Ny41IDUuMzE1IFogTSA2OC40IDEyLjYxNSBDIDY4IDE1LjQxNSA2NS44IDE1LjQxNSA2My44IDE1LjQxNSBMIDYyLjYgMTUuNDE1IEwgNjMuNCAxMC4yMTUgQyA2My40IDkuOTE1IDYzLjcgOS43MTUgNjQgOS43MTUgTCA2NC41IDkuNzE1IEMgNjUuOSA5LjcxNSA2Ny4yIDkuNzE1IDY3LjkgMTAuNTE1IEMgNjguNCAxMC45MTUgNjguNSAxMS42MTUgNjguNCAxMi42MTUgWiI+PC9wYXRoPgogICAgPHBhdGggZmlsbD0iI2ZmZmZmZiIgZD0iTSA5MC43IDEyLjUxNSBMIDg3IDEyLjUxNSBDIDg2LjcgMTIuNTE1IDg2LjQgMTIuNzE1IDg2LjQgMTMuMDE1IEwgODYuMiAxNC4wMTUgTCA4NS45IDEzLjYxNSBDIDg1LjEgMTIuNDE1IDgzLjMgMTIuMDE1IDgxLjUgMTIuMDE1IEMgNzcuNCAxMi4wMTUgNzMuOSAxNS4xMTUgNzMuMiAxOS41MTUgQyA3Mi44IDIxLjcxNSA3My4zIDIzLjgxNSA3NC42IDI1LjIxNSBDIDc1LjcgMjYuNTE1IDc3LjQgMjcuMTE1IDc5LjMgMjcuMTE1IEMgODIuNiAyNy4xMTUgODQuNSAyNS4wMTUgODQuNSAyNS4wMTUgTCA4NC4zIDI2LjAxNSBDIDg0LjIgMjYuNDE1IDg0LjUgMjYuODE1IDg0LjkgMjYuODE1IEwgODguMyAyNi44MTUgQyA4OC44IDI2LjgxNSA4OS4zIDI2LjQxNSA4OS40IDI1LjkxNSBMIDkxLjQgMTMuMTE1IEMgOTEuNCAxMi45MTUgOTEuMSAxMi41MTUgOTAuNyAxMi41MTUgWiBNIDg1LjUgMTkuODE1IEMgODUuMSAyMS45MTUgODMuNSAyMy40MTUgODEuMyAyMy40MTUgQyA4MC4yIDIzLjQxNSA3OS40IDIzLjExNSA3OC44IDIyLjQxNSBDIDc4LjIgMjEuNzE1IDc4IDIwLjgxNSA3OC4yIDE5LjgxNSBDIDc4LjUgMTcuNzE1IDgwLjMgMTYuMjE1IDgyLjQgMTYuMjE1IEMgODMuNSAxNi4yMTUgODQuMyAxNi42MTUgODQuOSAxNy4yMTUgQyA4NS41IDE3LjgxNSA4NS43IDE4LjcxNSA4NS41IDE5LjgxNSBaIj48L3BhdGg+CiAgICA8cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNIDk1LjEgNS45MTUgTCA5MS45IDI2LjIxNSBDIDkxLjggMjYuNjE1IDkyLjEgMjYuOTE1IDkyLjUgMjYuOTE1IEwgOTUuNyAyNi45MTUgQyA5Ni4yIDI2LjkxNSA5Ni43IDI2LjUxNSA5Ni44IDI2LjAxNSBMIDEwMCA2LjExNSBDIDEwMC4xIDUuNzE1IDk5LjggNS40MTUgOTkuNCA1LjQxNSBMIDk1LjggNS40MTUgQyA5NS40IDUuMzE1IDk1LjIgNS41MTUgOTUuMSA1LjkxNSBaIj48L3BhdGg+Cjwvc3ZnPgo=">
                </div>
                <div class="paypal-checkout-loader">
                    <div style="height: 30px; width: 30px; display: inline-block; box-sizing: content-box; opacity: 1; filter: alpha(opacity=100); -webkit-animation: rotation .7s infinite linear; -moz-animation: rotation .7s infinite linear; -o-animation: rotation .7s infinite linear; animation: rotation .7s infinite linear; border-left: 8px solid rgba(0, 0, 0, .2); border-right: 8px solid rgba(0, 0, 0, .2); border-bottom: 8px solid rgba(0, 0, 0, .2); border-top: 8px solid #fff; border-radius: 100%;"></div>
                </div>
            </div>
        </div>
        <script src="https://www.paypalobjects.com/api/checkout.js"></script>
        <?php echo ( apply_filters( 'wp_easycart_allow_paypal_express', false ) ) ? $this->get_paypal_express_button_code( true ) : $this->get_paypal_express_button_code_order( true ); ?>
    <?php }?>
    
    <div class="ec_cart_button_row" id="wpeasycart_submit_order_row"<?php if( get_option( 'ec_option_payment_third_party' ) == "paypal" && $this->get_selected_payment_method( ) == "third_party" && get_option( 'ec_option_paypal_enable_pay_now' ) == '1' && $this->order_totals->grand_total > 0 ){ ?> style="display:none;"<?php }?>>
        <input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' )?>" class="ec_cart_button" id="ec_cart_submit_order" onclick="<?php if( get_option( 'ec_option_payment_process_method' ) == "square" ){ ?>return requestCardNonce(event);<?php }else{ ?>return ec_validate_submit_order( );<?php }?>" />
        <input type="submit" value="<?php echo strtoupper( $GLOBALS['language']->get_text( 'cart', 'cart_please_wait' ) ); ?>" class="ec_cart_button_working" id="ec_cart_submit_order_working" onclick="return false;" />
    </div>
</div>

<?php $this->display_page_three_form_end( ); ?>

<div class="ec_cart_right" id="ec_cart_payment_hide_column">
    
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_title' ); ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->first_name, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->last_name, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->billing->company_name ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->company_name, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_1, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->billing->address_line_2 ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_2, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->city, ENT_QUOTES ); ?>, <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->state, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->zip, ENT_QUOTES ); ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->country_name, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->billing->phone ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->phone, ENT_QUOTES ); ?>
    </div>
    <?php }?>
        
	<?php if( strlen( $GLOBALS['ec_user']->vat_registration_number ) > 0 ){ ?>
    <div class="ec_cart_input_row">
        <strong><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_vat_registration_number' ); ?>:</strong> <?php echo htmlspecialchars( $GLOBALS['ec_user']->vat_registration_number, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_billing_link' ); ?></a>
    </div>
    
    <?php if( get_option( 'ec_option_use_shipping' ) && ( $this->cart->shippable_total_items > 0 || $this->order_totals->handling_total > 0 ) ){ ?>
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_title' ); ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->first_name, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->last_name, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->shipping->company_name ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->company_name, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_1, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->shipping->address_line_2 ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_2, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->city, ENT_QUOTES ); ?>, <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->state, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->zip, ENT_QUOTES ); ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->country_name, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->shipping->phone ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->phone, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <?php $this->display_page_two_form_start( ); ?>
    <div class="ec_cart_input_row">
    	<a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_shipping_link' ); ?></a>
    </div>
    <?php }?>
    
    <?php if( get_option( 'ec_option_use_shipping' ) && ( $this->cart->shippable_total_items > 0 || $this->order_totals->handling_total > 0 ) ){ ?>
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_method_title' ); ?>
    </div>
    <div class="ec_cart_input_row">
        <strong><?php $this->ec_cart_display_shipping_methods( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ),$GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" ); ?></strong>
    </div>
    
    <div class="ec_cart_button_row">
        <input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_update_shipping' ); ?>" class="ec_cart_button" />
    </div>
    <?php $this->display_page_two_form_end( ); ?>
    <?php } // Close if for shipping ?>
    
</div>