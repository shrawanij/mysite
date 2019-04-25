<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_manufacturer', 'manufacturer_id' );
$table->set_default_sort( 'name', 'ASC' );
$table->set_header( 'Manage Manufacturers' );
$table->set_icon( 'products' );
$table->set_docs_link ('products','manufacturers');
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'manufacturer_id', 
			'label'	=> 'ID',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'name', 
			'label'	=> 'Manufacturer Name',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'clicks',
			'label'	=> 'Clicks',
			'format'=> 'int'
		)
	)
);
$table->set_search_columns(
	array( 'ec_manufacturer.name' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-manufacturer',
			'label'	=> 'Delete'
		)
	)
);
$table->set_actions(
	array(
		array(
			'name'	=> 'edit',
			'label'	=> 'Edit',
			'icon'	=> 'edit'
		),
		array(
			'name'	=> 'delete-manufacturer',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);

$table->set_filters(
	array( )
);
$table->set_label( 'Manufacturer', 'Manufacturers' );
$table->print_table( );
?>