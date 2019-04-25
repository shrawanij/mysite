<form action="<?php echo $this->action; ?>"  method="POST" id="wpeasycart_admin_form" name="wpeasycart_admin_form" novalidate="novalidate">
<input type="hidden" name="ec_admin_form_action" value="<?php echo $this->form_action; ?>" />
<input type="hidden" name="user_id" value="<?php echo $this->user->user_id; ?>" />

<div class="ec_admin_settings_panel ec_admin_details_panel">
    <div class="ec_admin_important_numbered_list">
        
        
        
        <div class="ec_admin_flex_row">
            <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first">
            
                <div class="ec_admin_settings_label">
                    <div class="dashicons-before dashicons-admin-users"></div>
                    <span><?php if( isset( $_GET['ec_admin_form_action'] ) && $_GET['ec_admin_form_action'] == 'add-new' ){ echo 'ADD NEW'; }else{ echo 'EDIT'; } ?> USER ACCOUNT</span>
                    <div class="ec_page_title_button_wrap">
                        <a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                        <?php if( !isset( $_GET['ec_admin_form_action'] ) || $_GET['ec_admin_form_action'] != "add-new" ){ ?>
                        <a href="admin.php?page=wp-easycart-orders&subpage=orders&filter_2=<?php echo $this->user->user_id; ?>" class="ec_page_title_button">View Orders</a>
                        <a href="admin.php?page=wp-easycart-users&subpage=accounts&ec_admin_form_action=user-login-override&user_id=<?php echo $this->user->user_id; ?>" class="ec_page_title_button">Login as User</a>
                        <?php }?>
                        <a href="<?php echo $this->action; ?>" class="ec_page_title_button">Cancel</a>
                        <input type="submit" value="Save" onclick="return wpeasycart_admin_validate_form( )" class="ec_page_title_button">
                    </div>
                </div>
            
                <div class="ec_admin_settings_input ec_admin_settings_currency_section">
                	<div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">User Account Setup<br></div>
                    <div id="ec_admin_row_heading_message" class="ec_admin_row_heading_message"><p>EasyCart user accounts can store their billing and shipping address information as well as important shipping, tax, and user role preferences.</p></div>
					<?php do_action( 'wp_easycart_admin_user_details_basic_fields' ); ?>
                </div>
            </div>
        </div>
        
        
        
        <div class="ec_admin_flex_row">
            <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first">
            
                <div class="ec_admin_settings_label">
                    <div class="dashicons-before dashicons-admin-users"></div>
                    <span>EDIT OPTIONAL ACCOUNT SETTINGS</span>
                    <div class="ec_page_title_button_wrap">
                        <a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                    </div>
                </div>
            
                <div class="ec_admin_settings_input ec_admin_settings_currency_section">
                	<div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Optional User Account Settings<br></div>
                    <div id="ec_admin_row_heading_message" class="ec_admin_row_heading_message"><p>You may add various optional components to this account such as exclude them from shipping and taxes. You may also add administrative notes or VAT registration numbers depending on your needs.</p></div>
					<?php do_action( 'wp_easycart_admin_user_details_optional_fields' ); ?>
                </div>
            </div>
        </div>
        
        
        
        <div class="ec_admin_flex_row">
            <div class="ec_admin_list_line_item ec_admin_col_6 ec_admin_col_first">
            
                <div class="ec_admin_settings_label">
                    <div class="dashicons-before dashicons-admin-users"></div>
                    <span>EDIT BILLING ADDRESS</span>
                    <div class="ec_page_title_button_wrap">
                    	<a  class="ec_page_title_button" onclick="copy_to_shipping();">Copy to Shipping</a>
                        <a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                    </div>
                </div>
            
                <div class="ec_admin_settings_input ec_admin_settings_currency_section">
                	<?php do_action( 'wp_easycart_admin_user_details_billing_fields' ); ?>
                </div>
            </div>
            
            <div class="ec_admin_list_line_item ec_admin_col_6 ec_admin_col_last">
            
                <div class="ec_admin_settings_label">
                    <div class="dashicons-before dashicons-admin-users"></div>
                    <span>EDIT SHIPPING ADDRESS</span>
                    <div class="ec_page_title_button_wrap">
                        <a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                    </div>
                </div>
            
                <div class="ec_admin_settings_input ec_admin_settings_currency_section">
                	<?php do_action( 'wp_easycart_admin_user_details_shipping_fields' ); ?>
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