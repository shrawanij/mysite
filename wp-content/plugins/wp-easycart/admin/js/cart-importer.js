// JavaScript Document



function ec_admin_save_woo_importer( ){
	jQuery( document.getElementById( "ec_admin_woo_importer" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_woo_importer',

	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_woo_importer' );
	} } );
	
	return false;
	
}

function ec_admin_save_oscommerce_importer( ){
	jQuery( document.getElementById( "ec_admin_oscommerce_importer" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_save_oscommerce_importer',

	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_oscommerce_importer' );
	} } );
	
	return false;
	
}