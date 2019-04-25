<?php
global $wpdb;
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_menulevel2', 'menulevel2_id' );
$table->set_table_id( 'ec_admin_menu_list' );
$table->set_default_sort( 'menu_order', 'ASC' );
$menu_name = $wpdb->get_var( $wpdb->prepare("SELECT ec_menulevel1.name FROM ec_menulevel1 WHERE ec_menulevel1.menulevel1_id = %d", $_GET['menulevel1_id'] ) );
$table->set_header( 'Manage Sub-Menus for ' . $menu_name );
$table->set_icon( 'menu' );
$table->set_add_new( true, 'add-new-menulevel2&menulevel1_id=' . $_GET['menulevel1_id'], 'Add New');
$table->set_cancel(true, 'admin.php?page=wp-easycart-products&subpage=menus', 'Back to Main Menus');
$table->set_custom_where( $wpdb->prepare( ' AND menulevel1_id = %d', $_GET['menulevel1_id'] ) );
$table->set_docs_link ('products','menus');
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'name', 
			'label'	=> 'Menu Name',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'menulevel2_id', 
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
	array( 'ec_menulevel2.name' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-menulevel2',
			'label'	=> 'Delete'
		)
	)
);
$table->set_actions(
	array(
		array(
			'custom'=> 'subpage',
			'name'	=> 'subsubmenus',
			'label'	=> 'View Submenu',
			'icon'	=> 'external'
		),
		array(
			'name'	=> 'edit',
			'label'	=> 'Edit',
			'icon'	=> 'edit'
		),
		array(
			'name'	=> 'delete-menulevel2',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);
$table->set_filters(
	array( )
);
$table->set_label( 'Sub-Menu', 'Sub-Menus' );
$table->set_get_vars( array( 'menulevel1_id' ) );
$table->print_table( );
?>