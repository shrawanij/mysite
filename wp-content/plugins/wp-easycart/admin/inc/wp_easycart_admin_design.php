<?php
class wp_easycart_admin_design{
	
	private $wpdb;
	
	public $design_file;
	public $settings_file;
		
	public function __construct( ){
		// Keep reference to wpdb
		global $wpdb;
		$this->wpdb =& $wpdb;
		
		// Setup File Names 
		$this->design_file	 				= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/design/design.php';
		$this->settings_file		 		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/design/settings.php';
		$this->colorize_file		 		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/design/design-colors.php';
		$this->custom_css			 		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/design/custom-css.php';
		$this->product_details_options		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/design/product-details-design-options.php';
		$this->cart_design_options			= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/design/cart-design-options.php';
		$this->product_design_options		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/design/product-design-options.php';
		$this->template_settings		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/design/design-templates.php';
		
		// Actions
		//add_action( 'wpeasycart_admin_design_settings', array( $this, 'load_success_messages' ) );
		add_action( 'wpeasycart_admin_design_settings', array( $this, 'load_design_settings' ) );
		add_action( 'wpeasycart_admin_design_settings', array( $this, 'load_color_settings' ) );
		add_action( 'wpeasycart_admin_design_settings', array( $this, 'load_custom_css' ) );
		add_action( 'wpeasycart_admin_design_settings', array( $this, 'load_cart_design_options' ) );
		add_action( 'wpeasycart_admin_design_settings', array( $this, 'load_product_details_design_options' ) );
		add_action( 'wpeasycart_admin_design_settings', array( $this, 'load_product_design_options' ) );
		add_action( 'wpeasycart_admin_design_settings', array( $this, 'load_design_template_settings' ) );
		add_action( 'init', array( $this, 'save_settings' ) );
	}
	
	public function load_design( ){
		include( $this->design_file );
	}
	
	public function load_success_messages( ){
		//include( $this->success_messages_file );
	}
	public function load_design_template_settings( ){
		include( $this->template_settings );
	}
	public function load_design_settings( ){
		include( $this->settings_file );
	}
	public function load_custom_css( ){
		include( $this->custom_css );
	}
	public function load_color_settings( ){
		include( $this->colorize_file );
	}
	public function load_product_design_options( ){
		include( $this->product_design_options );
	}
	public function load_product_details_design_options( ){
		include( $this->product_details_options );
	}
	public function load_cart_design_options( ){
		include( $this->cart_design_options );
	}
	
	public function save_custom_css( ){
		$ec_option_custom_css = stripslashes_deep( $_POST['ec_option_custom_css'] );
		update_option( 'ec_option_custom_css', $ec_option_custom_css );
	}
	
	public function save_design_template_settings( ){
		$ec_option_base_theme = $_POST['ec_option_base_theme'];
		$ec_option_base_layout = $_POST['ec_option_base_layout'];
		$ec_option_caching_on = $_POST['ec_option_caching_on'];
		$ec_option_cache_update_period = $_POST['ec_option_cache_update_period'];
		
		if( isset( $_POST['ec_option_base_theme'] ))
			$ec_option_base_theme = $_POST['ec_option_base_theme'] ;
		if( isset( $_POST['ec_option_base_layout'] ))
			$ec_option_base_layout = $_POST['ec_option_base_layout'] ;
		if( isset( $_POST['ec_option_caching_on'] ))
			$ec_option_caching_on = $_POST['ec_option_caching_on'] ;
		if( isset( $_POST['ec_option_cache_update_period'] ))
			$ec_option_cache_update_period = $_POST['ec_option_cache_update_period'] ;

		update_option( 'ec_option_base_theme', $ec_option_base_theme );
		update_option( 'ec_option_base_layout', $ec_option_base_layout );
		update_option( 'ec_option_caching_on', $ec_option_caching_on );
		update_option( 'ec_option_cache_update_period', $ec_option_cache_update_period );
	}
	
	public function save_design_settings( ){
		$ec_option_hide_live_editor = 0;
		$ec_option_use_custom_post_theme_template = 0;
		$ec_option_match_store_meta = 0;
		
		if( isset( $_POST['ec_option_hide_live_editor'] ) && $_POST['ec_option_hide_live_editor'] == '1' )
			$ec_option_hide_live_editor = 1;
		if( isset( $_POST['ec_option_use_custom_post_theme_template'] ) && $_POST['ec_option_use_custom_post_theme_template'] == '1' )
			$ec_option_use_custom_post_theme_template = 1;
		if( isset( $_POST['ec_option_match_store_meta'] ) && $_POST['ec_option_match_store_meta'] == '1' )
			$ec_option_match_store_meta = 1;
		
		$ec_option_no_rounded_corners = 1;
		if( isset( $_POST['ec_option_no_rounded_corners'] ) && $_POST['ec_option_no_rounded_corners'] )
			$ec_option_no_rounded_corners = 0;
			
		$ec_option_font_main = $_POST['ec_option_font_main'];

		update_option( 'ec_option_no_rounded_corners', $ec_option_no_rounded_corners );
		update_option( 'ec_option_font_main', $ec_option_font_main );
		update_option( 'ec_option_hide_live_editor', $ec_option_hide_live_editor );
		update_option( 'ec_option_use_custom_post_theme_template', $ec_option_use_custom_post_theme_template );
		update_option( 'ec_option_match_store_meta', $ec_option_match_store_meta );
	}
	public function save_design_colors( ){
		$ec_option_details_main_color = $_POST['ec_option_details_main_color'];
		$ec_option_details_second_color = $_POST['ec_option_details_second_color'];
		$ec_option_use_dark_bg = $_POST['ec_option_use_dark_bg'];
		
		if( isset( $_POST['ec_option_details_main_color'] ))
			$ec_option_details_main_color = $_POST['ec_option_details_main_color'] ;
		if( isset( $_POST['ec_option_details_second_color'] ))
			$ec_option_details_second_color = $_POST['ec_option_details_second_color'] ;
		if( isset( $_POST['ec_option_use_dark_bg'] ))
			$ec_option_use_dark_bg = $_POST['ec_option_use_dark_bg'] ;

		update_option( 'ec_option_details_main_color', $ec_option_details_main_color );
		update_option( 'ec_option_details_second_color', $ec_option_details_second_color );
		update_option( 'ec_option_use_dark_bg', $ec_option_use_dark_bg );
	}
	public function save_cart_design_options( ){
		$ec_option_cart_columns_desktop = $_POST['ec_option_cart_columns_desktop'];
		$ec_option_cart_columns_laptop = $_POST['ec_option_cart_columns_laptop'];
		$ec_option_cart_columns_tablet_wide = $_POST['ec_option_cart_columns_tablet_wide'];
		$ec_option_cart_columns_tablet = $_POST['ec_option_cart_columns_tablet'];
		$ec_option_cart_columns_smartphone = $_POST['ec_option_cart_columns_smartphone'];
		
		if( isset( $_POST['ec_option_cart_columns_desktop'] ))
			$ec_option_cart_columns_desktop = $_POST['ec_option_cart_columns_desktop'] ;
		if( isset( $_POST['ec_option_cart_columns_laptop'] ))
			$ec_option_cart_columns_laptop = $_POST['ec_option_cart_columns_laptop'] ;
		if( isset( $_POST['ec_option_cart_columns_tablet_wide'] ))
			$ec_option_cart_columns_tablet_wide = $_POST['ec_option_cart_columns_tablet_wide'] ;
		if( isset( $_POST['ec_option_cart_columns_tablet'] ))
			$ec_option_cart_columns_tablet = $_POST['ec_option_cart_columns_tablet'] ;
		if( isset( $_POST['ec_option_cart_columns_smartphone'] ))
			$ec_option_cart_columns_smartphone = $_POST['ec_option_cart_columns_smartphone'] ;

		update_option( 'ec_option_cart_columns_desktop', $ec_option_cart_columns_desktop );
		update_option( 'ec_option_cart_columns_laptop', $ec_option_cart_columns_laptop );
		update_option( 'ec_option_cart_columns_tablet_wide', $ec_option_cart_columns_tablet_wide );
		update_option( 'ec_option_cart_columns_tablet', $ec_option_cart_columns_tablet );
		update_option( 'ec_option_cart_columns_smartphone', $ec_option_cart_columns_smartphone );
	}
	public function save_details_design_options( ){
		$ec_option_details_columns_desktop = $_POST['ec_option_details_columns_desktop'];
		$ec_option_details_columns_laptop = $_POST['ec_option_details_columns_laptop'];
		$ec_option_details_columns_tablet_wide = $_POST['ec_option_details_columns_tablet_wide'];
		$ec_option_details_columns_tablet = $_POST['ec_option_details_columns_tablet'];
		$ec_option_details_columns_smartphone = $_POST['ec_option_details_columns_smartphone'];
		
		if( isset( $_POST['ec_option_details_columns_desktop'] ))
			$ec_option_details_columns_desktop = $_POST['ec_option_details_columns_desktop'] ;
		if( isset( $_POST['ec_option_details_columns_laptop'] ))
			$ec_option_details_columns_laptop = $_POST['ec_option_details_columns_laptop'] ;
		if( isset( $_POST['ec_option_details_columns_tablet_wide'] ))
			$ec_option_details_columns_tablet_wide = $_POST['ec_option_details_columns_tablet_wide'] ;
		if( isset( $_POST['ec_option_details_columns_tablet'] ))
			$ec_option_details_columns_tablet = $_POST['ec_option_details_columns_tablet'] ;
		if( isset( $_POST['ec_option_details_columns_smartphone'] ))
			$ec_option_details_columns_smartphone = $_POST['ec_option_details_columns_smartphone'] ;

		update_option( 'ec_option_details_columns_desktop', $ec_option_details_columns_desktop );
		update_option( 'ec_option_details_columns_laptop', $ec_option_details_columns_laptop );
		update_option( 'ec_option_details_columns_tablet_wide', $ec_option_details_columns_tablet_wide );
		update_option( 'ec_option_details_columns_tablet', $ec_option_details_columns_tablet );
		update_option( 'ec_option_details_columns_smartphone', $ec_option_details_columns_smartphone );
	}
	public function save_product_design_options( ){
		$ec_option_default_product_type = $_POST['ec_option_default_product_type'];
		$ec_option_default_product_image_hover_type = $_POST['ec_option_default_product_image_hover_type'];
		$ec_option_default_product_image_effect_type = $_POST['ec_option_default_product_image_effect_type'];
		$ec_option_default_quick_view = $_POST['ec_option_default_quick_view'];
		$ec_option_default_dynamic_sizing = $_POST['ec_option_default_dynamic_sizing'];
		$ec_option_default_desktop_columns = $_POST['ec_option_default_desktop_columns'];
		$ec_option_default_desktop_image_height = $_POST['ec_option_default_desktop_image_height'];
		$ec_option_default_laptop_columns = $_POST['ec_option_default_laptop_columns'];
		$ec_option_default_laptop_image_height = $_POST['ec_option_default_laptop_image_height'];
		$ec_option_default_tablet_wide_columns = $_POST['ec_option_default_tablet_wide_columns'];
		$ec_option_default_tablet_wide_image_height = $_POST['ec_option_default_tablet_wide_image_height'];
		$ec_option_default_tablet_columns = $_POST['ec_option_default_tablet_columns'];
		$ec_option_default_tablet_image_height = $_POST['ec_option_default_tablet_image_height'];
		$ec_option_default_smartphone_columns = $_POST['ec_option_default_smartphone_columns'];
		$ec_option_default_smartphone_image_height = $_POST['ec_option_default_smartphone_image_height'];
		
		if( isset( $_POST['ec_option_default_product_type'] ))
			$ec_option_default_product_type = $_POST['ec_option_default_product_type'] ;
		if( isset( $_POST['ec_option_default_product_image_hover_type'] ))
			$ec_option_default_product_image_hover_type = $_POST['ec_option_default_product_image_hover_type'] ;
		if( isset( $_POST['ec_option_default_product_image_effect_type'] ))
			$ec_option_default_product_image_effect_type = $_POST['ec_option_default_product_image_effect_type'] ;
		if( isset( $_POST['ec_option_default_quick_view'] ))
			$ec_option_default_quick_view = $_POST['ec_option_default_quick_view'] ;
		if( isset( $_POST['ec_option_default_dynamic_sizing'] ))
			$ec_option_default_dynamic_sizing = $_POST['ec_option_default_dynamic_sizing'] ;
		if( isset( $_POST['ec_option_default_desktop_columns'] ))
			$ec_option_default_desktop_columns = $_POST['ec_option_default_desktop_columns'] ;
		if( isset( $_POST['ec_option_default_desktop_image_height'] ))
			$ec_option_default_desktop_image_height = $_POST['ec_option_default_desktop_image_height'] ;
		if( isset( $_POST['ec_option_default_laptop_columns'] ))
			$ec_option_default_laptop_columns = $_POST['ec_option_default_laptop_columns'] ;
		if( isset( $_POST['ec_option_default_laptop_image_height'] ))
			$ec_option_default_laptop_image_height = $_POST['ec_option_default_laptop_image_height'] ;
		if( isset( $_POST['ec_option_default_tablet_wide_columns'] ))
			$ec_option_default_tablet_wide_columns = $_POST['ec_option_default_tablet_wide_columns'] ;
		if( isset( $_POST['ec_option_default_tablet_wide_image_height'] ))
			$ec_option_default_tablet_wide_image_height = $_POST['ec_option_default_tablet_wide_image_height'] ;
		if( isset( $_POST['ec_option_default_tablet_columns'] ))
			$ec_option_default_tablet_columns = $_POST['ec_option_default_tablet_columns'] ;
		if( isset( $_POST['ec_option_default_tablet_image_height'] ))
			$ec_option_default_tablet_image_height = $_POST['ec_option_default_tablet_image_height'] ;
		if( isset( $_POST['ec_option_default_smartphone_columns'] ))
			$ec_option_default_smartphone_columns = $_POST['ec_option_default_smartphone_columns'] ;
		if( isset( $_POST['ec_option_default_smartphone_image_height'] ))
			$ec_option_default_smartphone_image_height = $_POST['ec_option_default_smartphone_image_height'] ;

		update_option( 'ec_option_default_product_type', $ec_option_default_product_type );
		update_option( 'ec_option_default_product_image_hover_type', $ec_option_default_product_image_hover_type );
		update_option( 'ec_option_default_product_image_effect_type', $ec_option_default_product_image_effect_type );
		update_option( 'ec_option_default_quick_view', $ec_option_default_quick_view );
		update_option( 'ec_option_default_dynamic_sizing', $ec_option_default_dynamic_sizing );
		update_option( 'ec_option_default_desktop_columns', $ec_option_default_desktop_columns );
		update_option( 'ec_option_default_desktop_image_height', $ec_option_default_desktop_image_height );
		update_option( 'ec_option_default_laptop_columns', $ec_option_default_laptop_columns );
		update_option( 'ec_option_default_laptop_image_height', $ec_option_default_laptop_image_height );
		update_option( 'ec_option_default_tablet_wide_columns', $ec_option_default_tablet_wide_columns );
		update_option( 'ec_option_default_tablet_wide_image_height', $ec_option_default_tablet_wide_image_height );
		update_option( 'ec_option_default_tablet_columns', $ec_option_default_tablet_columns );
		update_option( 'ec_option_default_tablet_image_height', $ec_option_default_tablet_image_height );
		update_option( 'ec_option_default_smartphone_columns', $ec_option_default_smartphone_columns );
		update_option( 'ec_option_default_smartphone_image_height', $ec_option_default_smartphone_image_height );
	}
	
	public function ec_design_file_uploads( ){
		//////////////////////////////////////////////////////
		//Theme Uploader
		//////////////////////////////////////////////////////
		if( $_FILES && $_FILES["theme_file"]["name"] ) {
			
			$filename = $_FILES["theme_file"]["name"];
			$source = $_FILES["theme_file"]["tmp_name"];
			$type = $_FILES["theme_file"]["type"];
			
			$theme_message = "";
			
			$name = explode(".", $filename);
			$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
			foreach($accepted_types as $mime_type) {
				if($mime_type == $type) {
					$okay = true;
					break;
				} 
			}
			
			$continue = strtolower($name[1]) == 'zip' ? true : false;
			if(!$continue) {
				$theme_message .= " The theme file you are trying to upload is not a .zip file. Please try again.<br>";
			}
			/* PHP current path */
			$path = dirname(__FILE__).'/';
			$filenoext = basename ($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
			$filenoext = basename ($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)
			$targetdir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/theme/". $filenoext; // target directory
			$targetdir2 = WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/". $filenoext; // target directory
			$targetzip = $path . $filename; // target zip file
			
			if( is_writable( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/theme/" ) ){ // If we can create the dir, do it, otherwise ftp it.
				if (is_dir($targetdir))  wpeasycart_rmdir_recursive ( $targetdir);
				mkdir($targetdir, 0777);
				if (is_dir($targetdir2))  wpeasycart_rmdir_recursive ( $targetdir2);
				mkdir($targetdir2, 0777);
				
				if( is_dir( $targetdir2 ) )
					$theme_message .= " The theme directory was created successfully.<br>";
				else
					$theme_message .= " The theme directory was NOT created, please try again.<br>";
			  
			}else{
				// Could not open the file, lets write it via ftp!
				$ftp_server = $_SERVER['HTTP_HOST'];
				$ftp_user_name = $_POST['ec_ftp_user1'];
				$ftp_user_pass = $_POST['ec_ftp_pass1'];
				
				// set up basic connection
				$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
				
				// login with username and password
				$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
				
				if( !$login_result ){
					$theme_message .= "The plugin could not connect to your server via FTP. Please enter your FTP info and try again.<br>";
				}else{
					ftp_mkdir( $conn_id, $targetdir );
					ftp_site( $conn_id, "CHMOD 0777 " . $targetdir );
					
					ftp_mkdir( $conn_id, $targetdir2 );
					ftp_site( $conn_id, "CHMOD 0777 " . $targetdir2 );
					
					if( is_dir( $targetdir ) )
						$theme_message .= " The theme directory was created successfully via FTP.<br>";
					else
						$theme_message .= " The theme directory was NOT created, failed via FTP, please try again.<br>";
				}
			}
			
			if( !is_dir( $targetdir2 ) ){
				// Already added message about the dir.
			}else{
				$zip = new ZipArchive();
				$x = $zip->open( $_FILES["theme_file"]["tmp_name"] );  // open the zip file to extract 
				if( $x === true ) {
					$zip->extractTo( $targetdir ); // place in the directory with same name  
					$zip->extractTo( $targetdir2 ); // place in the directory with same name  
					$zip->close();
					$theme_message .= "Your EasyCart theme file was uploaded and unpacked. You may select from the Base Design above.";
					update_option( 'ec_option_base_theme', $filenoext );
				}else{
					$theme_message .= "Could not open the uploaded zip file. Please try again.";
				}
			}
		}
			
		//////////////////////////////////////////////////////
		//layout uploader
		//////////////////////////////////////////////////////
		if( $_FILES && $_FILES["layout_file"]["name"] ) {
			
			$filename = $_FILES["layout_file"]["name"];
			$source = $_FILES["layout_file"]["tmp_name"];
			$type = $_FILES["layout_file"]["type"];
			
			$layout_message = "";
			
			$name = explode(".", $filename);
			$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
			foreach($accepted_types as $mime_type) {
				if($mime_type == $type) {
					$okay = true;
					break;
				} 
			}
			
			$continue = strtolower($name[1]) == 'zip' ? true : false;
			if(!$continue) {
				$layout_message .= " The layout file you are trying to upload is not a .zip file. Please try again.<br>";
			}
			/* PHP current path */
			$path = dirname(__FILE__).'/';
			$filenoext = basename ($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
			$filenoext = basename ($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)
			$targetdir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/layout/". $filenoext; // target directory
			$targetdir2 = WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/". $filenoext; // target directory
			$targetzip = $path . $filename; // target zip file
			
			if( is_writable(  WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/layout/" ) ){ // If we can create the dir, do it, otherwise ftp it.
				if (is_dir($targetdir))  wpeasycart_rmdir_recursive ( $targetdir);
				mkdir($targetdir, 0777);
				if (is_dir($targetdir2))  wpeasycart_rmdir_recursive ( $targetdir2 );
				mkdir($targetdir2, 0777);
				if( is_dir( $targetdir ) )
					$layout_message .= " The layout directory was created successfully.<br>";
				else
					$layout_message .= " The layout directory was NOT created, please try again.<br>";
			  
			}else{
				// Could not open the file, lets write it via ftp!
				$ftp_server = $_SERVER['HTTP_HOST'];
				$ftp_user_name = $_POST['ec_ftp_user2'];
				$ftp_user_pass = $_POST['ec_ftp_pass2'];
				
				// set up basic connection
				$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
				
				// login with username and password
				$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
				
				if( !$login_result ){
					$layout_message .= "The plugin could not connect to your server via FTP. Please enter your FTP info and try again.<br>";
				}else{
					ftp_mkdir( $conn_id, $targetdir );
					ftp_site( $conn_id, "CHMOD 0777 " . $targetdir );
					ftp_mkdir( $conn_id, $targetdir2 );
					ftp_site( $conn_id, "CHMOD 0777 " . $targetdir2 );
					if( is_dir( $targetdir2 ) )
						$layout_message .= " The layout directory was created successfully via FTP.<br>";
					else
						$layout_message .= " The layout directory was NOT created, failed via FTP, please try again.<br>";
				}
			}
			
			if( !is_dir( $targetdir2 ) ){
				// Already added message about the dir.
			}else{
				$zip = new ZipArchive();
				$x = $zip->open( $_FILES["layout_file"]["tmp_name"] );  // open the zip file to extract 
				if( $x === true ) {
					$zip->extractTo( $targetdir ); // place in the directory with same name  
					$zip->extractTo( $targetdir2 ); // place in the directory with same name  
					$zip->close();
					$layout_message .= "Your EasyCart layout file was uploaded and unpacked. You may select from the Base Design above.";
					update_option( 'ec_option_base_layout', $filenoext );
				}else{
					$layout_message .= "Could not open the uploaded zip file. Please try again.";
				}
			}
		}
		
		// Copy the latest theme
		if( isset( $_POST['ec_option_copy_theme']) && $_POST['ec_option_copy_theme'] != "0" ){
			$to = "../wp-content/plugins/wp-easycart-data/design/theme/";
			$from = "../wp-content/plugins/wp-easycart-data/latest-design/theme/" . $_POST['ec_option_copy_theme'] . "/";
			
			if( is_dir( $to ) && !is_dir( $to . $_POST['ec_option_copy_theme'] . "-" . EC_CURRENT_VERSION . "/" ) && is_dir( $from ) ){
				// Recursive copy the selected theme
				wpeasycart_copyr( $from, $to . $_POST['ec_option_copy_theme'] . "-" . EC_CURRENT_VERSION . "/" );
				update_option( 'ec_option_base_theme', $_POST['ec_option_copy_theme'] . "-" . EC_CURRENT_VERSION );
			}
		}
		
		// Copy the latest layout
		if( isset( $_POST['ec_option_copy_layout']) && $_POST['ec_option_copy_layout'] != "0" ){
			$to = "../wp-content/plugins/wp-easycart-data/design/layout/";
			$from = "../wp-content/plugins/wp-easycart-data/latest-design/layout/" . $_POST['ec_option_copy_layout'] . "/";
			
			if( is_dir( $to ) && !is_dir( $to . $_POST['ec_option_copy_layout'] . "-" . EC_CURRENT_VERSION . "/" ) && is_dir( $from ) ){
				// Recursive copy the selected theme
				wpeasycart_copyr( $from, $to . $_POST['ec_option_copy_layout'] . "-" . EC_CURRENT_VERSION . "/" );
				update_option( 'ec_option_base_layout', $_POST['ec_option_copy_layout'] . "-" . EC_CURRENT_VERSION );
			}
		}
	}
		
	
	public function save_settings( ){
		
	}
	
}

add_action( 'wp_ajax_ec_admin_ajax_save_design_template_settings', 'ec_admin_ajax_save_design_template_settings' );
function ec_admin_ajax_save_design_template_settings( ){
	$custom_css = new wp_easycart_admin_design( );
	$custom_css->save_design_template_settings( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_custom_css', 'ec_admin_ajax_save_custom_css' );
function ec_admin_ajax_save_custom_css( ){
	$custom_css = new wp_easycart_admin_design( );
	$custom_css->save_custom_css( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_design_settings', 'ec_admin_ajax_save_design_settings' );
function ec_admin_ajax_save_design_settings( ){
	$design_settings = new wp_easycart_admin_design( );
	$design_settings->save_design_settings( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_design_colors', 'ec_admin_ajax_save_design_colors' );
function ec_admin_ajax_save_design_colors( ){
	$design_colors = new wp_easycart_admin_design( );
	$design_colors->save_design_colors( );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_save_cart_design_options', 'ec_admin_ajax_save_cart_design_options' );
function ec_admin_ajax_save_cart_design_options( ){
	$design_colors = new wp_easycart_admin_design( );
	$design_colors->save_cart_design_options( );
	die( );
}
add_action( 'wp_ajax_ec_admin_ajax_save_details_design_options', 'ec_admin_ajax_save_details_design_options' );
function ec_admin_ajax_save_details_design_options( ){
	$design_colors = new wp_easycart_admin_design( );
	$design_colors->save_details_design_options( );
	die( );
}
add_action( 'wp_ajax_ec_admin_ajax_save_product_design_options', 'ec_admin_ajax_save_product_design_options' );
function ec_admin_ajax_save_product_design_options( ){
	$design_colors = new wp_easycart_admin_design( );
	$design_colors->save_product_design_options( );
	die( );
}