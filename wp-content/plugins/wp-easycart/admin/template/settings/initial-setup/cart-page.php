<div class="ec_admin_list_line_item">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_cartpage_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-cart"></div><span>Cart Display Page</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'initial-setup', 'cart-page');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'initial-setup', 'cart-page');?></div>
    <div class="ec_admin_settings_input">
        <span>Choose a Main Display Page</span>
        <?php wp_dropdown_pages( array(
                                    'name'				=> 'ec_option_cartpage', 
                                    'selected' 			=> get_option( 'ec_option_cartpage' ),
                                    'show_option_none'	=> 'Select a Page',
                                    'option_none_value'	=> '',
                                    'sort_order'   		=> 'ASC',
                                    'sort_column'  		=> 'post_title'
                                 )
        ); ?>
    </div>
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_cartpage_setup( );" value="Save Selection" />
        <span class="ec_admin_settings_simple_button"><a href="admin.php?page=wp-easycart-settings&subpage=initial-setup&action=easycart-add-cartpage" onclick="return ec_admin_create_cartpage( );">Create New Cart Page</a></span>
    </div>
    
</div>