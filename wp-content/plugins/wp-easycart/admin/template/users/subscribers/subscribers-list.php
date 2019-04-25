<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_subscriber', 'subscriber_id' );
$table->set_default_sort( 'email', 'ASC' );
$table->set_icon( 'id-alt' );
$table->set_docs_link ('users','subscribers');
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'email',
			'label'	=> 'Email',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'first_name',
			'label'	=> 'First Name',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'last_name',
			'label'	=> 'Last Name',
			'format'=> 'string'
		)
	)
);
$table->set_search_columns(
	array( 'ec_subscriber.email', 'ec_subscriber.first_name', 'ec_subscriber.last_name' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-subscriber',
			'label'	=> 'Delete'
		),
		array(
			'name'	=> 'export-subscribers-csv',
			'label'	=> 'Export Selected CSV'
		),
		array(
			'name'	=> 'export-subscribers-csv-all',
			'label'	=> 'Export All CSV'
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
			'name'	=> 'delete-subscriber',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);
$table->set_filters(
	array( )
);
$table->set_label( 'Subscriber', 'Subscribers' );
$table->print_table( );
?>