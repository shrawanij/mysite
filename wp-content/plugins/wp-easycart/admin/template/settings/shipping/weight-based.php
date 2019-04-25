<?php
$weight_triggers = $this->wpdb->get_results( "SELECT * FROM ec_shippingrate WHERE is_weight_based = 1 ORDER BY trigger_rate ASC" );
$shipping_zones = $this->wpdb->get_results( "SELECT * FROM ec_zone ORDER BY zone_name ASC" );
$currency = new ec_currency( );
?>
<div class="ec_admin_settings_input ec_admin_settings_shipping_section ec_admin_settings_<?php if( wp_easycart_admin( )->settings->shipping_method == "weight" ){ ?>show<?php }else{?>hide<?php }?>" id="weight">
    <?php foreach( $weight_triggers as $trigger ){ ?>
    <div class="ec_admin_tax_row ec_admin_shipping_weight_trigger_row" id="ec_admin_weight_trigger_row_<?php echo $trigger->shippingrate_id; ?>">
    	<div class="ec_admin_shipping_trigger"><span>Weight Trigger: </span><input type="number" class="ec_admin_weight_trigger_input" step=".01" value="<?php echo $trigger->trigger_rate; ?>" name="ec_admin_weight_trigger_<?php echo $trigger->shippingrate_id; ?>" id="ec_admin_new_weight_trigger_<?php echo $trigger->shippingrate_id; ?>" /></div>
        <div class="ec_admin_shipping_rate"><span>Shipping Rate: <?php echo $currency->symbol; ?></span><input type="number" class="ec_admin_weight_trigger_rate_input" step=".01" value="<?php echo $currency->get_number_only( $trigger->shipping_rate ); ?>" name="ec_admin_weight_trigger_rate_<?php echo $trigger->shippingrate_id; ?>" id="ec_admin_new_weight_trigger_rate_<?php echo $trigger->shippingrate_id; ?>" /></div>
    	<div class="ec_admin_shipping_rate"><span>Shipping Zone: </span><select class="ec_admin_weight_trigger_zone_id_input" name="ec_admin_weight_trigger_zone_id_<?php echo $trigger->shippingrate_id; ?>" id="ec_admin_weight_trigger_zone_id_<?php echo $trigger->shippingrate_id; ?>">
        	<option value="0">No Zone</option>
            <?php foreach( $shipping_zones as $zone ){ ?>
            <option value="<?php echo $zone->zone_id; ?>"<?php if( $zone->zone_id == $trigger->zone_id ){ ?> selected="selected"<?php }?>><?php echo $zone->zone_name; ?></option>
            <?php }?>
        </select></div>
    	<span class="ec_admin_shipping_rate_delete"><div class="dashicons-before dashicons-trash" onclick="ec_admin_delete_weight_trigger( '<?php echo $trigger->shippingrate_id; ?>' );"></div></span>
    </div>
    <?php } ?>
    
    <div id="insert_new_weight_trigger_here"></div>
    
    <div id="ec_admin_no_weight_triggers"<?php if( count( $weight_triggers ) > 0 ){ ?> style="display:none;"<?php }?>>No Weight Triggers Entered</div>
       
    <div class="ec_admin_settings_shipping_input">
        <input type="submit" class="ec_admin_settings_simple_button" value="Save Triggers" onclick="return ec_admin_save_shipping_weight_triggers( );" />
    </div>

	<div class="ec_admin_settings_shipping_divider"></div>

    <span>Add Weight Trigger</span>
    
    <div class="ec_admin_tax_row ec_admin_shipping_weight_trigger_row">
        <div class="ec_admin_shipping_trigger"><span>Weight Trigger: </span><input type="number" step=".01" value="0.00" name="ec_admin_new_weight_trigger" id="ec_admin_new_weight_trigger" /></div>
        <div class="ec_admin_shipping_rate"><span>Shipping Rate: <?php echo $currency->symbol; ?></span><input type="number" step=".01" value="<?php echo $currency->get_number_only( 0.00 ); ?>" name="ec_admin_new_weight_trigger_rate" id="ec_admin_new_weight_trigger_rate" /></div>
    	<div class="ec_admin_shipping_rate"><span>Shipping Zone: </span><select name="ec_admin_new_weight_trigger_zone_id" id="ec_admin_new_weight_trigger_zone_id">
        	<option value="0">No Zone</option>
            <?php foreach( $shipping_zones as $zone ){ ?>
            <option value="<?php echo $zone->zone_id; ?>"><?php echo $zone->zone_name; ?></option>
            <?php }?>
        </select></div>
    	<div class="ec_admin_settings_shipping_input">
            <input type="submit" class="ec_admin_settings_simple_button" value="Add New" onclick="return ec_admin_add_new_shipping_weight_trigger( );" />
        </div>
    </div>
    
</div>