<form action="" method="POST" name="wpeasycart_admin_setup_wizard_form" id="wpeasycart_admin_setup_wizard_form" novalidate="novalidate">
<input type="hidden" name="ec_admin_form_action" id="ec_admin_form_action" value="process-wizard-payments">
<h3>Payments</h3>
<p>WP EasyCart offers both online and offline payments. <a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=payment" target="_blank">Additional payment methods</a> can be installed later.</p>
<div class="ec_admin_wizard_page_row" style="padding:30px 0;">
	<div class="ec_admin_wizard_page_row_title"><strong>PayPal</strong></div>
	<div class="ec_admin_wizard_page_row_content" style="padding-right:100px;">Accept payments with PayPal without an SSL certificate.</div>
    <a target="_blank" href="<?php echo wp_easycart_admin( )->available_url; ?>/paypal-v2/production_onboard.php?redirect=<?php echo urlencode( admin_url( ) . '?wpeasycart_paypal_onboard=production&is_wizard=true' ); ?>" onclick="return wp_easycart_wizard_use_paypal( );">
    	<span></span>
        <label class="ec_admin_wizard_input_row_toggle">
    		<input type="checkbox" name="paypal_standard" id="wp_easycart_paypal_standard" onchange="wp_easycart_wizard_use_paypal( );"<?php if( get_option( 'ec_option_payment_third_party' ) == 'paypal' ){ ?> checked="checked"<?php }?> />
    	    <span class="ec_admin_wizard_slider round" style="top:-7px;"></span>
    	</label>
    </a>
    <div style="clear:both;"></div>
</div>
<div class="ec_admin_wizard_page_row" style="padding:30px 0;">
	<div class="ec_admin_wizard_page_row_title"><strong>Stripe</strong></div>
	<div class="ec_admin_wizard_page_row_content" style="padding-right:100px;">Accept payments with Stripe (SSL certificate required).</div>
    <a target="_blank" href="<?php echo wp_easycart_admin( )->available_url; ?>/connect/?step=start&redirect=<?php echo urlencode( admin_url( ) . '?ec_admin_form_action=stripe_onboard&env=production&goto=wizard' ); ?>&env=production" onclick="return wp_easycart_wizard_use_stripe( );">
		<span></span>
        <label class="ec_admin_wizard_input_row_toggle">
            <input type="checkbox" name="use_stripe" id="wp_easycart_use_stripe" onchange="wp_easycart_wizard_use_stripe( );"<?php if( get_option( 'ec_option_payment_process_method' ) == 'stripe_connect' ){ ?> checked="checked"<?php }?> />
            <span class="ec_admin_wizard_slider round" style="top:-7px;"></span>
        </label>
    </a>
    <div style="clear:both;"></div>
</div>
<div id="use_stripe_content" style="display:none;">
    <div class="ec_admin_wizard_input_row" style="text-align:center; padding:0 0 15px; margin-top:-15px;">   
    	<span id="stripe_connected" style="font-weight:bold;"><br />You should now be connected. Visit your Settings -> Payment page for more information.</span>
    </div>
    <div style="clear:both;"></div>
</div>
<?php 
	$app_redirect_state = rand( 1000000, 9999999 );
?>
<div class="ec_admin_wizard_page_row" style="padding:30px 0;">
	<div class="ec_admin_wizard_page_row_title"><strong>Square</strong></div>
	<div class="ec_admin_wizard_page_row_content" style="padding-right:100px;">Accept payments with Square (SSL certificate required).</div>
    <a target="_blank" href="https://support.wpeasycart.com/square/?url=<?php echo urlencode( admin_url( ) . '?ec_admin_form_action=handle-square&goto=wizard' ); ?>&state=<?php echo $app_redirect_state; ?>" onclick="return wp_easycart_wizard_use_square( );">
		<span></span>
        <label class="ec_admin_wizard_input_row_toggle">
            <input type="checkbox" name="use_square" id="wp_easycart_use_square" onchange="wp_easycart_wizard_use_square( );"<?php if( get_option( 'ec_option_payment_process_method' ) == 'square' ){ ?> checked="checked"<?php }?> />
            <span class="ec_admin_wizard_slider round" style="top:-7px;"></span>
        </label>
    </a>
    <div style="clear:both;"></div>
</div>
<div id="use_square_content" style="display:none;">
    <div class="ec_admin_wizard_input_row" style="text-align:center; padding:0 0 15px; margin-top:-15px;">   
    	<span id="square_connected" style="font-weight:bold;"><br />You should now be connected. Visit your Settings -> Payment page for more information.</span>
    </div>
    <div style="clear:both;"></div>
</div>
<div class="ec_admin_wizard_page_row" style="padding:30px 0;">
	<div class="ec_admin_wizard_page_row_title"><strong>Manual Payments</strong></div>
	<div class="ec_admin_wizard_page_row_content" style="padding-right:100px;">Allow users to complete an order without paying immediately. You can provide instructions on checkout for direct deposit or payment by check.</div>
    <label class="ec_admin_wizard_input_row_toggle">
    	<input type="checkbox" name="manual_billing" id="wp_easycart_manual_billing"<?php if( get_option( 'ec_option_use_direct_deposit' ) ){ ?> checked="checked"<?php }?> />
        <span class="ec_admin_wizard_slider round"></span>
    </label>
    <div style="clear:both;"></div>
</div>
<?php $trial_note = '<div class="ec_admin_wizard_page_row" style="padding:30px 0;">
	<div class="ec_admin_wizard_page_row_title"><strong>Other Payments</strong></div>
	<div class="ec_admin_wizard_page_row_content" style="padding-right:100px;">Did you know we offer 30+ other payment methods in Professional or Premium?<br /><a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=payment" target="_blank">View Payment Gateway List</a> | <a href="admin.php?page=wp-easycart-registration&ec_trial=start" target="_blank">TRY WITH 14 DAY FREE TRIAL</a></div>
    <div style="clear:both;"></div>
</div>';
echo apply_filters( 'wp_easycart_trial_start_content', $trial_note ); ?>
<div class="ec_admin_wizard_page_row" style="padding:30px 0;">
	<div class="ec_admin_wizard_page_row_title"><strong>Your Email Address</strong></div>
	<div class="ec_admin_wizard_page_row_content" style="padding-right:100px;">Please enter your admin email address here. This allows you to recieve all notifications automatically from your store.</div>
    <div style="clear:both;"></div>
</div>
<div class="ec_admin_wizard_input_row" style="padding-top:0px; margin-top:-20px;">
    <div class="ec_admin_wizard_input_row_title">&nbsp;&nbsp;&nbsp;</div>
    <div class="ec_admin_wizard_input_row_input" style="padding-left:0 !important;">
    	<input type="text" name="bcc_email" id="wp_easycart_bcc_email" value="" placeholder="youremail@email.com" style="margin-bottom:10px;" />
    	<label style="font-size:11px;"><input type="checkbox" checked="checked" name="subscribe_me" id="wp_easycart_subscribe_me" /> Send me security updates and news from WP EasyCart.</label>
    </div>
</div>
<div class="ec_admin_wizard_button_bar">
	<a href="admin.php?page=wp-easycart-settings&ec_admin_form_action=skip-wizard" class="ec_admin_wizard_quit_button">Skip Setup Wizard</a>
    <a href="admin.php?page=wp-easycart-products&subpage=products">Setup Later</a>
    <input type="submit" class="ec_admin_wizard_next_button" value="Save &amp; Continue" />
</div>