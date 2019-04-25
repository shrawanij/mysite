<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_order_receipt_loader" ); ?>
    
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
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "email-setup" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "send_test_email" ){
			$send_emails = new wp_easycart_admin_email_settings( );
			$result = $send_emails->ec_send_test_email( );
            if( $result )
                $isupdate = "5";
            else
                $isupdate = "6";
		}
		?>
    
    <div class="ec_admin_settings_label">
    	<div class="dashicons-before dashicons-email"></div>
        <span>Order Receipt Email Setup</span>
        <a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'email-setup', 'order-receipt');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    	<?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'email-setup', 'order-receipt');?>
    </div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        
		<?php if( $isupdate && $isupdate == "1" ) { ?>
           <div  class="ec_save_success"><span>Email Test Sent Successfully!</span></div>
        <?php }else if( $isupdate && $isupdate == "2" ) { ?>
            <div  class="ec_save_failure"><span>Email Test Failed! Errors: <?php echo $smtp_errors; ?></span></div>
        <?php } ?> 
        
        <div>Order Receipt 'From' Email Address  <a href="admin.php?page=wp-easycart-settings&subpage=email-setup&ec_action=smtp-test1">(Send Test Email)</a><input name="ec_option_order_from_email" id="ec_option_order_from_email" class="language_input" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_order_from_email' ) ); ?>" /></div>
        
        <div id="ec_option_order_use_smtp_choice"<?php if( get_option('ec_option_use_wp_mail') ){ ?> style="display:none;"<?php }?>>Use SMTP Server to send order receipts?<select name="ec_option_order_use_smtp" id="ec_option_order_use_smtp" onchange="wpeasycart_update_order_use_smtp( );" style="width:100%;">
                <option value="0"<?php if( get_option('ec_option_order_use_smtp') == "0" ){ echo " selected=\"selected\""; }?>>No SMTP Needed, use global email settings</option>
                <option value="1"<?php if( get_option('ec_option_order_use_smtp') == "1" ){ echo " selected=\"selected\""; }?>>Yes, Use SMTP server</option>
            </select>
        </div>
        
        <div id="ec_option_order_from_smtp_host_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_order_use_smtp') ){ ?> style="display:none;"<?php }?>>SMTP Host<input name="ec_option_order_from_smtp_host" id="ec_option_order_from_smtp_host"  class="language_input"type="text"  value="<?php echo stripslashes( get_option( 'ec_option_order_from_smtp_host' ) ); ?>"/></div>
        
       	<div id="ec_option_order_from_smtp_encryption_type_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_order_use_smtp') ){ ?> style="display:none;"<?php }?>>SMTP Encryption Type<select name="ec_option_order_from_smtp_encryption_type" id="ec_option_order_from_smtp_encryption_type">
                <option value="none"<?php if( get_option('ec_option_order_from_smtp_encryption_type') == "none" ){ echo " selected=\"selected\""; }?>>None</option>
                <option value="ssl"<?php if( get_option('ec_option_order_from_smtp_encryption_type') == "ssl" ){ echo " selected=\"selected\""; }?>>SSL</option>
                <option value="tls"<?php if( get_option('ec_option_order_from_smtp_encryption_type') == "tls" ){ echo " selected=\"selected\""; }?>>TLS</option>
            </select>
        </div>
        
        <div id="ec_option_order_from_smtp_port_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_order_use_smtp') ){ ?> style="display:none;"<?php }?>>SMTP Port Number<input name="ec_option_order_from_smtp_port" id="ec_option_order_from_smtp_port" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_order_from_smtp_port' ) ); ?>" /></div>
        
        <div id="ec_option_order_from_smtp_username_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_order_use_smtp') ){ ?> style="display:none;"<?php }?>>SMTP Username<input name="ec_option_order_from_smtp_username" id="ec_option_order_from_smtp_username"  class="language_input" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_order_from_smtp_username' ) ); ?>"/></div>
        
        <div id="ec_option_order_from_smtp_password_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_order_use_smtp') ){ ?> style="display:none;"<?php }?>>SMTP Password<input name="ec_option_order_from_smtp_password"  id="ec_option_order_from_smtp_password"  class="language_input" type="password" value="<?php echo stripslashes( get_option( 'ec_option_order_from_smtp_password' ) ); ?>"  /></div>
        
        
        <br /><span>Additional Email Options</span>
        <div>Admin Email Address(es):<input class="language_input" name="ec_option_bcc_email_addresses"  id="ec_option_bcc_email_addresses" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_bcc_email_addresses' ) ); ?>" /></div>
        
        <div><input type="checkbox" name="ec_option_show_email_on_receipt" id="ec_option_show_email_on_receipt" value="1"<?php if( get_option('ec_option_show_email_on_receipt') == "1" ){ echo " checked=\"checked\""; }?> /> Show Email Address on Receipt Email</div>
        <div><input type="checkbox" name="ec_option_show_image_on_receipt" id="ec_option_show_image_on_receipt" value="1"<?php if( get_option('ec_option_show_image_on_receipt') == "1" ){ echo " checked=\"checked\""; }?> /> Show Product Images on Receipt Email</div>
         
		<?php 
       		global $wpdb;
        	$min_order_id = $wpdb->get_var( $wpdb->prepare( "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = %s AND TABLE_NAME = 'ec_order'", $wpdb->dbname ) );?>
        <div>Next Order ID (min allowed is <?php echo $min_order_id; ?>)<input name="ec_option_current_order_id" id="ec_option_current_order_id" type="text"  value="<?php echo $min_order_id; ?>" /></div>
        
        <br /><span>Resend Order Email Test</span>
        <?php if( $isupdate && $isupdate == "5" ) { ?>
        <div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Order Emails have been dispatched.</strong></p></div>
        <?php }else if( $isupdate && $isupdate == "6" ){ ?>
        <div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Order ID was not found.</strong></p></div> 
        <?php }?>
        
		<div>
        	<form action="admin.php?page=wp-easycart-settings&subpage=email-setup&ec_action=send_test_email" method="POST">
                <p>This section is intended to troubleshoot the EasyCart emailer system. First place an order, then you can change the status of the order in the admin to a completed payment status (this allows you to test without actually completing the checkout payment process). Once you have a completed order, get the order id, enter it below, and hit the send email button.</p>
            
                <div>
                    <strong>Order ID:</strong>  <input type="text" name="ec_order_id" id="ec_order_id" value="1700" size="1"  style="width:325px; float: right; margin-top: 0px;" />
                </div>
        
                <div class="ec_admin_settings_input">
                    <input type="submit" value="Send Order Email" class="ec_admin_settings_simple_button" style="float: right;" />
                </div>
			</form>
            <br /><span>Email Logo</span>
            <div class="ec_admin_settings_input" style="padding:0px;">Upload custom email logo image:  <input type="button" class="ec_admin_settings_simple_button" id="upload_logo_button" type="button" style="margin-top:4px;" value="Upload Custom Image" />
            	<input id="ec_option_email_logo" type="hidden" size="36" name="ec_option_email_logo" value="<?php echo get_option( 'ec_option_email_logo' ); ?>" />
           	</div>
            <div style="float:left; height:auto; position:relative;">
                <a href="#" onclick="ec_admin_remove_email_logo( ); return false;" id="ec_admin_email_logo_remove_link" style="position:absolute; top:13px; right:5px; padding:8px 10px; text-decoration:none; background:#7bb141; border-radius:100px; color:#FFF; font-weight:bold; line-height:1em;<?php if( get_option( 'ec_option_email_logo' ) == '' ){ ?> display:none;<?php }?>">delete</a>
                <img src="<?php echo get_option( 'ec_option_email_logo' ); ?>" id="email_logo_image" style="float:left; max-width:100%; max-height:250px; margin:10px 0; padding:10px; border:1px solid #a2ab9f;" />
            </div>
            
            <div class="ec_admin_settings_input">
                <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_order_receipt_setup( );" value="Save Options" />
            </div>
        </div>
    </div>
</div>