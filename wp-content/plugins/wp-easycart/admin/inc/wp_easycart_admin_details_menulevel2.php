<?php
if( !defined( 'ABSPATH' ) ) exit;

class wp_easycart_admin_details_menulevel2 extends wp_easycart_admin_details{
	
	public $menulevel2;

	public function __construct( ){
		parent::__construct( );
		add_action( 'wp_easycart_admin_menulevel2_details_basic_fields', array( $this, 'basic_fields' ) );

	}
	
	protected function init( ){
		$this->docs_link = 'http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=menus';
		$this->id = 0;
		$this->page = 'wp-easycart-products';
		$this->subpage = 'submenus';
		$this->action = 'admin.php?page=' . $this->page . '&subpage=' . $this->subpage;
		$this->form_action = 'add-new-menulevel2';
		$this->menulevel2 = (object) array(
			"menulevel2_id"						=> "",
			"name"								=> "",
			"guid"								=> "",
			"menu_order"						=> "",
			"clicks"							=> "",
			"seo_keywords"						=> "",
			"seo_description"					=> "",
			"banner_image"						=> "",
			"post_id" 							=> ""
		);
	}
	
	protected function init_data( ){
		$this->form_action = 'update-menulevel2';
		$this->menulevel2 = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT 
				ec_menulevel2.*,
				" . $this->wpdb->prefix . "posts.guid  
			FROM 
				ec_menulevel2 
				LEFT JOIN " . $this->wpdb->prefix . "posts ON " . $this->wpdb->prefix . "posts.ID = ec_menulevel2.post_id
			WHERE 
				menulevel2_id = %d", $_GET['menulevel2_id']
		) );
		$this->id = $this->menulevel2->menulevel2_id;
	}

	public function output( $type = 'edit' ){
		$this->init( );
		if( $type == 'edit' )
			$this->init_data( );
		
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/products/menus/menulevel2-details.php' );
	}
	
	public function basic_fields( ){
		$banner_image = $this->menulevel2->banner_image;
		if( $banner_image != "" && substr( $banner_image, 0, 7 ) != "http://" && substr( $banner_image, 0, 8 ) != "https://" ){
			$banner_image = plugins_url( '/wp-easycart-data/products/banners/' . $banner_image );
		}
		
		$fields = apply_filters( 'wp_easycart_admin_menulevel2_details_basic_fields_list', array(
			array(
				"name"				=> "menulevel2_id",
				"alt_name"			=> "menulevel2_id",
				"type"				=> "hidden",
				"value"				=> $this->menulevel2->menulevel2_id
			),
			array(
				"name"				=> "post_id",
				"alt_name"			=> "post_id",
				"type"				=> "hidden",
				"value"				=> $this->menulevel2->post_id
			),
			array(
				"name"				=> "name",
				"type"				=> "text",
				"label"				=> "Menu Name",
				"required" 			=> true,
				"message" 			=> "Please enter a unique menu name.",
				"validation_type" 	=> 'text',
				"value"				=> $this->menulevel2->name
			),
			array(
				"name"				=> "post_slug",
				"type"				=> "text",
				"label"				=> "Link Slug",
				"required" 			=> false,
				"validation_type" 	=> 'post_slug',
				"visible"			=> ($this->id == '0') ? false : true,
				"value"				=> basename( $this->menulevel2->guid ),
				"message"			=> "Post Slug values must be unique and may only include letters, numbers, and dashes"
			),
			array(
				"name"				=> "menu_order",
				"type"				=> "number",
				"label"				=> "Menu Order #",
				"required" 			=> true,
				"message" 			=> "Please enter number to which this menu will sort by.",
				"validation_type" 	=> 'number',
				"value"				=> $this->menulevel2->menu_order
			),
			array(
				"name"				=> "seo_keywords",
				"type"				=> "textarea",
				"label"				=> "SEO Keywords (optional)",
				"required" 			=> false,
				"message" 			=> "Please enter SEO keywords separated by a comma.",
				"validation_type" 	=> 'textarea',
				"value"				=> $this->menulevel2->seo_keywords
			),
			array(
				"name"				=> "seo_description",
				"type"				=> "textarea",
				"label"				=> "SEO Description (optional)",
				"required" 			=> false,
				"message" 			=> "Please enter a couple sentences for SEO descriptions.",
				"validation_type" 	=> 'textarea',
				"value"				=> $this->menulevel2->seo_description
			),
			array(
				"name"				=> "banner_image",
				"type"				=> "image_upload",
				"label"				=> "Banner Image (optional)",
				"required" 			=> false,
				"message" 			=> "Please select an image for this menu.",
				"validation_type" 	=> 'image_upload',
				"value"				=> $banner_image
			),
			

			
		) );
		$this->print_fields( $fields );
	}

	
}