<?php
if( !defined( 'ABSPATH' ) ) exit;

class wp_easycart_admin_details_products extends wp_easycart_admin_details{
	
	public $product;
	public $option_item_quantities;
	public $price_tiers;
	public $b2b_prices;
	public $option_item_images;
	public $advanced_options;
	public $categories;

	public function __construct( ){
		parent::__construct( );
		add_action( 'wp_easycart_admin_product_details_basic_fields', array( $this, 'basic_fields' ) );
		add_action( 'wp_easycart_admin_product_details_options_fields', array( $this, 'options_fields' ) );
		add_action( 'wp_easycart_admin_product_details_images_fields', array( $this, 'images_fields' ) );
		add_action( 'wp_easycart_admin_product_details_menus_fields', array( $this, 'menus_fields' ) );
		add_action( 'wp_easycart_admin_product_details_categories_fields', array( $this, 'categories_fields' ) );
		add_action( 'wp_easycart_admin_product_details_quantity_fields', array( $this, 'quantity_fields' ) );
		add_action( 'wp_easycart_admin_product_details_optionitem_quantity_fields', array( $this, 'optionitem_quantity_fields' ) );
		add_action( 'wp_easycart_admin_product_details_packaging_fields', array( $this, 'packaging_fields' ) );
		add_action( 'wp_easycart_admin_product_details_pricing_fields', array( $this, 'pricing_fields' ) );
		add_action( 'wp_easycart_admin_product_details_advanced_pricing_fields', array( $this, 'advanced_pricing_fields' ) );
		add_action( 'wp_easycart_admin_product_details_shipping_fields', array( $this, 'shipping_fields' ) );
		add_action( 'wp_easycart_admin_product_details_short_description_fields', array( $this, 'short_description_fields' ) );
		add_action( 'wp_easycart_admin_product_details_specifications_fields', array( $this, 'specifications_fields' ) );
		add_action( 'wp_easycart_admin_product_details_order_completed_note_fields', array( $this, 'order_completed_note_fields' ) );
		add_action( 'wp_easycart_admin_product_details_order_completed_email_note_fields', array( $this, 'order_completed_email_note_fields' ) );
		add_action( 'wp_easycart_admin_product_details_order_completed_details_note_fields', array( $this, 'order_completed_details_note_fields' ) );
		add_action( 'wp_easycart_admin_product_details_featured_products_fields', array( $this, 'featured_products_fields' ) );
		add_action( 'wp_easycart_admin_product_details_general_options_fields', array( $this, 'general_options_fields' ) );
		add_action( 'wp_easycart_admin_product_details_tax_fields', array( $this, 'tax_fields' ) );
		add_action( 'wp_easycart_admin_product_details_deconetwork_fields', array( $this, 'deconetwork_fields' ) );
		add_action( 'wp_easycart_admin_product_details_subscription_fields', array( $this, 'subscription_fields' ) );
		add_action( 'wp_easycart_admin_product_details_seo_fields', array( $this, 'seo_fields' ) );
		add_action( 'wp_easycart_admin_product_details_downloads_fields', array( $this, 'downloads_fields' ) );
		add_action( 'wp_easycart_admin_product_details_tags_fields', array( $this, 'tags_fields' ) );
	}
	
	protected function init( ){
		$this->docs_link = 'http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=products';
		$this->id = '0';
		$this->page = 'wp-easycart-products';
		$this->subpage = 'products';
		$this->action = 'admin.php?page=' . $this->page . '&subpage=' . $this->subpage;
		
		if( isset( $_GET['pagenum'] ) )
			$this->action .= '&pagenum=' . (int) $_GET['pagenum'];
		
		if( isset( $_GET['orderby'] ) )
			$this->action .= '&orderby=' . esc_attr( $_GET['orderby'] );
		
		if( isset( $_GET['order'] ) )
			$this->action .= '&order=' . esc_attr( $_GET['order'] );
		
		$this->form_action = 'add-new-product';
		$this->product = $this->item = (object) array(
			"product_id" => '0',
			"model_number" => '',
			"guid" => '',
			"post_id" => '',
			"activate_in_store" => '',
			"title" => '',
			"description" => '',
			"specifications" => '',
			"order_completed_note" => '',
			"order_completed_email_note" => '',
			"order_completed_details_note" => '',
			"price" => '',
			"list_price" => '',
			"product_cost" => '',
			"vat_rate" => '',
			"handling_price" => '',
			"handling_price_each" => '',
			"stock_quantity" => '',
			"min_purchase_quantity" => '',
			"max_purchase_quantity" => '',
			"weight" => '',
			"width" => '',
			"height" => '',
			"length" => '',
			"seo_description" => '',
			"seo_keywords" => '',
			"use_specifications" => '',
			"use_customer_reviews" => '',
			"manufacturer_id" => '',
			"download_file_name" => '',
			"image1" => '',
			"image2" => '',
			"image3" => '',
			"image4" => '',
			"image5" => '',
			"option_id_1" => 0,
			"option_id_2" => 0,
			"option_id_3" => 0,
			"option_id_4" => 0,
			"option_id_5" => 0,
			"use_advanced_optionset" => 0,
			"menulevel1_id_1" => 0,
			"menulevel1_id_2" => 0,
			"menulevel1_id_3" => 0,
			"menulevel2_id_1" => 0,
			"menulevel2_id_2" => 0,
			"menulevel2_id_3" => 0,
			"menulevel3_id_1" => 0,
			"menulevel3_id_2" => 0,
			"menulevel3_id_3" => 0,
			"featured_product_id_1" => 0,
			"featured_product_id_2" => 0,
			"featured_product_id_3" => 0,
			"featured_product_id_4" => 0,
			"is_giftcard" => 0,
			"is_download" => 0,
			"is_donation" => 0,
			"is_special" => 0,
			"is_taxable" => 1,
			"is_shippable" => 1,
			"is_subscription_item" => 0,
			"is_preorder" => 0,
			"added_to_db_date" => '',
			"show_on_startup" => 1,
			"use_optionitem_images" => 0,
			"use_optionitem_quantity_tracking" => 0,
			"views" => '',
			"last_viewed" => '',
			"show_stock_quantity" => '',
			"maximum_downloads_allowed" => '',
			"download_timelimit_seconds" => '',
			"list_id" => '',
			"edit_sequence" => '',
			"quickbooks_status" => '',
			"income_account_ref" => '',
			"cogs_account_ref" => '',
			"asset_account_ref" => '',
			"quickbooks_parent_name" => '',
			"quickbooks_parent_list_id" => '',
			"subscription_bill_length" => '',
			"subscription_bill_period" => '',
			"subscription_bill_duration" => '',
			"trial_period_days" => '',
			"stripe_plan_added" => '',
			"allow_multiple_subscription_purchases" => '',
			"membership_page" => '',
			"is_amazon_download" => '',
			"amazon_key" => '',
			"catalog_mode" => '',
			"catalog_mode_phrase" => '',
			"inquiry_mode" => '',
			"inquiry_url" => '',
			"is_deconetwork" => '',
			"deconetwork_mode" => '',
			"deconetwork_product_id" => '',
			"deconetwork_size_id" => '',
			"deconetwork_color_id" => '',
			"deconetwork_design_id" => '',
			"short_description" => '',
			"display_type" => '',
			"image_hover_type" => '',
			"tag_type" => '',
			"tag_bg_color" => '',
			"tag_text_color" => '',
			"tag_text" => '',
			"image_effect_type" => '',
			"include_code" => '',
			"TIC" => '',
			"subscription_signup_fee" => '',
			"subscription_unique_id" => '',
			"subscription_prorate" => '',
			"subscription_plan_id" => '',
			"allow_backorders" => '',
			"backorder_fill_date" => '',
			"shipping_class_id" => ''
		);
		
		$this->option_item_quantities = array( );
		$this->price_tiers = array( );
		$this->b2b_prices = array( );
		$this->option_item_images = array( );
		$this->advanced_options = array( );
		$this->categories = array( );

	}
	
	protected function init_data( ){
		$this->form_action = 'update-product';
		$this->product = $this->item = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT 
				ec_product.*,
				" . $this->wpdb->prefix . "posts.guid 
			FROM 
				ec_product 
				LEFT JOIN " . $this->wpdb->prefix . "posts ON " .$this->wpdb->prefix . "posts.ID = ec_product.post_id 
			WHERE product_id = %d", $_GET['product_id']
		) );
		$this->id = $this->product->product_id;
		$this->option_item_quantities = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT 
				ec_optionitemquantity.*, 
				optionitem1.optionitem_name as optionitem_name_1, 
				optionitem2.optionitem_name as optionitem_name_2, 
				optionitem3.optionitem_name as optionitem_name_3, 
				optionitem4.optionitem_name as optionitem_name_4, 
				optionitem5.optionitem_name as optionitem_name_5
			FROM 
				ec_optionitemquantity 
				LEFT JOIN ec_optionitem AS optionitem1 ON ( optionitem1.optionitem_id = ec_optionitemquantity.optionitem_id_1 )
				LEFT JOIN ec_optionitem AS optionitem2 ON ( optionitem2.optionitem_id = ec_optionitemquantity.optionitem_id_2 )
				LEFT JOIN ec_optionitem AS optionitem3 ON ( optionitem3.optionitem_id = ec_optionitemquantity.optionitem_id_3 )
				LEFT JOIN ec_optionitem AS optionitem4 ON ( optionitem4.optionitem_id = ec_optionitemquantity.optionitem_id_4 )
				LEFT JOIN ec_optionitem AS optionitem5 ON ( optionitem5.optionitem_id = ec_optionitemquantity.optionitem_id_5 )
			WHERE 
				ec_optionitemquantity.product_id = %d", 
		$this->id ) );
		$this->price_tiers = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT ec_pricetier.* FROM ec_pricetier WHERE product_id = %d", $this->id ) );
		$this->b2b_prices = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT ec_roleprice.* FROM ec_roleprice WHERE product_id = %d", $this->id ) );
		$this->option_item_images = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT ec_optionitemimage.* FROM ec_optionitemimage WHERE product_id = %d", $this->id ) );
		$this->advanced_options = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT ec_option.*, ec_option_to_product.option_to_product_id FROM ec_option_to_product, ec_option WHERE ec_option_to_product.product_id = %d AND ec_option.option_id = ec_option_to_product.option_id ORDER BY ec_option_to_product.option_order ASC, ec_option.option_name ASC", $this->id ) );
		$this->categories = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT ec_categoryitem.category_id, ec_category.category_name FROM ec_categoryitem, ec_category WHERE ec_categoryitem.product_id = %d AND ec_category.category_id = ec_categoryitem.category_id", $this->id ) );
	}

	public function output( $type = 'edit' ){
		$this->init( );
		if( $type == 'edit' )
			$this->init_data( );
		
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/products/products/product-details.php' );
	}
	
	public function basic_fields( ){
		
		global $wpdb;
		$fields = apply_filters( 'wp_easycart_admin_product_details_basic_fields_list', array(

			array(
				"name"				=> "activate_in_store",
				"type"				=> "checkbox",
				"label"				=> "Product Activated",
				"required" 			=> false,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"value"				=> $this->product->activate_in_store,
				"selected"			=> true
			),
			array(
				"name"				=> "title",
				"type"				=> "text",
				"label"				=> "Title",
				"required" 			=> true,
				"message"			=> "Your product must have a title",
				"validation_type" 	=> 'text',
				"visible"			=> true,
				"value"				=> $this->product->title
			),
			array(
				"alt_name"			=> "model_number_orig",
				"type"				=> "hidden",
				"value"				=> $this->product->model_number
			),
			array(
				"name"				=> "model_number",
				"type"				=> "text",
				"label"				=> "SKU",
				"required" 			=> true,
				"validation_type" 	=> 'model_number',
				"visible"			=> true,
				"value"				=> $this->product->model_number,
				"message"			=> "SKU values must be unique and may only include letters, numbers, and dashes"
			),
			array(
				"name"				=> "post_slug",
				"type"				=> "text",
				"label"				=> "Link Slug",
				"required" 			=> true,
				"validation_type" 	=> 'post_slug',
				"visible"			=> ($this->id == '0') ? false : true,
				"value"				=> basename( $this->product->guid ),
				"message"			=> "Post Slug values must be unique and may only include letters, numbers, and dashes"
			),
			array(
				"name"				=> "manufacturer_id",
				"type"				=> "manufacturer",
				"label"				=> "Manufacturer",
			),
			array(
				"name"				=> "price",
				"type"				=> "currency",
				"label"				=> "Price",
				"required" 			=> true,
				"message"			=> "Your product must have a valid price",
				"validation_type" 	=> 'price',
				"visible"			=> true,
				"value"				=> $this->product->price
			),
			array(
				"name"				=> "description",
				"type"				=> "wp_textarea",
				"label"				=> "Description",
				"required" 			=> false,
				"validation_type" 	=> 'textarea',
				"visible"			=> true,
				"value"				=> $this->product->description
			)

		) );
		$this->print_fields( $fields );
	}
	
	public function options_fields( ){
		global $wpdb;
		$basic_options = $wpdb->get_results( "SELECT option_id as id, option_name as value FROM ec_option WHERE option_type = 'basic-combo' OR option_type = 'basic-swatch' ORDER BY option_label ASC" );
		$fields = apply_filters( 'wp_easycart_admin_product_details_options_fields_list', array(
			array(
				"name"				=> "use_advanced_optionset",
				"type"				=> "checkbox",
				"label"				=> "Use Advanced Options",
				"required" 			=> false,
				"validation_type" 	=> 'checkbox',
				"onclick"			=> 'show_pro_required',
				"read-only"			=> true,
				"visible"			=> true,
				"value"				=> $this->product->use_advanced_optionset
			),
			array(
				"name"				=> "option1",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Option 1",
				"data"				=> $basic_options,
				"data_label"		=> "Select One",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "use_advanced_optionset",
					"value"			=> 0,
					"default_show"	=> true
				),
				"onchange"			=> 'ec_admin_product_details_option1_change',
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->option_id_1
			),
			array(
				"name"				=> "option2",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Option 2",
				"data"				=> $basic_options,
				"data_label"		=> "Select One",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "use_advanced_optionset",
					"value"			=> 0,
					"default_show"	=> true
				),
				"onchange"			=> 'ec_admin_product_details_option2_change',
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->option_id_2
			),
			array(
				"name"				=> "option3",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Option 3",
				"data"				=> $basic_options,
				"data_label"		=> "Select One",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "use_advanced_optionset",
					"value"			=> 0,
					"default_show"	=> true
				),
				"onchange"			=> 'ec_admin_product_details_option3_change',
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->option_id_3
			),
			array(
				"name"				=> "option4",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Option 4",
				"data"				=> $basic_options,
				"data_label"		=> "Select One",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "use_advanced_optionset",
					"value"			=> 0,
					"default_show"	=> true
				),
				"onchange"			=> 'ec_admin_product_details_option4_change',
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->option_id_4
			),
			array(
				"name"				=> "option5",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Option 5",
				"data"				=> $basic_options,
				"data_label"		=> "Select One",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "use_advanced_optionset",
					"value"			=> 0,
					"default_show"	=> true
				),
				"onchange"			=> 'ec_admin_product_details_option5_change',
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->option_id_5
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function images_fields( ){
		
		$image1 = $this->product->image1;
		$image2 = $this->product->image2;
		$image3 = $this->product->image3;
		$image4 = $this->product->image4;
		$image5 = $this->product->image5;
		
		if( $image1 != "" && substr( $image1, 0, 7 ) != "http://" && substr( $image1, 0, 8 ) != "https://" ){
			$image1 = plugins_url( '/wp-easycart-data/products/pics1/' . $image1 );
		}
		if( $image2 != "" && substr( $image2, 0, 7 ) != "http://" && substr( $image2, 0, 8 ) != "https://" ){
			$image2 = plugins_url( '/wp-easycart-data/products/pics2/' . $image2 );
		}
		if( $image3 != "" && substr( $image3, 0, 7 ) != "http://" && substr( $image3, 0, 8 ) != "https://" ){
			$image3 = plugins_url( '/wp-easycart-data/products/pics3/' . $image3 );
		}
		if( $image4 != "" && substr( $image4, 0, 7 ) != "http://" && substr( $image4, 0, 8 ) != "https://" ){
			$image4 = plugins_url( '/wp-easycart-data/products/pics4/' . $image4 );
		}
		if( $image5 != "" && substr( $image5, 0, 7 ) != "http://" && substr( $image5, 0, 8 ) != "https://" ){
			$image5 = plugins_url( '/wp-easycart-data/products/pics5/' . $image5 );
		}
		
		$fields = apply_filters( 'wp_easycart_admin_product_details_images_fields_list', array(
			array(
				"name"				=> "use_optionitem_images",
				"type"				=> "checkbox",
				"label"				=> "Option Set Images",
				"required" 			=> false,
				"onclick"			=> 'show_pro_required',
				"read-only"			=> true,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"value"				=> $this->product->use_optionitem_images
			),
			array(
				"name"				=> "image1",
				"type"				=> "image_upload",
				"label"				=> "Image 1",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "use_optionitem_images",
					"value"			=> 0,
					"default_show"	=> true
				),
				"validation_type" 	=> 'image',
				"visible"			=> true,
				"value"				=> $image1
			),
			array(
				"name"				=> "image2",
				"type"				=> "image_upload",
				"label"				=> "Image 2",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "use_optionitem_images",
					"value"			=> 0,
					"default_show"	=> true
				),
				"validation_type" 	=> 'image',
				"visible"			=> false,
				"value"				=> $image2
			),
			array(
				"name"				=> "image3",
				"type"				=> "image_upload",
				"label"				=> "Image 3",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "use_optionitem_images",
					"value"			=> 0,
					"default_show"	=> true
				),
				"validation_type" 	=> 'image',
				"visible"			=> false,
				"value"				=> $image3
			),
			array(
				"name"				=> "image4",
				"type"				=> "image_upload",
				"label"				=> "Image 4",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "use_optionitem_images",
					"value"			=> 0,
					"default_show"	=> true
				),
				"validation_type" 	=> 'image',
				"visible"			=> false,
				"value"				=> $image4
			),
			array(
				"name"				=> "image5",
				"type"				=> "image_upload",
				"label"				=> "Image 5",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "use_optionitem_images",
					"value"			=> 0,
					"default_show"	=> true
				),
				"validation_type" 	=> 'image',
				"visible"			=> false,
				"value"				=> $image5
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function menus_fields( ){
		global $wpdb;
		$menus = $wpdb->get_results( "SELECT ec_menulevel1.menulevel1_id as id, ec_menulevel1.name as value FROM ec_menulevel1 ORDER BY ec_menulevel1.name ASC" );
		$submenus = $wpdb->get_results( "SELECT ec_menulevel2.menulevel2_id as id, ec_menulevel2.menulevel1_id AS parent_id, ec_menulevel2.name as value FROM ec_menulevel2 ORDER BY ec_menulevel2.menulevel1_id ASC, ec_menulevel2.name ASC" );
		$subsubmenus = $wpdb->get_results( "SELECT ec_menulevel3.menulevel3_id as id, ec_menulevel3.menulevel2_id AS parent_id, ec_menulevel3.name as value FROM ec_menulevel3 ORDER BY ec_menulevel3.menulevel2_id ASC, ec_menulevel3.name ASC" );
		$fields = apply_filters( 'wp_easycart_admin_product_details_menus_fields_list', array(
			array(
				"name"				=> "menulevel1_id_1",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Menu Level 1",
				"data"				=> $menus,
				"data_label"		=> "None Selected",
				"required" 			=> false,
				"onchange"			=> 'product_details_update_menus',
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->menulevel1_id_1
			),
			array(
				"name"				=> "menulevel1_id_2",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Menu Level 2",
				"data"				=> $submenus,
				"data_label"		=> "None Selected",
				"required" 			=> false,
				"onchange"			=> 'product_details_update_menus',
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->menulevel1_id_2
			),
			array(
				"name"				=> "menulevel1_id_3",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Menu Level 3",
				"data"				=> $subsubmenus,
				"data_label"		=> "None Selected",
				"required" 			=> false,
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->menulevel1_id_3
			),
			array(
				"name"				=> "menulevel2_id_1",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Menu Level 1",
				"data"				=> $menus,
				"data_label"		=> "None Selected",
				"required" 			=> false,
				"onchange"			=> 'product_details_update_menus',
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->menulevel2_id_1
			),
			array(
				"name"				=> "menulevel2_id_2",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Menu Level 2",
				"data"				=> $submenus,
				"data_label"		=> "None Selected",
				"required" 			=> false,
				"onchange"			=> 'product_details_update_menus',
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->menulevel2_id_2
			),
			array(
				"name"				=> "menulevel2_id_3",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Menu Level 3",
				"data"				=> $subsubmenus,
				"data_label"		=> "None Selected",
				"required" 			=> false,
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->menulevel2_id_3
			),
			array(
				"name"				=> "menulevel3_id_1",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Menu Level 1",
				"data"				=> $menus,
				"data_label"		=> "None Selected",
				"required" 			=> false,
				"onchange"			=> 'product_details_update_menus',
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->menulevel3_id_1
			),
			array(
				"name"				=> "menulevel3_id_2",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Menu Level 2",
				"data"				=> $submenus,
				"data_label"		=> "None Selected",
				"required" 			=> false,
				"onchange"			=> 'product_details_update_menus',
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->menulevel3_id_2
			),
			array(
				"name"				=> "menulevel3_id_3",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Menu Level 3",
				"data"				=> $subsubmenus,
				"data_label"		=> "None Selected",
				"required" 			=> false,
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->menulevel3_id_3
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function categories_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_categories_fields_list', array(
			array(
				"name"				=> "categories",
				"type"				=> "categories",
				"label"				=> "Categories"
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function quantity_fields( ){
		$quantity_type = 0;
		if( $this->product->use_optionitem_quantity_tracking )
			$quantity_type = 2;
		else if( $this->product->show_stock_quantity )
			$quantity_type = 1;
		
		$fields = apply_filters( 'wp_easycart_admin_product_details_quantity_fields_list', array(

			array(
				"name"				=> "stock_quantity_type",
				"type"				=> "select",
				"data"				=> array(
					(object) array(
						"id"		=> 1,
						"value"		=> "Track Overall Quantity"
					),
					(object) array(
						"id"		=> 2,
						"value"		=> "Track Option Item Quantity"
					)
				),
				"data_label"		=> "Do NOT Track Quantity",
				"label"				=> "Track Quantity",
				"required" 			=> false,
				"onchange"			=> "return ec_admin_product_details_quantity_type_change",
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $quantity_type
			),
			
			array(
				"name"				=> "stock_quantity",
				"requires"			=> array(
					"name"			=> "show_stock_quantity",
					"value"			=> 1,
					"default_show"	=> false
				),
				"type"				=> "number",
				"label"				=> "Total In Stock",
				"required" 			=> false,
				"validation_type" 	=> 'number',
				"visible"			=> true,
				"value"				=> $this->product->stock_quantity
			),
			
			array(
				"name"				=> "min_purchase_quantity",
				"type"				=> "number",
				"label"				=> "Minimum Quantity",
				"required" 			=> false,
				"validation_type" 	=> 'number',
				"visible"			=> true,
				"value"				=> $this->product->min_purchase_quantity
			),
			
			array(
				"name"				=> "max_purchase_quantity",
				"type"				=> "number",
				"label"				=> "Maximum Quantity",
				"required" 			=> false,
				"validation_type" 	=> 'number',
				"visible"			=> true,
				"value"				=> $this->product->max_purchase_quantity
			)
			
		) );
		$this->print_fields( $fields );
	}
	
	public function optionitem_quantity_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_quantity_fields_list', array(

			array(
				"name"				=> "optionitem_quantity",
				"type"				=> "optionitem_quantity",
				"label"				=> "Option Item Quantites"
			)
			
		) );
		$this->print_fields( $fields );
	}
	
	public function packaging_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_packaging_fields_list', array(
			array(
				"name"				=> "weight",
				"type"				=> "number",
				"label"				=> "Weight",
				"required" 			=> false,
				"validation_type" 	=> 'number',
				"visible"			=> true,
				"default"			=> "0.000",
				"value"				=> $this->product->weight
			),
			array(
				"name"				=> "width",
				"type"				=> "number",
				"label"				=> "Width",
				"required" 			=> false,
				"validation_type" 	=> 'number',
				"visible"			=> true,
				"default"			=> "1.000",
				"value"				=> $this->product->width
			),
			array(
				"name"				=> "height",
				"type"				=> "number",
				"label"				=> "Height",
				"required" 			=> false,
				"validation_type" 	=> 'number',
				"visible"			=> true,
				"default"			=> "1.000",
				"value"				=> $this->product->height
			),
			array(
				"name"				=> "length",
				"type"				=> "number",
				"label"				=> "Length",
				"required" 			=> false,
				"validation_type" 	=> 'number',
				"visible"			=> true,
				"default"			=> "1.000",
				"value"				=> $this->product->length
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function pricing_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_pricing_fields_list', array(
			array(
				"name"				=> "list_price",
				"type"				=> "currency",
				"label"				=> "Previous Price",
				"required" 			=> false,
				"validation_type" 	=> 'price',
				"visible"			=> true,
				"default"			=> "0.00",
				"value"				=> $this->product->list_price
			),
			array(
				"name"				=> "show_custom_price_range",
				"type"				=> "checkbox",
				"label"				=> "Custom Price Range Display (e.g. $90-$99)",
				"required" 			=> false,
				"onclick"			=> 'show_custom_price_range',
				"read-only"			=> true,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"value"				=> $this->product->show_custom_price_range
			),
			array(
				"name"				=> "price_range_low",
				"type"				=> "currency",
				"label"				=> "Price Range Display Low",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "show_custom_price_range",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'price',
				"visible"			=> false,
				"value"				=> $this->product->price_range_low
			),
			array(
				"name"				=> "price_range_high",
				"type"				=> "currency",
				"label"				=> "Price Range Display High",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "show_custom_price_range",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'price',
				"visible"			=> false,
				"value"				=> $this->product->price_range_high
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function advanced_pricing_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_pricing_fields_list', array(
			array(
				"name"				=> "tier_pricing",
				"type"				=> "tier_pricing",
				"label"				=> "Volume Pricing"
			),
			array(
				"name"				=> "b2b_pricing",
				"type"				=> "b2b_pricing",
				"label"				=> "B2B Pricing"
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function shipping_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_shipping_fields_list', array(
			array(
				"name"				=> "is_shippable",
				"type"				=> "checkbox",
				"label"				=> "Enable Shipping",
				"required" 			=> false,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"selected"			=> true,
				"value"				=> $this->product->is_shippable
			),
			array(
				"name"				=> "allow_backorders",
				"type"				=> "checkbox",
				"label"				=> "Allow Backorders",
				"required" 			=> false,
				"show"				=> array(
					"name"			=> "backorder_fill_date",
					"value"			=> "1"
				),
				"onchange"			=> 'ec_admin_product_details_backorder_change',
				"validation_type" 	=> 'checkbox',
				"visible"			=> false,
				"value"				=> $this->product->allow_backorders
			),
			array(
				"name"				=> "backorder_fill_date",
				"type"				=> "text",
				"label"				=> "Expected Delivery Date",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "allow_backorders",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'text',
				"visible"			=> true,
				"value"				=> $this->product->backorder_fill_date
			),
			array(
				"name"				=> "handling_price",
				"type"				=> "currency",
				"label"				=> "One-Time Handling Cost",
				"required" 			=> false,
				"validation_type" 	=> 'price',
				"visible"			=> true,
				"default"			=> "0.000",
				"value"				=> $this->product->handling_price
			),
			array(
				"name"				=> "handling_price_each",
				"type"				=> "currency",
				"label"				=> "Handling Cost Each Item",
				"required" 			=> false,
				"validation_type" 	=> 'price',
				"visible"			=> true,
				"default"			=> "0.000",
				"value"				=> $this->product->handling_price_each
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function short_description_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_short_description_fields_list', array(
			array(
				"name"				=> "short_description",
				"type"				=> "textarea",
				"label"				=> "Short Description",
				"required" 			=> false,
				"validation_type" 	=> 'textarea',
				"visible"			=> true,
				"value"				=> $this->product->short_description
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function specifications_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_specifications_fields_list', array(
			array(
				"name"				=> "specifications",
				"type"				=> "wp_textarea",
				"label"				=> "Specifications",
				"required" 			=> false,
				"validation_type" 	=> 'textarea',
				"visible"			=> true,
				"value"				=> $this->product->specifications
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function order_completed_note_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_order_completed_note_fields_list', array(
			array(
				"name"				=> "order_completed_note",
				"type"				=> "wp_textarea",
				"label"				=> "Order Completed Note",
				"required" 			=> false,
				"validation_type" 	=> 'textarea',
				"visible"			=> true,
				"value"				=> $this->product->order_completed_note
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function order_completed_email_note_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_order_completed_email_note_fields_list', array(
			array(
				"name"				=> "order_completed_email_note",
				"type"				=> "wp_textarea",
				"label"				=> "Order email product note",
				"required" 			=> false,
				"validation_type" 	=> 'textarea',
				"visible"			=> true,
				"value"				=> $this->product->order_completed_email_note
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function order_completed_details_note_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_order_completed_details_note_fields_list', array(
			array(
				"name"				=> "order_completed_details_note",
				"type"				=> "wp_textarea",
				"label"				=> "Order details product note",
				"required" 			=> false,
				"validation_type" 	=> 'textarea',
				"visible"			=> true,
				"value"				=> $this->product->order_completed_details_note
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function featured_products_fields( ){
		global $wpdb;
		$products = $wpdb->get_results( "SELECT ec_product.product_id AS id, ec_product.title AS value FROM ec_product ORDER BY title ASC" );
		$fields = apply_filters( 'wp_easycart_admin_product_details_featured_products_fields_list', array(
			array(
				"name"				=> "featured_product_id_1",
				"type"				=> "select",
				"label"				=> "Featured Product 1",
				"data"				=> $products,
				"data_label"		=> "None Selected",
				"select2"			=> "basic",
				"required" 			=> false,
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->featured_product_id_1
			),
			array(
				"name"				=> "featured_product_id_2",
				"type"				=> "select",
				"label"				=> "Featured Product 2",
				"data"				=> $products,
				"data_label"		=> "None Selected",
				"select2"			=> "basic",
				"required" 			=> false,
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->featured_product_id_2
			),
			array(
				"name"				=> "featured_product_id_3",
				"type"				=> "select",
				"label"				=> "Featured Product 3",
				"data"				=> $products,
				"data_label"		=> "None Selected",
				"select2"			=> "basic",
				"required" 			=> false,
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->featured_product_id_3
			),
			array(
				"name"				=> "featured_product_id_4",
				"type"				=> "select",
				"label"				=> "Featured Product 4",
				"data"				=> $products,
				"data_label"		=> "None Selected",
				"select2"			=> "basic",
				"required" 			=> false,
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->featured_product_id_4
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function general_options_fields( ){
		global $wpdb;
		$user_roles = $wpdb->get_results( "SELECT ec_role.role_id AS id, ec_role.role_label AS value FROM ec_role ORDER BY role_label ASC" );
		$user_roles[] = (object) array( "id" => -1, "value" => "Logged Out Users Only" );
		$fields = apply_filters( 'wp_easycart_admin_product_details_general_options_fields_list', array(
			array(
				"name"				=> "show_on_startup",
				"type"				=> "checkbox",
				"label"				=> "Show on Main Store Page",
				"required" 			=> false,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"selected"			=> true,
				"value"				=> $this->product->show_on_startup
			),
			array(
				"name"				=> "is_special",
				"type"				=> "checkbox",
				"label"				=> "Include in Specials Widget",
				"required" 			=> false,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"value"				=> $this->product->is_special
			),
			array(
				"name"				=> "use_customer_reviews",
				"type"				=> "checkbox",
				"label"				=> "Allow Customer Reviews",
				"required" 			=> false,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"value"				=> $this->product->use_customer_reviews
			),
			array(
				"name"				=> "is_donation",
				"type"				=> "checkbox",
				"label"				=> "Donation/Invoice Product",
				"required" 			=> false,
				"validation_type" 	=> 'checkbox',
				"onclick"			=> 'show_pro_required',
				"read-only"			=> true,
				"visible"			=> true,
				"value"				=> $this->product->is_donation
			),
			array(
				"name"				=> "is_giftcard",
				"type"				=> "checkbox",
				"label"				=> "Gift Card Product",
				"required" 			=> false,
				"onclick"			=> 'show_pro_required',
				"read-only"			=> true,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"value"				=> $this->product->is_giftcard
			),
			array(
				"name"				=> "inquiry_mode",
				"type"				=> "checkbox",
				"label"				=> "Inquiry Mode",
				"required" 			=> false,
				"onclick"			=> 'show_pro_required',
				"read-only"			=> true,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"value"				=> $this->product->inquiry_mode
			),
			array(
				"name"				=> "inquiry_url",
				"type"				=> "text",
				"label"				=> "Inquiry URL",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "inquiry_mode",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'text',
				"visible"			=> true,
				"value"				=> $this->product->inquiry_url
			),
			array(
				"name"				=> "catalog_mode",
				"type"				=> "checkbox",
				"label"				=> "Seasonal Mode",
				"required" 			=> false,
				"show"				=> array(
					"name"			=> "catalog_mode_phrase",
					"value"			=> "1"
				),
				"onclick"			=> 'show_pro_required',
				"read-only"			=> true,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"value"				=> $this->product->catalog_mode
			),
			array(
				"name"				=> "catalog_mode_phrase",
				"type"				=> "text",
				"label"				=> "Seasonal Phrase",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "catalog_mode",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'text',
				"visible"			=> true,
				"value"				=> $this->product->catalog_mode_phrase
			),
			array(
				"name"				=> "role_id",
				"type"				=> "select",
				"label"				=> "Restrict to User Role",
				"data"				=> $user_roles,
				"data_label"		=> "Show to All User Levels",
				"select2"			=> "basic",
				"required" 			=> false,
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->role_id
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function tax_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_tax_fields_list', array(
			array(
				"name"				=> "is_taxable",
				"type"				=> "checkbox",
				"label"				=> "Product is Taxable",
				"required" 			=> false,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"selected"			=> true,
				"value"				=> $this->product->is_taxable
			),
			array(
				"name"				=> "vat_rate",
				"type"				=> "checkbox",
				"label"				=> "VAT Enabled",
				"required" 			=> false,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"value"				=> intval( $this->product->vat_rate )
			),
			array(
				"name"				=> "TIC",
				"type"				=> "text",
				"label"				=> "TIC (Tax Cloud)",
				"required" 			=> false,
				"validation_type" 	=> 'text',
				"visible"			=> true,
				"onclick"			=> 'show_pro_required',
				"read-only"			=> true,
				"value"				=> $this->product->TIC
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function deconetwork_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_deconetwork_fields_list', array(
			array(
				"name"				=> "is_deconetwork",
				"type"				=> "checkbox",
				"label"				=> "Deconetwork Product",
				"required" 			=> false,
				"onclick"			=> 'show_pro_required',
				"read-only"			=> true,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"value"				=> $this->product->is_deconetwork
			),
			array(
				"name"				=> "deconetwork_mode",
				"type"				=> "select",
				"data"				=> array(
					(object) array(
						"id"		=> "designer",
						"value"		=> "Designer Mode"
					),
					(object) array(
						"id"		=> "blank",
						"value"		=> "Blank Mode"
					),
					(object) array(
						"id"		=> "designer_predec",
						"value"		=> "Designer Predecorated Mode"
					),
					(object) array(
						"id"		=> "predec",
						"value"		=> "Predecorated Mode"
					),
					(object) array(
						"id"		=> "design",
						"value"		=> "Blank Design Mode"
					),
					(object) array(
						"id"		=> "view_design",
						"value"		=> "Design Detail Mode"
					)
				),
				"data_label"		=> "None Selected",
				"label"				=> "Deconetwork Mode",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_deconetwork",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'select',
				"visible"			=> false,
				"value"				=> $this->product->deconetwork_mode
			),
			array(
				"name"				=> "deconetwork_product_id",
				"type"				=> "text",
				"label"				=> "Product ID",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_deconetwork",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'text',
				"visible"			=> false,
				"value"				=> $this->product->deconetwork_product_id
			),
			array(
				"name"				=> "deconetwork_size_id",
				"type"				=> "text",
				"label"				=> "Product Size ID",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_deconetwork",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'text',
				"visible"			=> false,
				"value"				=> $this->product->deconetwork_size_id
			),
			array(
				"name"				=> "deconetwork_color_id",
				"type"				=> "text",
				"label"				=> "Product Color ID",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_deconetwork",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'text',
				"visible"			=> false,
				"value"				=> $this->product->deconetwork_color_id
			),
			array(
				"name"				=> "deconetwork_design_id",
				"type"				=> "text",
				"label"				=> "Deconetwork Design ID",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_deconetwork",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'text',
				"visible"			=> false,
				"value"				=> $this->product->deconetwork_design_id
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function subscription_fields( ){
		global $wpdb;
		$fields = apply_filters( 'wp_easycart_admin_product_details_subscription_fields_list', array(
			array(
				"name"				=> "is_subscription_item",
				"type"				=> "checkbox",
				"label"				=> "Subscription Product",
				"required" 			=> false,
				"onclick"			=> 'show_pro_required',
				"read-only"			=> true,
				"validation_type" 	=> 'checkbox',
				"visible"			=> true,
				"value"				=> $this->product->is_subscription_item
			),
			array(
				"name"				=> "subscription_interval",
				"type"				=> "subscription_interval",
				"label"				=> "Subscription Interval (How often to bill the customer)",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_subscription_item",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'subscription_interval',
				"visible"			=> false,
				"bill_length"		=> $this->product->subscription_bill_length,
				"bill_period"		=> $this->product->subscription_bill_period
			),
			array(
				"name"				=> "subscription_bill_duration",
				"type"				=> "text",
				"label"				=> "Billing Duration",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_subscription_item",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'text',
				"visible"			=> false,
				"value"				=> $this->product->subscription_bill_duration
			),
			array(
				"name"				=> "trial_period_days",
				"type"				=> "number",
				"label"				=> "Trial Days",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_subscription_item",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'number',
				"visible"			=> false,
				"value"				=> $this->product->trial_period_days
			),
			array(
				"name"				=> "subscription_signup_fee",
				"type"				=> "currency",
				"label"				=> "Initial Fee",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_subscription_item",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'price',
				"visible"			=> false,
				"value"				=> $this->product->subscription_signup_fee
			),
			array(
				"name"				=> "allow_multiple_subscription_purchases",
				"type"				=> "checkbox",
				"label"				=> "Allow Multiple Subscriptions",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_subscription_item",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'checkbox',
				"visible"			=> false,
				"value"				=> $this->product->allow_multiple_subscription_purchases
			),
			array(
				"name"				=> "subscription_prorate",
				"type"				=> "checkbox",
				"label"				=> "Prorate on Upgrade/Downgrade",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_subscription_item",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'checkbox',
				"visible"			=> false,
				"value"				=> $this->product->subscription_prorate
			),
			array(
				"name"				=> "subscription_plan_id",
				"type"				=> "select",
				"label"				=> "Stripe Plan",
				"data"				=> $wpdb->get_results( "SELECT subscription_plan_id AS id, plan_title AS value FROM ec_subscription_plan ORDER BY plan_title ASC" ),
				"data_label"		=> "No Plan",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_subscription_item",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'select',
				"visible"			=> false,
				"value"				=> $this->product->subscription_plan_id
			),
			array(
				"name"				=> "membership_page",
				"type"				=> "text",
				"label"				=> "Membership URL",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_subscription_item",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'text',
				"visible"			=> false,
				"value"				=> $this->product->membership_page
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function seo_fields( ){
		$fields = apply_filters( 'wp_easycart_admin_product_details_seo_fields_list', array(
			array(
				"name"				=> "seo_description",
				"type"				=> "textarea",
				"label"				=> "SEO Description",
				"required" 			=> false,
				"validation_type" 	=> 'textarea',
				"visible"			=> true,
				"value"				=> $this->product->seo_description
			),
			array(
				"name"				=> "seo_keywords",
				"type"				=> "textarea",
				"label"				=> "SEO Keywords",
				"required" 			=> false,
				"validation_type" 	=> 'textarea',
				"visible"			=> true,
				"value"				=> $this->product->seo_keywords
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function downloads_fields( ){
		$s3_files = array( (object) array( "id" => "0", "value" => "Not Connected" ) );
		if( ( get_option( 'ec_option_amazon_key' ) != '' && get_option( 'ec_option_amazon_key' ) != '0' ) && 
			( get_option( 'ec_option_amazon_secret' ) != '' && get_option( 'ec_option_amazon_secret' ) != '0' ) &&
			( get_option( 'ec_option_amazon_bucket' ) != '' && get_option( 'ec_option_amazon_bucket' ) != '0' ) && 
			( phpversion( ) >= 5.3 ) ){
			
			try{
				require_once( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/inc/classes/account/ec_amazons3.php" );
				$amazons3 = new ec_amazons3( );
				$s3_files_from_server = $amazons3->get_aws_files( );
				$s3_files = array( );
				foreach( $s3_files_from_server as $file ){
					$s3_files[] = (object) array(
						"id"			=> $file,
						"value"			=> $file
					);
				}
			}catch( Exception $e ){
				echo 'Error connecting to Amazon S3: ' . $e->getMessage( );
			}
		}
		
		$fields = apply_filters( 'wp_easycart_admin_product_details_downloads_fields_list', array(
			array(
				"name"				=> "is_download",
				"type"				=> "checkbox",
				"label"				=> "Download Product",
				"required" 			=> false,
				"validation_type" 	=> 'checkbox',
				"onclick"			=> 'show_pro_required',
				"read-only"			=> true,
				"visible"			=> true,
				"value"				=> $this->product->is_download
			),
			array(
				"name"				=> "is_amazon_download",
				"type"				=> "select",
				"label"				=> "Download Location",
				"data"				=> array(
					(object) array(
						"id"		=> "1",
						"value"		=> "Amazon S3"
					)
				),
				"data_label"		=> "My Server",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_download",
					"value"			=> 1,
					"default_show"	=> false
				),
				"onchange"			=> 'ec_admin_product_details_download_location_toggle',
				"validation_type" 	=> 'select',
				"visible"			=> false,
				"value"				=> $this->product->is_amazon_download
			),
			array(
				"name"				=> "amazon_key",
				"type"				=> "select",
				"label"				=> "S3 File",
				"data"				=> $s3_files,
				"data_label"		=> "None Selected",
				"required" 			=> false,
				"requires"			=> array(
					array(
						"name"		=> "is_amazon_download",
						"value"		=> 1,
						"default_show"=> false
					),
					array(
						"name"		=> "is_download",
						"value"		=> 1,
						"default_show"=> false
					)
				),
				"validation_type" 	=> 'select',
				"visible"			=> false,
				"value"				=> $this->product->amazon_key
			),
			array(
				"name"				=> "download_file_name",
				"type"				=> "image_upload",
				"button_label"		=> "Upload File",
				"label"				=> "Download File",
				"required" 			=> false,
				"requires"			=> array(
					array(
						"name"		=> "is_amazon_download",
						"value"		=> 0,
						"default_show"=> false
					),
					array(
						"name"		=> "is_download",
						"value"		=> 1,
						"default_show"=> false
					)
				),
				"validation_type" 	=> 'image',
				"image_action"		=> 'ec_admin_download_upload',
				"visible"			=> true,
				"delete_label"		=> 'Remove File',
				"value"				=> $this->product->download_file_name
			),
			array(
				"name"				=> "maximum_downloads_allowed",
				"type"				=> "number",
				"label"				=> "Maximum Downloads",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_download",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'number',
				"visible"			=> false,
				"value"				=> $this->product->maximum_downloads_allowed
			),
			array(
				"name"				=> "download_timelimit_seconds",
				"type"				=> "number",
				"label"				=> "Expiration (in seconds)",
				"required" 			=> false,
				"requires"			=> array(
					"name"			=> "is_download",
					"value"			=> 1,
					"default_show"	=> false
				),
				"validation_type" 	=> 'number',
				"visible"			=> false,
				"value"				=> $this->product->download_timelimit_seconds
			)
		) );
		$this->print_fields( $fields );
	}
	
	public function tags_fields( ){
		
		$fields = apply_filters( 'wp_easycart_admin_product_details_tags_fields_list', array(

			array(
				"name"				=> "tag_type",
				"type"				=> "select",
				"label"				=> "Tag Type",
				"required" 			=> false,
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"data"				=> array(
					(object) array(
						"id"		=> 1,
						"value"		=> "Round Tag"
					),
					(object) array(
						"id"		=> 2,
						"value"		=> "Square Tag"
					),
					(object) array(
						"id"		=> 3,
						"value"		=> "Diagonal Tag"
					),
					(object) array(
						"id"		=> 4,
						"value"		=> "Classy Tag"
					)
				),
				"data_label"		=> "No Tag",
				"value"				=> $this->product->tag_type
			),
			array(
				"name"				=> "tag_text",
				"type"				=> "text",
				"label"				=> "Tag Promo Text",
				"required" 			=> false,
				"validation_type" 	=> 'text',
				"visible"			=> true,
				"value"				=> $this->product->tag_text
			),
			array(
				"name"				=> "tag_bg_color",
				"type"				=> "color",
				"label"				=> "Tag BG Color",
				"required" 			=> false,
				"validation_type" 	=> 'color',
				"visible"			=> true,
				"value"				=> $this->product->tag_bg_color
			),
			array(
				"name"				=> "tag_text_color",
				"type"				=> "color",
				"label"				=> "Tag Text Color",
				"required" 			=> false,
				"validation_type" 	=> 'color',
				"visible"			=> true,
				"value"				=> $this->product->tag_text_color
			)

		) );
		$this->print_fields( $fields );
	}
	
	public function print_subscription_interval_field( $column ){
		echo '<div id="ec_admin_row_' . $column['name'] . '"';
		if($this->id && isset( $column['requires'] ) && isset($this->item) && $this->item->{$column['requires']['name']} != $column['requires']['value'] )
			echo ' class="ec_admin_hidden"';
		else if (!$this->id && isset( $column['requires']) && $column['requires']['default_show'] == false )
			echo ' class="ec_admin_hidden"';
		echo '>' . $column['label'];
		echo '<select name="subscription_bill_period" id="subscription_bill_period" style="min-width:75px;">';
		$periods = array( 
			(object) array( "value" => "W", "label" => "Weeks" ),
			(object) array( "value" => "M", "label" => "Months" ),
			(object) array( "value" => "Y", "label" => "Years" )
		);
		for( $i=0; $i<count( $periods ); $i++ ){
			echo '<option value="' . $periods[$i]->value . '"';
			if( $periods[$i]->value == $column['bill_period'] )
				echo ' selected="selected"';
			echo '>' . $periods[$i]->label . '</option>';
		}
		echo '</select>';
		echo '<select name="subscription_bill_length" id="subscription_bill_length" style="min-width:75px;">';
		for( $i=1; $i<=31; $i++ ){
			echo '<option value="' . $i . '"';
			if( $i == $column['bill_length'] )
				echo ' selected="selected"';
			echo '>' . $i . '</option>';
		}
		echo '</select>';
		echo '</div>';
	}
	
	public function print_advanced_options_field( $column ){
		global $wpdb;
		$advanced_options = $wpdb->get_results( "SELECT * FROM ec_option WHERE option_type != 'basic-combo' AND option_type != 'basic-swatch' ORDER BY option_label ASC" );
		
		echo '<div id="ec_admin_row_' . $column['name'] . '"';
		if( !$this->item->use_advanced_optionset )
			echo ' class="ec_admin_hidden"';
		echo '>';
		echo '<div id="ec_admin_add_new_advanced_option_row">';
		echo '<select name="add_new_advanced_option" id="add_new_advanced_option" class="select2-basic">';
		echo '<option value="0">No Selection</option>';
		foreach( $advanced_options as $advanced_option ){
			echo '<option value="' . $advanced_option->option_id . '">' . $advanced_option->option_name . '</option>';
		}
		echo '</select>';
		echo '<input type="button" value="Add New" onclick="return ec_admin_product_details_add_advanced_option( );" />';
		echo '</div>';
		echo '<div class="ec_admin_option_header"><span>Option Name</span><span>Option Type</span><span>Required</span><span></span></div>';
		echo '<div id="advanced_options_holder">';
			if( count( $this->advanced_options ) ){
				foreach( $this->advanced_options as $advanced_option ){
					echo '<div class="ec_admin_option_row" id="ec_admin_product_details_advanced_option_row_' . $advanced_option->option_to_product_id . '" data-id="' . $advanced_option->option_to_product_id . '"><span>' . $advanced_option->option_name . '</span><span>' . $advanced_option->option_type . '</span><span>' . ( $advanced_option->option_required ? 'Yes' : 'No' ) . '</span><span><a href="" onclick="return ec_admin_product_details_delete_advanced_option( \'' . $advanced_option->option_to_product_id . '\' );"><div class="dashicons-before dashicons-trash"></div></a></span></div>';
				}
			}else{
				echo '<div id="ec_admin_no_advanced_options">No Advanced Options Added</div>';
			}
		echo '</div>';
		echo '</div>';
	}
	
	public function print_optionitem_images_field( $column ){
		global $wpdb;
		$optionitems = $wpdb->get_results( $wpdb->prepare( "SELECT ec_optionitem.*, ec_optionitemimage.image1, ec_optionitemimage.image2, ec_optionitemimage.image3, ec_optionitemimage.image4, ec_optionitemimage.image5 FROM ec_optionitem LEFT JOIN ec_optionitemimage ON ( ec_optionitemimage.optionitem_id = ec_optionitem.optionitem_id AND ec_optionitemimage.product_id = %d ) WHERE option_id = %d ORDER BY optionitem_order ASC", $this->item->product_id, $this->item->option_id_1 ) );
		
		echo '<div id="ec_admin_row_' . $column['name'] . '"';
		if( !$this->item->use_optionitem_images )
			echo ' class="ec_admin_hidden"';
		echo '>';
		echo '<div id="ec_admin_add_new_optionitem_image_row">';
		echo '<label>Choose Option:</label>';
		echo '<select name="optionitems_images" id="optionitems_images" onchange="ec_admin_product_details_update_optionitem_images( );">';
		foreach( $optionitems as $optionitem ){
			echo '<option value="' . $optionitem->optionitem_id . '">' . $optionitem->optionitem_name . '</option>';
		}
		echo '</select>';
		echo '</div>';
		echo '<div id="optionitem_images_holder">';
		for( $i=0; $i<count( $optionitems ); $i++ ){
			$image1 = $optionitems[$i]->image1;
			$image2 = $optionitems[$i]->image2;
			$image3 = $optionitems[$i]->image3;
			$image4 = $optionitems[$i]->image4;
			$image5 = $optionitems[$i]->image5;
			
			if( $image1 != "" && substr( $image1, 0, 7 ) != "http://" && substr( $image1, 0, 8 ) != "https://" ){
				$image1 = plugins_url( '/wp-easycart-data/products/pics1/' . $image1 );
			}
			if( $image2 != "" && substr( $image2, 0, 7 ) != "http://" && substr( $image2, 0, 8 ) != "https://" ){
				$image2 = plugins_url( '/wp-easycart-data/products/pics2/' . $image2 );
			}
			if( $image3 != "" && substr( $image3, 0, 7 ) != "http://" && substr( $image3, 0, 8 ) != "https://" ){
				$image3 = plugins_url( '/wp-easycart-data/products/pics3/' . $image3 );
			}
			if( $image4 != "" && substr( $image4, 0, 7 ) != "http://" && substr( $image4, 0, 8 ) != "https://" ){
				$image4 = plugins_url( '/wp-easycart-data/products/pics4/' . $image4 );
			}
			if( $image5 != "" && substr( $image5, 0, 7 ) != "http://" && substr( $image5, 0, 8 ) != "https://" ){
				$image5 = plugins_url( '/wp-easycart-data/products/pics5/' . $image5 );
			}
			
			echo '<div class="ec_admin_optionitem_image_row';
			if( $i!=0 )
				echo ' ec_admin_hidden';
			echo '" id="ec_admin_product_details_optionitem_image_row_' . $optionitems[$i]->optionitem_id . '">';
			echo '<div class="ec_admin_product_details_optionitem_image_row_label">Images for ' . $optionitems[$i]->optionitem_name . '</div>';
			$fields = array(
				array(
					"name"				=> "image1_" . $optionitems[$i]->optionitem_id,
					"type"				=> "image_upload",
					"label"				=> "Image 1",
					"required" 			=> false,
					"validation_type" 	=> 'image',
					"visible"			=> true,
					"value"				=> $image1
				),
				array(
					"name"				=> "image2_" . $optionitems[$i]->optionitem_id,
					"type"				=> "image_upload",
					"label"				=> "Image 2",
					"required" 			=> false,
					"validation_type" 	=> 'image',
					"visible"			=> true,
					"value"				=> $image2
				),
				array(
					"name"				=> "image3_" . $optionitems[$i]->optionitem_id,
					"type"				=> "image_upload",
					"label"				=> "Image 3",
					"required" 			=> false,
					"validation_type" 	=> 'image',
					"visible"			=> true,
					"value"				=> $image3
				),
				array(
					"name"				=> "image4_" . $optionitems[$i]->optionitem_id,
					"type"				=> "image_upload",
					"label"				=> "Image 4",
					"required" 			=> false,
					"validation_type" 	=> 'image',
					"visible"			=> true,
					"value"				=> $image4
				),
				array(
					"name"				=> "image5_" . $optionitems[$i]->optionitem_id,
					"type"				=> "image_upload",
					"label"				=> "Image 5",
					"required" 			=> false,
					"validation_type" 	=> 'image',
					"visible"			=> true,
					"value"				=> $image5
				)
			);
			$this->print_fields( $fields );
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';
	}
	
	function print_categories_field( $column ){
		global $wpdb;
		$categories = $wpdb->get_results( "SELECT * FROM ec_category ORDER BY category_name ASC" );
		
		echo '<div id="ec_admin_row_' . $column['name'] . '">' . $column['label'];
		echo '<div id="ec_admin_add_new_category_row">';
		echo '<select name="add_new_category" id="add_new_category" class="select2-basic">';
		echo '<option value="0">No Selection</option>';
		foreach( $categories as $category ){
			echo '<option value="' . $category->category_id . '">' . $category->category_name . '</option>';
		}
		echo '</select>';
		echo '<input type="button" value="Add New" onclick="return ec_admin_product_details_add_category( );" />';
		echo '</div>';
		echo '<div class="ec_admin_option_header"><span>Category Name</span><span></span></div>';
		echo '<div id="categories_holder">';
			if( count( $this->categories ) ){
				foreach( $this->categories as $category ){
					echo '<div class="ec_admin_category_row" id="ec_admin_product_details_category_row_' . $category->category_id . '"><span>' . $category->category_name . '</span><span><a href="" onclick="return ec_admin_product_details_delete_category( \'' . $category->category_id . '\' );"><div class="dashicons-before dashicons-trash"></div></a></span></div>';
				}
			}else{
				echo '<div id="ec_admin_no_categories">Product is Not in a Category</div>';
			}
		echo '</div>';
		echo '</div>';
	}
	
	function print_optionitem_quantity_field( $column ){
		global $wpdb;
		$optionitems1 = array( );
		$optionitems2 = array( );
		$optionitems3 = array( );
		$optionitems4 = array( );
		$optionitems5 = array( );
		if( $this->item->option_id_1 )
			$optionitems1 = $wpdb->get_results( $wpdb->prepare( "SELECT ec_optionitem.* FROM ec_optionitem WHERE option_id = %d ORDER BY optionitem_order ASC", $this->item->option_id_1 ) );
		if( $this->item->option_id_2 )
			$optionitems2 = $wpdb->get_results( $wpdb->prepare( "SELECT ec_optionitem.* FROM ec_optionitem WHERE option_id = %d ORDER BY optionitem_order ASC", $this->item->option_id_2 ) );
		if( $this->item->option_id_3 )
			$optionitems3 = $wpdb->get_results( $wpdb->prepare( "SELECT ec_optionitem.* FROM ec_optionitem WHERE option_id = %d ORDER BY optionitem_order ASC", $this->item->option_id_3 ) );
		if( $this->item->option_id_4 )
			$optionitems4 = $wpdb->get_results( $wpdb->prepare( "SELECT ec_optionitem.* FROM ec_optionitem WHERE option_id = %d ORDER BY optionitem_order ASC", $this->item->option_id_4 ) );
		if( $this->item->option_id_5 )
			$optionitems5 = $wpdb->get_results( $wpdb->prepare( "SELECT ec_optionitem.* FROM ec_optionitem WHERE option_id = %d ORDER BY optionitem_order ASC", $this->item->option_id_5 ) );
		
		echo '<div id="ec_admin_row_' . $column['name'] . '" class="ec_admin_quantity_tracking_table_holder';
		if( !$this->id || !$this->item->use_optionitem_quantity_tracking )
			echo ' ec_admin_hidden';
		echo '">';
		echo '<div id="ec_admin_add_new_optionitem_quantity_row"><h3>Add New Quantity Item <a href="admin.php?page=wp-easycart-products&subpage=products&product_id=' . $this->item->product_id . '&ec_admin_form_action=export-option-item-quantities" target="_blank"' . apply_filters( 'wp_easycart_admin_lock_icon', ' onclick="return show_pro_required( );"' ) . '>Export' . apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; margin-top:8px;"></span>' ) . '</a><form action="" method="POST" enctype="multipart/form-data" style="float:right; border:1px solid #CCC; padding:5px; max-width:100%;"><input type="hidden" name="ec_admin_form_action" value="import-option-item-quantities" /><input type="hidden" name="product_id" id="product_id" value="' . $this->item->product_id . '" /><input type="file" placeholder="Choose Quantity File" name="import_file" /><input type="submit" value="Import Quantities"' . apply_filters( 'wp_easycart_admin_lock_icon', ' onclick="return show_pro_required( );"' ) . ' />' . apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="float:right; color:#FC0; margin-top:8px;"></span>' ) . '</form></h3>';
		if( count( $optionitems1 ) ){
			echo '<select name="add_new_optionitem_quantity_1" id="add_new_optionitem_quantity_1" class="select2-basic">';
			echo '<option value="0">No Selection</option>';
			foreach( $optionitems1 as $optionitem ){
				echo '<option value="' . $optionitem->optionitem_id . '">' . $optionitem->optionitem_name . '</option>';
			}
			echo '</select>';
		}
		
		if( count( $optionitems2 ) ){
			echo '<select name="add_new_optionitem_quantity_2" id="add_new_optionitem_quantity_2" class="select2-basic">';
			echo '<option value="0">No Selection</option>';
			foreach( $optionitems2 as $optionitem ){
				echo '<option value="' . $optionitem->optionitem_id . '">' . $optionitem->optionitem_name . '</option>';
			}
			echo '</select>';
		}
		
		if( count( $optionitems3 ) ){
			echo '<select name="add_new_optionitem_quantity_3" id="add_new_optionitem_quantity_3" class="select2-basic">';
			echo '<option value="0">No Selection</option>';
			foreach( $optionitems3 as $optionitem ){
				echo '<option value="' . $optionitem->optionitem_id . '">' . $optionitem->optionitem_name . '</option>';
			}
			echo '</select>';
		}
		
		if( count( $optionitems4 ) ){
			echo '<select name="add_new_optionitem_quantity_4" id="add_new_optionitem_quantity_4" class="select2-basic">';
			echo '<option value="0">No Selection</option>';
			foreach( $optionitems4 as $optionitem ){
				echo '<option value="' . $optionitem->optionitem_id . '">' . $optionitem->optionitem_name . '</option>';
			}
			echo '</select>';
		}
		
		if( count( $optionitems5 ) ){
			echo '<select name="add_new_optionitem_quantity_5" id="add_new_optionitem_quantity_5" class="select2-basic">';
			echo '<option value="0">No Selection</option>';
			foreach( $optionitems5 as $optionitem ){
				echo '<option value="' . $optionitem->optionitem_id . '">' . $optionitem->optionitem_name . '</option>';
			}
			echo '</select>';
		}
		echo '<input type="number" value="" placeholder="Quantity" name="add_new_optionitem_quantity" id="add_new_optionitem_quantity" />';
		$add_new_click_action = apply_filters( 'wp_easycart_admin_optionitem_quantity_add_click', 'show_pro_required' );
		$update_click_action = apply_filters( 'wp_easycart_admin_optionitem_quantity_update_click', 'show_pro_required' );
		$delete_click_action = apply_filters( 'wp_easycart_admin_optionitem_quantity_delete_click', 'show_pro_required' );
		echo '<input type="button" value="Add New" onclick="return ' . $add_new_click_action . '( );" />' . apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="float:left; width:25px !important; color:#FC0; margin-top:15px;"></span>' );
		echo '</div>';
		echo '<div class="ec_admin_optionitem_quantity_header"><span>Options</span><span>Quantity</span><span></span></div>';
		echo '<div id="ec_admin_product_details_optionitem_quantities_holder">';
		if( count( $this->option_item_quantities ) ){
			for( $i=0; $i<count( $this->option_item_quantities ); $i++ ){
				echo '<div id="ec_admin_product_details_optionitem_quantity_row_' . $this->option_item_quantities[$i]->optionitemquantity_id . '" class="ec_admin_opionitem_quantity_row"><label>';
				echo $this->option_item_quantities[$i]->optionitem_name_1;
				if( $this->option_item_quantities[$i]->optionitem_id_2 )
					echo ', ' . $this->option_item_quantities[$i]->optionitem_name_2;
				if( $this->option_item_quantities[$i]->optionitem_id_3 )
					echo ', ' . $this->option_item_quantities[$i]->optionitem_name_3;
				if( $this->option_item_quantities[$i]->optionitem_id_4 )
					echo ', ' . $this->option_item_quantities[$i]->optionitem_name_4;
				if( $this->option_item_quantities[$i]->optionitem_id_5 )
					echo ', ' . $this->option_item_quantities[$i]->optionitem_name_5;
				
				echo '</label><input type="number" name="optionitem_quantity_' . $this->option_item_quantities[$i]->optionitemquantity_id . '" id="optionitem_quantity_' . $this->option_item_quantities[$i]->optionitemquantity_id . '" value="' . $this->option_item_quantities[$i]->quantity . '" /><span><a href="#" onclick="return ' . $delete_click_action . '( \'' . $this->option_item_quantities[$i]->optionitemquantity_id . '\' )" title="Delete"><div class="dashicons-before dashicons-trash"></div></a> <a href="#" onclick="return ' . $update_click_action . '( \'' . $this->option_item_quantities[$i]->optionitemquantity_id . '\' )"><div class="dashicons-before dashicons-yes" title="Save"></div></a>';
				echo '</div>';
			}
		}else{
			echo '<div id="ec_admin_no_optionitem_quantities">No Option Item Quantities Setup</div>';
		}
		echo '</div>';
		echo '</div>';
	}
	
	function print_tier_pricing_field( $column ){
		echo '<div id="ec_admin_row_' . $column['name'] . '">' . apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; margin-top:5px;"></span>' ) . $column['label'];
		echo '<div id="ec_admin_add_new_price_tier_row">';
		$add_new_click_action = apply_filters( 'wp_easycart_admin_tiered_pricing_add_click', 'show_pro_required' );
		$edit_new_click_action = apply_filters( 'wp_easycart_admin_tiered_pricing_edit_click', 'show_pro_required' );
		$delete_new_click_action = apply_filters( 'wp_easycart_admin_tiered_pricing_delete_click', 'show_pro_required' );
		echo '<span>Quantity of </span><input type="number" value="" placeholder="Quantity" name="ec_admin_new_price_tier_quantity" id="ec_admin_new_price_tier_quantity" />';
		echo '<span> OR MORE will be charged </span><input type="number" value="" placeholder="Price" name="ec_admin_new_price_tier_price" id="ec_admin_new_price_tier_price" /> <span> EACH</span>';
		echo '<input type="button" value="Add New" onclick="return ' . $add_new_click_action . '( );" />';
		echo '</div>';
		echo '<div class="ec_admin_option_header"><span>Quantity</span><span>Price</span><span></span></div>';
		echo '<div id="price_tiers_holder">';
			if( count( $this->price_tiers ) ){
				foreach( $this->price_tiers as $price_tier ){
					echo '<div class="ec_admin_price_tier_row" id="ec_admin_product_details_price_tier_row_' . $price_tier->pricetier_id . '"><span><input type="number" value="' . $price_tier->quantity . '" id="ec_admin_product_details_price_tier_row_' . $price_tier->pricetier_id . '_quantity" /></span><span><input type="number" min="0" step=".001" value="' . $GLOBALS['currency']->get_number_only( $price_tier->price ) . '" id="ec_admin_product_details_price_tier_row_' . $price_tier->pricetier_id . '_price" /></span><span><a href="" onclick="return ' . $delete_new_click_action . '( \'' . $price_tier->pricetier_id . '\' );" title="Delete"><div class="dashicons-before dashicons-trash"></div></a><a href="" onclick="return ' . $edit_new_click_action . '( \'' . $price_tier->pricetier_id . '\' );" title="Save"><div class="dashicons-before dashicons-yes"></div></a></span></div>';
				}
			}else{
				echo '<div id="ec_admin_no_price_tiers">No Volume Pricing Setup</div>';
			}
		echo '</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';
	}
	
	function print_b2b_pricing_field( $column ){
		global $wpdb;
		$user_roles = $wpdb->get_results( "SELECT * FROM ec_role WHERE role_label != 'admin' AND role_label != 'shopper' ORDER BY role_label ASC" );
		
		echo '<div id="ec_admin_row_' . $column['name'] . '">' . apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; margin-top:5px;"></span>' ) . $column['label'];
		echo '<div id="ec_admin_add_new_role_price_row">';
		$add_new_click_action = apply_filters( 'wp_easycart_admin_b2b_pricing_add_click', 'show_pro_required' );
		$delete_new_click_action = apply_filters( 'wp_easycart_admin_b2b_pricing_delete_click', 'show_pro_required' );
		echo '<select name="add_new_role_price_role" id="add_new_role_price_role" class="select2-basic">';
		echo '<option value="0">No Selection</option>';
		foreach( $user_roles as $role ){
			echo '<option value="' . $role->role_label . '">' . $role->role_label . '</option>';
		}
		echo '</select>';
		echo '<span> will be charged </span><input type="number" value="" placeholder="Price" name="ec_admin_new_role_price" id="ec_admin_new_role_price" />';
		echo '<input type="button" value="Add New" onclick="return ' . $add_new_click_action . '( );" />';
		echo '</div>';
		echo '<div class="ec_admin_option_header"><span>Role</span><span>Price</span><span></span></div>';
		echo '<div id="role_prices_holder">';
			if( count( $this->b2b_prices ) ){
				foreach( $this->b2b_prices as $role_price ){
					echo '<div class="ec_admin_role_price_row" id="ec_admin_product_details_role_price_row_' . $role_price->roleprice_id . '"><span>' . $role_price->role_label . '</span><span>' . $GLOBALS['currency']->get_currency_display( $role_price->role_price ) . '</span><span><a href="" onclick="return ' . $delete_new_click_action . '( \'' . $role_price->roleprice_id . '\' );"><div class="dashicons-before dashicons-trash"></div></a></span></div>';
				}
			}else{
				echo '<div id="ec_admin_no_role_prices">No B2B Pricing Setup</div>';
			}
		echo '</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';
	}
	
	function print_manufacturer_field( $column ){
		global $wpdb;
		$fields = array( 
			array(
				"name"				=> "manufacturer_id",
				"type"				=> "select",
				"select2"			=> "basic",
				"label"				=> "Manufacturer",
				"data"				=> $wpdb->get_results( "SELECT manufacturer_id AS id, ec_manufacturer.name as value FROM ec_manufacturer ORDER BY ec_manufacturer.name" ),
				"data_label"		=> "Select a Manufacturer",
				"required" 			=> true,
				"message"			=> "Your product must be connected to a manufacturer",
				"validation_type" 	=> 'select',
				"visible"			=> true,
				"value"				=> $this->product->manufacturer_id
			)
		);
		
		$this->print_fields( $fields );
		echo '<div class="ec_admin_product_details_manufacturer_column2"><input type="button" value="Create New Manufacturer" onclick="return ec_admin_product_details_add_new_manufacturer( );" /><input type="text" name="manufacturer_name" id="manufacturer_name" placeholder="New Manufacturer Name" /></div>';
	}
	
}