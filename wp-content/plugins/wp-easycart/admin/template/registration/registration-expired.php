<div class="ec_admin_settings_panel  ec_admin_settings_shipping_section"   id="live">
  <div class="ec_admin_important_numbered_list_fullwidth">
    <div class="ec_admin_list_line_item_fullwidth ec_admin_demo_data_line">
      <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_upgrade_loader" ); 
                $status = new wp_easycart_admin_store_status();
            
            ?>
      <div class="ec_admin_settings_label">
        <div class="dashicons-before dashicons-lock"></div>
        <span>Support & Upgrade Registration Expired</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'registration', 'expired');?>" target="_blank" class="ec_help_icon_link">
        <div class="dashicons-before ec_help_icon dashicons-info"></div>
        </a>
        <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'registration', 'expired');?></div>
        <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
      
      
      <div>
      <p>Our records indicate that your EasyCart support & upgrades are not active and have expired.  In order to continue using Professional version features, you are required to have active support & updates with EasyCart.</p>
      <p align="center"><strong>The process is simple!  Login to EasyCart Account -> Purchase Renewal Credits -> access to this section will be open.</strong></p> 
      <p>Please allow a few minutes for your support & upgrade purchase to process and begin working.  Once you are current with support & upgrades, all Professional admin panels will open for your access.  You may view and verify your account at www.wpeasycart.com  </p> 
      </div>
      
       <div align="center">
       <form action="https://www.wpeasycart.com/my-account"  method="POST" target="_blank" name="wpeasycart_admin_form" id="wpeasycart_admin_form" novalidate="novalidate">
               <div class="ec_admin_settings_input"><input type="submit" class="ec_admin_settings_simple_button" value="Visit WP EasyCart Account to Renew" ></div>
              </form><br /><br /></div>
      </div><br /><br />
      
       
    </div>
  </div>
</div>
