<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_google_adwords_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-generic"></div><span>Google Adwords Setup</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'third-party', 'google adwords');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'third-party', 'google adwords');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        <div>Google Conversion ID (Conversion Tracking)<input type="text" name="ec_option_google_adwords_conversion_id" id="ec_option_google_adwords_conversion_id" value="<?php echo get_option( 'ec_option_google_adwords_conversion_id' ); ?>" /></div>
       	<div>Google Conversion Language<input type="text" name="ec_option_google_adwords_language" id="ec_option_google_adwords_language" value="<?php echo get_option( 'ec_option_google_adwords_language' ); ?>" /> </div>
        <div>Google Conversion Format<input type="text" name="ec_option_google_adwords_format" id="ec_option_google_adwords_format" value="<?php echo get_option( 'ec_option_google_adwords_format' ); ?>" /> </div>
        <div>Google Conversion Color<input type="text" name="ec_option_google_adwords_color" id="ec_option_google_adwords_color" value="<?php echo get_option( 'ec_option_google_adwords_color' ); ?>" /> </div>
        <div>Google Conversion Currency<input type="text" name="ec_option_google_adwords_currency" id="ec_option_google_adwords_currency" value="<?php echo get_option( 'ec_option_google_adwords_currency' ); ?>" /> </div>
        <div>Google Conversion Label<input type="text" name="ec_option_google_adwords_label" id="ec_option_google_adwords_label" value="<?php echo get_option( 'ec_option_google_adwords_label' ); ?>" /> </div>
        <div><input type="checkbox" name="ec_option_google_adwords_remarketing_only" id="ec_option_google_adwords_remarketing_only" value="0"<?php if( get_option('ec_option_google_adwords_remarketing_only') == "true" ){ echo " checked=\"checked\""; }?> /> Google Remarketing Only </div>
        
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_google_adwords( );" value="Save Setup" />
        </div>
    </div>
</div>