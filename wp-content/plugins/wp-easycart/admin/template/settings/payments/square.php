<div class="ec_admin_square_row">
    <div class="ec_admin_slider_row">
        <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_square_display_loader" ); ?>
        <h3>Square</h3>
        <div class="ec_admin_slider_row_description">
            <div>Square offers the ability to pay with a credit card directly on your website. Adding Square gives your shopping cart a more professional look and increases conversions.</div>
            <?php if( get_option( 'ec_option_payment_process_method' ) == 'square' ){ ?><a href="admin.php?page=wp-easycart-settings&subpage=cart-importer&ec_action=import-square-products" target="_blank">Import Products From SquareUp</a><a href="admin.php?page=wp-easycart-settings&subpage=payment&ec_admin_form_action=square-disconnect">Disconnect</a><a href="admin.php?page=wp-easycart-settings&subpage=payment&ec_admin_form_action=square-renew">Renew Access</a><a href="#" onclick="return square_show_advanced( );" id="square_advanced_link">Advanced Options &#9660;</a><?php }?>
            <input type="hidden" name="use_square" id="use_square" value="<?php echo ( get_option( 'ec_option_payment_process_method' ) == 'square' ) ? 1 : 0; ?>" />
        </div>
        <div class="ec_admin_toggles_wrap">
            <div class="ec_admin_toggle">
                <span>Enable:</span>
                <?php if( get_option( 'ec_option_payment_process_method' ) != 'square' ){ ?>
                <?php 
					$app_redirect_state = rand( 1000000, 9999999 );
				?>
                <a href="https://support.wpeasycart.com/square/?url=<?php echo urlencode( admin_url( ) . '?ec_admin_form_action=handle-square' ); ?>&state=<?php echo $app_redirect_state; ?>">
                <span></span>
				<?php }?>
                <label class="ec_admin_switch">
                    <input type="checkbox" onclick="return square_on_off( );" class="ec_admin_slider_checkbox" value="1" id="ec_option_square_enable"<?php if( get_option( 'ec_option_payment_process_method' ) == 'square' ){ ?> checked="checked"<?php }?>>
                    <span class="ec_admin_slider round"></span>
                </label>
               <?php if( get_option( 'ec_option_payment_process_method' ) != 'square' ){ ?>
                </a> 
                <?php }?>
            </div>
        </div>
        <div id="ec_square_options" class="ec_admin_initial_hide">
            <?php if( get_option( 'ec_option_square_access_token' ) != '' ){ ?>
            <?php if( class_exists( 'ec_square' ) ){
                $square = new ec_square( );
                $square_locations = $square->get_locations( );
            ?>
            <div class="ec_admin_settings_input ec_admin_settings_third_party_section ec_admin_settings_show">Store Location
                <select name="ec_option_square_location_id" id="ec_option_square_location_id" onchange="ec_admin_save_square_options( );">
                    <option value="0">Use Default Location (or select one here)</option>
                    <?php if( is_array( $square_locations ) && isset( $square_locations[0] ) && isset( $square_locations[0]->id ) ){
                        foreach( $square_locations as $location ){ ?>
                    <option value="<?php echo $location->id; ?>"<?php if( $location->id == get_option( 'ec_option_square_location_id' ) ){ ?> selected="selected"<?php }?> data-country="<?php echo $location->country; ?>"><?php echo $location->name; ?></option>
                    <?php }
                    }else{ ?>
                    <option value="0">Could not get your Square Locations</option>
                    <?php }?>
                </select>
            </div>
            <?php } } ?>
        </div>
    </div>
</div>