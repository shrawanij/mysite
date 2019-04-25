<?php
$table = new wp_easycart_admin_table( );
$table->set_table( 'ec_order', 'order_id' );
$table->set_table_id( 'ec_admin_order_list' );
$table->set_default_sort( 'order_id', 'DESC' );
$table->set_icon( 'tag' );
$table->set_add_new(false, '', '');
$table->set_docs_link ('orders','order-management');
$table->set_join( 'LEFT JOIN ec_orderstatus ON (ec_orderstatus.status_id = ec_order.orderstatus_id)' );
$table->set_list_columns( 
	array(
		array( 
			'name' 	=> 'order_viewed', 
			'label'	=> '',
			'format'=> 'order_viewed'
		),
		array( 
			'name' 	=> 'order_id', 
			'label'	=> 'Order ID',
			'format'=> 'int'
		),
		array( 
			'select'=> "ec_order.order_date AS order_date",
			'name' 	=> 'order_date', 
			'label'	=> 'Order Date',
			'format'=> 'datetime'
		),
		array( 
			'name' 	=> 'grand_total',
			'label'	=> 'Order Total',
			'format'=> 'currency'
		),
		array( 
			'name' 	=> 'billing_first_name',
			'label'	=> 'First Name',
			'format'=> 'string'
		),
		array( 
			'name' 	=> 'billing_last_name',
			'label'	=> 'Last Name',
			'format'=> 'string'
		),
		array( 
			'select'=> 'ec_orderstatus.order_status',
			'name' 	=> 'order_status',
			'label'	=> 'Order Status',
			'format'=> 'string'
		)
	)
);

global $wpdb;
$order_status = $wpdb->get_results( "SELECT ec_orderstatus.status_id AS value, ec_orderstatus.order_status AS label FROM ec_orderstatus ORDER BY status_id ASC" );
$products = $wpdb->get_results( "SELECT product_id AS value, title AS label FROM ec_product ORDER BY model_number ASC LIMIT 500" );
$users = $wpdb->get_results( "SELECT user_id AS value, CONCAT(first_name, ' ', last_name) AS label FROM ec_user ORDER BY last_name, first_name ASC LIMIT 500" );

$table->set_filters(
	array(
		array(
			'data'		=> $order_status,
			'label'		=> 'Order Status',
			'where'		=> 'ec_order.orderstatus_id = %s'
		),
		array(
			'data'		=> $products,
			'label'		=> 'Purchased Product',
			'where'		=> 'ec_orderdetail.product_id = %s',
			'where2'	=> 'ec_orderdetail.model_number = %s',
			'join'		=> 'LEFT JOIN ec_orderdetail ON ec_orderdetail.order_id = ec_order.order_id',
			'group'		=> 'GROUP BY ec_order.order_id'
		),
		array(
			'data'		=> $users,
			'label'		=> 'By Customer',
			'where'		=> 'ec_order.user_id = %d'
		)
		
	)
);

$table->set_search_columns(
	array( 'ec_order.order_id', 'ec_order.user_email', 'ec_order.billing_first_name', 'ec_order.billing_last_name', 'ec_order.shipping_first_name', 'ec_order.shipping_last_name', 'ec_orderstatus.order_status' )
);
$table->set_bulk_actions(
	array(
		array(
			'name'	=> 'delete-order',
			'label'	=> 'Delete'
		),
		array(
			'name'	=> 'resend-email',
			'label'	=> 'Resend Email Receipt'
		),
		array(
			'name'	=> 'print-receipt',
			'label'	=> 'Print Receipt'
		),
		array(
			'name'	=> 'print-packing-slip',
			'label'	=> 'Print Packing Slip'
		),
		array(
			'name'	=> 'change-order-status',
			'label'	=> 'Change Order Status',
			'alt'	=> array(
				'id'	 	=> 'bulk_order_status',
				'options'	=> $order_status
			)
		),
		array(
			'name'	=> 'export-orders-csv',
			'label'	=> 'Export Selected CSV'
		),
		array(
			'name'	=> 'export-orders-csv-all',
			'label'	=> 'Export All CSV'
		),
		array(
			'name'	=> 'mark-orders-viewed',
			'label'	=> 'Mark Selected Viewed'
		),
		array(
			'name'	=> 'mark-orders-not-viewed',
			'label'	=> 'Mark Selected Not Viewed'
		),
		array(
			'name'	=> 'mark-all-orders-viewed',
			'label'	=> 'Mark All Viewed'
		),
		array(
			'name'	=> 'mark-all-orders-not-viewed',
			'label'	=> 'Mark All Not Viewed'
		)
	)
);
$table->set_actions(
	array(
		array(
			'name'	=> 'quick-edit',
			'label'	=> 'Quick Edit',
			'icon' 	=> 'feedback',
			'type'	=> 'order'
		),
		array(
			'name'	=> 'edit',
			'label'	=> 'Edit',
			'icon' 	=> 'edit'
		),
		array(
			'name'	=> 'delete-order',
			'label'	=> 'Delete',
			'icon'  => 'trash'
		)
	)
);

$table->set_label( 'Order', 'Orders' );
if( !get_option( 'ec_option_review_complete' ) ){
?>
<div class="wp-easycart-admin-review-us-box">
	Do you like WP EasyCart? If you do, please take a moment to <a href="https://wordpress.org/support/plugin/wp-easycart/reviews/" target="_blank">submit a review</a>, it really helps us!
    <div class="wp-easycart-admin-review-us-close" onclick="wp_easycart_admin_close_review( );"><div class="dashicons dashicons-no"></div></div>
</div>
<?php
}
$table->print_table( );
wp_easycart_admin( )->load_new_slideout( 'order' );
?>
<script>
jQuery( document.getElementById( 'ec_form_action' ) ).on( 'change', function( ){
	if( jQuery( this ).val( ) == 'change-order-status' ){
		jQuery( document.getElementById( 'bulk_order_status' ) ).show( );
	}else{
		jQuery( document.getElementById( 'bulk_order_status' ) ).hide( );
	}
} );
</script>