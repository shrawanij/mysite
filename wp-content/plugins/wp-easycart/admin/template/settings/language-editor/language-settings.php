<div class="ec_admin_list_line_item_fullwidth ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_language_editor_loader" ); 
	
		$validate = new ec_validation; 
		$license = new ec_license;
		$language = new ec_language( );
		$language->update_language_data( ); //Do this to update the database if a new language is added
		
		if( !get_option( 'ec_option_use_seperate_language_forms' ) )
			update_option( 'ec_option_use_seperate_language_forms', 1 );
			
		if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "language-editor" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "update_language" && isset( $_POST['ec_option_language '] ) ){
			ec_update_language_file( $language );
		
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "language-editor" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "update-selected-language" && isset( $_POST['ec_option_language'] ) ){
			update_option( 'ec_option_language', $_POST['ec_option_language'] );
		
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "language-editor" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "delete-language" && isset( $_GET['ec_language'] ) ){
			$language->remove_language( $_GET['ec_language'] );
		
		}else if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "language-editor" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "add-new-language" && isset( $_POST['ec_option_add_language'] ) ){
			$language->add_new_language( $_POST['ec_option_add_language'] );
		}
	
	
	?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-generic"></div><span>Installed Languages</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'language-editor', 'installed-languages');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'language-editor', 'installed-languages');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section ec_admin_settings_language_section">
   		
        <span>Add Languages to EasyCart</span>
        
        <form method="post" action="admin.php?page=wp-easycart-settings&subpage=language-editor&ec_action=add-new-language" name="wpeasycart_admin_form" id="wpeasycart_admin_form_lang1" novalidate="novalidate">
            <div><select name="ec_option_add_language" id="ec_option_add_language">
                <?php 
                $add_count = 0;
                $language_file_list = $language->get_language_file_list( );
                $languages = $language->get_languages_array( );
                $language_data = $language->get_language_data( );
                for( $i=0; $i<count( $language_file_list ); $i++ ){ 
                    $file_name = $language_file_list[$i];
                    if( !in_array( $file_name, $languages ) ){
                ?>
                    <option value="<?php echo $file_name; ?>" <?php if( get_option( 'ec_option_language' ) == $file_name ) echo ' selected'; ?>><?php echo $language_file_list[$i]; ?></option>
                <?php
                    $add_count++;
                    }
                }
                if( $add_count == 0 ){ ?>
                <option value="">No New Languages</option>
                <?php } ?>
                </select> 
                <?php if( $add_count > 0 ){ ?>
                <div class="ec_admin_language_add"><input type="submit" class="ec_admin_settings_simple_button" value="Add" /></div>
                <?php }?>
            </div>
        </form>
        
        <span>Currently Installed Languages</span><br />
        <?php foreach( $language_data as $key => $data ){ ?>
            <div class="ec_language_settings ec_language_settings_edit_row">
                <span class="ec_language_setting_row_label"><?php echo $data->label; ?> | <a href="admin.php?page=wp-easycart-settings&subpage=language-editor&ec_action=delete-language&ec_language=<?php echo $key; ?>">delete </a></span>
            </div>
        <?php } ?>
        
        
        </div></div>
        <div class="ec_admin_list_line_item_fullwidth ec_admin_demo_data_line">
        <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-generic"></div><span>Current Language to Edit</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'language-editor', 'current-language');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
        <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'language-editor', 'current-language');?></div>
   			 <div class="ec_admin_settings_input ec_admin_settings_live_payment_section ec_admin_settings_language_section">
    
        <span>Select Language to Edit</span>
        <form method="post" action="admin.php?page=wp-easycart-settings&subpage=language-editor&ec_action=update-selected-language">
            <div><select name="ec_option_language" id="ec_option_language">
                <?php 
                for( $i=0; $i<count( $languages ); $i++ ){ 
                    $file_name = $languages[$i];
                ?>
                    <option value="<?php echo $file_name; ?>" <?php if( get_option( 'ec_option_language' ) == $file_name ) echo ' selected'; ?>><?php echo $language_data->{$file_name}->label; ?></option>
                <?php }?>
                </select> 
            </div>  
               <div class="ec_admin_language_add"><input type="submit" class="ec_admin_settings_simple_button" value="Select Language" /></div>
          
        </form>
        
        
        <?php 
        $file_name = get_option( 'ec_option_language' );
		
        ?>
        <a href="admin.php?page=wp-easycart-settings&subpage=language-editor&ec_action=export-language&ec_language=<?php echo $file_name; ?>">Export <?php echo $language_data->{$file_name}->label; ?> File</a>
        
   </div>    	
</div>
<div class="current_language_title">Editing <?php echo $language_data->{$file_name}->label; ?></div>