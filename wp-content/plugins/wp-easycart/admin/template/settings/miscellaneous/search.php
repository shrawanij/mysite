<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_miscellaneous_search_options_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-search"></div><span>Search Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'additional-settings', 'search-options');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'additional-settings', 'search-options');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        <div><input type="checkbox" name="ec_option_use_live_search" id="ec_option_use_live_search" value="0"<?php if( get_option('ec_option_use_live_search') == "1" ){ echo " checked=\"checked\""; }?> /> Use Live Search</div>
    	<div><input type="checkbox" name="ec_option_search_title" id="ec_option_search_title" value="1"<?php if( get_option('ec_option_search_title') == "1" ){ echo " checked=\"checked\""; }?> /> Search Includes Title</div>
        <div><input type="checkbox" name="ec_option_search_model_number" id="ec_option_search_model_number" value="1"<?php if( get_option('ec_option_search_model_number') == "1" ){ echo " checked=\"checked\""; }?> /> Search Includes Model Number</div>
        <div><input type="checkbox" name="ec_option_search_manufacturer" id="ec_option_search_manufacturer" value="1"<?php if( get_option('ec_option_search_manufacturer') == "1" ){ echo " checked=\"checked\""; }?> /> Search Includes Manufacturer</div>
        <div><input type="checkbox" name="ec_option_search_description" id="ec_option_search_description" value="1"<?php if( get_option('ec_option_search_description') == "1" ){ echo " checked=\"checked\""; }?> /> Search Includes Description</div>
        <div><input type="checkbox" name="ec_option_search_short_description" id="ec_option_search_short_description" value="1"<?php if( get_option('ec_option_search_short_description') == "1" ){ echo " checked=\"checked\""; }?> /> Search Includes Short Description</div>
        <div><input type="checkbox" name="ec_option_search_menu" id="ec_option_search_menu" value="1"<?php if( get_option('ec_option_search_menu') == "1" ){ echo " checked=\"checked\""; }?> /> Search Includes Menu Items</div>
        <div><input type="checkbox" name="ec_option_search_by_or" id="ec_option_search_by_or" value="1"<?php if( get_option('ec_option_search_by_or') == "1" ){ echo " checked=\"checked\""; }?> /> Search each Term for More Results</div>
    	
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_search_options( );" value="Save Options" />
        </div>
    </div>
</div>