<div class="ec_admin_list_line_item">
    
    <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_live_gateway_display_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-lock"></div><span>Live Payment</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'payment', 'live-gateway');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'payment', 'live-gateway');?></div>
    
    <?php if( get_option( 'ec_option_stripe_connect_use_sandbox' ) && get_option( 'ec_option_stripe_connect_sandbox_access_token' ) != '' ){ ?>
    <div class="ec_admin_stripe_holder">
    	<h1 class="ec_admin_stripe_title">Connected with Stripe Sandbox</h1>
        <h3 class="ec_admin_stripe_subtitle">You are ready to process payments in test mode</h3>
        <div class="ec_admin_stripe_button_row">
        	<div style="width:100%;"><img style="max-width:100%;" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/Stripe Logo (blue).png' ); ?>" alt="Stripe" /></div>
    		<?php if( get_option( 'ec_option_stripe_connect_production_access_token' ) != '' ){ ?>
            <a href="admin.php?page=wp-easycart-settings&subpage=payment&ec_admin_form_action=stripe-connect-use-production">Switch to Live Mode</a>
            <?php }else{ ?>
            <a href="https://support.wpeasycart.com/connect/?step=start&redirect=<?php echo urlencode( admin_url( ) . '?ec_admin_form_action=stripe_onboard&env=production' ); ?>&env=production">Switch to Live Mode</a><?php }?> | <a href="admin.php?page=wp-easycart-settings&subpage=payment&ec_admin_form_action=stripe-connect-sandbox-disconnect">Change Payment Method</a>
        </div>
        <div class="ec_admin_stripe_legal">*WP EasyCart charges a 2% application fee on all sales with Stripe in the free edition.</div>
    	<div class="ec_admin_settings_notice" style="text-align:center; padding:0 10px 20px;"><strong>Webhook URL:</strong> <?php echo plugins_url( EC_PLUGIN_DIRECTORY . "/inc/scripts/stripe_webhook.php" ); ?></div>
    </div>
    
	<?php }else if( !get_option( 'ec_option_stripe_connect_use_sandbox' ) && get_option( 'ec_option_stripe_connect_production_access_token' ) != '' ){ ?>
    <div class="ec_admin_stripe_holder">
    	<h1 class="ec_admin_stripe_title">Connected with Stripe</h1>
        <h3 class="ec_admin_stripe_subtitle">You are ready to process payments in live mode</h3>
        <div class="ec_admin_stripe_button_row">
        	<div style="width:100%;"><img style="max-width:100%;" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/Stripe Logo (blue).png' ); ?>" alt="Stripe" /></div>
    		<?php if( get_option( 'ec_option_stripe_connect_sandbox_access_token' ) != '' ){ ?>
            <a href="admin.php?page=wp-easycart-settings&subpage=payment&ec_admin_form_action=stripe-connect-use-sandbox">Switch to Sandbox Mode</a>
            <?php }else{ ?>
            <a href="https://support.wpeasycart.com/connect/?step=start&redirect=<?php echo urlencode( admin_url( ) . '?ec_admin_form_action=stripe_onboard&env=sandbox' ); ?>&env=sandbox">Switch to Sandbox Mode</a><?php }?> | <a href="admin.php?page=wp-easycart-settings&subpage=payment&ec_admin_form_action=stripe-connect-production-disconnect">Change Payment Method</a>
        </div>
        <div class="ec_admin_stripe_legal">*WP EasyCart charges a 2% application fee on all sales with Stripe in the free edition.</div>
    	<div class="ec_admin_settings_notice" style="text-align:center; padding:0 10px 20px;"><strong>Webhook URL:</strong> <?php echo plugins_url( EC_PLUGIN_DIRECTORY . "/inc/scripts/stripe_webhook.php" ); ?></div>
    </div>
    
    <?php }else{ ?>
    <div class="ec_admin_stripe_holder">
    	<h1 class="ec_admin_stripe_title">WP EasyCart + Stripe</h1>
        <h3 class="ec_admin_stripe_subtitle">Included FREE in WP EasyCart!*</h3>
        <div class="ec_admin_stripe_button_row">
        	<a href="https://support.wpeasycart.com/connect/?step=start&redirect=<?php echo urlencode( admin_url( ) . '?ec_admin_form_action=stripe_onboard&env=production' ); ?>&env=production" target="_self">
        		<img src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/blue-on-light.png' ); ?>" alt="Connect with Stripe" />
    		</a>
            <br />
            <a href="https://support.wpeasycart.com/connect/?step=start&redirect=<?php echo urlencode( admin_url( ) . '?ec_admin_form_action=stripe_onboard&env=sandbox' ); ?>&env=sandbox">Try Sandbox First?</a>
        </div>
        <div class="ec_admin_stripe_legal">*WP EasyCart charges a 2% application fee on all sales with Stripe in the free edition.</div>
    
    	<div class="ec_admin_paypal_or">-- OR --</div>
    </div>
    
    <?php do_action( 'wp_easycart_admin_live_gateway_post_stripe' ); ?>
    
    <h1 class="ec_admin_stripe_title" style="color:#333; margin-top:10px;">Use one of our PRO gateways</h1>
    <h3 class="ec_admin_stripe_subtitle">No Application Fees, Sell Like a Pro!</h3>
     
    <div class="ec_admin_live_gateway_select">
    	<select id="ec_option_payment_process_method" name="ec_option_payment_process_method" onchange="toggle_live_gateways( );<?php do_action( 'wp_easycart_pro_add_live_save' ); ?>" value="<?php echo get_option('ec_option_payment_process_method'); ?>" style="width:250px;">
        	<option value="0" <?php if( get_option( 'ec_option_payment_process_method') == "0" ){ echo " selected"; } ?>>No Live Payment Processor</option>
        	<?php do_action( 'wpeasycart_admin_load_live_gateway_select_options' ); ?>
    	</select>
    </div>
    
    <?php do_action( 'wpeasycart_admin_load_live_gateway_settings' ); ?>
    
    <div class="ec_admin_settings_input<?php if( get_option( 'ec_option_payment_process_method' ) != '0' && get_option( 'ec_option_payment_process_method' ) != 'custom' ){ ?> ec_admin_initial_hide<?php }?>" id="ec_admin_live_gateway_none">
        <?php /*<input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_live_gateway_selection( );" value="Save Options" />*/ ?>
    </div>
    <?php }?>
    
</div>