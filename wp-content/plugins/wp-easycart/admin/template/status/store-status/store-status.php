<div class="ec_admin_list_line_item_fullwidth ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_store_status_loader" ); 
		$status = new wp_easycart_admin_store_status();
	
	?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-generic"></div><span>Store & Server Status</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'store-status', 'settings');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'store-status', 'settings');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
       
 
 
		 <?php
        $isupdate = false;
        if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "store-status" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "send_test_email" ){
            $result = $status->ec_send_test_email( );
            if( $result )
                $isupdate = "1";
            else
                $isupdate = "2";
        }else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "store-status" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "reset_store_permalinks" ){
            $status->ec_reset_store_permalinks( );
            $isupdate = "3";
        }
        ?>
        
        <?php if( $isupdate && $isupdate == "1" ) { ?>
            <div id='setting-error-settings_updated' class='updated settings-success'><p><strong>The receipt has been sent to the customer's email address and the admin.</strong></p></div>
        <?php }else if( $isupdate && $isupdate == "2" ){ ?>
            <div id='setting-error-settings_updated' class='updated settings-success'><p><strong>The order row was not found from the entered order id.</strong></p></div> 
        <?php
        }else if( $isupdate && $isupdate == "3" ){ ?>
            <div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Your store permalinks have been reset.</strong></p></div> 
        <?php
        }
        ///////////////////////////////////////////////
        // Server Status Section
        ///////////////////////////////////////////////
        ?>
        
        <div class="ec_status_header"><div class="ec_status_header_text">Server Settings Status</div></div>
        
        <?php 
        ////////////////////////////
        // PHP Versoin Check
        ////////////////////////////
        if( $status->ec_get_php_version( ) < 5.3 ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">PHP 5.3 is the mimimal version accepted. We do not guarantee functionality for PHP versions below 5.3 at this time.</span></div>
        <?php }else{ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">Your PHP Version is <?php echo  $status->ec_get_php_version( ); ?>, meeting the PHP 5.3 minimal setup.</span></div>
        <?php } ?>
	
		<div class="ec_status_subs ec_status_success"><strong>Common PHP Settings</strong><br /><p>These settings are something you should contact your web hosting company regarding installation of modules and PHP setting adjustments.  This is likely not something EasyCart technicians would be able to assist with.</p><p><i><strong>Note:  EasyCart may operate just fine in some situations with warnings in this section as some modules and settings only affect certain areas or features.  Refer to this section if you begin experiencing problems with EasyCart.</strong></i></p>
    
    	<?php
			// ======= File Uploads =======
			if (ini_get("file_uploads") != "1")
			{
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>File Uploads disabled</div><?php 
			} else {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>File Uploads enabled</div><?php
			}
			// ======= openSSL =======
			$isopenssl = extension_loaded("openssl");
			if (!$isopenssl)
			{
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Open SSL Not Installed</div><?php 
			} else {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>Open SSL Installed</div><?php
			}
			// ======= Curl =======
			$iscurl = extension_loaded("curl");
			if (!$iscurl)
			{
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Curl Not Installed</div><?php 
			} else {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>Curl Installed</div><?php
			}
			// ======= GD =======
			$isgd = extension_loaded("gd");
			if (!$isgd)
			{
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>GD Not Installed</div><?php 
			} else {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>GD Installed</div><?php
			}
			// ======= SOAP =======
			$isSOAP = extension_loaded("SOAP");
			if (!$isSOAP)
			{
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>SOAP Not Installed</div><?php 
			} else {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>SOAP Installed</div><?php
			}
			// ======= MySQL =======
			$isMySQL = extension_loaded("MySQL");
			$isMySQLi = extension_loaded("MySQLi");
			if( !$isMySQL && !$isMySQLi )
			{
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>MySQL Not Installed</div><?php 
			} else {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>MySQL Installed</div><?php
			}
			// ======= XMLRPC =======
			//$isXMLRPC = extension_loaded("XMLRPC");
			//if (!$isXMLRPC)
			//{
			//<div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>XML-RPC Not Installed</div><?php 
			//} else {
			//<div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>XML-RPC Installed</div><?php
			//}
			// ======= Max File Upload Size =======
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>
            Max PHP File Upload Size (Recommended >10M): <?php echo ini_get("upload_max_filesize"); ?>
            </div><?php
			// ======= max_execution_time =======
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>
            Max PHP Execution Time (Recommended >300): <?php echo ini_get("max_execution_time"); ?>
            </div><?php
			// ======= memory_limit =======
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>
            PHP Memory Limit (Recommended >128M): <?php echo ini_get("memory_limit"); ?>
            </div><?php
			// ======= post_max_size =======
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>
            Max PHP Post Size (Recommended >10M): <?php echo ini_get("post_max_size"); ?>
            </div><?php
			/*// ======= Output  Buffering =======
			if (ini_get("output_buffering") == 0)
			{
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Output Buffering OFF</div><?php 
			} if (ini_get("output_buffering") == 1) {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>Output Buffering ON</div><?php
			}
			// ======= oAuth =======
			if (!class_exists( 'OAuth' ))
			{
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>oAuth Not Installed</div><?php 
			} if (class_exists( 'OAuth' )) {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>oAuth Installed</div><?php
			}*/
			// ======= create directory =======
			$to = dirname( __FILE__ ) . "/../../../../testfolder/";
			$success = mkdir( $to, 0777 );
			if( !$success ){
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Failed to Create Directories</div><?php  
			} else {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>Success Creating Directories</div><?php
			}
			// ======= remove directory =======
			if ($success) {
				$to = dirname( __FILE__ ) . "/../../../../testfolder/";
				$remove = rmdir( $to );
				if( !$remove ){
				?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Failed to Remove Directories</div><?php 
				} else {
				?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>Success Removing Directories</div><?php
				}
			} else {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Failed to Remove Directories</div><?php 
			}
			
			// ======= test file write to plugins directory =======
			$ec_test_php = 'test file write'; 
		
			$ec_test_filename = dirname( __FILE__ ) . "/../../../../../testfile.php";
			$ec_test_filehandler = fopen($ec_test_filename, 'w');
			if(!$ec_test_filehandler) {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Failed to Open File in Plugin Directory</div><?php 
			} else {
				if(!fwrite($ec_test_filehandler, $ec_test_php)) {
				?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Failed to Write File to Plugin Directory</div><?php 
				} else {
					if(!fclose($ec_test_filehandler)) {
						?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Failed to Close File in Plugin Directory</div><?php 
						unlink($ec_test_filename);
					} else {
						?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>Success in Writing Files to Plugin Directory</div><?php
						unlink($ec_test_filename);
					}
				}
			}
			
			// ======= test file write to easycart plugin directory =======
			$ec_test_php = 'test file write'; 
		
			$ec_test_filename = dirname( __FILE__ ) . "/../../../../testfile.php";
			$ec_test_filehandler = fopen($ec_test_filename, 'w');
			if(!$ec_test_filehandler) {
			?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Failed to Open File in EasyCart Directory</div><?php 
			} else {
				if(!fwrite($ec_test_filehandler, $ec_test_php)) {
				?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Failed to Write File to EasyCart Directory</div><?php 
				} else {
					if(!fclose($ec_test_filehandler)) {
						?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-warning"></div>Failed to Close File in EasyCart Directory</div><?php 
						unlink($ec_test_filename);
					} else {
						?><div class="ec_status_subtitles"><div class="dashicons-before dashicons-yes"></div>Success in Writing Files to EasyCart Directory</div><?php
						unlink($ec_test_filename);
					}
				}
			}
		?>
        </div>
        <?php
        ///////////////////////////////////////////////
        // EasyCart Status Section
        ///////////////////////////////////////////////
        ?>
        <div class="ec_status_header"><div class="ec_status_header_text">EasyCart Setup Status - <a href="http://docs.wpeasycart.com/wp-easycart-installation-guide/" target="_blank">Click Here</a> for our Installation Guide</div></div>
        <?php
        ////////////////////////////
        // Data Folder Check
        ////////////////////////////
        if( $status->wpeasycart_is_data_folder_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">Data Folders Setup Correctly</span></div>
        <?php }else{ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label"><a href="admin.php?page=wp-easycart-status&subpage=store-status&ec_action=fix_data_folders">Fix Errors</a> <?php echo $status->ec_get_data_folders_error( ); ?></span></div>
        <?php } ?>
        
        <?php
        ////////////////////////////
        // DB Check
        ////////////////////////////
        if( $status->wpeasycart_is_database_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">Database Setup Correctly</span></div>
        <?php }else{ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label"><a href="admin.php?page=wp-easycart-status&subpage=store-status&ec_action=fix_database">Fix Errors</a> <?php echo $status->ec_get_database_error( ); ?></span></div>
        <?php } ?>
        
        <?php
        ////////////////////////////
        // Store Page Setup Check
        ////////////////////////////
        if( $status->ec_is_store_page_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">Store Page Setup &amp; Connected Correctly</span></div>
        <?php }else{ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label"><?php echo $status->ec_get_store_page_error( ); ?></span></div>
        <?php } ?>
        
        <?php
        ////////////////////////////
        // Cart Page Setup Check
        ////////////////////////////
        if( $status->ec_is_cart_page_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">Cart Page Setup &amp; Connected Correctly</span></div>
        <?php }else{ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label"><?php echo $status->ec_get_cart_page_error( ); ?></span></div>
        <?php } ?>
        
        <?php
        ////////////////////////////
        // Account Page Setup Check
        ////////////////////////////
        if( $status->ec_is_account_page_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">Account Page Setup &amp; Connected Correctly</span></div>
        <?php }else{ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label"><?php echo $status->ec_get_account_page_error( ); ?></span></div>
        <?php } ?>
        
        <?php
        ///////////////////////////////////////////////
        // Shipping Status Section
        ///////////////////////////////////////////////
        ?>
        <div class="ec_status_header"><div class="ec_status_header_text">Shipping Status - <a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=shipping-rates" target="_blank">Click Here</a> for Shipping Setup Help</div></div>
        <?php
		
		////////////////////////////
        // No Shipping Check
        ////////////////////////////
        if( $status->ec_using_method_shipping( ) == false && $status->ec_using_live_shipping( ) == false && $status->ec_using_price_shipping( ) == false && $status->ec_using_weight_shipping( ) == false && $status->ec_using_quantity_shipping( ) == false && $status->ec_using_percentage_shipping( ) == false && $status->ec_using_fraktjakt_shipping( ) == false){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">No shipping methods have been setup at this time.</span></div>
        <?php }
		
		
        
		////////////////////////////
        // Price Based Shipping Check
        ////////////////////////////
        if( $status->ec_using_price_shipping( ) && $status->ec_price_shipping_setup( )  ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup price based shipping.</span></div>
        <?php }else if( $status->ec_using_price_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">You have chosen to use price based shipping, but there doesn't appear to be any price triggers setup.</span></div>
        <?php }
        
        ////////////////////////////
        // Weight Based Shipping Check
        ////////////////////////////
        if( $status->ec_using_weight_shipping( ) && $status->ec_weight_shipping_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup weight based shipping.</span></div>
        <?php }else if( $status->ec_using_weight_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">You have chosen to use weight based shipping, but there doesn't appear to be any weight triggers setup.</span></div>
        <?php }
        
        ////////////////////////////
        // Quantity Based Shipping Check
        ////////////////////////////
        if( $status->ec_using_quantity_shipping( ) && $status->ec_quantity_shipping_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup quantity based shipping.</span></div>
        <?php }else if( $status->ec_using_quantity_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">You have chosen to use quantity based shipping, but there doesn't appear to be any quantity triggers setup.</span></div>
        <?php }
        
        ////////////////////////////
        // Percentage Based Shipping Check
        ////////////////////////////
        if( $status->ec_using_percentage_shipping( ) && $status->ec_percentage_shipping_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup percentage based shipping.</span></div>
        <?php }else if( $status->ec_using_percentage_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">You have chosen to use percentage based shipping, but there doesn't appear to be any percentage triggers setup.</span></div>
        <?php }
        
        ////////////////////////////
        // Method Based Shipping Check
        ////////////////////////////
        if( $status->ec_using_method_shipping( ) && $status->ec_method_shipping_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup method based shipping.</span></div>
        <?php }else if( $status->ec_using_method_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">You have chosen to use method based shipping, but there doesn't appear to be any method triggers setup.</span></div>
        <?php }
        
        ////////////////////////////
        // Live Based Shipping Check
        ////////////////////////////
        if( $status->ec_using_live_shipping( ) && !$status->ec_live_shipping_setup( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">You have live shipping selected, but no rates are setup.</span></div>
        <?php }
        
        ////////////////////////////
        // UPS Shipping Check
        ////////////////////////////
        if( $status->ec_using_live_shipping( ) && $status->ec_using_ups_shipping( ) && $status->ec_ups_shipping_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup UPS live shipping.</span></div>
        <?php }else if( $status->ec_using_live_shipping( ) && $status->ec_using_ups_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">UPS live shipping setup incorrectly.</span></div>
        <?php }
        
        ////////////////////////////
        // USPS Shipping Check
        ////////////////////////////
        if( $status->ec_using_live_shipping( ) && $status->ec_using_usps_shipping( ) && $status->ec_usps_shipping_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup USPS live shipping.</span></div>
        <?php }else if( $status->ec_using_live_shipping( ) && $status->ec_using_usps_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">USPS live shipping setup incorrectly.</span></div>
        <?php }
        
        ////////////////////////////
        // FEDEX Shipping Check
        ////////////////////////////
        if( $status->ec_using_live_shipping( ) && $status->ec_using_fedex_shipping( ) && $status->ec_fedex_shipping_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup FedEx live shipping.</span></div>
        <?php }else if( $status->ec_using_live_shipping( ) && $status->ec_using_fedex_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">FedEx live shipping setup incorrectly.</span></div>
        <?php }
        
        ////////////////////////////
        // DHL Shipping Check
        ////////////////////////////
        if( $status->ec_using_live_shipping( ) && $status->ec_using_dhl_shipping( ) && $status->ec_dhl_shipping_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup DHL live shipping.</span></div>
        <?php }else if( $status->ec_using_live_shipping( ) && $status->ec_using_dhl_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">DHL live shipping setup incorrectly.</span></div>
        <?php }
        
        ////////////////////////////
        // AUSPOST Shipping Check
        ////////////////////////////
        if( $status->ec_using_live_shipping( ) && $status->ec_using_auspost_shipping( ) && $status->ec_auspost_shipping_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup Australia Post live shipping.</span></div>
        <?php }else if( $status->ec_using_live_shipping( ) && $status->ec_using_auspost_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">Australia Post live shipping setup incorrectly.</span></div>
        <?php } 
        
        ////////////////////////////
        // Canada Post Shipping Check
        ////////////////////////////
        if( $status->ec_using_live_shipping( ) && $status->ec_using_canadapost_shipping( ) && $status->ec_canadapost_shipping_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup Canada Post live shipping.</span></div>
        <?php }else if( $status->ec_using_live_shipping( ) && $status->ec_using_canadapost_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">Canada Post live shipping setup incorrectly.</span></div>
        <?php } 
        
        ////////////////////////////
        // Fraktjakt Shipping Check
        ////////////////////////////
        if( $status->ec_using_fraktjakt_shipping( ) && $status->ec_fraktjakt_shipping_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully setup Fraktjakt live shipping.</span></div>
        <?php }else if( $status->ec_using_fraktjakt_shipping( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">Fraktjakt live shipping is setup incorrectly.</span></div>
        <?php } 
        
		
		
		
		
		
		
		
		
		
		
        ///////////////////////////////////////////////
        // Tax Status Section
        ///////////////////////////////////////////////
        ?>
        
        <div class="ec_status_header"><div class="ec_status_header_text">Tax Status - <a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=taxes" target="_blank">Click Here</a> for Tax Setup Help</div></div>
        
        <?php 
        ////////////////////////////
        // No Tax Check
        ////////////////////////////
        if( $status->ec_using_no_tax( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You are setup to use no tax structure, this can be changed in the Store Admin -> Rates -> Tax Rates panel.</span></div>
        <?php }
        
        ////////////////////////////
        // State Tax Check
        ////////////////////////////
        if( $status->ec_using_state_tax( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully configured state/province taxes.</span></div>
        <?php }
        
        ////////////////////////////
        // Country Tax Check
        ////////////////////////////
        if( $status->ec_using_country_tax( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully configured country taxes.</span></div>
        <?php }
        
        ////////////////////////////
        // Gloabl Tax Check
        ////////////////////////////
        if( $status->ec_using_global_tax( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully configured global taxes.</span></div>
        <?php }
        
        ////////////////////////////
        // Duty Tax Check
        ////////////////////////////
        if( $status->ec_using_duty_tax( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully configured customs duty or export taxes.</span></div>
        <?php }
        
        ////////////////////////////
        // VAT Tax Check
        ////////////////////////////
        if( $status->ec_using_vat_tax( ) && $status->ec_global_vat_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have successfully configured VAT.</span></div>
        <?php }else if( $status->ec_using_vat_tax( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">You have selected to use VAT, but have not entered a rate and/or have not set any individual country rates.</span></div>
        <?php } ?>
        
        
        
        
        <div class="ec_status_header">
            <div class="ec_status_header_text">Payment Status - 
            	<a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=payment" target="_blank">Click Here</a> for Payment Setup Help
            </div>
        </div>
        <?php

		///////////////////////////////////////////////
        // Payment Status Section
        ///////////////////////////////////////////////
        
        ////////////////////////////
        // No Payment Type Selected Check
        ////////////////////////////
        if( $status->ec_no_payment_selected( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">You have not selected a payment method, the checkout process cannot be completed by your customers at this time.</span></div>
        <?php } 
        
        ////////////////////////////
        // Manual Payment Type Selected Check
        ////////////////////////////
        if( $status->ec_manual_payment_selected( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have setup your store to use manual payment. This method requires your customer to send a check or direct deposit before shipping.</span></div>
        <?php } 
        
        ////////////////////////////
        // Third Party Payment Type Selected Check
        ////////////////////////////
        if( $status->ec_third_party_payment_selected( ) && $status->ec_third_party_payment_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have selected to use <?php echo $status->ec_get_third_party_method( ); ?> as a third party payment method and you have entered all necessary info.</span></div>
        <?php }else if( $status->ec_third_party_payment_selected( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">You have selected <?php echo $status->ec_get_third_party_method( ); ?> , but have missed some necessary info. Go to WP EasyCart -> Settings -> Payment to resolve this.</span></div>
        <?php } 
        
        ////////////////////////////
        // Live Payment Type Selected Check
        ////////////////////////////
        if( $status->ec_live_payment_selected( ) && $status->ec_live_payment_setup( ) ){ ?>
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">You have selected to use <?php echo $status->ec_get_live_payment_method( ); ?> as a live payment method and you have entered all necessary info.</span></div>
        <?php }else if( $status->ec_live_payment_selected( ) ){ ?>
        <div class="ec_status_error"><div class="dashicons-before dashicons-no"></div><span class="ec_status_label">You have selected <?php echo $status->ec_get_live_payment_method( ); ?> , but have missed some necessary info. Go to WP EasyCart -> Settings -> Payment to resolve this.</span></div>
        <?php } 
        
        
        
        
        
        
        
        ////////////////////////////
        // MISCELLANEOUS
        ////////////////////////////
		?>
        <div class="ec_status_header"><div class="ec_status_header_text">Miscellaneous</div></div>
        <?php
        ////////////////////////////
        // Provide fix for custom post type links
        ////////////////////////////
        ?>
        
        <div class="ec_status_success"><div class="dashicons-before dashicons-yes"></div><span class="ec_status_label">If you are having problems with store links, <a href="admin.php?page=wp-easycart-status&subpage=store-status&ec_action=reset_store_permalinks">reset permalinks</a> | <a href="admin.php?page=wp-easycart-status&subpage=store-status&ec_action=reset_store_permalinks&ec_reset_phase2=true">rebuild permalinks</a></span></div>
        
            
        
  
    </div>
</div>
           
           
