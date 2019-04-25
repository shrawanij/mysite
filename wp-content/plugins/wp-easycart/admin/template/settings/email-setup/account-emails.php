<div class="ec_admin_list_line_item ec_admin_demo_data_line" style="float:left;">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_customer_account_email_loader" ); ?>
    
    <?php
		$isupdate = false;
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "email-setup" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "smtp-test1" ){
			$send_emails = new wp_easycart_admin_email_settings( );
			$smtp_errors = $send_emails->wpeasycart_smtp_test1( );
			if( !$smtp_errors )
				$isupdate = "1";
			else
				$isupdate = "2";
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "email-setup" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "smtp-test2" ){
			$send_emails = new wp_easycart_admin_email_settings( );
			$smtp_errors = $send_emails->wpeasycart_smtp_test2( );
			if( !$smtp_errors )
				$isupdate = "3";
			else
				$isupdate = "4";
		}
	?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-email"></div><span>Customer Account Email Setup</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'email-setup', 'customer-email');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'email-setup', 'customer-email');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        
        <?php if( $isupdate && $isupdate == "3" ) { ?>
           <div  class="ec_save_success"> <span>Email Test Sent Successfully!</span></div>
        <?php }else if( $isupdate && $isupdate == "4" ) { ?>
            <div  class="ec_save_failure"><span>Email Test Failed! Errors: <?php echo $smtp_errors; ?></span></div>
        <?php } ?> 
        
        <div>Customer Account 'From' Email Address <a href="admin.php?page=wp-easycart-settings&subpage=email-setup&ec_action=smtp-test2">(Send Test Email)</a><input name="ec_option_password_from_email" id="ec_option_password_from_email"  type="text"  class="language_input" value="<?php echo stripslashes( get_option( 'ec_option_password_from_email' ) ); ?>" /></div>
        
		<div id="ec_option_password_use_smtp_choice"<?php if( get_option('ec_option_use_wp_mail') ){ ?> style="display:none;"<?php }?>>Use SMTP Server to send account emails?<select name="ec_option_password_use_smtp" id="ec_option_password_use_smtp" onchange="wpeasycart_update_password_use_smtp( );" style="width:100%;">
        	<option value="0"<?php if( get_option('ec_option_password_use_smtp') == "0" ){ echo " selected=\"selected\""; }?>>No SMTP Needed, use global email settings</option>
            <option value="1"<?php if( get_option('ec_option_password_use_smtp') == "1" ){ echo " selected=\"selected\""; }?>>Yes, Use SMTP server</option>
        </select></div>
        
        <div id="ec_option_password_from_smtp_host_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_password_use_smtp') ){ ?> style="display:none;"<?php }?>>SMTP Host<input name="ec_option_password_from_smtp_host" id="ec_option_password_from_smtp_host" type="text"  class="language_input"  value="<?php echo stripslashes( get_option( 'ec_option_password_from_smtp_host' ) ); ?>"/></div>
        
       <div id="ec_option_password_from_smtp_encryption_type_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_password_use_smtp') ){ ?> style="display:none;"<?php }?>>SMTP Encryption Type<select name="ec_option_password_from_smtp_encryption_type" id="ec_option_password_from_smtp_encryption_type">
        	<option value="none"<?php if( get_option('ec_option_password_from_smtp_encryption_type') == "none" ){ echo " selected=\"selected\""; }?>>None</option>
            <option value="ssl"<?php if( get_option('ec_option_password_from_smtp_encryption_type') == "ssl" ){ echo " selected=\"selected\""; }?>>SSL</option>
            <option value="tls"<?php if( get_option('ec_option_password_from_smtp_encryption_type') == "tls" ){ echo " selected=\"selected\""; }?>>TLS</option>
        </select></div>
        
        <div id="ec_option_password_from_smtp_port_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_password_use_smtp') ){ ?> style="display:none;"<?php }?>>SMTP Port Number<input name="ec_option_password_from_smtp_port" id="ec_option_password_from_smtp_port" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_password_from_smtp_port' ) ); ?>" /></div>
        
        <div id="ec_option_password_from_smtp_username_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_password_use_smtp') ){ ?> style="display:none;"<?php }?>>SMTP Username<input name="ec_option_password_from_smtp_username" id="ec_option_password_from_smtp_username" type="text"  class="language_input" value="<?php echo stripslashes( get_option( 'ec_option_password_from_smtp_username' ) ); ?>"/></div>
        
        <div id="ec_option_password_from_smtp_password_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_password_use_smtp') ){ ?> style="display:none;"<?php }?>>SMTP Password<input name="ec_option_password_from_smtp_password" id="ec_option_password_from_smtp_password" type="password"  class="language_input" value="<?php echo stripslashes( get_option( 'ec_option_password_from_smtp_password' ) ); ?>"  /></div>
        
       <br />
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_customer_account_emails( );" value="Save Options" />
        </div>
    </div>
</div>