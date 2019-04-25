<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_perpage', 'perpage_id' );
$table->set_default_sort( 'perpage', 'ASC' );
$table->set_header( 'Manage Per-Page' );
$table->set_icon( 'admin-site' );
$table->set_docs_link ('settings','manage-per-page');
$table->set_list_columns( 
	array(

		array( 
			'name' 	=> 'perpage',
			'label'	=> 'Per-Page Value',
			'format'=> 'string'
		)
	)
);
$table->set_search_columns(
	array( 'ec_perpage.perpage' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-perpage',
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
			'name'	=> 'delete-perpage',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);

$table->set_filters(
	array( )
);
$table->set_label( 'Per-Page', 'Per-Page' );
$table->print_table( );
?>