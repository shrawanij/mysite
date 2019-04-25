<div class="ec_admin_settings_panel">
    <div class="ec_admin_important_numbered_list_fullwidth">
        <div class="ec_admin_list_line_item_fullwidth ec_admin_demo_data_line">
			<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_registration_loader" ); ?>
            <div class="ec_admin_settings_label">
            	<div class="dashicons-before dashicons-unlock"></div>
            	<span>Registration & Activation</span>
                <a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'registration', 'none');?>" target="_blank" class="ec_help_icon_link">
            		<div class="dashicons-before ec_help_icon dashicons-info"></div>
            	</a>
            	<?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'registration', 'none');?>
            </div>
            <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
                <style>input {margin-top: 0px !important;}</style>
                <h3 style="font-size:32px; font-weight:normal; margin:0 0 10px; display:block;">Already Purchased PRO?</h3>
                <p>If you have already purchased the WP EasyCart PRO edition and are seeing this message you need to install your PRO plugin to unlock this page. Once installed, return here and you will be able to register your site with your license key provided on purchase.</p>
                <div class="ec_admin_upgrade_subheader ec_admin_upgrade_box_signup_row" style="text-align:left; padding:0 0 50px;"><a href="admin.php?page=wp-easycart-registration&ec_install=pro">INSTALL PRO</a></div>
				<hr />
                <h3 style="font-size:32px; font-weight:normal; margin:25px 0 10px; display:block;">Need a License?</h3>
                <ul style="list-style:inherit; padding:0 30px; line-height:1.5em;">
					<li>All EasyCart licenses are good for use on <strong>one</strong> WordPress website.</li>
					<li>You may easily transfer your website license to any other website by deactivating your license key.</li>  
					<li>You may also enter your license key into a new website and it will automatically transfer your license to the new site.</li>
					<li>You may start a free PRO trial (if you have not previously bought a license) at <a href="https://www.wpeasycart.com" target="_blank">www.wpeasycart.com</a>.</li>
				</ul>
				<p>We make it easy and simple! Each WordPress website requires a license, you can purchase new licenses by visiting <a href="https://www.wpeasycart.com" target="_blank">www.wpeasycart.com</a>.</p>
            </div>
        </div>
    </div>
</div>