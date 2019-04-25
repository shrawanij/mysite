<div class="ec_admin_settings_panel">
    <div class="ec_admin_important_numbered_list_fullwidth">
        <div class="ec_admin_list_line_item_fullwidth ec_admin_demo_data_line">
			<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_registration_loader" ); ?>
            <div class="ec_admin_settings_label">
            	<div class="dashicons-before dashicons-unlock"></div>
            	<span>Registration & Activation</span>
                <a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'registration', 'registration');?>" target="_blank" class="ec_help_icon_link">
            		<div class="dashicons-before ec_help_icon dashicons-info"></div>
            	</a>
            	<?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'registration', 'registration');?>
            </div>
            <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
            
				<style>input {margin-top: 0px !important;}</style>
            
            
				<?php if( isset( $_GET['success'] ) && $_GET['success'] == 'deactivate-complete' ){ ?>
                    <div id='setting-error-settings_updated' class='updated settings-success' style="margin:0 0 10px;"><p><strong>EasyCart Successfully Deactivated!  You may now use your license key elsewhere.</strong></p></div>
                <?php }else if( isset( $_GET['error'] ) && $_GET['error'] == 'deactivate-no-key-found' ){ ?>
                    <div id='setting-error-settings_updated' class='updated error' style="margin:0 0 10px;"><p><strong>No License Key found with that value, please check your value.</strong></p></div> 
                <?php }else if( isset( $_GET['error'] ) && $_GET['error'] == 'deactivate-registration-failed' ){ ?>
                    <div id='setting-error-settings_updated' class='updated error' style="margin:0 0 10px;"><p><strong>There was an error Deactivating EasyCart, please try again at a later time.</strong></p></div> 
                <?php }
                
                if( isset( $_GET['success'] ) && $_GET['success'] == 'activate-complete' ){ ?>
                    <div id='setting-error-settings_updated' class='updated settings-success' style="margin:0 0 10px;"><p><strong>EasyCart Successfully Activated!  You now have access to new sections within EasyCart.</strong></p></div>
                <?php }else if( isset( $_GET['error'] ) && $_GET['error'] == 'activate-no-key-found' ){ ?>
                    <div id='setting-error-settings_updated' class='updated error' style="margin:0 0 10px;"><p><strong>No License Key found with that value, please check your value.</strong></p></div> 
                <?php }else if( isset( $_GET['error'] ) && $_GET['error'] == 'activate-registration-failed' ){ ?>
                    <div id='setting-error-settings_updated' class='updated error' style="margin:0 0 10px;"><p><strong>There was an error activating EasyCart, please try again at a later time.</strong></p></div> 
                <?php
                }
            	
				if( $license_status == 'deactivated' ){ ?>
				<span style="font-size:32px; font-weight:normal; margin:0 0 10px; display:block;">Try WP EasyCart PRO FREE for 14 Days</span>
				<p style="margin-top:0px;">If you do not have a license, try starting a FREE 14 day trial!</p>
				<div class="ec_admin_upgrade_subheader ec_admin_upgrade_box_signup_row" style="text-align:left; padding:0 0 50px;"><a href="admin.php?page=wp-easycart-registration&ec_trial=start">ACTIVATE 14 DAY PRO TRIAL NOW!</a></div>
				
                <hr style="float:left; width:100%;" />
				
				<span style="font-size:32px; font-weight:normal; margin:25px 0 10px; display:block;">Already Have a License? Register Your Site:</span>
				
				<form action="admin.php?page=wp-easycart-registration&subpage=registration&ec_action=activateregistration"  method="POST" name="wpeasycart_admin_form" id="wpeasycart_admin_form1" novalidate="novalidate">
					<div><span class="ec_language_row_label">Full Name (First & Last):</span><br /> <input type="text" name="customername" id="customername" required="required" ></div><br />
					<div><span class="ec_language_row_label">Email Address:</span><br /> <input type="email" name="customeremail" id="customeremail" required="required" ></div><br />
					<div><span class="ec_language_row_label">License Key:</span><br /> <input type="text" name="transactionkey" id="transactionkey" required="required" ></div><br />
					<div class="ec_admin_settings_input" style="padding:0;"><input type="submit" class="ec_admin_settings_simple_button"value="Activate EasyCart License"></div>
				</form>
                
                <br /><br />
				
				<hr />
				
                <span style="font-size:32px; font-weight:normal; margin:0 0 10px; display:block;">Forgot your License Key?</span>
				<p>All of your license keys are available by logging into our website at www.wpeasycart.com and visiting your account. You can see past orders, license keys, days left of support & upgrades, as well as what sites are reigstered to what license keys.</p>
				<form action="https://www.wpeasycart.com/my-account"  method="POST" target="_blank" name="wpeasycart_admin_form" id="wpeasycart_admin_form_outside1" novalidate="novalidate">
					<div class="ec_admin_settings_input" style="padding:0;"><input type="submit" class="ec_admin_settings_simple_button" value="Visit WP EasyCart Account" ></div>
				</form>
                
				<div style="clear:both;"></div>
				
				<?php }else if( $license_status == 'activated' ){ 
             		$license_data = wp_easycart_admin_license( )->license_data;
            		if( $license_data->key_version == 'v3' ){ ?>
                <p> All EasyCart licenses are good for use on <strong>one</strong> WordPress website.  You may easily transfer your website license to any other website by simply deactivating your license key.  You may also simply enter your license key into a new website and it will automatically deactivate any other websites that may be active.</p>
				<p>We make it easy and simple!  Each WordPress website requires a license, you can purchase new licenses by visiting www.wpeasycart.com.</p>
                  
				<div><span class="ec_language_row_label">License Version:</span><input type="text"  disabled="disabled" value="Legacy V3 License" /></div><br />
                <div><span class="ec_language_row_label">Registered URL:</span><input type="text"  disabled="disabled" value="<?php echo $license_data->siteurl; ?>" /></div><br />
                  
                <div><span class="ec_language_row_label">Registration Date:</span>  <input type="text"  disabled="disabled" value="<?php echo date("F j, Y, g:i a",strtotime($license_data->date));   ?>"  /></div><br />
                
                <form action="https://www.wpeasycart.com/my-account/"  method="POST" target="_blank" name="wpeasycart_admin_form" id="wpeasycart_admin_form_outside2" novalidate="novalidate">
                	<div class="ec_admin_settings_input"><input type="submit" class="ec_admin_settings_simple_button" value="View Account and Upgrade" ></div>
                </form>
                
                <br />
                
                **You must login with the same WP EasyCart account you used to purchase this license for it to accurately apply credit.
                
                <br />
                
                <hr />
                
                <span> Would you like to deactivate this site license?</span>
                <p>You may enter your original license key and deactivate this site license at anytime. If you are moving to a new server or want to use the license key on a different URL, we make it easy to deactivate your license.  No data is touched during this process.
                <form action="admin.php?page=wp-easycart-registration&subpage=registration&ec_action=deactivateregistration"  method="POST" name="wpeasycart_admin_form" id="wpeasycart_admin_form2" novalidate="novalidate">
                	<div><input type="text" name="transactionkey" id="transactionkey" required="required" ></div>
                	<div class="ec_admin_settings_input"><input type="submit" class="ec_admin_settings_simple_button" value="Deactivate EasyCart License" ></div>
                </form>
                
                <br /><br />
                
                <hr />
                
                <span>Forgot your License Key?  <br />Want to extend Support & Upgrades for EasyCart?</span>
                <p>All of your license keys are available by logging into our website at www.wpeasycart.com and visiting your account.  You can see past orders, license keys, days left of support & upgrades, as well as what sites are reigstered to what license keys.
                <form action="https://www.wpeasycart.com/my-account"  method="POST" target="_blank" name="wpeasycart_admin_form" id="wpeasycart_admin_form_outside3" novalidate="novalidate">
                <div class="ec_admin_settings_input"><input type="submit" class="ec_admin_settings_simple_button" value="Visit WP EasyCart Account" ></div>
                </form>
                
                <br /><br />
                  
               		<?php }else if( $license_data->key_version == 'v4' ){ ?>
				<span style="font-size:32px; font-weight:normal; margin:0 0 10px; display:block;">Your License is Active</span>
				<ul style="list-style:inherit; padding:0 30px; line-height:1.5em;">
					<li>All EasyCart licenses are good for use on <strong>one</strong> WordPress website.</li>
					<li>You may easily transfer your website license to any other website by deactivating your license key.</li>  
					<li>You may also enter your license key into a new website and it will automatically transfer your license to the new site.</li>
				</ul>
                
                <hr />
                
                <span style="font-size:32px; font-weight:normal; margin:25px 0 10px; display:block;">License Information</span>
				<?php 
							wp_easycart_admin_license( )->license_check( );
                			if( wp_easycart_admin_license( )->active_license == false ){ ?>
                <div id='setting-error-settings_updated' class='updated error'><p><strong>Automatic upgrades have expired!  Please visit below to continue to get security patches and upgrades.</strong></p></div><br />
                
				<?php 		}else if( wp_easycart_admin_license( )->active_license == true ){ ?>
                
                <?php 	} ?>
                
                <div><span class="ec_language_row_label">License Version:</span><input type="text"  disabled="disabled" value="V4 License" /></div><br />
                <div><span class="ec_language_row_label">Registered URL:</span><input type="text"  disabled="disabled" value="<?php echo $license_data->siteurl; ?>" /></div><br />
                
                <div><span class="ec_language_row_label">Support & Upgrades End:</span>  <input type="text"  disabled="disabled" value="<?php echo date("F j, Y",strtotime($license_data->support_end_date));   ?>"  /></div><br />
                
                <form action="https://www.wpeasycart.com/my-account/"  method="POST" target="_blank" name="wpeasycart_admin_form" id="wpeasycart_admin_form_outside4" novalidate="novalidate">
                	<div class="ec_admin_settings_input" style="padding:0px;">
                		<input type="submit" class="ec_admin_settings_simple_button" value="View Account and Upgrade" >
                    </div>
                </form>
                
                <br />
                
                **You must login with the same WP EasyCart account you used to purchase this license for it to accurately apply credit.
                
                <br />
                
                <hr />
                
                <span style="font-size:32px; font-weight:normal; margin:25px 0 10px; display:block;">Would you like to deactivate this site license?</span>
                <p>You may enter your original license key and deactivate this site license at anytime.  If you are moving to a new server or want to use the license key on a different URL, we make it easy to deactivate your license.  No data is touched during this process.</p>
                <form action="admin.php?page=wp-easycart-registration&subpage=registration&ec_action=deactivateregistration"  method="POST" name="wpeasycart_admin_form" id="wpeasycart_admin_form3" novalidate="novalidate">
                	<div><input type="text" name="transactionkey" id="transactionkey" required="required" ></div>
                	<div class="ec_admin_settings_input" style="padding:0px;">
                    	<input type="submit" class="ec_admin_settings_simple_button" value="Deactivate EasyCart License" >
                    </div>
                </form>
                
                <br /><br />
                
                <hr />
                
                <span style="font-size:32px; font-weight:normal; margin:25px 0 10px; display:block;">Forgot your License Key?</span>
                <p>All of your license keys are available by logging into our website at <a href="www.wpeasycart.com/my-account" target="_blank">www.wpeasycart.com/my-account</a> and visiting your account. You can see past orders, license keys, days left of support & upgrades, as well as what sites are reigstered to what license keys.</p>
                <form action="https://www.wpeasycart.com/my-account"  method="POST" target="_blank" name="wpeasycart_admin_form" id="wpeasycart_admin_form_outside5" novalidate="novalidate">
                	<div class="ec_admin_settings_input" style="padding:0px;">
                    	<input type="submit" class="ec_admin_settings_simple_button" value="Visit WP EasyCart Account" >
                    </div>
                </form>
                
                <br /><br />
                
                <hr />
                
                <span style="font-size:32px; font-weight:normal; margin:25px 0 10px; display:block;">Extend Support & Upgrades for EasyCart?</span>
                <p>You can always extend your support & upgrades early! Go to <a href="www.wpeasycart.com/my-account" target="_blank">www.wpeasycart.com/my-account</a> and extend your license directly from your account.</p>
                <form action="https://www.wpeasycart.com/my-account"  method="POST" target="_blank" name="wpeasycart_admin_form" id="wpeasycart_admin_form_outside5" novalidate="novalidate">
                	<div class="ec_admin_settings_input" style="padding:0px;">
                    	<input type="submit" class="ec_admin_settings_simple_button" value="Visit WP EasyCart Account" >
                    </div>
                </form>
                
                <br /><br />
            
                <?php } ?>
                
            <?php }else if( $license_status == 'communications_error' ){ ?>
            <div id='setting-error-settings_updated' class='updated error'>
            	<p><strong>Communications Error! Licensing server is down at this time.</strong></p>
            </div>
            <p>Registration and Licensing servers are currently down, check back at a later time.</p>
            <?php } ?>
        </div>
    </div>
</div>
