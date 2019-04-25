<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_role', 'role_id' );
$table->set_default_sort( 'role_label', 'ASC' );
$table->set_icon( 'groups' );
$table->set_docs_link ('users','user-roles');
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'role_label', 
			'label'	=> 'User Role',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'admin_access', 
			'label'	=> 'Remote Admin Access',
			'format'=> 'checkbox'
		)

	)
);
$table->set_search_columns(
	array( 'ec_role.role_label' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-user-role',
			'label'	=> 'Delete'
		),
		
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
			'name'	=> 'delete-user-role',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);
$table->set_filters(
	array( )
);
$table->set_label( 'User Role', 'User Roles' );
$table->print_table( );
?>