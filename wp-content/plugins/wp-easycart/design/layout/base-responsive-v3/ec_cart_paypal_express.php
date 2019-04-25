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
<div class="ec_cart_left">
    
	<?php $this->display_page_three_form_start( ); ?>
    <?php if( isset( $_GET['OID'] ) ){ ?>
    <input type="hidden" name="paypal_order_id" value="<?php echo preg_replace( "/[^A-Za-z0-9\-]/", '', $_GET['OID'] ); ?>" />
    <?php }else{ ?>
    <input type="hidden" name="paypal_payment_id" value="<?php echo preg_replace( "/[^A-Za-z0-9\-]/", '', $_GET['PID'] ); ?>" />
    <?php }?>
    <input type="hidden" name="paypal_payer_id" value="<?php echo preg_replace( "/[^A-Za-z0-9\-]/", '', $_GET['PYID'] ); ?>" />
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_payment_method' ); ?>
    </div>
    <div class="wp-easycart-paypal-express-logo-box" style="float:left; width:100%; background:#FFF; padding:10px 20px; border:1px solid #e1e1e1; text-align:center;"><img src="<?php echo $this->get_payment_image_source( "paypal.jpg" ); ?>" alt="PayPal" /></div>
    <div class="wp-easycart-paypal-express-back-link" style="float:left; width:100%; text-align:right;"><a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_payment"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_change_payment_method' ); ?></a></div>
    <div class="ec_cart_header">
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
        
        <?php if( !isset( $_GET['OID'] ) && apply_filters( 'wp_easycart_allow_paypal_express', false ) && get_option( 'ec_option_use_shipping' ) && ( $this->cart->shippable_total_items > 0 || $this->order_totals->handling_total > 0 ) ){ ?>
    	<div class="ec_cart_header">
            <?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_method_title' ); ?> 
        </div>
        <div class="ec_cart_input_row">
            <strong><?php $this->ec_cart_display_shipping_methods( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ),$GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" ); ?></strong>
        </div>
        <?php }?>
        
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
    
    <?php if( get_option( 'ec_option_user_order_notes' ) ){ ?>
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ); ?>
    </div>
    <div class="ec_cart_input_row">
    	<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_message' ); ?>
        <textarea name="ec_order_notes" id="ec_order_notes"><?php if( $GLOBALS['ec_cart_data']->cart_data->order_notes != "" ){ echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->order_notes, ENT_QUOTES ); } ?></textarea>
    </div>
    <?php }?>
		
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' )?>
    </div>
    
    <div class="ec_cart_error_row" id="ec_terms_error">
        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_accept_terms' )?> 
    </div>
    <div class="ec_cart_input_row">
		<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_checkout_text' )?>
    </div>
	<?php if( get_option( 'ec_option_require_terms_agreement' ) ){ ?>
    <div class="ec_cart_input_row ec_agreement_section">
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
    
    <div class="ec_cart_button_row">
        <input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' )?>" class="ec_cart_button" id="ec_cart_submit_order" onclick="return ec_validate_paypal_express_submit_order( );" />
        <input type="submit" value="<?php echo strtoupper( $GLOBALS['language']->get_text( 'cart', 'cart_please_wait' ) ); ?>" class="ec_cart_button_working" id="ec_cart_submit_order_working" onclick="return false;" />
    </div>
	<?php $this->display_page_three_form_end( ); ?>
</div>

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
    <?php }?>
    
    <?php if( !isset( $_GET['OID'] ) && apply_filters( 'wp_easycart_allow_paypal_express', false ) && get_option( 'ec_option_use_shipping' ) && ( $this->cart->shippable_total_items > 0 || $this->order_totals->handling_total > 0 ) ){ ?>
    <?php $this->display_page_two_form_start( ); ?>
    <input type="hidden" name="paypal_payment_id" value="<?php echo preg_replace( "/[^A-Za-z0-9\-]/", '', $_GET['PID'] ); ?>" />
    <input type="hidden" name="paypal_payer_id" value="<?php echo preg_replace( "/[^A-Za-z0-9\-]/", '', $_GET['PYID'] ); ?>" />
    <input type="hidden" name="paypal_payment_method" value="<?php echo preg_replace( "/[^A-Za-z0-9\_]/", '', $_GET['PMETH'] ); ?>" />
    
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