<?php
if( !defined( 'ABSPATH' ) ) exit;

class wp_easycart_admin_details_states extends wp_easycart_admin_details{
	
	public $states;

	public function __construct( ){
		parent::__construct( );
		add_action( 'wp_easycart_admin_states_details_basic_fields', array( $this, 'basic_fields' ) );
	}
	
	protected function init( ){
		$this->docs_link = 'http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=states';
		$this->id = 0;
		$this->page = 'wp-easycart-settings';
		$this->subpage = 'states';
		$this->action = 'admin.php?page=' . $this->page . '&subpage=' . $this->subpage;
		$this->form_action = 'add-new-states';
		$this->states = (object) array(
			"id_sta"					=> "",
			"idcnt_sta"					=> "",
			"code_sta"					=> "",
			"name_sta" 					=> "",
			"sort_order" 				=> "",
			"group_sta" 				=> "",
			"ship_to_active" 			=> ""
		);
	}
	
	protected function init_data( ){
		$this->form_action = 'update-states';
		$this->states = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT ec_state.* FROM ec_state WHERE id_sta = %d", $_GET['id_sta'] ) );
		$this->id = $this->states->id_sta;
	}

	public function output( $type = 'edit' ){
		$this->init( );
		if( $type == 'edit' )
			$this->init_data( );
		
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/country-state/states-details.php' );
	}
	
	public function basic_fields( ){
		global $wpdb;
		$countries = $wpdb->get_results( "SELECT ec_country.id_cnt AS id, ec_country.name_cnt AS value FROM ec_country ORDER BY name_cnt ASC" );

		$fields = apply_filters( 'wp_easycart_admin_states_details_basic_fields_list', array(
			array(
				"name"				=> "id_sta",
				"alt_name"			=> "id_sta",
				"type"				=> "hidden",
				"value"				=> $this->states->id_sta
			),
			array(
				"name"				=> "ship_to_active",
				"type"				=> "checkbox",
				"label"				=> " Enable this State?",
				"required" 			=> false,
				"message" 			=> "Please select if country is enabled.",
				"validation_type" 	=> 'checkbox',
				"value"				=> $this->states->ship_to_active
			),
			array(
				"name"				=> "idcnt_sta",
				"type"				=> "select",
				"select2"			=> "basic",
				"data"				=> $countries,
				"data_label" 		=> "Please Select a Country",
				"label" 			=> "Select Country",
				"required" 			=> true,
				"message" 			=> "Please select a Country.",
				"value" 			=> $this->states->idcnt_sta
			),
			array(
				"name"				=> "name_sta",
				"type"				=> "text",
				"label"				=> "State/Province Name",
				"required" 			=> true,
				"message" 			=> "Please enter an state or province name.",
				"validation_type" 	=> 'text',
				"value"				=> $this->states->name_sta
			),
			array(
				"name"				=> "code_sta",
				"type"				=> "text",
				"label"				=> "Abbreviated Name",
				"required" 			=> true,
				"message" 			=> "Please enter an ISO 2 digit abbreviated state or province code ",
				"validation_type" 	=> 'text',
				"value"				=> $this->states->code_sta
			),
			array(
				"name"				=> "sort_order",
				"type"				=> "number",
				"label"				=> "Sort Order",
				"required" 			=> true,
				"message" 			=> "Please enter a sort order value.",
				"validation_type" 	=> 'number',
				"value"				=> $this->states->sort_order
			),
			array(
				"name"				=> "group_sta",
				"type"				=> "text",
				"label"				=> "State Group",
				"required" 			=> false,
				"message" 			=> "Please enter an optional group name for this state.",
				"validation_type" 	=> 'text',
				"value"				=> $this->states->group_sta
			),
			
			

			
		) );
		$this->print_fields( $fields );
	}

	
}