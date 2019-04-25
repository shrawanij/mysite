<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_pricepoint', 'pricepoint_id' );
$table->set_default_sort( 'pricepoint_order', 'ASC' );
$table->set_header( 'Manage Price Points' );
$table->set_icon( 'admin-site' );
$table->set_docs_link ('settings','manage-price-points');
$table->set_list_columns( 
	array(

		array( 
			'name' 	=> 'low_point',
			'label'	=> 'Low Price Point',
			'format'=> 'currency'
		),
		array( 
			'name' 	=> 'High_point',
			'label'	=> 'High Price Point',
			'format'=> 'currency'
		),
		array( 
			'name' 	=> 'is_less_than',
			'label'	=> 'Less Than',
			'format'=> 'checkbox'
		),
		array( 
			'name' 	=> 'is_greater_than',
			'label'	=> 'Greater Than',
			'format'=> 'checkbox'
		)
	)
);
$table->set_search_columns(
	array( 'ec_pricepoint.pricepoint_id' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-pricepoint',
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
			'name'	=> 'delete-pricepoint',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);

$table->set_filters(
	array( )
);
$table->set_label( 'Price Point', 'Price Points' );
$table->print_table( );
?>