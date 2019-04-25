<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_order_receipt_language_loader" ); 
		$language = new ec_language( );
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "email-setup" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_language" ){
			$language->update_language_data( );
			$isupdate = "5";
		}
	
	?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-testimonial"></div><span>Order Receipt Phrases</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'email-setup', 'order-receipt-language');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'email-setup', 'order-receipt-language');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
    
    	<?php if( isset($isupdate) && $isupdate == "5" ) { ?>
            <div  class="ec_save_success"><span>Updated Successfully!</span></div>
        <?php } ?>
		
   		<?php
		$file_name = get_option( 'ec_option_language' );
		$key_section = 'cart_success';
		$language_section = $language->language_data->{$file_name}->options->{$key_section};
		$section_label = $language_section->label;
		?>
        
        <form action="admin.php?page=wp-easycart-settings&subpage=email-setup&ec_action=save_language" method="POST">
        
        <input type="hidden" name="file_name" value="<?php echo $file_name; ?>" />
        <input type="hidden" name="key_section" value="<?php echo $key_section; ?>" />
        <input type="hidden" name="isupdate" value="1" />
        
		
			<?php
            foreach( $language_section->options as $key => $language_item ){
				$title = $language_item->title;
				$value = $language_item->value;
				?>
				<div> <?php echo $title; ?>: <input  class="language_input" name="ec_language_field[<?php echo $key; ?>]" id="ec_language_field[<?php echo $key; ?>]" type="text" value="<?php echo $value; ?>" style="width:100%;" />
                </div>
            <?php }?>
        	
        
      
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button"  value="Save Options" />
            
         </form>  
        </div> 
    </div>
</div>