<div id="ec_account_billing_information">
	
    <div class="ec_account_left">
    	
    	<?php $this->display_account_billing_information_form_start(); ?>

  		<div class="ec_cart_header ec_top">
			<?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_title' )?>
        </div>
        
        <?php if( get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_country"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' )?>*</label>
            <?php $this->display_account_billing_information_country_input( ); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_country_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' ); ?>
            </div>
        </div>
        <?php } ?>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_first_name"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_first_name' )?>*</label>
            <?php $this->display_account_billing_information_first_name_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_first_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_first_name' ); ?>
            </div>
        </div>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_last_name"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_last_name' )?>*</label>
            <?php $this->display_account_billing_information_last_name_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_last_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_last_name' ); ?>
            </div>
        </div>
        
        <?php if( get_option( 'ec_option_enable_company_name' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_company_name"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_company_name' ); ?></label>
            <input type="text" name="ec_account_billing_information_company_name" id="ec_account_billing_information_company_name" class="ec_account_billing_information_input_field" value="<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->company_name, ENT_QUOTES ); ?>">
            <div class="ec_cart_error_row" id="ec_account_billing_information_company_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'cart_billing_information_company_name' ); ?>
            </div>
        </div>
        <?php } ?>
        
        <?php if( get_option( 'ec_option_collect_vat_registration_number' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_vat_registration_number"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_vat_registration_number' ); ?></label>
            <input type="text" name="ec_account_billing_information_vat_registration_number" id="ec_account_billing_information_vat_registration_number" class="ec_account_billing_information_input_field" value="<?php echo htmlspecialchars( $GLOBALS['ec_user']->vat_registration_number, ENT_QUOTES ); ?>">
            <div class="ec_cart_error_row" id="ec_account_billing_information_vat_registration_number_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'cart_billing_information_vat_registration_number' ); ?>
            </div>
        </div>
        <?php } ?>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_address"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_address' )?>*</label>
            <?php $this->display_account_billing_information_address_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_address_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_address' ); ?>
            </div>
        </div>
        <?php if( get_option( 'ec_option_use_address2' ) ){ ?>
        <div class="ec_cart_input_row">
        	<?php $this->display_account_billing_information_address2_input(); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_city"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_city' )?>*</label>
            <?php $this->display_account_billing_information_city_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_city_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_city' ); ?>
        	</div>
        </div>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_state"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_state' )?><span id="ec_billing_state_required">*</span></label>
            <?php $this->display_account_billing_information_state_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_state_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_state' ); ?>
            </div>
        </div>
    	
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_zip"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_zip' )?>*</label>
            <?php $this->display_account_billing_information_zip_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_zip_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_zip' ); ?>
            </div>
        </div>
		
        <?php if( !get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_country"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' )?>*</label>
            <?php $this->display_account_billing_information_country_input( ); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_country_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' ); ?>
            </div>
        </div>
        <?php } ?>
        
        <?php if( get_option( 'ec_option_collect_user_phone' ) ){ ?>
		<div class="ec_cart_input_row">
            <label for="ec_account_billing_information_phone"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_phone' )?>*</label>
            <?php $this->display_account_billing_information_phone_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_phone_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_phone' ); ?>
            </div>
        </div>
        <?php }?>
        
        <div class="ec_cart_button_row">
			<input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_update_button' ); ?>" class="ec_account_button" onclick="return ec_account_billing_information_update_click( );" />
			<?php $this->display_account_billing_information_cancel_link( $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_cancel' ) ); ?>
    	</div>

    	<?php $this->display_account_billing_information_form_end(); ?>
    
    </div>
    
    <div class="ec_account_right">
    	
        <div class="ec_cart_header ec_top"><?php echo $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_title' )?></div>
        
        <?php do_action( 'wpeasycart_account_links' ); ?>

		<div class="ec_cart_input_row">

			<?php $this->display_billing_information_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_billing_information' ) ); ?>

		</div>

        <?php if( get_option( 'ec_option_use_shipping' ) ){ ?>
        <div class="ec_cart_input_row">

			<?php $this->display_shipping_information_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_shipping_information' ) ); ?>

		</div>
		<?php }?>

        <div class="ec_cart_input_row">

			<?php $this->display_personal_information_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_basic_inforamtion' ) ); ?>

		</div>

       <div class="ec_cart_input_row">

          <?php $this->display_password_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_password' ) ); ?>

        </div>

		<?php if( $this->using_subscriptions( ) ){ ?>

        <div class="ec_cart_input_row">

          <?php $this->display_subscriptions_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_subscriptions' )); ?>

        </div>

        <?php }?>

        <div class="ec_cart_input_row">

          <?php $this->display_logout_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_sign_out' )); ?>

        </div>
        
    </div>

</div>

