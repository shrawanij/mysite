<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_option', 'option_id' );
$table->set_table_id( 'ec_admin_option_list' );
$table->set_default_sort( 'option_name', 'ASC' );
$table->set_header( 'Manage Option Sets' );
$table->set_add_new( true, 'add-new-option', 'Add New');
$table->set_icon( 'image-filter' );
$table->set_docs_link ('products','option-sets');
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'option_name', 
			'label'	=> 'Option Set Name',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'option_type', 
			'label'	=> 'Option Type',
			'format'=> 'optiontype'
		),
		array( 
			'name' 	=> 'option_id', 
			'label'	=> 'Option ID',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'option_required',
			'label'	=> 'Option Required?',
			'format'=> 'checkbox'
		)
	)
);
$table->set_search_columns(
	array( 'ec_option.option_name', 'ec_option.option_label', 'ec_option.option_id', 'ec_option.option_type' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-option',
			'label'	=> 'Delete'
		)
	)
);
$table->set_actions(
	array(

		array(
			'custom'=> 'subpage',
			'name'	=> 'optionitems',
			'label'	=> 'Edit Option Items',
			'icon'	=> 'external'
		),
		array(
			'name'	=> 'edit',
			'label'	=> 'Edit Option',
			'icon'	=> 'edit'
		),
		array(
			'name'	=> 'duplicate-option',
			'label'	=> 'Duplicate',
			'icon'	=> 'admin-page'
		),
		array(
			'name'	=> 'delete-option',
			'label'	=> 'Delete',
			'icon'	=> 'trash'
		)
	)
);
$option_types = array(
	(object) array(
			'value'	=> 'basic-combo',
			'label'	=> 'Basic Combo'
	),
	(object) array(
			'value'	=> 'basic-swatch',
			'label'	=> 'Basic Swatch'
	),
	(object) array(
			'value'	=> 'combo',
			'label'	=> 'Advanced Combo Box'
	),
	(object) array(
			'value'	=> 'swatch',
			'label'	=> 'Advanced Image Swatches'
	),
	(object) array(
			'value'	=> 'text',
			'label'	=> 'Advanced Text Input'
	),
	(object) array(
			'value'	=> 'textarea',
			'label'	=> 'Advanced Text Area'
	),
	(object) array(
			'value'	=> 'number',
			'label'	=> 'Advanced Number Field'
	),
	(object) array(
			'value'	=> 'file',
			'label'	=> 'Advanced File Upload'
	),
	(object) array(
			'value'	=> 'radio',
			'label'	=> 'Advanced Radio Group'
	),
	(object) array(
			'value'	=> 'checkbox',
			'label'	=> 'Advanced Checkbox Group'
	),
	(object) array(
			'value'	=> 'grid',
			'label'	=> 'Advanced Quantity Grid'
	),
	(object) array(
			'value'	=> 'date',
			'label'	=> 'Advanced Date'
	),
	(object) array(
			'value'	=> 'dimensions1',
			'label'	=> 'Advanced Dimensions (Whole Inch)'
	),
	(object) array(
			'value'	=> 'dimensions2',
			'label'	=> 'Advanced Dimensions (Sub-Inch)'
	)
);
$option_requirements = array(
	(object) array(
			'value'	=> '1',
			'label'	=> 'Option Required'
	),
	(object) array(
			'value'	=> '0',
			'label'	=> 'Option Not Required'
	)
);
$table->set_filters(
	array(
		array(
			'data'		=> $option_types,
			'label'		=> 'All Option Types',
			'where'		=> 'ec_option.option_type = %s'
		),
		array(
			'data'		=> $option_requirements,
			'label'		=> 'All Options',
			'where'		=> 'ec_option.option_required = %d'
		)
	)
);
$table->set_label( 'Option', 'Options' );
$table->print_table( );
?>