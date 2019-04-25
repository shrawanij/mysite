<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_design_template_settings_loader" ); 
		$design_file_updated = false;
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "design" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "upload_design_files" && isset( $_FILES["theme_file"] ) ){
		$design_class = new wp_easycart_admin_design;
		$design_class = $design_class->ec_design_file_uploads( );
		$design_file_updated = true;
	}
	
	?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-welcome-add-page"></div><span>Design Template System</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'design', 'templates');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'design', 'templates');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
	
		<div>Choose EasyCart Theme System: <select name="ec_option_base_theme" id="ec_option_base_theme">
    				<option value="0"<?php if( get_option('ec_option_base_theme') == "0" ){ ?> selected="selected"<?php }?>>No Child Theme</option>
		          <?php
						if( is_dir( '../wp-content/plugins/wp-easycart-data/' ) )
							$dir = '../wp-content/plugins/wp-easycart-data/design/theme/';
						else
							$dir = '../wp-content/plugins/wp-easycart/design/theme/';
						
						$scan = scandir( $dir );
						foreach( $scan as $key => $val ) {
							
							if ( is_dir( $dir . "/" . $val ) ) {
								if($val != "." && $val != ".."){
									echo "<option value=\"".$val."\"";
									if( get_option('ec_option_base_theme') == $val){ 
										echo " selected=\"selected\"";
									}
									
									echo ">" . $val . "</option>\n";
								}
							}
							
						}
						?>
		          </select>
        </div>
        
        <div>Choose EasyCart Layout System: <select name="ec_option_base_layout" id="ec_option_base_layout">
    				<option value="0"<?php if( get_option('ec_option_base_layout') == "0" ){ ?> selected="selected"<?php }?>>No Child Theme</option>
		          <?php
						if( is_dir( '../wp-content/plugins/wp-easycart-data/' ) )
							$dir = '../wp-content/plugins/wp-easycart-data/design/layout/';
						else
							$dir = '../wp-content/plugins/wp-easycart/design/layout/';
							
						$scan = scandir( $dir );
						foreach( $scan as $key => $val ) {
							
							if ( is_dir( $dir . "/" . $val ) ) {
								if($val != "." && $val != ".."){
									echo "<option value=\"".$val."\"";
									if( get_option('ec_option_base_layout') == $val){ 
										echo " selected=\"selected\"";
									}
									
									echo ">" . $val . "</option>\n";
								}
							}
							
						}
						?>
		          </select>
        </div>
        
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_design_template_settings( );" value="Save Options" />
        </div>

    </div>
</div>