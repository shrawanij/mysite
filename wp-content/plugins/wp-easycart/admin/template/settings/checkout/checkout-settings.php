<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_checkout_settings_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-cart"></div><span>Checkout Options</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'checkout', 'settings');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'checkout', 'settings');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        <div>Terms URL<input name="ec_option_terms_link" id="ec_option_terms_link" type="text" value="<?php echo get_option('ec_option_terms_link'); ?>" /></div>
        <div>Privacy Policy URL<input name="ec_option_privacy_link" id="ec_option_privacy_link" type="text" value="<?php echo get_option('ec_option_privacy_link'); ?>" /></div>
        <div>Custom Return to Cart URL (leave blank to automatically redirect to store)<input name="ec_option_return_to_store_page_url" id="ec_option_return_to_store_page_url" type="text" value="<?php echo get_option( 'ec_option_return_to_store_page_url' ); ?>" /></div>
        <div>Weight Unit<select name="ec_option_weight" id="ec_option_weight">
              <option value="0"<?php if(get_option('ec_option_weight') == '0') echo ' selected'; ?>>Select a Weight Unit</option>
              <option value="lbs"<?php if(get_option('ec_option_weight') == 'lbs') echo ' selected'; ?>>LBS</option>
              <option value="kgs"<?php if(get_option('ec_option_weight') == 'kgs') echo ' selected'; ?>>KGS</option>
          </select>
        </div>
        <div>Unit of Measurement<select name="ec_option_enable_metric_unit_display" id="ec_option_enable_metric_unit_display">
              <option value="0"<?php if(get_option('ec_option_enable_metric_unit_display') == '0') echo ' selected'; ?>>Standard</option>
              <option value="1"<?php if(get_option('ec_option_enable_metric_unit_display') == '1') echo ' selected'; ?>>Metric</option>
          </select>
        </div>
        <div>Default Payment Selection<select name="ec_option_default_payment_type" id="ec_option_default_payment_type">
                <option value="manual_bill" <?php if (get_option('ec_option_default_payment_type') == 'manual_bill') echo ' selected'; ?>>Manual Billing</option>
                <option value="third_party" <?php if (get_option('ec_option_default_payment_type') == 'third_party') echo ' selected'; ?>>Third Party</option>
                <option value="credit_card" <?php if (get_option('ec_option_default_payment_type') == 'credit_card') echo ' selected'; ?>>Credit Card</option>
              </select>
        </div>
        <div>Default Country Selection<select name="ec_option_default_country" id="ec_option_default_country">
				<option value="0" <?php if( get_option( 'ec_option_default_country' ) == '0' ){ ?> "selected"<?php }?>>No Default Country</option>
            	<?php foreach( wp_easycart_admin( )->countries as $country ){ ?>
            	<?php if( $country->ship_to_active ){ ?>
            	<option value="<?php echo $country->iso2_cnt; ?>"<?php if( get_option( 'ec_option_default_country' ) == $country->iso2_cnt ){ ?> selected="selected"<?php }?>><?php echo $country->name_cnt; ?></option>
            	<?php }?>
				<?php }?>
          	</select>
        </div>
        <div style="margin-top:15px;">Cart Minimum Order Total <input name="ec_option_minimum_order_total" id="ec_option_minimum_order_total" type="number" step=".01" min="0.00" value="<?php echo get_option('ec_option_minimum_order_total'); ?>" /></div>
        <?php 
		 	global $wpdb;
			$min_order_id = $wpdb->get_var( $wpdb->prepare( "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = %s AND TABLE_NAME = 'ec_order'", $wpdb->dbname ) );?>
         <div>Next Order ID (min allowed is <?php echo $min_order_id; ?>)<input name="ec_option_current_order_id" id="ec_option_current_order_id" type="text"  value="<?php echo $min_order_id; ?>" /></div>
        <div><input type="checkbox" name="ec_option_skip_shipping_page" id="ec_option_skip_shipping_page" value="1"<?php if( get_option('ec_option_skip_shipping_page') == "1" ){ echo " checked=\"checked\""; }?> /> Skip Shipping Panel</div>
        <div style="display:none"><input type="checkbox" name="ec_option_skip_cart_login" id="ec_option_skip_cart_login" value="1"<?php if( get_option('ec_option_skip_cart_login') == "1" ){ echo " checked=\"checked\""; }?> /> Skip Login Screen in Cart</div>
        <div><input type="checkbox" name="ec_option_use_estimate_shipping" id="ec_option_use_estimate_shipping" value="1"<?php if( get_option('ec_option_use_estimate_shipping') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Estimate Shipping</div>
        <div><input type="checkbox" name="ec_option_estimate_shipping_zip" id="ec_option_estimate_shipping_zip" value="1"<?php if( get_option('ec_option_estimate_shipping_zip') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Zip Code for Estimate Shipping</div>
        <div><input type="checkbox" name="ec_option_estimate_shipping_country" id="ec_option_estimate_shipping_country" value="1"<?php if( get_option('ec_option_estimate_shipping_country') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Country for Estimate Shipping</div>
        <div><input type="checkbox" name="ec_option_allow_guest" id="ec_option_allow_guest" value="1"<?php if( get_option('ec_option_allow_guest') == "1" ){ echo " checked=\"checked\""; }?> /> Allow Guest Checkout</div>
        <div><input type="checkbox" name="ec_option_show_giftcards" id="ec_option_show_giftcards" value="1"<?php if( get_option('ec_option_show_giftcards') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Gift Cards</div>
        <div><input type="checkbox" name="ec_option_gift_card_shipping_allowed" id="ec_option_gift_card_shipping_allowed" value="1"<?php if( get_option('ec_option_gift_card_shipping_allowed') == "1" ){ echo " checked=\"checked\""; }?> /> Gift Cards Apply to Grand Total</div>
        <div><input type="checkbox" name="ec_option_show_coupons" id="ec_option_show_coupons" value="1"<?php if( get_option('ec_option_show_coupons') == "1" ){ echo " checked=\"checked\""; }?> /> Enable Coupons</div>
        <div><input type="checkbox" name="ec_option_addtocart_return_to_product" id="ec_option_addtocart_return_to_product" value="1"<?php if( get_option('ec_option_addtocart_return_to_product') == "1" ){ echo " checked=\"checked\""; }?> /> Keep User on Product Details on Add to Cart</div>
        <div><input type="checkbox" name="ec_option_use_smart_states" id="ec_option_use_smart_states" value="1"<?php if( get_option('ec_option_use_smart_states') == "1" ){ echo " checked=\"checked\""; }?> /> States Change with Country (Preferred Method)</div>
        <div><input type="checkbox" name="ec_option_use_state_dropdown" id="ec_option_use_state_dropdown" value="1"<?php if( get_option('ec_option_use_state_dropdown') == "1" ){ echo " checked=\"checked\""; }?> /> State Drop Down Box (Preferred Method)</div>
        <div><input type="checkbox" name="ec_option_use_country_dropdown" id="ec_option_use_country_dropdown" value="1"<?php if( get_option('ec_option_use_country_dropdown') == "1" ){ echo " checked=\"checked\""; }?> /> Country Drop Down Box (Preferred Method)</div>
        
        <div class="ec_admin_settings_input">
            <input type="submit" class="ec_admin_settings_simple_button" onclick="return ec_admin_save_checkout_options( );" value="Save Options" />
        </div>
    </div>
</div>