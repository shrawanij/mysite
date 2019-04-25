<?php do_action( 'wp_easycart_admin_mobile_navigation' ); ?>

<?php do_action( 'wp_easycart_admin_upsell_popup' ); ?>

<div class="ec_admin_help_video_container">
    <div class="ec_admin_upsell_popup_close">
    	<a href="#" onclick="wp_easycart_admin_close_video_help( ); return false;"><div class="dashicons-before dashicons-dismiss"></div></a>
    </div>
    <div class="ec_admin_help_video_container_inner"><div id="wp_easycart_admin_help_video_player"></div></div>
</div>
<script>jQuery( '.ec_admin_help_video_container' ).prependTo( document.body );</script>

<div class="ec_admin_wrap">

	<div class="ec_admin_left">
    
    	<a href="http://www.wpeasycart.com" target="_blank"><div class="ec_admin_logo"></div></a>
        
        <div class="ec_admin_styled_divider"></div>
        
        <div class="wp_easycart_view_store_main_link"><a href="<?php $storepageid = get_option( 'ec_option_storepage' ); $store_page = get_permalink( $storepageid ); echo $store_page; ?>" target="_blank">View My Store</a></div>
        
        <div class="ec_admin_styled_divider"></div>
        
        <div class="ec_admin_search"><form method="GET" action="https://docs.wpeasycart.com/" target="_blank"><input type="text" name="s" placeholder="search docs..."><div class="ec_admin_search_icon dashicons-before dashicons-search"></div></form></div>
    
        <div class="ec_admin_styled_divider"></div>
        
        <?php if (get_option( 'ec_option_admin_display_sales_goal') == 1) { ?>
    
    	<div class="ec_admin_main_stats">
        
        	<div class="ec_admin_left_stats">
            
            	<div class="ec_admin_left_stats_first"><?php 
				if( class_exists( 'DateTime' ) ){
					$date = new DateTime;
					echo $date->format('M');
				}else{
					echo date( 'M' );
				}?> Sales</div>
            
            	<div class="ec_admin_left_stats_second"><?php echo $GLOBALS['currency']->get_currency_display( $this->month_sales_total ); ?></div>
            
            </div>
            
            <div class="ec_admin_right_stats">
            
            	<div class="<?php if( $this->month_percentage_change >= 0 ){ echo "ec_admin_right_stats_arrow_positive"; }else{ echo "ec_admin_right_stats_arrow_negative"; } ?>"></div>
            
            	<div class="<?php if( $this->month_percentage_change >= 0 ){ echo "ec_admin_right_stats_percent_positive"; }else{ echo "ec_admin_right_stats_percent_negative"; } ?>"><?php if( $this->month_percentage_change > 0 ){ echo "+"; } echo number_format( $this->month_percentage_change, 2, '.', '' ); ?>%</div>
            
            </div>
            
        </div>
            
        <div class="ec_admin_bottom_stats">
        
            <div class="ec_admin_bottom_stats_label_row">
            
                <div class="ec_admin_bottom_stats_label_row_right"><?php 
				if( class_exists( 'DateTime' ) ){
					$date = new DateTime;
					echo $date->format('M');
				}else{
					echo date( 'M' );
				}?> Sales</div>
            
                <div class="ec_admin_bottom_stats_label_row_left"><?php echo number_format( $this->month_percentage_goal, 0, '', '' ); ?>% of goal</div>
            
            </div>
            
            <div class="ec_admin_bottom_stats_bar">
            
                <div class="ec_admin_bottom_stats_bar_positive" style="width:<?php echo number_format( $this->month_percentage_goal, 0, '', '' ); ?>%;"></div>
            
            </div>
        
        </div>
        
        
        <div class="ec_admin_styled_divider"></div>
        
         <?php } ?>
         
        <div class="ec_admin_left_navigation">
        
        	<?php do_action( 'wp_easycart_admin_left_navigation' ); ?>
        
        </div>
    
    </div>
    
    <div class="ec_admin_right">
    
    	<div class="ec_admin_head_navigation">
        
        	<?php do_action( 'wp_easycart_admin_head_navigation' ); ?>
        
        </div>
        
        <div class="ec_admin_content_area">
        
        	<div class="ec_admin_mobile_menu_button">
    
                <a href="#" onclick="ec_admin_open_mobile_menu( ); return false;"><div class="dashicons-before dashicons-menu"></div></a>
            
            </div>
            
            <?php do_action( 'wp_easycart_admin_messages' ); ?>
        
        	<?php do_action( 'wp_easycart_admin_shell_content' ); ?>
        
        </div>
    
    </div>
    


</div>