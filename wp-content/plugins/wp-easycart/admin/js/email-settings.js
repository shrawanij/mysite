// JavaScript Document


function ec_admin_save_order_receipt_language_setup( ){
	jQuery( document.getElementById( "ec_admin_order_receipt_language_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_order_receipt_language',
		////////////////////////////
		//loop through language array here
		////////////////////////////


	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_order_receipt_language_loader' );
	} } );
	
	
}

function ec_admin_save_customer_account_emails( ){
	jQuery( document.getElementById( "ec_admin_customer_account_email_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_account_email_settings',
		ec_option_password_from_email:  ec_admin_get_value( 'ec_option_password_from_email', 'text' ),
		ec_option_password_use_smtp:  ec_admin_get_value( 'ec_option_password_use_smtp', 'select' ),
		ec_option_password_from_smtp_host:  ec_admin_get_value( 'ec_option_password_from_smtp_host', 'text' ),
		ec_option_password_from_smtp_encryption_type:  ec_admin_get_value( 'ec_option_password_from_smtp_encryption_type', 'select' ),
		ec_option_password_from_smtp_port:  ec_admin_get_value( 'ec_option_password_from_smtp_port', 'text' ),
		ec_option_password_from_smtp_username:  ec_admin_get_value( 'ec_option_password_from_smtp_username', 'text' ),
		ec_option_password_from_smtp_password:  ec_admin_get_value( 'ec_option_password_from_smtp_password', 'text' ),

	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_customer_account_email_loader' );
	} } );
	
	return false;
	
}

function ec_admin_save_order_receipt_setup( ){
	jQuery( document.getElementById( "ec_admin_order_receipt_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_order_receipt_settings',
		ec_option_order_from_email:  ec_admin_get_value( 'ec_option_order_from_email', 'text' ),
		ec_option_order_use_smtp:  ec_admin_get_value( 'ec_option_order_use_smtp', 'select' ),
		ec_option_order_from_smtp_host:  ec_admin_get_value( 'ec_option_order_from_smtp_host', 'text' ),
		ec_option_order_from_smtp_encryption_type:  ec_admin_get_value( 'ec_option_order_from_smtp_encryption_type', 'select' ),
		ec_option_order_from_smtp_port:  ec_admin_get_value( 'ec_option_order_from_smtp_port', 'text' ),
		ec_option_order_from_smtp_username:  ec_admin_get_value( 'ec_option_order_from_smtp_username', 'text' ),
		ec_option_order_from_smtp_password:  ec_admin_get_value( 'ec_option_order_from_smtp_password', 'text' ),
		ec_option_bcc_email_addresses:  ec_admin_get_value( 'ec_option_bcc_email_addresses', 'text' ),
		ec_option_show_email_on_receipt:  ec_admin_get_value( 'ec_option_show_email_on_receipt', 'checkbox' ),
		ec_option_show_image_on_receipt:  ec_admin_get_value( 'ec_option_show_image_on_receipt', 'checkbox' ),
		ec_option_current_order_id:  ec_admin_get_value( 'ec_option_current_order_id', 'text' ),
		ec_option_email_logo:  ec_admin_get_value( 'ec_option_email_logo', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_order_receipt_loader' );
	} } );
	
	return false;
	
}

function ec_admin_save_email_settings( ){
	jQuery( document.getElementById( "ec_admin_email_settings_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_email_settings',
		ec_option_use_wp_mail:  ec_admin_get_value( 'ec_option_use_wp_mail', 'select' ),
		ec_option_send_signup_email:  ec_admin_get_value( 'ec_option_send_signup_email', 'checkbox' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_email_settings_loader' );
	} } );
	
	return false;
	
}

function wpeasycart_update_use_wp_mail( ){
	if( jQuery( document.getElementById( 'ec_option_use_wp_mail' ) ).val( ) == "0" ){
		
		jQuery( document.getElementById( 'ec_option_order_use_smtp_choice' ) ).show( );
		jQuery( document.getElementById( 'ec_option_order_use_smtp_choice' ) ).val( 0 );
		wpeasycart_update_order_use_smtp( );
		
		jQuery( document.getElementById( 'ec_option_password_use_smtp_choice' ) ).show( );
		jQuery( document.getElementById( 'ec_option_password_use_smtp_choice' ) ).val( 0 );
		wpeasycart_update_password_use_smtp( );
	
	}else{
		
		jQuery( document.getElementById( 'ec_option_order_use_smtp_choice' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_order_use_smtp_choice' ) ).val( 0 );
		wpeasycart_update_order_use_smtp( );
		
		jQuery( document.getElementById( 'ec_option_password_use_smtp_choice' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_password_use_smtp_choice' ) ).val( 0 );
		wpeasycart_update_password_use_smtp( );
	
	}
}

function wpeasycart_update_order_use_smtp( ){
	if( jQuery( document.getElementById( 'ec_option_order_use_smtp' ) ).val( ) == "0" ){
		jQuery( document.getElementById( 'ec_option_order_from_smtp_host_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_encryption_type_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_port_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_username_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_password_display' ) ).hide( );
	}else{
		jQuery( document.getElementById( 'ec_option_order_from_smtp_host_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_encryption_type_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_port_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_username_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_password_display' ) ).show( );
	}
}

function wpeasycart_update_password_use_smtp( ){
	if( jQuery( document.getElementById( 'ec_option_password_use_smtp' ) ).val( ) == "0" ){
		jQuery( document.getElementById( 'ec_option_password_from_smtp_host_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_encryption_type_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_port_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_username_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_password_display' ) ).hide( );
	}else{
		jQuery( document.getElementById( 'ec_option_password_from_smtp_host_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_encryption_type_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_port_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_username_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_password_display' ) ).show( );
	}
}

function ec_admin_remove_email_logo( ){
	jQuery( document.getElementById( 'email_logo_image' ) ).attr( 'src', '' );
	jQuery( document.getElementById( 'ec_option_email_logo' ) ).val( '' );
	jQuery( document.getElementById( 'ec_admin_email_logo_remove_link' ) ).hide( );
}

jQuery( document ).ready( function( $ ){
	
	var custom_uploader;
	
	jQuery( '#upload_logo_button' ).click( function( e ){
 
		e.preventDefault( );
		
		if( custom_uploader ){
			custom_uploader.open( );
			return;
		}

		custom_uploader = wp.media.frames.file_frame = wp.media( {
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		} );
 
		custom_uploader.on( 'select', function( ){
			attachment = custom_uploader.state( ).get( 'selection' ).first( ).toJSON( );
			jQuery( '#email_logo_image' ).attr( "src", attachment.url );
			jQuery( '#ec_option_email_logo' ).val( attachment.url );
			jQuery( document.getElementById( 'ec_admin_email_logo_remove_link' ) ).show( );
		} );
 
		custom_uploader.open( );
 
	});
} );