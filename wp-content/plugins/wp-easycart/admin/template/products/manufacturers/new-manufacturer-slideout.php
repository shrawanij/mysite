<div class="ec_admin_slideout_container" id="new_manufacturer_box">
    <div class="ec_admin_slideout_container_content">
        <?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_new_manufacturer_display_loader" ); ?>
        <header class="ec_admin_slideout_container_content_header">
            <div class="ec_admin_slideout_container_content_header_inner">
                <h3>Create a Manufacturer</h3>
                <div class="ec_admin_slideout_close" onclick="wp_easycart_admin_close_slideout( 'new_manufacturer_box' );">
                    <div class="dashicons-before dashicons-no-alt"></div>
                </div>
            </div>
        </header>
        <div class="ec_admin_slideout_container_content_inner">
            <div class="ec_admin_slideout_container_input_row">
                <label for="ec_new_manufacturer_name">Name</label>
                <div>
                    <input type="text" id="ec_new_manufacturer_name" name="ec_new_manufacturer_name" placeholder="Your Manufacturer Name" />
                </div>
            </div>
        </div>
        <footer class="ec_admin_slideout_container_content_footer">
            <div class="ec_admin_slideout_container_content_footer_inner">
                <div class="ec_admin_slideout_container_content_footer_inner_body">
                    <ul>
                        <li>
                            <button onclick="ec_admin_save_new_manufacturer( );">
                                <span>Create</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="wp_easycart_admin_close_slideout( 'new_manufacturer_box' );">
                                <span>Cancel</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>jQuery( document.getElementById( 'new_manufacturer_box' ) ).appendTo( document.body );</script>