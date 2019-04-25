<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_country', 'id_cnt' );
$table->set_default_sort( 'sort_order', 'ASC' );
$table->set_header( 'Manage Countries' );
$table->set_icon( 'admin-site' );
$table->set_docs_link ('settings','manage-countries');
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'name_cnt', 
			'label'	=> 'Country Name',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'iso2_cnt',
			'label'	=> '2 Digit Name',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'iso3_cnt',
			'label'	=> '3 Digit Name',
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
	array( 'ec_country.name_cnt' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-country',
			'label'	=> 'Delete'
		),
		array(
			'name'	=> 'bulk-enable-country',
			'label'	=> 'Enable'
		),
		array(
			'name'	=> 'bulk-disable-country',
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
			'name'	=> 'delete-country',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);

$table->set_filters(
	array( )
);
$table->set_label( 'Country', 'Countries' );
$table->print_table( );
?>