<div id="install_demo_data" class="ec_admin_list_line_item ec_admin_demo_data_line"<?php if( get_option( 'ec_option_demo_data_installed' ) ){ ?> style="display:none;"<?php }?>>
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_demo_data_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-download"></div><span>Install Demo Data (Optional)</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'initial-setup', 'demo-data');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'initial-setup', 'demo-data');?></div>
    
    <div class="ec_admin_settings_input">
        <span>Install our demo data for quick testing</span>
    </div>
    <div class="ec_admin_settings_input">
            <span class="ec_admin_settings_simple_button"><a href="admin.php?page=wp-easycart-settings&subpage=initial-setup&action=easycart-install-demo-data" onclick="return ec_admin_install_demo_data( );">Install Demo Data Now!</a></span>
    </div>
</div>

<div id="uninstall_demo_data" class="ec_admin_list_line_item ec_admin_demo_data_line"<?php if( !get_option( 'ec_option_demo_data_installed' ) ){ ?> style="display:none;"<?php }?>>
    
    <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_uninstall_demo_data_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-download"></div><span>Uninstall Demo Data</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'initial-setup', 'demo-data');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'initial-setup', 'demo-data');?></div>
    
    <div class="ec_admin_settings_input">
        <p>Uninstall demo data <strong>(careful, all data will be deleted from the store!)</strong></p>
    </div>
    <div class="ec_admin_settings_input">
        <span class="ec_admin_settings_simple_button"><a href="admin.php?page=wp-easycart-settings&subpage=initial-setup&action=easycart-install-demo-data" onclick="return ec_admin_uninstall_demo_data( );">Uninstall Demo Data</a></span>
    </div>
</div>