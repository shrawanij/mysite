<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_response', 'response_id' );
$table->set_default_sort( 'response_id', 'DESC' );
$table->set_header( 'EasyCart Logging System' );
$table->set_icon( 'sos' );
$table->set_add_new(false);
$table->set_docs_link ('settings','logs');
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'response_id',
			'label'	=> 'Log ID',
			'format'=> 'int'
		),
		array( 
			'name' 	=> 'order_id',
			'label'	=> 'Order ID',
			'format'=> 'int'
		),
		array( 
			'name' 	=> 'processor',
			'label'	=> 'Source',
			'format'=> 'text'
		),
		array( 
			'name' 	=> 'is_error', 
			'label'	=> 'Is Error?',
			'format'=> 'checkbox'
		),array( 
			'name' 	=> 'response_time',
			'label'	=> 'Date',
			'format'=> 'date'
		)
	)
);
$table->set_search_columns(
	array( 'ec_response.response_id', 'ec_response.order_id' )
);
$table->set_bulk_actions(
	array(
		
	)
);
$table->set_actions(
	array(
		array(
			'name'	=> 'edit',
			'label'	=> 'Edit',
			'icon'	=> 'edit'
		)
	)
);

$table->set_filters(
	array( )
);
$table->set_label( 'Log Entry', 'Log Entries' );
$table->print_table( );
?>