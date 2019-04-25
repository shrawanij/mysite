<div id="ec_account_password">
	
    <div class="ec_account_left">

		<div class="ec_cart_header ec_top"><?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_title' )?></div>

		<div class="ec_account_password_main_sub_title"><?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_sub_title' )?></div>

		<?php $this->display_account_password_form_start( ); ?>

		<?php do_action( 'wpeasycart_change_password_top' ); ?>

		<div class="ec_cart_input_row">
            
            <label for="ec_account_password_current_password"><?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_current_password' )?></label>
            
			<?php $this->display_account_password_current_password(); ?>

			<div class="ec_cart_error_row" id="ec_account_password_current_password_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_current_password' ); ?>
            </div>

		</div>
        
        <div class="ec_cart_input_row">
            
            <?php do_action( 'wpeasycart_pre_password_display' ); ?>
            
            <label for="ec_account_password_new_password"><?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_new_password' )?></label>

			<?php $this->display_account_password_new_password(); ?>

			<div class="ec_cart_error_row" id="ec_account_password_new_password_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_length_error' ); ?>
            </div>

      </div>
      
	  <div class="ec_cart_input_row">
            
            <label for="ec_account_password_retype_new_password"><?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_retype_new_password' )?></label>

			<?php $this->display_account_password_retype_new_password(); ?>

			<div class="ec_cart_error_row" id="ec_account_password_retype_new_password_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_passwords_do_not_match' ); ?>
            </div>

        </div>
	  
        <div class="ec_cart_button_row">
        	<input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_update_button' ); ?>" class="ec_account_button" onclick="<?php $ec_password_save_js_function = apply_filters( 'wpeasycart_update_password_js_function', 'return ec_account_password_button_click( );' ); echo $ec_password_save_js_function; ?>" />
        
			<?php $this->display_account_password_cancel_link( $GLOBALS['language']->get_text( 'account_password', 'account_password_cancel_button' ) ); ?>
		</div>

    	<?php $this->display_account_password_form_end( ); ?>

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