<?php 
global $wpdb; 
$prev_order_id = $wpdb->get_var( $wpdb->prepare( "SELECT order_id FROM ec_order WHERE order_id = (SELECT MIN(order_id) FROM ec_order WHERE order_id > %d)", $this->order->order_id ) );
$next_order_id = $wpdb->get_var( $wpdb->prepare( "SELECT order_id FROM ec_order WHERE order_id = (SELECT MAX(order_id) FROM ec_order WHERE order_id < %d)", $this->order->order_id ) );
?>
<input type="hidden" name="ec_admin_form_action" value="<?php echo $this->form_action; ?>" />
<input type="hidden" name="order_id" id="order_id"value="<?php echo $this->order->order_id; ?>" />
<input type="hidden" name="payment_method" value="<?php echo $this->order->payment_method; ?>" />
<input type="hidden" name="user_id" value="<?php echo $this->order->user_id; ?>" />
<input type="hidden" name="user_level" value="<?php echo $this->order->user_level; ?>" />
<input type="hidden" name="last_updated" value="<?php echo $this->order->last_updated; ?>" />
<input type="hidden" name="paypal_email_id" value="<?php echo $this->order->paypal_email_id; ?>" />
<input type="hidden" name="paypal_transaction_id" value="<?php echo $this->order->paypal_transaction_id; ?>" />
<input type="hidden" name="paypal_payer_id" value="<?php echo $this->order->paypal_payer_id; ?>" />
<input type="hidden" name="order_viewed" value="<?php echo $this->order->order_viewed; ?>" />
<input type="hidden" name="txn_id" value="<?php echo $this->order->txn_id; ?>" />
<input type="hidden" name="edit_sequence" value="<?php echo $this->order->edit_sequence; ?>" />
<input type="hidden" name="fraktjakt_order_id" value="<?php echo $this->order->fraktjakt_order_id; ?>" />
<input type="hidden" name="fraktjakt_shipment_id" value="<?php echo $this->order->fraktjakt_shipment_id; ?>" />
<input type="hidden" name="stripe_charge_id" value="<?php echo $this->order->stripe_charge_id; ?>" />
<input type="hidden" name="subscription_id" value="<?php echo $this->order->subscription_id; ?>" />
<input type="hidden" name="order_gateway" id="order_gateway"value="<?php echo $this->order->order_gateway; ?>" />
<input type="hidden" name="affirm_charge_id" value="<?php echo $this->order->affirm_charge_id; ?>" />
<input type="hidden" name="guest_key" value="<?php echo $this->order->guest_key; ?>" />
<input type="hidden" name="gateway_transaction_id" value="<?php echo $this->order->gateway_transaction_id; ?>" />
<input type="hidden" name="credit_memo_txn_id" value="<?php echo $this->order->credit_memo_txn_id; ?>" />
<input type="hidden" name="shipping_service_code" value="<?php echo $this->order->shipping_service_code; ?>" />
<input type="hidden" name="quickbooks_status" value="<?php echo $this->order->quickbooks_status; ?>" />		
<div class="ec_admin_settings_panel ec_admin_details_panel">
	<div class="ec_admin_details_footer" style="margin-bottom:10px;">
        <div class="ec_page_title_button_wrap">
        	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
        	<?php echo wp_easycart_admin( )->helpsystem->print_vids_url('orders', 'order-management', 'details');?>
            <?php if( $next_order_id ){ ?>
            <a class="ec_page_title_button" href="admin.php?page=wp-easycart-orders&subpage=orders&order_id=<?php echo $next_order_id; ?>&ec_admin_form_action=edit"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
            <?php }else{ ?>
            <button class="ec_page_title_button_disabled"><div class="dashicons-before dashicons-arrow-down-alt2"></div></button>
            <?php }?>
            <?php if( $prev_order_id ){ ?>
            <a class="ec_page_title_button" href="admin.php?page=wp-easycart-orders&subpage=orders&order_id=<?php echo $prev_order_id; ?>&ec_admin_form_action=edit"><div class="dashicons-before dashicons-arrow-up-alt2"></div></a>
            <?php }else{ ?>
            <button class="ec_page_title_button_disabled"><div class="dashicons-before dashicons-arrow-up-alt2"></div></button>
            <?php }?>
            <a href="<?php echo $this->action; ?>" class="ec_page_title_button">Back to Orders</a>
        </div>
    </div>
    <div class="ec_admin_important_numbered_list">
    	<div class="ec_admin_flex_row">
        	<div class="ec_admin_list_line_item ec_admin_col_9 ec_admin_col_first">
            	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_order_management" ); ?>
          		<div class="ec_admin_settings_label">
					<span class="ec_admin_order_details_order_id">Order #<?php echo $this->order->order_id;?></span>
                    <?php $edit_order_date_action = apply_filters( 'wp_easycart_admin_order_details_order_date_edit_action', 'show_pro_required' ); ?>
                    <span class="ec_admin_order_details_order_date" id="ec_admin_order_details_order_date_row"><span id="ec_admin_order_details_order_date"><?php echo date( 'F d, Y', strtotime( $this->order->order_date ) ); ?></span><div class="dashicons-before dashicons-edit ec_admin_order_details_totals_edit" id="ec_admin_order_date_edit" style="top:8px; right:-35px;" onclick="<?php echo $edit_order_date_action; ?>( ); return false;"></div></span>
                    <?php do_action( 'wp_easycart_order_details_order_date' ); ?>
                    <?php
                        $order_status_list = $wpdb->get_results( "SELECT ec_orderstatus.* FROM ec_orderstatus ORDER BY status_id" );
                        $order_viewed = $wpdb->query( $wpdb->prepare( "UPDATE ec_order SET ec_order.order_viewed = 1 WHERE ec_order.order_id = %s ", $this->order->order_id ));
                    ?>
                    <a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
            		<select id="orderstatus_id" name="orderstatus_id" style="width:200px; min-width:200px; max-width:200px;" onchange="return ec_admin_edit_order_status(this);">
                    <?php foreach( $order_status_list as $order_status ){
                        echo '<option value="'.$order_status->status_id.'"';
                        if( $this->order->orderstatus_id == $order_status->status_id )
                            echo ' selected';
                        echo '>'.$order_status->order_status.'</option>';
                    }?>
                    </select>
                	<a class="ec_admin_order_edit_button" href="admin.php?page=wp-easycart-orders&subpage=orders&order_id=<?php echo $this->order->order_id;?>&ec_admin_form_action=resend-email" style="margin-top:10px;">Resend Receipt</a> 
                </div>
                <div class="ec_admin_order_items_header">
                    <?php do_action( 'wp_easycart_admin_order_details_button_row_pre', $this->order->order_id ); ?>
					<?php $add_new_line_action = apply_filters( 'wp_easycart_admin_order_details_add_new_line_action', 'show_pro_required' ); ?>
                    <?php $refund_action = apply_filters( 'wp_easycart_admin_order_details_refund_action', 'show_pro_required' ); ?>
                    <button class="ec_admin_order_edit_button" style="float:left;" onclick="<?php echo $add_new_line_action; ?>( ); return false;">Add Line</button> 
                    <?php if( $this->order->grand_total > $this->order->refund_total && ( $this->order->order_gateway == "affirm" || $this->order->order_gateway == "stripe" || $this->order->order_gateway == "stripe_connect" || $this->order->order_gateway == "authorize" || $this->order->order_gateway == "beanstream" || $this->order->order_gateway == "braintree" || $this->order->order_gateway == "nmi" || $this->order->order_gateway == "intuit" || $this->order->order_gateway == "square" || $this->order->order_gateway == "paypal-express" ) ){ ?>
                    <button class="ec_admin_order_edit_button" style="float:left;" onclick="<?php echo $refund_action; ?>( ); return false;" id="ec_admin_refund_button">Refund Order</button> 
                    <?php }?>
                    <a class="ec_admin_order_edit_button" href="admin.php?page=wp-easycart-orders&subpage=orders&bulk=<?php echo $this->order->order_id;?>&ec_admin_form_action=print-packing-slip" target="_blank">Print Packaging Slip</a> 
                    <a class="ec_admin_order_edit_button" href="admin.php?page=wp-easycart-orders&subpage=orders&bulk=<?php echo $this->order->order_id;?>&ec_admin_form_action=print-receipt" target="_blank">Print Receipt</a>
                    <input type="submit" value="Send Order Shipped Email" onclick="return ec_admin_send_order_shipped_email( )" class="ec_admin_order_edit_button">
                	<?php do_action( 'wp_easycart_admin_order_details_button_row_post', $this->order->order_id ); ?>
                	<?php do_action( 'wp_easycart_order_details_refund_panel' ); ?>
                	<div class="ec_admin_refund_error" id="ec_admin_refund_failed"><div>There was an error completing the refund.</div></div>
                </div>
            	<div class="ec_admin_settings_input ec_admin_settings_input_order_row ec_admin_settings_currency_section" id="ec_admin_order_line_items">
				<?php
                	$order_details = $wpdb->get_results( $wpdb->prepare( "SELECT ec_orderdetail.*, ec_order.subscription_id FROM ec_orderdetail LEFT JOIN ec_order ON (ec_order.order_id = ec_orderdetail.order_id) WHERE ec_orderdetail.order_id = %s ORDER BY orderdetail_id", $this->order->order_id ));
                	foreach( $order_details as $line_item ){
                    	include(  WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/orders/orders/order-item.php' );
                	}
					do_action( 'wp_easycart_admin_order_details_items_end' );
				?>
                </div>
                <div class="ec_admin_settings_input ec_admin_settings_input_order_row ec_admin_settings_currency_section">
					<div class="ec_admin_order_details_notes_box">
                    	<?php do_action( 'wp_easycart_admin_orders_details_shipment' ); ?>
                        <textarea name="order_notes" id="order_notes" placeholder="Enter Private Order Notes"><?php echo $this->order->order_notes; ?></textarea>
                    	<a class="ec_admin_order_edit_button" onclick="ec_admin_process_order_info( ); return false;">Save Changes</a>
                    </div>
                    <div class="ec_admin_order_details_totals_box">
                        <?php $edit_totals_action = apply_filters( 'wp_easycart_admin_order_details_totals_edit_action', 'show_pro_required' ); ?>
						<div id="ec_admin_order_details_totals_content">
                        	<div class="ec_admin_order_details_row ec_admin_order_details_currency_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label">Sub Total:</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total"><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><span id="ec_admin_order_details_totals_sub_total"><?php echo number_format( $this->order->sub_total, 2 );?></span><?php if( !$GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?></div>
                            </div>
                            <div class="ec_admin_order_details_row ec_admin_order_details_currency_row<?php if( $this->order->vat_total == 0 ){ ?> ec_admin_initial_hide<?php } ?>" id="ec_admin_order_details_totals_vat_total_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label">VAT Total (<span id="ec_admin_order_details_totals_vat_total_rate"><?php echo $this->order->vat_rate;?></span>%):</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total"><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><span id="ec_admin_order_details_totals_vat_total"><?php echo number_format( $this->order->vat_total, 2 ); ?></span><?php if( !$GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?></div>
                            </div>
                            <div class="ec_admin_order_details_row ec_admin_order_details_currency_row<?php if( $this->order->vat_registration_number == '' ){ ?> ec_admin_initial_hide<?php } ?>" id="ec_admin_order_details_totals_vat_registration_number_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label">VAT Registration #:</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total" id="ec_admin_order_details_totals_vat_registration_number"><?php echo $this->order->vat_registration_number;?></div>
                            </div>
                            <div class="ec_admin_order_details_row ec_admin_order_details_currency_row<?php if( $this->order->gst_total == 0 ){ ?> ec_admin_initial_hide<?php } ?>" id="ec_admin_order_details_totals_gst_total_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label">GST Total (<span id="ec_admin_order_details_totals_gst_total_rate"><?php echo $this->order->gst_rate;?></span>%):</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total"><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><span id="ec_admin_order_details_totals_gst_total"><?php echo number_format( $this->order->gst_total, 2 );?></span><?php if( !$GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?></div>
                            </div>
                            <div class="ec_admin_order_details_row ec_admin_order_details_currency_row<?php if( $this->order->hst_total == 0 ){ ?> ec_admin_initial_hide<?php } ?>" id="ec_admin_order_details_totals_hst_total_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label">HST Total (<span id="ec_admin_order_details_totals_hst_total_rate"><?php echo $this->order->hst_rate;?></span>%):</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total"><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><span id="ec_admin_order_details_totals_hst_total"><?php echo number_format( $this->order->hst_total, 2 );?></span><?php if( !$GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?></div>
                            </div>
                            <div class="ec_admin_order_details_row ec_admin_order_details_currency_row<?php if( $this->order->pst_total == 0 ){ ?> ec_admin_initial_hide<?php } ?>" id="ec_admin_order_details_totals_pst_total_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label">PST Total (<span id="ec_admin_order_details_totals_pst_total_rate"><?php echo $this->order->pst_rate;?></span>%):</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total"><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><span id="ec_admin_order_details_totals_pst_total"><?php echo number_format( $this->order->pst_total, 2 );?></span><?php if( !$GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?></div>
                            </div>
                            <div class="ec_admin_order_details_row ec_admin_order_details_currency_row<?php if( $this->order->duty_total == 0 ){ ?> ec_admin_initial_hide<?php } ?>" id="ec_admin_order_details_totals_duty_total_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label">Duty Total:</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total"><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><span id="ec_admin_order_details_totals_duty_total"><?php echo number_format( $this->order->duty_total, 2 );?></span><?php if( !$GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?></div>
                            </div>
                            <div class="ec_admin_order_details_row ec_admin_order_details_currency_row<?php if( $this->order->tax_total == 0 ){ ?> ec_admin_initial_hide<?php } ?>" id="ec_admin_order_details_totals_tax_total_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label">Tax Total:</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total"><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><span id="ec_admin_order_details_totals_tax_total"><?php echo number_format( $this->order->tax_total, 2 );?></span><?php if( !$GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?></div>
                            </div>
                            <div class="ec_admin_order_details_row ec_admin_order_details_currency_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label">Shipping Total:</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total"><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><span id="ec_admin_order_details_totals_shipping_total"><?php echo number_format( $this->order->shipping_total, 2 );?></span><?php if( !$GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?></div>
                            </div>
                            <div class="ec_admin_order_details_row ec_admin_order_details_currency_row<?php if( $this->order->discount_total == 0 ){ ?> ec_admin_initial_hide<?php } ?>" id="ec_admin_order_details_totals_discount_total_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label">Discount Total:</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total">-<?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><span id="ec_admin_order_details_totals_discount_total"><?php echo number_format( $this->order->discount_total, 2 );?></span><?php if( !$GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?></div>
                            </div>
                            <div class="ec_admin_order_details_row ec_admin_order_details_currency_row<?php if( $this->order->refund_total == 0 ){ ?> ec_admin_initial_hide<?php } ?>" id="ec_admin_order_details_totals_refund_total_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label ec_admin_order_details_currency_refund_label">Refund Total:</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total ec_admin_order_details_currency_refund_total"><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><span id="ec_admin_order_details_totals_refund_total"><?php echo number_format( $this->order->refund_total, 2 );?></span><?php if( !$GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?></div>
                            </div>
                       		<div class="dashicons-before dashicons-edit ec_admin_order_details_totals_edit" id="ec_admin_order_total_edit" onclick="<?php echo $edit_totals_action; ?>( ); return false;"></div>
                            <div class="ec_admin_order_details_row ec_admin_order_details_currency_row">
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_label ec_admin_order_details_currency_grand_total_label">Grand Total:</div>
                                <div class="ec_admin_order_details_column_12 ec_admin_order_details_currency_total ec_admin_order_details_currency_grand_total"><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><span id="ec_admin_order_details_totals_grand_total"><?php echo number_format( $this->order->grand_total, 2 );?></span><?php if( !$GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?></div>
                            </div>
                        </div>
                        <?php do_action( 'wp_easycart_admin_order_details_totals_content_end' ); ?>
                    </div>
                </div>
            </div>
            <div class="ec_admin_list_line_item ec_admin_col_3">
            	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_shipping_details" ); ?>
          		<div class="ec_admin_settings_label_center">
            		<div class="dashicons-before dashicons-admin-users"></div>
                </div>
            	<div class="ec_admin_settings_input ec_admin_settings_input_order_row ec_admin_settings_currency_section">
                	
                    <?php $edit_shipping_action = apply_filters( 'wp_easycart_admin_order_details_shipping_edit_action', 'show_pro_required' ); ?>
                    <div id="ec_admin_order_details_shipping_content" class="ec_admin_order_details_row ec_admin_customer_info_top ec_admin_customer_info_details">
                        <div class="ec_admin_row_heading_title ec_admin_order_details_special_title">Shipping Address</div>
                        <div class="dashicons-before dashicons-edit ec_admin_order_details_totals_edit" id="ec_admin_order_shipping_edit_button" onclick="<?php echo $edit_shipping_action; ?>( ); return false;"></div>
                        <div id="ec_admin_order_details_shipping_name"><?php echo $this->order->shipping_first_name; ?> <?php echo $this->order->shipping_last_name; ?></div>
                        <div id="ec_admin_order_details_shipping_company"><?php if( $this->order->shipping_company_name != '' ){ ?><?php echo $this->order->shipping_company_name; ?><?php }?></div>
                        <div id="ec_admin_order_details_shipping_address1"><?php echo $this->order->shipping_address_line_1; ?></div>
                        <div id="ec_admin_order_details_shipping_address2"><?php if( $this->order->shipping_address_line_2 != '' ){ ?><?php echo $this->order->shipping_address_line_2; ?><?php }?></div>
                        <div id="ec_admin_order_details_shipping_address3"><?php echo $this->order->shipping_city; ?> <?php echo $this->order->shipping_state; ?> <?php echo $this->order->shipping_zip; ?></div>
                        <div id="ec_admin_order_details_shipping_country"><?php echo $this->order->shipping_country_name; ?></div>
                        <div id="ec_admin_order_details_shipping_phone"><?php echo $this->order->shipping_phone; ?></div>
                    </div>
                    <?php do_action( 'wp_easycart_admin_order_details_shipping_content_end' ); ?>
                	
                    <div class="ec_admin_order_details_row ec_admin_customer_info_top ec_admin_customer_info_details" id="ec_admin_view_shipping_method">
                		<div class="dashicons-before dashicons-edit ec_admin_order_details_totals_edit" id="ec_admin_order_details_shipping_method_edit" onclick="ec_admin_process_shipping_method( ); return false;"></div>
                        <div class="ec_admin_row_heading_title ec_admin_order_details_special_title">Shipping Info</div>
                        <span id="ec_admin_order_details_shipping_type"><?php if( $this->order->use_expedited_shipping ){ echo 'Expedite Shipping<br />'; }?></span>
                    	<span id="ec_admin_order_details_shipping_carrier"><?php if( $this->order->shipping_carrier != '' ){ echo $this->order->shipping_carrier . '<br />'; }?></span>
                        <span id="ec_admin_order_details_shipping_method"><?php if( $this->order->shipping_method != '' ){ echo $this->order->shipping_method . '<br />'; } ?></span>
                        <span id="ec_admin_order_details_tracking_number"><?php if( $this->order->tracking_number != '' ){ echo $this->order->tracking_number; }?></span>
                        <div id="ec_admin_order_details_shipping_empty_message"<?php if( $this->order->tracking_number != '' ){ ?> class="ec_admin_initial_hide"<?php }?>><a href="#" onclick="ec_admin_process_shipping_method( ); return false;">Edit Shipping/Tracking Info</a></div>
                    </div>
                    <div id="ec_admin_order_details_shipping_method_form" class="ec_admin_order_details_row ec_admin_customer_info_top ec_admin_initial_hide">
                        <div class="dashicons-before dashicons-yes ec_admin_order_details_totals_edit" id="ec_admin_order_details_shipping_method_save"></div>
                        <div class="ec_admin_order_details_row">
                            <div class="ec_admin_order_details_column_1 ec_admin_order_details_input_padding">
                                <select id="use_expedited_shipping" name="use_expedited_shipping">
                                    <option value="0"<?php if( wp_easycart_admin_orders( )->order_details->order->use_expedited_shipping == '0' ){ ?> selected="selected"<?php }?>>Standard Shipping</option>
                                    <option value="1"<?php if( wp_easycart_admin_orders( )->order_details->order->use_expedited_shipping == '1' ){ ?> selected="selected"<?php }?>>Expedite Shipping</option>
                                </select>
                            </div>
                        </div>
                        <div class="ec_admin_order_details_row">
                            <div class="ec_admin_order_details_column_1 ec_admin_order_details_input_padding">
                                <input type="text" placeholder="Shipping Method" id="shipping_method" name="shipping_method" value="<?php echo wp_easycart_admin_orders( )->order_details->order->shipping_method; ?>" />
                            </div>
                        </div>
                        <div class="ec_admin_order_details_row">
                            <div class="ec_admin_order_details_column_1 ec_admin_order_details_input_padding">
                                <input type="text" placeholder="Shipping Carrier" id="shipping_carrier" name="shipping_carrier" value="<?php echo wp_easycart_admin_orders( )->order_details->order->shipping_carrier; ?>" />
                            </div>
                        </div>
                        <div class="ec_admin_order_details_row">
                            <div class="ec_admin_order_details_column_1 ec_admin_order_details_input_padding">
                                <input type="text" placeholder="Tracking Number" id="tracking_number" name="tracking_number" value="<?php echo wp_easycart_admin_orders( )->order_details->order->tracking_number; ?>" />
                            </div>
                        </div>
                    </div>
                    
					<?php $edit_billing_action = apply_filters( 'wp_easycart_admin_order_details_billing_edit_action', 'show_pro_required' ); ?>
                    <div id="ec_admin_order_details_billing_content" class="ec_admin_order_details_row ec_admin_customer_info_top ec_admin_customer_info_details">
                    	<div class="ec_admin_row_heading_title ec_admin_order_details_special_title">Billing Address</div>
                    	<div class="dashicons-before dashicons-edit ec_admin_order_details_totals_edit" id="ec_admin_order_billing_edit_button" onclick="<?php echo $edit_billing_action; ?>( ); return false;"></div>
                        <div id="ec_admin_order_details_billing_name"><?php echo $this->order->billing_first_name; ?> <?php echo $this->order->billing_last_name; ?></div>
                        <div id="ec_admin_order_details_billing_company"><?php if( $this->order->billing_company_name != '' ){ ?><?php echo $this->order->billing_company_name; ?><?php }?></div>
                        <div id="ec_admin_order_details_billing_address1"><?php echo $this->order->billing_address_line_1; ?></div>
                        <div id="ec_admin_order_details_billing_address2"><?php if( $this->order->billing_address_line_2 != '' ){ ?><?php echo $this->order->billing_address_line_2; ?><?php }?></div>
                        <div id="ec_admin_order_details_billing_address3"><?php echo $this->order->billing_city; ?> <?php echo $this->order->billing_state; ?> <?php echo $this->order->billing_zip; ?></div>
                        <div id="ec_admin_order_details_billing_country"><?php echo $this->order->billing_country_name; ?></div>
                        <div id="ec_admin_order_details_billing_phone"><?php echo $this->order->billing_phone; ?></div>
                    </div>
                    <?php do_action( 'wp_easycart_admin_order_details_billing_content_end' ); ?>
                    
                    <div class="ec_admin_order_details_row ec_admin_customer_info_top ec_admin_customer_info_details" id="ec_admin_view_order_information">
						<?php $edit_order_details_action = apply_filters( 'wp_easycart_admin_order_details_order_edit_action', 'show_pro_required' ); ?>
                        <div class="dashicons-before dashicons-edit ec_admin_order_details_totals_edit" id="ec_admin_order_details_edit" onclick="<?php echo $edit_order_details_action; ?>( ); return false;"></div>
                        <div class="ec_admin_row_heading_title ec_admin_order_details_special_title">Billing Info</div>
                        <span id="ec_admin_order_details_card_holder_name"><?php if( $this->order->card_holder_name != "" ){ ?><?php echo $this->order->card_holder_name; ?><?php }else{ ?><?php echo $this->order->shipping_first_name; ?> <?php echo $this->order->shipping_last_name; ?><?php }?></span><br />
                        <span id="ec_admin_order_details_user_email"><a href="mailto: <?php echo $this->order->user_email; ?>"><?php echo $this->order->user_email; ?></a></span><br />
                        <span id="ec_admin_order_details_creditcard_digits"><?php if( $this->order->creditcard_digits != "" ){ ?>**** **** **** <?php echo $this->order->creditcard_digits;?><br /><?php }?></span>
                        <span id="ec_admin_order_details_cc_exp"><?php if( $this->order->cc_exp_month != "" ){ ?><?php echo $this->order->cc_exp_month;?> / <?php echo $this->order->cc_exp_year;?><br /><?php }?></span>
                    </div>
                    <?php do_action( 'wp_easycart_order_details_order_information' ); ?>
                    
                    <div id="ec_admin_order_details_customer_notes_content" class="ec_admin_order_details_row ec_admin_customer_info_top ec_admin_customer_info_details">
                    	<div class="dashicons-before dashicons-edit ec_admin_order_details_totals_edit" id="ec_admin_order_details_customer_notes_edit" onclick="ec_admin_process_customer_notes( ); return false;"></div>
                        <div class="ec_admin_row_heading_title ec_admin_order_details_special_title">Customer Notes</div>
                    	<span id="ec_admin_order_details_customer_notes"><?php echo $this->order->order_customer_notes; ?></span>
                    	<div id="ec_admin_order_details_customer_notes_empty_message"<?php if( $this->order->order_customer_notes != '' ){ ?> class="ec_admin_initial_hide"<?php }?>><a href="#" onclick="ec_admin_process_customer_notes( ); return false;">Edit Customer Notes</a></div>
                    </div>
                    
                    <div id="ec_admin_order_details_customer_notes_form" class="ec_admin_order_details_row ec_admin_customer_info_top ec_admin_customer_info_details ec_admin_initial_hide">
                    	<div class="dashicons-before dashicons-yes ec_admin_order_details_totals_edit" id="ec_admin_order_details_customer_notes_save" onclick="ec_admin_process_customer_notes( ); return false;"></div>
                        <div class="ec_admin_row_heading_title ec_admin_order_details_special_title">Customer Notes</div>
                    	<textarea name="order_customer_notes" id="order_customer_notes" style="height:100px;"><?php echo $this->order->order_customer_notes; ?></textarea>
                    </div>
                    
					<div class="ec_admin_order_details_row ec_admin_customer_info_top" id="ec_admin_view_order_information_bottom">
                		<?php $edit_order_details_bottom_action = apply_filters( 'wp_easycart_admin_order_details_order_bottom_edit_action', 'show_pro_required' ); ?>
                        <div class="dashicons-before dashicons-edit ec_admin_order_details_totals_edit" id="ec_admin_order_details_edit_bottom" onclick="<?php echo $edit_order_details_bottom_action; ?>( ); return false;"></div>
                        <span id="ec_admin_order_details_ip_address"><?php if( $this->order->order_ip_address != '' ){ echo 'IP: ' . $this->order->order_ip_address;?><br /><?php }?></span>
                        <span id="ec_admin_order_details_agreed_to_terms">Agreed to Terms: <?php if( !$this->order->agreed_to_terms ){ echo 'No'; }else{ echo 'Yes'; } ?></span>
                    </div>
                    <?php do_action( 'wp_easycart_order_details_order_bottom_information' ); ?>
                    
                </div>
            </div>
        </div>
	</div>
    <div class="ec_admin_details_footer">
        <div class="ec_page_title_button_wrap">
        	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
        	<?php echo wp_easycart_admin( )->helpsystem->print_vids_url('orders', 'order-management', 'details');?>
            <?php if( $next_order_id ){ ?>
            <a class="ec_page_title_button" href="admin.php?page=wp-easycart-orders&subpage=orders&order_id=<?php echo $next_order_id; ?>&ec_admin_form_action=edit"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
            <?php }else{ ?>
            <button class="ec_page_title_button_disabled"><div class="dashicons-before dashicons-arrow-down-alt2"></div></button>
            <?php }?>
            <?php if( $prev_order_id ){ ?>
            <a class="ec_page_title_button" href="admin.php?page=wp-easycart-orders&subpage=orders&order_id=<?php echo $prev_order_id; ?>&ec_admin_form_action=edit"><div class="dashicons-before dashicons-arrow-up-alt2"></div></a>
            <?php }else{ ?>
            <button class="ec_page_title_button_disabled"><div class="dashicons-before dashicons-arrow-up-alt2"></div></button>
            <?php }?>
            <a href="<?php echo $this->action; ?>" class="ec_page_title_button">Back to Orders</a>
        </div>
    </div>
</div>