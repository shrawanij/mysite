<h3>Page Setup</h3>
<p>Your store needs a few pages to operate. The following pages have <strong>already been created automatically</strong> for you (if they did not already exist).</p>
<div class="ec_admin_wizard_page_row">
	<div class="ec_admin_wizard_page_row_title"><a href="<?php echo wp_easycart_admin( )->store_page; ?>" target="_blank">Store</a></div>
    <div class="ec_admin_wizard_page_row_content">This is where your customers will enter your store and begin shopping.</div>
    <div style="clear:both;"></div>
</div>
<div class="ec_admin_wizard_page_row">
	<div class="ec_admin_wizard_page_row_title"><a href="<?php echo wp_easycart_admin( )->cart_page; ?>" target="_blank">Shopping Cart</a></div>
    <div class="ec_admin_wizard_page_row_content">This page displays the shopping cart and checkout to the customer.</div>
    <div style="clear:both;"></div>
</div>
<div class="ec_admin_wizard_page_row">
	<div class="ec_admin_wizard_page_row_title"><a href="<?php echo wp_easycart_admin( )->account_page; ?>" target="_blank">My Account</a></div>
    <div class="ec_admin_wizard_page_row_content">This page displays the customer's account, order history, and other information.</div>
    <div style="clear:both;"></div>
</div>
<div class="ec_admin_wizard_page_row">
	<p>We recommend adding your store, account, and cart to your menu. You can show these pages on your site by adding them to your menu via <a href="nav-menus.php" target="_blank">Appearance >> Menus</a></p>
	<div style="clear:both;"></div>
</div>
<div class="ec_admin_wizard_button_bar">
	<a href="admin.php?page=wp-easycart-settings&ec_admin_form_action=skip-wizard" class="ec_admin_wizard_quit_button">Skip Setup Wizard</a>
    <a href="admin.php?page=wp-easycart-products&subpage=products">Setup Later</a>
    <a href="admin.php?page=wp-easycart-settings&subpage=setup-wizard&step=2" class="ec_admin_wizard_next_button">Continue</a>
</div>