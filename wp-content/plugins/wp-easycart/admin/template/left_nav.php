<?php
$admin_page_variable = "";
if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" ){
	$admin_page_variable = "wp-easycart-products";
}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-orders" ){
	$admin_page_variable = "wp-easycart-orders";
}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-users" ){
	$admin_page_variable = "wp-easycart-users";
}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-rates" ){
	$admin_page_variable = "wp-easycart-rates";
}else if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-registration" ){
	$admin_page_variable = "wp-easycart-registration";
}
?>

<!--DASHBOARD-->
<div class="ec_admin_left_nav_item<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-dashboard" ){ ?> ec_admin_left_nav_selected<?php }?>">
	<div class="ec_admin_left_nav_icon dashicons-before dashicons-admin-home"></div>
	<div class="ec_admin_left_nav_label"><a href="admin.php?page=wp-easycart-dashboard">Dashboard</a></div>
</div>
<!--<div class="ec_admin_left_nav_item<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-reports" ){ ?> ec_admin_left_nav_selected<?php }?>">
	<div class="ec_admin_left_nav_icon dashicons-before dashicons-chart-area"></div>
	<div class="ec_admin_left_nav_label"><a href="admin.php?page=wp-easycart-reports">Reports</a></div>
</div>-->

<!--PRODUCTS-->
<div class="ec_admin_left_nav_item<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" ){ ?> ec_admin_left_nav_selected<?php }?>">
	<div class="ec_admin_left_nav_icon dashicons-before dashicons-products"></div>
	<div class="ec_admin_left_nav_label"><a href="admin.php?page=wp-easycart-products&subpage=products">Products</a></div>
</div>

<div class="ec_admin_left_submenu<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" ){ ?> ec_admin_left_submenu_open<?php }?>" id="ec_admin_products_submenu">
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-products" && ( ( isset( $_GET['subpage'] ) && $_GET['subpage'] == "products" ) || !isset( $_GET['subpage'] ) ) ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_products_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-products&subpage=products">Products</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "inventory" ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_options_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-products&subpage=inventory">Inventory</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && ( $_GET['subpage'] == "option" || $_GET['subpage'] == "optionitems" ) ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_options_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-products&subpage=option">Option Sets</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && ( $_GET['subpage'] == "category" || $_GET['subpage'] == "category-products" || $_GET['subpage'] == "category-products-manage" ) ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_categories_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-products&subpage=category">Categories</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && ( $_GET['subpage'] == "menus" || $_GET['subpage'] == "submenus" || $_GET['subpage'] == "subsubmenus" ) ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_menus_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-products&subpage=menus">Menus</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "manufacturers" ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_manufacturers_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-products&subpage=manufacturers">Manufacturers</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "reviews" ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_reviews_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-products&subpage=reviews">Product Reviews</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "subscriptionplans" ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_subscriptionplans_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-products&subpage=subscriptionplans">Subscription Plans<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; float:right;"></span>' ); ?></a></div>
    </div>
</div>

<!--ORDERS-->
<div class="ec_admin_left_nav_item<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-orders" ){ ?> ec_admin_left_nav_selected<?php }?>">
	<div class="ec_admin_left_nav_icon dashicons-before dashicons-tag"></div>
	<div class="ec_admin_left_nav_label"><a href="admin.php?page=wp-easycart-orders&subpage=orders">Orders</a></div>
</div>

<div class="ec_admin_left_submenu<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-orders" ){ ?> ec_admin_left_submenu_open<?php }?>" id="ec_admin_orders_submenu">
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-orders" && ( ( isset( $_GET['subpage'] ) && $_GET['subpage'] == "orders" ) || !isset( $_GET['subpage'] ) ) ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_orders_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-orders&subpage=orders">Orders</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "subscriptions" ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_subscriptions_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-orders&subpage=subscriptions">Subscriptions<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; float:right;"></span>' ); ?></a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "downloads" ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_downloads_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-orders&subpage=downloads">Manage Downloads<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; float:right;"></span>' ); ?></a></div>
    </div>
</div>

<!--USERS-->
<div class="ec_admin_left_nav_item<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-users" ){ ?> ec_admin_left_nav_selected<?php }?>">
	<div class="ec_admin_left_nav_icon dashicons-before dashicons-groups"></div>
	<div class="ec_admin_left_nav_label"><a href="admin.php?page=wp-easycart-users&subpage=accounts">Users</a></div>
</div>

<div class="ec_admin_left_submenu<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-users" ){ ?> ec_admin_left_submenu_open<?php }?>" id="ec_admin_users_submenu">
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-users" && ( ( isset( $_GET['subpage'] ) && $_GET['subpage'] == "accounts" ) || !isset( $_GET['subpage'] ) ) ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_accounts_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-users&subpage=accounts">User Accounts</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "user-roles" ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_subscribers_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-users&subpage=user-roles">User Roles</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "subscribers" ){ ?> ec_admin_left_nav_selected<?php }?>" id="ec_admin_subscribers_submenu_item">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-users&subpage=subscribers">Subscribers</a></div>
    </div>

</div>

<!--MARKETING-->
<div class="ec_admin_left_nav_item<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-rates" ){ ?> ec_admin_left_nav_selected<?php }?>">
	<div class="ec_admin_left_nav_icon dashicons-before dashicons-performance"></div>
	<div class="ec_admin_left_nav_label"><a href="admin.php?page=wp-easycart-rates&subpage=gift-cards">Marketing<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; float:right;"></span>' ); ?></a></div>
</div>

<div class="ec_admin_left_submenu<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-rates" ){ ?> ec_admin_left_submenu_open<?php }?>" id="ec_admin_rates_submenu">
    
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-rates" && ( ( isset( $_GET['subpage'] ) && $_GET['subpage'] == "gift-cards" ) || !isset( $_GET['subpage'] ) ) ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-rates&subpage=gift-cards">Gift Cards<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; float:right;"></span>' ); ?></a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "coupons" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-rates&subpage=coupons">Coupons<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; float:right;"></span>' ); ?></a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "promotions" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-rates&subpage=promotions">Promotions<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; float:right;"></span>' ); ?></a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "abandon-cart" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-rates&subpage=abandon-cart">Abandoned Cart<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; float:right;"></span>' ); ?></a></div>
    </div>
</div>

<!--SETTINGS-->
<div class="ec_admin_left_nav_item<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" ){ ?> ec_admin_left_nav_selected<?php }?>">
	<div class="ec_admin_left_nav_icon dashicons-before dashicons-admin-tools"></div>
	<div class="ec_admin_left_nav_label"><a href="admin.php?page=wp-easycart-settings">Settings</a></div>
</div>

<div class="ec_admin_left_submenu<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-settings" ){ ?> ec_admin_left_submenu_open<?php }?>" id="ec_admin_settings_submenu">
    <div class="ec_admin_left_nav_subitem<?php if( !isset( $_GET['subpage'] ) || ( isset( $_GET['subpage'] ) && $_GET['subpage'] == "initial-setup" ) ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=initial-setup">Initial Setup</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "products" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=products">Products</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "tax" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=tax">Taxes</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "shipping-settings" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=shipping-settings">Shipping Settings</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "shipping-rates" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=shipping-rates">Shipping Rates</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "payment" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=payment">Payment</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "checkout" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=checkout">Checkout</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "account" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=account">Accounts</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "miscellaneous" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=miscellaneous">Additional Settings</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "language-editor" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=language-editor">Language Editor</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "design" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=design">Design</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "email-setup" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=email-setup">Email Setup</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "third-party" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=third-party">Third Party</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "cart-importer" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=cart-importer">Cart Importer</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "country" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=country">Countries</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "states" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=states">States/Territories</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "perpage" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=perpage">Per Page Options</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "pricepoint" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=pricepoint">Price Points</a></div>
    </div>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == "logs" ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-settings&subpage=logs">Log Entries</a></div>
    </div>
</div>

<!--EXTENSIONS-->
<!--<div class="ec_admin_left_nav_item<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-extensions" ){ ?> ec_admin_left_nav_selected<?php }?>">
	<div class="ec_admin_left_nav_icon dashicons-before dashicons-admin-plugins"></div>
	<div class="ec_admin_left_nav_label"><a href="admin.php?page=wp-easycart-extensions">Extensions</a></div>
</div>

<div class="ec_admin_left_submenu<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-extensions" ){ ?> ec_admin_left_submenu_open<?php }?>" id="ec_admin_extensions_submenu">
    <?php $extensions = apply_filters( 'wp_easycart_admin_extensions_menu', array( ) ); ?>
    <?php foreach( $extensions as $extension ){ ?>
    <div class="ec_admin_left_nav_subitem<?php if( isset( $_GET['subpage'] ) && $_GET['subpage'] == $extension->subpage ){ ?> ec_admin_left_nav_selected<?php }?>">
        <div class="ec_admin_left_nav_sublabel"><a href="admin.php?page=wp-easycart-extensions&subpage=<?php echo $extension->subpage; ?>"><?php echo $extension->title; ?></a></div>
    </div>
    <?php } ?>
</div>-->
 
<!--STORE STATUS-->
<div class="ec_admin_left_nav_item<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-status" ){ ?> ec_admin_left_nav_selected<?php }?>">
	<div class="ec_admin_left_nav_icon dashicons-before dashicons-search"></div>
	<div class="ec_admin_left_nav_label"><a href="admin.php?page=wp-easycart-status&subpage=store-status">Store Status</a></div>
</div>

<!--registration-->
<div class="ec_admin_left_nav_item<?php if( isset( $_GET['page'] ) && $_GET['page'] == "wp-easycart-registration" ){ ?> ec_admin_left_nav_selected<?php }?>">
	<div class="ec_admin_left_nav_icon dashicons-before dashicons-unlock"></div>
	<div class="ec_admin_left_nav_label"><a href="admin.php?page=wp-easycart-registration&subpage=registration">Registration<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' <span class="dashicons dashicons-lock" style="color:#FC0; float:right;"></span>' ); ?></a></div>
</div>