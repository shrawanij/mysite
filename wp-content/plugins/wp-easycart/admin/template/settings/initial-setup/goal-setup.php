<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_goal_setup" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-cart"></div><span>eCommerce Goals</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'initial-setup', 'goals');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
     <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'initial-setup', 'goals');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_currency_section">
        <span>Setup a monthly goal for your eCommerce project.</span>
       
        <div>Enable Sidebar Visual: <select name="ec_option_admin_display_sales_goal" id="ec_option_admin_display_sales_goal">
                <option value="1"<?php if( get_option( 'ec_option_admin_display_sales_goal' ) == '1' ){ echo " selected='selected'"; }?>>Yes</option>
                <option value="0"<?php if( get_option( 'ec_option_admin_display_sales_goal' ) == '0' ){ echo " selected='selected'"; }?>>No</option>
        	</select>
        </div>
        
        <div>Monthly Goal ($): <input name="ec_option_admin_sales_goal" id="ec_option_admin_sales_goal" type="number" value="<?php if( get_option( 'ec_option_admin_sales_goal' ) ){ echo get_option( 'ec_option_admin_sales_goal'); }else{ echo "1000"; } ?>" style="width:40px;" />
       </div>

       
        </div>
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_goals_setup( );" value="Save Options" />
    </div>
</div>