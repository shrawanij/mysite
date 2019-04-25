<?php
global $wpdb;
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_optionitem', 'optionitem_id' );
$table->set_table_id( 'ec_optionitem_table' );
$table->set_sortable( true );
//$table->set_join( 'LEFT JOIN ec_product ON ec_product.product_id = ec_categoryitem.product_id' );
$table->set_default_sort( 'ec_optionitem.optionitem_order', 'ASC' );
$option_data = $wpdb->get_results( $wpdb->prepare("SELECT ec_option.option_name, ec_option.option_type FROM ec_option WHERE ec_option.option_id = %d", $_GET['option_id'] ) );
$table->set_header( "Manage '" . $option_data[0]->option_name . "' Items" );
$table->set_icon( 'image-filter' );
$table->set_docs_link ('products','option-sets');
if($option_data[0]->option_type == 'basic-combo' || $option_data[0]->option_type == 'basic-swatch' || $option_data[0]->option_type == 'combo' || $option_data[0]->option_type == 'swatch' || $option_data[0]->option_type == 'radio' || $option_data[0]->option_type == 'checkbox' || $option_data[0]->option_type == 'grid') {
	$table->set_add_new (true, 'add-new-optionitem&option_id=' . $_GET['option_id'], 'Add New');
} else {
	$table->set_add_new (false);
}
$table->set_cancel(true, 'admin.php?page=wp-easycart-products&subpage=option', 'Back to Option Sets');
$table->set_custom_where( $wpdb->prepare( ' AND ec_optionitem.option_id = %d', $_GET['option_id'] ) );
if ($option_data[0]->option_type == 'basic-swatch' || $option_data[0]->option_type == 'swatch') {
	$table->set_list_columns( 
		array(
			array( 
				'name' 	=> 'optionitem_icon', 
				'label'	=> 'Image Swatch',
				'format'=> 'image_swatch',
				'alt'	=> 'optionitem_name'
			),
			array( 
				'name' 	=> 'optionitem_name', 
				'label'	=> 'Option Item Name',
				'format'=> 'string'
			),
			array( 
				'name' 	=> 'optionitem_price', 
				'label'	=> 'Basic Price Change',
				'format'=> 'currency'
			),
			array( 
				'name'	=> 'optionitem_weight', 
				'label'	=> 'Weight Change',
				'format'=> 'string'
			)
		)
	);
} else {
	$table->set_list_columns( 
		array(
			array( 
				'name' 	=> 'optionitem_name', 
				'label'	=> 'Option Item Name',
				'format'=> 'string'
			),
			array( 
				'name' 	=> 'optionitem_price', 
				'label'	=> 'Basic Price Change',
				'format'=> 'currency'
			),
			array( 
				'name'	=> 'optionitem_weight', 
				'label'	=> 'Weight Change',
				'format'=> 'string'
			)
		)
	);
}
$table->set_search_columns(
	array( 'ec_optionitem.optionitem_name', 'ec_optionitem.optionitem_model_number' )
);

if ($option_data[0]->option_type == 'text' || $option_data[0]->option_type == 'textarea' || $option_data[0]->option_type == 'file' || $option_data[0]->option_type == 'date' || $option_data[0]->option_type == 'dimension1' || $option_data[0]->option_type == 'dimension2' || $option_data[0]->option_type == 'number') {
	$table->set_bulk_actions(
		array(
			
		)
	);
	$table->set_actions(
		array(
			array(
				'name'	=> 'edit',
				'label'	=> 'Edit Option Item',
				'icon'	=> 'edit'
			),	
				
		)
	);
} else {
	$table->set_bulk_actions(
		array(
			array(
				'name'	=> 'delete-optionitem',
				'label'	=> 'Delete'
			)
		)
	);
	$table->set_actions(
		array(
			array(
				'name'	=> 'edit',
				'label'	=> 'Edit Option Item',
				'icon'	=> 'edit'
			),
			array(
				'name'	=> 'duplicate-optionitem',
				'label'	=> 'Duplicate',
				'icon'	=> 'admin-page'
			),	
			array(
				'name'	=> 'delete-optionitem',
				'label'	=> 'Delete',
				'icon'	=> 'trash'
			)
			
		)
	);
}
$table->set_filters(
	array( )
);
$table->set_label( 'Option Item', 'Option Items' );
$table->set_get_vars( array( 'option_id' ) );
$table->print_table( );
?>