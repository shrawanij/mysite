<?php
$advanced_options = $wpdb->get_results( $wpdb->prepare( "SELECT ec_order_option.* FROM ec_order_option WHERE ec_order_option.orderdetail_id = %s ORDER BY order_option_id", $line_item->orderdetail_id ));
if( $advanced_options ){
    $order_detail_row = $wpdb->get_row( $wpdb->prepare( "SELECT ec_orderdetail.is_deconetwork, ec_orderdetail.deconetwork_id, ec_orderdetail.deconetwork_name, ec_orderdetail.deconetwork_product_code, ec_orderdetail.deconetwork_options, ec_orderdetail.deconetwork_color_code, ec_orderdetail.product_id, ec_orderdetail.deconetwork_image_link FROM ec_orderdetail WHERE ec_orderdetail.orderdetail_id = %d", $line_item->orderdetail_id ) );
    if( $order_detail_row !== false && $order_detail_row->is_deconetwork ){
        $deconetwork1 = new stdClass( );
        $deconetwork1->orderdetail_id = $advanced_options->orderdetail_id;
        $deconetwork1->option_name = "DecoNetwork ID: ";
        $deconetwork1->optionitem_name = "";
        $deconetwork1->option_type = "text";
        $deconetwork1->option_value = $order_detail_row->deconetwork_id;
        $deconetwork1->option_price_change = "";
        
        $advanced_options[] = $deconetwork1;
        
        $deconetwork2 = new stdClass( );
        $deconetwork2->option_name = "DecoNetwork Name: ";
        $deconetwork2->optionitem_name = "";
        $deconetwork2->option_type = "text";
        $deconetwork2->option_value =  $order_detail_row->deconetwork_name;
        $deconetwork2->option_price_change = "";
        $advanced_options[] = $deconetwork2;
        
        $deconetwork3 = new stdClass( );
        $deconetwork3->option_name = "DecoNetwork Product Code: ";
        $deconetwork3->optionitem_name = "";
        $deconetwork3->option_type = "text";
        $deconetwork3->option_value = $order_detail_row->deconetwork_product_code;
        $deconetwork3->option_price_change = "";
        $advanced_options[] = $deconetwork3;
        
        $deconetwork4 = new stdClass( );
        $deconetwork4->option_name = "DecoNetwork Options: ";
        $deconetwork4->optionitem_name = "";
        $deconetwork4->option_type = "text";
        $deconetwork4->option_value = $order_detail_row->deconetwork_options;
        $deconetwork4->option_price_change = "";
        $advanced_options[] = $deconetwork4;
        
        $deconetwork5 = new stdClass( );
        $deconetwork5->option_name = "DecoNetwork Color Code: ";
        $deconetwork5->optionitem_name = "";
        $deconetwork5->option_type = "text";
        $deconetwork5->option_value = $order_detail_row->deconetwork_color_code;
        $deconetwork5->option_price_change = "";
        $advanced_options[] = $deconetwork5;
        
        $deconetwork6 = new stdClass( );
        $deconetwork6->option_name = "DecoNetwork Image Link: ";
        $deconetwork6->optionitem_name = "";
        $deconetwork6->option_type = "text";
        $deconetwork6->option_value = $order_detail_row->deconetwork_image_link;
        $deconetwork6->option_price_change = "";
        $advanced_options[] = $deconetwork6;
    }
} ?>
<div class="ec_admin_order_details_line_item" id="ec_admin_order_details_line_item_<?php echo $line_item->orderdetail_id; ?>">
    
    <div class="ec_admin_order_details_item_actions">
        <?php $delete_line_action = apply_filters( 'wp_easycart_admin_order_details_delete_line_action', 'show_pro_required' ); ?>
        <?php $edit_line_action = apply_filters( 'wp_easycart_admin_order_details_edit_line_action', 'show_pro_required' ); ?>
        <div class="dashicons-before dashicons-trash" onclick="<?php echo $delete_line_action; ?>( '<?php echo $line_item->orderdetail_id; ?>' ); return false;"></div>
        <div class="dashicons-before dashicons-edit" onclick="<?php echo $edit_line_action; ?>( '<?php echo $line_item->orderdetail_id; ?>' ); return false;" id="ec_admin_order_line_edit_<?php echo $line_item->orderdetail_id; ?>"></div>
    </div>
    <div class="ec_admin_order_details_item_details">
        <span id="ec_admin_order_details_item_title_display_<?php echo $line_item->orderdetail_id; ?>"><?php echo $line_item->title;?></span>
        <div class="ec_details_option_label">SKU:</div> <div class="ec_details_option_value" id="ec_admin_order_details_item_model_number_display_<?php echo $line_item->orderdetail_id; ?>"><?php echo $line_item->model_number;?></div>
        <?php
        if( $line_item->optionitem_label_1 || $line_item->optionitem_name_1 ){
            if( $line_item->optionitem_label_1 )
                echo '<div class="ec_details_option_label">'.$line_item->optionitem_label_1.':</div> ';
            else 
                echo '<div class="ec_details_option_label">Option 1:</div> ';
            echo '<div class="ec_details_option_value"> '.$line_item->optionitem_name_1.'</div>';
        }
        if( $line_item->optionitem_label_2 || $line_item->optionitem_name_2 ){
            if($line_item->optionitem_label_2)
                echo '<div class="ec_details_option_label">'.$line_item->optionitem_label_2.':</div> ';
            else 
                echo '<div class="ec_details_option_label">Option 2:</div> ';
            echo '<div class="ec_details_option_value"> '.$line_item->optionitem_name_2.'</div>';
        }
        if( $line_item->optionitem_label_3 || $line_item->optionitem_name_3 ){
            if($line_item->optionitem_label_3)
                echo '<div class="ec_details_option_label">'.$line_item->optionitem_label_3.':</div> ';
            else 
                echo '<div class="ec_details_option_label">Option 3:</div> ';
            echo '<div class="ec_details_option_value"> '.$line_item->optionitem_name_3.'</div>';
        }
        if( $line_item->optionitem_label_4 || $line_item->optionitem_name_4 ){
            if($line_item->optionitem_label_4)
                echo '<div class="ec_details_option_label">'.$line_item->optionitem_label_4.':</div> ';
            else 
                echo '<div class="ec_details_option_label">Option 4:</div> ';
            echo '<div class="ec_details_option_value"> '.$line_item->optionitem_name_4.'</div>';
        }
        if( $line_item->optionitem_label_5 || $line_item->optionitem_name_5 ){
            if($line_item->optionitem_label_5)
                echo '<div class="ec_details_option_label">'.$line_item->optionitem_label_5.':</div> ';
            else 
                echo '<div class="ec_details_option_label">Option 5:</div> ';
            echo '<div class="ec_details_option_value"> '.$line_item->optionitem_name_5.'</div>';
        }
        
        foreach( $advanced_options as $advanced_option ){
            if( $advanced_option->option_name )
                echo '<div class="ec_details_option_label">'.$advanced_option->option_name.':</div> ';
            else
                echo '<div class="ec_details_option_label">Option:</div> ';
            if( $advanced_option->option_type == 'file' )
				echo '<div class="ec_details_option_value"> <a href="' . plugins_url( '/wp-easycart-data/products/uploads/' . $advanced_option->option_value ) . '" target="_blank">Download File</a></div>';
			else if( $advanced_option->option_type == "grid" )
				echo '<div class="ec_details_option_value"> '.$advanced_option->optionitem_name . " (" . $advanced_option->option_value . ")".'</div>';
			else
				echo '<div class="ec_details_option_value"> '.$advanced_option->option_value.'</div>';
        }
        
        if( $line_item->is_giftcard ){
            if( $line_item->giftcard_id ){
                echo '<div class="ec_details_option_label">Gift Card ID:</div> ';
                echo '<div class="ec_details_option_value"> '.$line_item->giftcard_id.'</div>';
            }
            if($line_item->gift_card_email) {
                echo '<div class="ec_details_option_label">Gift Card Send to Email:</div> ';
                echo '<div class="ec_details_option_value"> '.$line_item->gift_card_email.'</div>';
            }
            if($line_item->gift_card_to_name) {
                echo '<div class="ec_details_option_label">Gift Card To:</div> ';
                echo '<div class="ec_details_option_value"> '.$line_item->gift_card_to_name.'</div>';
            }
            if($line_item->gift_card_from_name) {
                echo '<div class="ec_details_option_label">Gift Card From:</div> ';
                echo '<div class="ec_details_option_value"> '.$line_item->gift_card_from_name.'</div>';
            }
            if($line_item->gift_card_message) {
                echo '<div class="ec_details_option_label">Gift Card Message:</div> ';
                echo '<div class="ec_details_option_value"> '.$line_item->gift_card_message.'</div>';
            }
            if($line_item->gift_card_email) {
                echo '<div class="ec_details_option_label">Manage:</div> ';
                echo '<div class="ec_details_option_value"><a href="#" onclick="return ec_admin_resend_giftcard('.$line_item->order_id.', '.$line_item->orderdetail_id.');">Resend Gift Card Email</a></div>';
            }
        }
        
        if( $line_item->is_download ){
            if( $line_item->is_amazon_download == 1 ){
                if( $line_item->amazon_key ){
                    echo '<div class="ec_details_option_label">Download File Name (S3 Server):</div> ';
                    echo '<div class="ec_details_option_value"> '.$line_item->amazon_key.'</div>';
                }
            }else{
                if( $line_item->download_file_name ){
                    echo '<div class="ec_details_option_label">Download File Name (Web Server):</div> ';
                    echo '<div class="ec_details_option_value"> '.$line_item->download_file_name.'</div>';
                }
            }
            if( $line_item->maximum_downloads_allowed ){
                echo '<div class="ec_details_option_label">Max Downloads Allowed:</div> ';
                echo '<div class="ec_details_option_value"> '.$line_item->maximum_downloads_allowed.'</div>';
            }
            if( $line_item->download_timelimit_seconds ){
                echo '<div class="ec_details_option_label">Download Time (seconds):</div> ';
                echo '<div class="ec_details_option_value"> '.$line_item->download_timelimit_seconds.'</div>';
            }
        }
        
        if( $line_item->subscription_id != 0 ){
            echo '<div class="ec_details_option_label">Subscription ID ('.$line_item->subscription_id.'):</div> ';
            echo '<div class="ec_details_option_value"><a href="admin.php?page=wp-easycart-orders&subpage=subscriptions&subscription_id='.$line_item->subscription_id.'&ec_admin_form_action=edit" target="_blank">View Subscription Information</a></div>';
        }
        ?> 
    </div>
    <div class="ec_admin_order_details_item_price" id="ec_admin_order_details_item_price_display_<?php echo $line_item->orderdetail_id;?>"><?php echo $line_item->quantity;?><span> x </span><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><?php echo number_format( $line_item->unit_price, 2 );?></div>
    <div class="ec_admin_order_details_item_total" id="ec_admin_order_details_item_total_display_<?php echo $line_item->orderdetail_id;?>"><?php if( $GLOBALS['currency']->get_symbol_location( ) ){ echo $GLOBALS['currency']->get_symbol( ); } ?><?php echo number_format( $line_item->total_price, 2 );?></div>
	<?php do_action( 'wp_easycart_admin_order_details_line_item_end', $line_item ); ?>
</div>