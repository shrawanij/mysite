<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_review', 'review_id' );
$table->set_table_id( 'ec_admin_review_list' );
$table->set_join( 'LEFT JOIN ec_product ON ec_product.product_id = ec_review.product_id' );
$table->set_default_sort( 'ec_review.date_submitted', 'DESC' );
$table->set_icon( 'format-chat' );
$table->set_docs_link ('products','product-reviews');
$table->set_add_new (false, '', '');
$table->set_list_columns( 
	array(
		array( 
			'select'=> "DATE_FORMAT( ec_review.date_submitted, '%b %d, %Y' ) AS date_submitted",
			'name' 	=> 'date_submitted', 
			'label'	=> 'Review Date',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'title',
			'label'	=> 'Review Title',
			'format'=> 'string'
		),
		array( 
			'select'=> 'ec_product.title AS product_title',
			'name' 	=> 'product_title', 
			'label'	=> 'Product',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'rating', 
			'label'	=> 'Rating',
			'format'=> 'star_rating'
		),
		array( 
			'name' 	=> 'approved', 
			'label'	=> 'Approved',
			'format'=> 'bool'
		)
	)
);
$table->set_search_columns(
	array( 'ec_review.title, ec_product.title' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-review',
			'label'	=> 'Delete'
		)
	)
);
$table->set_actions(
	array(
		array(
			'name'	=> 'edit',
			'label'	=> 'Edit',
			'icon'  => 'edit'
		),
		array(
			'name'	=> 'delete-review',
			'label'	=> 'Delete',
			'icon'  => 'trash'
		)
	)
);
$table->set_filters(
	array( )
);
$table->set_label( 'Product Review', 'Product Reviews' );
$table->print_table( );
?>