<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_deconetwork_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-generic"></div><span>DecoNetwork Setup</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'third-party', 'deconetwork');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'third-party', 'deconetwork');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        <div>DecoNetwork URL <input name="ec_option_deconetwork_url" id="ec_option_deconetwork_url" type="text" value="<?php echo stripslashes( get_option( 'ec_option_deconetwork_url' ) ); ?>" /></div>
        <div>DecoNetwork Order Password <input name="ec_option_deconetwork_password" id="ec_option_deconetwork_password" type="text" value="<?php echo stripslashes( get_option( 'ec_option_deconetwork_password' ) );  ?>" /></div>
        <div class="settings_list_items"><p>Note: You must complete the following steps in your DecoNetwork settings panel to offer these product types:</p>
        <ul>
            <li>External Cart Integration must be enabled by going to your DecoNetwork Manage Store -> Website Settings -> API Settings.</li>
            <li>Add the Add to Cart Callback URL: <?php echo get_permalink( get_option( 'ec_option_cartpage' ) ); ?></li>
            <li>Add the Cancel Callback URL: <?php echo get_permalink( get_option( 'ec_option_storepage' ) ); ?></li>
            <li>Create a Custom Order Commit URL. This is a custom value DIFFERENT from your account password AND should be entered in the field provided above!</li>
            <li>Additional note, the hard part of setting this up tends to be finding the product id (not product code!) and is available if you go to the product on your DecoNetowrk site, look at the URL, and where it says n=xxxxxxx, the xxxxxxx is the id you need to enter in the EasyCart system when setting up a product.</li>
            <li>It is recommended that you turn off email correspondence from your DecoNetwork site. This can be done by going to Manage Store -> Website Settings -> Correspondence Settings and check the box to force correspondence from the WP EasyCart instead of your DecoNetwork site.</li>
        </ul>
        </div>
       	
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_deconetwork_settings( );" value="Save Setup" />
        </div>
    </div>
</div>