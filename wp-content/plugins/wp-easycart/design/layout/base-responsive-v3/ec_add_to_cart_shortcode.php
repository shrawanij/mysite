<?php if( $product->inquiry_url == "" ){ // Regular Add to Cart Form ?>
	<form action="<?php echo $cartpage; ?>" method="POST" enctype="multipart/form-data" class="ec_add_to_cart_form">
	<?php if( $product->is_subscription_item ){ ?>
		<input type="hidden" name="ec_cart_form_action" value="subscribe_v3" />
	<?php }else{ ?>
		<input type="hidden" name="ec_cart_form_action" value="add_to_cart_v3" />
	<?php }?>
	<input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>"  />
<?php }else{ // Custom Inquiry Form ?>
	<form action="<?php echo $product->inquiry_url; ?>" method="GET" enctype="multipart/form-data" class="ec_add_to_cart_form">
	<input type="hidden" name="model_number" value="<?php echo $product->model_number; ?>"  />
<?php }?>
<?php 
$vat_rate_multiplier = 1;
if( ( $product->is_catalog_mode && get_option( 'ec_option_hide_price_seasonal' ) ) || 
		  ( $product->is_inquiry_mode && get_option( 'ec_option_hide_price_inquiry' ) ) ){ // NO PRICE SHOWN

}else if( $product->vat_rate > 0  && get_option( 'ec_option_show_multiple_vat_pricing' ) ){ 

	global $wpdb;
	$vat_row = $wpdb->get_row( "SELECT ec_taxrate.vat_rate, ec_taxrate.vat_added, ec_taxrate.vat_included FROM ec_taxrate WHERE ec_taxrate.vat_added = 1 OR ec_taxrate.vat_included = 1" );
	$vat_rate = $vat_row->vat_rate;
	$vat_rate_multiplier = ( $vat_rate / 100 ) + 1;
}
?>
<?php /* PRODUCT BASIC OPTIONS */ 
$has_quantity_grid = false;
?>
<?php if( $product->has_options ){ ?>
<div class="ec_details_options">
<?php 
$optionsets = array( $product->options->optionset1, $product->options->optionset2, $product->options->optionset3, $product->options->optionset4, $product->options->optionset5 );

for( $i=0; $i<5; $i++ ){ ?>

	<?php
	/* START SWATCHES AREA */
	if( count( $optionsets[$i]->optionset ) > 0 && $optionsets[$i]->optionset[0]->optionitem_icon && $optionsets[$i]->optionset[0]->optionitem_icon != "" ){ ?>
	
	<div class="ec_details_option_row_error ec_option<?php echo ( $i+1 ); ?>_<?php echo $product->product_id; ?>" id="ec_details_option_row_error_<?php echo $optionsets[$i]->option_id; ?>_<?php echo $product->product_id; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_missing_option' ); ?> <?php echo $optionsets[$i]->option_label; ?></div>
	<input type="hidden" name="ec_option<?php echo ($i+1); ?>" id="ec_option<?php echo ($i+1); ?>_<?php echo $product->product_id; ?>" value="0" />
	<div class="ec_details_option_row">
		<div class="ec_details_option_label"><?php echo $optionsets[$i]->option_label; ?></div>
		<ul class="ec_details_swatches">
		<?php
		for( $j=0; $j<count( $optionsets[$i]->optionset ); $j++ ){
			// Check the in stock status for this option item
			if( $product->use_optionitem_quantity_tracking && ( $i > 0 || $product->option1quantity[$optionsets[$i]->optionset[$j]->optionitem_id] <= 0 ) ){
				$optionitem_in_stock = false;
			}else{
				$optionitem_in_stock = true;
			}
		?>
		<li class="ec_details_swatch ec_option<?php echo ($i+1); ?> ec_option<?php echo ($i+1); ?>_<?php echo $product->product_id; ?><?php if( $optionitem_in_stock ){ ?> ec_active <?php }?><?php if( $optionsets[$i]->optionset[$j]->optionitem_initially_selected ){ ?> ec_selected<?php }?>" data-optionitem-id="<?php echo $optionsets[$i]->optionset[$j]->optionitem_id; ?>"<?php if( $product->use_optionitem_quantity_tracking && $i == 0 ){ ?> data-optionitem-quantity="<?php echo $product->option1quantity[$optionsets[$i]->optionset[$j]->optionitem_id]; ?>"<?php }?> data-optionitem-price="<?php if( $optionsets[$i]->optionset[$j]->optionitem_price != "" ){ echo $optionsets[$i]->optionset[$j]->optionitem_price; }else{ echo "0.00"; } ?>" data-optionitem-price-onetime="<?php if( isset( $optionsets[$i]->optionset[$j]->optionitem_price_onetime ) && $optionsets[$i]->optionset[$j]->optionitem_price_onetime != "" ){ echo $optionsets[$i]->optionset[$j]->optionitem_price_onetime; }else{ echo "0.00"; } ?>" data-optionitem-price-override="<?php if( isset( $optionsets[$i]->optionset[$j]->optionitem_price_override ) && $optionsets[$i]->optionset[$j]->optionitem_price_override != "" ){ echo $optionsets[$i]->optionset[$j]->optionitem_price_override; }else{ echo "-1.00"; } ?>" data-optionitem-price-multiplier="<?php echo $optionsets[$i]->optionset[$j]->optionitem_price_multiplier; ?>"><img src="<?php if( substr( $optionsets[$i]->optionset[$j]->optionitem_icon, 0, 7 ) == 'http://' || substr( $optionsets[$i]->optionset[$j]->optionitem_icon, 0, 8 ) == 'https://' ){ echo $optionsets[$i]->optionset[$j]->optionitem_icon; }else{ echo plugins_url( "/wp-easycart-data/products/swatches/" . $optionsets[$i]->optionset[$j]->optionitem_icon ); } ?>" title="<?php echo str_replace( '"', '&quot;', $optionsets[$i]->optionset[$j]->optionitem_name ); ?><?php if( $optionsets[$i]->optionset[$j]->optionitem_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $optionsets[$i]->optionset[$j]->optionitem_price ); ?> <?php echo $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ); ?> )<?php }else if( $optionsets[$i]->optionset[$j]->optionitem_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $optionsets[$i]->optionset[$j]->optionitem_price ); ?> <?php echo $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ); ?> )<?php }else if( isset( $optionsets[$i]->optionset[$j]->optionitem_price_onetime ) && $optionsets[$i]->optionset[$j]->optionitem_price_onetime > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $optionsets[$i]->optionset[$j]->optionitem_price_onetime ); ?> <?php echo $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ); ?> )<?php }else if( isset( $optionsets[$i]->optionset[$j]->optionitem_price_onetime ) && $optionsets[$i]->optionset[$j]->optionitem_price_onetime < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $optionsets[$i]->optionset[$j]->optionitem_price_onetime ); ?> <?php echo $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ); ?> )<?php }else if( isset( $optionsets[$i]->optionset[$j]->optionitem_price_override ) && $optionsets[$i]->optionset[$j]->optionitem_price_override > -1 ){ ?> ( <?php echo $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ); ?> <?php echo $GLOBALS['currency']->get_currency_display( $optionsets[$i]->optionset[$j]->optionitem_price_override ); ?> )<?php }?>" /></li>
		<?php
		}
		?>
		</ul>
		<div class="ec_option_loading" id="ec_option_loading_<?php echo ($i+1); ?>_<?php echo $product->product_id; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_loading_options' ); ?></div>
	</div>
	<?php
	/* END SWATCHES AREA */
	
	/* START COMBO BOX AREA */
	}else if( count( $optionsets[$i]->optionset ) > 0 && $optionsets[$i]->optionset[0]->optionitem_name != "" ){ ?>
	<div class="ec_details_option_row_error ec_option<?php echo ( $i+1 ); ?>_<?php echo $product->product_id; ?>" id="ec_details_option_row_error_<?php echo $optionsets[$i]->option_id; ?>_<?php echo $product->product_id; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_missing_option' ); ?> <?php echo $optionsets[$i]->option_label; ?></div>
	
	<div class="ec_details_option_row">
		<select name="ec_option<?php echo ($i+1); ?>" id="ec_option<?php echo ($i+1); ?>" class="ec_details_combo ec_option<?php echo ($i+1); ?>_<?php echo $product->product_id; ?> ec_option<?php echo ($i+1); ?><?php if( $product->use_optionitem_quantity_tracking && $i > 0 ){ ?> ec_inactive<?php }?>"<?php if( $product->use_optionitem_quantity_tracking && $i > 0 ){ ?> disabled="disabled"<?php }?>>
		<option value="0"<?php if( $product->use_optionitem_quantity_tracking && $i == 0 ){ ?> data-optionitem-quantity="<?php echo $product->stock_quantity; ?>"<?php }?> data-optionitem-price="0.00" data-optionitem-price-onetime="0.00" data-optionitem-price-override="-1" data-optionitem-price-multiplier="-1.00"><?php echo $optionsets[$i]->option_label; ?></option>
		<?php
		for( $j=0; $j<count( $optionsets[$i]->optionset ); $j++ ){
			// Check the in stock status for this option item
			if( $product->use_optionitem_quantity_tracking && ( $i > 0 || $product->option1quantity[$optionsets[$i]->optionset[$j]->optionitem_id] <= 0 ) ){
				$optionitem_in_stock = false;
			}else{
				$optionitem_in_stock = true;
			}
		?>
		<?php if( !$product->use_optionitem_quantity_tracking || $i != 0 || $product->option1quantity[$optionsets[$i]->optionset[$j]->optionitem_id] > 0 ){ ?> 
		<option value="<?php echo $optionsets[$i]->optionset[$j]->optionitem_id; ?>"<?php if( $product->use_optionitem_quantity_tracking && $i == 0 ){ ?> data-optionitem-quantity="<?php echo $product->option1quantity[$optionsets[$i]->optionset[$j]->optionitem_id]; ?>"<?php }?> data-optionitem-price="<?php if( $optionsets[$i]->optionset[$j]->optionitem_price != "" ){ echo $optionsets[$i]->optionset[$j]->optionitem_price; }else{ echo "0.00"; } ?>" data-optionitem-price-onetime="<?php if( $optionsets[$i]->optionset[$j]->optionitem_price_onetime != "" ){ echo $optionsets[$i]->optionset[$j]->optionitem_price_onetime; }else{ echo "0.00"; } ?>" data-optionitem-price-override="<?php if( isset( $optionsets[$i]->optionset[$j]->optionitem_price_override ) && $optionsets[$i]->optionset[$j]->optionitem_price_override != "" ){ echo $optionsets[$i]->optionset[$j]->optionitem_price_override; }else{ echo "-1.00"; } ?>" data-optionitem-price-multiplier="<?php echo $optionsets[$i]->optionset[$j]->optionitem_price_multiplier; ?>"<?php if( $optionsets[$i]->optionset[$j]->optionitem_initially_selected ){ ?> selected="selected"<?php }?>><?php echo $optionsets[$i]->optionset[$j]->optionitem_name; ?><?php if( $optionsets[$i]->optionset[$j]->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionsets[$i]->optionset[$j]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionsets[$i]->optionset[$j]->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionsets[$i]->optionset[$j]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( isset( $optionsets[$i]->optionset[$j]->optionitem_price_onetime ) && $optionsets[$i]->optionset[$j]->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionsets[$i]->optionset[$j]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionsets[$i]->optionset[$j]->optionitem_price_onetime ) && $optionsets[$i]->optionset[$j]->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionsets[$i]->optionset[$j]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionsets[$i]->optionset[$j]->optionitem_price_override ) && $optionsets[$i]->optionset[$j]->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . $GLOBALS['currency']->get_currency_display( $optionsets[$i]->optionset[$j]->optionitem_price_override ) . ')'; } ?></option>
		<?php }?>	
		<?php
		}
		?>
		</select>
		<div class="ec_option_loading" id="ec_option_loading_<?php echo ($i+1); ?>_<?php echo $product->product_id; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_loading_options' ); ?></div>
	</div>
	<?php
	}
	/* END COMBO BOX AREA*/
}
?>
</div>
<?php } ?>
<?php /* END BASIC OPTIONS */ ?>

<?php /* PRODUCT ADVANCED OPTIONS */ ?>
<?php 

$add_price_grid = 0;
$add_order_price_grid = 0;
$override_price_grid = -1;
if( $product->use_advanced_optionset && count( $product->advanced_optionsets ) > 0 ){ ?>
<div class="ec_details_options">
	<?php 
	foreach( $product->advanced_optionsets as $optionset ){
		$optionitems = $product->get_advanced_optionitems( $optionset->option_id );
	?>
	<?php 
	if( $optionset->option_required ){ 
	?>
	<div class="ec_details_option_row_error" id="ec_details_option_row_error_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?>"><?php echo $optionset->option_error_text; ?></div>
	<?php
	}
	?>
	<div class="ec_details_option_row ec_option_type_<?php echo $optionset->option_type; ?>" data-option-id="<?php echo $optionset->option_id; ?>" data-option-required="<?php echo $optionset->option_required; ?>" data-product-id="<?php echo $product->product_id; ?>">
		<?php if( $optionset->option_type != "combo" ){ ?>
		<div class="ec_details_option_label"><?php echo $optionset->option_label; ?></div>
		<?php }?>
		<div class="ec_details_option_data">
		<?php
		/* START ADVANCED CHECBOX TYPE */
		if( $optionset->option_type == "checkbox" ){
		?>
		
			<?php
			foreach( $optionitems as $optionitem ){
			?>
				
				<div class="ec_details_checkbox_row"><input type="checkbox" class="ec_option_<?php echo $optionset->option_id; ?>" name="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $optionitem->optionitem_id; ?>" value="<?php echo $optionitem->optionitem_name; ?>" data-product-id="<?php echo $product->product_id; ?>" data-optionitem-price="<?php echo $optionitem->optionitem_price; ?>" data-optionitem-price-onetime="<?php echo $optionitem->optionitem_price_onetime; ?>" data-optionitem-price-override="<?php echo $optionitem->optionitem_price_override; ?>" data-optionitem-price-multiplier="<?php echo $optionitem->optionitem_price_multiplier; ?>"<?php if( $optionitem->optionitem_initially_selected ){ ?> checked="checked"<?php }?> /> <?php echo $optionitem->optionitem_name; ?><?php if( $optionitem->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitem->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitem->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $optionitem->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionitem->optionitem_price_override ) && $optionitem->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_override ) . ')'; } ?></div>
				
			<?php
			}
			?>
			
		<?php
		
		/* START ADVANCED COMBO TYPE */
		}else if( $optionset->option_type == "combo" ){
		?>
			<select name="ec_option_<?php echo $optionset->option_id; ?>" id="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?>">
			<option value="0" data-optionitem-price="0.000" data-optionitem-price-onetime="0.000" data-optionitem-price-override="-1.000" data-optionitem-price-multiplier="-1.000"><?php echo $optionset->option_label; ?></option>
			<?php
			foreach( $optionitems as $optionitem ){
			?>
				
				<option value="<?php echo $optionitem->optionitem_id; ?>" data-product-id="<?php echo $product->product_id; ?>" data-optionitem-price="<?php echo $optionitem->optionitem_price; ?>" data-optionitem-price-onetime="<?php echo $optionitem->optionitem_price_onetime; ?>" data-optionitem-price-override="<?php echo $optionitem->optionitem_price_override; ?>" data-optionitem-price-multiplier="<?php echo $optionitem->optionitem_price_multiplier; ?>"<?php if( $optionitem->optionitem_initially_selected ){ ?> selected="selected"<?php }?>><?php echo $optionitem->optionitem_name; ?><?php if( $optionitem->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitem->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitem->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $optionitem->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionitem->optionitem_price_override ) && $optionitem->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_override ) . ')'; } ?></option>
				
			<?php
			}
			?>
			</select>
		<?php
		
		/* START ADVANCED DATE TYPE*/
		}else if( $optionset->option_type == "date" ){
		?>
		
			<input type="date" name="ec_option_<?php echo $optionset->option_id; ?>" id="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?>" data-product-id="<?php echo $product->product_id; ?>" data-optionitem-price="<?php echo $optionitems[0]->optionitem_price; ?>" data-optionitem-price-onetime="<?php echo $optionitems[0]->optionitem_price_onetime; ?>" data-optionitem-price-override="<?php echo $optionitems[0]->optionitem_price_override; ?>" data-optionitem-price-multiplier="<?php echo $optionitems[0]->optionitem_price_multiplier; ?>" /><?php if( $optionitems[0]->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionitems[0]->optionitem_price_override ) && $optionitems[0]->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_override ) . ')'; } ?>
		
		<?php
		
		/* START ADVANCED FILE TYPE */
		}else if( $optionset->option_type == "file" ){
		?>
		
			<input type="file" name="ec_option_<?php echo $optionset->option_id; ?>" id="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?>" data-product-id="<?php echo $product->product_id; ?>" data-optionitem-price="<?php echo $optionitems[0]->optionitem_price; ?>" data-optionitem-price-onetime="<?php echo $optionitems[0]->optionitem_price_onetime; ?>" data-optionitem-price-override="<?php echo $optionitems[0]->optionitem_price_override; ?>" data-optionitem-price-multiplier="<?php echo $optionitems[0]->optionitem_price_multiplier; ?>" /><?php if( $optionitems[0]->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionitems[0]->optionitem_price_override ) && $optionitems[0]->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_override ) . ')'; } ?>
		
		<?php
		
		/* START ADVANCED SWATCH TYPE */
		}else if( $optionset->option_type == "swatch" ){
		?>
			<input type="hidden" name="ec_option_<?php echo $optionset->option_id; ?>" id="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?>" value="0" />
			<ul class="ec_details_swatches">
				<?php
				for( $j=0; $j<count( $optionitems ); $j++ ){
				?>
					<li class="ec_details_swatch ec_advanced ec_option_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?> ec_active<?php if( $optionsets[$i]->optionset[$j]->optionitem_initially_selected ){ ?> ec_selected<?php }?>" data-product-id="<?php echo $product->product_id; ?>" data-optionitem-id="<?php echo $optionitems[$j]->optionitem_id; ?>" data-option-id="<?php echo $optionset->option_id; ?>" data-optionitem-price="<?php echo $optionitems[$j]->optionitem_price; ?>" data-optionitem-price-onetime="<?php echo $optionitems[$j]->optionitem_price_onetime; ?>" data-optionitem-price-override="<?php echo $optionitems[$j]->optionitem_price_override; ?>" data-optionitem-price-multiplier="<?php echo $optionitems[$j]->optionitem_price_multiplier; ?>"><img src="<?php if( substr( $optionitems[$j]->optionitem_icon, 0, 7 ) == 'http://' || substr( $optionitems[$j]->optionitem_icon, 0, 8 ) == 'https://' ){ echo $optionitems[$j]->optionitem_icon; }else{ echo plugins_url( "/wp-easycart-data/products/swatches/" . $optionitems[$j]->optionitem_icon ); } ?>"<?php if( $optionitems[$j]->optionitem_price > 0 ){ ?> title="<?php echo str_replace( '"', '&quot;', $optionitems[$j]->optionitem_name ); ?> +<?php echo $GLOBALS['currency']->get_currency_display( $optionitems[$j]->optionitem_price ); ?> <?php echo $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ); ?>"<?php }else if( $optionitems[$j]->optionitem_price < 0 ){ ?> title="<?php echo str_replace( '"', '&quot;', $optionitems[$j]->optionitem_name ); ?> <?php echo $GLOBALS['currency']->get_currency_display( $optionitems[$j]->optionitem_price ); ?> <?php echo $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ); ?>"<?php }else if( $optionitems[$j]->optionitem_price_onetime > 0 ){ ?> title="<?php echo str_replace( '"', '&quot;', $optionitems[$j]->optionitem_name ); ?> +<?php echo $GLOBALS['currency']->get_currency_display( $optionitems[$j]->optionitem_price_onetime ); ?> <?php echo $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ); ?>"<?php }else if( $optionitems[$j]->optionitem_price_onetime < 0 ){ ?> title="<?php echo str_replace( '"', '&quot;', $optionitems[$j]->optionitem_name ); ?> <?php echo $GLOBALS['currency']->get_currency_display( $optionitems[$j]->optionitem_price_onetime ); ?> <?php echo $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ); ?>"<?php }else if( isset( $optionitems[$j]->optionitem_price_override ) && $optionitems[$j]->optionitem_price_override > -1 ){ ?> title="<?php echo str_replace( '"', '&quot;', $optionitems[$j]->optionitem_name ); ?> <?php $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ); ?> <?php echo $GLOBALS['currency']->get_currency_display( $optionitems[$j]->optionitem_price_override ); ?>"<?php }else{ ?> title="<?php echo str_replace( '"', '&quot;', $optionitems[$j]->optionitem_name ); ?>"<?php }?>/></li>
				<?php
				}
				?>
			</ul>
		
		<?php
		
		/* START ADVANCED GRID TYPE */
		}else if( $optionset->option_type == "grid" ){
			$has_quantity_grid = true;
		?>
		
			<?php
			foreach( $optionitems as $optionitem ){
			
			if( $optionitem->optionitem_initial_value > 0 ){	
				if( $optionitem->optionitem_price >= 0 ){
					$add_price_grid = $add_price_grid + $optionitem->optionitem_price;
				
				}else if( $optionitem->optionitem_price_override >= 0 ){
					$override_price_grid = $optionitem->optionitem_price_override;
				
				}else if( $optionitem->optionitem_price_onetime > 0 ){
					$add_order_price_grid = $add_order_price_grid + $optionitem->optionitem_price_onetime;
				
				}
			}
			?>
				
				<div class="ec_details_grid_row"><span><?php echo $optionitem->optionitem_name; ?></span><input type="number" min="0" step="1" name="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $optionitem->optionitem_id; ?>" value="<?php echo number_format( $optionitem->optionitem_initial_value, 0, "", "" ); ?>" data-product-id="<?php echo $product->product_id; ?>" data-optionitem-price="<?php echo $optionitem->optionitem_price; ?>" data-optionitem-price-onetime="<?php echo $optionitem->optionitem_price_onetime; ?>" data-optionitem-price-override="<?php echo $optionitem->optionitem_price_override; ?>" data-optionitem-price-multiplier="<?php echo $optionitem->optionitem_price_multiplier; ?>" /><?php if( $optionitem->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitem->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitem->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $optionitem->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionitem->optionitem_price_override ) && $optionitem->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_override ) . ')'; } ?></div>
				
			<?php
			}
			?>
		
		<?php
		
		/* START ADVANCED RADIO TYPE */
		}else if( $optionset->option_type == "radio" ){
		?>
		
			<?php
			foreach( $optionitems as $optionitem ){
			?>
				
				<div class="ec_details_radio_row"><input type="radio" name="ec_option_<?php echo $optionset->option_id; ?>" value="<?php echo $optionitem->optionitem_id; ?>" data-product-id="<?php echo $product->product_id; ?>" data-optionitem-price="<?php echo $optionitem->optionitem_price; ?>" data-optionitem-price-onetime="<?php echo $optionitem->optionitem_price_onetime; ?>" data-optionitem-price-override="<?php echo $optionitem->optionitem_price_override; ?>" data-optionitem-price-multiplier="<?php echo $optionitem->optionitem_price_multiplier; ?>"<?php if( $optionitem->optionitem_initially_selected ){ ?> checked="checked"<?php }?> /> <?php echo $optionitem->optionitem_name; ?><?php if( $optionitem->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitem->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitem->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $optionitem->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionitem->optionitem_price_override ) && $optionitem->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitem->optionitem_price_override ) . ')'; } ?></div>
				
			<?php
			}
			?>
			
		<?php
		
		/* START ADVANCED TEXT TYPE */
		}else if( $optionset->option_type == "text" ){
		?>
		
			<input type="text" name="ec_option_<?php echo $optionset->option_id; ?>" id="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?>" data-product-id="<?php echo $product->product_id; ?>" data-optionitem-price="<?php echo $optionitems[0]->optionitem_price; ?>" data-optionitem-price-onetime="<?php echo $optionitems[0]->optionitem_price_onetime; ?>" data-optionitem-price-override="<?php echo $optionitems[0]->optionitem_price_override; ?>" data-optionitem-price-multiplier="<?php echo $optionitems[0]->optionitem_price_multiplier; ?>" data-optionitem-price-per-character="<?php echo $optionitems[0]->optionitem_price_per_character; ?>" /><?php if( $optionitems[0]->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionitems[0]->optionitem_price_override ) && $optionitems[0]->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_override ) . ')'; }else if( isset( $optionitems[0]->optionitem_price_per_character ) && $optionitems[0]->optionitem_price_per_character > 0 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_per_character ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment_per_character' ) . ')'; } ?>
		
		<?php
		
		/* START ADVANCED TEXT AREA TYPE */
		}else if( $optionset->option_type == "textarea" ){
		?>
		
			<textarea name="ec_option_<?php echo $optionset->option_id; ?>" id="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?>" data-product-id="<?php echo $product->product_id; ?>" data-optionitem-price="<?php echo $optionitems[0]->optionitem_price; ?>" data-optionitem-price-onetime="<?php echo $optionitems[0]->optionitem_price_onetime; ?>" data-optionitem-price-override="<?php echo $optionitems[0]->optionitem_price_override; ?>" data-optionitem-price-multiplier="<?php echo $optionitems[0]->optionitem_price_multiplier; ?>" data-optionitem-price-per-character="<?php echo $optionitems[0]->optionitem_price_per_character; ?>"></textarea><?php if( $optionitems[0]->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionitems[0]->optionitem_price_override ) && $optionitems[0]->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_override ) . ')'; }else if( isset( $optionitems[0]->optionitem_price_per_character ) && $optionitems[0]->optionitem_price_per_character > 0 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_per_character ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment_per_character' ) . ')'; } ?>
		
		<?php
		
		/* START ADVANCED DIMENSIONS TYPE */
		}else if( $optionset->option_type == "dimensions1" || $optionset->option_type == "dimensions2" ){
			
			// Type 1 is NO sub dimensions (34")
			// Type 2 USES sub dimensions (34 1/2")
			
			$type = 2;
			
			if( $optionitems[0]->optionitem_name == "DimensionType1" )
				$type = 1;
		?>
		
			<input type="text" name="ec_option_<?php echo $optionset->option_id; ?>_width" id="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?>_width" data-product-id="<?php echo $product->product_id; ?>" data-optionitem-price="<?php echo $optionitems[0]->optionitem_price; ?>" data-optionitem-price-onetime="<?php echo $optionitems[0]->optionitem_price_onetime; ?>" data-optionitem-price-override="<?php echo $optionitems[0]->optionitem_price_override; ?>" data-optionitem-price-multiplier="<?php echo $optionitems[0]->optionitem_price_multiplier; ?>" data-optionitem-price-per-character="<?php echo $optionitems[0]->optionitem_price_per_character; ?>" class="ec_dimensions_box ec_dimensions_width" data-option-id="<?php echo $optionset->option_id; ?>" /><?php if( $optionitems[0]->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionitems[0]->optionitem_price_override ) && $optionitems[0]->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_override ) . ')'; }else if( isset( $optionitems[0]->optionitem_price_per_character ) && $optionitems[0]->optionitem_price_per_character > 0 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_per_character ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment_per_character' ) . ')'; } ?>
			
			<?php if( $type == 2 ){ ?>
			<select name="ec_option_<?php echo $optionset->option_id; ?>_sub_width" id="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?>_sub_width" class="ec_dimensions_select">
				<option value="0">0</option>
				<option value="1/16">1/16</option>
				<option value="1/8">1/8</option>
				<option value="3/16">3/16</option>
				<option value="1/4">1/4</option>
				<option value="5/16">5/16</option>
				<option value="3/8">3/8</option>
				<option value="7/16">7/16</option>
				<option value="1/2">1/2</option>
				<option value="9/16">9/16</option>
				<option value="5/8">5/8</option>
				<option value="11/16">11/16</option>
				<option value="3/4">3/4</option>
				<option value="13/16">13/16</option>
				<option value="7/8">7/8</option>
				<option value="15/16">15/16</option>
			</select>
			<?php }?>
			
			<span class="ec_dimensions_seperator">x</span>
			
			<input type="text" name="ec_option_<?php echo $optionset->option_id; ?>_height" id="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?>_height" data-product-id="<?php echo $product->product_id; ?>" data-optionitem-price="<?php echo $optionitems[0]->optionitem_price; ?>" data-optionitem-price-onetime="<?php echo $optionitems[0]->optionitem_price_onetime; ?>" data-optionitem-price-override="<?php echo $optionitems[0]->optionitem_price_override; ?>" data-optionitem-price-multiplier="<?php echo $optionitems[0]->optionitem_price_multiplier; ?>" data-optionitem-price-per-character="<?php echo $optionitems[0]->optionitem_price_per_character; ?>" class="ec_dimensions_box" /><?php if( $optionitems[0]->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $optionitems[0]->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( isset( $optionitems[0]->optionitem_price_override ) && $optionitems[0]->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_override ) . ')'; }else if( isset( $optionitems[0]->optionitem_price_per_character ) && $optionitems[0]->optionitem_price_per_character > 0 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ' ' . $GLOBALS['currency']->get_currency_display( $optionitems[0]->optionitem_price_per_character ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment_per_character' ) . ')'; } ?>
			
			<?php if( $type == 2 ){ ?>
			<select name="ec_option_<?php echo $optionset->option_id; ?>_sub_height" id="ec_option_<?php echo $optionset->option_id; ?>_<?php echo $product->product_id; ?>_sub_height" class="ec_dimensions_select">
				<option value="0">0</option>
				<option value="1/16">1/16</option>
				<option value="1/8">1/8</option>
				<option value="3/16">3/16</option>
				<option value="1/4">1/4</option>
				<option value="5/16">5/16</option>
				<option value="3/8">3/8</option>
				<option value="7/16">7/16</option>
				<option value="1/2">1/2</option>
				<option value="9/16">9/16</option>
				<option value="5/8">5/8</option>
				<option value="11/16">11/16</option>
				<option value="3/4">3/4</option>
				<option value="13/16">13/16</option>
				<option value="7/8">7/8</option>
				<option value="15/16">15/16</option>
			</select>
			<?php }?>
		
		<?php
		}
	?>
		</div>
	</div>				
	<?php
	}
	?>
</div>
<?php }?>
<?php /* END ADVANCED OPTIONS*/ ?>

<?php /* GIFT CARD OPTIONS */ ?>
<?php if( $product->is_giftcard ){ ?>
<div class="ec_details_options">
	<div class="ec_details_option_row_error ec_giftcard_error" id="ec_details_giftcard_error_<?php echo $product->product_id; ?>"><?php echo $GLOBALS['language']->get_text( 'ec_errors', 'missing_gift_card_options' ); ?></div>
	<div class="ec_details_option_row">
		<div class="ec_details_option_label"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_recipient_name' ); ?></div>
		<div class="ec_details_option_data"><input type="text" name="ec_giftcard_to_name" id="ec_giftcard_to_name_<?php echo $product->product_id; ?>" value="" /></div>
	</div>

	<div class="ec_details_option_row">
		<div class="ec_details_option_label"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_recipient_email' ); ?></div>
		<div class="ec_details_option_data"><input type="text" name="ec_giftcard_to_email" id="ec_giftcard_to_email_<?php echo $product->product_id; ?>" value="" /></div>
	</div>

	<div class="ec_details_option_row">
		<div class="ec_details_option_label"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_sender_name' ); ?></div>
		<div class="ec_details_option_data"><input type="text" name="ec_giftcard_from_name" id="ec_giftcard_from_name_<?php echo $product->product_id; ?>" value="" /></div>
	</div>

	<div class="ec_details_option_row">
		<div class="ec_details_option_label"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_message' ); ?></div>
		<div class="ec_details_option_data"><textarea name="ec_giftcard_message" id="ec_giftcard_message_<?php echo $product->product_id; ?>"></textarea></div>
	</div>
</div>
<?php }?>
<?php /* END GIFT CARD OPTIONS */ ?>

<?php /* DONATION OPTIONS */ ?>
<?php if( $product->is_donation ){ ?>
<div class="ec_details_options">
	<div class="ec_details_option_row_error ec_donation_error" id="ec_details_donation_error_<?php echo $product->product_id; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_donation_error' ) . " " . $GLOBALS['currency']->get_currency_display( $product->price ); ?>.</div>
	<div class="ec_details_option_row">
		<div class="ec_details_option_label"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_donation_amount' ); ?></div>
		<div class="ec_details_option_data"><input type="number" step=".01" min="<?php echo $GLOBALS['currency']->get_number_only( $product->price ); ?>" name="ec_donation_amount" id="ec_donation_amount_<?php echo $product->product_id; ?>" value="<?php echo $GLOBALS['currency']->get_number_only( $product->price ); ?>" /></div>
	</div>
</div>
<?php } ?>
<?php /* END DONATION OPTIONS */ ?>

<?php /* PRODUCT ADD TO CART */ ?>
<div class="ec_details_option_row_error" id="ec_addtocart_quantity_exceeded_error_<?php echo $product->product_id; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_maximum_quantity' ); ?></div>
<div class="ec_details_option_row_error" id="ec_addtocart_quantity_minimum_error_<?php echo $product->product_id; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_minimum_quantity_text1' ); ?> <?php echo $product->min_purchase_quantity; ?> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_minimum_quantity_text2' ); ?></div>
<div class="ec_details_option_row_error" id="ec_addtocart_quantity_maximum_error_<?php echo $product->product_id; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_maximum_quantity_text1' ); ?> <?php echo $product->max_purchase_quantity; ?> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_maximum_quantity_text2' ); ?></div>

<?php

do_action( 'wp_easycart_product_details_pre_add_to_cart' );

$show_add_to_cart_area = true;
$show_add_to_cart_area = apply_filters( 'wp_easycart_product_details_show_cart_area', $show_add_to_cart_area );

if( $show_add_to_cart_area ){
?>
<div class="ec_details_add_to_cart_area">
	
	<?php /* CATALOG MODE */ ?>
	<?php if( get_option( 'ec_option_display_as_catalog' ) ){
	// Show nothing
	
	}else if( $product->is_catalog_mode ){ ?>
	<div class="ec_details_seasonal_mode"><?php echo $product->catalog_mode_phrase; ?></div>	
	
	<?php /* INQUIRY BUTTON */ ?>
	<?php }else if( $product->is_inquiry_mode ){ ?>
	<div class="ec_details_add_to_cart">
		<input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_inquire' ); ?>" <?php if( $product->inquiry_url == "" ){ ?>onclick="return ec_details_show_inquiry_form( '<?php echo $product->product_id; ?>' );" <?php }?>style="margin-left:0px !important;" />
	</div>
	
	<?php /* DecoNetwork BUTTON */ ?>
	<?php }else if( $product->is_deconetwork ){ ?>
	<?php if( get_option( 'ec_option_deconetwork_allow_blank_products' ) ){ // Custom option to have both add to cart and design now ?>
		
	<div class="ec_details_quantity"<?php if( $has_quantity_grid ){ ?> style="display:none;"<?php }?>><input type="button" value="-" class="ec_minus" onclick="ec_minus_quantity( '<?php echo $product->product_id; ?>', <?php echo $product->min_purchase_quantity; ?> );" /><input type="number" value="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>" name="ec_quantity" id="ec_quantity_<?php echo $product->product_id; ?>" autocomplete="off" step="1" min="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>" class="ec_quantity"<?php if( $product->show_stock_quantity || $product->max_purchase_quantity > 0 ){ ?> max="<?php if( $product->max_purchase_quantity > 0 ){ echo $product->max_purchase_quantity; }else{ echo $product->stock_quantity; } ?>"<?php }?> /><input type="button" value="+" class="ec_plus" onclick="ec_plus_quantity( '<?php echo $product->product_id; ?>', <?php echo $product->show_stock_quantity; ?>, <?php if( $product->max_purchase_quantity > 0 ){ echo $product->max_purchase_quantity; }else{ echo $product->stock_quantity; } ?> );" /></div>
	<div class="ec_details_add_to_cart ec_deconetwork_custom_space">
		<input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_add_to_cart' ); ?>" onclick="return ec_details_add_to_cart_<?php echo $product->product_id; ?>( );"<?php if( $has_quantity_grid ){ ?> style="margin-left:0px !important;"<?php }?> />
	</div>
		
	<?php }?>
	
	<div class="ec_details_add_to_cart">
		<a href="<?php echo $product->get_deconetwork_link( ); ?>" style="margin-left:0px !important;"><?php echo $GLOBALS['language']->get_text( 'product_page', 'product_design_now' ); ?></a>
	</div>
	
	<?php /* SUBSCRIPTION BUTTON */ ?>
	<?php }else if( $product->is_subscription_item ){ ?>
	
	<?php if( !get_option( 'ec_option_subscription_one_only' ) ){ ?>
	<div class="ec_details_quantity"<?php if( $has_quantity_grid ){ ?> style="display:none;"<?php }?>><input type="button" value="-" class="ec_minus" onclick="ec_minus_quantity( '<?php echo $product->product_id; ?>', <?php echo $product->min_purchase_quantity; ?> );" /><input type="number" value="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>" name="ec_quantity" id="ec_quantity_<?php echo $product->product_id; ?>" autocomplete="off" step="1" min="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>" class="ec_quantity"<?php if( $product->show_stock_quantity || $product->max_purchase_quantity > 0 ){ ?> max="<?php if( $product->max_purchase_quantity > 0 ){ echo $product->max_purchase_quantity; }else{ echo $product->stock_quantity; } ?>"<?php }?> /><input type="button" value="+" class="ec_plus" onclick="ec_plus_quantity( '<?php echo $product->product_id; ?>', <?php echo $product->show_stock_quantity; ?>, <?php if( $product->max_purchase_quantity > 0 ){ echo $product->max_purchase_quantity; }else if( $product->show_stock_quantity ){ echo $product->stock_quantity; }else{ echo "10000000"; } ?> );" /></div>
	<?php }?>
	
	<div class="ec_details_add_to_cart">
		<input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_sign_up_now' ); ?>" onclick="return ec_details_add_to_cart_<?php echo $product->product_id; ?>( );"<?php if( get_option( 'ec_option_subscription_one_only' ) ){ ?> style="margin-left:0px !important;"<?php }?> />
	</div>
	
	<?php /* REGULAR BUTTON + QUANTITY */ ?>
	<?php }else if( $product->in_stock( ) ){ ?>
	<div class="ec_details_quantity"<?php if( $has_quantity_grid ){ ?> style="display:none;"<?php }?>><input type="button" value="-" class="ec_minus" onclick="ec_minus_quantity( '<?php echo $product->product_id; ?>', <?php echo $product->min_purchase_quantity; ?> );" /><input type="number" value="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>" name="ec_quantity" id="ec_quantity_<?php echo $product->product_id; ?>" autocomplete="off" step="1" min="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>" class="ec_quantity"<?php if( $product->show_stock_quantity || $product->max_purchase_quantity > 0 ){ ?> max="<?php if( $product->max_purchase_quantity > 0 ){ echo $product->max_purchase_quantity; }else{ echo $product->stock_quantity; } ?>"<?php }?> /><input type="button" value="+" class="ec_plus" onclick="ec_plus_quantity( '<?php echo $product->product_id; ?>', <?php echo $product->show_stock_quantity; ?>, <?php if( $product->max_purchase_quantity > 0 ){ echo $product->max_purchase_quantity; }else if( $product->show_stock_quantity ){ echo $product->stock_quantity; }else{ echo "10000000"; } ?> );" /></div>
	<div class="ec_details_add_to_cart">
		<input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_add_to_cart' ); ?>" onclick="return ec_details_add_to_cart_<?php echo $product->product_id; ?>( );"<?php if( $has_quantity_grid ){ ?> style="margin-left:0px !important;"<?php }?> />
	</div>
	
	<?php /* PRICING AREA FOR OPTIONS */ ?>
	<?php if( $product->has_options || $product->use_advanced_optionset ){ ?>
	<div class="ec_details_final_price"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_your_price' ); ?> <span id="ec_final_price_<?php echo $product->product_id; ?>"><?php if( $override_price_grid > -1 ){ echo $GLOBALS['currency']->get_currency_display( $override_price_grid ); }else if( $add_price_grid > 0 ){ echo $GLOBALS['currency']->get_currency_display( $product->price + $add_price_grid ); }else{ echo $GLOBALS['currency']->get_currency_display( $product->price ); } ?></span></div>
	<?php } ?>
	<span class="ec_details_hidden_base_price" id="ec_base_price_<?php echo $product->product_id; ?>"><?php echo $product->price; ?></span>
	
	 <?php /* OUT OF STOCK BUT BACKORDERS ALLOWED */ ?>
	<?php }else if( $product->allow_backorders ){ ?>
	<div class="ec_details_quantity"<?php if( $has_quantity_grid ){ ?> style="display:none;"<?php }?>><input type="button" value="-" class="ec_minus" onclick="ec_minus_quantity( '<?php echo $product->product_id; ?>', <?php echo $product->min_purchase_quantity; ?> );" /><input type="number" value="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>" name="ec_quantity" id="ec_quantity_<?php echo $product->product_id; ?>" autocomplete="off" step="1" min="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>" class="ec_quantity"<?php if( $product->max_purchase_quantity > 0 ){ ?> max="<?php echo $product->max_purchase_quantity; ?>"<?php }?> /><input type="button" value="+" class="ec_plus" onclick="ec_plus_quantity( '<?php echo $product->product_id; ?>', <?php echo $product->show_stock_quantity; ?>, <?php if( $product->max_purchase_quantity > 0 ){ echo $product->max_purchase_quantity; }else{ echo 100000000; } ?> );" /></div>
	<div class="ec_details_add_to_cart">
		<input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_backorder_button' ); ?>" onclick="return ec_details_add_to_cart_<?php echo $product->product_id; ?>( );"<?php if( $has_quantity_grid ){ ?> style="margin-left:0px !important;"<?php }?> />
	</div>
	
	<?php /* PRICING AREA FOR OPTIONS */ ?>
	<?php if( $product->has_options || $product->use_advanced_optionset ){ ?>
	<div class="ec_details_final_price"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_your_price' ); ?> <span id="ec_final_price_<?php echo $product->product_id; ?>"><?php if( $override_price_grid > -1 ){ echo $GLOBALS['currency']->get_currency_display( $override_price_grid ); }else if( $add_price_grid > 0 ){ echo $GLOBALS['currency']->get_currency_display( $product->price + $add_price_grid ); }else{ echo $GLOBALS['currency']->get_currency_display( $product->price ); } ?></span></div>
	<?php } ?>
	<span class="ec_details_hidden_base_price" id="ec_base_price_<?php echo $product->product_id; ?>"><?php echo $product->price; ?></span>
	
	<?php /* OUT OF STOCK INFO (NO ADD TO CART CASE) */ ?>
	<?php }else{ ?>
	<div class="ec_out_of_stock"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_out_of_stock' ); ?></div>
	<?php }?>
</div>
<?php } //END FILTER FOR HIDING ADD TO CART ?>

<?php if( !$product->in_stock( ) && $product->allow_backorders ){ ?>
<div class="ec_details_backorder_info" id="ec_back_order_info_<?php echo $product->product_id; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_out_of_stock' ); ?><?php if( $product->backorder_fill_date != "" ){ ?> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_backorder_until' ); ?> <?php echo $product->backorder_fill_date; ?><?php }?></div>
<?php }?>

<?php /* END ADD TO CART */ ?>
</form>
<script>var img = new Image( );
var img_width = 400;
var img_height = 400;
var img_ratio = 1;
var tier_quantities = [<?php if( !$product->using_role_price ){ for( $tier_i = 0; $tier_i < count( $product->pricetiers ); $tier_i++ ){ if( $tier_i > 0 ){ echo ","; } echo $product->pricetiers[$tier_i][1]; } } ?>];
var tier_prices = [<?php if( !$product->using_role_price ){ for( $tier_i = 0; $tier_i < count( $product->pricetiers ); $tier_i++ ){ if( $tier_i > 0 ){ echo ","; } echo $product->pricetiers[$tier_i][0]; } } ?>];<?php if( !$ipad && !$iphone && get_option( 'ec_option_show_magnification' ) ){?>
jQuery( '.ec_details_main_image_<?php echo $product->product_id; ?>' ).mousemove( function( e ){
	var parentOffset = jQuery( this ).parent( ).offset( ); 
	var mouse_x = e.pageX - parentOffset.left;
	var mouse_y = e.pageY - parentOffset.top;
	var div_width = jQuery( this ).width( );
	var div_height = jQuery( this ).height( );
	var x_val = '-' + ( ( img_width - div_width ) * ( mouse_x / div_width ) ) + 'px';
	var y_val = '-' + ( ( img_height - div_height ) * ( mouse_y / div_height ) ) + 'px';
	jQuery( '.ec_details_magbox_image_<?php echo $product->product_id; ?>' ).css( 'background-position', x_val + ' ' + y_val );	
} );
jQuery( '.ec_details_main_image_<?php echo $product->product_id; ?>' ).hover( 
	function( ){ 
		img = new Image( );
		img.onload = function( ){
			img_width = this.width;
			img_height = this.height;
			img_ratio =  img_height / img_width;
			jQuery( '.ec_details_magbox' ).css( 'width', jQuery( '.ec_details_main_image_<?php echo $product->product_id; ?>' ).width( ) + 'px' ).css( 'height', jQuery( '.ec_details_main_image_<?php echo $product->product_id; ?>' ).height( ) + 'px' );
			jQuery( '.ec_details_magbox_image_<?php echo $product->product_id; ?>' ).css( 'width', jQuery( '.ec_details_main_image_<?php echo $product->product_id; ?>' ).width( ) + 'px' ).css( 'height', jQuery( '.ec_details_main_image_<?php echo $product->product_id; ?>' ).height( ) + 'px' );
		}
		img.src = jQuery( this ).find( 'img' ).attr( 'src' );
		jQuery( '.ec_details_magbox_<?php echo $product->product_id; ?>' ).fadeIn( 'fast' ); 
	}, 
	function( ){ 
		jQuery( '.ec_details_magbox_<?php echo $product->product_id; ?>' ).fadeOut( 'fast' ); 
	} 
);<?php }?>
jQuery( '.ec_details_thumbnail_<?php echo $product->product_id; ?>' ).click( function( e ){ 
	var src = jQuery( this ).find( 'img' ).attr( 'src' );
	jQuery( '.ec_details_thumbnail_<?php echo $product->product_id; ?>' ).removeClass( 'ec_active' );
	jQuery( this ).addClass( 'ec_active' );
	jQuery( '.ec_details_main_image_<?php echo $product->product_id; ?>' ).find( 'img' ).attr( 'src', src );
	jQuery( '.ec_details_large_popup_main_<?php echo $product->product_id; ?>' ).find( 'img' ).attr( 'src', src );
	jQuery( '.ec_details_magbox_image_<?php echo $product->product_id; ?>' ).css( 'background', 'url( "' + src + '" ) no-repeat' );
});
jQuery( '.ec_details_large_popup_thumbnail_<?php echo $product->product_id; ?>' ).click( function( e ){
	var src = jQuery( this ).find( 'img' ).attr( 'src' );
	jQuery( '.ec_details_large_popup_thumbnail_<?php echo $product->product_id; ?>' ).removeClass( 'ec_active' );
	jQuery( this ).addClass( 'ec_active' );
	jQuery( '.ec_details_thumbnail_<?php echo $product->product_id; ?>' ).removeClass( 'ec_active' );
	jQuery( '.ec_details_main_image_<?php echo $product->product_id; ?>' ).find( 'img' ).attr( 'src', src );
	jQuery( '.ec_details_large_popup_main_<?php echo $product->product_id; ?>' ).find( 'img' ).attr( 'src', src );
	jQuery( '.ec_details_magbox_image_<?php echo $product->product_id; ?>' ).css( 'background', 'url( "' + src + '" ) no-repeat' );
});
jQuery( '.ec_minus' ).click( function( ){
	<?php if( $product->use_advanced_optionset ){ ?>ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );<?php }else{ ?>ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );<?php }?>
} );
jQuery( '.ec_plus' ).click( function( ){
	<?php if( $product->use_advanced_optionset ){ ?>ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );<?php }else{ ?>ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );<?php }?>
} );
jQuery( document.getElementById( 'ec_quantity_<?php echo $product->product_id; ?>' ) ).change( function( ){
	<?php if( $product->use_advanced_optionset ){ ?>ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );<?php }else{ ?>ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );<?php }?>
} );
jQuery( document.getElementById( 'ec_donation_amount_<?php echo $product->product_id; ?>' ) ).change( function( ){
	<?php if( $product->use_advanced_optionset ){ ?>ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );<?php }else{ ?>ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );<?php }?>
} );
jQuery( '.ec_details_tab_<?php echo $product->product_id; ?>' ).click( function( ){
	jQuery( '.ec_details_tab_<?php echo $product->product_id; ?>' ).removeClass( 'ec_active' );
	jQuery( this ).addClass( 'ec_active' );
	jQuery( '.ec_details_extra_area_<?php echo $product->product_id; ?>' ).children( 'div' ).each( function( ){ jQuery( this ).hide( ) } );
	if( jQuery( this ).hasClass( 'ec_description' ) )
		jQuery( '.ec_details_description_tab_<?php echo $product->product_id; ?>' ).show( );
	else if( jQuery( this ).hasClass( 'ec_specifications' ) )
		jQuery( '.ec_details_specifications_tab_<?php echo $product->product_id; ?>' ).show( );
	else if( jQuery( this ).hasClass( 'ec_customer_reviews' ) )
		jQuery( '.ec_details_customer_reviews_tab_<?php echo $product->product_id; ?>' ).show( );
	else
		jQuery( '.ec_details_' + jQuery( this ).attr( 'data-tab-id' ) + '_tab' ).show( );
} );
jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>' ).click( function( ){
	if( jQuery( this ).hasClass( 'ec_active' ) ){
		var optionitem_id_1 = jQuery( this ).attr( 'data-optionitem-id' );
		var quantity = jQuery( this ).attr( 'data-optionitem-quantity' );
		<?php if( $product->use_optionitem_quantity_tracking ){ ?>
		ec_option1_selected_<?php echo $product->product_id; ?>( optionitem_id_1, quantity );
		<?php }?>
		ec_option1_image_change_<?php echo $product->product_id; ?>( optionitem_id_1, quantity );
		jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' );
		jQuery( this ).addClass( 'ec_selected' );
		jQuery( '.ec_option1_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
		jQuery( document.getElementById( 'ec_option1_<?php echo $product->product_id; ?>' ) ).val( optionitem_id_1 );
		ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );
	}
} );
jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>' ).click( function( ){
	if( jQuery( this ).hasClass( 'ec_active' ) ){
		var optionitem_id_1 = 0;
		if( jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).length ){
			optionitem_id_1 = jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
		}else{
			optionitem_id_1 = jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?>' ).val( );
		}
		var optionitem_id_2 = jQuery( this ).attr( 'data-optionitem-id' );
		<?php if( $product->use_optionitem_quantity_tracking ){ ?>
		var quantity = jQuery( this ).attr( 'data-optionitem-quantity' );
		option2_selected_<?php echo $product->product_id; ?>( optionitem_id_1, optionitem_id_2, quantity );
		<?php }?>
		jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' );
		jQuery( this ).addClass( 'ec_selected' );
		jQuery( '.ec_option2_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
		jQuery( document.getElementById( 'ec_option2_<?php echo $product->product_id; ?>' ) ).val( optionitem_id_2 );
		ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );
	}
} );
jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>' ).click( function( ){
	if( jQuery( this ).hasClass( 'ec_active' ) ){
		var optionitem_id_1 = 0;
		if( jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).length ){
			optionitem_id_1 = jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
		}else{
			optionitem_id_1 = jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?>' ).val( );
		}
		var optionitem_id_2 = 0;
		if( jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).length ){
			optionitem_id_2 = jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
		}else{
			optionitem_id_2 = jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?>' ).val( );
		}
		var optionitem_id_3 = jQuery( this ).attr( 'data-optionitem-id' );
		<?php if( $product->use_optionitem_quantity_tracking ){ ?>
		var quantity = jQuery( this ).attr( 'data-optionitem-quantity' );
		option3_selected_<?php echo $product->product_id; ?>( optionitem_id_1, optionitem_id_2, optionitem_id_3, quantity );
		<?php }?>
		jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' );
		jQuery( this ).addClass( 'ec_selected' );
		jQuery( '.ec_option3_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
		jQuery( document.getElementById( 'ec_option3_<?php echo $product->product_id; ?>' ) ).val( optionitem_id_3 );
		ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );
	}
} );
jQuery( '.ec_details_swatches > li.ec_option4_<?php echo $product->product_id; ?>' ).click( function( ){
	if( jQuery( this ).hasClass( 'ec_active' ) ){
		var optionitem_id_1 = 0;
		if( jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).length ){
			optionitem_id_1 = jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
		}else{
			optionitem_id_1 = jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?>' ).val( );
		}
		var optionitem_id_2 = 0;
		if( jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).length ){
			optionitem_id_2 = jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
		}else{
			optionitem_id_2 = jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?>' ).val( );
		}
		var optionitem_id_3 = 0;
		if( jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>.ec_selected' ).length ){
			optionitem_id_3 = jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
		}else{
			optionitem_id_3 = jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?>' ).val( );
		}
		var optionitem_id_4 = jQuery( this ).attr( 'data-optionitem-id' );
		<?php if( $product->use_optionitem_quantity_tracking ){ ?>
		var quantity = jQuery( this ).attr( 'data-optionitem-quantity' );
		option4_selected_<?php echo $product->product_id; ?>( optionitem_id_1, optionitem_id_2, optionitem_id_3, optionitem_id_4, quantity );
		<?php }?>
		jQuery( '.ec_details_swatches > li.ec_option4_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' );
		jQuery( this ).addClass( 'ec_selected' );
		jQuery( '.ec_option4_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
		jQuery( document.getElementById( 'ec_option4_<?php echo $product->product_id; ?>' ) ).val( optionitem_id_4 );
		ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );
	}
} );
jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>' ).click( function( ){
	if( jQuery( this ).hasClass( 'ec_active' ) ){
		var optionitem_id_5 = jQuery( this ).attr( 'data-optionitem-id' );
		jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' );
		jQuery( this ).addClass( 'ec_selected' );
		jQuery( '.ec_option5_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
		jQuery( document.getElementById( 'ec_option5_<?php echo $product->product_id; ?>' ) ).val( optionitem_id_5 );
		ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );
	}
} );
jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?>' ).change( function( ){
	var optionitem_id_1 = jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?>' ).val( );
	var quantity = jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-quantity' );
	<?php if( $product->use_optionitem_quantity_tracking ){ ?>
	if( optionitem_id_1 != '0' ){
		ec_option1_selected_<?php echo $product->product_id; ?>( optionitem_id_1, quantity );
	}else{
		jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
		jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
		jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
		jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
		jQuery( document.getElementById( 'ec_details_stock_quantity_<?php echo $product->product_id; ?>' ) ).html( quantity );	
	}
	<?php }?>
	ec_option1_image_change_<?php echo $product->product_id; ?>( optionitem_id_1, quantity );
	jQuery( '.ec_option1_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
	ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?>' ).change( function( ){
	<?php if( $product->use_optionitem_quantity_tracking ){ ?>
	var optionitem_id_1 = 0;
	if( jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).length ){
		optionitem_id_1 = jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
	}else{
		optionitem_id_1 = jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?>' ).val( );
	}
	var optionitem_id_2 = jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?>' ).val( );
	var quantity = jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-quantity' );
	if( optionitem_id_2 != '0' ){
		option2_selected_<?php echo $product->product_id; ?>( optionitem_id_1, optionitem_id_2, quantity );
	}else{
		jQuery( document.getElementById( 'ec_details_stock_quantity_<?php echo $product->product_id; ?>' ) ).html( quantity );	
	}
	<?php }?>
	jQuery( '.ec_option2_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
	ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?>' ).change( function( ){
	<?php if( $product->use_optionitem_quantity_tracking ){ ?>
	var optionitem_id_1 = 0;
	if( jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).length ){
		optionitem_id_1 = jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
	}else{
		optionitem_id_1 = jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?>' ).val( );
	}
	var optionitem_id_2 = 0;
	if( jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).length ){
		optionitem_id_2 = jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
	}else{
		optionitem_id_2 = jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?>' ).val( );
	}
	var optionitem_id_3 = jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?>' ).val( );
	var quantity = jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-quantity' );
	
	if( optionitem_id_3 != '0' ){
		option3_selected_<?php echo $product->product_id; ?>( optionitem_id_1, optionitem_id_2, optionitem_id_3, quantity );
	}else{
		jQuery( document.getElementById( 'ec_details_stock_quantity_<?php echo $product->product_id; ?>' ) ).html( quantity );	
	}
	<?php }?>
	jQuery( '.ec_option3_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
	ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?>' ).change( function( ){
	<?php if( $product->use_optionitem_quantity_tracking ){ ?>
	var optionitem_id_1 = 0;
	if( jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).length ){
		optionitem_id_1 = jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
	}else{
		optionitem_id_1 = jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?>' ).val( );
	}
	var optionitem_id_2 = 0;
	if( jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).length ){
		optionitem_id_2 = jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
	}else{
		optionitem_id_2 = jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?>' ).val( );
	}
	var optionitem_id_3 = 0;
	if( jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>.ec_selected' ).length ){
		optionitem_id_3 = jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' );
	}else{
		optionitem_id_3 = jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?>' ).val( );
	}
	var optionitem_id_4 = jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?>' ).val( );
	var quantity = jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-quantity' );
	
	if( optionitem_id_4 != '0' ){
		option4_selected_<?php echo $product->product_id; ?>( optionitem_id_1, optionitem_id_2, optionitem_id_3, optionitem_id_4, quantity );
	}else{
		jQuery( document.getElementById( 'ec_details_stock_quantity_<?php echo $product->product_id; ?>' ) ).html( quantity );	
	}
	<?php }?>
	jQuery( '.ec_option4_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
	ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?>' ).change( function( ){
	<?php if( $product->use_optionitem_quantity_tracking ){ ?>
	var quantity = jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-quantity' );
	jQuery( document.getElementById( 'ec_details_stock_quantity_<?php echo $product->product_id; ?>' ) ).html( quantity );
	<?php }?>
	jQuery( '.ec_option5_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
	ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_checkbox_row > input, .ec_details_radio_row > input' ).click( function( ){
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_option_row.ec_option_type_combo > .ec_details_option_data > select' ).change( function( ){
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_option_row.ec_option_type_date > .ec_details_option_data > input' ).change( function( ){
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_option_row.ec_option_type_file > .ec_details_option_data > input' ).change( function( ){
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_option_row.ec_option_type_text > .ec_details_option_data > input' ).change( function( ){
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_option_row.ec_option_type_textarea > .ec_details_option_data > textarea' ).change( function( ){
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_grid_row > input' ).change( function( ){
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_swatches > li.ec_advanced' ).click( function( ){
	var optionitem_id = jQuery( this ).attr( 'data-optionitem-id' );
	var option_id = jQuery( this ).attr( 'data-option-id' );
	var product_id = '<?php echo $product->product_id; ?>';
	jQuery( document.getElementById( 'ec_option_' + option_id + "_" + product_id ) ).val( optionitem_id );
	jQuery( '.ec_details_swatches > li.ec_option_' + option_id + "_" + product_id ).removeClass( 'ec_selected' );
	jQuery( this ).addClass( 'ec_selected' );
	jQuery( document.getElementById( 'ec_details_option_row_error_' + option_id + "_" + product_id ) ).hide( );
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_option_row.ec_option_type_dimensions1 > .ec_details_option_data > input' ).change( function( ){
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_option_row.ec_option_type_dimensions2 > .ec_details_option_data > input' ).change( function( ){
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( '.ec_details_option_row.ec_option_type_dimensions2 > .ec_details_option_data > select' ).change( function( ){
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
jQuery( document ).ready( function( ){
	ec_details_base_adjust_price_<?php echo $product->product_id; ?>( );
	ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( );
} );
function ec_details_base_adjust_price_<?php echo $product->product_id; ?>( ){
	if( jQuery( document.getElementById( 'ec_base_price_<?php echo $product->product_id; ?>' ) ).length == 0 )
		return;
	var base_price = Number( jQuery( document.getElementById( 'ec_base_price_<?php echo $product->product_id; ?>' ) ).html( ) );
	var option1_price_adj = 0;
	var option2_price_adj = 0;
	var option3_price_adj = 0;
	var option4_price_adj = 0;
	var option5_price_adj = 0;
	var option1_price_add = 0;
	var option2_price_add = 0;
	var option3_price_add = 0;
	var option4_price_add = 0;
	var option5_price_add = 0;
	var option1_price_override = -1;
	var option2_price_override = -1;
	var option3_price_override = -1;
	var option4_price_override = -1;
	var option5_price_override = -1;
	// Option 1 Price Adjustment
	if( jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).length ){
		option1_price_adj = jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price' );
		option1_price_add = jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-onetime' );
		option1_price_override = Number( jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-override' ) );
		option1_price_multiplier = Number( jQuery( '.ec_details_swatches > li.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-multiplier' ) );
	}else if( jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?>' ).length ){
		option1_price_adj = jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price' );
		option1_price_add = jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-onetime' );
		option1_price_override = Number( jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-override' ) );
		option1_price_multiplier = Number( jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-multiplier' ) );
	}
	// Option 2 Price Adjustment
	if( jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).length ){
		option2_price_adj = jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price' );
		option2_price_add = jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-onetime' );
		option2_price_override = Number( jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-override' ) );
		option2_price_multiplier = Number( jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-multiplier' ) );
	}else if( jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?>' ).length ){
		option2_price_adj = jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price' );
		option2_price_add = jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-onetime' );
		option2_price_override = Number( jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-override' ) );
		option2_price_multiplier = Number( jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-multiplier' ) );
	}
	// Option 3 Price Adjustment
	if( jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>.ec_selected' ).length ){
		option3_price_adj = jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price' );
		option3_price_add = jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-onetime' );
		option3_price_override = Number( jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-override' ) );
		option3_price_multiplier = Number( jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-multiplier' ) );
	}else if( jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?>' ).length ){
		option3_price_adj = jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price' );
		option3_price_add = jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-onetime' );
		option3_price_override = Number( jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-override' ) );
		option3_price_multiplier = Number( jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-multiplier' ) );
	}
	// Option 4 Price Adjustment
	if( jQuery( '.ec_details_swatches > li.ec_option4_<?php echo $product->product_id; ?>.ec_selected' ).length ){
		option4_price_adj = jQuery( '.ec_details_swatches > li.ec_option4_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price' );
		option4_price_add = jQuery( '.ec_details_swatches > li.ec_option4_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-onetime' );
		option4_price_override = Number( jQuery( '.ec_details_swatches > li.ec_option4_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-override' ) );
		option4_price_multiplier = Number( jQuery( '.ec_details_swatches > li.ec_option4_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-multiplier' ) );
	}else if( jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?>' ).length ){
		option4_price_adj = jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price' );
		option4_price_add = jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-onetime' );
		option4_price_override = Number( jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-override' ) );
		option4_price_multiplier = Number( jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-multiplier' ) );
	}
	// Option 5 Price Adjustment
	if( jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>.ec_selected' ).length ){
		option5_price_adj = jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price' );
		option5_price_add = jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-onetime' );
		option5_price_override = Number( jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-override' ) );
		option5_price_multiplier = Number( jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-price-multiplier' ) );
	}else if( jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?>' ).length ){
		option5_price_adj = jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price' );
		option5_price_add = jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-onetime' );
		option5_price_override = Number( jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-override' ) );
		option5_price_multiplier = Number( jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?> option:selected' ).attr( 'data-optionitem-price-multiplier' ) );
	}
	var num_decimals = <?php echo $GLOBALS['currency']->get_decimal_length( ); ?>;
	var decimal_symbol = '<?php echo $GLOBALS['currency']->get_decimal_symbol( ); ?>';
	var grouping_symbol = '<?php echo $GLOBALS['currency']->get_grouping_symbol( ); ?>';
	var new_price = base_price + Number( option1_price_adj ) + Number( option2_price_adj ) + Number( option3_price_adj ) + Number( option4_price_adj ) + Number( option5_price_adj );
	var order_price = Number( option1_price_add ) + Number( option2_price_add ) + Number( option3_price_add ) + Number( option4_price_add ) + Number( option5_price_add );
	var override_price = -1;
	if( option1_price_override > -1 )
		override_price = option1_price_override;
	else if( option2_price_override > -1 )
		override_price = option2_price_override;
	else if( option3_price_override > -1 )
		override_price = option3_price_override;
	else if( option4_price_override > -1 )
		override_price = option4_price_override;
	else if( option5_price_override > -1 )
		override_price = option5_price_override; 
	if( override_price > -1 ){
		jQuery( document.getElementById( 'ec_final_price_<?php echo $product->product_id; ?>' ) ).html( ec_details_format_money( override_price ) );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price ) ); } );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price ) ); } );
		<?php if( isset( $vat_row ) && $vat_row->vat_added ){?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price * <?php echo $vat_rate_multiplier; ?> ) ); } );
	<?php }else{?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price / <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price ) ); } );
	<?php }?>}else{
		jQuery( document.getElementById( 'ec_final_price_<?php echo $product->product_id; ?>' ) ).html( ec_details_format_money( new_price ) );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price ) ); } );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price ) ); } );
		<?php if( isset( $vat_row ) && $vat_row->vat_added ){?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * <?php echo $vat_rate_multiplier; ?> ) ); } );
	<?php }else{?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price / <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price ) ); } );
	<?php }?>}
	if( order_price != 0 ){
		jQuery( '.ec_details_added_price_<?php echo $product->product_id; ?>' ).show( );
		jQuery( document.getElementById( 'ec_added_price_<?php echo $product->product_id; ?>' ) ).html( ec_details_format_money( order_price ) );
	}else{
		jQuery( '.ec_details_added_price_<?php echo $product->product_id; ?>' ).hide( );
	}
}
function ec_details_advanced_adjust_price_<?php echo $product->product_id; ?>( ){	
	if( jQuery( document.getElementById( 'ec_base_price_<?php echo $product->product_id; ?>' ) ).length == 0 )
		return;
	var base_price = Number( jQuery( document.getElementById( 'ec_base_price_<?php echo $product->product_id; ?>' ) ).html( ) );
	// Get a quantity in case we need to use in calculating price
	var current_quantity = 1;
	if( jQuery( document.getElementById( 'ec_quantity_<?php echo $product->product_id; ?>' ) ).length > 0 ){
		current_quantity = jQuery( document.getElementById( 'ec_quantity_<?php echo $product->product_id; ?>' ) ).val( );
	}
	
	if( jQuery( '.ec_details_grid_row > input' ).length > 0 ){
		current_quantity = 0;
		jQuery( '.ec_details_grid_row > input' ).each( function( ){
			current_quantity = current_quantity + Number( jQuery( this ).val( ) );
		} );
	}
	for( var i=0; i<tier_quantities.length; i++ ){
		if( tier_quantities[i] <= current_quantity )
			base_price = Number( tier_prices[i] );
	}
	var override_price = -1;
	var price_multiplier = 0;
	// Checkbox Price Adjustments
	var checkbox_adj = 0;
	var checkbox_add = 0;
	// Combox Price Adjustments
	var combo_adj = 0;
	var combo_add = 0;
	// Date Price Adjustments
	var date_adj = 0;
	var date_add = 0;
	// File Price Adjustments
	var file_adj = 0;
	var file_add = 0;
	// Swatch Price Adjustments
	var swatch_adj = 0;
	var swatch_add = 0;
	// Grid Price Adjustments
	var grid_adj = 0;
	var grid_add = 0;
	// Radio Price Adjustments
	var radio_adj = 0;
	var radio_add = 0;
	// Text Price Adjustments
	var text_adj = 0;
	var text_add = 0;
	// Textarea Price Adjustments
	var textarea_adj = 0;
	var textarea_add = 0;
	// Dimensions Price Adjustments
	var has_sq_footage = false;
	var sq_footage = 1;
	jQuery( '.ec_details_checkbox_row > input:checked' ).each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price' ) != 0 ){
			checkbox_adj += Number( jQuery( this ).attr( 'data-optionitem-price' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-onetime' ) != 0 ){
			checkbox_add += Number( jQuery( this ).attr( 'data-optionitem-price-onetime' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-override' ) >= 0 ){
			override_price = Number( jQuery( this ).attr( 'data-optionitem-price-override' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-multiplier' ) > 0 ){
			price_multiplier = Number( jQuery( this ).attr( 'data-optionitem-price-multiplier' ) );
		}
	} );
	jQuery( '.ec_details_option_row.ec_option_type_combo > .ec_details_option_data > select option:selected' ).each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price' ) != 0 ){
			combo_adj += Number( jQuery( this ).attr( 'data-optionitem-price' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-onetime' ) != 0 ){
			combo_add += Number( jQuery( this ).attr( 'data-optionitem-price-onetime' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-override' ) >= 0 ){
			override_price = Number( jQuery( this ).attr( 'data-optionitem-price-override' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-multiplier' ) > 0 ){
			price_multiplier = Number( jQuery( this ).attr( 'data-optionitem-price-multiplier' ) );
		}
	} );
	jQuery( '.ec_details_option_row.ec_option_type_date > .ec_details_option_data > input' ).each( function( ){
		if( jQuery( this ).val( ) != "" ){
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price' ) != 0 ){
				date_adj += Number( jQuery( this ).attr( 'data-optionitem-price' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-onetime' ) != 0 ){
				date_add += Number( jQuery( this ).attr( 'data-optionitem-price-onetime' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-override' ) >= 0 ){
				override_price = Number( jQuery( this ).attr( 'data-optionitem-price-override' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-multiplier' ) > 0 ){
				price_multiplier = Number( jQuery( this ).attr( 'data-optionitem-price-multiplier' ) );
			}
		}
	} );
	jQuery( '.ec_details_option_row.ec_option_type_file > .ec_details_option_data > input' ).each( function( ){
		if( jQuery( this ).val( ) != "" ){
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price' ) != 0 ){
				file_adj += Number( jQuery( this ).attr( 'data-optionitem-price' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-onetime' ) != 0 ){
				file_add += Number( jQuery( this ).attr( 'data-optionitem-price-onetime' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-override' ) >= 0 ){
				override_price = Number( jQuery( this ).attr( 'data-optionitem-price-override' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-multiplier' ) > 0 ){
				price_multiplier = Number( jQuery( this ).attr( 'data-optionitem-price-multiplier' ) );
			}
		}
	} );
	jQuery( '.ec_details_swatch.ec_advanced.ec_selected' ).each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price' ) != 0 ){
			swatch_adj += Number( jQuery( this ).attr( 'data-optionitem-price' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-onetime' ) != 0 ){
			swatch_add += Number( jQuery( this ).attr( 'data-optionitem-price-onetime' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-override' ) >= 0 ){
			override_price = Number( jQuery( this ).attr( 'data-optionitem-price-override' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-multiplier' ) > 0 ){
			price_multiplier = Number( jQuery( this ).attr( 'data-optionitem-price-multiplier' ) );
		}
	} );
	jQuery( '.ec_details_radio_row > input:checked' ).each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price' ) != 0 ){
			radio_adj += Number( jQuery( this ).attr( 'data-optionitem-price' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-onetime' ) != 0 ){
			radio_add += Number( jQuery( this ).attr( 'data-optionitem-price-onetime' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-override' ) >= 0 ){
			override_price = Number( jQuery( this ).attr( 'data-optionitem-price-override' ) );
		}
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-multiplier' ) > 0 ){
			price_multiplier = Number( jQuery( this ).attr( 'data-optionitem-price-multiplier' ) );
		}
	} );
	jQuery( '.ec_details_option_row.ec_option_type_text > .ec_details_option_data > input' ).each( function( ){
		if( jQuery( this ).val( ) != "" ){
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price' ) != 0 ){
				text_adj += Number( jQuery( this ).attr( 'data-optionitem-price' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-onetime' ) != 0 ){
				text_add += Number( jQuery( this ).attr( 'data-optionitem-price-onetime' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-override' ) >= 0 ){
				override_price = Number( jQuery( this ).attr( 'data-optionitem-price-override' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-multiplier' ) > 0 ){
				price_multiplier = Number( jQuery( this ).attr( 'data-optionitem-price-multiplier' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-per-character' ) > 0 ){
				var num_characters = Number(  jQuery( this ).val( ).replace( / /g, '' ).length );
				var price_per_char = Number( jQuery( this ).attr( 'data-optionitem-price-per-character' ) );
				text_adj = text_adj + ( num_characters * price_per_char );
			}
		}
	} );
	jQuery( '.ec_details_option_row.ec_option_type_textarea > .ec_details_option_data > textarea' ).each( function( ){
		if( jQuery( this ).val( ) != "" ){
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price' ) != 0 ){
				textarea_adj += Number( jQuery( this ).attr( 'data-optionitem-price' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-onetime' ) != 0 ){
				textarea_add += Number( jQuery( this ).attr( 'data-optionitem-price-onetime' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-override' ) >= 0 ){
				override_price = Number( jQuery( this ).attr( 'data-optionitem-price-override' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-multiplier' ) > 0 ){
				price_multiplier = Number( jQuery( this ).attr( 'data-optionitem-price-multiplier' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-per-character' ) > 0 ){
				var num_characters = Number(  jQuery( this ).val( ).replace( / /g, '' ).length );
				var price_per_char = Number( jQuery( this ).attr( 'data-optionitem-price-per-character' ) );
				textarea_adj = textarea_adj + ( num_characters * price_per_char );
			}
		}
	} );
	jQuery( '.ec_details_grid_row > input' ).each( function( ){
		if( jQuery( this ).val( ) > 0 ){
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price' ) != 0 ){
				grid_adj += ( Number( jQuery( this ).attr( 'data-optionitem-price' ) ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-onetime' ) != 0 ){
				grid_add += Number( jQuery( this ).attr( 'data-optionitem-price-onetime' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-override' ) >= 0 ){
				override_price = Number( jQuery( this ).attr( 'data-optionitem-price-override' ) );
			}
			if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-optionitem-price-multiplier' ) > 0 ){
				price_multiplier = Number( jQuery( this ).attr( 'data-optionitem-price-multiplier' ) );
			}
		}
	} );
	jQuery( '.ec_dimensions_width' ).each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' ){
			has_sq_footage = true;
			var option_id = jQuery( this ).attr( 'data-option-id' );
			var product_id = '<?php echo $product->product_id; ?>';
			var width = jQuery( document.getElementById( 'ec_option_' + option_id + '_' + product_id + '_width' ) ).val( );
			var sub_width = 0;
			if( jQuery( document.getElementById( 'ec_option_' + option_id + '_' + product_id + '_sub_width' ) ).length )
				var sub_width = jQuery( document.getElementById( 'ec_option_' + option_id + '_' + product_id + '_sub_width' ) ).val( );
			var height = jQuery( document.getElementById( 'ec_option_' + option_id + '_' + product_id + '_height' ) ).val( );
			var sub_height = 0;
			if( jQuery( document.getElementById( 'ec_option_' + option_id + '_' + product_id + '_sub_height' ) ).length )
				var sub_height = jQuery( document.getElementById( 'ec_option_' + option_id + '_' + product_id + '_sub_height' ) ).val( );
			if( width != "" && height != "" )
				sq_footage = ec_details_get_sq_footage_<?php echo $product->product_id; ?>( width, sub_width, height, sub_height ) * Number( jQuery( document.getElementById( 'ec_quantity_<?php echo $product->product_id; ?>' ) ).val( ) );	
		}
	} );
	var new_price = ( base_price + Number( checkbox_adj ) + Number( combo_adj ) + Number( date_adj ) + Number( file_adj ) + Number( swatch_adj ) + Number( grid_adj ) + Number( radio_adj ) + Number( text_adj ) + Number( textarea_adj ) );
	var new_price_sqft = new_price * sq_footage;
	var override_price_final = override_price + Number( checkbox_adj ) + Number( combo_adj ) + Number( date_adj ) + Number( file_adj ) + Number( swatch_adj ) + Number( grid_adj ) + Number( radio_adj ) + Number( text_adj ) + Number( textarea_adj );
	var override_price_sqft = override_price_final * sq_footage;
	var order_price = Number( checkbox_add ) + Number( combo_add ) + Number( date_add ) + Number( file_add ) + Number( swatch_add ) + Number( grid_add ) + Number( radio_add ) + Number( text_add ) + Number( textarea_add );
	if( override_price > -1 ){
		jQuery( document.getElementById( 'ec_final_price_<?php echo $product->product_id; ?>' ) ).html( ec_details_format_money( override_price_sqft ) );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final ) ); } );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final ) ); } );
		<?php if( isset( $vat_row ) && $vat_row->vat_added ){?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * <?php echo $vat_rate_multiplier; ?> ) ); } );
	<?php }else{ ?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final / <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final ) ); } );
		jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final / <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final ) ); } );
	<?php }?>}else{
		jQuery( document.getElementById( 'ec_final_price_<?php echo $product->product_id; ?>' ) ).html( ec_details_format_money( new_price_sqft ) );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price ) ); } );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price ) ); } );
		<?php if( isset( $vat_row ) && $vat_row->vat_added ){?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * <?php echo $vat_rate_multiplier; ?> ) ); } );
	<?php }else{ ?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price / <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price ) ); } );
		jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price / <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price ) ); } );
	<?php }?>}
	if( price_multiplier > 1 && override_price > -1 ){
		jQuery( document.getElementById( 'ec_final_price_<?php echo $product->product_id; ?>' ) ).html( ec_details_format_money( override_price_sqft * Number( price_multiplier ) ) );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * Number( price_multiplier ) ) ); } );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * Number( price_multiplier ) ) ); } );
		<?php if( isset( $vat_row ) && $vat_row->vat_added ){?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * Number( price_multiplier ) ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * Number( price_multiplier ) * <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * Number( price_multiplier ) ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * Number( price_multiplier ) * <?php echo $vat_rate_multiplier; ?> ) ); } );
	<?php }else{ ?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * Number( price_multiplier ) / <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * Number( price_multiplier ) ) ); } );
		jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * Number( price_multiplier ) / <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( override_price_final * Number( price_multiplier ) ) ); } );
	<?php }?>}else if( price_multiplier > 1 ){
		jQuery( document.getElementById( 'ec_final_price_<?php echo $product->product_id; ?>' ) ).html( ec_details_format_money( new_price * Number( price_multiplier ) ) );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * Number( price_multiplier ) ) ); } );
		jQuery( '.ec_details_price.ec_details_single_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * Number( price_multiplier ) ) ); } );
		<?php if( isset( $vat_row ) && $vat_row->vat_added ){?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * Number( price_multiplier ) ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * Number( price_multiplier ) * <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * Number( price_multiplier ) ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * Number( price_multiplier ) * <?php echo $vat_rate_multiplier; ?> ) ); } );
	<?php }else{ ?>jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * Number( price_multiplier ) / <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_sale_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * Number( price_multiplier ) ) ); } );
		jQuery( '.ec_details_price.ec_details_no_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * Number( price_multiplier ) / <?php echo $vat_rate_multiplier; ?> ) ); } );
		jQuery( '.ec_details_price.ec_details_vat_price > .ec_product_price_<?php echo $product->product_id; ?>' ).each( function( ){ jQuery( this ).html( ec_details_format_money( new_price * Number( price_multiplier ) ) ); } );
	<?php }?>}
	if( order_price != 0 ){
		jQuery( '.ec_details_added_price_<?php echo $product->product_id; ?>' ).show( );
		jQuery( document.getElementById( 'ec_added_price_<?php echo $product->product_id; ?>' ) ).html( ec_details_format_money( order_price ) );
	}else{
		jQuery( '.ec_details_added_price_<?php echo $product->product_id; ?>' ).hide( );
	}
}
function ec_details_get_sq_footage_<?php echo $product->product_id; ?>( width, sub_width, height, sub_height ){
	var sub_width_decimal = ec_details_get_sub_dimension_decimal_<?php echo $product->product_id; ?>( sub_width );
	width = Number( Number( width ) + sub_width_decimal ) / <?php if( !get_option( 'ec_option_enable_metric_unit_display' ) ){ echo "12"; }else{ echo "1000"; } ?>;
	var sub_height_decimal = ec_details_get_sub_dimension_decimal_<?php echo $product->product_id; ?>( sub_height );
	height = Number( Number( height ) + sub_height_decimal ) / <?php if( !get_option( 'ec_option_enable_metric_unit_display' ) ){ echo "12"; }else{ echo "1000"; } ?>;
	return width*height;
}
function ec_details_get_sub_dimension_decimal_<?php echo $product->product_id; ?>( sub_dimension ){
	if( sub_dimension == "0" ){
		return 0;
	}else if( sub_dimension == "1/16" ){
		return .0625;
	}else if( sub_dimension == "1/8" ){
		return .1250;
	}else if( sub_dimension == "3/16" ){
		return .1875;
	}else if( sub_dimension == "1/4" ){
		return .2500;
	}else if( sub_dimension == "5/16" ){
		return .3125;
	}else if( sub_dimension == "3/8" ){
		return .3750;
	}else if( sub_dimension == "7/16" ){
		return .4375;
	}else if( sub_dimension == "1/2" ){
		return .5000;
	}else if( sub_dimension == "9/16" ){
		return .5625;
	}else if( sub_dimension == "5/8" ){
		return .6250;
	}else if( sub_dimension == "11/16" ){
		return .6875;
	}else if( sub_dimension == "3/4" ){
		return .7500;
	}else if( sub_dimension == "13/16" ){
		return .8125;
	}else if( sub_dimension == "7/8" ){
		return .8750;
	}else if( sub_dimension == "15/16" ){
		return .9375;
	}else{
		return 0;
	}
}
function ec_details_format_money( price, num_decimals, grouping_symbol, decimal_symbol ){
	var currency_symbol = '<?php echo $GLOBALS['currency']->get_symbol( ); ?>';
	var num_decimals = <?php echo $GLOBALS['currency']->get_decimal_length( ); ?>;
	var decimal_symbol = '<?php echo $GLOBALS['currency']->get_decimal_symbol( ); ?>';
	var grouping_symbol = '<?php echo $GLOBALS['currency']->get_grouping_symbol( ); ?>';
	var conversion_rate = '<?php echo $GLOBALS['currency']->get_conversion_rate( ); ?>';
	var symbol_location = <?php echo $GLOBALS['currency']->get_symbol_location( ); ?>;
	var currency_code = '<?php echo $GLOBALS['currency']->get_currency_code( ); ?>';
	var show_currency_code = '<?php echo $GLOBALS['currency']->get_show_currency_code( ); ?>';
	price = ec_pricing_round( price * Number( conversion_rate ), num_decimals );
	var n = price,
        num_decimals = isNaN(num_decimals = Math.abs(num_decimals)) ? 2 : num_decimals,
        decimal_symbol = decimal_symbol == undefined ? "." : decimal_symbol,
        grouping_symbol = grouping_symbol == undefined ? "," : grouping_symbol,
        i = parseInt(n = price.toFixed( num_decimals ) ) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    var formatted = (j ? i.substr(0, j) + grouping_symbol : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + grouping_symbol) + (num_decimals ? decimal_symbol + Math.abs(n - i).toFixed(num_decimals).slice(2) : "");
	if( symbol_location ){
		formatted = currency_symbol + formatted;
	}else{
		formatted = formatted + currency_symbol;
	}
	if( show_currency_code == '1' ){
		formatted = currency_code + ' ' +  formatted;
	}
	return formatted;
};
function ec_pricing_round(number, places) {
    var multiplier = Math.pow(10, places+2); // get two extra digits
    var fixed = Math.floor(number*multiplier); // convert to integer
    fixed += 50; // round down on anything less than x.xxx50
    fixed = Math.floor(fixed/100); // chop off last 2 digits
    return fixed/Math.pow(10, places);
}
function ec_details_submit_inquiry_<?php echo $product->product_id; ?>( ){
	var errors = 0;
	if( document.getElementById( 'ec_inquiry_name_<?php echo $product->product_id; ?>' ) ){
		if( jQuery( document.getElementById( 'ec_inquiry_name_<?php echo $product->product_id; ?>' ) ).val( ) == "" || jQuery( document.getElementById( 'ec_inquiry_email_<?php echo $product->product_id; ?>' ) ).val( ) == "" || jQuery( document.getElementById( 'ec_inquiry_message_<?php echo $product->product_id; ?>' ) ).val( ) == "" ){
			jQuery( document.getElementById( 'ec_details_inquiry_error_<?php echo $product->product_id; ?>' ) ).show( );
			errors++;
		}else{
			jQuery( document.getElementById( 'ec_details_inquiry_error_<?php echo $product->product_id; ?>' ) ).hide( );
		}
	}
	if( errors > 0 )
		return false;
	else{
		jQuery( document.getElementById( 'ec_inquiry_loader_<?php echo $product->product_id; ?>' ) ).show( );
		jQuery( document.getElementById( 'ec_inquiry_loader_bg_<?php echo $product->product_id; ?>' ) ).show( );
		return true;
	}
}
function ec_details_add_to_cart_<?php echo $product->product_id; ?>( ){
	var errors = 0; 
	// Basic Option 1 Error Check
	if( jQuery( '.ec_details_swatch.ec_option1_<?php echo $product->product_id; ?>' ).length && !jQuery( '.ec_option1_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' ) ){ 
		jQuery( '.ec_option1_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).show( ); 
		errors++; 
	}else if( jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?>' ).length && jQuery( '.ec_details_combo.ec_option1_<?php echo $product->product_id; ?>' ).val( ) == '0' ){ 
		jQuery( '.ec_option1_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).show( ); 
		errors++; 
	}else{ 
		jQuery( '.ec_option1_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
	}
	// Basic Option 2 Error Check
	if( jQuery( '.ec_details_swatch.ec_option2_<?php echo $product->product_id; ?>' ).length && !jQuery( '.ec_option2_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' ) ){ 
		jQuery( '.ec_option2_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).show( ); 
		errors++; 
	}else if( jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?>' ).length && jQuery( '.ec_details_combo.ec_option2.ec_option2_<?php echo $product->product_id; ?>' ).val( ) == '0' ){ 
		jQuery( '.ec_option2_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).show( ); 
		errors++; 
	}else{ 
		jQuery( '.ec_option2_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( ); 
	}
	// Basic Option 3 Error Check
	if( jQuery( '.ec_details_swatch.ec_option3_<?php echo $product->product_id; ?>' ).length && !jQuery( '.ec_option3_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' ) ){ 
		jQuery( '.ec_option3_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).show( );
		errors++; 
	}else if( jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?>' ).length && jQuery( '.ec_details_combo.ec_option3.ec_option3_<?php echo $product->product_id; ?>' ).val( ) == '0' ){ 
		jQuery( '.ec_option3_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).show( ); 
		errors++; 
	}else{ 
		jQuery( '.ec_option3_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( ); 
	}
	// Basic Option 4 Error Check
	if( jQuery( '.ec_details_swatch.ec_option4_<?php echo $product->product_id; ?>' ).length && !jQuery( '.ec_option4_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' ) ){ 
		jQuery( '.ec_option4_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).show( ); 
		errors++; 
	}else if( jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?>' ).length && jQuery( '.ec_details_combo.ec_option4.ec_option4_<?php echo $product->product_id; ?>' ).val( ) == '0' ){ 
		jQuery( '.ec_option4_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).show( ); 
		errors++; 
	}else{ 
		jQuery( '.ec_option4_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( ); 
	}
	// Basic Option 5 Error Check
	if( jQuery( '.ec_details_swatch.ec_option5_<?php echo $product->product_id; ?>' ).length && !jQuery( '.ec_option5_<?php echo $product->product_id; ?>.ec_selected' ).attr( 'data-optionitem-id' ) ){ 
		jQuery( '.ec_option5_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).show( ); 
		errors++; 
	}else if( jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?>' ).length && jQuery( '.ec_details_combo.ec_option5.ec_option5_<?php echo $product->product_id; ?>' ).val( ) == '0' ){ 
		jQuery( '.ec_option5_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).show( ); 
		errors++; 
	}else{ 
		jQuery( '.ec_option5_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( ); 
	}
	// --------Advanced Option Checks---------- //
	// Select Box Check
	var advanced_select_rows = jQuery( '.ec_details_option_row.ec_option_type_combo' );
	advanced_select_rows.each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-option-required' ) == '1' ){ // Option is Required
			if( jQuery( document.getElementById( 'ec_option_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).val( ) == '0' ){
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).show( );
				errors++;
			}else{
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).hide( );
			}
		}
	} );
	// Check Box Check
	var advanced_checkbox_rows = jQuery( '.ec_details_option_row.ec_option_type_checkbox' );
	advanced_checkbox_rows.each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-option-required' ) == '1' ){ // Option is Required
			var selected_checkboxes = jQuery( "input.ec_option_" + jQuery( this ).attr( 'data-option-id' ) + ":checked" );
			if( selected_checkboxes.length ){
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).hide( );
			}else{
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).show( );
				errors++;
			}
		}
	} );
	// Date Box Check
	var advanced_date_rows = jQuery( '.ec_details_option_row.ec_option_type_date' );
	advanced_date_rows.each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-option-required' ) == '1' ){ // Option is Required
			if( jQuery( document.getElementById( 'ec_option_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).val( ) == "" ){
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).show( );
				errors++;
			}else{
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).hide( );
			}
		}
	} );
	// File Upload Check
	var advanced_file_rows = jQuery( '.ec_details_option_row.ec_option_type_file' );
	advanced_file_rows.each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-option-required' ) == '1' ){ // Option is Required	
			if( jQuery( document.getElementById( 'ec_option_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).val( ) ){
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).hide( );
			}else{
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).show( );
				errors++;
			}
		}
	} );
	// Swatch Check
	var advanced_swatch_rows = jQuery( '.ec_details_option_row.ec_option_type_swatch' );
	advanced_swatch_rows.each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-option-required' ) == '1' ){ // Option is Required
			var advanced_selected_swatches = jQuery( ".ec_details_swatch.ec_option_" + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' + ".ec_selected" );
			if( advanced_selected_swatches.length ){
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).hide( );
			}else{
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).show( );
				errors++;
			}
		}
	} );
	// Radio Button Check
	var advanced_radio_rows = jQuery( '.ec_details_option_row.ec_option_type_radio' );
	advanced_radio_rows.each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-option-required' ) == '1' ){ // Option is Required
			var selected_radios = jQuery( "input[name='ec_option_" + jQuery( this ).attr( 'data-option-id' ) + "']:checked" );
			if( selected_radios.length ){
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).hide( );
			}else{
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).show( );
				errors++;
			}
		}
	} );
	// Text Box Check
	var advanced_text_rows = jQuery( '.ec_details_option_row.ec_option_type_text' );
	advanced_text_rows.each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-option-required' ) == '1' ){ // Option is Required	
			if( jQuery( document.getElementById( 'ec_option_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).val( ) != "" ){
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).hide( );
			}else{
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).show( );
				errors++;
			}
		}
	} );
	// Text Area Check
	var advanced_textarea_rows = jQuery( '.ec_details_option_row.ec_option_type_textarea' );
	advanced_textarea_rows.each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-option-required' ) == '1' ){ // Option is Required	
			if( jQuery( document.getElementById( 'ec_option_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).val( ) != "" ){
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).hide( );
			}else{
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).show( );
				errors++;
			}
		}
	} );
	// Quantity Grid Check
	var advanced_grid_rows = jQuery( '.ec_details_option_row.ec_option_type_grid' );
	advanced_grid_rows.each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-option-required' ) == '1' ){ // Option is Required
			var grid_items = jQuery( ".ec_details_grid_row > input" );
			var total_grid_quantity = 0;
			grid_items.each( 
				function( ){ 
					total_grid_quantity += jQuery( this ).val( ); 
				} 
			);
			if( total_grid_quantity > 0 ){
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).hide( );
			}else{
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).show( );
				errors++;
			}
		}
	} );
	// Dimensions Type 1 Check
	var advanced_dimensions_rows = jQuery( '.ec_details_option_row.ec_option_type_dimensions1' );
	advanced_dimensions_rows.each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-option-required' ) == '1' ){ // Option is Required	
			// Test Width + Height
			if( jQuery( document.getElementById( 'ec_option_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' + '_width' ) ).val( ) != "" && jQuery( document.getElementById( 'ec_option_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' + '_height' ) ).val( ) != "" ){
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).hide( );
			}else{
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).show( );
				errors++;
			}
			
		}
	} );
	// Dimensions Type 2 Check
	var advanced_dimensions_rows = jQuery( '.ec_details_option_row.ec_option_type_dimensions2' );
	advanced_dimensions_rows.each( function( ){
		if( jQuery( this ).attr( 'data-product-id' ) == '<?php echo $product->product_id; ?>' && jQuery( this ).attr( 'data-option-required' ) == '1' ){ // Option is Required	
			// Test Width + Height
			if( jQuery( document.getElementById( 'ec_option_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' + '_width' ) ).val( ) != "" && jQuery( document.getElementById( 'ec_option_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' + '_height' ) ).val( ) != "" ){
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).hide( );
			}else{
				jQuery( document.getElementById( 'ec_details_option_row_error_' + jQuery( this ).attr( 'data-option-id' ) + '_<?php echo $product->product_id; ?>' ) ).show( );
				errors++;
			}
			
		}
	} );
	// -------END Advanced Option Checks------- //
	// -------START GIFT CARD CHECK ----------- //
	var gift_card_errors = 0;
	if( document.getElementById( 'ec_giftcard_to_name_<?php echo $product->product_id; ?>' ) && jQuery( document.getElementById( 'ec_giftcard_to_name_<?php echo $product->product_id; ?>' ) ).val( ) == "" ){
		errors++;
		gift_card_errors++;
	}
	if( document.getElementById( 'ec_giftcard_to_email_<?php echo $product->product_id; ?>' ) && jQuery( document.getElementById( 'ec_giftcard_to_email_<?php echo $product->product_id; ?>' ) ).val( ) == "" ){
		errors++;
		gift_card_errors++;
	}
	if( document.getElementById( 'ec_giftcard_from_name_<?php echo $product->product_id; ?>' ) && jQuery( document.getElementById( 'ec_giftcard_from_name_<?php echo $product->product_id; ?>' ) ).val( ) == "" ){
		errors++;
		gift_card_errors++;
	}
	if( document.getElementById( 'ec_giftcard_message_<?php echo $product->product_id; ?>' ) && jQuery( document.getElementById( 'ec_giftcard_message_<?php echo $product->product_id; ?>' ) ).val( ) == "" ){
		errors++;
		gift_card_errors++;
	}
	if( gift_card_errors ){
		jQuery( document.getElementById( 'ec_details_giftcard_error_<?php echo $product->product_id; ?>' ) ).show( );
	}else{
		jQuery( document.getElementById( 'ec_details_giftcard_error_<?php echo $product->product_id; ?>' ) ).hide( );
	}
	// -------END GIFT CARD CHECK   ----------- //
	// -------START DONATION CHECK  ----------- //
	if( document.getElementById( 'ec_donation_amount_<?php echo $product->product_id; ?>' ) ){
		if( isNaN( jQuery( document.getElementById( 'ec_donation_amount_<?php echo $product->product_id; ?>' ) ).val( ) ) || Number( jQuery( document.getElementById( 'ec_donation_amount_<?php echo $product->product_id; ?>' ) ).val( ) ) < <?php echo $GLOBALS['currency']->get_number_only( $product->price ); ?> ){
			jQuery( document.getElementById( 'ec_details_donation_error_<?php echo $product->product_id; ?>' ) ).show( );
			errors++;
		}else{
			jQuery( document.getElementById( 'ec_details_donation_error_<?php echo $product->product_id; ?>' ) ).hide( );
		}
	}
	// -------END DONATION CHECK    ----------- //
	// -------START INQUIRY CHECK  ----------- //
	if( document.getElementById( 'ec_inquiry_name' ) ){
		if( jQuery( document.getElementById( 'ec_inquiry_name' ) ).val( ) == "" || jQuery( document.getElementById( 'ec_inquiry_email' ) ).val( ) == "" || jQuery( document.getElementById( 'ec_inquiry_message' ) ).val( ) == "" ){
			jQuery( document.getElementById( 'ec_details_inquiry_error' ) ).show( );
			errors++;
		}else{
			jQuery( document.getElementById( 'ec_details_inquiry_error' ) ).hide( );
		}
	}
	// -------END INQUIRY CHECK    ----------- //
	// Stock Quantity Check
	var entered_quantity = Number( jQuery( document.getElementById( 'ec_quantity_<?php echo $product->product_id; ?>' ) ).val( ) );
	var allowed_quantity = 9999999999999;
	if( jQuery( document.getElementById( 'ec_details_stock_quantity' ) ).length ){
		allowed_quantity = Number( jQuery( document.getElementById( 'ec_details_stock_quantity' ) ).html( ) );
	}
	// Backorder Check
	if( allowed_quantity <= 0 && jQuery( document.getElementById( 'ec_back_order_info_<?php echo $product->product_id; ?>' ) ).length ){
		allowed_quantity = 1000000;
	}
	// Check Stock Quantity
	if( entered_quantity > allowed_quantity ){
		jQuery( document.getElementById( 'ec_addtocart_quantity_exceeded_error_<?php echo $product->product_id; ?>' ) ).show( );
		errors++;
	}else{
		jQuery( document.getElementById( 'ec_addtocart_quantity_exceeded_error_<?php echo $product->product_id; ?>' ) ).hide( );
	}
	// Minimum Quantity Check
	var min_quantity = <?php echo $product->min_purchase_quantity; ?>;
	if( entered_quantity < min_quantity ){
		jQuery( document.getElementById( 'ec_addtocart_quantity_minimum_error_<?php echo $product->product_id; ?>' ) ).show( );
		errors++;
	}else{
		jQuery( document.getElementById( 'ec_addtocart_quantity_minimum_error_<?php echo $product->product_id; ?>' ) ).hide( );
	}
	// Maximum Quantity Check
	var max_quantity = <?php echo $product->max_purchase_quantity; ?>;
	if( max_quantity > 0 && entered_quantity > max_quantity ){
		jQuery( document.getElementById( 'ec_addtocart_quantity_maximum_error_<?php echo $product->product_id; ?>' ) ).show( );
		errors++;
	}else{
		jQuery( document.getElementById( 'ec_addtocart_quantity_maximum_error_<?php echo $product->product_id; ?>' ) ).hide( );
	}
	if( errors > 0 )
		return false;
	else
		return true;
}
jQuery( '.ec_details_review_input_<?php echo $product->product_id; ?>' ).hover( function( ){	
	var score = jQuery( this ).attr( 'data-review-score' );
	jQuery( '.ec_details_review_input_<?php echo $product->product_id; ?>' ).removeClass( 'ec_product_details_star_on' ).addClass( 'ec_product_details_star_off' );
	for( var i=0; i<score; i++ ){
		jQuery( document.getElementById( 'ec_details_review_star' + (i+1) + '_<?php echo $product->product_id; ?>' ) ).removeClass( 'ec_product_details_star_off' ).addClass( 'ec_product_details_star_on' );
	}
} );
jQuery( '.ec_product_openclose' ).hide( );
function ec_option1_image_change_<?php echo $product->product_id; ?>( optionitem_id_1, quantity ){<?php if( $product->use_optionitem_images ){ ?>
	if( optionitem_id_1 != 0 ){
		jQuery( '.ec_details_thumbnails_<?php echo $product->product_id; ?>' ).hide( );
		jQuery( '.ec_details_large_popup_thumbnails_<?php echo $product->product_id; ?>' ).hide( );
		jQuery( document.getElementById( 'ec_details_thumbnails_' + optionitem_id_1 + '_<?php echo $product->product_id; ?>' ) ).find( '.ec_details_thumbnail' ).first( ).trigger( 'click' );
		if( !jQuery( document.getElementById( 'ec_details_thumbnails_' + optionitem_id_1 + '_<?php echo $product->product_id; ?>' ) ).hasClass( 'ec_no_thumbnails' ) ){
			jQuery( document.getElementById( 'ec_details_thumbnails_' + optionitem_id_1 + '_<?php echo $product->product_id; ?>' ) ).show( );
			if( document.getElementById( 'ec_details_large_popup_thumbnails_' + optionitem_id_1 + '_<?php echo $product->product_id; ?>' ) )
				document.getElementById( 'ec_details_large_popup_thumbnails_' + optionitem_id_1 + '_<?php echo $product->product_id; ?>' ).style.display = "inline-block";
		}
	}<?php }?>
}
function ec_option1_selected_<?php echo $product->product_id; ?>( optionitem_id_1, quantity ){<?php if( $product->use_optionitem_images ){ ?>
	jQuery( '.ec_details_thumbnails_<?php echo $product->product_id; ?>' ).hide( );
	jQuery( '.ec_details_large_popup_thumbnails_<?php echo $product->product_id; ?>' ).hide( );
	jQuery( document.getElementById( 'ec_details_thumbnails_' + optionitem_id_1 + '_<?php echo $product->product_id; ?>' ) ).find( '.ec_details_thumbnail' ).first( ).trigger( 'click' );
	if( !jQuery( document.getElementById( 'ec_details_thumbnails_' + optionitem_id_1 + '_<?php echo $product->product_id; ?>' ) ).hasClass( 'ec_no_thumbnails' ) ){
		jQuery( document.getElementById( 'ec_details_thumbnails_' + optionitem_id_1 + '_<?php echo $product->product_id; ?>' ) ).show( );
		jQuery( document.getElementById( 'ec_details_large_popup_thumbnails_' + optionitem_id_1 + '_<?php echo $product->product_id; ?>' ) ).show( );
	}<?php }?>
	jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' ).removeClass( 'ec_active' );
	jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' ).removeClass( 'ec_active' );
	jQuery( '.ec_details_swatches > li.ec_option4_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' ).removeClass( 'ec_active' );
	jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' ).removeClass( 'ec_active' );
	jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
	jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
	jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
	jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
	jQuery( document.getElementById( 'ec_details_stock_quantity_<?php echo $product->product_id; ?>' ) ).html( quantity );
	jQuery( document.getElementById( 'ec_option_loading_2_<?php echo $product->product_id; ?>' ) ).show( );
	var next_options = jQuery( '.ec_details_swatches > li.ec_option2_<?php echo $product->product_id; ?>' );
	if( next_options.length ){
		next_options.each( function( ){
			jQuery( this ).removeClass( 'ec_active' );
		} );
		var data = {
			action: 'ec_ajax_get_optionitem_quantities',
			optionitem_id_1: optionitem_id_1,
			product_id: '<?php echo $product->product_id; ?>'
		};
		jQuery.ajax( { url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ 
			var json_data = JSON.parse( data );
			jQuery( document.getElementById( 'ec_option_loading_2_<?php echo $product->product_id; ?>' ) ).hide( );
			var i=0;
			next_options.each( function( ){
				jQuery( this ).attr( 'data-optionitem-quantity', json_data[i].quantity );
				if( json_data[i].quantity > 0 ){
					jQuery( this ).addClass( 'ec_active' );
				}
				i++;
			} );
		} } );
	}else{
		next_options = jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?> option' );
		next_options.each( function( ){
			jQuery( this ).removeClass( 'ec_active' );
		} );
		var data = {
			action: 'ec_ajax_get_optionitem_quantities',
			optionitem_id_1: optionitem_id_1,
			product_id: '<?php echo $product->product_id; ?>'
		};
		jQuery.ajax( { url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ 
			jQuery( '.ec_details_combo.ec_option2_<?php echo $product->product_id; ?>' ).prop( 'disabled', false ).removeClass( 'ec_inactive' );
			var json_data = JSON.parse( data );
			jQuery( document.getElementById( 'ec_option_loading_2_<?php echo $product->product_id; ?>' ) ).hide( );
			var i=0;
			next_options.each( function( ){
				if( i > 0 ){
					jQuery( this ).attr( 'data-optionitem-quantity', json_data[i-1].quantity )
					if( json_data[i-1].quantity > 0 ){
						jQuery( this ).show( );
						jQuery( this ).prop( 'disabled', false );
					}else{
						jQuery( this ).hide( );
						jQuery( this ).prop( 'disabled', true );
					}
				}else{
					jQuery( this ).attr( 'data-optionitem-quantity', quantity );
				}
				i++;
			} );
		} } );
	}
}
function option2_selected_<?php echo $product->product_id; ?>( optionitem_id_1, optionitem_id_2, quantity ){	
	jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' ).removeClass( 'ec_active' );
	jQuery( '.ec_details_swatches > li.ec_option4_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' ).removeClass( 'ec_active' );
	jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' ).removeClass( 'ec_active' );
	jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
	jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
	jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
	jQuery( '.ec_option2_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
	jQuery( document.getElementById( 'ec_details_stock_quantity_<?php echo $product->product_id; ?>' ) ).html( quantity );
	var next_options = jQuery( '.ec_details_swatches > li.ec_option3_<?php echo $product->product_id; ?>' );
	jQuery( document.getElementById( 'ec_option_loading_3_<?php echo $product->product_id; ?>' ) ).show( );
	if( next_options.length ){
		next_options.each( function( ){
			jQuery( this ).removeClass( 'ec_active' );
		} );
		var data = {
			action: 'ec_ajax_get_optionitem_quantities',
			optionitem_id_1: optionitem_id_1,
			optionitem_id_2: optionitem_id_2,
			product_id: '<?php echo $product->product_id; ?>'
		};
		jQuery.ajax( { url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ 
			var json_data = JSON.parse( data );
			jQuery( document.getElementById( 'ec_option_loading_3_<?php echo $product->product_id; ?>' ) ).hide( );
			var i=0;
			next_options.each( function( ){
				jQuery( this ).attr( 'data-optionitem-quantity', json_data[i].quantity );
				if( json_data[i].quantity > 0 ){
					jQuery( this ).addClass( 'ec_active' );
				}
				i++;
			} );
		} } );
	}else{
		next_options = jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?> option' );
		next_options.each( function( ){
			jQuery( this ).removeClass( 'ec_active' );
		} );
		var data = {
			action: 'ec_ajax_get_optionitem_quantities',
			optionitem_id_1: optionitem_id_1,
			optionitem_id_2: optionitem_id_2,
			product_id: '<?php echo $product->product_id; ?>'
		};
		jQuery.ajax( { url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ 
			jQuery( '.ec_details_combo.ec_option3_<?php echo $product->product_id; ?>' ).prop( 'disabled', false ).removeClass( 'ec_inactive' );
			var json_data = JSON.parse( data );
			jQuery( document.getElementById( 'ec_option_loading_3_<?php echo $product->product_id; ?>' ) ).hide( );
			var i=0;
			next_options.each( function( ){
				if( i > 0 ){
					jQuery( this ).attr( 'data-optionitem-quantity', json_data[i-1].quantity );
					if( json_data[i-1].quantity > 0 ){
						jQuery( this ).show( );
						jQuery( this ).prop( 'disabled', false );
					}else{
						jQuery( this ).hide( );
						jQuery( this ).prop( 'disabled', true );
					}
				}else{
					jQuery( this ).attr( 'data-optionitem-quantity', quantity );
				}
				i++;
			} );
		} } );
	}
}
function option3_selected_<?php echo $product->product_id; ?>( optionitem_id_1, optionitem_id_2, optionitem_id_3, quantity ){	
	jQuery( '.ec_details_swatches > li.ec_option4_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' ).removeClass( 'ec_active' );
	jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' ).removeClass( 'ec_active' );
	jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
	jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
	jQuery( '.ec_option3_<?php echo $product->product_id; ?>.ec_details_option_row_error' ).hide( );
	jQuery( document.getElementById( 'ec_details_stock_quantity_<?php echo $product->product_id; ?>' ) ).html( quantity );
	var next_options = jQuery( '.ec_details_swatches > li.ec_option4_<?php echo $product->product_id; ?>' );
	jQuery( document.getElementById( 'ec_option_loading_4_<?php echo $product->product_id; ?>' ) ).show( );
	if( next_options.length ){
		next_options.each( function( ){
			jQuery( this ).removeClass( 'ec_active' );
		} );
		var data = {
			action: 'ec_ajax_get_optionitem_quantities',
			optionitem_id_1: optionitem_id_1,
			optionitem_id_2: optionitem_id_2,
			optionitem_id_3: optionitem_id_3,
			product_id: '<?php echo $product->product_id; ?>'
		};
		jQuery.ajax( { url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ 
			var json_data = JSON.parse( data );
			jQuery( document.getElementById( 'ec_option_loading_4_<?php echo $product->product_id; ?>' ) ).hide( );
			var i=0;
			next_options.each( function( ){
				jQuery( this ).attr( 'data-optionitem-quantity', json_data[i].quantity );
				if( json_data[i].quantity > 0 ){
					jQuery( this ).addClass( 'ec_active' );
				}
				i++;
			} );
		} } );
	}else{
		next_options = jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?> option' );
		next_options.each( function( ){
			jQuery( this ).removeClass( 'ec_active' );
		} );
		var data = {
			action: 'ec_ajax_get_optionitem_quantities',
			optionitem_id_1: optionitem_id_1,
			optionitem_id_2: optionitem_id_2,
			optionitem_id_3: optionitem_id_3,
			product_id: '<?php echo $product->product_id; ?>'
		};
		jQuery.ajax( { url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ 
			jQuery( '.ec_details_combo.ec_option4_<?php echo $product->product_id; ?>' ).prop( 'disabled', false ).removeClass( 'ec_inactive' );
			var json_data = JSON.parse( data );
			jQuery( document.getElementById( 'ec_option_loading_4_<?php echo $product->product_id; ?>' ) ).hide( );
			var i=0;
			next_options.each( function( ){
				if( i > 0 ){
					jQuery( this ).attr( 'data-optionitem-quantity', json_data[i-1].quantity );
					if( json_data[i-1].quantity > 0 ){
						jQuery( this ).show( );
						jQuery( this ).prop( 'disabled', false );
					}else{
						jQuery( this ).hide( );
						jQuery( this ).prop( 'disabled', true );
					}
				}else{
					jQuery( this ).attr( 'data-optionitem-quantity', quantity );
				}
				i++;
			} );
		} } );
	}
}
function option4_selected_<?php echo $product->product_id; ?>( optionitem_id_1, optionitem_id_2, optionitem_id_3, optionitem_id_4, quantity ){	
	jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>' ).removeClass( 'ec_selected' ).removeClass( 'ec_active' );
	jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?>' ).val( '0' ).prop( 'disabled', true ).addClass( 'ec_inactive' );
	jQuery( '.ec_option4.ec_details_option_row_error' ).hide( );
	jQuery( document.getElementById( 'ec_details_stock_quantity_<?php echo $product->product_id; ?>' ) ).html( quantity );
	var next_options = jQuery( '.ec_details_swatches > li.ec_option5_<?php echo $product->product_id; ?>' );
	jQuery( document.getElementById( 'ec_option_loading_5_<?php echo $product->product_id; ?>' ) ).show( );
	if( next_options.length ){
		next_options.each( function( ){
			jQuery( this ).removeClass( 'ec_active' );
		} );
		var data = {
			action: 'ec_ajax_get_optionitem_quantities',
			optionitem_id_1: optionitem_id_1,
			optionitem_id_2: optionitem_id_2,
			optionitem_id_3: optionitem_id_3,
			optionitem_id_4: optionitem_id_4,
			product_id: '<?php echo $product->product_id; ?>'
		};
		jQuery.ajax( { url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ 
			var json_data = JSON.parse( data );
			jQuery( document.getElementById( 'ec_option_loading_5_<?php echo $product->product_id; ?>' ) ).hide( );
			var i=0;
			next_options.each( function( ){
				jQuery( this ).attr( 'data-optionitem-quantity', json_data[i].quantity );
				if( json_data[i].quantity > 0 ){
					jQuery( this ).addClass( 'ec_active' );
				}
				i++;
			} );
		} } );
	}else{
		next_options = jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?> option' );
		next_options.each( function( ){
			jQuery( this ).removeClass( 'ec_active' );
		} );
		var data = {
			action: 'ec_ajax_get_optionitem_quantities',
			optionitem_id_1: optionitem_id_1,
			optionitem_id_2: optionitem_id_2,
			optionitem_id_3: optionitem_id_3,
			optionitem_id_4: optionitem_id_4,
			product_id: '<?php echo $product->product_id; ?>'
		};
		jQuery.ajax( { url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ 
			jQuery( '.ec_details_combo.ec_option5_<?php echo $product->product_id; ?>' ).prop( 'disabled', false ).removeClass( 'ec_inactive' );
			var json_data = JSON.parse( data );
			jQuery( document.getElementById( 'ec_option_loading_5_<?php echo $product->product_id; ?>' ) ).hide( );
			var i=0;
			next_options.each( function( ){
				if( i > 0 ){
					jQuery( this ).attr( 'data-optionitem-quantity', json_data[i-1].quantity );
					if( json_data[i-1].quantity > 0 ){
						jQuery( this ).show( );
						jQuery( this ).prop( 'disabled', false );
					}else{
						jQuery( this ).hide( );
						jQuery( this ).prop( 'disabled', true );
					}
				}else{
					jQuery( this ).attr( 'data-optionitem-quantity', quantity );
				}
				i++;
			} );
		} } );
	}
}
function ec_submit_product_review_<?php echo $product->product_id; ?>( ){	
	var review_title = jQuery( document.getElementById( 'ec_review_title_<?php echo $product->product_id; ?>' ) ).val( );
	var review_score = 0;
	for( var i=1; i<=5; i++ ){
		if( jQuery( document.getElementById( 'ec_details_review_star' + i + '_<?php echo $product->product_id; ?>' ) ).hasClass( 'ec_product_details_star_on' ) ){
			review_score++;
		}
	}
	var review_message = jQuery( document.getElementById( 'ec_review_message_<?php echo $product->product_id; ?>' ) ).val( );
	if( review_title != "" && review_score != 0 && review_message != "" ){
		// Submit a filled out review
		jQuery( document.getElementById( 'ec_details_customer_review_loader_<?php echo $product->product_id; ?>' ) ).show( );
		jQuery( document.getElementById( 'ec_details_review_error_<?php echo $product->product_id; ?>' ) ).hide( );
		var data = {
			action: 'ec_ajax_insert_customer_review',
			review_title: review_title,
			review_score: review_score,
			review_message: review_message,
			product_id: '<?php echo $product->product_id; ?>'
		};
		jQuery.ajax( { url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ 
			jQuery( document.getElementById( 'ec_details_customer_review_loader_<?php echo $product->product_id; ?>' ) ).hide( ); 
			jQuery( document.getElementById( 'ec_review_title_<?php echo $product->product_id; ?>' ) ).val( "" );
			jQuery( document.getElementById( 'ec_review_message_<?php echo $product->product_id; ?>' ) ).val( "" );
			jQuery( document.getElementById( 'ec_details_review_star1_<?php echo $product->product_id; ?>' ) ).removeClass( 'ec_product_details_star_on' ).addClass( 'ec_product_details_star_off' ); 
			jQuery( document.getElementById( 'ec_details_review_star2_<?php echo $product->product_id; ?>' ) ).removeClass( 'ec_product_details_star_on' ).addClass( 'ec_product_details_star_off' ); 
			jQuery( document.getElementById( 'ec_details_review_star3_<?php echo $product->product_id; ?>' ) ).removeClass( 'ec_product_details_star_on' ).addClass( 'ec_product_details_star_off' ); 
			jQuery( document.getElementById( 'ec_details_review_star4_<?php echo $product->product_id; ?>' ) ).removeClass( 'ec_product_details_star_on' ).addClass( 'ec_product_details_star_off' ); 
			jQuery( document.getElementById( 'ec_details_review_star5_<?php echo $product->product_id; ?>' ) ).removeClass( 'ec_product_details_star_on' ).addClass( 'ec_product_details_star_off' ); 
			jQuery( document.getElementById( 'ec_details_submit_review_button_row_<?php echo $product->product_id; ?>' ) ).hide( );
			jQuery( document.getElementById( 'ec_details_review_submitted_button_row_<?php echo $product->product_id; ?>' ) ).show( );
			jQuery( document.getElementById( 'ec_details_customer_review_success_<?php echo $product->product_id; ?>' ) ).show( ).delay( 1500 ).fadeOut( 'slow' ); 
		} } );
	}else{
		// Something is missing, display error.
		jQuery( document.getElementById( 'ec_details_review_error_<?php echo $product->product_id; ?>' ) ).show( );
	}
}
</script>