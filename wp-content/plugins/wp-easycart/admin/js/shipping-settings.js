

function ec_admin_save_country_list( ){
	jQuery( document.getElementById( "ec_admin_country_list_display_loader" ) ).fadeIn( 'fast' );
	
	var country_list = {}
	var country_id = 0;
	jQuery( '.ec_admin_country_list' ).each( function( index ){
		if( jQuery( this ).is(':checked') ){
			country_id = jQuery( this ).attr( 'data-id-cnt' );
			country_list[country_id] = 1;
		}
	} );
	
	var data = {
		action: 'ec_admin_ajax_save_country_list',
		country_list: country_list
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_country_list_display_loader' );
	} } );
	
	return false;
}

function ec_admin_toggle_shipping_country( country_id ){
	if( jQuery( document.getElementById( 'country_list_' + country_id ) ).is(':checked') ){
		jQuery( '.ec_admin_state_list' ).each( function( index ){
			if( jQuery( this ).attr( 'data-id-cnt' ) == country_id ){
				jQuery( this ).prop('checked', true );
			}
		} );
	}else{
		jQuery( '.ec_admin_state_list' ).each( function( index ){
			if( jQuery( this ).attr( 'data-id-cnt' ) == country_id ){
				jQuery( this ).prop('checked', false );
			}
		} );
	}
}

function ec_admin_save_state_list( ){
	jQuery( document.getElementById( "ec_admin_state_list_display_loader" ) ).fadeIn( 'fast' );
	
	var state_list = {}
	jQuery( '.ec_admin_state_list' ).each( function( index ){
		if( jQuery( this ).is(':checked') ){
			state_list[jQuery( this ).attr( 'data-id-sta' )] = 1;
		}
	} );
	
	var data = {
		action: 'ec_admin_ajax_save_state_list',
		state_list: state_list
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_state_list_display_loader' );
	} } );
	
	return false;
}

function shipping_zone_toggle( zone_id ){
	if( jQuery( document.getElementById( 'shipping_zones_' + zone_id ) ).css( 'display' ) == 'none' ){
		jQuery( this ).find( '.dashicons-arrow-up' ).hide( );
		jQuery( this ).find( '.dashicons-arrow-down' ).show( );
		jQuery( document.getElementById( 'shipping_zones_' + zone_id ) ).show( );
	}else{
		jQuery( this ).find( '.dashicons-arrow-down' ).hide( );
		jQuery( this ).find( '.dashicons-arrow-up' ).show( );
		jQuery( document.getElementById( 'shipping_zones_' + zone_id ) ).hide( );
	}
	return false;
}

function ec_admin_open_add_zone( ){
	ec_admin_edit_zone_close( );
	ec_admin_close_add_shipping_zone_item( );
	jQuery( document.getElementById( 'shipping_zone_add' ) ).show( );
	return false;
}

function ec_admin_close_add_zone( ){
	jQuery( document.getElementById( 'shipping_zone_add' ) ).hide( );
	return false;
}

function add_zone_item_open( zone_id ){
	return false;
}

function ec_admin_add_shipping_zone( ){
	jQuery( document.getElementById( "ec_admin_shipping_zone_list_display_loader" ) ).fadeIn( 'fast' );
	
	var zone_name = jQuery( document.getElementById( 'ec_option_add_zone_name' ) ).val( );
	var data = {
		action: 'ec_admin_ajax_add_shipping_zone',
		ec_option_add_zone_name: zone_name
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_shipping_zone_list_display_loader' );
		jQuery( document.getElementById( 'shipping_zone_list' ) ).html( data );
		ec_admin_close_add_zone( );
		jQuery( document.getElementById( 'ec_option_add_zone_name' ) ).val( '' );
	} } );
	
	return false;
}

function ec_admin_edit_zone_open( zone_name, zone_id ){
	ec_admin_close_add_zone( );
	ec_admin_close_add_shipping_zone_item( );
	jQuery( document.getElementById( 'ec_option_edit_zone_name' ) ).val( zone_name );
	jQuery( document.getElementById( 'ec_option_edit_zone_id' ) ).val( zone_id );
	jQuery( document.getElementById( 'shipping_zone_edit' ) ).show( );
	return false;
}

function ec_admin_edit_zone_close( ){
	jQuery( document.getElementById( 'shipping_zone_edit' ) ).hide( );
	return false;
}

function ec_admin_edit_shipping_zone( ){
	jQuery( document.getElementById( "ec_admin_shipping_zone_list_display_loader" ) ).fadeIn( 'fast' );
	
	var zone_id = jQuery( document.getElementById( 'ec_option_edit_zone_id' ) ).val( );
	var zone_name = jQuery( document.getElementById( 'ec_option_edit_zone_name' ) ).val( );
	var data = {
		action: 'ec_admin_ajax_edit_shipping_zone',
		ec_option_edit_zone_name: zone_name,
		ec_option_edit_zone_id: zone_id
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_shipping_zone_list_display_loader' );
		jQuery( document.getElementById( 'shipping_zone_list' ) ).html( data );
		ec_admin_edit_zone_close( );
	} } );
	
	return false;
}

function delete_zone( zone_id ){
	jQuery( document.getElementById( "ec_admin_shipping_zone_list_display_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_delete_shipping_zone',
		zone_id: zone_id
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_shipping_zone_list_display_loader' );
		jQuery( document.getElementById( 'shipping_zone_list' ) ).html( data );
	} } );
	
	return false;
}

function ec_admin_open_add_shipping_zone_item( zone_id ){
	ec_admin_close_add_zone( );
	ec_admin_edit_zone_close( );
	jQuery( document.getElementById( 'ec_option_add_zone_item_id' ) ).val( zone_id );
	jQuery( document.getElementById( 'shipping_zone_item_add' ) ).show( );
	return false;
}

function ec_admin_close_add_shipping_zone_item( ){
	jQuery( document.getElementById( 'shipping_zone_item_add' ) ).hide( );
	return false;
}

function ec_admin_add_shipping_zone_item( ){
	jQuery( document.getElementById( "ec_admin_shipping_zone_list_display_loader" ) ).fadeIn( 'fast' );
	
	var zone_id = jQuery( document.getElementById( 'ec_option_add_zone_item_id' ) ).val( );
	var zone_item_country = jQuery( document.getElementById( 'ec_option_add_zone_item_country' ) ).val( );
	var zone_item_state = jQuery( document.getElementById( 'ec_option_add_zone_item_state' ) ).val( );
	var data = {
		action: 'ec_admin_ajax_add_shipping_zone_item',
		ec_option_add_zone_item_country: zone_item_country,
		ec_option_add_zone_item_state: zone_item_state,
		ec_option_add_zone_item_id: zone_id
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_shipping_zone_list_display_loader' );
		jQuery( document.getElementById( 'ec_option_add_zone_item_country' ) ).val( "" );
		jQuery( document.getElementById( 'ec_option_add_zone_item_state' ) ).val( "" );
		jQuery( document.getElementById( 'shipping_zone_list' ) ).html( data );
		ec_admin_close_add_shipping_zone_item( );
	} } );
	
	return false;
}

function delete_zone_item( zone_item_id ){
	jQuery( document.getElementById( "ec_admin_shipping_zone_list_display_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_delete_shipping_zone_item',
		zone_item_id: zone_item_id
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_shipping_zone_list_display_loader' );
		jQuery( document.getElementById( 'shipping_zone_list' ) ).html( data );
	} } );
	
	return false;
}

function ec_admin_save_basic_shipping_options( ){
	jQuery( document.getElementById( "ec_admin_shipping_options_display_loader" ) ).fadeIn( 'fast' );
	
	
	var data = {
		action: 'ec_admin_ajax_update_basic_shipping_options',
		ec_option_use_shipping: ec_admin_get_value( 'ec_option_use_shipping', 'checkbox' ),
		ec_option_hide_shipping_rate_page1: ec_admin_get_value( 'ec_option_hide_shipping_rate_page1', 'checkbox' ),
		shipping_handling_rate: ec_admin_get_value( 'shipping_handling_rate', 'text' ),
		shipping_expedite_rate: ec_admin_get_value( 'shipping_expedite_rate', 'text' ),
		ec_option_weight: ec_admin_get_value( 'ec_option_weight', 'select' ),
		ec_option_enable_metric_unit_display: ec_admin_get_value( 'ec_option_enable_metric_unit_display', 'select' ),
		ec_option_add_local_pickup: ec_admin_get_value( 'ec_option_add_local_pickup', 'checkbox' ),
		ec_option_collect_tax_on_shipping: ec_admin_get_value( 'ec_option_collect_tax_on_shipping', 'checkbox' ),
		ec_option_show_delivery_days_live_shipping: ec_admin_get_value( 'ec_option_show_delivery_days_live_shipping', 'checkbox' ),
		ec_option_collect_shipping_for_subscriptions: ec_admin_get_value( 'ec_option_collect_shipping_for_subscriptions', 'checkbox' ),
		ec_option_ship_items_seperately: ec_admin_get_value( 'ec_option_ship_items_seperately', 'checkbox' ),
		ec_option_static_ship_items_seperately: ec_admin_get_value( 'ec_option_static_ship_items_seperately', 'checkbox' ),
		ec_option_fedex_use_net_charge: ec_admin_get_value( 'ec_option_fedex_use_net_charge', 'checkbox' ),
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_shipping_options_display_loader' );
	} } );
	
	return false;
}