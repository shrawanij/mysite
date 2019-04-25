<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_email_settings_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-generic"></div><span>Global Email Settings</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'email-setup', 'email-settings');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'email-setup', 'email-settings');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        
        <div>Choose Global Email System to Use<select name="ec_option_use_wp_mail" id="ec_option_use_wp_mail" style="width:100%;" onchange="return wpeasycart_update_use_wp_mail( );">
        	<option value="0"<?php if( get_option('ec_option_use_wp_mail') == "0" ){ echo " selected=\"selected\""; }?>>EasyCart Mail System</option>
            <option value="1"<?php if( get_option('ec_option_use_wp_mail') == "1" ){ echo " selected=\"selected\""; }?>>WordPress's Mail System</option>
        </select></div>
        
        <div><input type="checkbox" name="ec_option_send_signup_email" id="ec_option_send_signup_email" value="1"<?php if( get_option('ec_option_send_signup_email') == "1" ){ echo " checked=\"checked\""; }?> /> Send Admin Email on New Account Signup</div>
        
       	
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_email_settings( );" value="Save Options" />
        </div>
    </div>
</div>