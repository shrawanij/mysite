<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_custom_css" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-editor-alignleft"></div><span>Custom CSS</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'design', 'custom-css');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'design', 'custom-css');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
	
		<span>Insert Custom CSS Rules Here</span> 
       	
        <div><textarea style="width:100%; height:250px;" name="ec_option_custom_css" id="ec_option_custom_css"><?php echo stripslashes( get_option( 'ec_option_custom_css' ) ); ?></textarea></div>
        
     
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_custom_css( );" value="Save Options" />
        </div>
    </div>
</div>