<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_checkout_form_settings_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-feedback"></div><span>Checkout Form</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'checkout', 'form-settings');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'checkout', 'form-settings');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        <div><input type="checkbox" name="ec_option_load_ssl" id="ec_option_load_ssl" value="1"<?php if( get_option('ec_option_load_ssl') == "1" ){ echo " checked=\"checked\""; }?> /> Force Site Secure (SSL Certificate Required)</div>
        <div><input type="checkbox" name="ec_option_display_country_top" id="ec_option_display_country_top" value="1"<?php if( get_option('ec_option_display_country_top') == "1" ){ echo " checked=\"checked\""; }?> /> Display Country Selection at top of form</div>
        <div><input type="checkbox" name="ec_option_use_address2" id="ec_option_use_address2" value="1"<?php if( get_option('ec_option_use_address2') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Address Line 2</div>
        <div><input type="checkbox" name="ec_option_collect_user_phone" id="ec_option_collect_user_phone" value="1"<?php if( get_option('ec_option_collect_user_phone') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Phone Number</div>
        <div><input type="checkbox" name="ec_option_enable_company_name" id="ec_option_enable_company_name" value="1"<?php if( get_option('ec_option_enable_company_name') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Company Address</div>
        <div><input type="checkbox" name="ec_option_collect_vat_registration_number" id="ec_option_collect_vat_registration_number" value="1"<?php if( get_option('ec_option_collect_vat_registration_number') == "1" ){ echo " checked=\"checked\""; }?> /> Enable VAT Registration Number</div>
        <div><input type="checkbox" name="ec_option_user_order_notes" id="ec_option_user_order_notes" value="1"<?php if( get_option('ec_option_user_order_notes') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Customer Notes</div>
        <div><input type="checkbox" name="ec_option_require_terms_agreement" id="ec_option_require_terms_agreement" value="1"<?php if( get_option('ec_option_require_terms_agreement') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Terms Agreement</div>
        <div><input type="checkbox" name="ec_option_use_contact_name" id="ec_option_use_contact_name" value="1"<?php if( get_option('ec_option_use_contact_name') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Name for Account</div>
        <div><input type="checkbox" name="ec_option_show_card_holder_name" id="ec_option_show_card_holder_name" value="1"<?php if( get_option('ec_option_show_card_holder_name') == "1" ){ echo " checked=\"checked\""; }?> /> Collect Card Holder Name</div>
        
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_checkout_form_options( );" value="Save Options" />
        </div>
    </div>
</div>