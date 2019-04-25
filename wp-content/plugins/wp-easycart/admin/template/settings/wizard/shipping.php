<form action="" method="POST" name="wpeasycart_admin_setup_wizard_form" id="wpeasycart_admin_setup_wizard_form" novalidate="novalidate">
<input type="hidden" name="ec_admin_form_action" id="ec_admin_form_action" value="process-wizard-shipping">
<h3>Shipping</h3>
<p>WP EasyCart offers static shipping rates, weight based rates, cart total based rates, and a few more by default. You can upgrade to PRO and activate live shipping rates with UPS, USPS, FedEx, DHL, CanadaPost, or Australia Post later. For now, please choose a preferred method below and let EasyCart install some common shipping rates for you and your store's location.</p>
<div class="ec_admin_wizard_input_row">
	<div class="ec_admin_wizard_input_row_title">Shipping Method</div>
	<div class="ec_admin_wizard_input_row_input"><select name="shipping_method" id="wp_easycart_shipping_method" class="select2-basic">
    	<option value="static">Static Rates</option>
        <option value="price">Cart Total Based Rates</option>
        <option value="weight">Weight Based Rates</option>
    </select></div>
</div>
<?php $trial_note = '<div class="ec_admin_wizard_input_row">
	<div class="ec_admin_wizard_input_row_title">Live Shipping Rates</div>
	<div class="ec_admin_wizard_input_row_input" style="padding-right:100px;">UPS, FedEx, USPS, DHL, CanadaPost, and Australia Post are all available in Professional or Premium<br /><a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=shipping-rates" target="_blank">VIEW DETAILS</a> | <a href="admin.php?page=wp-easycart-registration&ec_trial=start" target="_blank">TRY WITH 14 DAY FREE TRIAL</a></div>
    <div style="clear:both;"></div>
</div>';
echo apply_filters( 'wp_easycart_trial_start_content', $trial_note ); ?>
<div class="ec_admin_wizard_button_bar">
	<a href="admin.php?page=wp-easycart-settings&ec_admin_form_action=skip-wizard" class="ec_admin_wizard_quit_button">Skip Setup Wizard</a>
    <a href="admin.php?page=wp-easycart-products&subpage=products">Setup Later</a>
    <input type="submit" class="ec_admin_wizard_next_button" value="Save &amp; Continue" />
</div>