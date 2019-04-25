<?php
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'wp_easycart_admin_reviews' ) ) :

final class wp_easycart_admin_reviews{
	
	protected static $_instance = null;
	
	public $reviews_list_file;
	
	public static function instance( ) {
		
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self(  );
		}
		return self::$_instance;
	
	}
	
	public function __construct( ){ 
		$this->reviews_list_file 			= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/products/reviews/review-list.php';	
		
		/* Process Admin Messages */
		add_filter( 'wp_easycart_admin_success_messages', array( $this, 'add_success_messages' ) );
		add_filter( 'wp_easycart_admin_error_messages', array( $this, 'add_failure_messages' ) );
		
		/* Process Form Actions */
		add_action( 'wp_easycart_process_post_form_action', array( $this, 'process_update_review' ) );
		
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'process_delete_review' ) );
		add_action( 'wp_easycart_process_get_form_action', array( $this, 'process_bulk_delete_reviews' ) );
	}
	
	public function process_update_review( ){
		if( $_POST['ec_admin_form_action'] == "update-review" ){
			$result = $this->update_review( );
			wp_easycart_admin( )->redirect( 'wp-easycart-products', 'reviews', $result );
		}
	}
	
	public function process_delete_review( ){
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == 'reviews' && $_GET['ec_admin_form_action'] == 'delete-review' && isset( $_GET['review_id'] ) && !isset( $_GET['bulk'] ) ){
			$result = $this->delete_review( );
			wp_easycart_admin( )->redirect( 'wp-easycart-products', 'reviews', $result );
		}
	}
	
	public function process_bulk_delete_reviews( ){
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == 'reviews' && $_GET['ec_admin_form_action'] == 'delete-review' && !isset( $_GET['review_id'] ) && isset( $_GET['bulk'] ) ){
			$result = $this->bulk_delete_review( );
			wp_easycart_admin( )->redirect( 'wp-easycart-products', 'reviews', $result );
		}
	}
	
	public function add_success_messages( $messages ){
		if( isset( $_GET['success'] ) && $_GET['success'] == 'review-updated' ){
			$messages[] = 'Review successfully updated';
		}else if( isset( $_GET['success'] ) && $_GET['success'] == 'review-deleted' ){
			$messages[] = 'Review successfully deleted';
		}
		return $messages;
	}
	
	public function add_failure_messages( $messages ){
		if( isset( $_GET['error'] ) && $_GET['error'] == 'review-updated-error' ){
			$messages[] = 'Review failed to update';
		}else if( isset( $_GET['error'] ) && $_GET['error'] == 'review-deleted-error' ){
			$messages[] = 'Review failed to delete';
		}else if( isset( $_GET['error'] ) && $_GET['error'] == 'review-duplicate' ){
			$messages[] = 'Review failed to create due to duplicate';
		}
		return $messages;
	}
	
	public function load_reviews_list( ){
		if( ( isset( $_GET['review_id'] ) && isset( $_GET['ec_admin_form_action'] ) && $_GET['ec_admin_form_action'] == 'edit' ) || 
			( isset( $_GET['ec_admin_form_action'] ) && $_GET['ec_admin_form_action'] == 'add-new' ) ){
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/inc/wp_easycart_admin_details_review.php' );
				$details = new wp_easycart_admin_details_review( );
				$details->output( esc_attr( $_GET['ec_admin_form_action'] ) );
		}else{
			include( $this->reviews_list_file );
		
		}
	}
	
	public function update_review( ){	
		global $wpdb;
	
		$review_id = $_POST['review_id'];			
		$product_id = $_POST['product_id'];
		$user_id = $_POST['user_id'];
		$rating = $_POST['rating'];
		$title = stripslashes_deep( $_POST['title'] );
		$description = stripslashes_deep( $_POST['description'] );
		$date_submitted = date( "Y-m-d h:i:s", strtotime( $_POST['date_submitted'] ) );
		$approved = 0;
		if( isset( $_POST['approved'] ) )
			$approved = 1;
		
		$result = $wpdb->query( $wpdb->prepare( "UPDATE ec_review SET review_id = %s, product_id = %s, user_id = %s, approved = %s, rating = %s , title = %s , description = %s , date_submitted = %s  WHERE review_id = %s", $review_id, $product_id, $user_id, $approved, $rating, $title, $description, $date_submitted, $review_id ) );
		
		return array( 'success' => 'review-updated' );	
	}
	
	
	public function delete_review( ){
		$review_id = $_GET['review_id'];
		$query_vars = array( );
		

		global $wpdb;
		$result = $wpdb->query( $wpdb->prepare( "DELETE FROM ec_review WHERE ec_review.review_id = %s", $review_id ) );
		
		if( count($result)> 0){
			$query_vars['success'] = 'review-deleted';
		}else{
			$query_vars['error'] = 'review-deleted-error';
		}

		
		return $query_vars;
	}
	
	public function bulk_delete_review( ){
		$bulk_ids = $_GET['bulk'];
		$query_vars = array( );
		
		global $wpdb;
		$errors = 0;
		foreach( $bulk_ids as $bulk_id ){
			$result = $wpdb->query( $wpdb->prepare( "DELETE FROM ec_review WHERE ec_review.review_id = %s", $bulk_id ) );
			if( $result === false )
				$errors++;
		}
		
		if( $errors ){
			$query_vars['error'] = 'review-deleted-error';
		} else {
			$query_vars['success'] = 'review-deleted';
		}
		
		return $query_vars;
		
	}
	
}
endif; // End if class_exists check

function wp_easycart_admin_reviews( ){
	return wp_easycart_admin_reviews::instance( );
}
wp_easycart_admin_reviews( );