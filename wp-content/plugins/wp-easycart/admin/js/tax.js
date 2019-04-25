/* State Taxes*/
function ec_admin_save_state_tax( id ){
	jQuery( document.getElementById( "ec_admin_tax_by_state_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_state_tax_rate',
		taxrate_id: id,
		state_id: ec_admin_get_value( 'ec_state_code_' + id, 'select' ),
		rate: ec_admin_get_value( 'state_tax_rate_' + id, 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_tax_by_state_loader' );
	} } );
	
	return false;
}

function ec_admin_delete_state_tax_rate( id ){
	jQuery( document.getElementById( "ec_admin_tax_by_state_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_delete_state_tax_rate',
		taxrate_id: id
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		jQuery( document.getElementById( 'ec_admin_state_tax_divider_' + id ) ).remove( );
		jQuery( document.getElementById( 'ec_admin_state_tax_row_' + id ) ).remove( );
		jQuery( document.getElementById( 'ec_admin_state_tax_button_row_' + id ) ).remove( );
		if( data == '0' ){
			jQuery( document.getElementById( 'modify_state_tax_rates_none_header' ) ).show( );
			jQuery( document.getElementById( 'modify_state_tax_rates_header' ) ).hide( );
		}
		ec_admin_hide_loader( 'ec_admin_tax_by_state_loader' );
	} } );
	
	return false;
}

function ec_admin_add_state_tax_rate( ){
	jQuery( document.getElementById( "ec_admin_tax_by_state_loader" ) ).fadeIn( 'fast' );
		
	var data = {
		action: 'ec_admin_ajax_insert_state_tax_rate',
		state_id: ec_admin_get_value( 'ec_new_state_code', 'text' ),
		rate: ec_admin_get_value( 'ec_new_state_rate', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		jQuery( document.getElementById( 'ec_new_state_code' ) ).val( "0" );
		jQuery( document.getElementById( 'ec_new_state_rate' ) ).val( "0.000" );
		jQuery( document.getElementById( 'insert_new_state_tax_here' ) ).before( data );
		ec_admin_hide_loader( 'ec_admin_tax_by_state_loader' );
		jQuery( document.getElementById( 'modify_state_tax_rates_none_header' ) ).hide( );
		jQuery( document.getElementById( 'modify_state_tax_rates_header' ) ).show( );
	} } );
	
	return false;
}

/* Country Taxes*/
function ec_admin_save_country_tax( id ){
	jQuery( document.getElementById( "ec_admin_tax_by_country_loader" ) ).fadeIn( 'fast' );

	var data = {
		action: 'ec_admin_ajax_save_country_tax_rate',
		taxrate_id: id,
		country_id: ec_admin_get_value( 'ec_country_code_' + id, 'select' ),
		rate: ec_admin_get_value( 'country_tax_rate_' + id, 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_tax_by_country_loader' );
	} } );
	
	return false;
}

function ec_admin_delete_country_tax_rate( id ){
	jQuery( document.getElementById( "ec_admin_tax_by_country_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_delete_country_tax_rate',
		taxrate_id: id
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		jQuery( document.getElementById( 'ec_admin_country_tax_divider_' + id ) ).remove( );
		jQuery( document.getElementById( 'ec_admin_country_tax_row_' + id ) ).remove( );
		jQuery( document.getElementById( 'ec_admin_country_tax_button_row_' + id ) ).remove( );
		if( data == '0' ){
			jQuery( document.getElementById( 'modify_country_tax_rates_none_header' ) ).show( );
			jQuery( document.getElementById( 'modify_country_tax_rates_header' ) ).hide( );
		}
		ec_admin_hide_loader( 'ec_admin_tax_by_country_loader' );
	} } );
	
	return false;
}

function ec_admin_add_country_tax_rate( ){
	jQuery( document.getElementById( "ec_admin_tax_by_country_loader" ) ).fadeIn( 'fast' );
		
	var data = {
		action: 'ec_admin_ajax_insert_country_tax_rate',
		country_id: ec_admin_get_value( 'ec_new_country_code', 'text' ),
		rate: ec_admin_get_value( 'ec_new_country_rate', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		jQuery( document.getElementById( 'ec_new_country_code' ) ).val( "0" );
		jQuery( document.getElementById( 'ec_new_country_rate' ) ).val( "0.000" );
		jQuery( document.getElementById( 'insert_new_country_tax_here' ) ).before( data );
		ec_admin_hide_loader( 'ec_admin_tax_by_country_loader' );
		jQuery( document.getElementById( 'modify_country_tax_rates_none_header' ) ).hide( );
		jQuery( document.getElementById( 'modify_country_tax_rates_header' ) ).show( );
	} } );
	
	return false;
}
/* Global Tax Rate */
function ec_admin_update_global_tax_display( ){
	if( jQuery( document.getElementById( 'ec_option_use_global_tax' ) ).is(':checked') ){
		jQuery( document.getElementById( 'ec_global_tax_row' ) ).show( );
	}else{
		jQuery( document.getElementById( 'ec_global_tax_row' ) ).hide( );
	}
}

function ec_admin_update_global_tax_rate( ){
	jQuery( document.getElementById( "ec_admin_global_tax_rate_loader" ) ).fadeIn( 'fast' );
		
	var data = {
		action: 'ec_admin_ajax_update_global_tax_rate',
		ec_global_taxrate_id: ec_admin_get_value( 'ec_global_taxrate_id', 'text' ),
		ec_option_use_global_tax: ec_admin_get_value( 'ec_option_use_global_tax', 'checkbox' ),
		ec_global_tax_rate: ec_admin_get_value( 'ec_global_tax_rate', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		if( data == "0" ){
			jQuery( document.getElementById( 'ec_global_tax_rate' ) ).val( '0.000' );
			jQuery( document.getElementById( 'ec_global_tax_row' ) ).hide( );
		}
		jQuery( document.getElementById( 'ec_global_taxrate_id' ) ).val( data );
		ec_admin_hide_loader( 'ec_admin_global_tax_rate_loader' );
	} } );
	
	return false;
}

/* Duty Tax Rate */
function ec_admin_update_duty_tax_display( ){
	if( jQuery( document.getElementById( 'ec_option_use_duty_tax' ) ).is(':checked') ){
		jQuery( document.getElementById( 'ec_duty_tax_row' ) ).show( );
	}else{
		jQuery( document.getElementById( 'ec_duty_tax_row' ) ).hide( );
	}
}

function ec_admin_update_duty_tax_rate( ){
	jQuery( document.getElementById( "ec_admin_duty_options_loader" ) ).fadeIn( 'fast' );
		
	var data = {
		action: 'ec_admin_ajax_update_duty_tax_rate',
		ec_duty_taxrate_id: ec_admin_get_value( 'ec_duty_taxrate_id', 'text' ),
		ec_option_use_duty_tax: ec_admin_get_value( 'ec_option_use_duty_tax', 'checkbox' ),
		ec_duty_exempt_country_code: ec_admin_get_value( 'ec_duty_exempt_country_code', 'select' ),
		ec_duty_tax_rate: ec_admin_get_value( 'ec_duty_tax_rate', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		if( data == "0" ){
			jQuery( document.getElementById( 'ec_duty_tax_rate' ) ).val( '0.000' );
			jQuery( document.getElementById( 'ec_duty_tax_row' ) ).hide( );
		}
		jQuery( document.getElementById( 'ec_duty_taxrate_id' ) ).val( data );
		ec_admin_hide_loader( 'ec_admin_duty_options_loader' );
	} } );
	
	return false;
}

/* Vat Tax Rate */
function ec_admin_update_vat_tax_display( ){
	if( jQuery( document.getElementById( 'ec_vat_type' ) ).val( ) == "0" ){
		jQuery( document.getElementById( 'ec_admin_vat_pricing_type_row' ) ).hide( );
		jQuery( document.getElementById( 'ec_admin_vat_default_rate_row' ) ).hide( );
		jQuery( document.getElementById( 'ec_admin_vat_country_rates_section' ) ).hide( );
		jQuery( document.getElementById( 'ec_admin_vat_custom_rate_row' ) ).hide( );
		jQuery( document.getElementById( 'ec_admin_vat_validate_number_rate_row' ) ).hide( );
		jQuery( document.getElementById( 'ec_admin_vat_validate_vat_registration_number' ) ).hide( );
		jQuery( document.getElementById( 'ec_admin_vatlayer_api_row' ) ).hide( );
	
	}else if( jQuery( document.getElementById( 'ec_vat_type' ) ).val( ) == "tax_by_single_vat" ){
		jQuery( document.getElementById( 'ec_admin_vat_pricing_type_row' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_vat_default_rate_row' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_vat_country_rates_section' ) ).hide( );
		jQuery( document.getElementById( 'ec_admin_vat_custom_rate_row' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_vat_validate_number_rate_row' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_vat_validate_vat_registration_number' ) ).show( );
		if( jQuery( document.getElementById( 'ec_option_validate_vat_registration_number' ) ).is( ":checked" ) )
			jQuery( document.getElementById( 'ec_admin_vatlayer_api_row' ) ).show( );
		else
			jQuery( document.getElementById( 'ec_admin_vatlayer_api_row' ) ).hide( );
	
	}else{
		jQuery( document.getElementById( 'ec_admin_vat_pricing_type_row' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_vat_default_rate_row' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_vat_country_rates_section' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_vat_custom_rate_row' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_vat_validate_number_rate_row' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_vat_validate_vat_registration_number' ) ).show( );
		if( jQuery( document.getElementById( 'ec_option_validate_vat_registration_number' ) ).is( ":checked" ) )
			jQuery( document.getElementById( 'ec_admin_vatlayer_api_row' ) ).show( );
		else
			jQuery( document.getElementById( 'ec_admin_vatlayer_api_row' ) ).hide( );
	}
}

function ec_validate_vat_toggle( ){
	if( jQuery( document.getElementById( 'ec_vat_type' ) ).val( ) != "0" && jQuery( document.getElementById( 'ec_option_validate_vat_registration_number' ) ).is( ":checked" ) ){
		jQuery( document.getElementById( 'ec_admin_vatlayer_api_row' ) ).show( );
	}else{
		jQuery( document.getElementById( 'ec_admin_vatlayer_api_row' ) ).hide( );
	}
}

function ec_admin_update_vat_tax_rate( ){
	jQuery( document.getElementById( "ec_admin_vat_options_loader" ) ).fadeIn( 'fast' );
		
	var data = {
		action: 'ec_admin_ajax_update_vat_tax_rate',
		ec_vat_taxrate_id: ec_admin_get_value( 'ec_vat_taxrate_id', 'text' ),
		ec_vat_type: ec_admin_get_value( 'ec_vat_type', 'select' ),
		ec_vat_pricing_method: ec_admin_get_value( 'ec_vat_pricing_method', 'select' ),
		ec_default_vat_rate: ec_admin_get_value( 'ec_default_vat_rate', 'text' ),
		ec_option_validate_vat_registration_number: ec_admin_get_value( 'ec_option_validate_vat_registration_number', 'checkbox' ),
		ec_option_vatlayer_api_key: ec_admin_get_value( 'ec_option_vatlayer_api_key', 'text' ),
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		if( data == "0" ){
			jQuery( document.getElementById( 'ec_admin_vat_pricing_type_row' ) ).hide( );
			jQuery( document.getElementById( 'ec_admin_vat_default_rate_row' ) ).hide( );
			jQuery( document.getElementById( 'ec_default_vat_rate' ) ).val( '0.000' );
			jQuery( document.getElementById( 'ec_admin_vat_country_rates_section' ) ).hide( );
		}
		jQuery( document.getElementById( 'ec_vat_taxrate_id' ) ).val( data );
		ec_admin_hide_loader( 'ec_admin_vat_options_loader' );
	} } );
	
	return false;
}

function ec_admin_add_vat_country_tax_rate( ){
	jQuery( document.getElementById( "ec_admin_vat_options_loader" ) ).fadeIn( 'fast' );
		
	var data = {
		action: 'ec_admin_ajax_insert_vat_country_tax_rate',
		ec_new_vat_country_code: ec_admin_get_value( 'ec_new_vat_country_code', 'select' ),
		ec_new_vat_country_rate: ec_admin_get_value( 'ec_new_vat_country_rate', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		jQuery( document.getElementById( 'ec_new_vat_country_code' ) ).val( "0" );
		jQuery( document.getElementById( 'ec_new_vat_country_rate' ) ).val( "0.000" );
		jQuery( document.getElementById( 'insert_new_vat_country_tax_here' ) ).before( data );
		ec_admin_hide_loader( 'ec_admin_vat_options_loader' );
		jQuery( document.getElementById( 'modify_vat_country_tax_rates_none_header' ) ).hide( );
		jQuery( document.getElementById( 'modify_vat_country_tax_rates_header' ) ).show( );
	} } );
	
	return false;
}

function ec_admin_save_vat_country_tax( id ){
	jQuery( document.getElementById( "ec_admin_vat_options_loader" ) ).fadeIn( 'fast' );

	var data = {
		action: 'ec_admin_ajax_save_vat_country_tax_rate',
		country_id: id,
		rate: ec_admin_get_value( 'vat_country_tax_rate_' + id, 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_vat_options_loader' );
	} } );
	
	return false;
}

function ec_admin_delete_vat_country_tax_rate( id ){
	jQuery( document.getElementById( "ec_admin_vat_options_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_delete_vat_country_tax_rate',
		country_id: id
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		jQuery( document.getElementById( 'ec_admin_vat_country_tax_divider_' + id ) ).remove( );
		jQuery( document.getElementById( 'ec_admin_vat_country_tax_row_' + id ) ).remove( );
		jQuery( document.getElementById( 'ec_admin_vat_country_tax_button_row_' + id ) ).remove( );
		if( data == '0' ){
			jQuery( document.getElementById( 'modify_vat_country_tax_rates_none_header' ) ).show( );
			jQuery( document.getElementById( 'modify_vat_country_tax_rates_header' ) ).hide( );
		}
		ec_admin_hide_loader( 'ec_admin_vat_options_loader' );
	} } );
	
	return false;
}

/* Canada Tax */
function ec_admin_update_canada_tax_display( ){
	if( jQuery( document.getElementById( 'ec_option_enable_easy_canada_tax' ) ).is(':checked') ){
		jQuery( document.getElementById( 'ec_admin_use_canada_tax_section' ) ).show( );
	}else{
		jQuery( document.getElementById( 'ec_admin_use_canada_tax_section' ) ).hide( );
	}
}

function ec_admin_update_province_canada_tax_display( province, user_role ){
	if( jQuery( document.getElementById( 'ec_canada_tax_' + province + '_' + user_role ) ).is(':checked') ){
		jQuery( document.getElementById( 'ec_admin_canada_tax_row_' + province + "_" + user_role ) ).show( );
	}else{
		jQuery( document.getElementById( 'ec_admin_canada_tax_row_' + province + "_" + user_role ) ).hide( );
	}
}

function ec_admin_update_canada_tax_rate( ){
	jQuery( document.getElementById( "ec_admin_canada_tax_options_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_update_canada_country_tax_rate',
		ec_option_enable_easy_canada_tax: ec_admin_get_value( 'ec_option_enable_easy_canada_tax', 'checkbox' )
	};
	
	jQuery( '.ec_admin_canada_tax_checkbox' ).each( function( index ){
		if( jQuery( this ).is(':checked') ){
			data[jQuery( this ).attr( 'name' )] = 1;
		}
	} );
	
	jQuery( '.ec_admin_canada_tax_gst_input' ).each( function( index ){
		data[jQuery( this ).attr( 'name' )] = jQuery( this ).val( );
	} );
	
	jQuery( '.ec_admin_canada_tax_pst_input' ).each( function( index ){
		data[jQuery( this ).attr( 'name' )] = jQuery( this ).val( );
	} );
	
	jQuery( '.ec_admin_canada_tax_hst_input' ).each( function( index ){
		data[jQuery( this ).attr( 'name' )] = jQuery( this ).val( );
	} );
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_canada_tax_options_loader' );
	} } );
	
	return false;
}

/* Tax Cloud */
function ec_admin_update_tax_cloud( ){
	jQuery( document.getElementById( "ec_admin_tax_cloud_loader" ) ).fadeIn( 'fast' );
		
	var data = {
		action: 'ec_admin_ajax_update_tax_cloud',
		ec_option_tax_cloud_api_id: ec_admin_get_value( 'ec_option_tax_cloud_api_id', 'text' ),
		ec_option_tax_cloud_api_key: ec_admin_get_value( 'ec_option_tax_cloud_api_key', 'text' ),
		ec_option_tax_cloud_address: ec_admin_get_value( 'ec_option_tax_cloud_address', 'text' ),
		ec_option_tax_cloud_city: ec_admin_get_value( 'ec_option_tax_cloud_city', 'text' ),
		ec_option_tax_cloud_state: ec_admin_get_value( 'ec_option_tax_cloud_state', 'text' ),
		ec_option_tax_cloud_zip: ec_admin_get_value( 'ec_option_tax_cloud_zip', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_tax_cloud_loader' );
	} } );
	
	return false;
}