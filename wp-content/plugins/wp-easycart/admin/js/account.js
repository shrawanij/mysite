// JavaScript Document
function ec_admin_save_account_settings( ){
	jQuery( document.getElementById( "ec_admin_account_settings_loader" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_account_settings',
		ec_option_require_account_terms:  ec_admin_get_value( 'ec_option_require_account_terms', 'checkbox' ),
		ec_option_require_account_address:  ec_admin_get_value( 'ec_option_require_account_address', 'checkbox' ),
		ec_option_require_email_validation:  ec_admin_get_value( 'ec_option_require_email_validation', 'checkbox' ),
		ec_option_enable_recaptcha:  ec_admin_get_value( 'ec_option_enable_recaptcha', 'checkbox' ),
		ec_option_recaptcha_site_key:  ec_admin_get_value( 'ec_option_recaptcha_site_key', 'text' ),
		ec_option_recaptcha_secret_key:  ec_admin_get_value( 'ec_option_recaptcha_secret_key', 'text' ),
		ec_option_show_account_subscriptions_link:  ec_admin_get_value( 'ec_option_show_account_subscriptions_link', 'checkbox' ),
		ec_option_enable_user_notes:  ec_admin_get_value( 'ec_option_enable_user_notes', 'checkbox' ),
		ec_option_show_subscriber_feature:  ec_admin_get_value( 'ec_option_show_subscriber_feature', 'checkbox' ),
		ec_subscriptions_use_first_order_details:  ec_admin_get_value( 'ec_subscriptions_use_first_order_details', 'checkbox' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_account_settings_loader' );
	} } );
	
	return false;
}