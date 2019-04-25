<?php
if( !defined( 'ABSPATH' ) ) exit;

class wp_easycart_admin_details_option extends wp_easycart_admin_details{
	
	public $option;

	
	public function __construct( ){
		parent::__construct( );
		add_action( 'wp_easycart_admin_option_details_basic_fields', array( $this, 'basic_fields' ) );

	}
	
	protected function init( ){
		$this->docs_link = 'http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=option';
		$this->id = 0;
		$this->page = 'wp-easycart-products';
		$this->subpage = 'option';
		$this->action = 'admin.php?page=' . $this->page . '&subpage=' . $this->subpage;
		$this->form_action = 'add-new-option';
		$this->option = (object) array(
			"option_id"					=> "",
			"option_name"					=> "",
			"option_label"					=> "",
			"option_type"					=> "",
			"option_required"				=> false,
			"option_error_text"				=> "",
			"option_meta"					=> false,
			"post_id"						=> "",
			"parent_id"						=> "",
			"short_description"				=> "",
			"image"							=> "",
			"featured_option"				=> ""
		);

	}
	
	protected function init_data( ){
		$this->form_action = 'update-option';
		$this->option = $this->item = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT ec_option.* FROM ec_option WHERE option_id = %d", $_GET['option_id'] ) );
		$this->id = $this->option->option_id;

		
	}

	public function output( $type = 'edit' ){
		$this->init( );
		if( $type == 'edit' )
			$this->init_data( );
		
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/products/options/option-details.php' );
	}
	
	public function basic_fields( ){
		$option_type = array( 
			(object) array(
				'id'	=> 'basic-combo',
				'value'	=> 'Basic Combo'
			),
			(object) array(
				'id'	=> 'basic-swatch',
				'value'	=> 'Basic Swatch'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'combo' ),
				'value'	=> 'Advanced Combo Box'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'swatch' ),
				'value'	=> 'Advanced Image Swatches'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'text' ),
				'value'	=> 'Advanced Text Input'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'textarea' ),
				'value'	=> 'Advanced Text Area'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'number' ),
				'value'	=> 'Advanced Number Field'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'file' ),
				'value'	=> 'Advanced File Upload'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'radio' ),
				'value'	=> 'Advanced Radio Group'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'checkbox' ),
				'value'	=> 'Advanced Checkbox Group'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'grid' ),
				'value'	=> 'Advanced Quantity Grid'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'date' ),
				'value'	=> 'Advanced Date'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'dimensions1' ),
				'value'	=> 'Advanced Dimensions (Whole Inch)'
			),
			(object) array(
				'id'	=> apply_filters( 'wp_easycart_admin_advanced_option_type', 'dimensions2' ),
				'value'	=> 'Advanced Dimensions (Sub-Inch)'
			)
		);
		
		if( $this->option->option_meta ){
			$option_meta = maybe_unserialize( $this->option->option_meta );
		}else{
			$option_meta = array(
				"min"	=> "",
				"max"	=> "",
				"step"	=> "",
				"url_var"	=> ""
			);
		}

		$fields = apply_filters( 'wp_easycart_admin_option_details_basic_fields_list', array(
			array(
				"name"				=> "option_id",
				"alt_name"			=> "option_id",
				"type"				=> "hidden",
				"value"				=> $this->option->option_id
			),
			array(
				"name"				=> "option_type",
				"type"				=> "select",
				"data"				=> $option_type,
				"data_label" 		=> "Please Select",
				"label" 			=> "Option Type",
				"required" 			=> true,
				"message" 			=> "Please select an option type",
				"value" 			=> $this->option->option_type,
				"validation_type" 	=> 'select',
				"onchange"			=> 'ec_admin_option_type_change'
			),
			array(
				"name"				=> "option_name",
				"type"				=> "text",
				"label"				=> "Option Name",
				"required" 			=> true,
				"message" 			=> "Please enter a unique option name.",
				"validation_type" 	=> 'text',
				"value"				=> $this->option->option_name
			),
			array(
				"name"				=> "option_label",
				"type"				=> "text",
				"label"				=> "Option Label",
				"required" 			=> true,
				"message" 			=> "Please enter an option label to display to user.",
				"validation_type" 	=> 'text',
				"value"				=> $this->option->option_label
			),
			array(
				"name"				=> "option_meta_url_var",
				"type"				=> "text",
				"label"				=> "Option URL Variable",
				"required" 			=> false,
				"validation_type" 	=> 'text',
				"value"				=> $option_meta["url_var"]
			),
			array(
				"name"				=> "option_meta_min",
				"type"				=> "number",
				"label"				=> "Minimum Value",
				"required" 			=> false,
				"validation_type" 	=> 'text',
				"value"				=> $option_meta["min"],
				"requires"			=> array(
					"name"			=> "option_type",
					"value"			=> 'number',
					"default_show"	=> false
				),
				"visible"			=> false
			),
			array(
				"name"				=> "option_meta_max",
				"type"				=> "number",
				"label"				=> "Maximum Value",
				"required" 			=> false,
				"validation_type" 	=> 'text',
				"value"				=> $option_meta["max"],
				"requires"			=> array(
					"name"			=> "option_type",
					"value"			=> 'number',
					"default_show"	=> false
				),
				"visible"			=> false
			),
			array(
				"name"				=> "option_meta_step",
				"type"				=> "number",
				"label"				=> "Step (e.g.: .01, .1, 1)",
				"required" 			=> false,
				"validation_type" 	=> 'text',
				"value"				=> $option_meta["step"],
				"requires"			=> array(
					"name"			=> "option_type",
					"value"			=> 'number',
					"default_show"	=> false
				),
				"visible"			=> false
			),
			
			array(
				"type"				=> "heading",
				"label"				=> "Advanced Option Settings",
				"horizontal_rule"	=> true, 
				"message" 			=> "Only advanced options can be optional/required to your users on the product.  Advanced options allow for much more configuration, but they can not track quantity per option.  Only basic options can track quantity at their option level.  Other than this, advanced options are the most configurable and best option set to use.",

			),
			
			array(
				"name"				=> "option_required",
				"type"				=> "checkbox",
				"label"				=> "Is Option going to be required by user?",
				"required" 			=> false,
				"message" 			=> "Please enter an option",
				"validation_type" 	=> 'checkbox',
				"show"  => array(
					"name" =>"option_error_text",
					"value"=>"1"
				),
				"value"				=> $this->option->option_required
			),
			array(
				"name"				=> "option_error_text",
				"type"				=> "text",
				"label"				=> "Error Message",
				"required" 			=> false,
				"message" 			=> "Please enter an option error message to display to user.",
				"validation_type" 	=> 'text',
				"requires"=>array(
					"name"=>"option_required",
					"value"=>"1"
				),
				"value"				=> $this->option->option_error_text
			),
			
			
			

			
		) );
		$this->print_fields( $fields );
	}

	
}