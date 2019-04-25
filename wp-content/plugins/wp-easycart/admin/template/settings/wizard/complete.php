<form action="" method="POST" name="wpeasycart_admin_setup_wizard_form" id="wpeasycart_admin_setup_wizard_form" novalidate="novalidate">
<input type="hidden" name="ec_admin_form_action" id="ec_admin_form_action" value="process-wizard-payments">
<h3>You're Done!</h3>
<p>Thank you for taking the time to complete setup, now onwards to create your first product and make your first sale!</p>
<div class="wp_easycart_wizard_success_container">
    <?php if( !get_option( 'ec_option_demo_data_installed' ) ){ ?>
    <div class="wp_easycart_wizard_success_box" id="easycart_wizard_demo_data">
        <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_demo_data_loader" ); ?>
    	<div class="wp_easycart_wizard_success_box_left">
            <div class="wp_easycart_wizard_success_box_title">JUST TRYING THE CART?</div>
            <div class="wp_easycart_wizard_success_box_content">If you are new to EasyCart, try our demo data first.</div>
        </div>
        <div class="wp_easycart_wizard_success_box_right">
            <div class="wp_easycart_wizard_success_box_button"><a href="admin.php?page=wp-easycart-settings&subpage=initial-setup&action=easycart-install-demo-data" onclick="return ec_admin_install_demo_data( );">Install Demo Data</a></div>
        </div>
    	<div style="clear:both;"></div>
    </div>
    <div class="wp_easycart_wizard_success_box" id="easycart_wizard_demo_data_done" style="display:none;">
    	<div class="wp_easycart_wizard_success_box_left">
            <div class="wp_easycart_wizard_success_box_title">DEMO DATA INSTALLED!</div>
            <div class="wp_easycart_wizard_success_box_content">You are all set! Now check out your new store.</div>
        </div>
        <div class="wp_easycart_wizard_success_box_right">
            <div class="wp_easycart_wizard_success_box_button"><a href="<?php $storepageid = get_option( 'ec_option_storepage' ); $store_page = get_permalink( $storepageid ); echo $store_page; ?>" style="background:#03A9F4;" target="_blank">View Your Store</a></div>
        </div>
    	<div style="clear:both;"></div>
    </div>
    <?php }?>
    <div class="wp_easycart_wizard_success_box">
        <div class="wp_easycart_wizard_success_box_left">
            <div class="wp_easycart_wizard_success_box_title">NEXT STEP</div>
            <div class="wp_easycart_wizard_success_box_content">You're ready to add your first product.</div>
        </div>
        <div class="wp_easycart_wizard_success_box_right">
            <div class="wp_easycart_wizard_success_box_button"><a href="admin.php?page=wp-easycart-products&subpage=products&ec_admin_form_action=add-new" onclick="wp_easycart_admin_open_slideout( 'new_product_box' ); return false;">Create a Product</a></div>
        </div>
    	<div style="clear:both;"></div>
    </div>
    <?php if( class_exists( "WooCommerce" ) ){ ?>
    <div class="wp_easycart_wizard_success_box">
        <div class="wp_easycart_wizard_success_box_left">
            <div class="wp_easycart_wizard_success_box_title">IMPORT FROM WOOCOMMERCE</div>
            <div class="wp_easycart_wizard_success_box_content">It looks like you already have WooCommerce installed -- Import automatically to EasyCart now!</div>
        </div>
        <div class="wp_easycart_wizard_success_box_right">
            <div class="wp_easycart_wizard_success_box_button"><a href="admin.php?page=wp-easycart-settings&subpage=cart-importer" target="_blank">Import Products</a></div>
        </div>
    	<div style="clear:both;"></div>
    </div>
    <?php }?>
    <?php if( get_option( 'ec_option_square_access_token' ) != '' ){ ?>
    <div class="wp_easycart_wizard_success_box">
        <div class="wp_easycart_wizard_success_box_left">
            <div class="wp_easycart_wizard_success_box_title">IMPORT FROM SQUARE</div>
            <div class="wp_easycart_wizard_success_box_content">It looks like you are connected with SquareUp Payments -- Import automatically to EasyCart now!</div>
        </div>
        <div class="wp_easycart_wizard_success_box_right">
            <div class="wp_easycart_wizard_success_box_button"><a href="admin.php?page=wp-easycart-settings&subpage=cart-importer" target="_blank">Import Products</a></div>
        </div>
    	<div style="clear:both;"></div>
    </div>
    <?php }?>
    <?php $trial_note = '<div class="wp_easycart_wizard_success_box">
        <div class="wp_easycart_wizard_success_box_left">
            <div class="wp_easycart_wizard_success_box_title">TRY PRO FREE</div>
            <div class="wp_easycart_wizard_success_box_content">Want to try all the features WP EasyCart has to offer? Try our 14 day FREE PRO Trial.</div>
        </div>
        <div class="wp_easycart_wizard_success_box_right">
            <div class="wp_easycart_wizard_success_box_button"><a href="admin.php?page=wp-easycart-registration&ec_trial=start" target="_blank">Install PRO Trial</a></div>
        </div>
    	<div style="clear:both;"></div>
    </div>';
	echo apply_filters( 'wp_easycart_trial_start_content', $trial_note );
	?>
    <div class="wp_easycart_wizard_success_box">
        <div class="wp_easycart_wizard_success_box_title">Learn More</div>
        <div><a href="http://support.wpeasycart.com/video-tutorials/" target="_blank">Watch our video tutorials</a></div>
        <div><a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/" target="_blank">Read our documentation guide</a></div>
        <div><a href="https://www.wpeasycart.com/contact-information/" target="_blank">Submit a sales question</a></div>
    </div>
</div>
<?php
	wp_easycart_admin( )->load_new_slideout( 'product' );
	wp_easycart_admin( )->load_new_slideout( 'manufacturer' );
	wp_easycart_admin( )->load_new_slideout( 'optionset' );
?>