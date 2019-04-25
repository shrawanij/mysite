<div class="ec_admin_list_line_item ec_admin_demo_data_line" style="float:left;">
                
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_tax_by_country_loader" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-welcome-add-page"></div><span>Tax By Country</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'taxes', 'tax-by-country-setup');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'taxes', 'tax-by-country-setup');?></div>
    
    <div class="ec_admin_settings_input ec_admin_settings_tax_section">
        <?php
        $country_tax_rates = $this->wpdb->get_results( "SELECT ec_taxrate.*, ec_country.name_cnt FROM ec_taxrate LEFT JOIN ec_country ON ec_country.iso2_cnt = ec_taxrate.country_code WHERE ec_taxrate.tax_by_country = 1 ORDER BY ec_country.sort_order ASC" );
        $countries = $this->wpdb->get_results( "SELECT * FROM ec_country WHERE ship_to_active = 1 ORDER BY sort_order ASC" );
        ?>
        <span <?php if( count( $country_tax_rates ) == 0 ){ ?>style="display:none;" <?php }?>id="modify_country_tax_rates_header">Modify Country Tax Rates</span>
        <?php
        if( count( $country_tax_rates ) ){
        foreach( $country_tax_rates as $country_tax_rate ){
        ?>
        <div class="ec_admin_tax_row" id="ec_admin_country_tax_row_<?php echo $country_tax_rate->taxrate_id; ?>">
            <span>
                <select name="ec_country_code_<?php echo $country_tax_rate->taxrate_id; ?>" id="ec_country_code_<?php echo $country_tax_rate->taxrate_id; ?>" style="float:left;">
                    <option value="0">Select a Country</option>
                    <?php foreach( $countries as $country ){ ?>
                    <option value="<?php echo $country->id_cnt; ?>"<?php if( $country->iso2_cnt == $country_tax_rate->country_code ){ ?> selected="selected"<?php }?>><?php echo $country->name_cnt; ?></option>
                    <?php }?>
                </select>
            </span>
            <span class="ec_admin_settings_tax_percentage">%</span>
            <input type="number" value="<?php echo $country_tax_rate->country_rate; ?>" step=".001" name="country_tax_rate_<?php echo $country_tax_rate->taxrate_id; ?>" id="country_tax_rate_<?php echo $country_tax_rate->taxrate_id; ?>" />
            </div>
        
        <div class="ec_admin_tax_button_row" id="ec_admin_country_tax_button_row_<?php echo $country_tax_rate->taxrate_id; ?>">
            <span><input class="ec_admin_tax_link_button" type="submit" value="Save" onclick="return ec_admin_save_country_tax( '<?php echo $country_tax_rate->taxrate_id; ?>' );" />
                <span class="ec_admin_tax_button_divider"> | </span>
                <a href="admin.php?page=wp-easycart-settings&subpage=tax&ec_admin_action=delete_tax_row&taxrate_id=<?php echo $country_tax_rate->taxrate_id; ?>" class="ec_admin_tax_link" onclick="return ec_admin_delete_country_tax_rate( '<?php echo $country_tax_rate->taxrate_id; ?>' );">Delete</a>
            </span>
        </div>
        
        <div class="ec_admin_settings_light_tax_divider" id="ec_admin_country_tax_divider_<?php echo $country_tax_rate->taxrate_id; ?>"></div>
            
        <?php }
        }?>
        <span <?php if( count( $country_tax_rates ) > 0 ){ ?>style="display:none;" <?php }?>id="modify_country_tax_rates_none_header">No Country Tax Rates Available</span>
        
        <div id="insert_new_country_tax_here"></div>
    </div>
    
    <div class="ec_admin_settings_input ec_admin_settings_tax_section">
        <div class="ec_admin_tax_row">
            <span>
                <select name="ec_new_country_code" id="ec_new_country_code" style="float:left;">
                    <option value="0">Select a Country</option>
                    <?php foreach( $countries as $country ){ ?>
                    <option value="<?php echo $country->id_cnt; ?>"><?php echo $country->name_cnt; ?></option>
                    <?php }?>
                </select>
            </span>
            <span class="ec_admin_settings_tax_percentage">%</span>
            <input name="ec_new_country_rate" id="ec_new_country_rate" type="number" value="0.000" step=".001" />
        </div>
        <div class="ec_admin_tax_button_row_last">
            <span><input class="ec_admin_tax_link_button" type="submit" value="+ Add New" onclick="return ec_admin_add_country_tax_rate( );" /></span>
        </div>
    </div>
    
    <div class="ec_admin_tax_spacer"></div>
    
</div>

<div class="ec_admin_settings_tax_clear"></div>