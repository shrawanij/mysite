<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_state', 'id_sta' );
$table->set_default_sort( 'sort_order', 'ASC' );
$table->set_header( 'Manage States & Provinces' );
$table->set_icon( 'admin-site' );
$table->set_docs_link ('settings','manage-states');
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'name_sta', 
			'label'	=> 'State/Province',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'code_sta',
			'label'	=> 'Abbreviated Name',
			'format'=> 'string'
		),

		array( 
			'name' 	=> 'ship_to_active',
			'label'	=> 'Enabled?',
			'format'=> 'checkbox'
		),
		array( 
			'name' 	=> 'sort_order',
			'label'	=> 'Sort Order',
			'format'=> 'string'
		)
	)
);
$table->set_search_columns(
	array( 'ec_state.name_sta' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-state',
			'label'	=> 'Delete'
		),
		array(
			'name'	=> 'bulk-enable-state',
			'label'	=> 'Enable'
		),
		array(
			'name'	=> 'bulk-disable-state',
			'label'	=> 'Disable'
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
			'name'	=> 'delete-state',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);

$table->set_filters(
	array( )
);
$table->set_label( 'State', 'States' );
$table->print_table( );
?>