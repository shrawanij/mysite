function ec_admin_save_storepage_setup( ){
		
	jQuery( document.getElementById( "ec_admin_storepage_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_storepage',
		ec_option_storepage: ec_admin_get_value( 'ec_option_storepage', 'select' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_storepage_loader' );
	} } );
	
	return false;
	
}

function ec_admin_create_storepage( ){
	
	jQuery( document.getElementById( "ec_admin_storepage_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_create_storepage'
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		// Update Store DD Box
		var opt = document.createElement( 'option' );
		opt.value = data;
		opt.innerHTML = "Store";
		document.getElementById( 'ec_option_storepage' ).appendChild( opt );
		document.getElementById( 'ec_option_storepage' ).value = data;
		ec_admin_hide_loader( 'ec_admin_storepage_loader' );
	} } );
	
	return false;
	
}

function ec_admin_save_cartpage_setup( ){
		
	jQuery( document.getElementById( "ec_admin_cartpage_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_cartpage',
		ec_option_cartpage: ec_admin_get_value( 'ec_option_cartpage', 'select' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_cartpage_loader' );
	} } );
	
	return false;
	
}

function ec_admin_create_cartpage( ){
	
	jQuery( document.getElementById( "ec_admin_cartpage_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_create_cartpage'
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		// Update Cart DD Box
		var opt = document.createElement( 'option' );
		opt.value = data;
		opt.innerHTML = "Cart";
		document.getElementById( 'ec_option_cartpage' ).appendChild( opt );
		document.getElementById( 'ec_option_cartpage' ).value = data;
		ec_admin_hide_loader( 'ec_admin_cartpage_loader' );
	} } );
	
	return false;
	
}

function ec_admin_save_accountpage_setup( ){
		
	jQuery( document.getElementById( "ec_admin_accountpage_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_accountpage',
		ec_option_accountpage: ec_admin_get_value( 'ec_option_accountpage', 'select' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_accountpage_loader' );
	} } );
	
	return false;
	
}

function ec_admin_create_accountpage( ){
	
	jQuery( document.getElementById( "ec_admin_accountpage_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_create_accountpage'
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		// Update Account DD Box
		var opt = document.createElement( 'option' );
		opt.value = data;
		opt.innerHTML = "Account";
		document.getElementById( 'ec_option_accountpage' ).appendChild( opt );
		document.getElementById( 'ec_option_accountpage' ).value = data;
		ec_admin_hide_loader( 'ec_admin_accountpage_loader' );
	} } );
	
	return false;
	
}

function ec_admin_save_goals_setup( ){
		
	jQuery( document.getElementById( "ec_admin_goal_setup" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_goals_setup',
		ec_option_admin_display_sales_goal: ec_admin_get_value( 'ec_option_admin_display_sales_goal', 'select' ),
		ec_option_admin_sales_goal: ec_admin_get_value( 'ec_option_admin_sales_goal', 'text' ),
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_goal_setup' );
	} } );
	
	return false;
	
}

function ec_admin_save_currency_options( ){
	
	jQuery( document.getElementById( "ec_admin_currency_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_currency_options',
		ec_option_base_currency: ec_admin_get_value( 'ec_option_base_currency', 'text' ),
		ec_option_show_currency_code: ec_admin_get_value( 'ec_option_show_currency_code', 'select' ),
		ec_option_currency: ec_admin_get_value( 'ec_option_currency', 'text' ),
		ec_option_currency_symbol_location: ec_admin_get_value( 'ec_option_currency_symbol_location', 'select' ),
		ec_option_currency_negative_location: ec_admin_get_value( 'ec_option_currency_negative_location', 'select' ),
		ec_option_currency_decimal_symbol: ec_admin_get_value( 'ec_option_currency_decimal_symbol', 'text' ),
		ec_option_currency_decimal_places: ec_admin_get_value( 'ec_option_currency_decimal_places', 'text' ),
		ec_option_currency_thousands_seperator: ec_admin_get_value( 'ec_option_currency_thousands_seperator', 'text' ),
		ec_option_exchange_rates: ec_admin_get_value( 'ec_option_exchange_rates', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_currency_loader' );
	} } );
	
	return false;
	
}