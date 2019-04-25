<?php
if( !defined( 'ABSPATH' ) ) exit;

class wp_easycart_admin_details_logging extends wp_easycart_admin_details{
	
	public $log_entry;

	
	public function __construct( ){
		parent::__construct( );
		add_action( 'wp_easycart_admin_log_details_basic_fields', array( $this, 'basic_fields' ) );

	}
	
	protected function init( ){
		$this->docs_link = 'http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=logs';
		$this->id = 0;
		$this->page = 'wp-easycart-settings';
		$this->subpage = 'logs';
		$this->action = 'admin.php?page=' . $this->page . '&subpage=' . $this->subpage;
		$this->form_action = 'add-new-response';
		$this->log_entry = (object) array(
			"response_id"					=> "",
			"is_error"						=> "",
			"processor"						=> "",
			"order_id" 						=> "",
			"response_time" 				=> "",
			"response_text" 				=> ""
		);

	}
	
	protected function init_data( ){
		$this->form_action = 'update-response';
		$this->log_entry = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT ec_response.* FROM ec_response WHERE response_id = %d", $_GET['response_id'] ) );
		$this->id = $this->log_entry->response_id;

		
	}

	public function output( $type = 'edit' ){
		$this->init( );
		if( $type == 'edit' )
			$this->init_data( );
		
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/logging/log-details.php' );
	}
	
	public function basic_fields( ){

		$fields = apply_filters( 'wp_easycart_admin_log_details_basic_fields_list', array(
			array(
				"name"				=> "response_id",
				"alt_name"			=> "original_id",
				"type"				=> "hidden",
				"value"				=> $this->log_entry->response_id
			),
			array(
				"name"				=> "response_id",
				"alt_name"			=> "response_id",
				"type"				=> "hidden",
				"value"				=> $this->log_entry->response_id
			),
			array(
				"name"				=> "is_error",
				"type"				=> "checkbox",
				"label"				=> "Is Error?",
				"required" 			=> false,
				"message" 			=> "Select if this was an error.",
				"validation_type" 	=> 'checkbox',
				"read-only"			=> true,
				"value"				=> $this->log_entry->is_error
			),
			array(
				"name"				=> "processor",
				"type"				=> "text",
				"label"				=> "Entry Source",
				"required" 			=> false,
				"message" 			=> "Please enter a source.",
				"validation_type" 	=> 'text',
				"read-only"			=> true,
				"value"				=> $this->log_entry->processor
			),
			array(
				"name"				=> "order_id",
				"type"				=> "text",
				"label"				=> "Order ID",
				"required" 			=> false,
				"message" 			=> "Please enter an order ID.",
				"validation_type" 	=> 'text',
				"read-only"			=> true,
				"value"				=> $this->log_entry->order_id
			),
			array(
				"name"				=> "response_time",
				"type"				=> "text",
				"label"				=> "Entry Date",
				"required" 			=> false,
				"message" 			=> "Please enter an entry date.",
				"validation_type" 	=> 'text',
				"read-only"			=> true,
				"value"				=> $this->log_entry->response_time
			),
			array(
				"name"				=> "response_text",
				"type"				=> "textarea",
				"label"				=> "Error Response",
				"required" 			=> false,
				"message" 			=> "Please enter response entry.",
				"validation_type" 	=> 'textarea',
				"height"			=> 500,
				"read-only"			=> true,
				"value"				=> $this->log_entry->response_text
			)
		) );
		$this->print_fields( $fields );
	}

	
}