<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_cart_design_options" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-cart"></div><span>Cart Design Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'design', 'cart');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'design', 'cart');?>
    </div>
    <div class="ec_admin_settings_input ec_admin_settings_currency_section">
        <span>Cart Page Columns</span>
       
        <div>Desktop: <select name="ec_option_cart_columns_desktop" id="ec_option_cart_columns_desktop">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_desktop' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_desktop' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </div>
        
        <div>Tablet Landscape: <select name="ec_option_cart_columns_laptop" id="ec_option_cart_columns_laptop">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_laptop' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_laptop' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </div>
        
        
        <div>Tablet Portrait: <select name="ec_option_cart_columns_tablet_wide" id="ec_option_cart_columns_tablet_wide">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_tablet_wide' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_tablet_wide' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </div>
        
        <div>Phone Landscape: <select name="ec_option_cart_columns_tablet" id="ec_option_cart_columns_tablet">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_tablet' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_tablet' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </div>
        
        
        <div>Phone Portrait: <select name="ec_option_cart_columns_smartphone" id="ec_option_cart_columns_smartphone">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_smartphone' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_smartphone' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </div>
       
       
        </div>
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_cart_design_options( );" value="Save Options" />
    </div>
</div>