function ec_admin_save_admin_options( ){
	jQuery( document.getElementById( "ec_admin_miscellaneous_admin_options_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_miscellaneous_admin_options',
		ec_option_admin_product_show_stock_option: ec_admin_get_value( 'ec_option_admin_product_show_stock_option', 'checkbox' ),
		ec_option_admin_product_show_shipping_option: ec_admin_get_value( 'ec_option_admin_product_show_shipping_option', 'checkbox' ),
		ec_option_admin_product_show_tax_option: ec_admin_get_value( 'ec_option_admin_product_show_tax_option', 'checkbox' ),
		ec_option_admin_product_show_variant_option: ec_admin_get_value( 'ec_option_admin_product_show_variant_option', 'checkbox' ),
		ec_option_enable_push_notifications: ec_admin_get_value( 'ec_option_enable_push_notifications', 'checkbox' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_miscellaneous_admin_options_loader' );
	} } );
	
	return false;
}

function ec_admin_save_search_options( ){
	jQuery( document.getElementById( "ec_admin_miscellaneous_search_options_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_miscellaneous_search_options',
		ec_option_use_live_search: ec_admin_get_value( 'ec_option_use_live_search', 'checkbox' ),
		ec_option_search_title: ec_admin_get_value( 'ec_option_search_title', 'checkbox' ),
		ec_option_search_model_number: ec_admin_get_value( 'ec_option_search_model_number', 'checkbox' ),
		ec_option_search_manufacturer: ec_admin_get_value( 'ec_option_search_manufacturer', 'checkbox' ),
		ec_option_search_description: ec_admin_get_value( 'ec_option_search_description', 'checkbox' ),
		ec_option_search_short_description: ec_admin_get_value( 'ec_option_search_short_description', 'checkbox' ),
		ec_option_search_menu: ec_admin_get_value( 'ec_option_search_menu', 'checkbox' ),
		ec_option_search_by_or: ec_admin_get_value( 'ec_option_search_by_or', 'checkbox' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_miscellaneous_search_options_loader' );
	} } );
	
	return false;
	
}

function ec_admin_save_additional_options( ){
	jQuery( document.getElementById( "ec_admin_miscellaneous_additional_options_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_miscellaneous_additional_options',
		ec_option_cart_menu_id: ec_admin_get_value( 'ec_option_cart_menu_id', 'select' ),
		ec_option_hide_cart_icon_on_empty: ec_admin_get_value( 'ec_option_hide_cart_icon_on_empty', 'checkbox' ),
		ec_option_enable_newsletter_popup: ec_admin_get_value( 'ec_option_enable_newsletter_popup', 'checkbox' ),
		ec_option_enable_gateway_log: ec_admin_get_value( 'ec_option_enable_gateway_log', 'checkbox' ),
		ec_option_use_inquiry_form: ec_admin_get_value( 'ec_option_use_inquiry_form', 'checkbox' ),
		ec_option_packing_slip_show_pricing: ec_admin_get_value( 'ec_option_packing_slip_show_pricing', 'checkbox' ),
		ec_option_use_old_linking_style: ec_admin_get_value( 'ec_option_use_old_linking_style', 'checkbox' ),
		ec_option_deconetwork_allow_blank_products: ec_admin_get_value( 'ec_option_deconetwork_allow_blank_products', 'checkbox' ),
		ec_option_allow_tracking: ec_admin_get_value( 'ec_option_allow_tracking', 'checkbox' ),
		ec_option_abandoned_cart_days: ec_admin_get_value( 'ec_option_abandoned_cart_days', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_miscellaneous_additional_options_loader' );
	} } );
	
	return false;
	
}

function ec_admin_ajax_clear_stats( ){
	
	jQuery( document.getElementById( "ec_admin_miscellaneous_additional_options_loader" ) ).fadeIn( 'fast' );
		
	var data = {
		action: 'ec_admin_ajax_clear_stats',
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_miscellaneous_additional_options_loader' );
	} } );
	
	return false;
	
}


function ec_admin_delete_gateway_log( ){
	
	jQuery( document.getElementById( "ec_admin_miscellaneous_additional_options_loader" ) ).fadeIn( 'fast' );
		
	var data = {
		action: 'ec_admin_delete_gateway_log',
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_miscellaneous_additional_options_loader' );
	} } );
	
	return false;
	
}

function ec_admin_ajax_download_gateway_log( ){
	jQuery( document.getElementById( "ec_admin_miscellaneous_additional_options_loader" ) ).fadeIn( 'fast' );
		
	var data = {
		action: 'ec_admin_ajax_download_gateway_log',
		ec_option_cart_menu_id: ec_admin_get_value( 'ec_option_cart_menu_id', 'select' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_miscellaneous_additional_options_loader' );
	} } );
	
	return false;
	
}