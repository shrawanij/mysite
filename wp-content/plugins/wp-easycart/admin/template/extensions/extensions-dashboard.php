<?php
$is_premium = false;
$is_pro = false;
$is_expired = false;
$query_var = '';

if( function_exists( 'wp_easycart_admin_license' ) ){
	if( !wp_easycart_admin_license( )->active_license && wp_easycart_admin_license( )->valid_license ){
		$is_expired = true;
	}
	if( wp_easycart_admin_license( )->valid_license ){
		$is_pro = true;
	}
}
if( function_exists( 'ec_license_manager' ) ){
	$license_data = ec_license_manager( )->ec_get_license( );
	if( isset( $license_data->model_number ) && $license_data->model_number == 'ec410' )
		$is_premium = true;
	
}
if( get_option( 'wp_easycart_license_info' ) ){
	$registration_info = get_option( 'wp_easycart_license_info' );
	$query_var = '?transaction_key='.esc_attr( $registration_info['transaction_key'] );
}

if( $is_expired && $is_pro ){ // Existing license that is expired - Send to Premium Renewal
	$button = $app_button = $iphone_button = $ipad_button = $android_button = '<a href="https://www.wpeasycart.com/products/wp-easycart-premium-support-extensions/' . $query_var . '" target="_blank" class="get-extension">Renew License</a>';

}else if( !$is_pro ){ // No license - Send to buy Premium
	$button = $app_button = $iphone_button = $ipad_button = $android_button = 'custom';

}else if( $is_pro && !$is_premium ){ // Is valid PRO license - Send to Upgrade
	$button = $app_button = $iphone_button = $ipad_button = $android_button = '<a href="http://www.wpeasycart.com/products/wp-easycart-pro-to-premium-upgrade/' . $query_var . '" target="_blank" class="get-extension">Upgrade Today</a>';

}else{ // Premium User - Send to Download
	$button = '<a href="https://www.wpeasycart.com/premium-members-page/" target="_blank" class="get-extension">Download Extension</a>';
	$app_button = '<a href="https://www.wpeasycart.com/premium-members-page/" target="_blank" class="get-extension">Download App</a>';
	$iphone_button = '<a href="https://itunes.apple.com/us/app/wp-easycart-iphone/id1289942523?ls=1&mt=8" target="_blank" class="get-extension">Download App</a>';
	$ipad_button = '<a href="https://itunes.apple.com/us/app/wp-easycart/id616846878?mt=8" target="_blank" class="get-extension">Download App</a>';
	$android_button = '<a href="https://play.google.com/store/apps/details?id=air.com.wpeasycart.androidtablet&hl=en" target="_blank" class="get-extension">Download App</a>';
}
?>

<div class="ec_admin_extensions_list_wrap">
	<div class="ec_admin_extensions_list">
		
		<!--column 1-->
    	<div class="ec_admin_extension_item">
        	<h3>Desktop App</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="Desktop App" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-desktop.jpg' ); ?>" /></a>
            <p>Manage your store from your desktop with the WP EasyCart Desktop Applicatoin.</p>
            <?php echo ( $app_button != 'custom' ) ? $app_button : '<a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank" class="get-extension">Learn More</a>'; ?>
        </div>
        <div class="ec_admin_extension_item">
        	<h3>iPhone App</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="iPhone App" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-iphone.jpg' ); ?>" /></a>
            <p>Manage your store from your iPhone with the WP EasyCart iPhone Application. Download from the iTunes app store today!</p>
            <?php echo ( $iphone_button != 'custom' ) ? $iphone_button : '<a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank" class="get-extension">Learn More</a>'; ?>
        </div>
        <div class="ec_admin_extension_item">
        	<h3>MailChimp</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="MailChimp Extension" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-mailchimp.jpg' ); ?>" /></a>
            <p>Fully integrated with MailChimp's eCommerce features to track purchases directly related to mail campaigns.</p>
            <?php echo ( $button != 'custom' ) ? $button : '<a href="https://www.wpeasycart.com/wordpress-mailchimp-extension/" target="_blank" class="get-extension">Learn More</a>'; ?><br>
			 <a href="http://docs.wpeasycart.com/wp-easycart-extensions-guide/?section=mailchimp" target="_blank" class="get-extension">Intallation Guide</a> 
        </div>
		<div class="ec_admin_extension_item">
        	<h3>AffiliateWP Product Rates</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="AffiliateWP" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-affiliatewp.jpg' ); ?>" /></a>
            <p>The AffiiliateWP product add-on allows you to add custom rates for individual products through Affiliate WP.  You still must have an AffiliateWP license and software to utilize this in combination with EasyCart.</p>
            <?php echo ( $button != 'custom' ) ? $button : '<a href="https://www.wpeasycart.com/wordpress-affiliate-wp-extension/" target="_blank" class="get-extension">Learn More</a>'; ?>	<br>
			 <a href="http://docs.wpeasycart.com/wp-easycart-extensions-guide/?section=affiliatewp" target="_blank" class="get-extension">Intallation Guide</a> 		
        </div>
        <div class="ec_admin_extension_item">
        	<h3>Tabs</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="Tabs Extension" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-tabs.jpg' ); ?>" /></a>
            <p>The WP EasyCart Tabs Extension allows you to create custom tabs for each product. Now you can have more than just the Description &amp; Specifications tabs on each product entry.</p>
            <?php echo ( $button != 'custom' ) ? $button : '<a href="https://www.wpeasycart.com/wordpress-extra-tabs-extension/" target="_blank" class="get-extension">Learn More</a>'; ?><br>
			 <a href="http://docs.wpeasycart.com/wp-easycart-extensions-guide/?section=system-requirements" target="_blank" class="get-extension">Intallation Guide</a>
        </div>
		
		
		<!--column 2-->
        <div class="ec_admin_extension_item">
        	<h3>iPad App</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="iPad App" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-ipad.jpg' ); ?>" /></a>
            <p>Manage your store from your iPad with the WP EasyCart iPad Application. Download from the iTunes app store today!</p>
            <?php echo ( $ipad_button != 'custom' ) ? $ipad_button : '<a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank" class="get-extension">Learn More</a>'; ?>
        </div>
        <div class="ec_admin_extension_item">
        	<h3>ShipStation</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="ShipStation Extension" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-shipstation.jpg' ); ?>" /></a>
            <p>The WP EasyCart ShipStation extension automatically exports orders to ShipStation to quickly manage and automate your shipping system.</p>
            <?php echo ( $button != 'custom' ) ? $button : '<a href="https://www.wpeasycart.com/wordpress-shipstation-extension/" target="_blank" class="get-extension">Learn More</a>'; ?><br>
			 <a href="http://docs.wpeasycart.com/wp-easycart-extensions-guide/?section=shipstation" target="_blank" class="get-extension">Intallation Guide</a>
        </div>
        <div class="ec_admin_extension_item">
        	<h3>Stamps.com</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="Stamps.com Extension" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-stamps.jpg' ); ?>" /></a>
            <p>The WP EasyCart Stamps.com extension allows you to purchase and print packaging labels for EasyCart orders directly with Stamps.com account.</p>
            <?php echo ( $button != 'custom' ) ? $button : '<a href="https://www.wpeasycart.com/wordpress-usps-stamps-extension/" target="_blank" class="get-extension">Learn More</a>'; ?><br>
			 <a href="http://docs.wpeasycart.com/wp-easycart-extensions-guide/?section=stamps-com" target="_blank" class="get-extension">Intallation Guide</a>
        </div>
		<div class="ec_admin_extension_item">
        	<h3>BlueCheck</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="Mandrill Extension" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-mandrill.jpg' ); ?>" /></a>
            <p>The Mandrill extension will send your email subscribers from EasyCart to the Mandrill email system for more professional email sending.</p>
            <?php echo ( $button != 'custom' ) ? $button : '<a href="https://www.wpeasycart.com/wordpress-mandrill-extension/" target="_blank" class="get-extension">Learn More</a>'; ?><br>
			 <a href="http://docs.wpeasycart.com/wp-easycart-extensions-guide/?section=mandrill-email" target="_blank" class="get-extension">Intallation Guide</a>
        </div>
        <div class="ec_admin_extension_item">
        	<h3>BlueCheck</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="BlueCheck Extension" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-bluecheck.jpg' ); ?>" /></a>
            <p>This plugin allows you to verify the age of your customers when selling vapor and eCigarette type goods. Learn more about BlueCheck at <a href="http://www.bluecheck.me/" target="_blank">http://www.bluecheck.me/</a>.</p>
            <?php echo ( $button != 'custom' ) ? $button : '<a href="https://www.wpeasycart.com/wordpress-bluecheck-extension/" target="_blank" class="get-extension">Learn More</a>'; ?><br>
			 <a href="http://docs.wpeasycart.com/wp-easycart-extensions-guide/?section=bluecheck" target="_blank" class="get-extension">Intallation Guide</a>
        </div>
		
		
		
		<!--column 3-->
        <div class="ec_admin_extension_item">
        	<h3>Android App</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="Android App" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-android.jpg' ); ?>" /></a>
            <p>Manage your store from your Android device with the WP EasyCart iPad Application. Download from the Google Play app store today!</p>
            <?php echo ( $android_button != 'custom' ) ? $android_button : '<a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank" class="get-extension">Learn More</a>'; ?>
        </div>
		<div class="ec_admin_extension_item">
        	<h3>Facebook & Instagram</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="Groupon Extension" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-facebook.jpg' ); ?>" /></a>
            <p>Sell your products on Facebook & Instagram with the new feed extension.  Quickly pull products into Facebook dynamically or via CSV.</p>
            <?php echo ( $button != 'custom' ) ? $button : '<a href="https://www.wpeasycart.com/wordpress-facebook-instagram-extension/" target="_blank" class="get-extension">Learn More</a>'; ?><br>
			 <a href="http://docs.wpeasycart.com/wp-easycart-extensions-guide/?section=facebook-instagram" target="_blank" class="get-extension">Intallation Guide</a>
        </div>
        <div class="ec_admin_extension_item">
        	<h3>Groupon</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="Groupon Extension" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-groupon.jpg' ); ?>" /></a>
            <p>Import your Groupon coupon codes quickly into your WP EasyCart system.</p>
            <?php echo ( $button != 'custom' ) ? $button : '<a href="https://www.wpeasycart.com/wordpress-groupon-extension/" target="_blank" class="get-extension">Learn More</a>'; ?><br>
			 <a href="http://docs.wpeasycart.com/wp-easycart-extensions-guide/?section=groupon-importer" target="_blank" class="get-extension">Intallation Guide</a>
        </div>
        <div class="ec_admin_extension_item">
        	<h3>Quickbooks</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="Quickbooks Extension" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-quickbooks.jpg' ); ?>" /></a>
            <p>The EasyCart QuickBooks integration plugin allows you to seamlessly have order information, customer account data, and even product information flow from EasyCart to your QuickBooks.</p>
            <?php echo ( $button != 'custom' ) ? $button : '<a href="https://www.wpeasycart.com/wordpress-quickbooks-extension/" target="_blank" class="get-extension">Learn More</a>'; ?><br>
			 <a href="http://docs.wpeasycart.com/wp-easycart-extensions-guide/?section=quickbooks" target="_blank" class="get-extension">Intallation Guide</a>
        </div>
        <div class="ec_admin_extension_item">
        	<h3>Optimal Logistics</h3>
            <a href="https://www.wpeasycart.com/wordpress-ecommerce-premium-edition/" target="_blank"><img alt="Optimal Logistics Extension" src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/admin/images/extension-optimalship.jpg' ); ?>" /></a>
            <p>This plugin allows you to use Optimalship to get a single DHL rate for international orders.</p>
            <?php echo ( $button != 'custom' ) ? $button : '<a href="https://www.wpeasycart.com/wordpress-optimalship-extension/" target="_blank" class="get-extension">Learn More</a>'; ?><br>
			 <a href="http://docs.wpeasycart.com/wp-easycart-extensions-guide/?section=optimal-logistics" target="_blank" class="get-extension">Intallation Guide</a>
        </div>
    </div>
</div>
	