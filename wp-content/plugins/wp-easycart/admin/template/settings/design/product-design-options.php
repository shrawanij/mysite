<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_design_options" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-media-document"></div><span>Product Design Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'design', 'product');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'design', 'product');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_currency_section">
        <span style="float:left; width:100%;">Default Product Page Options</span> 
       
        <div>Product Type: <select name="ec_option_default_product_type" id="ec_option_default_product_type">
                <option value="1"<?php if( get_option( 'ec_option_default_product_type' ) == '1' ){ echo " selected='selected'"; }?>>Grid Type 1</option>
                <option value="2"<?php if( get_option( 'ec_option_default_product_type' ) == '2' ){ echo " selected='selected'"; }?>>Grid Type 2</option>
                <option value="3"<?php if( get_option( 'ec_option_default_product_type' ) == '3' ){ echo " selected='selected'"; }?>>Grid Type 3</option>
                <option value="4"<?php if( get_option( 'ec_option_default_product_type' ) == '4' ){ echo " selected='selected'"; }?>>Grid Type 4</option>
                <option value="5"<?php if( get_option( 'ec_option_default_product_type' ) == '5' ){ echo " selected='selected'"; }?>>Grid Type 5</option>
                <option value="6"<?php if( get_option( 'ec_option_default_product_type' ) == '6' ){ echo " selected='selected'"; }?>>List Type 6</option>
            </select>
        </div>
        
        <div>Image Hover Effect: <select name="ec_option_default_product_image_hover_type" id="ec_option_default_product_image_hover_type">
                <option value="1"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '1' ){ echo " selected='selected'"; }?>>Image Flip</option>
                <option value="2"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '2' ){ echo " selected='selected'"; }?>>Image Crossfade</option>
                <option value="3"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '3' ){ echo " selected='selected'"; }?>>Lighten</option>
                <option value="5"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '5' ){ echo " selected='selected'"; }?>>Image Grow</option>
                <option value="6"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '6' ){ echo " selected='selected'"; }?>>Image Shrink</option>
                <option value="7"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '7' ){ echo " selected='selected'"; }?>>Grey-Color</option>
                <option value="8"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '8' ){ echo " selected='selected'"; }?>>Brighten</option>
                <option value="9"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '9' ){ echo " selected='selected'"; }?>>Image Slide</option>
                <option value="10"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '10' ){ echo " selected='selected'"; }?>>FlipBook</option>
                <option value="4"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '4' ){ echo " selected='selected'"; }?>>No Effect</option>
            </select>
        </div>
        
        
        <div>Image Effect:<select name="ec_option_default_product_image_effect_type" id="ec_option_default_product_image_effect_type">
                <option value="none"<?php if( get_option( 'ec_option_default_product_image_effect_type' ) == 'none' ){ echo " selected='selected'"; }?>>None</option>
                <option value="border"<?php if( get_option( 'ec_option_default_product_image_effect_type' ) == 'border' ){ echo " selected='selected'"; }?>>Border</option>
                <option value="shadow"<?php if( get_option( 'ec_option_default_product_image_effect_type' ) == 'shadow' ){ echo " selected='selected'"; }?>>Shadow</option>
            </select>
        </div>
        
        <div>Quick View: <select name="ec_option_default_quick_view" id="ec_option_default_quick_view">
            	<option value="1"<?php if( get_option( 'ec_option_default_quick_view' ) == '1' ){ echo " selected='selected'"; }?>>On</option>
            	<option value="0"<?php if( get_option( 'ec_option_default_quick_view' ) == '0' ){ echo " selected='selected'"; }?>>Off</option>
        	</select>
        </div>
        
        
        <div>Dynamic Image Height: <select name="ec_option_default_dynamic_sizing" id="ec_option_default_dynamic_sizing">
            	<option value="1"<?php if( get_option( 'ec_option_default_dynamic_sizing' ) == '1' ){ echo " selected='selected'"; }?>>On</option>
            	<option value="0"<?php if( get_option( 'ec_option_default_dynamic_sizing' ) == '0' ){ echo " selected='selected'"; }?>>Off</option>
        	</select>
        </div>
        
        <span style="float:left; width:100%;">Responsive Desktop Options</span>
        <div>Columns: <select name="ec_option_default_desktop_columns" id="ec_option_default_desktop_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
            </select>
        </div>
       <div>Image Height: <input name="ec_option_default_desktop_image_height" id="ec_option_default_desktop_image_height" type="number" value="<?php if( get_option( 'ec_option_default_desktop_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_desktop_image_height' ) ); }else{ echo "250"; } ?>" style="width:40px;" />px
       </div>
       
       <span style="float:left; width:100%;">Responsive Tablet Landscape</span>
        <div>Columns: <select name="ec_option_default_laptop_columns" id="ec_option_default_laptop_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </div>
       <div>Image Height: <input name="ec_option_default_laptop_image_height" id="ec_option_default_laptop_image_height" type="number" value="<?php if( get_option( 'ec_option_default_laptop_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_laptop_image_height' ) ); }else{ echo "250"; } ?>"  style="width:40px;"  />px
       </div>
       
       <span style="float:left; width:100%;">Responsive Tablet Portrait</span>
        <div>Columns: <select name="ec_option_default_tablet_wide_columns" id="ec_option_default_tablet_wide_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </div>
       <div>Image Height: <input name="ec_option_default_tablet_wide_image_height" id="ec_option_default_tablet_wide_image_height" type="number" value="<?php if( get_option( 'ec_option_default_tablet_wide_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_tablet_wide_image_height' ) ); }else{ echo "250"; } ?>" style="width:40px;"  />px
       </div>
       
       <span style="float:left; width:100%;">Responsive Smartphone Landscape</span>
        <div>Columns: <select name="ec_option_default_tablet_columns" id="ec_option_default_tablet_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </div>
       <div>Image Height: <input name="ec_option_default_tablet_image_height" id="ec_option_default_tablet_image_height" type="number" value="<?php if( get_option( 'ec_option_default_tablet_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_tablet_image_height' ) ); }else{ echo "250"; } ?>" style="width:40px;"  />px
       </div>
       
       <span style="float:left; width:100%;">Responsive Smartphone Portrait</span>
        <div>Columns: <select name="ec_option_default_smartphone_columns" id="ec_option_default_smartphone_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </div>
       <div>Image Height: <input name="ec_option_default_smartphone_image_height" id="ec_option_default_smartphone_image_height" type="number" value="<?php if( get_option( 'ec_option_default_smartphone_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_smartphone_image_height' ) ); }else{ echo "250"; } ?>" style="width:40px;"  />px
       </div>
       
       
       
        </div>
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_product_design_options( );" value="Save Options" />
    </div>
</div>