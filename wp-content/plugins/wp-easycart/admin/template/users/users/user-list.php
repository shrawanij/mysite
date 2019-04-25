<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_user', 'user_id' );
$table->set_table_id( 'ec_admin_user_list' );
$table->set_default_sort( 'email', 'ASC' );
$table->set_header( 'Manage User Accounts' );
$table->set_icon( 'admin-users' );
$table->set_docs_link ('users','user-accounts');
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'email',
			'label'	=> 'Email Address',
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
		),
		array( 
			'name' 	=> 'user_level',
			'label'	=> 'Security Level',
			'format'=> 'string'
		)
	)
);
$table->set_search_columns(
	array( 'ec_user.email', 'ec_user.first_name', 'ec_user.last_name', 'ec_user.user_level' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-account',
			'label'	=> 'Delete'
		),
		array(
			'name'	=> 'export-accounts-csv',
			'label'	=> 'Export Selected CSV'
		),
		array(
			'name'	=> 'export-accounts-csv-all',
			'label'	=> 'Export All CSV'
		),
		array(
			'name'	=> 'accounts-force-password-reset',
			'label'	=> 'Force Selected to Reset Password'
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
			'name'	=> 'delete-account',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);
global $wpdb;
$user_roles = $wpdb->get_results( "SELECT ec_role.role_label AS value, ec_role.role_label AS label FROM ec_role ORDER BY role_id ASC" );

$table->set_filters(
	array(
		array(
			'data'		=> $user_roles,
			'label'		=> 'User Role',
			'where'		=> 'ec_user.user_level = %s'
		),
		
	)
);
$table->set_label( 'User', 'Users' );
$table->print_table( );
?>
