<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_category', 'category_id' );
$table->set_table_id( 'ec_admin_category_list' );
$table->set_sortable( true );
$table->set_default_sort( array( 'priority', 'category_name' ), array( 'DESC', 'ASC' ) );
$table->set_header( 'Manage Product Categories' );
$table->set_add_new( true, 'add-new-category', 'Add New');
$table->set_icon( 'menu' );
$table->set_docs_link ('products','categories');
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'category_name', 
			'label'	=> 'Category Name',
			'format'=> 'text'
		),
		array( 
			'name' 	=> 'category_id', 
			'label'	=> 'Category ID',
			'format'=> 'int'
		),
		array( 
			'select'=> '(SELECT COUNT(ec_categoryitem.category_id) FROM ec_categoryitem WHERE ec_categoryitem.category_id = `ec_category`.category_id) AS total_products',
			'name' 	=> 'total_products',
			'label'	=> 'Products in Category',
			'format'=> 'int'
		),
		array( 
			'name' 	=> 'featured_category',
			'label'	=> 'Featured Category',
			'format'=> 'checkbox'
		)
	)
);
$table->set_search_columns(
	array( 'ec_category.category_name' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-category',
			'label'	=> 'Delete'
		)
	)
);
$table->set_actions(
	array(
		array(
			'custom'=> 'subpage',
			'name'	=> 'category-products',
			'label'	=> 'Edit Products',
			'icon'	=> 'external'
		),
		array(
			'name'	=> 'edit',
			'label'	=> 'Edit',
			'icon'	=> 'edit'
		),
		array(
			'name'	=> 'duplicate-category',
			'label'	=> 'Duplicate',
			'icon'	=> 'admin-page'
		),	
		array(
			'name'	=> 'delete-category',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);
$table->set_filters(
	array( )
);
$table->set_label( 'Category', 'Categories' );
$table->print_table( );
?>