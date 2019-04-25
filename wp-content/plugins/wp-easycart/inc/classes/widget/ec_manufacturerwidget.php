<?php 
class ec_manufacturerwidget extends WP_Widget{
	
	function __construct( ){
		$widget_ops = array('classname' => 'ec_manufacturerwidget', 'description' => 'Filters the Products by Manufacturer For Your WP EasyCart' );
		parent::__construct('ec_manufacturerwidget', 'WP EasyCart Manufacturer Filter', $widget_ops);
	}
	
	function form($instance){
		if( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else {
			$title = __( 'Filter by Manufacturer', 'text_domain' );
		}
		
		echo "<p><label for=\"" . $this->get_field_name( 'title' ) . "\">" . _e( 'Title:' ) . "</label><input class=\"widefat\" id=\"" . $this->get_field_id( 'title' ) . "\" name=\"" . $this->get_field_name( 'title' ) . "\" type=\"text\" value=\"" . esc_attr( $title ) . "\" /></p>";
		
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults);
	}
	
	function update($new_instance, $old_instance){
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
	
	
	function widget($args, $instance){
	
		extract( $args );
		if( isset( $instance['title'] ) )
			$title = apply_filters( 'widget_title', $instance['title'] );
		else
			$title = "";
		
		// Translate if Needed
		$title = $GLOBALS['language']->convert_text( $title );
	
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		// WIDGET CODE GOES HERE
		$mysqli = new ec_db();
		$filter = new ec_filter(0);
		
		//Required for old linking layouts /////DO NOT DELETE////
		$store_page_id = get_option('ec_option_storepage');
		if( function_exists( 'icl_object_id' ) ){
			$store_page_id = icl_object_id( $store_page_id, 'page', true, ICL_LANGUAGE_CODE );
		}
		$store_page = get_permalink( $store_page_id );
		
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$store_page = $https_class->makeUrlHttps( $store_page );
		}
		
		if( substr_count( $store_page, '?' ) )					$permalink_divider = "&";
		else													$permalink_divider = "?";
		//Required for old linking layouts //////DO NOT DELETE////
		
		if( isset( $_GET['menuid'] ) || isset( $_GET['submenuid'] ) || isset( $_GET['subsubmenuid'] ) ){
			//Old Linking Format Code
			if( isset( $_GET['menuid'] ) ){
				$level = 1;
				$menu_id = $_GET['menuid'];
			}else if( isset( $_GET['submenuid'] ) ){
				$level = 2;
				$menu_id = $_GET['submenuid'];
			}else if( isset( $_GET['subsubmenuid'] ) ){
				$level = 3;
				$menu_id = $_GET['subsubmenuid'];
			}else{
				$level = 0;
				$menu_id = 0;
			}
		}else if( isset( $GLOBALS['ec_store_shortcode_options'] ) ){
			
			// If content loads first, we can grab the shortcode option
			$menulevel1 = $GLOBALS['ec_store_shortcode_options'][0];
			$menulevel2 = $GLOBALS['ec_store_shortcode_options'][1];
			$menulevel3 = $GLOBALS['ec_store_shortcode_options'][2];
			
			if( $menulevel1 != "NOMENU" ){
				$level = 1;
				$menu_id = $menulevel1;
			}else if( $menulevel2 != "NOSUBMENU" ){
				$level = 2;
				$menu_id = $menulevel2;
			}else if( $menulevel3 != "NOSUBSUBMENU" ){
				$level = 3;
				$menu_id = $menulevel3;
			}else{
				$level = 0;
				$menu_id = 0;
			}
			
		}else{
			// Otherwise hope that someone didn't manually add shortcode to page and pull based on post id
			global $wp_query;
			$post_obj = $wp_query->get_queried_object();
			if( isset( $post_obj ) && isset( $post_obj->ID ) ){
				$post_id = $post_obj->ID;
				$menulevel1 = $GLOBALS['ec_menu']->get_menu_row_from_post_id( $post_id, 1 );
				$menulevel2 = $GLOBALS['ec_menu']->get_menu_row_from_post_id( $post_id, 2 );
				$menulevel3 = $GLOBALS['ec_menu']->get_menu_row_from_post_id( $post_id, 3 );
				
				if( count( $menulevel1 ) > 0 ){
					$level = 1;
					$menu_id = $menulevel1->menulevel1_id;
				}else if( count( $menulevel2 ) > 0 ){
					$level = 2;
					$menu_id = $menulevel2->menulevel2_id;
				}else if( count( $menulevel3 ) > 0 ){
					$level = 3;
					$menu_id = $menulevel3->menulevel3_id;
				}else{
					$level = 0;
					$menu_id = 0;
				}
			}else{
				$level = 0;
				$menu_id = 0;
			}
		}
		
		global $wp_query;
		$post_obj = $wp_query->get_queried_object();
		if( isset( $post_obj ) && isset( $post_obj->ID ) ){
			$post_id = $post_obj->ID;
			$manufacturer = $GLOBALS['ec_manufacturers']->get_manufacturer_id_from_post_id( $post_id );
			$group = $GLOBALS['ec_categories']->get_category_id_from_post_id( $post_id );
			
			if( isset( $_GET['manufacturer'] ) )
				$man_id = $_GET['manufacturer'];
			else if( isset( $GLOBALS['ec_store_shortcode_options'] ) && $GLOBALS['ec_store_shortcode_options'][3] != "NOMANUFACTURER" )
				$man_id = $GLOBALS['ec_store_shortcode_options'][3];
			else if( isset( $manufacturer ) )
				$man_id = $manufacturer->manufacturer_id;
			else
				$man_id = 0;
				
			if( isset( $_GET['group_id'] ) )
				$group_id = $_GET['group_id'];
			else if( isset( $GLOBALS['ec_store_shortcode_options'] ) && $GLOBALS['ec_store_shortcode_options'][4] != "NOGROUP" )
				$group_id = $GLOBALS['ec_store_shortcode_options'][4];
			else if( isset( $group ) )
				$group_id = $group->category_id;
			else
				$group_id = 0;
		}else{
			$man_id = 0;
			$group_id = 0;
		}
		
		$manufacturers = $mysqli->get_manufacturers( $level, $menu_id, $man_id, $group_id );
		for( $i=0; $i<count( $manufacturers ); $i++ ){
			$manufacturers[$i]->name = $GLOBALS['language']->convert_text( $manufacturers[$i]->name );
		}
		
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_manufacturer_widget.php' ) )	
			include( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_manufacturer_widget.php");
		else
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/layout/" . get_option( 'ec_option_latest_layout' ) . "/ec_manufacturer_widget.php");
		
		echo $after_widget;
	}
 
}
?>