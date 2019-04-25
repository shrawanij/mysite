<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_product', 'product_id' );
$table->set_table_id( 'ec_admin_product_list' );
$table->set_default_sort( 'title', 'ASC' );
$table->set_header( 'Manage Products' );
$table->set_icon( 'products' );
$table->set_importer( true, 'Import Products');
$table->set_docs_link ('products','products');
$table->set_add_new_js( 'wp_easycart_admin_open_slideout( \'new_product_box\' ); return false;' );
$table->set_add_new_css( 'ec_page_title_button' );
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'title', 
			'label'	=> 'Product Title',
			'format'=> 'string',
			'width'	=> 225
		),
		array( 
			'name' 	=> 'stock_quantity', 
			'label'	=> 'Quantity',
			'format'=> 'int'
		),
		array( 
			'name' 	=> 'price',
			'label'	=> 'Price',
			'format'=> 'currency'
		), 
		array( 
			'name' 	=> 'model_number',
			'label'	=> 'SKU',
			'format'=> 'string'
		),
		array( 
			'select'=> 'ec_product.activate_in_store as is_visible',
			'name' 	=> 'is_visible',
			'label'	=> 'Active',
			'format'=> 'yes_no'
		),
		array( 
			'name' 	=> 'product_id',
			'label'	=> 'ID',
			'format'=> 'int',
		),
		array( 
			'name' 	=> 'views',
			'label'	=> 'ID',
			'format'=> 'hidden'
		)
	)
);
$table->set_search_columns(
	array( 'ec_product.title', 'ec_product.short_description', 'ec_product.description', 'ec_product.model_number' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-product',
			'label'	=> 'Delete'
		),
		array(
			'name'	=> 'activate-product',
			'label'	=> 'Activate Selected'
		),
		array(
			'name'	=> 'deactivate-product',
			'label'	=> 'Deactivate Selected'
		),

		array(
			'name'	=> 'export-products-csv',
			'label'	=> 'Export Selected CSV'
		),
		array(
			'name'	=> 'export-all-products-csv',
			'label'	=> 'Export All CSV'
		)
	)
);
$table->set_actions(
	array(
		array(
			'name'	=> 'stats',
			'label'	=> 'Stats',
			'icon'	=> 'chart-bar',
			'custom'=> '#',
			'customhtml'=>' class="ec_admin_stats_link" onmouseout="wp_easycart_hide_product_stats( jQuery( this ) );" onmouseover="wp_easycart_show_product_stats( jQuery( this ) );" onclick="return false;"'
		),
		array(
			'name'	=> 'edit',
			'label'	=> 'Edit',
			'icon'	=> 'edit'
		),
		array(
			'name'	=> 'deactivate-product',
			'label'	=> 'Deactivate',
			'icon'	=> 'hidden'
		),
		array(
			'name'	=> 'duplicate-product',
			'label'	=> 'Duplicate',
			'icon'	=> 'admin-page'
		),
		array(
			'name'	=> 'delete-product',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);
global $wpdb;
$manufacturer_list = $wpdb->get_results( "SELECT ec_manufacturer.manufacturer_id AS value, ec_manufacturer.name AS label FROM ec_manufacturer ORDER BY ec_manufacturer.name ASC" );
$category_list = $wpdb->get_results( "SELECT ec_category.category_id AS value, ec_category.category_name AS label FROM ec_category ORDER BY ec_category.category_name ASC" );
$table->set_filters(
	array(
		array(
			'data'		=> $manufacturer_list,
			'label'		=> 'All Manufacturers',
			'where'		=> 'ec_product.manufacturer_id = %d'
		),
		array(
			'data'		=> $category_list,
			'label'		=> 'All Categories',
			'select'	=> 'ec_categoryitem.category_id',
			'join'		=> 'LEFT JOIN ec_categoryitem ON (ec_categoryitem.product_id = ec_product.product_id)',
			'having'	=> 'ec_categoryitem.category_id = %d'
		)
	)
);
$table->set_label( 'Product', 'Products' );
if( !get_option( 'ec_option_review_complete' ) ){
?>
<div class="wp-easycart-admin-review-us-box">
	Do you like WP EasyCart? If you do, please take a moment to <a href="https://wordpress.org/support/plugin/wp-easycart/reviews/" target="_blank">submit a review</a>, it really helps us!
    <div class="wp-easycart-admin-review-us-close" onclick="wp_easycart_admin_close_review( );"><div class="dashicons dashicons-no"></div></div>
</div>
<?php
}
$table->print_table( );

wp_easycart_admin( )->load_new_slideout( 'product' );
wp_easycart_admin( )->load_new_slideout( 'manufacturer' );
wp_easycart_admin( )->load_new_slideout( 'optionset' );
?>