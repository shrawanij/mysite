<?php
$curr_page = "";
if( isset( $_GET['subpage'] ) )
	$curr_page = esc_attr( $_GET['subpage'] );
else
	$curr_page = esc_attr( $_GET['page'] );
?>
<div class="ec_admin_settings_panel ec_admin_details_panel">
    
    <div class="ec_admin_important_numbered_list">
		
        <div class="ec_admin_flex_row">

			<div class="ec_admin_list_line_item ec_admin_col_12 ec_admin_col_first">
			
                <div class="ec_admin_settings_label">
                    <div class="dashicons-before dashicons-lock"></div>
                    <span>Upgrade to PRO Today!</span>
                    <a href="<?php echo wp_easycart_admin( )->helpsystem->print_docs_url('upgrade', 'professional-version', 'giftcards');?>" target="_blank" class="ec_help_icon_link"><div class="dashicons-before ec_help_icon dashicons-info"></div></a>
                </div>
    
                <div class="ec_admin_upgrade_wrap">
                    
                    <div class="ec_admin_upsell_popup_extras" style="display:none;" id="ec_admin_upsell_popup_paypal_express">
                        <div class="ec_admin_upgrade_header">Paypal Express Requires an Upgrade!</div>
                        <div class="ec_admin_upgrade_subheader">When you upgrade you are getting PayPal Express + hundreds of other great selling features.</div>
                        <div class="ec_admin_upgrade_subheader"><a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=paypal-express" target="_blank">Learn more about PayPal Express</a></div>
                        <div class="ec_admin_upgrade_subheader ec_admin_upgrade_box_signup_row"><a href="<?php echo apply_filters( 'wp_easycart_upgrade_pro_url', 'https://www.wpeasycart.com/wordpress-shopping-cart-pricing/?upsell=paypal-express&upsellpage=' . $curr_page ); ?>" target="_blank">UPGRADE NOW</a></div>
                    	
                        <div class="ec_admin_upgrade_divider" style="margin-bottom:25px;"><div></div></div>
                    
                    </div>
                    
                    <?php /* SHIPPING UPSALES */ ?>
                    <?php if( isset( $_GET['subpage'] ) && ( $_GET['subpage'] == 'shipping-settings' || $_GET['subpage'] == 'shipping-rates' ) ){ ?>
                    <div class="ec_admin_upsell_popup_extras" style="display:none;" id="ec_admin_upsell_popup_australia_post">
                        <div class="ec_admin_upgrade_header">Australia Post Requires an Upgrade!</div>
                        <div class="ec_admin_upgrade_subheader">Upgrade to get live shipping rates with Australia Post + hundreds of other great selling features.</div>
                        <div class="ec_admin_upgrade_subheader"><a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=shipping-settings" target="_blank">Learn more about Australia Post</a></div>
                        <div class="ec_admin_upgrade_subheader ec_admin_upgrade_box_signup_row"><a href="<?php echo apply_filters( 'wp_easycart_upgrade_pro_url', 'https://www.wpeasycart.com/wordpress-shopping-cart-pricing/?upsell=australia-post&upsellpage=' . $curr_page ); ?>" target="_blank">UPGRADE NOW</a></div>
                    	
                        <div class="ec_admin_upgrade_divider" style="margin-bottom:25px;"><div></div></div>
                    
                    </div>
                    
                    <div class="ec_admin_upsell_popup_extras" style="display:none;" id="ec_admin_upsell_popup_canada_post">
                        <div class="ec_admin_upgrade_header">Canada Post Requires an Upgrade!</div>
                        <div class="ec_admin_upgrade_subheader">Upgrade to get live shipping rates with Canada Post + hundreds of other great selling features.</div>
                        <div class="ec_admin_upgrade_subheader"><a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=shipping-settings" target="_blank">Learn more about Canada Post</a></div>
                        <div class="ec_admin_upgrade_subheader ec_admin_upgrade_box_signup_row"><a href="<?php echo apply_filters( 'wp_easycart_upgrade_pro_url', 'https://www.wpeasycart.com/wordpress-shopping-cart-pricing/?upsell=canada-post&upsellpage=' . $curr_page ); ?>" target="_blank">UPGRADE NOW</a></div>
                    	
                        <div class="ec_admin_upgrade_divider" style="margin-bottom:25px;"><div></div></div>
                    
                    </div>
                    
                    <div class="ec_admin_upsell_popup_extras" style="display:none;" id="ec_admin_upsell_popup_dhl">
                        <div class="ec_admin_upgrade_header">DHL Requires an Upgrade!</div>
                        <div class="ec_admin_upgrade_subheader">Upgrade to get live shipping rates with DHL + hundreds of other great selling features.</div>
                        <div class="ec_admin_upgrade_subheader"><a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=shipping-settings" target="_blank">Learn more about DHL</a></div>
                        <div class="ec_admin_upgrade_subheader ec_admin_upgrade_box_signup_row"><a href="<?php echo apply_filters( 'wp_easycart_upgrade_pro_url', 'https://www.wpeasycart.com/wordpress-shopping-cart-pricing/?upsell=dhl&upsellpage=' . $curr_page ); ?>" target="_blank">UPGRADE NOW</a></div>
                    	
                        <div class="ec_admin_upgrade_divider" style="margin-bottom:25px;"><div></div></div>
                    
                    </div>
                    
                    <div class="ec_admin_upsell_popup_extras" style="display:none;" id="ec_admin_upsell_popup_fedex">
                        <div class="ec_admin_upgrade_header">FedEx Requires an Upgrade!</div>
                        <div class="ec_admin_upgrade_subheader">Upgrade to get live shipping rates with FedEx + hundreds of other great selling features.</div>
                        <div class="ec_admin_upgrade_subheader"><a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=shipping-settings" target="_blank">Learn more about FedEx</a></div>
                        <div class="ec_admin_upgrade_subheader ec_admin_upgrade_box_signup_row"><a href="<?php echo apply_filters( 'wp_easycart_upgrade_pro_url', 'https://www.wpeasycart.com/wordpress-shopping-cart-pricing/?upsell=dhl&upsellpage=' . $curr_page ); ?>" target="_blank">UPGRADE NOW</a></div>
                    	
                        <div class="ec_admin_upgrade_divider" style="margin-bottom:25px;"><div></div></div>
                    
                    </div>
                    
                    <div class="ec_admin_upsell_popup_extras" style="display:none;" id="ec_admin_upsell_popup_ups">
                        <div class="ec_admin_upgrade_header">UPS Requires an Upgrade!</div>
                        <div class="ec_admin_upgrade_subheader">Upgrade to get live shipping rates with UPS + hundreds of other great selling features.</div>
                        <div class="ec_admin_upgrade_subheader"><a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=shipping-settings" target="_blank">Learn more about UPS</a></div>
                        <div class="ec_admin_upgrade_subheader ec_admin_upgrade_box_signup_row"><a href="<?php echo apply_filters( 'wp_easycart_upgrade_pro_url', 'https://www.wpeasycart.com/wordpress-shopping-cart-pricing/?upsell=dhl&upsellpage=' . $curr_page ); ?>" target="_blank">UPGRADE NOW</a></div>
                    	
                        <div class="ec_admin_upgrade_divider" style="margin-bottom:25px;"><div></div></div>
                    
                    </div>
                    
                    <div class="ec_admin_upsell_popup_extras" style="display:none;" id="ec_admin_upsell_popup_usps">
                        <div class="ec_admin_upgrade_header">USPS Requires an Upgrade!</div>
                        <div class="ec_admin_upgrade_subheader">Upgrade to get live shipping rates with USPS + hundreds of other great selling features.</div>
                        <div class="ec_admin_upgrade_subheader"><a href="http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?section=shipping-settings" target="_blank">Learn more about USPS</a></div>
                        <div class="ec_admin_upgrade_subheader ec_admin_upgrade_box_signup_row"><a href="<?php echo apply_filters( 'wp_easycart_upgrade_pro_url', 'https://www.wpeasycart.com/wordpress-shopping-cart-pricing/?upsell=dhl&upsellpage=' . $curr_page ); ?>" target="_blank">UPGRADE NOW</a></div>
                    	
                        <div class="ec_admin_upgrade_divider" style="margin-bottom:25px;"><div></div></div>
                    
                    </div>
                    <?php }?>
                    
                   <?php $trial_note = '
                    <div id="wp_easycart_trial_upsell">';
					
					$pro_plugin_base = 'wp-easycart-pro/wp-easycart-admin-pro.php';
					$pro_plugin_file = WP_PLUGIN_DIR . '/' . $pro_plugin_base;
					if( file_exists( $pro_plugin_file ) && !is_plugin_active( $pro_plugin_base ) ) {
						$trial_note .= '<div class="ec_admin_message_error">';
						$trial_note .= '<p>WP EasyCart PRO is installed but NOT ACTIVATED. Please <a href="' . wp_easycart_admin( )->get_pro_activation_link( ) . '">click here to activate your WP EasyCart PRO plugin</a>.</p>';
						$trial_note .= '</div>';
					}
					$trial_note .= '
						<div class="ec_admin_upgrade_header">Start Your FREE 14 Day PRO Trial</div>
						<div class="ec_admin_upgrade_subheader">To start your free trial, simply click the install button below.</div>
						<div class="ec_admin_upgrade_subheader ec_admin_upgrade_box_signup_row"><a href="admin.php?page=wp-easycart-registration&ec_trial=start">INSTALL YOUR PRO TRIAL NOW!</a></div>
						<div class="ec_admin_upgrade_subheader" style="font-size:14px;">*WP EasyCart PRO plugin will install immediately on click and your trial will start.</div>
						<div class="ec_admin_upgrade_subheader" style="font-size:14px;">*No credit card required to start trial, remove WP EasyCart PRO at any time.</div>
						
						<div class="ec_admin_upgrade_divider" style="margin-bottom:25px;"><div></div></div>
                    </div>';
					
					echo apply_filters( 'wp_easycart_trial_start_content', $trial_note );
					?>
                    
                    <div class="ec_admin_upgrade_header">Ready for PRO? Choose Your License!</div>
                    
                    <div class="ec_admin_upgrade_subheader" style="margin-bottom:25px">No need for a trial? Professional or Premium, choose the plan right for you.</div>
                    
                    <div class="ec_admin_upgrade_box_container">
                    
                        <div class="ec_admin_upgrade_box ec_admin_upgrade_box_most_popular">
                            
                            <div class="ec_admin_upgrade_box_line_item">
                                <div class="ec_admin_upgrade_box_title">Professional</div>
                            </div>
                            
                            <div class="ec_admin_upgrade_box_line_item"><img src="<?php echo plugins_url( 'wp-easycart/admin/images/v4-professional-edition.jpg' ); ?>" alt="Premium Edition" /></div>
                            
                            <div class="ec_admin_upgrade_box_line_item">30+ Payment Methods</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Sell with PayPal, Square, Intuit, Stripe & More</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">USPS, UPS, FedEx, DHL, Australia Post, & Canada Post</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Unlimited Support Tickets</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Coupons, Promotions, & Gift Cards</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">B2B, Volume & Option Product Pricing</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Categories & Product Groupings</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Sell Downloads, Subscriptions, & Gift Cards</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">12 Advanced Product Variant Types</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">8+ Tax Options</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Unlimited Products</div>
                            
                            <div class="ec_admin_upgrade_box_line_item" style="color:#666;">No Premium Extensions</div>
                            
                            <div class="ec_admin_upgrade_box_line_item" style="color:#666;">No Premium Apps</div>
                            
                            <div class="ec_admin_upgrade_box_line_item" style="color:#666;">No QuickBooks</div>
                            
                            <div class="ec_admin_upgrade_box_line_item" style="color:#666;">No MailChimp</div>
                            
                            <div class="ec_admin_upgrade_box_line_item" style="color:#666;">No ShipStation</div>
                            
                            <div class="ec_admin_upgrade_box_line_item" style="color:#666;">No Groupon Importer</div>
                            
                            <div class="ec_admin_upgrade_box_line_item ec_admin_upgrade_box_signup_row"><a href="<?php echo apply_filters( 'wp_easycart_upgrade_pro_url', 'https://www.wpeasycart.com/wordpress-shopping-cart-pricing/?upsell=5&upsellpage=' . $curr_page ); ?>" target="_blank">GET PROFESSIONAL</a></div>
                            
                        </div>
                        
                        <div class="ec_admin_upgrade_box">
                        
                            <div class="ec_admin_upgrade_box_line_item">
                                <div class="ec_admin_upgrade_box_title">Premium</div>
                            </div>
                            
                            <div class="ec_admin_upgrade_box_line_item"><img src="<?php echo plugins_url( 'wp-easycart/admin/images/v4-premium-edition.jpg' ); ?>" alt="Premium Edition" /></div>
                            
                            <div class="ec_admin_upgrade_box_line_item">30+ Payment Methods</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Sell with PayPal, Square, Intuit, Stripe & More</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">USPS, UPS, FedEx, DHL, Australia Post, & Canada Post</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Unlimited Support Tickets</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Coupons, Promotions, & Gift Cards</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">B2B, Volume & Option Product Pricing</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Categories & Product Groupings</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Sell Downloads, Subscriptions, & Gift Cards</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">12 Advanced Product Variant Types</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">8+ Tax Options</div>
                            
                            <div class="ec_admin_upgrade_box_line_item">Unlimited Products</div>
                            
                            <div class="ec_admin_upgrade_box_line_item ec_admin_upgrade_special_line_item">10 Premium Extensions</div>
                            
                            <div class="ec_admin_upgrade_box_line_item ec_admin_upgrade_special_line_item">3 Premium Apps</div>
                            
                            <div class="ec_admin_upgrade_box_line_item ec_admin_upgrade_special_line_item">QuickBooks for Desktop</div>
                            
                            <div class="ec_admin_upgrade_box_line_item ec_admin_upgrade_special_line_item">MailChimp e-commerce API 3.0</div>
                            
                            <div class="ec_admin_upgrade_box_line_item ec_admin_upgrade_special_line_item">Full ShipStation Integration</div>
                            
                            <div class="ec_admin_upgrade_box_line_item ec_admin_upgrade_special_line_item">Groupon Importer</div>
                            
                            <div class="ec_admin_upgrade_box_line_item ec_admin_upgrade_box_signup_row"><a href="<?php echo apply_filters( 'wp_easycart_upgrade_premium_url', 'https://www.wpeasycart.com/wordpress-shopping-cart-pricing/?upsell=6&upsellpage=' . $curr_page ); ?>" target="_blank">GET PREMIUM</a></div>
                            
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>