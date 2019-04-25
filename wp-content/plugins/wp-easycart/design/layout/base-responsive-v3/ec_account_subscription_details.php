<h3 class="ec_account_subscription_title"><?php $this->subscription->display_title( ); ?></h3>


<?php if( $this->subscription->has_membership_page( ) ){ ?><div class="ec_account_subscription_row"><?php $this->subscription->display_membership_page_link( $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_5" ) ); ?></div><?php } ?>


<?php if( !$this->subscription->is_canceled( ) ){ ?><div class="ec_account_subscription_row"><b><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_next_billing' ); ?>:</b> <?php $this->subscription->display_next_bill_date( ); ?></div><?php }?>


<div class="ec_account_subscription_row"><b><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_last_payment' ); ?>:</b> <?php $this->subscription->display_last_bill_date( ); ?></div>


<div class="ec_account_subscription_row"><?php $this->subscription->display_price( ); ?></div>


<?php if( !$this->subscription->is_canceled( ) ){ ?>


<div class="ec_account_subscription_row last_spacer"><?php $GLOBALS['ec_user']->display_card_type( ); ?>: ############<?php $GLOBALS['ec_user']->display_last4( ); ?> | <a href="#" onclick="return show_billing_info( );" class="ec_account_subscription_link">change billing method</a></div>

<?php $this->display_subscription_update_form_start( ); ?>

<?php if( $this->subscription->has_upgrades( ) ){ ?>

<div class="ec_account_subscription_upgrade_row"><?php $this->subscription->display_upgrade_dropdown( ); ?></div>

<?php }?>

<div id="ec_account_subscription_billing_information" class="ec_account_subscription_billing">

    <div class="ec_cart_subscription_holder_left">

        <div class="ec_cart_header ec_top">
			<?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_title' )?>
        </div>
        
        <?php if( get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_country"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' )?>*</label>
            <?php $this->display_account_billing_information_country_input( ); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_country_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' ); ?>
            </div>
        </div>
        <?php } ?>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_first_name"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_first_name' )?>*</label>
            <?php $this->display_account_billing_information_first_name_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_first_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_first_name' ); ?>
            </div>
        </div>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_last_name"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_last_name' )?>*</label>
            <?php $this->display_account_billing_information_last_name_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_last_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_last_name' ); ?>
            </div>
        </div>
        
        <?php if( get_option( 'ec_option_enable_company_name' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_company_name"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_company_name' ); ?></label>
            <input type="text" name="ec_account_billing_information_company_name" id="ec_account_billing_information_company_name" class="ec_account_billing_information_input_field" value="<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->company_name, ENT_QUOTES ); ?>">
            <div class="ec_cart_error_row" id="ec_account_billing_information_company_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'cart_billing_information_company_name' ); ?>
            </div>
        </div>
        <?php } ?>
        
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_address"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_address' )?>*</label>
            <?php $this->display_account_billing_information_address_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_address_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_address' ); ?>
            </div>
        </div>
        <?php if( get_option( 'ec_option_use_address2' ) ){ ?>
        <div class="ec_cart_input_row">
        	<?php $this->display_account_billing_information_address2_input(); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_city"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_city' )?>*</label>
            <?php $this->display_account_billing_information_city_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_city_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_city' ); ?>
        	</div>
        </div>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_state"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_state' )?><span id="ec_billing_state_required">*</span></label>
            <?php $this->display_account_billing_information_state_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_state_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_state' ); ?>
            </div>
        </div>
    	
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_zip"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_zip' )?>*</label>
            <?php $this->display_account_billing_information_zip_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_zip_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_zip' ); ?>
            </div>
        </div>
		
        <?php if( !get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_country"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' )?>*</label>
            <?php $this->display_account_billing_information_country_input( ); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_country_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' ); ?>
            </div>
        </div>
        <?php } ?>
        
        <?php if( get_option( 'ec_option_collect_user_phone' ) ){ ?>
		<div class="ec_cart_input_row">
            <label for="ec_account_billing_information_phone"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_phone' )?>*</label>
            <?php $this->display_account_billing_information_phone_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_phone_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_phone' ); ?>
            </div>
        </div>
        <?php }?>

    </div>

    <div class="ec_cart_subscription_holder_right" style="width:100%; float:left; border-top:1px solid #CCC; margin-top:10px; padding-top:10px;">

		<div style="float:none; max-width:500px;">

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
					var form = document.getElementById( 'ec_submit_update_form' );
					form.addEventListener( 'submit', function( event ){
						event.preventDefault( );
						var name = jQuery( document.getElementById( 'ec_account_billing_information_first_name' ) ).val( ) + " " + jQuery( document.getElementById( 'ec_account_billing_information_last_name' ) ).val( );
						var address1 = jQuery( document.getElementById( 'ec_account_billing_information_address' ) ).val( );
						var city = jQuery( document.getElementById( 'ec_account_billing_information_city' ) ).val( );
						var state = jQuery( document.getElementById( 'ec_account_billing_information_state' ) ).val( );
						if( jQuery( document.getElementById( 'ec_account_billing_information_state_' + jQuery( document.getElementById( 'ec_account_billing_information_country' ) ).val( ) ) ).length ){
							state = jQuery( document.getElementById( 'ec_account_billing_information_state_' + jQuery( document.getElementById( 'ec_account_billing_information_country' ) ).val( ) ) ).val( );
						}
						var zip = jQuery( document.getElementById( 'ec_account_billing_information_zip' ) ).val( );
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
								var form = document.getElementById( 'ec_submit_update_form' );
								
								jQuery( document.getElementById( 'stripeToken' ) ).val( token.id );
								
								var card_number_input = document.createElement( 'input' );
								card_number_input.setAttribute( 'type', 'hidden' );
								card_number_input.setAttribute( 'name', 'ec_card_number' );
								card_number_input.setAttribute( 'value', token.card.last4 );
								form.appendChild( card_number_input );
								
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
								form.submit( );
							}
						} );
					} );
				}catch( err ){
					console.log( err.message );
					alert( "Your WP EasyCart with Stripe has a problem: " + err.message + ". Contact WP EasyCart for assistance." );
				}
			</script>
            
        </div>

	</div>

	<div class="ec_account_subscription_details_notice"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_notice' ); ?></div>

    <div class="ec_cart_error_row" id="ec_terms_error">
		<?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_accept_terms' )?> 
    </div>
    
    <?php if( get_option( 'ec_option_require_terms_agreement' ) ){ ?>
    <div class="ec_cart_input_row ec_agreement_section">
        <input type="checkbox" name="ec_terms_agree" id="ec_terms_agree" value="1"  /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_review_agree' )?>
    </div>
    <?php }else{ ?>
        <input type="hidden" name="ec_terms_agree" id="ec_terms_agree" value="2"  />
    <?php }?>

	<?php if( !get_option( 'ec_option_subscription_one_only' ) ){ ?>
	<table class="ec_cartitem_quantity_table ec_account_subscription_table">
        <tbody>
            <tr>
                <td class="ec_minus_column">
                    <input type="button" value="-" class="ec_minus" onclick="ec_minus_quantity( '<?php echo $this->subscription->subscription_id; ?>', 1 );" /></td>
                <td class="ec_quantity_column"><input type="number" value="<?php echo $this->subscription->quantity; ?>" id="ec_quantity_<?php echo $this->subscription->subscription_id; ?>" name="ec_quantity" autocomplete="off" step="1" min="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>" class="ec_quantity" /></td>
                <td class="ec_plus_column"><input type="button" value="+" class="ec_plus" onclick="ec_plus_quantity( '<?php echo $this->subscription->subscription_id; ?>', 0, 1000000 );" /></td>
            </tr>
        </tbody>
    </table>
    <?php }?>

</div>

<div class="ec_account_subscription_button"><input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'save_changes_button' ); ?>" onclick="return ec_check_update_subscription_info( );" /></div>

<?php $this->display_subscription_update_form_end( ); ?>

<?php }?>

<h3><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_past_payments' ); ?></h3>

<div class="ec_account_subscriptions_past_payments"><?php $this->subscription->display_past_payments( ); ?></div>

<?php if( !$this->subscription->is_canceled( ) ){ ?>

<hr />

<div  class="ec_account_subscription_button"><?php $this->subscription->display_cancel_form( $GLOBALS['language']->get_text( 'account_subscriptions', 'cancel_subscription_button' ), $GLOBALS['language']->get_text( 'account_subscriptions', 'cancel_subscription_confirm_text' ) ); ?></div>

<?php } ?>