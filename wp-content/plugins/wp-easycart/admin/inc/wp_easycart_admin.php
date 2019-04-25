<?php

if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'wp_easycart_admin' ) ) :

final class wp_easycart_admin{
	
	protected static $_instance = null;
	
	private $wpdb;
	
	public $available_url;
	public $preloader;
	
	public $month_sales_total;
	public $month_name;
	public $month_percentage_change;
	public $month_percentage_goal;
	public $month_goal_total;
	
	public $daily_sales;
	public $weekly_sales;
	public $monthly_sales;
	public $yearly_sales;
	
	public $daily_items_sold;
	public $weekly_items_sold;
	public $monthly_items_sold;
	public $yearly_items_sold;
	
	public $daily_abandonment;
	public $weekly_abandonment;
	public $monthly_abandonment;
	public $yearly_abandonment;
	
	public $new_orders;
	public $new_unviewed_orders;
	public $pending_reviews;
	public $cart_users;
	
	public $settings;
	public $shipping_zones;
	public $shipping_zones_items;
	public $countries;
	public $states;
	
	public $store_page;
	public $cart_page;
	public $account_page;
	public $permalink_divider;
	
	public static function instance( ) {
		
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self(  );
		}
		return self::$_instance;
	
	}
	
	public function __construct( ){ 
	
		if( !defined( 'WP_EASYCART_ADMIN_PLUGIN_DIR' ) )
			define( 'WP_EASYCART_ADMIN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			
		if( ! defined( 'WP_EASYCART_ADMIN_PLUGIN_URL' ) )
			define( 'WP_EASYCART_ADMIN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		if( ! defined( 'WP_EASYCART_ADMIN_PLUGIN_FILE' ) )
			define( 'WP_EASYCART_ADMIN_PLUGIN_FILE', __FILE__ );
	
		if( !defined( 'WP_EASYCART_ADMIN_DB_VERSION' ) )
			define( 'WP_EASYCART_ADMIN_DB_VERSION', 0.1 );
			
		// Keep reference to wpdb
		global $wpdb;
		$this->wpdb =& $wpdb;
		
		if( is_callable( 'socket_create' ) && is_callable( 'socket_connect' ) && is_callable( 'socket_close' ) ){
			$socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
			$connection = @socket_connect( $socket, "connect.wpeasycart.com", 443 );
			$this->available_url = ( $connection ) ? "https://connect.wpeasycart.com" : "https://support.wpeasycart.com";
			@socket_close( $socket );
		}else{
			$this->available_url = "https://connect.wpeasycart.com";
		}
		
		$this->preloader = new wp_easycart_admin_preloader( );
		$this->helpsystem = new wp_easycart_admin_online_docs( );
		
		if( isset( $_GET['page'] ) && (
			$_GET['page'] == 'wp-easycart-dashboard' || 
			$_GET['page'] == 'wp-easycart-products' || 
			$_GET['page'] == 'wp-easycart-orders' || 
			$_GET['page'] == 'wp-easycart-users' || 
			$_GET['page'] == 'wp-easycart-rates' || 
			$_GET['page'] == 'wp-easycart-settings' || 
			$_GET['page'] == 'wp-easycart-status' || 
			$_GET['page'] == 'wp-easycart-registration'
		) ){
			// Setup Basic Variables for Admin Design
			$this->month_sales_total = $this->get_month_sales_total( );
			$this->month_name = date( 'F' );
			$this->month_percentage_change = $this->get_month_percentage_change( );
			$this->month_goal_total =  get_option( 'ec_option_admin_sales_goal');
			$this->month_percentage_goal = ( $this->month_sales_total / $this->month_goal_total ) * 100;
			
			if( $_GET['page'] == 'wp-easycart-dashboard' ){
				$this->new_orders = $this->get_total_new_orders( );
				$this->pending_reviews = $this->get_total_new_reviews( );
				$this->cart_users = $this->get_total_cart_users( );
			}
		}
		
		$this->new_unviewed_orders = $this->get_total_new_unviewed_orders( );

		// EasyCart Admin Actions
		add_action( 'wp_easycart_admin_messages', array( $this, 'load_upsell_image' ) );
		add_action( 'wp_easycart_admin_upsell_popup', array( $this, 'load_upsell_popup' ) );
		add_action( 'wp_easycart_admin_mobile_navigation', array( $this, 'load_mobile_navigation' ), 1, 0 );
		add_action( 'wp_easycart_admin_left_navigation', array( $this, 'load_left_navigation' ), 1, 0 );
		add_action( 'wp_easycart_admin_head_navigation', array( $this, 'load_head_navigation' ), 1, 0 );
		add_action( 'wp_easycart_admin_messages', array( $this, 'print_admin_message' ) );
		add_action( 'wp_dashboard_setup', array( $this, 'add_ec_nag_widget' ) );

		// Hook Actions
		add_action( 'admin_init', array( $this, 'delete_gateway_log' ) );
		add_action( 'admin_init', array( $this, 'complete_init' ) );
		add_action( 'admin_init', array( $this, 'setup_pro_hooks' ) );
		add_action( 'admin_init', array( $this, 'process_actions' ) );
		add_action( 'admin_init', array( $this, 'change_uploads_dir' ), 999 );
		add_action( 'admin_menu', array( $this, 'setup_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'load_block_editor_assets' ) );
		add_action( 'admin_notices', array( $this, 'wp_easycart_pro_check' ) );
		add_action( 'admin_notices', array( $this, 'elementor_check' ) );
		add_action( 'add_meta_boxes', array( $this, 'page_lock_meta' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_page_lock_meta' ) );
		
		// WordPress Filters
		add_filter( 'admin_title', array( $this, 'set_title' ), 10, 2 );
	}
	
	public function save_page_lock_meta( $post_id ){
		if( current_user_can( 'manage_options' ) ){
			if( array_key_exists( 'wpeasycart_restrict_product_id', $_POST ) ){
				update_post_meta( $post_id, 'wpeasycart_restrict_product_id', $_POST['wpeasycart_restrict_product_id'] );
			}
			
			if( array_key_exists( 'wpeasycart_restrict_user_id', $_POST ) ){
				update_post_meta( $post_id, 'wpeasycart_restrict_user_id', $_POST['wpeasycart_restrict_user_id'] );
			}
			
			if( array_key_exists( 'wpeasycart_restrict_role_id', $_POST ) ){
				update_post_meta( $post_id, 'wpeasycart_restrict_role_id', $_POST['wpeasycart_restrict_role_id'] );
			}
			
			if( array_key_exists( 'wpeasycart_restrict_redirect_url', $_POST ) ){
				update_post_meta( $post_id, 'wpeasycart_restrict_redirect_url', $_POST['wpeasycart_restrict_redirect_url'] );
			}
		}
	}
	
	public function page_lock_meta( $post_type, $post ){
		if( current_user_can( 'manage_options' ) && ( $post_type == 'page' || $post_type == 'post' || $post_type == 'ec_store' ) ){
			add_meta_box( 
				'wp-easycart-product-lock',
				'WP EasyCart Limit Access',
				array( $this, 'load_page_lock_meta_box' ),
				array( 'page', 'post', 'ec_store' ),
				'side',
				'default'
			);
		}
	}
	
	public function load_page_lock_meta_box( $post ){
		global $wpdb;
		$products = $wpdb->get_results( "SELECT product_id, title FROM ec_product ORDER BY title ASC LIMIT 500" );
		$users = $wpdb->get_results( "SELECT user_id, first_name, last_name FROM ec_user ORDER BY last_name ASC, first_name ASC LIMIT 500" );
		$user_roles = $wpdb->get_results( "SELECT role_label FROM ec_role ORDER BY role_label ASC" );
		
		$selected_product = get_post_meta( $post->ID, 'wpeasycart_restrict_product_id', true );
		$selected_user = get_post_meta( $post->ID, 'wpeasycart_restrict_user_id', true );
		$selected_role = get_post_meta( $post->ID, 'wpeasycart_restrict_role_id', true );
		$selected_redirect = get_post_meta( $post->ID, 'wpeasycart_restrict_redirect_url', true );
		
		if( count( $products ) >= 500 ){
			echo '<label for="wpeasycart_restrict_product_id">Option 1: Restrict by Product</label>';
			echo '<input type="text" name="wpeasycart_restrict_product_id" id="wpeasycart_restrict_product_id" class="postbox" value="' . $selected_product . '" placeholder="Enter Product ID">';
		}else{
			echo '<label for="wpeasycart_restrict_product_id">Option 1: Restrict by Product</label>
			<select name="wpeasycart_restrict_product_id[]" id="wpeasycart_restrict_product_id" class="postbox" multiple>
				<option value="">No Restriction</option>';
				
			foreach( $products as $product ){
				echo '<option value="' . $product->product_id . '"' . ( ( ( is_array( $selected_product ) && in_array( $product->product_id, $selected_product ) ) || ( !is_array( $selected_product ) && $product->product_id == $selected_product ) ) ? ' selected="selected"' : '' ). '>' . $product->title . '</option>';
			}
			echo '</select>';
		}
		
		if( count( $users ) >= 500 ){
			echo '<label for="wpeasycart_restrict_user_id">Option 2: Restrict by User</label>';
			echo '<input type="text" name="wpeasycart_restrict_user_id" id="wpeasycart_restrict_user_id" class="postbox" value="' . $selected_user . '" placeholder="Enter User ID">';
		}else{
			echo '<label for="wpeasycart_restrict_user_id">Option 2: Restrict by User</label>
			<select name="wpeasycart_restrict_user_id[]" id="wpeasycart_restrict_user_id" class="postbox" multiple>
				<option value="">No Restriction</option>';
				
			foreach( $users as $user ){
				echo '<option value="' . $user->user_id . '"' . ( ( ( is_array( $selected_user ) && in_array( $user->user_id, $selected_user ) ) || ( !is_array( $selected_user ) && $user->user_id == $selected_user ) ) ? ' selected="selected"' : '' ). '>' . $user->first_name . ' ' . $user->last_name . '</option>';
			}
			echo '</select>';
		}
		
		echo '<label for="wpeasycart_restrict_role_id">Option 3: Restrict by User Role</label>';
		echo '<select name="wpeasycart_restrict_role_id[]" id="wpeasycart_restrict_role_id" class="postbox" multiple>';
		echo '<option value="">No Restriction</option>';
		foreach( $user_roles as $role ){
			echo '<option value="' . $role->role_label . '"' . ( ( ( is_array( $selected_role ) && in_array( $role->role_label, $selected_role ) ) || ( !is_array( $selected_role ) && $role->role_label == $selected_role ) ) ? ' selected="selected"' : '' ). '>' . $role->role_label . '</option>';
		}
		echo '</select>';
		
		echo '<label for="wpeasycart_restrict_redirect_url">Redirect URL if User Not Authorized</label>';
		echo '<input type="text" name="wpeasycart_restrict_redirect_url" id="wpeasycart_restrict_redirect_url" class="postbox" value="' . $selected_redirect . '" placeholder="https://www.site.com">';
		
		
		echo '<p>Note: You must turn off guest checkout or select a download or subscription product from the menu above. Subscription products will check the user has an active subscription. You must create a page to redirect to if a user does not have authorization.</p>';
	}

	public function add_ec_nag_widget( ){
		wp_add_dashboard_widget( 'ec_free_dashboard_widget', 'WP EasyCart FREE Edition', array( $this, 'ec_dashboard_nag_widget' ) );
        global $wp_meta_boxes;
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$widget_backup = array( 'ec_free_dashboard_widget' => $normal_dashboard['ec_free_dashboard_widget'] );
		unset( $normal_dashboard['ec_free_dashboard_widget'] );
		$sorted_dashboard = array_merge( $widget_backup, $normal_dashboard );
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}
	
	public function ec_dashboard_nag_widget( $post, $callback_args ){
		echo "<div style='text-align:center;font-size: 1.3em;'>Are you enjoying your FREE Shopping Cart?<br> Want to unlock more awesome features?<br/><br/>Upgrade to <strong>Professional</strong> & <strong>Premium</strong> editions!<br/>";
		echo "<a href='https://www.wpeasycart.com/wordpress-shopping-cart-pricing/?upsell=9' target='_blank'><img src='https://www.wpeasycart.com/images/ec_dashboard_nag_image.jpg' style='max-width:100%;margin: 10px;'/></a>";
		echo "<a class='button button-primary' href='https://www.wpeasycart.com/wordpress-shopping-cart-pricing/?upsell=9' target='_blank'>Upgrade Today!</a></div>";
    }
	
	public function delete_gateway_log( ){ 
		if( current_user_can( 'manage_options' ) && isset( $_GET['ec_admin_form_action'])  && $_GET['ec_admin_form_action'] == 'ec_delete_gateway_log' ){
			wp_easycart_admin_miscellaneous( )->delete_gateway_log( );
		}
	}
	
	public function complete_init( ){
		
		// Link Information
		$store_page_id = get_option('ec_option_storepage');
		$cart_page_id = get_option('ec_option_cartpage');
		$account_page_id = get_option('ec_option_accountpage');
		
		if( function_exists( 'icl_object_id' ) ){
			$store_page_id = icl_object_id( $store_page_id, 'page', true, ICL_LANGUAGE_CODE );
			$cart_page_id = icl_object_id( $cart_page_id, 'page', true, ICL_LANGUAGE_CODE );
			$account_page_id = icl_object_id( $account_page_id, 'page', true, ICL_LANGUAGE_CODE );
		}
		
		$this->store_page = get_permalink( $store_page_id );
		$this->cart_page = get_permalink( $cart_page_id );
		$this->account_page = get_permalink( $account_page_id );
		
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$this->store_page = $https_class->makeUrlHttps( $this->store_page );
			$this->cart_page = $https_class->makeUrlHttps( $this->cart_page );
			$this->account_page = $https_class->makeUrlHttps( $this->account_page );
		}
		
		if( substr_count( $this->cart_page, '?' ) )					$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
		
	}
	
	public function process_actions( ){ 
		if( current_user_can( 'manage_options' ) && (isset( $_POST['ec_admin_form_action'] ) || isset( $_GET['ec_admin_form_action'] )) ){
			$actions = new wp_easycart_admin_actions( );
			$actions->process_action( );
		}
		
		if( current_user_can( 'manage_options' ) && isset( $_GET['ec_trial'] ) && $_GET['ec_trial'] == 'start' ){
			$this->start_pro_trial( );
			wp_redirect( "admin.php?page=wp-easycart-registration" );
		}
		
		if( current_user_can( 'manage_options' ) && isset( $_GET['ec_install'] ) && $_GET['ec_install'] == 'pro' ){
			if( !file_exists( WP_PLUGIN_DIR . '/' . EC_PLUGIN_DIRECTORY . '-pro/wp-easycart-admin-pro.php' ) ){
				$this->install_pro_plugin( 0 );
			}
			if( file_exists( WP_PLUGIN_DIR . '/' . EC_PLUGIN_DIRECTORY . '-pro/wp-easycart-admin-pro.php' ) && !is_plugin_active( 'wp-easycart-pro/wp-easycart-admin-pro.php' ) ){
				activate_plugin( WP_PLUGIN_DIR . '/' . EC_PLUGIN_DIRECTORY . '-pro/wp-easycart-admin-pro.php', NULL, 0, 1 );
			}
			wp_redirect( "admin.php?page=wp-easycart-registration" );
		}
	}
	
	public function change_uploads_dir( ){
		add_filter( 'upload_dir', array( $this, 'custom_download_location' ) );
	}
	
	public function custom_download_location( $upload ){
		if( isset( $_REQUEST['is_wpec_download'] ) && $_REQUEST['is_wpec_download'] == '1' ){
			if( !is_dir( $upload['basedir'] . '/wp-easycart' ) ){
				mkdir( $upload['basedir'] . '/wp-easycart', 0755 );
				$index_file = fopen( $upload['basedir'] . '/wp-easycart/index.html', "w" );
				fclose( $index_file );
			}
			$upload['subdir']  = "/wp-easycart";
			$upload['path']    = $upload['basedir'] . "/wp-easycart";
			$upload['url']     = $upload['baseurl'] . "/wp-easycart";
		}
		return $upload;
	}
	
	/* STATS FUNCTIONS */
	private function get_month_sales_total( ){
		$local_tz_diff = get_option( 'gmt_offset' );
		if( $local_tz_diff < 0 ){
			return $this->wpdb->get_var( "SELECT ( SUM( ec_order.sub_total ) - SUM( ec_order.discount_total ) ) as total FROM ec_order LEFT JOIN ec_orderstatus ON ec_orderstatus.status_id = ec_order.orderstatus_id WHERE MONTH( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ) ) = MONTH( ec_order.order_date ) AND YEAR( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ) ) = YEAR( ec_order.order_date ) AND ec_orderstatus.`is_approved` = 1" );
		}else{
			return $this->wpdb->get_var( "SELECT ( SUM( ec_order.sub_total ) - SUM( ec_order.discount_total ) ) as total FROM ec_order LEFT JOIN ec_orderstatus ON ec_orderstatus.status_id = ec_order.orderstatus_id WHERE MONTH( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ) ) = MONTH( ec_order.order_date ) AND YEAR( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ) ) = YEAR( ec_order.order_date ) AND ec_orderstatus.`is_approved` = 1" );
		}
	}
	
	private function get_month_percentage_change( ){
		$local_tz_diff = get_option( 'gmt_offset' );
		if( $local_tz_diff < 0 ){
			$last_month = $this->wpdb->get_var( "SELECT ( SUM( ec_order.sub_total ) - SUM( ec_order.discount_total ) ) as total FROM ec_order LEFT JOIN ec_orderstatus ON ec_orderstatus.status_id = ec_order.orderstatus_id WHERE MONTH( DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 30 DAY ) ) = MONTH( ec_order.order_date ) AND YEAR( DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 30 DAY ) ) = YEAR( ec_order.order_date ) AND ec_orderstatus.`is_approved` = 1" );
		}else{
			$last_month = $this->wpdb->get_var( "SELECT ( SUM( ec_order.sub_total ) - SUM( ec_order.discount_total ) ) as total FROM ec_order LEFT JOIN ec_orderstatus ON ec_orderstatus.status_id = ec_order.orderstatus_id WHERE MONTH( DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 30 DAY ) ) = MONTH( ec_order.order_date ) AND YEAR( DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 30 DAY ) ) = YEAR( ec_order.order_date ) AND ec_orderstatus.`is_approved` = 1" );
		}
		if($last_month == null) $last_month = 0;
		$datestring = 'first day of last month';
		$dt = date_create( $datestring );
		$month = intval( date_format( $dt, 'm' ) );
		$year = intval( date_format( $dt, 'Y' ) );
		$days_last = $this->days_in_month( $month, $year );
		$days_this_month = intval( date( 'j' ) );
		
		if( ( $last_month / $days_last ) * $days_this_month == 0 )
			return 0;
		else
			return ( ( $this->month_sales_total / ( ( $last_month / $days_last ) * $days_this_month ) ) - 1 ) * 100; //compare total over same number of days between months
	}
	
	private function days_in_month( $month, $year ){ 
		return $month == 2 ? ( $year % 4 ? 28 : ( $year % 100 ? 29 : ( $year % 400 ? 28 : 29 ) ) ) : ( ( $month - 1 ) % 7 % 2 ? 30 : 31 ); 
	}
	
	public function get_dashboard_data( $date_type, $chart_type, $product_id ){
		return $this->{"get_".$date_type."_".$chart_type}( $product_id );
	}
	
	private function get_daily_sales( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_orderdetail.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.total_price ), 0 ) as total, DATE_FORMAT( ec_order.order_date, '%m/%d/%Y' ) as date, DAY( ec_order.order_date ) AS order_day, MONTH( ec_order.order_date ) AS order_month FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 DAY ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_day, order_month ORDER BY ec_order.order_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.total_price ), 0 ) as total, DATE_FORMAT( ec_order.order_date, '%m/%d/%Y' ) as date, DAY( ec_order.order_date ) AS order_day, MONTH( ec_order.order_date ) AS order_month FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 DAY ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_day, order_month ORDER BY ec_order.order_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'day' ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'day' ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_weekly_sales( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_orderdetail.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.total_price ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFWEEK( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, WEEK( ec_order.order_date ) AS order_week, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 WEEK ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY date ORDER BY ec_order.order_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.total_price ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFWEEK( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, WEEK( ec_order.order_date ) AS order_week, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 WEEK ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY date ORDER BY ec_order.order_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'weeks', strtotime( '-' . date( 'w' ) . ' days' ) ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'week', strtotime( '-' . date( 'w' ) . ' days' ) ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_monthly_sales( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_orderdetail.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.total_price ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFMONTH( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, MONTH( ec_order.order_date ) AS order_month, MONTHNAME( ec_order.order_date ) AS order_month, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 MONTH ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_month, order_year ORDER BY ec_order.order_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.total_price ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFMONTH( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, MONTH( ec_order.order_date ) AS order_month, MONTHNAME( ec_order.order_date ) AS order_month, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 MONTH ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_month, order_year ORDER BY ec_order.order_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'months', strtotime( '-' . (date( 'd' )-1) . ' days' ) ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'month', strtotime( '-' . (date( 'd' )-1) . ' days' ) ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_yearly_sales( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_orderdetail.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.total_price ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFYEAR( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 YEAR ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_year ORDER BY ec_order.order_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.total_price ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFYEAR( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 YEAR ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_year ORDER BY ec_order.order_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'years', strtotime( '-' . date('z') . ' days' ) ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'years', strtotime( '-' . date('z') . ' days' ) ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_daily_items_sold( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_orderdetail.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.quantity ), 0 ) as total, DATE_FORMAT( ec_order.order_date, '%m/%d/%Y' ) as date, DAY( ec_order.order_date ) AS order_day FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 DAY ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_day ORDER BY ec_order.order_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.quantity ), 0 ) as total, DATE_FORMAT( ec_order.order_date, '%m/%d/%Y' ) as date, DAY( ec_order.order_date ) AS order_day FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 DAY ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_day ORDER BY ec_order.order_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'day' ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'day' ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_weekly_items_sold( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_orderdetail.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.quantity ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFWEEK( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, WEEK( ec_order.order_date ) AS order_week, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 WEEK ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_week, order_year ORDER BY ec_order.order_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.quantity ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFWEEK( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, WEEK( ec_order.order_date ) AS order_week, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 WEEK ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_week, order_year ORDER BY ec_order.order_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'weeks', strtotime( '-' . date( 'w' ) . ' days' ) ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'week', strtotime( '-' . date( 'w' ) . ' days' ) ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_monthly_items_sold( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_orderdetail.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.quantity ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFMONTH( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, MONTHNAME( ec_order.order_date ) AS order_month, MONTH( ec_order.order_date ) AS order_month, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 MONTH ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_month, order_year ORDER BY ec_order.order_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.quantity ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFMONTH( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, MONTHNAME( ec_order.order_date ) AS order_month, MONTH( ec_order.order_date ) AS order_month, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 MONTH ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_month, order_year ORDER BY ec_order.order_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'months', strtotime( '-' . (date( 'd' )-1) . ' days' ) ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'month', strtotime( '-' . (date( 'd' )-1) . ' days' ) ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_yearly_items_sold( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_orderdetail.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.quantity ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFYEAR( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 YEAR ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_year ORDER BY ec_order.order_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT IFNULL( SUM( ec_orderdetail.quantity ), 0 ) as total, DATE_FORMAT( DATE_SUB( ec_order.order_date, INTERVAL ( DAYOFYEAR( ec_order.order_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, YEAR( ec_order.order_date ) AS order_year FROM ec_orderdetail LEFT JOIN ec_order ON ec_order.order_id = ec_orderdetail.order_id LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.order_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 YEAR ) AND ec_orderstatus.is_approved = 1 " . $product_where . "GROUP BY order_year ORDER BY ec_order.order_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'years', strtotime( '-' . date('z') . ' days' ) ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'years', strtotime( '-' . date('z') . ' days' ) ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_daily_abandonment( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_tempcart.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT COUNT( ec_tempcart.session_id ) as total, DATE_FORMAT( ec_tempcart.last_changed_date, '%m/%d/%Y') as date, DAY( ec_tempcart.last_changed_date ) as cart_day, MONTH( ec_tempcart.last_changed_date ) as cart_month FROM ec_tempcart WHERE ec_tempcart.last_changed_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 DAY ) " . $product_where . "GROUP BY cart_day, cart_month ORDER BY ec_tempcart.last_changed_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT COUNT( ec_tempcart.session_id ) as total, DATE_FORMAT( ec_tempcart.last_changed_date, '%m/%d/%Y') as date, DAY( ec_tempcart.last_changed_date ) as cart_day, MONTH( ec_tempcart.last_changed_date ) as cart_month FROM ec_tempcart WHERE ec_tempcart.last_changed_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 DAY ) " . $product_where . "GROUP BY cart_day, cart_month ORDER BY ec_tempcart.last_changed_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'day' ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'day' ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_weekly_abandonment( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_tempcart.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT COUNT( ec_tempcart.session_id ) as total, DATE_FORMAT( DATE_SUB( ec_tempcart.last_changed_date, INTERVAL ( DAYOFWEEK( ec_tempcart.last_changed_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, WEEK( ec_tempcart.last_changed_date ) as cart_week, YEAR( ec_tempcart.last_changed_date ) as cart_year FROM ec_tempcart WHERE ec_tempcart.last_changed_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 WEEK ) " . $product_where . "GROUP BY cart_week, cart_year ORDER BY ec_tempcart.last_changed_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT COUNT( ec_tempcart.session_id ) as total, DATE_FORMAT( DATE_SUB( ec_tempcart.last_changed_date, INTERVAL ( DAYOFWEEK( ec_tempcart.last_changed_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, WEEK( ec_tempcart.last_changed_date ) as cart_week, YEAR( ec_tempcart.last_changed_date ) as cart_year FROM ec_tempcart WHERE ec_tempcart.last_changed_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 WEEK ) " . $product_where . "GROUP BY cart_week, cart_year ORDER BY ec_tempcart.last_changed_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'weeks', strtotime( '-' . date( 'w' ) . ' days' ) ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'week', strtotime( '-' . date( 'w' ) . ' days' ) ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_monthly_abandonment( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_tempcart.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT COUNT( ec_tempcart.session_id ) as total, DATE_FORMAT( DATE_SUB( ec_tempcart.last_changed_date, INTERVAL ( DAYOFMONTH( ec_tempcart.last_changed_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, MONTHNAME( ec_tempcart.last_changed_date ) AS cart_month, MONTH( ec_tempcart.last_changed_date ) as cart_month, YEAR( ec_tempcart.last_changed_date ) as cart_year FROM ec_tempcart WHERE ec_tempcart.last_changed_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 MONTH ) " . $product_where . "GROUP BY cart_month, cart_year ORDER BY ec_tempcart.last_changed_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT COUNT( ec_tempcart.session_id ) as total, DATE_FORMAT( DATE_SUB( ec_tempcart.last_changed_date, INTERVAL ( DAYOFMONTH( ec_tempcart.last_changed_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, MONTHNAME( ec_tempcart.last_changed_date ) AS cart_month, MONTH( ec_tempcart.last_changed_date ) as cart_month, YEAR( ec_tempcart.last_changed_date ) as cart_year FROM ec_tempcart WHERE ec_tempcart.last_changed_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 MONTH ) " . $product_where . "GROUP BY cart_month, cart_year ORDER BY ec_tempcart.last_changed_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'months', strtotime( '-' . (date( 'd' )-1) . ' days' ) ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'month', strtotime( '-' . (date( 'd' )-1) . ' days' ) ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_yearly_abandonment( $product_id ){
		$local_tz_diff = get_option( 'gmt_offset' );
		$sales = array( );
		$product_where = "";
		if( $product_id ){
			$product_where = $this->wpdb->prepare( "AND ec_tempcart.product_id = %d ", $product_id );
		}
		if( $local_tz_diff < 0 ){
			$sales_data = $this->wpdb->get_results( "SELECT COUNT( ec_tempcart.session_id ) as total, DATE_FORMAT( DATE_SUB( ec_tempcart.last_changed_date, INTERVAL ( DAYOFYEAR( ec_tempcart.last_changed_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, YEAR( ec_tempcart.last_changed_date ) as cart_year FROM ec_tempcart WHERE ec_tempcart.last_changed_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 14 YEAR ) " . $product_where . "GROUP BY cart_year ORDER BY ec_tempcart.last_changed_date DESC" );
		}else{
			$sales_data = $this->wpdb->get_results( "SELECT COUNT( ec_tempcart.session_id ) as total, DATE_FORMAT( DATE_SUB( ec_tempcart.last_changed_date, INTERVAL ( DAYOFYEAR( ec_tempcart.last_changed_date ) - 1 ) DAY ), '%m/%d/%Y' ) as date, YEAR( ec_tempcart.last_changed_date ) as cart_year FROM ec_tempcart WHERE ec_tempcart.last_changed_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 14 YEAR ) " . $product_where . "GROUP BY cart_year ORDER BY ec_tempcart.last_changed_date DESC" );
		}
		$current_index = 0;
		for( $i=0; $i<14; $i++ ){
			if( count( $sales_data ) > $current_index && $sales_data[$current_index]->date == date( 'm/d/Y', strtotime( '- ' . $i . 'years', strtotime( '-' . date('z') . ' days' ) ) ) ){
				$sales[] = $sales_data[$current_index];
				$current_index++;
			}else{
				$sales[] = (object) array( 'date' => date( 'm/d/Y', strtotime( '- ' . $i . 'years', strtotime( '-' . date('z') . ' days' ) ) ), 'total' => 0 );
			}
		}
		return $sales;
	}
	
	private function get_total_new_unviewed_orders( ){
		return $this->wpdb->get_var( "SELECT COUNT( ec_order.order_id ) as total FROM ec_order WHERE ec_order.order_viewed = 0" );
	}
	private function get_total_new_orders( ){
		$local_tz_diff = get_option( 'gmt_offset' );
		if( $local_tz_diff < 0 ){
			return $this->wpdb->get_var( "SELECT COUNT( ec_order.order_id ) as total FROM ec_order WHERE ec_order.order_date > DATE_SUB( DATE_SUB( UTC_TIMESTAMP( ), INTERVAL " . ($local_tz_diff*-1) . " HOUR ), INTERVAL 1 WEEK )" );
		}else{
			return $this->wpdb->get_var( "SELECT COUNT( ec_order.order_id ) as total FROM ec_order WHERE ec_order.order_date > DATE_SUB( DATE_ADD( UTC_TIMESTAMP( ), INTERVAL " . $local_tz_diff . " HOUR ), INTERVAL 1 WEEK )" );
		}
	}
	
	private function get_total_new_reviews( ){
		return $this->wpdb->get_var( "SELECT COUNT( ec_review.review_id ) as total FROM ec_review WHERE ec_review.approved = 0" );
	}
	
	private function get_total_cart_users( ){
		return $this->wpdb->get_var( "SELECT COUNT( ec_user.user_id ) as total FROM ec_user" );
	}
	/* END STATS FUNCTIONS */
	
	public function setup_menu( ){
		
		if( function_exists( 'wp_easycart_admin_license' ) ){
			$license = wp_easycart_admin_license( )->license_check();
		}
		
		if( !function_exists( 'wp_easycart_admin_license' ) || ( function_exists( 'wp_easycart_admin_license' ) && !wp_easycart_admin_license( )->active_license ) ){
			$registration_count = 1;
			$registration_label = sprintf( __( 'Registration %s' ), "<span class='update-plugins count-$registration_count' title='License'><span class='update-count'>" . number_format_i18n($registration_count) . "</span></span>" );
		} else {
			$registration_count = 0;
			$registration_label = sprintf( __( 'Registration %s' ), "<span class='update-plugins count-$registration_count' title='License'><span class='update-count'>" . number_format_i18n($registration_count) . "</span></span>" );
		}
		
		//new unread order notification
		$orders_count = $this->new_unviewed_orders;
		$order_label = sprintf( __( 'Orders %s' ), "<span class='update-plugins count-$orders_count' title='New Orders'><span class='update-count'>" . number_format_i18n($orders_count) . "</span></span>" );
		
		//total notifications
		$total_notifications = $registration_count + $orders_count;
		$mainmenu_label = sprintf( __( 'WP EasyCart %s' ), "<span class='update-plugins count-$total_notifications' title='New Orders'><span class='update-count'>" . number_format_i18n($total_notifications) . "</span></span>" );


		add_menu_page( 'WP EasyCart', $mainmenu_label, 'manage_options', 'wp-easycart-dashboard', array( $this, 'load_dashboard' ), 'dashicons-cart', 58 );
		add_menu_page( 'Extensions', 'Extensions', 'manage_options', 'ec_adminv2', array( $this, 'load_extensions_page' ), 'dashicons-cart', 59 );
	
		add_submenu_page( 'wp-easycart-dashboard', 'WP EasyCart Dashboard', 'Dashboard', 'manage_options', 'wp-easycart-dashboard', array( $this, 'load_dashboard' ) );
		//add_submenu_page( 'wp-easycart-dashboard', 'WP EasyCart Reports', 'Reports', 'manage_options', 'wp-easycart-reports', array( $this, 'load_reports' ) );
		add_submenu_page( 'wp-easycart-dashboard', 'WP EasyCart Products', 'Products', 'manage_options', 'wp-easycart-products', array( $this, 'load_products' ) );
		add_submenu_page( 'wp-easycart-dashboard', 'WP EasyCart Orders', $order_label, 'manage_options', 'wp-easycart-orders', array( $this, 'load_orders' ) );
		add_submenu_page( 'wp-easycart-dashboard', 'WP EasyCart Users', 'Users', 'manage_options', 'wp-easycart-users', array( $this, 'load_users' ) );
		add_submenu_page( 'wp-easycart-dashboard', 'WP EasyCart Marketing', 'Marketing', 'manage_options', 'wp-easycart-rates', array( $this, 'load_marketing' ) );
		add_submenu_page( 'wp-easycart-dashboard', 'WP EasyCart Settings', 'Settings', 'manage_options', 'wp-easycart-settings', array( $this, 'load_settings' ) );
		//add_submenu_page( 'wp-easycart-dashboard', 'WP EasyCart Extensions', 'Extensions', 'manage_options', 'wp-easycart-extensions', array( $this, 'load_extensions' ) );
		add_submenu_page( 'wp-easycart-dashboard', 'WP EasyCart Store Status', 'Store Status', 'manage_options', 'wp-easycart-status', array( $this, 'load_status' ) );
		add_submenu_page( 'wp-easycart-dashboard', 'WP EasyCart Registration', $registration_label , 'manage_options', 'wp-easycart-registration', array( $this, 'load_registration' ) );
		  
	}
	
	public function setup_pro_hooks( ){
		/* Products Tab*/
		add_action( 'wp_easycart_admin_subscription_plans_list', array( $this, 'show_upgrade' ) );
		add_action( 'wp_easycart_admin_subscription_plans_details', array( $this, 'show_upgrade' ) );
		add_filter( 'wp_easycart_admin_advanced_option_type', array( $this, 'filter_option_type' ) );
		
		/* Marketing Tab */
		add_action( 'wp_easycart_admin_subscriptions_list', array( $this, 'show_upgrade' ) );
		add_action( 'wp_easycart_admin_subscriptions_details', array( $this, 'show_upgrade' ) );
		add_action( 'wp_easycart_admin_downloads_list', array( $this, 'show_upgrade' ) );
		add_action( 'wp_easycart_admin_downloads_details', array( $this, 'show_upgrade' ) );
		add_action( 'wp_easycart_admin_abandon_cart_load', array( $this, 'show_upgrade' ) );
		add_action( 'wp_easycart_admin_coupon_list', array( $this, 'show_upgrade' ) );
		add_action( 'wp_easycart_admin_coupon_details', array( $this, 'show_upgrade' ) );
		add_action( 'wp_easycart_admin_giftcard_list', array( $this, 'show_upgrade' ) );
		add_action( 'wp_easycart_admin_giftcard_details', array( $this, 'show_upgrade' ) );
		add_action( 'wp_easycart_admin_promotion_list', array( $this, 'show_upgrade' ) );
		add_action( 'wp_easycart_admin_promotion_details', array( $this, 'show_upgrade' ) );
		
		$pro_plugin_base = 'wp-easycart-pro/wp-easycart-admin-pro.php';
		$pro_plugin_file = WP_PLUGIN_DIR . '/' . $pro_plugin_base;
		
		$pro_plugin_base_legacy = 'wp-easycart-admin/wp-easycart-admin-pro.php';
		$pro_plugin_file_legacy = WP_PLUGIN_DIR . '/' . $pro_plugin_base_legacy;
		
		if( file_exists( $pro_plugin_file ) || file_exists( $pro_plugin_file_legacy ) ){
			remove_action( 'wp_easycart_admin_messages', array( wp_easycart_admin( ), 'load_upsell_image' ) );
			add_filter( 'wp_easycart_admin_lock_icon', array( $this, 'remove_lock_icon' ) );
			remove_filter( 'wp_easycart_admin_advanced_option_type', array( $this, 'filter_option_type' ) );
			remove_action( 'wp_dashboard_setup', array( $this, 'add_ec_nag_widget' ) );
		}
		
		do_action( 'wp_easycart_admin_pro_ready' );
	}
	
	public function remove_lock_icon( $content ){
		return "";
	}
	
	public function load_dashboard( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_dashboard_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	
	public function load_dashboard_content( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/dashboard.php' );
	}
	
	public function load_extensions_page( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_extensions_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	
	public function load_reports( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_reports_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	
	public function load_reports_content( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/reports.php' );
	}
	
	public function load_admin( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_admin_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	
	public function load_admin_content( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/admin.php' );
	}
	
	public function load_settings( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_settings_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	
	public function load_products( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_products_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	
	public function load_orders( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_orders_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	
	public function load_users( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_users_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	
	public function load_marketing( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_marketing_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	
	public function load_status( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_status_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	public function load_registration( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_registration_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	
	public function init_shipping_data( ){
	
		$this->settings = $this->wpdb->get_row( "SELECT * FROM ec_setting" );
		$this->shipping_zones = $this->wpdb->get_results( "SELECT * FROM ec_zone ORDER BY zone_name ASC" );
		$this->shipping_zones_items = $this->wpdb->get_results( "SELECT ec_zone_to_location.zone_to_location_id, ec_zone_to_location.zone_id, ec_zone_to_location.iso2_cnt, ec_zone_to_location.code_sta, ec_country.name_cnt AS country_name, ec_state.name_sta AS state_name FROM ec_zone, ec_zone_to_location LEFT JOIN ec_country ON ec_country.iso2_cnt = ec_zone_to_location.iso2_cnt LEFT JOIN ec_state ON ( ec_state.code_sta = ec_zone_to_location.code_sta AND ec_state.idcnt_sta =  ec_country.id_cnt ) WHERE ec_zone.zone_id = ec_zone_to_location.zone_id ORDER BY ec_zone.zone_name ASC" );
		$this->countries = $this->wpdb->get_results( "SELECT * FROM ec_country ORDER BY sort_order ASC" );
		$this->states = $this->wpdb->get_results( "SELECT ec_state.*, ec_country.name_cnt as country_name FROM ec_state LEFT JOIN ec_country ON ec_country.id_cnt = ec_state.idcnt_sta ORDER BY ec_state.sort_order ASC" );
								
	}
		
	public function load_settings_content( ){
			
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/setup-actions.php' );
		$ec_admin_settings = new ec_admin_settings( );
		
		// Try to Process Form Actions if Needed
		if( isset( $_POST['ec_admin_settings_action'] ) ){
			$ec_admin_settings->process_form_action( $_POST['ec_admin_settings_action'] );
		}
		
		$this->init_shipping_data( );
		global $wpdb;
		if( !get_option( 'ec_option_setup_wizard_done' ) && $result = $wpdb->get_row( "SELECT product_id FROM ec_product LIMIT 1" ) ){
		   update_option( 'ec_option_setup_wizard_done', 1 );
    	}
		
		// Display Page Setup
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "setup-wizard" ){
			wp_easycart_admin_setup_wizard( )->load_setup_wizard( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "initial-setup" ){
			if( !get_option( 'ec_option_setup_wizard_done' ) ){
				wp_easycart_admin_setup_wizard( )->load_setup_wizard( );
			}else{
				wp_easycart_admin_initial_setup( )->load_initial_setup( );
			}
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "products" ){
			wp_easycart_admin_products( )->load_products_setup( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "tax" ){
			 wp_easycart_admin_taxes( )->load_tax_setup( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "shipping-settings" ){
			$shipping = new wp_easycart_admin_shipping( );
			$shipping->load_shipping_setup( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "shipping-rates" ){
			$shipping = new wp_easycart_admin_shipping( );
			$shipping->load_shipping_rates( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "payment" ){
			wp_easycart_admin_payments( )->load_payments( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "checkout" ){
			$checkout = new wp_easycart_admin_checkout( );
			$checkout->load_checkout( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "account" ){
			$account = new wp_easycart_admin_account( );
			$account->load_account( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "miscellaneous"){
			wp_easycart_admin_miscellaneous( )->load_miscellaneous( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "language-editor" ){
			$language_editor = new wp_easycart_admin_language_editor( );
			$language_editor->load_language( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "design" ){
			$design = new wp_easycart_admin_design( );
			$design->load_design( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "third-party" ){
			wp_easycart_admin_third_party( )->load_third_party( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "email-setup" ){
			$email = new wp_easycart_admin_email_settings( );
			$email->load_email( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "cart-importer" ){
			wp_easycart_admin_cart_importer( )->load_cart_importer( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "country" ){
			wp_easycart_admin_country( )->load_country_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "states" ){
			wp_easycart_admin_states( )->load_states_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "perpage" ){
			wp_easycart_admin_perpage( )->load_perpage_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "pricepoint" ){
			wp_easycart_admin_pricepoint( )->load_pricepoint_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "logs" ){
			wp_easycart_admin_logging( )->load_log_list( );
		}else{
			if( !get_option( 'ec_option_setup_wizard_done' ) ){
				wp_easycart_admin_setup_wizard( )->load_setup_wizard( );
			}else{
				wp_easycart_admin_initial_setup( )->load_initial_setup( );
			}
		}
	}
	
	public function load_products_content( ){
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "option" ){
			wp_easycart_admin_option( )->load_option_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "inventory" ){
			wp_easycart_admin_inventory( )->load_inventory_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "optionitems" ){
			wp_easycart_admin_option( )->load_optionitem_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "category" ){
			wp_easycart_admin_category( )->load_category_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "category-products" ){
			wp_easycart_admin_category( )->load_category_product_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "category-products-manage" ){
			wp_easycart_admin_category( )->load_category_product_manage_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "menus" ){
			wp_easycart_admin_menus( )->load_menus_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "submenus" ){
			wp_easycart_admin_menus( )->load_submenus_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "subsubmenus" ){
			wp_easycart_admin_menus( )->load_subsubmenus_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "manufacturers" ){
			wp_easycart_admin_manufacturers( )->load_manufacturers_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "reviews" ){
			wp_easycart_admin_reviews( )->load_reviews_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "subscriptionplans" ){
			wp_easycart_admin_subscription_plans( )->load_subscription_plans_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "products" ){
			wp_easycart_admin_products( )->load_products_list( );
		}else{
			wp_easycart_admin_products( )->load_products_list( );
		}
	}
	
	public function load_orders_content( ){
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "orders" ){
			wp_easycart_admin_orders( )->load_orders_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "subscriptions" ){
			$subscriptions = new wp_easycart_admin_subscriptions( );
			$subscriptions->load_subscriptions_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "downloads" ){
			$downloads = new wp_easycart_admin_downloads( );
			$downloads->load_downloads_list( );
		}else{
			wp_easycart_admin_orders( )->load_orders_list( );
		}
	}
	
	public function load_users_content( ){
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "accounts" ){
			wp_easycart_admin_users( )->load_users_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "user-roles" ){
			wp_easycart_admin_user_role( )->load_user_role_list( );
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "subscribers" ){
			wp_easycart_admin_subscribers( )->load_subscriber_list( );
		}else{
			wp_easycart_admin_users( )->load_users_list( );
		}
	}
	
	public function load_marketing_content( ){
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "gift-cards" ){
			$giftcards = new wp_easycart_admin_giftcards( );
			$giftcards = $giftcards->load_giftcards_list();
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "coupons" ){
			$coupons = new wp_easycart_admin_coupons( );
			$coupons = $coupons->load_coupons_list();
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "promotions" ){
			$promotions = new wp_easycart_admin_promotions( );
			$promotions = $promotions->load_promotions_list();
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "abandon-cart" ){
			$abandon_cart = new wp_easycart_admin_abandon_cart( );
			$abandon_cart->load_abandon_cart( );
		}else{
			$giftcards = new wp_easycart_admin_giftcards( );
			$giftcards = $giftcards->load_giftcards_list();
		}
	}
	
	public function load_status_content( ){
		wp_easycart_admin_store_status( )->load_status( );
	}
	
	public function load_registration_content( ){
		$registration = new wp_easycart_admin_registration( );
		$registration->load_registration_status( );
	}
	
	public function load_shipping_form( $shipping_type ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/shipping/' . $shipping_type . '.php' );
	}
	
	public function load_extensions( ){
		add_action( 'wp_easycart_admin_shell_content', array( $this, 'load_extensions_content' ), 1, 0 );
		$this->load_admin_shell( );
	}
	
	public function load_extensions_content( ){
		wp_easycart_admin_extensions( )->load_extensions( );
	}
	
	private function load_admin_shell( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/shell.php' );
	}
	
	public function load_mobile_navigation( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/mobile_nav.php' );
	}
	
	public function load_left_navigation( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/left_nav.php' );
	}
	
	public function load_head_navigation( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/head_nav.php' );
	}
	
	public function set_title( $admin_title, $title ){
		if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && ( !isset( $_GET['subpage'] ) || $_GET['subpage'] == "products" ) ){
			return 'WP EasyCart Products';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "inventory" ){
			return 'WP EasyCart Inventory';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && isset( $_GET['subpage'] ) && ( $_GET['subpage'] == "option" || $_GET['subpage'] == "optionitems" ) ){
			return 'WP EasyCart Option Sets';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && isset( $_GET['subpage'] ) && ( $_GET['subpage'] == "category" || $_GET['subpage'] == "category-products" || $_GET['subpage'] == "category-products-manage" ) ){
			return 'WP EasyCart Categories';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && isset( $_GET['subpage'] ) && ( $_GET['subpage'] == "menus" || $_GET['subpage'] == "submenus" || $_GET['subpage'] == "subsubmenus" ) ){
			return 'WP EasyCart Menus';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "manufacturers" ){
			return 'WP EasyCart Manufacturers';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "reviews" ){
			return 'WP EasyCart Product Reviews';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "subscriptionplans" ){
			return 'WP EasyCart Subscription Plans';
		
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-orders" && ( !isset( $_GET['subpage'] ) || $_GET['subpage'] == "orders" ) ){
			return 'WP EasyCart Orders';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-orders" && isset( $_GET['subpage'] )&& $_GET['subpage'] == "subscriptions" ){
			return 'WP EasyCart Subscriptions';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-orders" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "downloads" ){
			return 'WP EasyCart Downloads';
		
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-users" && ( !isset( $_GET['subpage'] ) || $_GET['subpage'] == "accounts" ) ){
			return 'WP EasyCart User Accounts';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-users" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "user-roles" ){
			return 'WP EasyCart User Roles';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-users" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "subscribers" ){
			return 'WP EasyCart Subscribers';
			
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-rates" && ( !isset( $_GET['subpage'] ) || $_GET['subpage'] == "gift-cards" ) ){
			return 'WP EasyCart Gift Cards';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-rates" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "coupons" ){
			return 'WP EasyCart Coupons';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-rates" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "promotions" ){
			return 'WP EasyCart Promotions';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-rates" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "abandon-cart" ){
			return 'WP EasyCart Abandoned Cart';
		
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && ( !isset( $_GET['subpage'] ) || $_GET['subpage'] == "initial-setup" ) ){
			return 'WP EasyCart Initial Setup';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "products" ){
			return 'WP EasyCart Product Settings';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "tax" ){
			return 'WP EasyCart Tax Settings';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "shipping-settings" ){
			return 'WP EasyCart Shipping Settings';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "shipping-rates" ){
			return 'WP EasyCart Shipping Rates';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "payment" ){
			return 'WP EasyCart Payment Settings';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "checkout" ){
			return 'WP EasyCart Checkout Settings';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "account" ){
			return 'WP EasyCart Account Settings';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "miscellaneous" ){
			return 'WP EasyCart Additional Settings';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "language-editor" ){
			return 'WP EasyCart Language Editor';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "design" ){
			return 'WP EasyCart Design Settings';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "email-setup" ){
			return 'WP EasyCart Email Setup';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "third-party" ){
			return 'WP EasyCart Third Party Settings';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "cart-importer" ){
			return 'WP EasyCart Cart Importer';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "country" ){
			return 'WP EasyCart Country Management';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "states" ){
			return 'WP EasyCart State Management';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "perpage" ){
			return 'WP EasyCart Per Page Settings';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "pricepoint" ){
			return 'WP EasyCart Price Point Settings';
		}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "logs" ){
			return 'WP EasyCart Logs';
		
		}else{
			return $admin_title;
		}
	}
	
	public function load_block_editor_assets( ){
		if( current_user_can( 'manage_options' ) && is_admin( ) ){
			wp_register_script( 'wp_easycart_block_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/block.js' ), array( 'wp-blocks', 'wp-i18n', 'wp-element' ), EC_CURRENT_VERSION );
			wp_enqueue_script( 'wp_easycart_block_js' );
			wp_localize_script( 'wp_easycart_block_js', 'wp_easycart_categories', $this->get_categories_cdata( ) );
			wp_localize_script( 'wp_easycart_block_js', 'wp_easycart_manufacturers', $this->get_manufacturers_cdata( ) );
			wp_localize_script( 'wp_easycart_block_js', 'wp_easycart_menulevel1', $this->get_menu_level1_cdata( ) );
			wp_localize_script( 'wp_easycart_block_js', 'wp_easycart_menulevel2', $this->get_menu_level2_cdata( ) );
			wp_localize_script( 'wp_easycart_block_js', 'wp_easycart_menulevel3', $this->get_menu_level3_cdata( ) );
			wp_localize_script( 'wp_easycart_block_js', 'wp_easycart_products', $this->get_products_cdata( ) );
			wp_localize_script( 'wp_easycart_block_js', 'wp_easycart_products_model', $this->get_products_model_cdata( ) );
		}
	}
	
	private function get_categories_cdata( ){
		global $wpdb;
		return $wpdb->get_results( "SELECT category_id AS value, category_name AS label FROM ec_category ORDER BY category_name ASC LIMIT 2000" );
	}
	
	private function get_manufacturers_cdata( ){
		global $wpdb;
		return $wpdb->get_results( "SELECT manufacturer_id AS value, ec_manufacturer.`name` AS label FROM ec_manufacturer ORDER BY ec_manufacturer.`name` ASC LIMIT 2000" );
	}
	
	private function get_menu_level1_cdata( ){
		global $wpdb;
		return $wpdb->get_results( "SELECT menulevel1_id AS value, ec_menulevel1.`name` AS label FROM ec_menulevel1 ORDER BY ec_menulevel1.`name` ASC LIMIT 2000" );
	}
	
	private function get_menu_level2_cdata( ){
		global $wpdb;
		return $wpdb->get_results( "SELECT menulevel1_id, menulevel2_id AS value, ec_menulevel2.`name` AS label FROM ec_menulevel2 ORDER BY ec_menulevel2.`name` ASC LIMIT 2000" );
	}
	
	private function get_menu_level3_cdata( ){
		global $wpdb;
		return $wpdb->get_results( "SELECT menulevel2_id, menulevel3_id AS value, ec_menulevel3.`name` AS label FROM ec_menulevel3 ORDER BY ec_menulevel3.`name` ASC LIMIT 2000" );
	}
	
	private function get_products_cdata( ){
		global $wpdb;
		return $wpdb->get_results( "SELECT product_id AS value, ec_product.`title` AS label FROM ec_product ORDER BY ec_product.`title` ASC LIMIT 2000" );
	}
	
	private function get_products_model_cdata( ){
		global $wpdb;
		return $wpdb->get_results( "SELECT model_number AS value, ec_product.`title` AS label FROM ec_product ORDER BY ec_product.`title` ASC LIMIT 2000" );
	}
	
	public function load_scripts( ){
		
		if( current_user_can( 'manage_options' ) ){
			$https_link = "";
			if( class_exists( "WordPressHTTPS" ) ){
				$https_class = new WordPressHTTPS( );
				$https_link = $https_class->makeUrlHttps( admin_url( 'admin-ajax.php' ) );
			}else{
				$https_link = str_replace( "http://", "https://", admin_url( 'admin-ajax.php' ) );
			}
			
			wp_register_style( 'wp_easycart_deactivate_css', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/css/deactivate.css' ), array( ), EC_CURRENT_VERSION );
			wp_enqueue_style( 'wp_easycart_deactivate_css' );
			
			wp_register_script( 'wp_easycart_deactivate_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/deactivate.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
			wp_enqueue_script( 'wp_easycart_deactivate_js' );
			
			if( is_ssl( ) ){
				wp_localize_script( 'wp_easycart_deactivate_js', 'ajax_object', array( 'ajax_url' => $https_link ) );
			}else{
				wp_localize_script( 'wp_easycart_deactivate_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
			}
		}
		
		if( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && ( substr( $_GET['page'], 0, 11 ) == "wp-easycart" || $_GET['page'] == 'ec_adminv2' ) ){
			
			$https_link = "";
			if( class_exists( "WordPressHTTPS" ) ){
				$https_class = new WordPressHTTPS( );
				$https_link = $https_class->makeUrlHttps( admin_url( 'admin-ajax.php' ) );
			}else{
				$https_link = str_replace( "http://", "https://", admin_url( 'admin-ajax.php' ) );
			}
			
			wp_enqueue_media( );
			
			wp_enqueue_style( 'wp_easycart_select2_css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' );
			wp_enqueue_script( 'wp_easycart_select2_js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery') );
 			
			wp_register_script( 'wp_easycart_admin_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/admin.js' ), array( 'jquery', 'jquery-ui-sortable', 'wp-color-picker' ), EC_CURRENT_VERSION );
			wp_enqueue_script( 'wp_easycart_admin_js' );
			if( is_ssl( ) ){
				wp_localize_script( 'wp_easycart_admin_js', 'ajax_object', array( 'ajax_url' => $https_link ) );
			}else{
				wp_localize_script( 'wp_easycart_admin_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
			}
			
			wp_register_script( 'wp_easycart_charts_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/Chart.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
			wp_enqueue_script( 'wp_easycart_charts_js' );
			
			wp_register_script( 'wp_easycart_validation_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/validation.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
			wp_enqueue_script( 'wp_easycart_validation_js' );
			
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_register_style( 'wpeasycart-jquery-ui-css', 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
			wp_enqueue_style( 'wpeasycart-jquery-ui-css' );
			wp_enqueue_style( 'wp-color-picker' );
			
			if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "category" ){
				wp_register_script( 'wp_easycart_admin_category_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/category.js' ), array( 'jquery', 'jquery-ui-sortable' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_category_js' );	
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-orders" && ( !isset( $_GET['subpage'] ) || $_GET['subpage'] == "orders" ) ){
				wp_register_script( 'wp_easycart_admin_orders_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/orders.js' ), array( 'jquery', 'jquery-ui-datepicker' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_orders_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "menus" ){
				wp_register_script( 'wp_easycart_admin_menus_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/menus.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_menus_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && isset( $_GET['subpage'] ) && ( $_GET['subpage'] == "option" || $_GET['subpage'] == "optionitems" ) ){
				wp_register_script( 'wp_easycart_admin_option_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/option.js' ), array( 'jquery', 'jquery-ui-sortable' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_option_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && ( !isset( $_GET['subpage'] ) || $_GET['subpage'] == "products" ) ){
				wp_register_script( 'wp_easycart_admin_product_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/products.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_product_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-users" && ( !isset( $_GET['subpage'] ) || $_GET['subpage'] == "accounts" || $_GET['subpage'] == "user-roles" ) ){
				wp_register_script( 'wp_easycart_admin_users_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/users.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_users_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && ( !isset( $_GET['subpage'] ) || $_GET['subpage'] == "initial-setup" ) ){
				wp_register_script( 'wp_easycart_admin_initial_setup_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/initial-setup.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_initial_setup_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "products" ){
				wp_register_script( 'wp_easycart_admin_products_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/products.js' ), array( 'jquery', 'jquery-ui-sortable' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_products_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "tax" ){
				wp_register_script( 'wp_easycart_admin_tax_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/tax.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_tax_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "shipping-settings" ){
				wp_register_script( 'wp_easycart_admin_shipping_settings_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/shipping-settings.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_shipping_settings_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "shipping-rates" ){
				wp_register_script( 'wp_easycart_admin_shipping_rates_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/shipping-rates.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_shipping_rates_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "payment" ){
				wp_register_script( 'wp_easycart_admin_payment_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/payment.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_payment_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "checkout" ){
				wp_register_script( 'wp_easycart_admin_checkout_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/checkout.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_checkout_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "account" ){
				wp_register_script( 'wp_easycart_admin_account_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/account.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_account_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "miscellaneous" ){
				wp_register_script( 'wp_easycart_admin_miscellaneous_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/miscellaneous.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_miscellaneous_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "language-editor" ){
				wp_register_script( 'wp_easycart_admin_language_editor_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/language-editor.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_language_editor_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "design" ){
				wp_register_script( 'wp_easycart_admin_design_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/design.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_design_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "third-party" ){
				wp_register_script( 'wp_easycart_admin_third_party_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/third-party.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_third_party_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "email-setup" ){
				wp_register_script( 'wp_easycart_admin_email_settings_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/email-settings.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_email_settings_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "cart-importer" ){
				wp_register_script( 'wp_easycart_admin_cart_importer_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/cart-importer.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_cart_importer_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && isset( $_GET['subpage'] ) && $_GET['subpage'] == "pricepoint" ){
				wp_register_script( 'wp_easycart_admin_pricepoint_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/pricepoint.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_pricepoint_js' );
			}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" && ( !isset( $_GET['subpage'] ) || $_GET['subpage'] == "setup-wizard" ) ){
				wp_register_script( 'wp_easycart_admin_product_js', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/js/products.js' ), array( 'jquery' ), EC_CURRENT_VERSION );
				wp_enqueue_script( 'wp_easycart_admin_product_js' );
			}
			
			wp_register_style( 'wp_easycart_admin_css', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/css/admin.css' ), array( ), EC_CURRENT_VERSION );
			wp_enqueue_style( 'wp_easycart_admin_css' );
			
			wp_register_style( 'wp_easycart_upgrade_css', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/css/upgrade.css' ), array( ), EC_CURRENT_VERSION );
			wp_enqueue_style( 'wp_easycart_upgrade_css' );
			
			add_editor_style( );
			add_thickbox( );
			wp_enqueue_script('common');
			wp_enqueue_script( 'post' );
			wp_enqueue_script('jquery-color');
			wp_enqueue_script( 'editor' );
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'tiny_mce' );
			wp_enqueue_script( 'editorremov' );
			wp_enqueue_script( 'editor-functions' );
				
		}
		
		wp_register_style( 'wp_easycart_editor_css', plugins_url( EC_PLUGIN_DIRECTORY . '/admin/css/editor.css' ), array( ), EC_CURRENT_VERSION );
		wp_enqueue_style( 'wp_easycart_editor_css' );
		
		wp_localize_script( 'wp_easycart_admin_js', 'wp_easycart_admin_vars', array(
			'ajaxURL' => admin_url( 'admin-ajax.php' ),
			'ec_option_newsletter_done' => ( ( get_option( 'ec_option_bcc_email_addresses' ) != 'youremail@url.com' || get_option( 'ec_option_newsletter_done' ) ) ? 1 : 0 ),
			'ec_option_currency'		=> get_option( 'ec_option_currency' )
		) );
	}
	
	public function wp_easycart_pro_check( ){
		$pro_plugin_base = 'wp-easycart-pro/wp-easycart-admin-pro.php';
		$pro_plugin_file = WP_PLUGIN_DIR . '/' . $pro_plugin_base;
		if( file_exists( $pro_plugin_file ) && !is_plugin_active( $pro_plugin_base ) ) {
			echo '<div class="updated">';
			echo '<p>WP EasyCart PRO is installed but NOT ACTIVATED. Please <a href="' . $this->get_pro_activation_link( ) . '">click here to activate your WP EasyCart PRO plugin</a>.</p>';
			echo '</div>';
		}
	}
	
	public function elementor_check( ){
		if( !get_option( 'ec_option_hide_elementor_notice' ) ){
			$elementor_plugin_base = 'elementor/elementor.php';
			$elementor_plugin_file = WP_PLUGIN_DIR . '/' . $elementor_plugin_base;
			if( file_exists( $elementor_plugin_file ) && is_plugin_active( $elementor_plugin_base ) ) {
				echo '<div class="updated" style="position:relative;" id="wp_easycart_elementor_notice">';
				echo '<p>Elementor can cause issues with WP EasyCart. If you are having issues, please <a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=elementor-page-builder" target="_blank">read more by clicking here</a> as the issue is easy to resolve!</p>';
				echo '<button type="button" class="notice-dismiss" onclick="wp_easycart_hide_elementor_notice( );"><span class="screen-reader-text">Dismiss this notice.</span></button>';
				echo '</div>';
				echo "<script>
				function wp_easycart_hide_elementor_notice( ){
					jQuery( document.getElementById( 'wp_easycart_elementor_notice' ) ).fadeOut( 'slow' );
					var data = {
						action: 'ec_admin_ajax_hide_elementor_notice'
					};
					jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ } } );
				}
				</script>";
			}
		}
	}
	
	public function get_pro_activation_link( ){ 
		$pro_plugin_file = WP_PLUGIN_DIR . '/wp-easycart-pro/wp-easycart-admin-pro.php';
		if( strpos( $pro_plugin_file, '/' ) ){
			$pro_plugin_file = str_replace( '/', '%2F', $pro_plugin_file );
		}
		$activate_url = sprintf( admin_url( 'plugins.php?action=activate&plugin=%s&plugin_status=all&paged=1&s' ), $pro_plugin_file ); 
		$_REQUEST['plugin'] = $pro_plugin_file;
		$activate_url = wp_nonce_url( $activate_url, 'activate-plugin_' . $pro_plugin_file );
		return $activate_url;
	}
	
	public function print_admin_message( ){
		$success_messages = apply_filters( 'wp_easycart_admin_success_messages', array( ) );
		$warning_messages = apply_filters( 'wp_easycart_admin_warning_messages', array( ) );
		$error_messages = apply_filters( 'wp_easycart_admin_error_messages', array( ) );
		
		// Lets make sure there are no DB errors
		$db_error = ( wp_easycart_admin_store_status( )->wpeasycart_is_database_setup( ) ) ? 0 : 1;
		
		if( count( $success_messages ) > 0 ){
			echo '<div id="ec_message" class="ec_admin_message_success"><div class="dashicons-before dashicons-thumbs-up"></div>' . implode( ', ', $success_messages ) . '</div>';
		
		}else if( count( $warning_messages ) > 0 ){
			echo '<div id="ec_message" class="ec_admin_message_warning"><div class="dashicons-before dashicons-warning"></div>' . implode( ', ', $warning_messages ) . '</div>';
		
		}else if( count( $error_messages ) > 0 ){
			echo '<div id="ec_message" class="ec_admin_message_error"><div class="dashicons-before dashicons-thumbs-down"></div>' . implode( ', ', $error_messages ) . '</div>';
		
		}
		
		if( $db_error ){
			echo '<div id="ec_message" class="ec_admin_message_error">' . wp_easycart_admin_store_status( )->ec_get_database_error( ) . ' - Please read more about this issue here: <a href="http://docs.wpeasycart.com/wp-easycart-installation-guide/?section=moving-easycart-to-new-website" target="_blank">Database Troubleshooting</a></div>';
		}
		
		if( !get_option( 'ec_option_allow_tracking' ) ){
			echo '<div id="ec_message" class="ec_admin_message_success ec_admin_allow_tracking">Please help improve WP EasyCart by sending us <a href="https://www.wpeasycart.com/terms-and-conditions/" target="_blank">basic usage data</a> for your plugin. <a href="admin.php?page=wp-easycart-settings&subpage=miscellaneous&ec_admin_form_action=allow-usage-tracking" class="ec_admin_tracking_allow" onclick="wp_easycart_allow_tracking( ); jQuery( this ).parent( ).fadeOut( ); return false;">allow</a><a href="admin.php?page=wp-easycart-settings&subpage=miscellaneous&ec_admin_form_action=deny-usage-tracking" class="ec_admin_tracking_deny" onclick="wp_easycart_deny_tracking( ); jQuery( this ).parent( ).fadeOut( ); return false;">deny</a></div>';
		}
	}
	
	public function load_upsell_image( ){
		if( isset( $_GET['page'] ) && $_GET['page'] == 'wp-easycart-settings' && !isset( $_GET['subpage'] ) )
			return;
		
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == 'setup-wizard' )
			return;
		
		echo '<div style="width:100%; text-align:center; max-width:100%;"><a href="admin.php?page=wp-easycart-registration&ec_trial=start"><img src="' . plugins_url( 'wp-easycart/admin/images/banner-ad-1-750x100.jpg' ) . '" style="max-width:100%; height:auto;" alt="Start Your PRO Trial Today!" /></a></div>';
	}
	
	public function load_upsell_popup( ){
		echo '<div id="ec_admin_upsell_popup"><div class="ec_admin_upsell_popup_close"><a href="#" onclick="hide_pro_required( ); return false;"><div class="dashicons-before dashicons-dismiss"></div></a></div><div class="ec_admin_upsell_popup_inner"><div class="ec_admin_upsell_popup_content">';
		$this->show_upgrade( );
		echo '<div style="clear:both;"></div></div></div></div>';
		echo '<script>jQuery( document.getElementById( \'ec_admin_upsell_popup\' ) ).appendTo( document.body );</script>';
	}
	
	public function show_upgrade( ){
		include( apply_filters( 'wp_easycart_admin_upgrade_file', WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/upgrade/upgrade-screen.php' ) );
	}
	
	public function load_new_slideout( $slide ){
		if( $slide == 'product' ){
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/products/products/new-product-slideout.php' );
		
		}else if( $slide == 'manufacturer' ){
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/products/manufacturers/new-manufacturer-slideout.php' );
		
		}else if( $slide == 'optionset' ){
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/products/options/new-optionset-slideout.php' );
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/products/options/new-optionitem-slideout.php' );
		
		}else if( $slide == 'advanced-optionset' ){
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/products/options/new-advanced-optionset-slideout.php' );
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/products/options/new-advanced-optionitem-slideout.php' );
		
		}else if( $slide == 'order' ){
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/orders/orders/order-quick-edit-slideout.php' );
		
		}
	}
	
	public function filter_option_type( ){
		return 'upgrade_required';
	}
	
	public function redirect( $page, $subpage, $args ){
		$url = $this->get_redirect_url( $page, $subpage, $args );
		wp_redirect( $url );
		exit( );
	}
	
	private function get_redirect_url( $page, $subpage, $args ){
		$url = "admin.php?page=" . $page . "&subpage=" . $subpage;
		foreach( $args as $key => $value ){
			$url .= "&" . $key . '=' . $value;
		}
		return $url;
	}
	
	public function start_pro_trial( ){
		
		// Required Trial Info
		$current_user = wp_get_current_user( );
		$name = $current_user->user_firstname . " " . $current_user->user_lastname;
		$email = $current_user->user_email;
		
		// Try and Install PRO
		if( !file_exists( WP_PLUGIN_DIR . '/' . EC_PLUGIN_DIRECTORY . '-pro/wp-easycart-admin-pro.php' ) ){
			$this->install_pro_plugin(  );
		}
		
		if( !file_exists( WP_PLUGIN_DIR . '/' . EC_PLUGIN_DIRECTORY . '-pro/wp-easycart-admin-pro.php' ) ){
			echo "Error installing the WP EasyCart PRO plugin. Please try again or contact support@wpeasycart.com for assistance.";
			die( );
		}
		
		if( !is_plugin_active( 'wp-easycart-pro/wp-easycart-admin-pro.php' ) ){
			activate_plugin( WP_PLUGIN_DIR . '/' . EC_PLUGIN_DIRECTORY . '-pro/wp-easycart-admin-pro.php', NULL, 0, 1 );
		}
		
		if( !is_plugin_active( 'wp-easycart-pro/wp-easycart-admin-pro.php' ) ){
			echo "Error activating WP EasyCart PRO, please visit your plugins page and click activate or contact support@wpeasycart.com for assistance.";
			die( );
		}
		
		if( !class_exists( 'ec_license_manager' ) ){
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '-pro/license/ec_license_manager.php' );
		}
		
		// Get Key and License the Trial
		$license_key = $this->create_trial_license( $name, $email );
		if( !$license_key ){
			echo "Error creating trial key. Something may be wrong with our server, please contact support@wpeasycart.com for assistance.<br>";
			die( );
			
		}else if( $license_key == "key_exists" ){
			// Should load from 
			
		}else{
			$license_manager = new ec_license_manager( );
			$license_manager->ec_activate_license( $name, $email, $license_key );
		}
	}
	
	private function install_pro_plugin( $is_trial = 1 ){
		
		// Echo out html for screen
		echo '<html>';
			echo '<head>';
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				echo '<title>Install WP EasyCart PRO</title>';
				echo '<style type="text/css">';
					echo 'html{ height:100%; margin:0; padding:0; }';
					echo 'body{ display:block; height:100%; margin:0; padding:0; color:#444; font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif; font-size:13px; line-height:1.4em; min-width:600px; }';
					echo 'img{ display:block; margin:0 auto; }';
					echo '.box-container{ -moz-box-shadow:0px 0px 100px rgba(0, 0, 0, 0.5); -webkit-box-shadow:0px 0px 100px rgba(0, 0, 0, 0.5); box-shadow:0px 0px 100px rgba(0, 0, 0, 0.5); -moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px; position:fixed; top:15%; left:50%; width:550px; margin:0 0 0 -225px; background:#FFF; overflow:auto; padding:0px; -webkit-box-sizing:border-box; -moz-box-sizing:border-box; box-sizing:border-box; z-index:99999; }';
					echo '.box-container > div{ padding:25px; border-color:#FFFFFF; border-width:4px; border-style:solid; border-radius:0px; }';
					echo 'h1{ font-weight:normal; margin:10px 0 25px; text-align:center; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif; font-size:26px; }';
					echo 'a{ background:#79af40; margin:15px auto 0; display:block; text-align:center; color:#FFF; padding:12px 20px; border-radius:5px; text-decoration:none; font-size:16px; font-weight:normal; }';
					echo 'a:hover{ background:#92c845; }';
				echo '</style>';
			echo '</head>';
			echo '<body style="background:#f7f4e8;" bgcolor="#f7f4e8">';
				echo '<div class="box-container"><div>';
				echo '<img src="https://www.wpeasycart.com/wp-content/uploads/2018/01/easycart-logo-1-11-2018.png" alt="WP EasyCart" title="WP EasyCart" />';
		
		$url = "https://connect.wpeasycart.com/downloads/professional-admin/wp-easycart-pro.zip";
		$method = '';

		if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, array() ) ) ) {
			return false;
		}

		if ( ! WP_Filesystem( $creds ) ) {
			request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, array() );
			return false;
		}

		if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		$title     = "Installing WP EasyCart PRO";
		$skin_args = array(
			'type'   => 'web',
			'title'  => sprintf( $title, 'WP EasyCart PRO' ),
			'url'    => esc_url_raw( $url ),
			'nonce'  => 'install-plugin_wp-easycart-pro',
			'plugin' => 'wp-easycart-pro',
			'extra'  => array( ),
		);
		
		add_filter( 'install_plugin_complete_actions', array( $this, 'remove_actions_install', 3 ) );
		$skin = new Plugin_Installer_Skin( $skin_args );
		$upgrader = new Plugin_Upgrader( $skin );
		$upgrader->install( $skin_args['url'] );
		
		if( $is_trial ){
			echo '<a href="admin.php?page=wp-easycart-registration&ec_trial=start">CLICK HERE TO COMPLETE INSTALLATION</a>';
		}else{
			echo '<a href="admin.php?page=wp-easycart-registration&ec_install=pro">CLICK HERE TO COMPLETE INSTALLATION</a>';
		}
		
		echo '</div></div></body></html>';
		
		die( );
	}
	
	private function remove_actions_install( $actions, $api, $file ){
		return array( '' );
	}
	
	private function create_trial_license( $name, $email ){
		$action_url = 'https://support.wpeasycart.com/trial/start/start.php';

		$url = site_url( );
		$url = str_replace( 'http://', '', $url );
		$url = str_replace( 'https://', '', $url );
		$url = str_replace( 'www.', '', $url );
		
		$action_url .= '?ec_action=start_trial';
		$action_url .= '&site_url=' . esc_attr( $url );
		$action_url .= '&customername=' . esc_attr( $name );
		$action_url .= '&customeremail=' . esc_attr( $email );
		
		$response = wp_remote_get( $action_url, array( 'timeout' => 30, 'sslverify' => false ) );
		if ( is_wp_error( $response ) ) {
			return false;
		}
		return wp_remote_retrieve_body( $response );
	}
	
}
endif; // End if class_exists check

function wp_easycart_admin( ){
	return wp_easycart_admin::instance( );
}
wp_easycart_admin( );

add_action( 'wp_ajax_ec_admin_ajax_popup_newsletter_close', 'ec_admin_ajax_popup_newsletter_close' );
function ec_admin_ajax_popup_newsletter_close( ){
	if( isset( $_POST['wpeasycart_newsletter_customeremail'] ) && isset( $_POST['wpeasycart_join_newsletter'] ) && $_POST['wpeasycart_join_newsletter'] == '1' ){
		$customeremail = $_POST['wpeasycart_newsletter_customeremail'];
		$customername = get_bloginfo( 'name' );
		$site_url = site_url( );
		$site_url = str_replace( 'http://', '', $site_url );
		$site_url = str_replace( 'https://', '', $site_url );
		$site_url = str_replace( 'www.', '', $site_url );
		file_get_contents( sprintf( 'https://support.wpeasycart.com/licensing/activatetrial.php?customeremail=%s&customername=%s&siteurl=%s', urlencode( esc_attr( $customeremail ) ), urlencode( esc_attr( $customername ) ), urlencode( esc_attr( $site_url ) ) ) );
	}
	if( isset( $_POST['wpeasycart_newsletter_customeremail'] ) ){
		update_option( 'ec_option_bcc_email_addresses', esc_attr( $_POST['wpeasycart_newsletter_customeremail'] ) );
	}
	update_option( 'ec_option_newsletter_done', 1 );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_allow_tracking', 'ec_admin_ajax_allow_tracking' );
function ec_admin_ajax_allow_tracking( ){
	update_option( 'ec_option_allow_tracking', '1' );
	if( !function_exists( 'wp_easycart_admin_tracking' ) ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/inc/wp_easycart_admin_tracking.php' );
	}
	do_action( 'wpeasycart_admin_usage_tracking_accepted' );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_deny_tracking', 'ec_admin_ajax_deny_tracking' );
function ec_admin_ajax_deny_tracking( ){
	update_option( 'ec_option_allow_tracking', '-1' );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_close_review_us', 'ec_admin_ajax_close_review_us' );
function ec_admin_ajax_close_review_us( ){
	update_option( 'ec_option_review_complete', '1' );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_custom_deactivate', 'ec_admin_ajax_custom_deactivate' );
function ec_admin_ajax_custom_deactivate( ){
	if( !function_exists( 'wp_easycart_admin_tracking' ) ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/inc/wp_easycart_admin_tracking.php' );
	}
	do_action( 'wpeasycart_deactivated' );
	die( );
}

add_action( 'wp_ajax_ec_admin_ajax_hide_elementor_notice', 'ec_admin_ajax_hide_elementor_notice' );
function ec_admin_ajax_hide_elementor_notice( ){
	update_option( 'ec_option_hide_elementor_notice', 1 );
	die( );
}
?>