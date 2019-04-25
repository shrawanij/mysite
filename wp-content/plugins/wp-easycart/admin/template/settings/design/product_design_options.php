<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_design_options" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-generic"></div><span>Product Design Options</span></div>
    <div class="ec_admin_settings_input ec_admin_settings_currency_section">
        <span>Choose you currency options</span>
        <div>Currency Code: <input type="text" name="ec_option_base_currency" id="ec_option_base_currency" value="<?php echo get_option('ec_option_base_currency'); ?>"></div>
        <div>Show Currency Code: <select name="ec_option_show_currency_code" id="ec_option_show_currency_code" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_currency_code') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_currency_code') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></div>
        <div>Symbol: <input type="text" name="ec_option_currency" id="ec_option_currency" value="<?php echo get_option('ec_option_currency'); ?>"></div>
        <div>Symbol Location: <select name="ec_option_currency_symbol_location" id="ec_option_currency_symbol_location">
    <option value="1" <?php if (get_option('ec_option_currency_symbol_location') == 1) echo ' selected'; ?>>Left</option>
    <option value="0" <?php if (get_option('ec_option_currency_symbol_location') == 0) echo ' selected'; ?>>Right</option>
  </select></div>
        <div>Negative Location: <select name="ec_option_currency_negative_location" id="ec_option_currency_negative_location">
        <option value="1" <?php if (get_option('ec_option_currency_negative_location') == 1) echo ' selected'; ?>>Before</option>
        <option value="0" <?php if (get_option('ec_option_currency_negative_location') == 0) echo ' selected'; ?>>After</option>
      </select></div>
        <div>Decimal Symbol: <input name="ec_option_currency_decimal_symbol" id="ec_option_currency_decimal_symbol" type="text" value="<?php echo get_option('ec_option_currency_decimal_symbol'); ?>" size="1" style="width:40px;" /></div>
        <div>Decimal Length: <input name="ec_option_currency_decimal_places" id="ec_option_currency_decimal_places" type="text" value="<?php echo get_option('ec_option_currency_decimal_places'); ?>" size="1" style="width:40px;" /></div>
        <div>Grouping Symbol: <input name="ec_option_currency_thousands_seperator" id="ec_option_currency_thousands_seperator" type="text" value="<?php echo get_option('ec_option_currency_thousands_seperator'); ?>" size="1" style="width:40px;" /></div>
    </div>
    <div class="ec_admin_settings_input">
        <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_currency_options( );" value="Save Options" />
    </div>
</div>