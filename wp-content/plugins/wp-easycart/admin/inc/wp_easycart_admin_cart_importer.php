<?php
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'wp_easycart_admin_cart_importer' ) ) :

final class wp_easycart_admin_cart_importer{
	
	protected static $_instance = null;
	
	private $wpdb;
	
	public $oscommerce_import_file;
	public $woo_import_file;
	public $square_import_file;
	public $settings_file;
	
	public static function instance( ) {
		
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self(  );
		}
		return self::$_instance;
	
	}
		
	public function __construct( ){
		// Keep reference to wpdb
		global $wpdb;
		$this->wpdb =& $wpdb;
		
		// Setup File Names 
		$this->oscommerce_import_file	 	= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/cart-importer/oscommerce-import.php';
		$this->woo_import_file	 			= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/cart-importer/woo-import.php';
		$this->square_import_file	 			= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/cart-importer/square-import.php';
		$this->settings_file		 		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/cart-importer/settings.php';
		
		// Actions
		add_action( 'wpeasycart_admin_cart_importer', array( $this, 'load_woo_importer' ) );
		add_action( 'wpeasycart_admin_cart_importer', array( $this, 'load_oscommerce_importer' ) );
		add_action( 'wpeasycart_admin_cart_importer', array( $this, 'load_square_importer' ) );
		add_action( 'wp_easycart_process_post_form_action', array( $this, 'process_square_import' ) );
		add_action( 'init', array( $this, 'save_settings' ) );
	}
	
	public function load_cart_importer( ){
		include( $this->settings_file );
	}
	
	public function load_woo_importer( ){
		include( $this->woo_import_file );
	}
	public function load_oscommerce_importer( ){
		include( $this->oscommerce_import_file );
	}

	public function load_square_importer( ){
		include( $this->square_import_file );
	}
	
	public function process_square_import( ){
		if( $_POST['ec_admin_form_action'] == 'import-square-products' ){
			$square = new ec_square( );
			$response = $square->get_catalog( );
			
			while( $response ){
				
				foreach( $response->objects as $object ){
					if( $object->type == "CATEGORY" ){
						$square->insert_category( $object );
						
					}else if( $object->type == "ITEM" ){
						$square->insert_product( $object );
						
					}
				}
				if( $response->cursor ){
					$response = $square->get_catalog( $response->cursor );
				}else{
					$response = false;
				}
			}
			
			header( "location:admin.php?page=wp-easycart-settings&subpage=cart-importer&ec_success=square-imported" );
			die( );
		}
	}
	
}
endif; // End if class_exists check

function wp_easycart_admin_cart_importer( ){
	return wp_easycart_admin_cart_importer::instance( );
}
wp_easycart_admin_cart_importer( );

add_action( 'wp_ajax_ec_admin_ajax_save_woo_importer', 'ec_admin_ajax_save_woo_importer' );
function ec_admin_ajax_save_woo_importer( ){
	wp_easycart_admin_cart_importer( )->save_woo_importer_settings( );
	die( );
}
add_action( 'wp_ajax_ec_admin_ajax_save_oscommerce_importer', 'ec_admin_ajax_save_oscommerce_importer' );
function ec_admin_ajax_save_oscommerce_importer( ){
	wp_easycart_admin_cart_importer( )->save_oscommerce_importer_settings( );
	die( );
}