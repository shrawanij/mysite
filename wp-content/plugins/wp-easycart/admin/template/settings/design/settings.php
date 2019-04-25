<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_design_settings_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-generic"></div><span>Design Settings</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'design', 'settings');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'design', 'settings');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        <div><input type="checkbox" name="ec_option_no_rounded_corners" id="ec_option_no_rounded_corners" value="0"<?php if( !get_option( 'ec_option_no_rounded_corners' ) ){ echo " checked=\"checked\""; }?> /> Display Rounded Corners on Cart</div>
        <div>WP EasyCart Font:
        <?php 
		$gfonts_str = file_get_contents( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/design/google-fonts.json' ); 
		$gfonts = json_decode( $gfonts_str );
		?>
        <select name="ec_option_font_main" id="ec_option_font_main">
        	<option value="0">Use Default</option>
            <?php foreach( $gfonts->items as $font ){ ?>
            <option value="<?php echo $font->family; ?>"<?php if( get_option( 'ec_option_font_main' ) == $font->family ){ ?> selected="selected"<?php }?>><?php echo $font->family; ?></option>
            <?php }?>
        </select>
        </div>
        <div><a href="https://fonts.google.com" target="_blank">View Google Fonts</a></div>
        <div><input type="checkbox" name="ec_option_hide_live_editor" id="ec_option_hide_live_editor" value="0"<?php if( get_option('ec_option_hide_live_editor') == "1" ){ echo " checked=\"checked\""; }?> /> Hide Live Design Editor on Frontend</div>
        <div><input type="checkbox" name="ec_option_use_custom_post_theme_template" id="ec_option_use_custom_post_theme_template" value="0"<?php if( get_option('ec_option_use_custom_post_theme_template') == "1" ){ echo " checked=\"checked\""; }?> /> Use Theme Custom Post Template</div>
        <div><input type="checkbox" name="ec_option_match_store_meta" id="ec_option_match_store_meta" value="0"<?php if( get_option('ec_option_match_store_meta') == "1" ){ echo " checked=\"checked\""; }?> /> Match Store Page Meta</div>

        
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_design_settings( );" value="Save Options" />
        </div>
    </div>
</div>