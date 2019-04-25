<?php
class wp_easycart_admin_preloader{
	
	public $preloader_file;
	
	public function __construct( ){ 
		$this->preloader_file = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/assets/preloader.php';
	}
	
	public function print_preloader( $id ){
		include( $this->preloader_file );
	}
	
}