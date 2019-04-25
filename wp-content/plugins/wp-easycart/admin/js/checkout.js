function ec_admin_save_checkout_form_options( ){
	jQuery( document.getElementById( "ec_admin_checkout_form_settings_loader" ) ).fadeIn( 'fast' );
	
	var ec_option_load_ssl = 0;
	var ec_option_display_country_top = 0;
	var ec_option_use_address2 = 0;
	var ec_option_collect_user_phone = 0;
	var ec_option_enable_company_name = 0;
	var ec_option_collect_vat_registration_number = 0;
	var ec_option_user_order_notes = 0;
	var ec_option_require_terms_agreement = 0;
	var ec_option_use_contact_name = 0;
	var ec_option_show_card_holder_name = 0;
	
	if( jQuery( document.getElementById( 'ec_option_load_ssl' ) ).is( ':checked' ) )
		ec_option_load_ssl = 1;
	
	if( jQuery( document.getElementById( 'ec_option_display_country_top' ) ).is( ':checked' ) )
		ec_option_display_country_top = 1;
		
	if( jQuery( document.getElementById( 'ec_option_use_address2' ) ).is( ':checked' ) )
		ec_option_use_address2 = 1;
		
	if( jQuery( document.getElementById( 'ec_option_collect_user_phone' ) ).is( ':checked' ) )
		ec_option_collect_user_phone = 1;
		
	if( jQuery( document.getElementById( 'ec_option_enable_company_name' ) ).is( ':checked' ) )
		ec_option_enable_company_name = 1;
		
	if( jQuery( document.getElementById( 'ec_option_collect_vat_registration_number' ) ).is( ':checked' ) )
		ec_option_collect_vat_registration_number = 1;
		
	if( jQuery( document.getElementById( 'ec_option_user_order_notes' ) ).is( ':checked' ) )
		ec_option_user_order_notes = 1;
		
	if( jQuery( document.getElementById( 'ec_option_require_terms_agreement' ) ).is( ':checked' ) )
		ec_option_require_terms_agreement = 1;
		
	if( jQuery( document.getElementById( 'ec_option_use_contact_name' ) ).is( ':checked' ) )
		ec_option_use_contact_name = 1;
		
	if( jQuery( document.getElementById( 'ec_option_show_card_holder_name' ) ).is( ':checked' ) )
		ec_option_show_card_holder_name = 1;
	
	var data = {
		action: 'ec_admin_ajax_save_checkout_form',
		ec_option_load_ssl: ec_option_load_ssl,
		ec_option_display_country_top: ec_option_display_country_top,
		ec_option_use_address2: ec_option_use_address2,
		ec_option_collect_user_phone: ec_option_collect_user_phone,
		ec_option_enable_company_name: ec_option_enable_company_name,
		ec_option_collect_vat_registration_number: ec_option_collect_vat_registration_number,
		ec_option_user_order_notes: ec_option_user_order_notes,
		ec_option_require_terms_agreement: ec_option_require_terms_agreement,
		ec_option_use_contact_name: ec_option_use_contact_name,
		ec_option_show_card_holder_name: ec_option_show_card_holder_name
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_checkout_form_settings_loader' );
	} } );
	
	return false;
}

function ec_admin_save_checkout_options( ){
	jQuery( document.getElementById( "ec_admin_checkout_settings_loader" ) ).fadeIn( 'fast' );
	
	var ec_option_terms_link = jQuery( document.getElementById( 'ec_option_terms_link' ) ).val( );
	var ec_option_privacy_link = jQuery( document.getElementById( 'ec_option_privacy_link' ) ).val( );
	var ec_option_return_to_store_page_url = jQuery( document.getElementById( 'ec_option_return_to_store_page_url' ) ).val( );
	var ec_option_weight = jQuery( document.getElementById( 'ec_option_weight' ) ).val( );
	var ec_option_enable_metric_unit_display = jQuery( document.getElementById( 'ec_option_enable_metric_unit_display' ) ).val( );
	var ec_option_default_payment_type = jQuery( document.getElementById( 'ec_option_default_payment_type' ) ).val( );
	var ec_option_default_country = jQuery( document.getElementById( 'ec_option_default_country' ) ).val( );
	var ec_option_minimum_order_total = jQuery( document.getElementById( 'ec_option_minimum_order_total' ) ).val( );
	
	var ec_option_skip_shipping_page = 0;
	var ec_option_skip_cart_login = 0;
	var ec_option_use_estimate_shipping = 0;
	var ec_option_estimate_shipping_zip = 0;
	var ec_option_estimate_shipping_country = 0;
	var ec_option_allow_guest = 0;
	var ec_option_show_giftcards = 0;
	var ec_option_gift_card_shipping_allowed = 0;
	var ec_option_show_coupons = 0;
	var ec_option_addtocart_return_to_product = 0;
	var ec_option_use_smart_states = 0;
	var ec_option_use_state_dropdown = 0;
	var ec_option_use_country_dropdown = 0;
	
	if( jQuery( document.getElementById( 'ec_option_skip_shipping_page' ) ).is( ':checked' ) )
		ec_option_skip_shipping_page = 1;
	if( jQuery( document.getElementById( 'ec_option_skip_cart_login' ) ).is( ':checked' ) )
		ec_option_skip_cart_login = 1;
	if( jQuery( document.getElementById( 'ec_option_use_estimate_shipping' ) ).is( ':checked' ) )
		ec_option_use_estimate_shipping = 1;
	if( jQuery( document.getElementById( 'ec_option_estimate_shipping_zip' ) ).is( ':checked' ) )
		ec_option_estimate_shipping_zip = 1;
	if( jQuery( document.getElementById( 'ec_option_estimate_shipping_country' ) ).is( ':checked' ) )
		ec_option_estimate_shipping_country = 1;
	if( jQuery( document.getElementById( 'ec_option_allow_guest' ) ).is( ':checked' ) )
		ec_option_allow_guest = 1;
	if( jQuery( document.getElementById( 'ec_option_show_giftcards' ) ).is( ':checked' ) )
		ec_option_show_giftcards = 1;
	if( jQuery( document.getElementById( 'ec_option_gift_card_shipping_allowed' ) ).is( ':checked' ) )
		ec_option_gift_card_shipping_allowed = 1;
	if( jQuery( document.getElementById( 'ec_option_show_coupons' ) ).is( ':checked' ) )
		ec_option_show_coupons = 1;
	if( jQuery( document.getElementById( 'ec_option_addtocart_return_to_product' ) ).is( ':checked' ) )
		ec_option_addtocart_return_to_product = 1;
	if( jQuery( document.getElementById( 'ec_option_use_smart_states' ) ).is( ':checked' ) )
		ec_option_use_smart_states = 1;
	if( jQuery( document.getElementById( 'ec_option_use_state_dropdown' ) ).is( ':checked' ) )
		ec_option_use_state_dropdown = 1;
	if( jQuery( document.getElementById( 'ec_option_use_country_dropdown' ) ).is( ':checked' ) )
		ec_option_use_country_dropdown = 1;
		

	var data = {
		action: 'ec_admin_ajax_save_checkout_options',
		ec_option_terms_link: ec_option_terms_link,
		ec_option_privacy_link: ec_option_privacy_link,
		ec_option_return_to_store_page_url: ec_option_return_to_store_page_url,
		ec_option_weight: ec_option_weight,
		ec_option_enable_metric_unit_display: ec_option_enable_metric_unit_display,
		ec_option_default_payment_type: ec_option_default_payment_type,
		ec_option_default_country: ec_option_default_country,
		ec_option_minimum_order_total: ec_option_minimum_order_total,
		ec_option_current_order_id:  ec_admin_get_value( 'ec_option_current_order_id', 'text' ),
		ec_option_skip_shipping_page: ec_option_skip_shipping_page,
		ec_option_skip_cart_login: ec_option_skip_cart_login,
		ec_option_use_estimate_shipping: ec_option_use_estimate_shipping,
		ec_option_estimate_shipping_zip: ec_option_estimate_shipping_zip,
		ec_option_estimate_shipping_country: ec_option_estimate_shipping_country,
		ec_option_allow_guest: ec_option_allow_guest,
		ec_option_show_giftcards: ec_option_show_giftcards,
		ec_option_gift_card_shipping_allowed: ec_option_gift_card_shipping_allowed,
		ec_option_show_coupons: ec_option_show_coupons,
		ec_option_addtocart_return_to_product: ec_option_addtocart_return_to_product,
		ec_option_use_smart_states: ec_option_use_smart_states,
		ec_option_use_state_dropdown: ec_option_use_state_dropdown,
		ec_option_use_country_dropdown: ec_option_use_country_dropdown,

	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_checkout_settings_loader' );
	} } );
	
	return false;
	
}

function ec_admin_save_stock_control_options( ){
	jQuery( document.getElementById( "ec_admin_checkout_stock_control_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_stock_control',
		ec_option_send_low_stock_emails: ec_admin_get_value( 'ec_option_send_low_stock_emails', 'checkbox' ),
		ec_option_send_out_of_stock_emails: ec_admin_get_value( 'ec_option_send_out_of_stock_emails', 'checkbox' ),
		ec_option_low_stock_trigger_total: ec_admin_get_value( 'ec_option_low_stock_trigger_total', 'number' ),

	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_checkout_stock_control_loader' );
	} } );
	
	return false;
	
}