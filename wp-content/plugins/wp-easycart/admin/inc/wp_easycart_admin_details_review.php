<?php
if( !defined( 'ABSPATH' ) ) exit;

class wp_easycart_admin_details_review extends wp_easycart_admin_details{
	
	public $review;

	
	public function __construct( ){
		parent::__construct( );
		add_action( 'wp_easycart_admin_reviews_details_basic_fields', array( $this, 'basic_fields' ) );
		add_action( 'wp_easycart_admin_reviews_details_review_info', array( $this, 'review_fields' ) );
		add_action( 'wp_easycart_admin_reviews_details_product_info', array( $this, 'product_fields' ) );

	}
	
	protected function init( ){
		$this->docs_link = 'http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=product-reviews';
		$this->id = 0;
		$this->page = 'wp-easycart-products';
		$this->subpage = 'reviews';
		$this->action = 'admin.php?page=' . $this->page . '&subpage=' . $this->subpage;
		$this->form_action = 'add-new-review';
		$this->review = (object) array(
			"review_id"							=> "",
			"product_id"						=> "",
			"approved"							=> "",
			"rating" 							=> "",
			"title"							 	=> "",
			"description"						=> "",
			"date_submitted"					=> "",
			"user_id"							=> ""
		);

	}
	
	protected function init_data( ){
		$this->form_action = 'update-review';
		$this->review = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT ec_review.* FROM ec_review WHERE review_id = %d", $_GET['review_id'] ) );
		$this->id = $this->review->review_id;

		
	}

	public function output( $type = 'edit' ){
		$this->init( );
		if( $type == 'edit' )
			$this->init_data( );
		
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/products/reviews/review-details.php' );
	}
	
	public function basic_fields( ){

		$fields = apply_filters( 'wp_easycart_admin_reviews_details_basic_fields_list', array(
			array(
				"name"				=> "review_id",
				"alt_name"			=> "review_id",
				"type"				=> "hidden",
				"value"				=> $this->review->review_id
			),
			array(
				"name"				=> "product_id",
				"alt_name"			=> "product_id",
				"type"				=> "hidden",
				"value"				=> $this->review->product_id
			),
			array(
				"name"				=> "user_id",
				"alt_name"			=> "user_id",
				"type"				=> "hidden",
				"value"				=> $this->review->user_id
			),
			array(
				"name"				=> "approved",
				"type"				=> "checkbox",
				"label"				=> "Is review approved for display on store product?",
				"required" 			=> false,
				"message" 			=> "Please select if review is approved.",
				"validation_type" 	=> 'checkbox',
				"value"				=> $this->review->approved
			),
			

			

			
		) );
		$this->print_fields( $fields );
	}
	
		public function review_fields( ){
			
		global $wpdb;
		$user_email = $wpdb->get_var( $wpdb->prepare( "SELECT ec_user.email FROM ec_user WHERE ec_user.user_id = %d", $this->review->user_id )  );
		
		$fields = apply_filters( 'wp_easycart_admin_reviews_details_review_fields_list', array(

			array(
				"name"				=> "date_submitted",
				"type"				=> "date",
				"label"				=> "Date Submitted",
				"required" 			=> true,
				"message" 			=> "Please enter a date this review occured.",
				"validation_type" 	=> 'date',
				"value"				=> $this->review->date_submitted
			),
			array(
				"name"				=> "user_email",
				"type"				=> "text",
				"label"				=> "Submitted By",
				"required" 			=> false,
				"message" 			=> "Please enter an email address.",
				"validation_type" 	=> 'text',
				"read-only"			=> true,
				"value"				=> $user_email
			),
			array(
				"name"				=> "rating",
				"type"				=> "star_rating",
				"label"				=> "Rating ",
				"max"				=> "5",
				"min"				=> "1",
				"step"				=> "1",
				"required" 			=> true,
				"message" 			=> "Please enter a customer rating.",
				"validation_type" 	=> "number",
				"value"				=> $this->review->rating
			),
			array(
				"name"				=> "title",
				"type"				=> "text",
				"label"				=> "Review Title",
				"required" 			=> true,
				"message" 			=> "Please enter a product title.",
				"validation_type" 	=> 'text',
				"value"				=> $this->review->title
			),
			array(
				"name"				=> "description",
				"type"				=> "textarea",
				"label"				=> "Customer Comments",
				"required" 			=> false,
				"message" 			=> "Please enter a customer comment.",
				"validation_type" 	=> 'textarea',
				"value"				=> $this->review->description
			),
			

			
		) );
		$this->print_fields( $fields );
	}

	public function product_fields( ){
		
		global $wpdb;
		$product = $wpdb->get_results( "SELECT ec_product.model_number, ec_product.title, ec_product.price, ec_product.activate_in_store, ec_product.image1, ec_product.list_price, ec_product.description FROM ec_product WHERE ec_product.product_id = ".$this->review->product_id.""  );

		$fields = apply_filters( 'wp_easycart_admin_reviews_details_product_fields_list', array(

			array(
				"name"				=> "product_title",
				"type"				=> "text",
				"label"				=> "Product Title",
				"required" 			=> false,
				"message" 			=> "Please enter a product title.",
				"validation_type" 	=> 'text',
				"read-only"			=> true,
				"value"				=> $product[0]->title
			),
			array(
				"name"				=> "model_number",
				"type"				=> "text",
				"label"				=> "Model Number",
				"required" 			=> false,
				"message" 			=> "Please enter a model number.",
				"validation_type" 	=> 'text',
				"read-only"			=> true,
				"value"				=> $product[0]->model_number
			),
			array(
				"name"				=> "product_price",
				"type"				=> "currency",
				"label"				=> "Product Price",
				"required" 			=> false,
				"message" 			=> "Please enter a product price.",
				"validation_type" 	=> 'currency',
				"read-only"			=> true,
				"value"				=> $product[0]->price
			),
			array(
				"name"				=> "activate_in_store",
				"type"				=> "checkbox",
				"label"				=> "Product is active on store?",
				"required" 			=> false,
				"message" 			=> "Please select if active in store.",
				"validation_type" 	=> 'checkbox',
				"read-only"			=> true,
				"value"				=> $product[0]->activate_in_store
			),
			array(
				"name"				=> "product_description",
				"type"				=> "textarea",
				"label"				=> "Product Description",
				"required" 			=> false,
				"message" 			=> "Please enter a product description.",
				"validation_type" 	=> 'textarea',
				"read-only"			=> true,
				"value"				=> $product[0]->description
			),
			

			
		) );
		$this->print_fields( $fields );
	}
	

	
}