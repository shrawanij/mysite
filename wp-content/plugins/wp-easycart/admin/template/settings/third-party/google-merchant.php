<div class="ec_admin_list_line_item ec_admin_demo_data_line">
	
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_google_merchant_loader" ); ?>

    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-admin-generic"></div><span>Google Merchant</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'third-party', 'google-merchant');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'third-party', 'google-merchant');?></div>

    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">

        <div class="ec_admin_page_title">Setup Products for Google Merchant Feed</div>
        <div class="ec_admin_page_intro">
            <p>Setting up Google Merchant requires you to set a lot of options that do not apply to the store, but are useful in the Google Merchant system. Please enter as many options as possible during setup for best results. Instructions to create a Google Merchant Feed are provided below.</p>
            <ol>
                <li>Download the CSV <a href="admin.php?page=wp-easycart-settings&subpage=third-party&ec_admin_form_action=download-google-csv" target="_blank">here</a> and fill out the necessary information. Please note that the product_id, model_number, price, sale_price, and brand CANNOT be edited through the CSV file. This is for your reference only. This data must be edited through the EasyCart admin area and is done this way to allow you to quickly download the latest XML feed file and upload those changes to Google.</li>
                <li>Upload your CSV to import the merchant feed data: <br />
                    <form action="admin.php?page=wp-easycart-settings&subpage=third-party&ec_admin_form_action=upload-google-csv" method="POST" enctype="multipart/form-data" style="border:1px solid #939393; width:100%; padding:5px; text-align:center; line-height:45px; margin:20px 0; background:#EFEFEF;">
                        <input type="file" name="csv_file" /><br />
                        <input type="submit" value="Import" />
                    </form>
                </li>
                <li>Download your <a href="admin.php?page=wp-easycart-settings&subpage=third-party&ec_admin_form_action=download-feed" target="_blank">XML feed</a> and manually upload in you Google Merchant account under Feeds. You should start by selecting Mode as Test, Feed Type as Products, and when uploading select &quot;regular uploads by user&quot;. Please note that you are required by Google to include a GTIN, MPN, and condition with each product. Any product without these values will not be included in the XML feed file generated.</li>
                <li>Once the test is successful, download your latest <a href="admin.php?page=wp-easycart-settings&subpage=third-party&ec_admin_form_action=download-feed" target="_blank">XML feed</a> and manually upload as a Standard Feed with the same options as before (non-test feed is the only diffence here) and be sure to choose &quot;regular uploads by user&quot;.</li>
                <li>You must visit this page, download, and re-upload the XML file whenever you need the data refreshed in your Google Merchant Account.</li>
                <li>While inserting Google Product Categories, please use data from <a href="http://www.google.com/basepages/producttype/taxonomy.en-US.txt" target="_blank">this list</a>.</li>
                <li>While inserting GTIN and MPN, use <a href="https://support.google.com/merchants/answer/160161?hl=en" target="_blank">this help page</a>.</li>
                <li>Product Type is strongly suggested by Google as well and to avoid the warning messages you should add a value to this field.</li>
            </ol>
        </div>
    </div>
</div>