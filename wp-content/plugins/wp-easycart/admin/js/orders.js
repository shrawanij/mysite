var ec_admin_order_details_order_info_show = false;
var ec_admin_order_details_shipping_method_show = false;
var ec_admin_order_details_customer_notes_show = false;

jQuery( document ).ready( function( ){
	jQuery( document.getElementById( 'ec_admin_order_details_shipping_method_save' ) ).on( 'click', ec_admin_process_shipping_method );
} );

function ec_admin_resend_giftcard( script_order_id, script_orderdetail_id ){
	jQuery( document.getElementById( "ec_admin_order_management" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_resend_giftcard_email',
		order_id: script_order_id,
		orderdetail_id: script_orderdetail_id,
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_order_management' );
	} } );
	
	return false;
}
function ec_admin_copy_billing_address(button) {
	 document.getElementById( "shipping_first_name" ).value = document.getElementById( "billing_first_name" ).value;
	 document.getElementById( "shipping_last_name" ).value = document.getElementById( "billing_last_name" ).value;
	 document.getElementById( "shipping_company_name" ).value = document.getElementById( "billing_company_name" ).value;
	 document.getElementById( "shipping_address_line_1" ).value = document.getElementById( "billing_address_line_1" ).value;
	 document.getElementById( "shipping_address_line_2" ).value = document.getElementById( "billing_address_line_2" ).value;
	 document.getElementById( "shipping_city" ).value = document.getElementById( "billing_city" ).value;
	 document.getElementById( "shipping_state" ).value = document.getElementById( "billing_state" ).value;
	 document.getElementById( "shipping_country" ).value = document.getElementById( "billing_country" ).value;
	 document.getElementById( "shipping_zip" ).value = document.getElementById( "billing_zip" ).value;
	 document.getElementById( "shipping_phone" ).value = document.getElementById( "billing_phone" ).value;
}

function ec_admin_edit_order_status(button) {
	jQuery( document.getElementById( "ec_admin_order_management" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_edit_orderstatus',
		order_id: ec_admin_get_value( 'order_id', 'text' ),
		orderstatus_id: ec_admin_get_value( 'orderstatus_id', 'select' ),
	
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_order_management' );
	} } );
	
	return false;
}

function ec_admin_process_order_info( ){
	jQuery( document.getElementById( "ec_admin_order_management" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_edit_order_info',
		order_id: ec_admin_get_value( 'order_id', 'text' ),
		order_weight: ec_admin_get_value( 'order_weight', 'text' ),
		giftcard_id: ec_admin_get_value( 'giftcard_id', 'text' ),
		promo_code: ec_admin_get_value( 'promo_code', 'text' ),
		order_notes: ec_admin_get_value( 'order_notes', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
		ec_admin_hide_loader( 'ec_admin_order_management' );
	} } );
	
	ec_admin_order_details_order_info_show = false;
}

function ec_admin_process_shipping_method( ){
	
	if( ec_admin_order_details_shipping_method_show ){
		jQuery( document.getElementById( "ec_admin_shipping_details" ) ).fadeIn( 'fast' );
		if( ec_admin_get_value( 'use_expedited_shipping', 'select' ) == '1' ){
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_type' ) ).html( 'Expedite Shipping<br />' );
		}else{
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_type' ) ).html( '' );
		}
		if( ec_admin_get_value( 'shipping_carrier', 'text' ) != '' ){
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_carrier' ) ).html( ec_admin_get_value( 'shipping_carrier', 'text' ) + '<br />' );
		}else{
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_carrier' ) ).html( '' );
		}
		if( ec_admin_get_value( 'shipping_method', 'text' ) != '' ){
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_method' ) ).html( ec_admin_get_value( 'shipping_method', 'text' ) + '<br />' );
		}else{
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_method' ) ).html( '' );
		}
		if( ec_admin_get_value( 'tracking_number', 'text' ) != '' ){
			jQuery( document.getElementById( 'ec_admin_order_details_tracking_number' ) ).html( ec_admin_get_value( 'tracking_number', 'text' ) );
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_empty_message' ) ).hide( );
		}else{
			jQuery( document.getElementById( 'ec_admin_order_details_tracking_number' ) ).html( '' );
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_empty_message' ) ).show( );
		}
		var data = {
			action: 'ec_admin_ajax_edit_shipping_method_info',
			order_id: ec_admin_get_value( 'order_id', 'text' ),
			use_expedited_shipping: ec_admin_get_value( 'use_expedited_shipping', 'select' ),
			shipping_method: ec_admin_get_value( 'shipping_method', 'text' ),
			shipping_carrier: ec_admin_get_value( 'shipping_carrier', 'text' ),
			tracking_number: ec_admin_get_value( 'tracking_number', 'text' )
		};
		
		jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_method_form' ) ).hide( );
			jQuery( document.getElementById( 'ec_admin_view_shipping_method' ) ).show( );
			ec_admin_hide_loader( 'ec_admin_shipping_details' );
		} } );
		
		ec_admin_order_details_shipping_method_show = false;
		
	}else{
		jQuery( document.getElementById( 'ec_admin_order_details_shipping_method_form' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_view_shipping_method' ) ).hide( );
		ec_admin_order_details_shipping_method_show = true;
	}
}

function ec_admin_process_customer_notes( ){
	if( ec_admin_order_details_customer_notes_show ){
		jQuery( document.getElementById( "ec_admin_shipping_details" ) ).fadeIn( 'fast' );
		
		jQuery( document.getElementById( 'ec_admin_order_details_customer_notes' ) ).html( ec_admin_get_value( 'order_customer_notes', 'text' ) );
		if( ec_admin_get_value( 'order_customer_notes', 'text' ) != '' ){
			jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_empty_message' ) ).hide( );
		}else{
			jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_empty_message' ) ).show( );
		}
		
		var data = {
			action: 'ec_admin_ajax_edit_customer_notes',
			order_id: ec_admin_get_value( 'order_id', 'text' ),
			order_customer_notes: ec_admin_get_value( 'order_customer_notes', 'text' )
		};
		
		jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
			jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_form' ) ).hide( );
			jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_content' ) ).show( );
			ec_admin_hide_loader( 'ec_admin_shipping_details' );
		} } );
		
		ec_admin_order_details_customer_notes_show = false;
	}else{
		jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_form' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_content' ) ).hide( );
		ec_admin_order_details_customer_notes_show = true;
	}
}

function ec_admin_send_order_shipped_email( ){
	jQuery( document.getElementById( "ec_admin_order_management" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_order_details_send_order_shipped_email',
		order_id: ec_admin_get_value( 'order_id', 'text' ),
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
		ec_admin_hide_loader( 'ec_admin_order_management' );
	} } );
	
	ec_admin_order_details_order_info_show = false;
}

function wp_easycart_open_order_quick_edit( order_id ){
	wp_easycart_admin_clear_order_quick_edit( );
	jQuery( document.getElementById( "ec_admin_order_quick_edit_display_loader" ) ).fadeIn( 'fast' );
	wp_easycart_admin_open_slideout( 'order_quick_edit_box' );
	
	var data = {
		action: 'ec_admin_ajax_get_order_quick_edit',
		order_id: order_id,
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
		var json_data = JSON.parse( data );
		jQuery( document.getElementById( 'ec_qe_order_id' ) ).html( json_data.order.order_id );
		jQuery( document.getElementById( 'ec_qe_order_name' ) ).html( json_data.order.shipping_first_name + " " + json_data.order.shipping_last_name );
		var shipping_address = json_data.order.shipping_first_name + " " + json_data.order.shipping_last_name + "<br>" + json_data.order.shipping_address_line_1 + "<br>";
		if( json_data.order.shipping_address_line_2 ){
			shipping_address += json_data.order.shipping_address_line_2 + "<br>";
		}
		shipping_address += json_data.order.shipping_city + ", " + json_data.order.shipping_state + " " + json_data.order.shipping_zip + "<br>";
		shipping_address += json_data.order.shipping_country;
		if( json_data.order.shipping_phone ){
			shipping_address += "<br>" + json_data.order.shipping_phone;
		}
		var items = "";
		for( var i=0; i<json_data.order.items.length; i++ ){
			if( json_data.order.items[i].title.length > 20 )
				items += json_data.order.items[i].title.substring( 0, 20 ) + "...";
			else
				items += json_data.order.items[i].title;
				
			items += " (" + json_data.order.items[i].model_number + ") x " + json_data.order.items[i].quantity + "<br>";
		}
		jQuery( document.getElementById( 'ec_qe_order_shipping_address' ) ).html( shipping_address );
		jQuery( document.getElementById( 'ec_qe_order_items' ) ).html( items );
		jQuery( document.getElementById( 'ec_qe_order_status' ) ).val( json_data.order.orderstatus_id ).trigger('change');
		jQuery( document.getElementById( 'ec_qe_order_use_expedited_shipping' ) ).val( json_data.order.use_expedited_shipping ).trigger('change');
		jQuery( document.getElementById( 'ec_qe_order_shipping_method' ) ).val( json_data.order.shipping_method );
		jQuery( document.getElementById( 'ec_qe_order_shipping_carrier' ) ).val( json_data.order.shipping_carrier );
		jQuery( document.getElementById( 'ec_qe_order_tracking_number' ) ).val( json_data.order.tracking_number );
		jQuery( document.getElementById( "ec_admin_order_quick_edit_display_loader" ) ).fadeOut( 'fast' );
	} } );
	
	return false;
}

function ec_admin_cancel_order_quick_edit( ){
	wp_easycart_admin_close_slideout( 'order_quick_edit_box' );
}

function ec_admin_save_order_quick_edit( ){
	jQuery( document.getElementById( "ec_admin_order_quick_edit_display_loader" ) ).fadeIn( 'fast' );
	var data = {
		action: 'ec_admin_ajax_update_order_quick_edit',
		order_id: jQuery( document.getElementById( 'ec_qe_order_id' ) ).html( ),
		orderstatus_id: jQuery( document.getElementById( 'ec_qe_order_status' ) ).val( ),
		use_expedited_shipping: jQuery( document.getElementById( 'ec_qe_order_use_expedited_shipping' ) ).val( ),
		shipping_method: jQuery( document.getElementById( 'ec_qe_order_shipping_method' ) ).val( ),
		shipping_carrier: jQuery( document.getElementById( 'ec_qe_order_shipping_carrier' ) ).val( ),
		tracking_number: jQuery( document.getElementById( 'ec_qe_order_tracking_number' ) ).val( ),
		send_tracking_email: jQuery( document.getElementById( 'ec_qe_order_send_tracking_email' ) ).val( )
	};
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
		jQuery( document.getElementById( 'ec_admin_order_list' ) ).find( "[data-id='"+ jQuery( document.getElementById( 'ec_qe_order_id' ) ).html( ) + "']" ).find( 'td:eq(6)' ).html( jQuery( '#ec_qe_order_status > option:selected' ).text( ) );
		ec_admin_hide_loader( 'ec_admin_order_quick_edit_display_loader' );
		wp_easycart_admin_close_slideout( 'order_quick_edit_box' );
	} } );
}

function wp_easycart_admin_clear_order_quick_edit( ){
	jQuery( document.getElementById( 'ec_qe_order_id' ) ).html( '' );
	jQuery( document.getElementById( 'ec_qe_order_name' ) ).html( '' );
	jQuery( document.getElementById( 'ec_qe_order_shipping_address' ) ).html( '' );
	jQuery( document.getElementById( 'ec_qe_order_status' ) ).val( 0 ).trigger('change');
	jQuery( document.getElementById( 'ec_qe_order_shipping_type' ) ).val( 0 ).trigger('change');
	jQuery( document.getElementById( 'ec_qe_order_shipping_method' ) ).val( '' );
	jQuery( document.getElementById( 'ec_qe_order_shipping_carrier' ) ).val( '' );
	jQuery( document.getElementById( 'ec_qe_order_tracking_number' ) ).val( '' );
	jQuery( document.getElementById( 'ec_qe_order_send_tracking_email' ) ).val( 0 ).trigger('change');
}