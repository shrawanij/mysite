<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_design_store_colors" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-appearance"></div><span>Store Colors</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'design', 'colors');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'design', 'colors');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
	
    <div>
    	<span class="ec_colorizer_row_label">Main Color: </span>
        <span class="ec_colorizer_row_input"><input type="color" name="ec_option_details_main_color" id="ec_option_details_main_color" value="<?php echo get_option( 'ec_option_details_main_color' ); ?>" class="ec_color_block_input" style="width:45px;" /></span>
    </div>
    
    <div>
        <span class="ec_colorizer_row_label">Second Color: </span>
        <span class="ec_colorizer_row_input"><input type="color" name="ec_option_details_second_color" id="ec_option_details_second_color" value="<?php echo get_option( 'ec_option_details_second_color' ); ?>" class="ec_color_block_input" style="width:45px;" /></span>
    </div>
    
    <div class="ec_colorizer_select">Theme Background Color (EX: Dark Background produces light text):
        	<select name="ec_option_use_dark_bg" id="ec_option_use_dark_bg">
    			<option value="1"<?php if( get_option( 'ec_option_use_dark_bg' ) == "1" ){?> selected="selected"<?php }?>>Dark Background</option>
        	    <option value="0"<?php if( get_option( 'ec_option_use_dark_bg' ) == "0" ){?> selected="selected"<?php }?>>Light Background</option>
    		</select>

    </div>
       	
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_store_colors( );" value="Save Options" />
        </div>
    </div>
</div>