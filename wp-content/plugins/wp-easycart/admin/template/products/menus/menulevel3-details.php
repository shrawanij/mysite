<form action="<?php echo $this->action; ?>"  method="POST" name="wpeasycart_admin_form" id="wpeasycart_admin_form" novalidate="novalidate">
<input type="hidden" name="ec_admin_form_action" value="<?php echo $this->form_action; ?>" />
<?php
	if(isset($_GET['menulevel2_id'])) {
		$menulevel2_id = $_GET['menulevel2_id'];
	} else {
		global $wpdb;
		$menulevel2_id = $wpdb->get_var( $wpdb->prepare( "SELECT ec_menulevel3.menulevel2_id FROM ec_menulevel3 WHERE ec_menulevel3.menulevel3_id = %d", $_GET['menulevel3_id'] ) );	
	}
?>
<input type="hidden" name="menulevel2_id" value="<?php echo $menulevel2_id; ?>" />	
<input type="hidden" name="menulevel3_id" value="<?php echo $this->menulevel3->menulevel3_id; ?>" />

<div class="ec_admin_settings_panel ec_admin_details_panel">
    <div class="ec_admin_important_numbered_list">
        <div class="ec_admin_flex_row">
            <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first">
            	<div class="ec_admin_settings_label">
                    <div class="dashicons-before dashicons-products"></div>
                    <span><?php if( isset( $_GET['ec_admin_form_action'] ) && $_GET['ec_admin_form_action'] == 'add-new-menulevel3' ){ echo 'ADD NEW'; }else{ echo 'EDIT'; } ?> SUB-SUB-MENU</span>
                    <div class="ec_page_title_button_wrap">
                        <a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                        <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('products', 'menus', 'details');?>
                        <a href="<?php echo $this->action; ?>&menulevel2_id=<?php echo $menulevel2_id;?>" class="ec_page_title_button">Back to Sub-Sub-Menu</a>
                        <input type="submit" value="Save" onclick="return wpeasycart_admin_validate_form( )" class="ec_page_title_button">
                    </div>
                </div>
            
                <div class="ec_admin_settings_input ec_admin_settings_currency_section">
                	<?php do_action( 'wp_easycart_admin_menulevel3_details_basic_fields' ); ?>
                </div>
            </div>
        </div>
		<div class="ec_admin_details_footer">
            <div class="ec_page_title_button_wrap">
                <a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('products', 'menus', 'details');?>
                <a href="<?php echo $this->action; ?>&menulevel2_id=<?php echo $menulevel2_id;?>" class="ec_page_title_button">Back to Sub-Sub-Menu</a>
                <input type="submit" value="Save" onclick="return wpeasycart_admin_validate_form( )" class="ec_page_title_button">
            </div>
        </div>  
    </div>
</div>
</form>