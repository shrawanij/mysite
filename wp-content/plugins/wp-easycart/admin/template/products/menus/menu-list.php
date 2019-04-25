<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_menulevel1', 'menulevel1_id' );
$table->set_table_id( 'ec_admin_menu_list' );
$table->set_default_sort( 'menu_order', 'ASC' );
$table->set_default_sort( 'name', 'ASC' );
$table->set_header( 'Manage Menus' );
$table->set_add_new( true, 'add-new-menulevel1', 'Add New');
$table->set_icon( 'menu' );
$table->set_docs_link ('products','menus');
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'name', 
			'label'	=> 'Menu Name',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'menulevel1_id', 
			'label'	=> 'Menu ID',
			'format'=> 'number'
		),
		array( 
			'name' 	=> 'clicks',
			'label'	=> 'Menu Clicks',
			'format'=> 'int'
		)
	)
);
$table->set_search_columns(
	array( 'ec_menulevel1.name' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-menulevel1',
			'label'	=> 'Delete'
		)
	)
);
$table->set_actions(
	array(
		array(
			'custom'=> 'subpage',
			'name'	=> 'submenus',
			'label'	=> 'View Submenu',
			'icon'	=> 'external'
		),
		array(
			'name'	=> 'edit',
			'label'	=> 'Edit',
			'icon'	=> 'edit'
		),
		array(
			'name'	=> 'delete-menulevel1',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);
$table->set_filters(
	array( )
);
$table->set_label( 'Menu', 'Menus' );
$table->print_table( );
?>