<?php
if(isset($_GET['category_id'])) {
	$category_id = $_GET['category_id'];
} else if (isset($_POST['category_id'])) {
	$category_id = $_POST['category_id'];
}
global $wpdb;
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_product', 'product_id' );
$table->set_default_sort( 'ec_product.title', 'ASC' );
$category_name = $wpdb->get_var( $wpdb->prepare("SELECT ec_category.category_name FROM ec_category WHERE ec_category.category_id = %d", $category_id ) );
$table->set_header( "Add Products to '" . $category_name . "' Category" );
$table->set_icon( 'menu' );
$table->set_add_new (false, '','');
$table->set_cancel(true, 'admin.php?page=wp-easycart-products&subpage=category-products&ec_admin_form_action=edit-products&category_id=' . $category_id, 'Back to Category Products');
$table->set_docs_link ('products','categories');
$table->set_list_columns(  
	array(

		array( 
			'name' 	=> 'title', 
			'label'	=> 'Product Title',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'model_number', 
			'label'	=> 'Model Number',
			'format'=> 'string'
		),
		array( 
			'name'	=> 'price', 
			'label'	=> 'Price',
			'format'=> 'currency'
		)
	)
);
$table->set_search_columns(
	array( 'ec_product.title', 'ec_product.model_number' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'add-to-category-product',
			'label'	=> 'Add to Category'
		)
	)
);
$table->set_bulk_action_hidden_variables(
	array(
		array(
			'name'	=> 'category_id',
			'label'	=> $category_id
		)
	)
);
$table->set_actions(
	array( )
);
$table->set_filters(
	array( )
);
$table->set_label( 'Product', 'Products' );
$table->print_table( );
?>