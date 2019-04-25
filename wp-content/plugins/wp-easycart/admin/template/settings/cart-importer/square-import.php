<div class="ec_admin_list_line_item ec_admin_demo_data_line">
            
	<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_square_importer" ); ?>
    
    <div class="ec_admin_settings_label"><div class="dashicons-before dashicons-migrate"></div><span>SquareUp Importer</span><a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('settings', 'cart-importer', 'square');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
    <?php echo wp_easycart_admin( )->helpsystem->print_vids_url('settings', 'cart-importer', 'square');?></div>
    <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
        
		<?php

			if( isset( $_GET['ec_success'] ) && $_GET['ec_success'] == "square-imported" ){ ?>
				<div class="ec_save_success">
					<p>Your SquareUp store has been imported to the EasyCart. There are no guarantees that all options have been imported, please check over the data and manually add anything that may be missing.</p>
				</div>
			<?php } ?>
			
			<form action="admin.php?page=wp-easycart-settings&subpage=cart-importer" method="POST" enctype="multipart/form-data" name="wpeasycart_admin_form" id="wpeasycart_admin_form_import2" novalidate="novalidate">
			<input type="hidden" name="ec_admin_form_action" id="ec_admin_form_action" value="import-square-products" />
            <div  class="settings_list_items"><p>Importing your data from your SquareUp store is as simple as a click of a button! Although we do our best to import your data, some things may be new to their system or unknown and we do not support. The following information is imported by our system:</p>
			<ul>
				<li>Product Categories</li>
				<li>Option Sets</li>
				<li>Option Item Price Changes</li>
				<li>Manufacturers</li>
				<li>Products are imported by the following rules:<ul>
					<li>Stock quantity, model number, weight, image name, and manufacturer.</li>
					<li>Titles and descriptions are added to the products.</li>
					<li>Connects products to option sets.</li>
					<li>Connects products to categories.</li>
				</ul></li>
			</ul>
			
			</div>
			<p>***<strong>Please note!</strong> If you have not connected, clicking import will cause a server error and you will need to press the back button to return to your WordPress admin. Please only use this feature if you are really importing from SquareUp.</p>
			
			<div class="ec_admin_settings_input"><input type="submit" value="IMPORT SquareUp DATA NOW" class="ec_admin_settings_simple_button" /></div>
			
			</form>
		
    </div>
</div>