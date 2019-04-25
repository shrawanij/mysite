// JavaScript Document

function ec_admin_save_design_template_settings( ){
	jQuery( document.getElementById( "ec_admin_design_template_settings_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_design_template_settings',
		ec_option_base_theme: ec_admin_get_value( 'ec_option_base_theme', 'select' ),
		ec_option_base_layout: ec_admin_get_value( 'ec_option_base_layout', 'select' ),
		ec_option_caching_on: ec_admin_get_value( 'ec_option_caching_on', 'select' ),
		ec_option_cache_update_period: ec_admin_get_value( 'ec_option_cache_update_period', 'select' ),
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_design_template_settings_loader' );
	} } );
	
	return false;
	
}

function ec_admin_save_design_settings( ){
	jQuery( document.getElementById( "ec_admin_design_settings_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_design_settings',
		ec_option_no_rounded_corners: ec_admin_get_value( 'ec_option_no_rounded_corners', 'checkbox' ),
		ec_option_font_main: ec_admin_get_value( 'ec_option_font_main', 'select' ),
		ec_option_hide_live_editor: ec_admin_get_value( 'ec_option_hide_live_editor', 'checkbox' ),
		ec_option_use_custom_post_theme_template: ec_admin_get_value( 'ec_option_use_custom_post_theme_template', 'checkbox' ),
		ec_option_match_store_meta: ec_admin_get_value( 'ec_option_match_store_meta', 'checkbox' ),
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_design_settings_loader' );
	} } );
	
	return false;
	
}
function ec_admin_save_custom_css( ){
	jQuery( document.getElementById( "ec_admin_custom_css" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_custom_css',
		ec_option_custom_css: ec_admin_get_value( 'ec_option_custom_css', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_custom_css' );
	} } );
	
	return false;
	
}

function ec_admin_save_store_colors( ){
	jQuery( document.getElementById( "ec_admin_design_store_colors" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_design_colors',
		ec_option_details_main_color: ec_admin_get_value( 'ec_option_details_main_color', 'text' ),
		ec_option_details_second_color: ec_admin_get_value( 'ec_option_details_second_color', 'text' ),
		ec_option_use_dark_bg: ec_admin_get_value( 'ec_option_use_dark_bg', 'select' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_design_store_colors' );
	} } );
	
	return false;
	
}

function ec_admin_save_cart_design_options( ){
	jQuery( document.getElementById( "ec_admin_cart_design_options" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_cart_design_options',
		ec_option_cart_columns_desktop: ec_admin_get_value( 'ec_option_cart_columns_desktop', 'select' ),
		ec_option_cart_columns_laptop: ec_admin_get_value( 'ec_option_cart_columns_laptop', 'select' ),
		ec_option_cart_columns_tablet_wide: ec_admin_get_value( 'ec_option_cart_columns_tablet_wide', 'select' ),
		ec_option_cart_columns_tablet: ec_admin_get_value( 'ec_option_cart_columns_tablet', 'select' ),
		ec_option_cart_columns_smartphone: ec_admin_get_value( 'ec_option_cart_columns_smartphone', 'select' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_cart_design_options' );
	} } );
	
	return false;
	
}

function ec_admin_save_product_details_design_options( ){
	jQuery( document.getElementById( "ec_admin_product_details_design_options" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_details_design_options',
		ec_option_details_columns_desktop: ec_admin_get_value( 'ec_option_details_columns_desktop', 'select' ),
		ec_option_details_columns_laptop: ec_admin_get_value( 'ec_option_details_columns_laptop', 'select' ),
		ec_option_details_columns_tablet_wide: ec_admin_get_value( 'ec_option_details_columns_tablet_wide', 'select' ),
		ec_option_details_columns_tablet: ec_admin_get_value( 'ec_option_details_columns_tablet', 'select' ),
		ec_option_details_columns_smartphone: ec_admin_get_value( 'ec_option_details_columns_smartphone', 'select' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_product_details_design_options' );
	} } );
	
	return false;
	
}

function ec_admin_save_product_design_options( ){
	jQuery( document.getElementById( "ec_admin_product_design_options" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_product_design_options',
		ec_option_default_product_type: ec_admin_get_value( 'ec_option_default_product_type', 'select' ),
		ec_option_default_product_image_hover_type: ec_admin_get_value( 'ec_option_default_product_image_hover_type', 'select' ),
		ec_option_default_product_image_effect_type: ec_admin_get_value( 'ec_option_default_product_image_effect_type', 'select' ),
		ec_option_default_quick_view: ec_admin_get_value( 'ec_option_default_quick_view', 'select' ),
		ec_option_default_dynamic_sizing: ec_admin_get_value( 'ec_option_default_dynamic_sizing', 'select' ),		
		ec_option_default_desktop_columns: ec_admin_get_value( 'ec_option_default_desktop_columns', 'select' ),
		ec_option_default_desktop_image_height: ec_admin_get_value( 'ec_option_default_desktop_image_height', 'select' ),
		ec_option_default_laptop_columns: ec_admin_get_value( 'ec_option_default_laptop_columns', 'select' ),
		ec_option_default_laptop_image_height: ec_admin_get_value( 'ec_option_default_laptop_image_height', 'select' ),
		ec_option_default_tablet_wide_columns: ec_admin_get_value( 'ec_option_default_tablet_wide_columns', 'select' ),
		ec_option_default_tablet_wide_image_height: ec_admin_get_value( 'ec_option_default_tablet_wide_image_height', 'select' ),
		ec_option_default_tablet_columns: ec_admin_get_value( 'ec_option_default_tablet_columns', 'select' ),
		ec_option_default_tablet_image_height: ec_admin_get_value( 'ec_option_default_tablet_image_height', 'select' ),
		ec_option_default_smartphone_columns: ec_admin_get_value( 'ec_option_default_smartphone_columns', 'select' ),
		ec_option_default_smartphone_image_height: ec_admin_get_value( 'ec_option_default_smartphone_image_height', 'select' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_product_design_options' );
	} } );
	
	return false;
	
}


