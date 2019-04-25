<form action="<?php echo $this->action; ?>"  method="POST" name="wpeasycart_admin_form" id="wpeasycart_admin_form" novalidate="novalidate">
<input type="hidden" name="ec_admin_form_action" value="<?php echo $this->form_action; ?>" />
<?php
	global $wpdb;
	if(isset($_GET['option_id'])) {
		$option_id = $_GET['option_id'];
	} else {
		$option_id = $wpdb->get_var( $wpdb->prepare( "SELECT ec_optionitem.option_id FROM ec_optionitem WHERE ec_optionitem.optionitem_id = %d", $_GET['optionitem_id'] ) );
	}	
	$option_type = $wpdb->get_var( $wpdb->prepare( "SELECT ec_option.option_type FROM ec_option WHERE ec_option.option_id = %d", $option_id ) );
?>
<input type="hidden" name="option_id" id="option_id" value="<?php echo $option_id; ?>" />	
<input type="hidden" name="optionitem_id" id="optionitem_id" value="<?php echo $this->optionitem->optionitem_id; ?>" />
<input type="hidden" name="option_type" id="option_type" value="<?php echo $option_type; ?>" />

<div class="ec_admin_settings_panel ec_admin_details_panel">
    <div class="ec_admin_important_numbered_list">

        
        <div class="ec_admin_flex_row">
            <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first">
            
                <div class="ec_admin_settings_label">
                    <div class="dashicons-before dashicons-image-filter"></div>
                    <span><?php if( isset( $_GET['ec_admin_form_action'] ) && $_GET['ec_admin_form_action'] == 'add-new-optionitem' ){ echo 'ADD NEW'; }else{ echo 'EDIT'; } ?> OPTION ITEM</span>
                    <div class="ec_page_title_button_wrap">
                        <a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('products', 'option-sets', 'option-sets');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                        <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('products', 'option-sets', 'details');?>
                        <a href="<?php echo $this->action; ?>&option_id=<?php echo $option_id;?>" class="ec_page_title_button">Cancel</a>
                        <input type="submit" value="Save" onclick="return wpeasycart_admin_validate_form( )" class="ec_page_title_button">
                    </div>
                </div>
            
                <div class="ec_admin_settings_input ec_admin_settings_currency_section">
                	<?php do_action( 'wp_easycart_admin_optionitem_details_basic_fields' ); ?>
                </div>
           </div>
        </div>     
         
         
         <?php 
		 	//only show advanced form fields if advanced option set
		 	if ($option_type == 'combo' || $option_type == 'swatch' ||$option_type == 'text' ||$option_type == 'textarea' ||$option_type == 'file' ||$option_type == 'radio' ||$option_type == 'checkbox' ||$option_type == 'grid' ||$option_type == 'date' ||$option_type == 'dimensions1' ||$option_type == 'dimensions2' ||$option_type == 'number') {
		?>
          <div class="ec_admin_flex_row ec_admin_advanced_fields">
            <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first">       
                 
            
                <div class="ec_admin_settings_input ec_admin_settings_currency_section">
                	<div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Advanced Option Settings<br></div>
                    <div id="ec_admin_row_heading_message" class="ec_admin_row_heading_message"><p>The following advanced option properties can be adjusted.  Swatch type images can upload an image to represent that option, or you can choose which option is initially selected and/or whether options allow shipping of products or product downloads.</p></div>
					<?php do_action( 'wp_easycart_admin_optionitem_details_advanced_fields' ); ?>
                </div>

            </div>
        </div>
        
         
         <div class="ec_admin_flex_row ec_admin_price_fields">
            <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first">       
                 
            
                <div class="ec_admin_settings_input ec_admin_settings_currency_section">
                	<div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Advanced Price Options<br></div>
                    <div id="ec_admin_row_heading_message" class="ec_admin_row_heading_message"><p>You may select to have a price adjustment made based on the option selected by the user.  Simply select the price adjustment type and then enter the value for that type.</p>
                    
                    </div>
                    <div class="ec_admin_row_weight_adjustment">Price Adjustment Type:  <select id="ec_optionitem_price" onchange="ec_admin_optionitem_price_adjustment();">
                      <option value="0">No Price Adjustments</option>
                      <option value="basic_price">Basic Price Adjustment</option>
                      <option value="one_time_price">One-Time Price Adjustment</option>
                      <option value="override_price">Product Price Over-Ride</option>
                      <option value="multiplier_price">Product Price Multiplier</option>
                      <?php
					  	if ($option_type == 'text') {
					  ?>
                      <option value="per_character_price">Per-Character Price Adjustment</option>
                      <?php
						}
					  ?>
                    </select>
                    </p>
                    </div>
					<?php do_action( 'wp_easycart_admin_optionitem_details_price_fields' ); ?>
                </div>

            </div>
        </div>
        
        
        <div class="ec_admin_flex_row ec_admin_weight_fields">
            <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first">       
                 
            
                <div class="ec_admin_settings_input ec_admin_settings_currency_section">
                	<div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Advanced Weight Options<br></div>
                    <div id="ec_admin_row_heading_message" class="ec_admin_row_heading_message"><p>You may select to have a weight adjustment made based on the option selected by the user.  Simply select the weight adjustment type and then enter the value for that type.</p>
                    
                    </div>
                    <div class="ec_admin_row_weight_adjustment">Weight Adjustment Type:  <select id="ec_optionitem_weight" onchange="ec_admin_optionitem_weight_adjustment();">
                      <option value="0">No Weight Adjustments</option>
                      <option value="basic_weight">Basic Weight Adjustment</option>
                      <option value="one_time_weight">One-Time Weight Adjustment</option>
                      <option value="override_weight">Product Weight Over-Ride</option>
                      <option value="multiplier_weight">Product Weight Multiplier</option>
                    </select>
                    </p>
                    </div>
					<?php do_action( 'wp_easycart_admin_optionitem_details_weight_fields' ); ?>
                </div>

            </div>
        </div>
		<?php
			}
		?>
        <div class="ec_admin_details_footer">
            <div class="ec_page_title_button_wrap">
                <a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('products', 'option-sets', 'option-sets');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('products', 'option-sets', 'details');?>
                <a href="<?php echo $this->action; ?>&option_id=<?php echo $option_id;?>" class="ec_page_title_button">Cancel</a>
                <input type="submit" value="Save" onclick="return wpeasycart_admin_validate_form( )" class="ec_page_title_button">
            </div>
        </div>  
    </div>
</div>
</form>