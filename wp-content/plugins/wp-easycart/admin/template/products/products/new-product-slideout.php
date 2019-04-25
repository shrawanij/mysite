<?php
global $wpdb;
$manufacturer_list = $wpdb->get_results( "SELECT ec_manufacturer.manufacturer_id AS value, ec_manufacturer.name AS label FROM ec_manufacturer ORDER BY ec_manufacturer.name ASC" );
$basic_option_list = $wpdb->get_results( "SELECT ec_option.option_id AS value, ec_option.option_name AS label FROM ec_option WHERE option_type = 'basic-combo' OR option_type = 'basic-swatch' ORDER BY option_name ASC" );

?>
<div class="ec_admin_slideout_container" id="new_product_box" style="z-index:1028;">
    <div class="ec_admin_slideout_container_content">
        <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_new_product_display_loader" ); ?>
        <header class="ec_admin_slideout_container_content_header">
            <div class="ec_admin_slideout_container_content_header_inner">
                <h3>Create a Product</h3>
                <div class="ec_admin_slideout_close" onclick="wp_easycart_admin_close_slideout( 'new_product_box' );">
                    <div class="dashicons-before dashicons-no-alt"></div>
                </div>
            </div>
        </header>
        <div class="ec_admin_slideout_container_content_inner">
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_product_status">Product Status</label>
                <div>
                    <select id="ec_new_product_status" name="ec_new_product_status" class="select2-basic">
                        <option value="0">Not Active</option>
                        <option value="1" selected="selected">Active</option>
                    </select>
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_product_featured">Feature on Main Store Page?</label>
                <div>
                    <select id="ec_new_product_featured" name="ec_new_product_featured" class="select2-basic">
                        <option value="1" selected="selected">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_product_type">Product Type</label>
                <div>
                    <select id="ec_new_product_type" name="ec_new_product_type" class="select2-basic"<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' onchange="wp_easycart_admin_new_product_type_change( );"' ); ?>>
                        <option value="0" selected="selected">Classic Retail Product</option>
                         <option value="11">Service Product</option>
                        <option value="12">Ticket or Event</option>
                    	<option value="13">Class or Online Course</option>
                    	<option value="1">Downloadable Product<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' (PRO/PREMIUM ONLY)' ); ?></option>
                        <option value="2">eBook Product<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' (PRO/PREMIUM ONLY)' ); ?></option>
                        <option value="3">Donation Product<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' (PRO/PREMIUM ONLY)' ); ?></option>
                        <option value="4">Invoice Product<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' (PRO/PREMIUM ONLY)' ); ?></option>
                        <option value="5">Subscription Product<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' (PRO/PREMIUM ONLY)' ); ?></option>
                        <option value="6">Membership Product<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' (PRO/PREMIUM ONLY)' ); ?></option>
                        <option value="7">Gift Card Product<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' (PRO/PREMIUM ONLY)' ); ?></option>
                        <option value="8">Deconetwork Product<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' (PRO/PREMIUM ONLY)' ); ?></option>
                        <option value="9">Inquiry Product<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' (PRO/PREMIUM ONLY)' ); ?></option>
                        <option value="10">Seasonal/Coming Soon Product<?php echo apply_filters( 'wp_easycart_admin_lock_icon', ' (PRO/PREMIUM ONLY)' ); ?></option>
                    </select>
                </div>
                <div id="stripe_paypal_only" style="display:none; padding:10px 0; font-size:12px; text-align:right;">*NOTE: This product type is only compatible with Stripe and PayPal</div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_product_title">Title</label>
                <div>
                    <input type="text" id="ec_new_product_title" name="ec_new_product_title" placeholder="Your Product Name" />
                </div>
                <div class="ec_admin_slideout_error_text" id="title_required">
                	The title is required.
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_product_sku">SKU</label>
                <div>
                    <input type="text" id="ec_new_product_sku" name="ec_new_product_sku" placeholder="product-name" />
                </div>
                <div class="ec_admin_slideout_error_text" id="sku_required">
                	The SKU is required.
                </div>
                <div class="ec_admin_slideout_error_text" id="duplicate_sku">
                	Duplicate SKU, please change to a unique value.
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_product_manufacturer">Manufacturer</label>
                <div>
                	<div class="wpec-admin-75-select">
                        <select id="ec_new_product_manufacturer" name="ec_new_product_manufacturer" class="select2-basic">
                            <option value="0">Select One</option>
                            <?php foreach( $manufacturer_list as $manufacturer ){ ?>
                            <option value="<?php echo $manufacturer->value; ?>"><?php echo $manufacturer->label; ?></option>
                            <?php }?>
                        </select>
	                </div>
                	<input type="button" class="wpec-admin-upload-button" value="Add New" onclick="wp_easycart_admin_open_slideout( 'new_manufacturer_box' );" />
            	</div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_product_price">Price</label>
                <div>
                	<?php
                    $step = 1;
                    for( $i=0; $i<$GLOBALS['currency']->get_decimal_length( ); $i++ ){
                        $step = $step / 10;
                    }
					?>
                    <input type="number" step="<?php echo $step; ?>" id="ec_new_product_price" name="ec_new_product_price" placeholder="19.99" />
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_product_image">Image</label>
                <div>
                    <input type="text" id="ec_new_product_image" name="ec_new_product_image" class="wpec-admin-upload-input" />
					<input type="button" class="wpec-admin-upload-button" value="Select Image" id="ec_upload_button_image" onclick="ec_admin_image_upload( 'ec_new_product_image' );" />
                </div>
            </div>
            
            <div class="ec_admin_slideout_container_input_row"<?php if( !get_option( 'ec_option_admin_product_show_stock_option' ) ){ ?> style="display:none;"<?php }?>>
                <label for="ec_new_product_stock_option">Stock Options</label>
                <div>
                    <select id="ec_new_product_stock_option" name="ec_new_product_stock_option" class="select2-basic" onchange="ec_admin_new_product_update_stock_option( );">
                        <option value="0">Do Not Track Stock</option>
                        <option value="1">Track Basic Stock</option>
                        <option value="2">Track Option Item Stock</option>
                    </select>
            	</div>
            </div>
            <div class="ec_admin_slideout_container_input_row ec_admin_new_product_basic_stock" style="display:none;">
                <div>
                	<input type="number" step="1" id="ec_new_product_stock_quantity" name="ec_new_product_stock_quantity" placeholder="Stock Quantity" />
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row ec_admin_new_product_optionitem_stock" style="display:none; float:left; width:100%; margin-top:25px; text-align:center;">-- Option item quantities will be added when you edit the product --</div>
            
            <div class="ec_admin_slideout_container_input_row"<?php if( !get_option( 'ec_option_admin_product_show_shipping_option' ) ){ ?> style="display:none;"<?php }?>>
                <label for="ec_new_product_is_shippable">Shipping Options</label>
                <div>
                    <select id="ec_new_product_is_shippable" name="ec_new_product_is_shippable" class="select2-basic" onchange="ec_admin_new_product_update_shipping_type( );">
                        <option value="0">No Shipping</option>
                        <option value="1">Enable Shipping</option>
                    </select>
            	</div>
            </div>
            <div class="ec_admin_slideout_container_input_row ec_admin_new_product_shipping_row" style="display:none;">
                <div>
                	<div class="wpec-admin-50-wide">
                    	<input type="number" min="0" step=".01" id="ec_new_product_weight" name="ec_new_product_weight" placeholder="Weight" />
                    </div>
                	<div class="wpec-admin-50-wide">
                    	<input type="number" min="0" step=".01" id="ec_new_product_length" name="ec_new_product_length" placeholder="Length" />
                    </div>
                	<div class="wpec-admin-50-wide">
                    	<input type="number" min="0" step=".01" id="ec_new_product_width" name="ec_new_product_width" placeholder="Width" />
                    </div>
                	<div class="wpec-admin-50-wide">
                    	<input type="number" min="0" step=".01" id="ec_new_product_height" name="ec_new_product_height" placeholder="Height" />
                    </div>
                </div>
            </div>
            
            <div class="ec_admin_slideout_container_input_row"<?php if( !get_option( 'ec_option_admin_product_show_tax_option' ) ){ ?> style="display:none;"<?php }?>>
                <label for="ec_new_product_is_taxable">Tax Options</label>
                <div>
                    <select id="ec_new_product_is_taxable" name="ec_new_product_is_taxable" class="select2-basic">
                        <option value="0">Not Taxable</option>
                        <option value="1">Enable Tax</option>
                        <option value="2">Enable VAT</option>
                    </select>
            	</div>
            </div>
            
            <div class="ec_admin_slideout_container_input_row"<?php if( !get_option( 'ec_option_admin_product_show_variant_option' ) ){ ?> style="display:none;"<?php }?>>
                <label for="ec_new_product_options_needed">Product Options (Product Variants)?</label>
                <div>
                    <select id="ec_new_product_options_needed" name="ec_new_product_options_needed" class="select2-basic" onchange="ec_admin_new_product_update_option_type( );">
                        <option value="0">No Options</option>
                        <option value="1">Basic Options</option>
                        <?php do_action( 'wp_easycart_admin_product_slideout_option_types' ); ?>
                    </select>
                </div>
            </div>
            <div class="ec_admin_slideout_container_input_row ec_admin_new_product_option_row" style="display:none;">
                <label for="ec_new_product_option1">Option 1</label>
                <div>
                	<div class="wpec-admin-75-select">
                        <select id="ec_new_product_option1" name="ec_new_product_option1" class="select2-basic">
                            <option value="0">None Selected</option>
                            <?php foreach( $basic_option_list as $option ){ ?>
                            <option value="<?php echo $option->value; ?>"><?php echo $option->label; ?></option>
                            <?php }?>
                        </select>
	                </div>
                	<input type="button" class="wpec-admin-upload-button" value="Add New" onclick="wp_easycart_admin_open_slideout( 'new_option_box' );" />
            	</div>
            </div>
            <div class="ec_admin_slideout_container_input_row ec_admin_new_product_option_row" style="display:none;">
                <label for="ec_new_product_option2">Option 2</label>
                <div>
                	<div class="wpec-admin-75-select">
                        <select id="ec_new_product_option2" name="ec_new_product_option2" class="select2-basic">
                            <option value="0">None Selected</option>
                            <?php foreach( $basic_option_list as $option ){ ?>
                            <option value="<?php echo $option->value; ?>"><?php echo $option->label; ?></option>
                            <?php }?>
                        </select>
	                </div>
                	<input type="button" class="wpec-admin-upload-button" value="Add New" onclick="wp_easycart_admin_open_slideout( 'new_option_box' );" />
            	</div>
            </div>
            <div class="ec_admin_slideout_container_input_row ec_admin_new_product_option_row" style="display:none;">
                <label for="ec_new_product_option3">Option 3</label>
                <div>
                	<div class="wpec-admin-75-select">
                        <select id="ec_new_product_option3" name="ec_new_product_option3" class="select2-basic">
                            <option value="0">None Selected</option>
                            <?php foreach( $basic_option_list as $option ){ ?>
                            <option value="<?php echo $option->value; ?>"><?php echo $option->label; ?></option>
                            <?php }?>
                        </select>
	                </div>
                	<input type="button" class="wpec-admin-upload-button" value="Add New" onclick="wp_easycart_admin_open_slideout( 'new_option_box' );" />
            	</div>
            </div>
            <div class="ec_admin_slideout_container_input_row ec_admin_new_product_option_row" style="display:none;">
                <label for="ec_new_product_option4">Option 4</label>
                <div>
                	<div class="wpec-admin-75-select">
                        <select id="ec_new_product_option4" name="ec_new_product_option4" class="select2-basic">
                            <option value="0">None Selected</option>
                            <?php foreach( $basic_option_list as $option ){ ?>
                            <option value="<?php echo $option->value; ?>"><?php echo $option->label; ?></option>
                            <?php }?>
                        </select>
	                </div>
                	<input type="button" class="wpec-admin-upload-button" value="Add New" onclick="wp_easycart_admin_open_slideout( 'new_option_box' );" />
            	</div>
            </div>
            <div class="ec_admin_slideout_container_input_row ec_admin_new_product_option_row" style="display:none;">
                <label for="ec_new_product_option5">Option 5</label>
                <div>
                	<div class="wpec-admin-75-select">
                        <select id="ec_new_product_option5" name="ec_new_product_option5" class="select2-basic">
                            <option value="0">None Selected</option>
                            <?php foreach( $basic_option_list as $option ){ ?>
                            <option value="<?php echo $option->value; ?>"><?php echo $option->label; ?></option>
                            <?php }?>
                        </select>
	                </div>
                	<input type="button" class="wpec-admin-upload-button" value="Add New" onclick="wp_easycart_admin_open_slideout( 'new_option_box' );" />
            	</div>
            </div>
            
            <div style="display:none; float:left; width:100%; margin-top:25px; text-align:center;" id="ec_new_product_advanced_options">-- Add advanced options by creating then editing the product --</div>
            <div style="float:left; width:100%; margin-top:25px; text-align:center;">*You can edit all product settings after creating the product basics</div>
            <div style="float:left; width:100%; margin-top:25px; text-align:center;">*Looking to customize this panel? <a href="admin.php?page=wp-easycart-settings&subpage=miscellaneous" target="_blank">Click here</a>.</div>
        </div>
        <footer class="ec_admin_slideout_container_content_footer">
            <div class="ec_admin_slideout_container_content_footer_inner">
                <div class="ec_admin_slideout_container_content_footer_inner_body">
                    <ul>
                        <li>
                            <button onclick="ec_admin_save_new_quick_product( 1 );">
                                <span>Create and Edit</span>
                            </button>
                        </li>
                        <li class="ec_admin_mobile_hide">
                            <button onclick="ec_admin_save_new_quick_product( 2 );">
                                <span>Create and Another</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="ec_admin_save_new_quick_product( 3 );">
                                <span>Create</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>jQuery( document.getElementById( 'new_product_box' ) ).appendTo( document.body );</script>