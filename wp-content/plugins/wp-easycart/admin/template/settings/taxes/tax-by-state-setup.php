<div class="ec_admin_list_line_item ec_admin_demo_data_line" style="float:left;">
                
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_tax_by_state_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-welcome-add-page"></div><span>Tax By State</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'taxes', 'tax-by-state-setup');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'taxes', 'tax-by-state-setup');?></div>
    
    <div class="ec_admin_settings_input ec_admin_settings_tax_section">
        
        <?php
        $states = $this->wpdb->get_results( "SELECT ec_state.*, ec_country.iso2_cnt as country_code FROM ec_state LEFT JOIN ec_country ON ec_country.id_cnt = ec_state.idcnt_sta WHERE ec_state.ship_to_active = 1 ORDER BY ec_country.sort_order ASC, ec_state.name_sta ASC" );
        $state_tax_rates = $this->wpdb->get_results( "SELECT ec_taxrate.*, ec_state.name_sta, ec_country.name_cnt FROM ec_taxrate LEFT JOIN ec_country ON ( ec_country.iso2_cnt = ec_taxrate.country_code ) LEFT JOIN ec_state ON (ec_state.code_sta = ec_taxrate.state_code AND idcnt_sta = ec_country.iso2_cnt ) WHERE tax_by_state = 1 ORDER BY ec_country.`sort_order` ASC, ec_state.name_sta ASC, ec_taxrate.`state_code` ASC" );
        ?>
        <span <?php if( count( $state_tax_rates ) == 0 ){ ?>style="display:none;" <?php }?>id="modify_state_tax_rates_header">Modify State Tax Rates</span>
        
        <?php
        if( count( $state_tax_rates ) > 0 ){
            foreach( $state_tax_rates as $state_tax_rate ){
            ?>
            
            <div class="ec_admin_tax_row" id="ec_admin_state_tax_row_<?php echo $state_tax_rate->taxrate_id; ?>">
                <span>
                <select name="ec_state_code_<?php echo $state_tax_rate->taxrate_id; ?>" id="ec_state_code_<?php echo $state_tax_rate->taxrate_id; ?>" style="float:left;">
                    <option value="0">Select a State</option>
                    <?php foreach( $states as $state ){ ?>
                    <option value="<?php echo $state->id_sta; ?>"<?php if( $state->code_sta == $state_tax_rate->state_code && ( $state_tax_rate->country_code == "" || $state_tax_rate->country_code == $state->country_code ) ){ ?> selected="selected"<?php }?>><?php echo $state->name_sta; ?></option>
                    <?php }?>
                </select>
                </span>
                <span class="ec_admin_settings_tax_percentage">%</span>
                <input type="number" value="<?php echo $state_tax_rate->state_rate; ?>" step=".001" name="state_tax_rate_<?php echo $state_tax_rate->taxrate_id; ?>" id="state_tax_rate_<?php echo $state_tax_rate->taxrate_id; ?>" />
            </div>
            
            <div class="ec_admin_tax_button_row" id="ec_admin_state_tax_button_row_<?php echo $state_tax_rate->taxrate_id; ?>">
                <span><input class="ec_admin_tax_link_button" type="submit" value="Save" onclick="return ec_admin_save_state_tax( '<?php echo $state_tax_rate->taxrate_id; ?>' );" />
                <span class="ec_admin_tax_button_divider"> | </span>
                <a href="admin.php?page=wp-easycart-settings&subpage=tax&ec_admin_action=delete_tax_row&taxrate_id=<?php echo $state_tax_rate->taxrate_id; ?>" class="ec_admin_tax_link" onclick="return ec_admin_delete_state_tax_rate( '<?php echo $state_tax_rate->taxrate_id; ?>' );">Delete</a></span>
            </div>
            
            <div class="ec_admin_settings_light_tax_divider" id="ec_admin_state_tax_divider_<?php echo $state_tax_rate->taxrate_id; ?>"></div>
            
            <?php }?>
        <?php } ?>
        <span <?php if( count( $state_tax_rates ) > 0 ){ ?>style="display:none;" <?php }?>id="modify_state_tax_rates_none_header">No State Tax Rates Available</span>
        <div id="insert_new_state_tax_here"></div>
    </div>
    
    
    <div class="ec_admin_settings_input ec_admin_settings_tax_section">
        
        <span>Add State Tax Rate</span>
        
        <div class="ec_admin_tax_row">
            <span>
                <select name="ec_new_state_code" id="ec_new_state_code" style="float:left;">
                    <option value="0">Select a State</option>
                    <?php foreach( $states as $state ){ ?>
                    <option value="<?php echo $state->id_sta; ?>"><?php echo $state->name_sta; ?></option>
                    <?php }?>
                </select>
            </span>
            <span class="ec_admin_settings_tax_percentage">%</span>
            <input name="ec_new_state_rate" id="ec_new_state_rate" type="number" value="0.000" step=".001" />
        </div>
        <div class="ec_admin_tax_button_row_last">
            <span><input class="ec_admin_tax_link_button" type="submit" value="+ Add New" onclick="return ec_admin_add_state_tax_rate( );" /></span>
        </div>
        <div class="ec_admin_tax_spacer"></div>
    </div>
    
</div>