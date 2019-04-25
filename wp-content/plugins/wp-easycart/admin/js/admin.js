jQuery( document ).ready( function( ){
	jQuery( 'select.select2-basic' ).select2( );
	jQuery( '.ec_color_block_input').wpColorPicker( );
	jQuery( '.ec_admin_expand_section' ).on( 'click', function( ){
		var section_id = jQuery( this ).attr( 'data-section' );
		if( jQuery( document.getElementById( section_id ) ).is( ':visible' ) ){
			jQuery( document.getElementById( section_id ) ).hide( );
			jQuery( this ).html( '<div class="dashicons-before dashicons-arrow-down-alt2"></div>' );
		}else{
			jQuery( document.getElementById( section_id ) ).show( );
			jQuery( this ).html( '<div class="dashicons-before dashicons-arrow-up-alt2"></div>' );
		}
	} );
	jQuery( '.ec_admin_mobile_menu' ).prependTo( document.body );
	
	/* PROCESSING CLICK ACTION */
	jQuery( '.ec_admin_process_click' ).on( 'click', function( ){
		jQuery( this ).html( 'PROCESSING...' );
		jQuery( this ).attr( 'disabled', 'disabled' );
	} );
	
	/* PREVENT DOUBLE FORM SUBMISSION */
	jQuery( 'form' ).on( 'submit', function( e ){
		var $form = jQuery( this );
	
		if( $form.data( 'submitted' ) === true ){
			e.preventDefault( );
		}else{
			$form.data( 'submitted', true );
		}
	} );
} );

/* Sort Functions */
function save_sort_order( table ){
	var curr_page = 0;
	if( jQuery( document.getElementById( 'pagenum' ) ).length )
		curr_page = jQuery( document.getElementById( 'pagenum' ) ).val( );
	var page_length = 25;
	if( jQuery( document.getElementById( 'perpage' ) ).length )
		page_length = jQuery( document.getElementById( 'perpage' ) ).val( );
	var rows = jQuery( 'table#' + table + ' tbody tr' );
	var ids = Array( );
	var id=0;
	var start_sort = curr_page * page_length;
	for( var i=0; i<rows.length; i++ ){
		ids.push( { id:jQuery( rows[i] ).attr( 'data-id' ), order: Number( start_sort + i ) } );
	}
	
	if( table == 'ec_optionitem_table' ){
		jQuery( document.getElementById( "ec_admin_table_display_loader" ) ).fadeIn( 'fast' );
		var data = {
			option_id: jQuery( document.getElementById( 'option_id' ) ).val( ),
			sort_order: ids,
			action: 'ec_admin_ajax_save_optionitem_order'
		};
		jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
			ec_admin_hide_loader( 'ec_admin_table_display_loader' );
		} } );
	
	}else if( table == 'ec_admin_category_list' ){
		jQuery( document.getElementById( "ec_admin_table_display_loader" ) ).fadeIn( 'fast' );
		var data = {
			parent_id: jQuery( document.getElementById( 'parent_id' ) ).val( ),
			sort_order: ids,
			action: 'ec_admin_ajax_save_category_order'
		};
		jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
			ec_admin_hide_loader( 'ec_admin_table_display_loader' );
		} } );
	}
}

/* Slidout Functions */
function wp_easycart_admin_open_slideout( id ){
	jQuery( document.getElementById( id ) ).fadeIn( );
	setTimeout( function( ){
		jQuery( document.getElementById( id ) ).find( '.ec_admin_slideout_container_content' ).animate( {"right": '+=600'}, 300 );
	}, 200 );
}

function wp_easycart_admin_close_slideout( id ){
	jQuery( document.getElementById( id ) ).find( '.ec_admin_slideout_container_content' ).animate( {"right": '-=600'}, 300 );
	setTimeout( function( ){
		jQuery( document.getElementById( id ) ).fadeOut( );
	}, 200 );
}

/* NEWSLETTER */
function wp_easycart_maybe_load_newsletter( ){
	var menu_location = jQuery( document.getElementById( 'toplevel_page_wp-easycart-dashboard' ) ).offset( ).top - 261;
	if( menu_location < 0 )
		menu_location = 0;
	if( wp_easycart_admin_vars.ec_option_newsletter_done == '0' ){
		var content = '<div id="wpeasycart_newsletter_popup" class="wpeasycart_newsletter_popup" style="top:' + menu_location + 'px"><div class="wpeasycart_newsletter_popup_content"><div class="wpeasycart_newsletter_popup_close" onclick="wpeasycart_close_newsletter_popup( );"><div class="dashicons-before dashicons-dismiss"></div></div><h3>Congratulations!</h3><p>You\'ve just installed WP EasyCart! Start by entering the administrator email address where you would like to receive alerts for your shopping system:</p><div style="padding: 0 5px 0 15px;"><form target="_new" method="post" class="wpeasycart-newsletter-wrapper" action="https://support.wpeasycart.com/licensing/activatetrial.php"><input class="text" id="wpeasycart_newsletter_customeremail" type="text" name="wpeasycart_newsletter_customeremail" value="" placeholder="Enter your email" tabindex="500"><input name="submit" type="submit" value="Get Notifications" tabindex="501" onclick="wpeasycart_submit_newsletter( ); return false;"><div style="padding:5px; font-size:10px;"><input type="checkbox" id="wpeasycart_join_newsletter" value="1" checked=""><span style="font-size: 10px;">Also join our WordPress eCommerce email list to receive eCommerce updates and WP EasyCart news.</span></div></form></div></div><div class="wpeasycart_newsletter_arrow"><div class="wpeasycart_newsletter_arrow_inner"></div></div></div>';
		jQuery( 'body' ).append( content );
	}
}

function wpeasycart_close_newsletter_popup( ){
	var data = {
		action: 'ec_admin_ajax_popup_newsletter_close'
	};
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ } } );
	jQuery( document.getElementById( 'wpeasycart_newsletter_popup' ) ).remove( );
}

function wpeasycart_submit_newsletter( ){
	var wpeasycart_newsletter_customeremail = jQuery( document.getElementById( 'wpeasycart_newsletter_customeremail' ) ).val( );
	var wpeasycart_join_newsletter = 0;
	if( jQuery( document.getElementById( 'wpeasycart_join_newsletter' ) ).is( ':checked' ) )
		wpeasycart_join_newsletter = 1;
	var data = {
		action: 'ec_admin_ajax_popup_newsletter_close',
		wpeasycart_newsletter_customeremail: wpeasycart_newsletter_customeremail,
		wpeasycart_join_newsletter: wpeasycart_join_newsletter
	};
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ } } );
	jQuery( document.getElementById( 'wpeasycart_newsletter_popup' ) ).remove( );
}

/* HELP VIDEOS */
function wp_easycart_admin_open_video_help( ){
	jQuery( '.ec_admin_help_video_container' ).show( );
}
function wp_easycart_admin_close_video_help( ){
	jQuery( '.ec_admin_help_video_container' ).hide( );
}

/* IMPORTER */
function ec_admin_importer_open_close(id) {
    jQuery(document.getElementById(id)).fadeToggle("fast");
}

/* bulk action delay for 5 seconds to prevent double clicks */
function ec_bulk_disable() {
  button = document.getElementById("doaction");
  button.setAttribute("disabled","disabled");
  button.value="Processing...";
  setTimeout(ec_bulk_enable, 3000);
}

function ec_bulk_enable() {
  button.disabled = false;
  button.value="Apply";
}

/* Mobile Menu Functions */
function ec_admin_open_mobile_menu( ){
	jQuery( document.getElementById( 'ec_admin_mobile_menu_main' ) ).show( ).animate( {left:0}, 200 );
}
function ec_admin_hide_mobile_menu( ){
	jQuery( document.getElementById( 'ec_admin_mobile_menu_main' ) ).animate( {left:'-100%'}, 200 );
}
function ec_admin_show_mobile_submenu( submenu ){
	jQuery( document.getElementById( 'ec_admin_mobile_menu_' + submenu ) ).show( ).animate( {left:0}, 200 );
}
function ec_admin_hide_mobile_submenu( submenu ){
	jQuery( document.getElementById( 'ec_admin_mobile_menu_' + submenu ) ).animate( {left:'-100%'}, 200 );
}

/* GENERAL FUNCTIONS */
function ec_admin_get_value( item_id, type ){
	var item_value = 0;
	if( type == "checkbox" ){
		if( jQuery( document.getElementById( item_id ) ).is(':checked') )
			item_value = 1;
	}else{
		item_value = jQuery( document.getElementById( item_id ) ).val( );
	}
	return item_value;
}

function ec_admin_hide_loader( loader_id ){
	jQuery( document.getElementById( loader_id ) ).delay( 1200 ).fadeOut( 'slow' );
	jQuery( "#" + loader_id + " > .ec_admin_loader_animation" ).hide( );
	jQuery( "#" + loader_id + " > .ec_admin_loader_loaded" ).fadeIn( 'fast' );
	// After Animation, Reset
	setTimeout( function( ){
		jQuery( "#" + loader_id + " > .ec_admin_loader_animation" ).show( );
		jQuery( "#" + loader_id + " > .ec_admin_loader_loaded" ).hide( ); 
	}, 2000 );
}

/* MENU FUNCTIONS */
function ec_admin_show_products_submenu(currentElement ){
	
	if( !jQuery( document.getElementById( 'ec_admin_products_submenu' ) ).hasClass( 'ec_admin_left_submenu_open' ) ){
		jQuery( '.ec_admin_left_submenu_open' ).slideUp( ).removeClass( 'ec_admin_left_submenu_open' );
		jQuery( document.getElementById( 'ec_admin_products_submenu' ) ).slideDown( ).addClass( 'ec_admin_left_submenu_open' );
		jQuery( 'div').removeClass( 'ec_admin_left_nav_selected' );
		jQuery( currentElement).addClass( 'ec_admin_left_nav_selected' );
		jQuery( document.getElementById( 'toplevel_page_wp-easycart-dashboard' ) ).find( 'ul > li' ).each( function( ){
			jQuery( this ).removeClass( 'current' );
			if( jQuery( this ).find( 'a' ).html( ) == "Products" ){
				jQuery( this ).addClass( 'current' );
			}
		} );
		jQuery (document.getElementById('ec_admin_products_submenu_item')).addClass('ec_admin_left_nav_selected');
	}
}

function ec_admin_show_orders_submenu(currentElement ){
	
	if( !jQuery( document.getElementById( 'ec_admin_orders_submenu' ) ).hasClass( 'ec_admin_left_submenu_open' ) ){
		jQuery( '.ec_admin_left_submenu_open' ).slideUp( ).removeClass( 'ec_admin_left_submenu_open' );
		jQuery( document.getElementById( 'ec_admin_orders_submenu' ) ).slideDown( ).addClass( 'ec_admin_left_submenu_open' );
		jQuery( 'div').removeClass( 'ec_admin_left_nav_selected' );
		jQuery( currentElement).addClass( 'ec_admin_left_nav_selected' );
		jQuery( document.getElementById( 'toplevel_page_wp-easycart-dashboard' ) ).find( 'ul > li' ).each( function( ){
			jQuery( this ).removeClass( 'current' );
			if( jQuery( this ).find( 'a' ).html( ) == "Orders" ){
				jQuery( this ).addClass( 'current' );
			}
		} );
		jQuery (document.getElementById('ec_admin_orders_submenu_item')).addClass('ec_admin_left_nav_selected');
	}
}

function ec_admin_show_users_submenu(currentElement ){
	
	if( !jQuery( document.getElementById( 'ec_admin_users_submenu' ) ).hasClass( 'ec_admin_left_submenu_open' ) ){
		jQuery( '.ec_admin_left_submenu_open' ).slideUp( ).removeClass( 'ec_admin_left_submenu_open' );
		jQuery( document.getElementById( 'ec_admin_users_submenu' ) ).slideDown( ).addClass( 'ec_admin_left_submenu_open' );
		jQuery( 'div').removeClass( 'ec_admin_left_nav_selected' );
		jQuery( currentElement).addClass( 'ec_admin_left_nav_selected' );
		jQuery( document.getElementById( 'toplevel_page_wp-easycart-dashboard' ) ).find( 'ul > li' ).each( function( ){
			jQuery( this ).removeClass( 'current' );
			if( jQuery( this ).find( 'a' ).html( ) == "Users" ){
				jQuery( this ).addClass( 'current' );
			}
		} );
		jQuery (document.getElementById('ec_admin_accounts_submenu_item')).addClass('ec_admin_left_nav_selected');
	}
}

function ec_admin_show_rates_submenu(currentElement ){
	
	if( !jQuery( document.getElementById( 'ec_admin_rates_submenu' ) ).hasClass( 'ec_admin_left_submenu_open' ) ){
		jQuery( '.ec_admin_left_submenu_open' ).slideUp( ).removeClass( 'ec_admin_left_submenu_open' );
		jQuery( document.getElementById( 'ec_admin_rates_submenu' ) ).slideDown( ).addClass( 'ec_admin_left_submenu_open' );
		jQuery( 'div').removeClass( 'ec_admin_left_nav_selected' );
		jQuery( currentElement).addClass( 'ec_admin_left_nav_selected' );
		jQuery( document.getElementById( 'toplevel_page_wp-easycart-dashboard' ) ).find( 'ul > li' ).each( function( ){
			jQuery( this ).removeClass( 'current' );
			if( jQuery( this ).find( 'a' ).html( ) == "Rates" ){
				jQuery( this ).addClass( 'current' );
			}
		} );
		jQuery (document.getElementById('ec_admin_giftcards_submenu_item')).addClass('ec_admin_left_nav_selected');
	}
}

function ec_admin_show_registration_submenu( currentElement){
	jQuery( 'div').removeClass( 'ec_admin_left_nav_selected' );
	jQuery( currentElement).addClass( 'ec_admin_left_nav_selected' );
	jQuery( '.ec_admin_left_submenu_open' ).slideUp( ).removeClass( 'ec_admin_left_submenu_open' );

}

function ec_admin_update_submenu_item_display( hash ){
	if( hash != "" ){
		hash = hash.substring( 1 ); 
		jQuery( '.ec_admin_left_nav_subitem' ).removeClass( 'ec_admin_left_nav_selected' );
		jQuery( document.getElementById( 'ec_admin_' + hash + '_submenu_item' ) ).addClass( 'ec_admin_left_nav_selected' );
	}
}

function ec_admin_show_hide_update( id, value, show_id ){
	if( jQuery( document.getElementById( id ) ).is( ':checkbox' ) ){
		if( jQuery( document.getElementById( id ) ).is( ':checked' ) && value == '1' ){
			jQuery( document.getElementById( show_id ) ).show( );
		}else if( !jQuery( document.getElementById( id ) ).is( ':checked' ) && value == '0' ){
			jQuery( document.getElementById( show_id ) ).show( );
		}else{
			jQuery( document.getElementById( show_id ) ).hide( );
		}
	}else if( jQuery( document.getElementById( id ) ).is( 'select' ) ){
		if( jQuery( document.getElementById( id ) ).val( ) == value ){
			jQuery( document.getElementById( show_id ) ).show( );
		}else{
			jQuery( document.getElementById( show_id ) ).hide( );
		}
	}
}

function ec_admin_download_upload( field ){
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id;
	var set_to_post_id;

	if( file_frame ){
		file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
		file_frame.open( );
		return;
	}else{
		wp.media.model.settings.post.id = set_to_post_id;
	}
	
	file_frame = wp.media.frames.file_frame = wp.media( {
		title: 'Select File',
		button: {
			text: 'Use File',
		},
		multiple: false
	} );
	
	file_frame.uploader.options.uploader.params.is_wpec_download = '1';

	file_frame.on( 'select', function() {
		attachment = file_frame.state( ).get( 'selection' ).first( ).toJSON( );
		jQuery( document.getElementById( field ) ).val( attachment.url );
		if( jQuery( document.getElementById( field + '_preview'  ) ).length )
			document.getElementById( field + '_preview'  ).src = attachment.url;
		wp.media.model.settings.post.id = wp_media_post_id;
	});
	
	file_frame.open( );
}

function ec_admin_file_upload( field ){
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id;
	var set_to_post_id;

	if( file_frame ){
		file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
		file_frame.open( );
		return;
	}else{
		wp.media.model.settings.post.id = set_to_post_id;
	}
	
	file_frame = wp.media.frames.file_frame = wp.media( {
		title: 'Select File',
		button:{
			text: 'Use File',
		},
		multiple: false	// Set to true to allow multiple files to be selected
	} );
	
	file_frame.on( 'select', function( ){
		attachment = file_frame.state( ).get( 'selection' ).first( ).toJSON( );
		jQuery( document.getElementById( field ) ).val( attachment.url );
		if( jQuery( document.getElementById( field + '_preview'  ) ).length )
			document.getElementById( field + '_preview'  ).src = attachment.url;
		wp.media.model.settings.post.id = wp_media_post_id;
	} );
	
	file_frame.open();	
}

function ec_admin_image_upload( field ){
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id;
	var set_to_post_id;

	if( file_frame ){
		file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
		file_frame.open( );
		return;
	}else{
		wp.media.model.settings.post.id = set_to_post_id;
	}
	
	file_frame = wp.media.frames.file_frame = wp.media( {
		title: 'Select Image',
		button:{
			text: 'Use Image',
		},
		multiple: false
	});
	
	file_frame.on( 'select', function( ){
		attachment = file_frame.state().get( 'selection' ).first( ).toJSON( );
		jQuery( document.getElementById( field ) ).val( attachment.url );
		if( jQuery( document.getElementById( field + '_preview'  ) ).length )
			document.getElementById( field + '_preview'  ).src = attachment.url;
		if( jQuery( document.getElementById( field + '_id'  ) ).length )
			jQuery( document.getElementById( field + '_id'  ) ).val( attachment.id );
		wp.media.model.settings.post.id = wp_media_post_id;
	} );
		
	file_frame.open();
	
	jQuery( '#ec_admin_row_' + field + '_preview > button' ).show( );
		
}

function ec_admin_import_file_upload( field, import_button, status_field ){
	
	jQuery( document.getElementById(status_field)).fadeOut("fast");
	
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id;
	var set_to_post_id;

	if( file_frame ){
		file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
		file_frame.open( );
		return;
	}else{
		wp.media.model.settings.post.id = set_to_post_id;
	}
	
	file_frame = wp.media.frames.file_frame = wp.media( {
		title: 'Select Import File',
		button:{
			text: 'Use File',
		},
		multiple: false
	} );
	
	file_frame.on( 'select', function( ){
		attachment = file_frame.state( ).get( 'selection' ).first( ).toJSON( );
		jQuery( document.getElementById( field ) ).val( attachment.url );
		jQuery( document.getElementById( import_button ) ).fadeIn("fast" );
		jQuery( document.getElementById( status_field ) ).fadeOut( "fast" );
		wp.media.model.settings.post.id = wp_media_post_id;
	} );
	
	file_frame.open( );	
}

function ec_admin_delete_image( id ){
	jQuery( document.getElementById( id ) ).val( '' );
	document.getElementById( id + '_preview' ).src = '';
	jQuery( '#ec_admin_row_' + id + '_preview > button' ).hide( );
}

function show_pro_required( custom_view ){
	custom_view = custom_view || 0;
	jQuery( document.body ).addClass( 'ec_admin_upsell_noscroll' );
	jQuery( document.getElementById( 'ec_admin_upsell_popup' ) ).show( );
	jQuery( document.getElementById( 'wp_easycart_trial_upsell' ) ).show( );
	jQuery( '.ec_admin_upsell_popup_extras' ).hide( );
	if( custom_view ){
		jQuery( document.getElementById( 'ec_admin_upsell_popup_' + custom_view ) ).show( );
		jQuery( document.getElementById( 'wp_easycart_trial_upsell' ) ).hide( );
	}
	return false;
}

function hide_pro_required( ){
	jQuery( document.body ).removeClass( 'ec_admin_upsell_noscroll' );
	jQuery( document.getElementById( 'ec_admin_upsell_popup' ) ).hide( );
}

/* Wizard */
function wp_easycart_update_wizard_update_tax( ){
	wp_easycart_update_wizard_locale( );
	wp_easycart_update_wizard_show_tax( );
}

function wp_easycart_update_wizard_show_tax( ){
	var val = jQuery( document.getElementById( 'wp_easycart_locale' ) ).val( );
	if( jQuery( document.getElementById( 'wp_easycart_sales_tax' ) ).is( ':checked' ) && jQuery( '.wp_easycart_wizard_tax_' + val ).length ){
		jQuery( document.getElementById( 'wp_easycart_wizard_tax_info' ) ).show( );
	}else{
		jQuery( document.getElementById( 'wp_easycart_wizard_tax_info' ) ).hide( );
	}
}

function wp_easycart_update_wizard_locale( ){
	jQuery( '.wp_easycart_wizard_tax_row' ).hide( );
	var val = jQuery( document.getElementById( 'wp_easycart_locale' ) ).val( );
	jQuery( '.wp_easycart_wizard_tax_' + val ).show( );
}

function wp_easycart_wizard_use_paypal( ){
	if( jQuery( document.getElementById( 'wp_easycart_paypal_standard' ) ).is( ':checked' ) ){
		jQuery( document.getElementById( 'wp_easycart_paypal_standard' ) ).prop( 'checked', false );
	}else{
		jQuery( document.getElementById( 'wp_easycart_paypal_standard' ) ).prop( 'checked', true );
	}
}

function wp_easycart_wizard_use_stripe( ){
	if( !jQuery( document.getElementById( 'wp_easycart_use_stripe' ) ).is( ':checked' ) ){
		jQuery( document.getElementById( 'wp_easycart_use_stripe' ) ).prop( 'checked', true );
		jQuery( document.getElementById( 'wp_easycart_use_square' ) ).prop( 'checked', false );
		jQuery( document.getElementById( 'use_stripe_content' ) ).show( );
		jQuery( document.getElementById( 'use_square_content' ) ).hide( );
		return true;
	}else{
		jQuery( document.getElementById( 'wp_easycart_use_stripe' ) ).prop( 'checked', false );
		jQuery( document.getElementById( 'use_stripe_content' ) ).hide( );
		return false;
	}
}

function wp_easycart_wizard_use_square( ){
	if( !jQuery( document.getElementById( 'wp_easycart_use_square' ) ).is( ':checked' ) ){
		jQuery( document.getElementById( 'wp_easycart_use_stripe' ) ).prop( 'checked', false );
		jQuery( document.getElementById( 'wp_easycart_use_square' ) ).prop( 'checked', true );
		jQuery( document.getElementById( 'use_square_content' ) ).show( );
		jQuery( document.getElementById( 'use_stripe_content' ) ).hide( );
		return true;
	}else{
		jQuery( document.getElementById( 'wp_easycart_use_square' ) ).prop( 'checked', false );
		jQuery( document.getElementById( 'use_square_content' ) ).hide( );
		return false;
	}
}

function wp_easycart_allow_tracking( ){
	var data = {
		action: 'ec_admin_ajax_allow_tracking'
	};
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ } } );
}

function wp_easycart_deny_tracking( ){
	var data = {
		action: 'ec_admin_ajax_deny_tracking'
	};
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ } } );
}

function wp_easycart_admin_close_review( ){
	jQuery( '.wp-easycart-admin-review-us-box' ).fadeOut( 'slow' );
	var data = {
		action: 'ec_admin_ajax_close_review_us'
	};
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ } } );
}

function ec_admin_install_demo_data( ){
	
	jQuery( document.getElementById( "ec_admin_demo_data_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_install_demo_data'
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		// Start Saved Animation
		jQuery( document.getElementById( "ec_admin_demo_data_loader" ) ).delay( 1200 ).fadeOut( 'slow' );
		jQuery( "#ec_admin_demo_data_loader > .ec_admin_loader_animation" ).hide( );
		jQuery( "#ec_admin_demo_data_loader > .ec_admin_loader_loaded" ).fadeIn( 'fast' );
		// After Animation, Reset
		setTimeout( function( ){
			jQuery( "#ec_admin_demo_data_loader > .ec_admin_loader_animation" ).show( );
			jQuery( "#ec_admin_demo_data_loader > .ec_admin_loader_loaded" ).hide( );
			jQuery( "#install_demo_data" ).hide( );
			jQuery( "#uninstall_demo_data" ).show( );
		}, 1200 );
		ec_admin_hide_loader( 'ec_admin_demo_data_loader' );
		
		if( jQuery( document.getElementById( 'easycart_wizard_demo_data' ) ).length ){
			jQuery( document.getElementById( 'easycart_wizard_demo_data' ) ).hide( );
			jQuery( document.getElementById( 'easycart_wizard_demo_data_done' ) ).show( );
		}
	} } );
	
	return false;
	
}

function ec_admin_uninstall_demo_data( ){
	
	jQuery( document.getElementById( "ec_admin_uninstall_demo_data_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_uninstall_demo_data'
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		setTimeout( function( ){
			jQuery( "#install_demo_data" ).show( );
			jQuery( "#uninstall_demo_data" ).hide( );
		}, 1200 );
		ec_admin_hide_loader( 'ec_admin_uninstall_demo_data_loader' );
	} } );
	
	return false;
	
}

function wp_easycart_open_quick_edit( type, id ){
	if( type == 'order' ){
		wp_easycart_open_order_quick_edit( id );
	}
}