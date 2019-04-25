<form action="<?php echo $this->action; ?>"  method="POST" id="wpeasycart_admin_form" name="wpeasycart_admin_form" novalidate="novalidate">
<input type="hidden" name="ec_admin_form_action" value="<?php echo $this->form_action; ?>" />
<input type="hidden" name="role_id" value="<?php echo $this->user_role->role_id; ?>" />

<div class="ec_admin_settings_panel ec_admin_details_panel">
    <div class="ec_admin_important_numbered_list">
        <div class="ec_admin_flex_row">
            <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first">
            
                <div class="ec_admin_settings_label">
                    <div class="dashicons-before dashicons-admin-users"></div>
                    <span><?php if( isset( $_GET['ec_admin_form_action'] ) && $_GET['ec_admin_form_action'] == 'add-new' ){ echo 'ADD NEW'; }else{ echo 'EDIT'; } ?> USER ROLE</span>
                    <div class="ec_page_title_button_wrap">
                        <a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                        <a href="<?php echo $this->action; ?>" class="ec_page_title_button">Cancel</a>
                        <input type="submit" value="Save" onclick="return wpeasycart_admin_validate_form( )" class="ec_page_title_button">
                    </div>
                </div>
            
                <div class="ec_admin_settings_input ec_admin_settings_currency_section">
                	<div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">User Role Setup<br></div>
                    <div id="ec_admin_row_heading_message" class="ec_admin_row_heading_message"><p>You may setup user roles so that pricing of products and store access can be limited to a select group of accounts or individuals.  Establish a user role, edit accounts to be a part of this user role, and lock the store down to only these users or adjust product price using user roles.</p></div>
					<?php do_action( 'wp_easycart_admin_user_role_details_basic_fields' ); ?>
                </div>
            </div>
        </div>
        <div class="ec_admin_flex_row">
            <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first">
            
                <div class="ec_admin_settings_label">
                    <div class="dashicons-before dashicons-admin-users"></div>
                    <span>Remote User Access</span>
                    <div class="ec_page_title_button_wrap">
                        <a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                    </div>
                </div>
            
                <div class="ec_admin_settings_input ec_admin_settings_currency_section">
                	<?php do_action( 'wp_easycart_admin_user_role_details_remote_access_fields' ); ?>
                </div>
            </div>
        </div>
      	<div class="ec_admin_details_footer">
            <div class="ec_page_title_button_wrap">
                <a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                <a href="<?php echo $this->action; ?>" class="ec_page_title_button">Cancel</a>
                <input type="submit" value="Save" onclick="return wpeasycart_admin_validate_form( )" class="ec_page_title_button">
            </div>
        </div>  
    </div>
</div>
</form>