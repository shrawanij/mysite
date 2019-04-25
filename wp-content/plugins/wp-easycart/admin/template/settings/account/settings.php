<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_account_settings_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-users"></div><span>Account Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'accounts', 'settings');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'accounts', 'settings');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        <div><input type="checkbox" name="ec_option_require_account_terms" id="ec_option_require_account_terms" value="1"<?php if( get_option('ec_option_require_account_terms') == "1" ){ echo " checked=\"checked\""; }?> /> Require terms agreement (Enable for GDPR Compliance)</div>
       	<div><input type="checkbox" name="ec_option_require_account_address" id="ec_option_require_account_address" value="1"<?php if( get_option('ec_option_require_account_address') == "1" ){ echo " checked=\"checked\""; }?> /> Collect Billing Information on Registration</div>
       	<div><input type="checkbox" name="ec_option_require_email_validation" id="ec_option_require_email_validation" value="1"<?php if( get_option('ec_option_require_email_validation') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Email Validation</div>
       	<div><input type="checkbox" name="ec_option_enable_recaptcha" id="ec_option_enable_recaptcha" value="1"<?php if( get_option('ec_option_enable_recaptcha') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Google Recaptcha on Account Forms</div>
       	<div>Google Recaptcha v2 Site Key: <input type="text" name="ec_option_recaptcha_site_key" id="ec_option_recaptcha_site_key" value="<?php echo get_option( 'ec_option_recaptcha_site_key' ); ?>" /></div>
       	<div>Google Recaptcha v2 Secret Key: <input type="text" name="ec_option_recaptcha_secret_key" id="ec_option_recaptcha_secret_key" value="<?php echo get_option( 'ec_option_recaptcha_secret_key' ); ?>" /></div>
       	<div><a href="https://www.google.com/recaptcha/admin#list" target="_blank">Get Your Google reCAPTCHA v2 keys here</a></div>
        <div><input type="checkbox" name="ec_option_show_account_subscriptions_link" id="ec_option_show_account_subscriptions_link" value="1"<?php if( get_option('ec_option_show_account_subscriptions_link') == "1" ){ echo " checked=\"checked\""; }?> /> Show Manage Subscription Menu Item</div>
       	<div><input type="checkbox" name="ec_option_enable_user_notes" id="ec_option_enable_user_notes" value="1"<?php if( get_option('ec_option_enable_user_notes') == "1" ){ echo " checked=\"checked\""; }?> /> Enable User Notes on Registration</div>
       	<div><input type="checkbox" name="ec_option_show_subscriber_feature" id="ec_option_show_subscriber_feature" value="1"<?php if( get_option('ec_option_show_subscriber_feature') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Subscribe Checkbox</div>
       	<div><input type="checkbox" name="ec_subscriptions_use_first_order_details" id="ec_subscriptions_use_first_order_details" value="1"<?php if( get_option('ec_subscriptions_use_first_order_details') == "1" ){ echo " checked=\"checked\""; }?> /> Subscription Renewals Match First Order Billing &amp; Shipping (Leave Unchecked to Match Account Values).</div>
       	
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_account_settings( );" value="Save Options" />
        </div>
    </div>
</div>