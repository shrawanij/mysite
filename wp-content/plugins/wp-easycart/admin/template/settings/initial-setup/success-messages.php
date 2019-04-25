<?php if( isset( $_GET['success'] ) && $_GET['success'] == "easycart-initial-setup" ){ ?>
	<div class="ec_admin_success_message"><div>Your initial setup has been updated successfully.</div></div>
<?php }else if( isset( $_GET['success'] ) && $_GET['success'] == "easycart-storepage-added" ){ ?>
	<div class="ec_admin_success_message"><div>The product page has been created successfully.</div></div>
<?php }else if( isset( $_GET['success'] ) && $_GET['success'] == "easycart-cartpage-added" ){ ?>
	<div class="ec_admin_success_message"><div>The cart page has been created successfully.</div></div>
<?php }else if( isset( $_GET['success'] ) && $_GET['success'] == "easycart-accountpage-added" ){ ?>
	<div class="ec_admin_success_message"><div>The account page has been created successfully.</div></div>
<?php }else if( isset( $_GET['success'] ) && $_GET['success'] == "easycart-demo-data-installed" ){ ?>
	<div class="ec_admin_success_message"><div>The demo data has been installed successfully.</div></div>
<?php }else if( isset( $_GET['success'] ) && $_GET['success'] == "easycart-demo-data-uninstalled" ){ ?>
	<div class="ec_admin_success_message"><div>The demo data has been uninstalled successfully.</div></div>
<?php } ?>