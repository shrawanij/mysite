<?php wp_easycart_admin( )->load_new_slideout( 'product' ); ?>
<?php wp_easycart_admin( )->load_new_slideout( 'manufacturer' ); ?>
<?php wp_easycart_admin( )->load_new_slideout( 'optionset' ); ?>
<?php wp_easycart_admin( )->load_new_slideout( 'advanced-optionset' ); ?>

<div class="ec_admin_message_error" id="ec_admin_product_activate_error"<?php if( !$this->id || $this->product->activate_in_store ){ ?> style="display:none;"<?php }?>>Your product is NOT ACTIVE and is currently not showing on your online store <a href="#" style="float:right; margin:0 15px 0;" onclick="jQuery( document.getElementById( 'activate_in_store' ) ).prop( 'checked', true ); ec_admin_save_product_details_basic( ); jQuery( this ).parent( ).fadeOut( ); return false;">Activate</a></div>
<div class="ec_admin_message_error" id="ec_admin_product_store_startup_error"<?php if( !$this->id || $this->product->show_on_startup ){ ?> style="display:none;"<?php }?>>Your product is NOT showing on your main store page. <a href="#" style="float:right; margin:0 15px 0;" onclick="jQuery( document.getElementById( 'show_on_startup' ) ).prop( 'checked', true ); ec_admin_save_product_details_general_options( ); jQuery( this ).parent( ).fadeOut( ); return false;">Add to Store</a></div>

<input type="hidden" name="ec_admin_form_action" value="<?php echo $this->form_action; ?>" />
<input type="hidden" name="product_id" id="product_id"value="<?php echo $this->product->product_id; ?>" />
  
  <div class="ec_admin_settings_panel ec_admin_details_panel">
    <div class="ec_admin_important_numbered_list">
      
      <div class="ec_admin_flex_row">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_basic_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-tag"></div>
            <span id="product_title"><?php if( !$this->id ){ ?>CREATE NEW PRODUCT<?php }else{ ?>EDIT PRODUCT<?php }?></span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('products', 'products', 'details');?>
                <a href="admin.php?page=wp-easycart-products&subpage=products&ec_admin_form_action=add-new" class="ec_page_title_button<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>" id="ec_admin_product_details_add_new_button" onclick="wp_easycart_admin_open_slideout( 'new_product_box' ); return false;">Add New Product</a>
                <a href="<?php echo wp_easycart_admin_products( )->get_product_link( $this->product->product_id ); ?>" target="_blank" class="ec_page_title_button<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>" id="ec_admin_product_details_view_product_link">View Product</a>
                <a href="<?php echo $this->action; ?>" class="ec_page_title_button">Back to Products</a>
            </div>
          </div>
          <div class="ec_admin_settings_input ec_admin_settings_currency_section">
            <?php do_action( 'wp_easycart_admin_product_details_basic_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" id="product_create_button" onclick="return ec_admin_save_product_details_basic( );" value="<?php if( !$this->id ){ ?>Create New Product<?php }else{ ?>Update Product<?php }?>" />
            </div>
          </div>
        </div>
      </div>
      <?php do_action( 'wp_easycart_admin_product_details_sections_pre' ); ?>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_images_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-format-gallery"></div>
            <span>PRODUCT IMAGES</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#images" class="ec_admin_expand_section" data-section="ec_admin_product_details_images_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_images_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Images</div>
            <?php do_action( 'wp_easycart_admin_product_details_images_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_images( );" value="Update Images" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_address_line_item ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_quantities_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-chart-area"></div>
            <span>QUANTITY OPTIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#quantities" class="ec_admin_expand_section" data-section="ec_admin_product_details_quantities_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_quantities_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Quantity</div>
            <?php do_action( 'wp_easycart_admin_product_details_quantity_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_quantities( );" value="Update Quanties" />
            </div>
            <?php do_action( 'wp_easycart_admin_product_details_optionitem_quantity_fields' ); ?>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_address_line_item ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_pricing_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-chart-pie"></div>
            <span>PRICING OPTIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#pricing" class="ec_admin_expand_section" data-section="ec_admin_product_details_pricing_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_pricing_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Pricing</div>
            <?php do_action( 'wp_easycart_admin_product_details_pricing_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_pricing( );" value="Update Pricing" />
            </div>
            <?php do_action( 'wp_easycart_admin_product_details_advanced_pricing_fields' ); ?>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_options_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-admin-settings"></div>
            <span>OPTION SETS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#options" class="ec_admin_expand_section" data-section="ec_admin_product_details_options_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_options_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">&nbsp;&nbsp;&nbsp;</div>
            
            <div class="ec_admin_option_add_new_row"><input type="button" value="CREATE NEW OPTION SET" onclick="ec_admin_open_new_option( );" /></div>
            
            <?php do_action( 'wp_easycart_admin_product_details_options_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_options( );" value="Update Options" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_general_options_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-admin-tools"></div>
            <span>BASIC SETTINGS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#general-options" class="ec_admin_expand_section" data-section="ec_admin_product_details_general_options_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_general_options_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">General Options</div>
            <?php do_action( 'wp_easycart_admin_product_details_general_options_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_general_options( );" value="Update General Options" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_address_line_item ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_featured_products_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-exerpt-view"></div>
            <span>FEATURED PRODUCTS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#featured-products" class="ec_admin_expand_section" data-section="ec_admin_product_details_featured_products_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_featured_products_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Featured Products</div>
            <?php do_action( 'wp_easycart_admin_product_details_featured_products_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_featured_products( );" value="Update Featured Products" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_seo_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-chart-area"></div>
            <span>SEO OPTIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#seo" class="ec_admin_expand_section" data-section="ec_admin_product_details_seo_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_seo_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">SEO</div>
            <?php do_action( 'wp_easycart_admin_product_details_seo_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_seo( );" value="Update SEO" />
            </div>
          </div>
        </div>
      </div>
      
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_menus_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-forms"></div>
            <span>MENU LOCATIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#menus" class="ec_admin_expand_section" data-section="ec_admin_product_details_menus_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_menus_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Menus</div>
            <?php do_action( 'wp_easycart_admin_product_details_menus_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_menus( );" value="Update Menus" />
            </div>
          </div>
        </div>
      </div>
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_categories_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-list-view"></div>
            <span>CATEGORY LOCATIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#categories" class="ec_admin_expand_section" data-section="ec_admin_product_details_categories_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_categories_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Categories</div>
            <?php do_action( 'wp_easycart_admin_product_details_categories_fields' ); ?>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_packaging_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-move"></div>
            <span>PACKAGING OPTIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#packaging" class="ec_admin_expand_section" data-section="ec_admin_product_details_packaging_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_packaging_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Packaging</div>
            <?php do_action( 'wp_easycart_admin_product_details_packaging_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_packaging( );" value="Update Packaging" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_shipping_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-store"></div>
            <span>SHIPPING OPTIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#shipping" class="ec_admin_expand_section" data-section="ec_admin_product_details_shipping_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_shipping_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Shipping</div>
             <?php do_action( 'wp_easycart_admin_product_details_shipping_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_shipping( );" value="Update Shipping" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_tax_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-cart"></div>
            <span>TAX OPTIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#tax" class="ec_admin_expand_section" data-section="ec_admin_product_details_tax_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_tax_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Tax</div>
            <?php do_action( 'wp_easycart_admin_product_details_tax_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_tax( );" value="Update Tax" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_address_line_item ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_short_description_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-menu"></div>
            <span>SHORT DESCRIPTION</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#short-description" class="ec_admin_expand_section" data-section="ec_admin_product_details_short_description_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_short_description_section">
            <?php do_action( 'wp_easycart_admin_product_details_short_description_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_short_description( );" value="Update Short Description" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_address_line_item ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_specifications_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-analytics"></div>
            <span>SPECIFICATIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#specifications" class="ec_admin_expand_section" data-section="ec_admin_product_details_specifications_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_specifications_section">
            <?php do_action( 'wp_easycart_admin_product_details_specifications_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_specifications( );" value="Update Specifications" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_address_line_item ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_ordercompleted_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-welcome-write-blog"></div>
            <span>ORDER COMPLETED NOTE</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#ordercompleted" class="ec_admin_expand_section" data-section="ec_admin_product_details_ordercompleted_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_ordercompleted_section">
            <?php do_action( 'wp_easycart_admin_product_details_order_completed_note_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_order_completed_note( );" value="Update Note" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_address_line_item ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_ordercompleted_email_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-welcome-write-blog"></div>
            <span>ORDER EMAIL NOTE</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#ordercompletedemail" class="ec_admin_expand_section" data-section="ec_admin_product_details_ordercompletedemail_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_ordercompletedemail_section">
            <?php do_action( 'wp_easycart_admin_product_details_order_completed_email_note_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_order_completed_email_note( );" value="Update Note" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_address_line_item ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_ordercompleted_details_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-welcome-write-blog"></div>
            <span>ORDER DETAILS NOTE</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#ordercompleteddetails" class="ec_admin_expand_section" data-section="ec_admin_product_details_ordercompleteddetails_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_ordercompleteddetails_section">
            <?php do_action( 'wp_easycart_admin_product_details_order_completed_details_note_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_order_completed_details_note( );" value="Update Note" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_address_line_item ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_tags_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-tablet"></div>
            <span>IMAGE TAGS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#tags" class="ec_admin_expand_section" data-section="ec_admin_product_details_tags_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_tags_section">
            <?php do_action( 'wp_easycart_admin_product_details_tags_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_tags( );" value="Update Tags" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_downloads_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-arrow-down-alt"></div>
            <span>DOWNLOAD OPTIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#downloads" class="ec_admin_expand_section" data-section="ec_admin_product_details_downloads_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_downloads_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Downloads</div>
            <?php do_action( 'wp_easycart_admin_product_details_downloads_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_downloads( );" value="Update Downloads" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_subscription_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-image-rotate"></div>
            <span>SUBSCRIPTION OPTIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#subscription" class="ec_admin_expand_section" data-section="ec_admin_product_details_subscription_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_subscription_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Subscription</div>
            <?php do_action( 'wp_easycart_admin_product_details_subscription_fields' ); ?>
            <div style="font-size:12px;">*NOTE: This product type is only compatible with Stripe and PayPal</div>
          	<div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_subscription( );" value="Update Subscription" />
            </div>
          </div>
        </div>
      </div>
      
      <div class="ec_admin_flex_row<?php if( !$this->id ){ ?> ec_admin_hidden<?php }?>">
        <div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first ec_admin_collapsable">
          <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_product_details_deconetwork_loader" ); ?>
          <div class="ec_admin_settings_label">
            <div class="dashicons-before dashicons-admin-appearance"></div>
            <span>DECONETWORK OPTIONS</span>
            <div class="ec_page_product_title_button_wrap ec_page_title_button_wrap">
            	<a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
              		<div class="dashicons-before ec_help_icon dashicons-info"></div>
              	</a>
            </div>
            <a href="#deconetwork" class="ec_admin_expand_section" data-section="ec_admin_product_details_deconetwork_section"><div class="dashicons-before dashicons-arrow-down-alt2"></div></a>
          </div>
          <div class="ec_admin_settings_input ec_admin_collapsed_section" id="ec_admin_product_details_deconetwork_section">
            <div id="ec_admin_row_heading_title" class="ec_admin_row_heading_title">Deconetwork</div>
            <?php do_action( 'wp_easycart_admin_product_details_deconetwork_fields' ); ?>
            <div class="ec_admin_products_submit">
                <input type="submit" class="ec_admin_products_simple_button" onclick="return ec_admin_save_product_details_deconetwork( );" value="Update Deconetwork" />
            </div>
          </div>
        </div>
      </div>
      
      <?php do_action( 'wp_easycart_admin_product_details_sections_post' ); ?>
      
      <div class="ec_admin_details_footer">
        <div class="ec_page_title_button_wrap"> <a href="<?php echo $this->docs_link; ?>" target="_blank" class="ec_help_icon_link">
          <div class="dashicons-before ec_help_icon dashicons-info"></div>
          </a> 
          <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('products', 'products', 'details');?>
          <a href="<?php echo $this->action; ?>" class="ec_page_title_button">Back to Products</a>
        </div>
      </div>
    </div>
  </div>