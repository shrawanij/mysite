<?php
if( trim( get_option( 'ec_option_fb_pixel' ) ) != '' ){
	if( !isset( $_COOKIE['ec_cart_facebook_order_id_tracked_' . $order->order_id] ) ){
		echo "<script>
			fbq('track', 'Purchase', {
				content_type: 'product',
				value: " . number_format( $order->grand_total, 2, '.', '' ) . ",
				currency: '" . $GLOBALS['currency']->get_currency_code( ) . "',
				contents: [";
		for( $i=0; $i<count( $order->orderdetails ); $i++ ){
			if( $i > 0 )
				echo ", ";
			echo "{
				id: '" . $order->orderdetails[$i]->product_id . "',
				quantity: " . $order->orderdetails[$i]->quantity . ",
				price: " . $order->orderdetails[$i]->unit_price . "
			}";
		}		
		echo "]
			});
		</script>";
		setcookie( 'ec_cart_facebook_order_id_tracked_' . $order->order_id, 1, time( ) + ( 3600 * 24 * 30 ), "/" );
	}
}
?>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', '<?php echo $google_urchin_code; ?>', '<?php echo $google_wp_url; ?>');
	ga('send', 'pageview');
	ga('require', 'ecommerce', 'ecommerce.js');

	<?php
		//transaction information
		echo $google_transaction;
		//transaction items
		echo $google_items;
	?>

	ga('ecommerce:send');

</script>

<?php if( get_option( 'ec_option_google_adwords_conversion_id' ) != "" ){ ?>
<!-- Google Code for WP EasyCart Sale Conversion Page -->
<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = <?php echo get_option( 'ec_option_google_adwords_conversion_id' ); ?>;
	var google_conversion_language = "<?php echo get_option( 'ec_option_google_adwords_language' ); ?>";
	var google_conversion_format = "<?php echo get_option( 'ec_option_google_adwords_format' ); ?>";
	var google_conversion_color = "<?php echo get_option( 'ec_option_google_adwords_color' ); ?>";
	var google_conversion_label = "<?php echo get_option( 'ec_option_google_adwords_label' ); ?>";
	var google_conversion_value = <?php echo number_format( $order->grand_total, 2, '.', '' ); ?>;
	var google_conversion_currency = "<?php echo get_option( 'ec_option_google_adwords_currency' ); ?>";
	var google_remarketing_only = <?php echo get_option( 'ec_option_google_adwords_remarketing_only' ); ?>;
	/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/<?php echo get_option( 'ec_option_google_adwords_conversion_id' ); ?>/?value=<?php echo number_format( $order->grand_total, 2, '.', '' ); ?>&amp;currency_code=<?php echo get_option( 'ec_option_google_adwords_currency' ); ?>&amp;label=<?php echo get_option( 'ec_option_google_adwords_label' ); ?>&amp;guid=ON&amp;script=0"/>
	</div>
</noscript>
<?php } ?>

<?php do_action( 'wpeasycart_success_page_content_top', $order_id, $order ); ?>

<div class="ec_order_success_loader">
    <div class="ec_order_success_loader_loaded">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 161.2 161.2" enable-background="new 0 0 161.2 161.2" xml:space="preserve">
            <path class="ec_order_success_loader_loaded_path" fill="none" stroke="<?php echo get_option( 'ec_option_details_main_color' ); ?>" stroke-miterlimit="10" d="M425.9,52.1L425.9,52.1c-2.2-2.6-6-2.6-8.3-0.1l-42.7,46.2l-14.3-16.4c-2.3-2.7-6.2-2.7-8.6-0.1c-1.9,2.1-2,5.6-0.1,7.7l17.6,20.3c0.2,0.3,0.4,0.6,0.6,0.9c1.8,2,4.4,2.5,6.6,1.4c0.7-0.3,1.4-0.8,2-1.5c0.3-0.3,0.5-0.6,0.7-0.9l46.3-50.1C427.7,57.5,427.7,54.2,425.9,52.1z"/>
            <circle class="ec_order_success_loader_loaded_path" fill="none" stroke="<?php echo get_option( 'ec_option_details_main_color' ); ?>" stroke-width="4" stroke-miterlimit="10" cx="80.6" cy="80.6" r="62.1"/>
            <polyline class="ec_order_success_loader_loaded_path" fill="none" stroke="<?php echo get_option( 'ec_option_details_main_color' ); ?>" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="113,52.8 74.1,108.4 48.2,86.4 "/>
        </svg>
    </div>
</div>

<h2 class="ec_cart_success_title"><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_thank_you_title' ); ?></h2>
<p class="ec_cart_success_subtitle"><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_will_receive_email' ); ?> <?php echo htmlspecialchars( $order->user_email, ENT_QUOTES); ?></p>
<p class="ec_cart_success_order_number"><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_order_number' )?> #<?php echo $order_id; ?></p>

<?php do_action( 'wpeasycart_success_page_content_middle', $order_id, $order ); ?>

<?php $order->display_order_customer_notes( ); ?>

<p class="ec_cart_success_continue_shopping_button">
	<?php if( $order->has_downloads( ) && $order->is_approved ){ ?>
	<?php echo $order->display_order_link( $GLOBALS['language']->get_text( 'cart_success', 'cart_success_view_downloads' ) ); ?>
    
	<?php }else if( $order->has_downloads( ) ){ ?>
    <?php echo $order->display_order_link( $GLOBALS['language']->get_text( 'cart_success', 'cart_success_view_downloads' ) ); ?>
    
	<?php }?>
	
	<?php if( $order->has_membership_page( ) ){ ?>
    	<a href="<?php echo $order->get_membership_page_link( ); ?>"><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_5" ); ?></a>
    <?php }?>
	
	<?php if( $GLOBALS['ec_cart_data']->cart_data->is_guest == "" ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=order_details&order_id=" . $order_id . "\"> " . $GLOBALS['language']->get_text( 'cart_success', 'cart_payment_receipt_order_details_link' ) . "</a>";
	}else{
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=order_details&order_id=" . $order_id . "&ec_guest_key=" . $GLOBALS['ec_cart_data']->cart_data->guest_key . "\">" . $GLOBALS['language']->get_text( 'cart_success', 'cart_payment_receipt_order_details_link' ) . "</a>";
	}
	?>
    
    <a href="<?php echo $this->return_to_store_page( $this->store_page ); ?>"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_continue_shopping' ); ?></a>
</p>

<div class="ec_cart_success_print_button">
	<?php $this->display_print_receipt_link( "<img src=\"" . $this->get_printer_icon( "printer_icon.png" ) . "\" class=\"ec_order_success_printer_icon\" />" . $GLOBALS['language']->get_text( 'cart_success', 'cart_success_print_receipt_text' ), $order_id ); ?>
</div>

<?php do_action( 'wpeasycart_success_page_content_bottom', $order_id, $order ); ?>