<div class="ec_admin_full_width_banner">
	<div class="ec_admin_full_width_banner_inner">
    	<div class="ec_admin_banner_bar_buttons">
			<div class="ec_admin_banner_button ec_admin_button_product">
            	<div class="dashicons-before dashicons-products"></div>
                <span><a href="admin.php?page=wp-easycart-products&subpage=products" title="Manage Products">Manage Products</a></span>
            </div>
			<div class="ec_admin_banner_button ec_admin_button_orders">
            	<div class="dashicons-before dashicons-tag"></div>
                <span><a href="admin.php?page=wp-easycart-orders&subpage=orders" title="Check Orders">Check Orders</a></span>
            </div>
			<div class="ec_admin_banner_button ec_admin_button_comments">
            	<div class="dashicons-before dashicons-format-chat"></div>
                <span><a href="admin.php?page=wp-easycart-products&subpage=reviews" title="Review Comments">Review Comments</a></span>
            </div>
			<div class="ec_admin_banner_button ec_admin_button_customers">
            	<div class="dashicons-before dashicons-groups"></div>
                <span><a href="admin.php?page=wp-easycart-users&subpage=accounts" title="Manage Customers">Manage Customers</a></span>
            </div>
			<div class="ec_admin_banner_button ec_admin_button_extend">
            	<div class="dashicons-before dashicons-admin-plugins"></div>
                <span><a href="http://www.wpeasycart.com/easycart-extension-marketplace/" title="Extend Store" target="_blank">Extend Store</a></span>
            </div>
		</div>
    </div>
</div>
	
<div class="ec_admin_graph_header">
	<form action="admin.php" method="GET">
    	<input type="hidden" name="page" value="wp-easycart-dashboard" />
		<?php 
            $selected_date_type_filter = 'daily';
            $selected_chart_type_filter = 'sales';
            $product_filter = 0;
            
			if( isset( $_GET['daily_filter'] ) && ( $_GET['daily_filter'] == 'daily' || $_GET['daily_filter'] == 'weekly' || $_GET['daily_filter'] == 'monthly' || $_GET['daily_filter'] == 'yearly' ) )
                $selected_date_type_filter = $_GET['daily_filter'];
            
			if( isset( $_GET['chart_filter'] ) && ( $_GET['chart_filter'] == 'sales' || $_GET['chart_filter'] == 'items_sold' || $_GET['chart_filter'] == 'abandonment' ) )
                $selected_chart_type_filter = $_GET['chart_filter'];
            
			if( isset( $_GET['product_filter'] ) )
                $product_filter = (int) $_GET['product_filter'];
            
			$dashboard_data = wp_easycart_admin( )->get_dashboard_data( $selected_date_type_filter, $selected_chart_type_filter, $product_filter );
        ?>
        <select name="daily_filter">
            <option value="daily"<?php if( $selected_date_type_filter == "daily" ){ ?> selected="selected"<?php }?>>Daily</option>
            <option value="weekly"<?php if( $selected_date_type_filter == "weekly" ){ ?> selected="selected"<?php }?>>Weekly</option>
            <option value="monthly"<?php if( $selected_date_type_filter == "monthly" ){ ?> selected="selected"<?php }?>>Monthly</option>
            <option value="yearly"<?php if( $selected_date_type_filter == "yearly" ){ ?> selected="selected"<?php }?>>Yearly</option>
        </select>
        
        <select name="chart_filter">
            <option value="sales"<?php if( $selected_chart_type_filter == "sales" ){ ?> selected="selected"<?php }?>>Sales (<?php echo get_option( 'ec_option_base_currency' ); ?>)</option>
            <option value="items_sold"<?php if( $selected_chart_type_filter == "items_sold" ){ ?> selected="selected"<?php }?>>Items Sold</option>
            <option value="abandonment"<?php if( $selected_chart_type_filter == "abandonment" ){ ?> selected="selected"<?php }?>>Carts Abandoned</option>
        </select>
        
        <?php 
		global $wpdb;
		$products = $wpdb->get_results( "SELECT ec_product.title, ec_product.product_id FROM ec_product WHERE ec_product.activate_in_store = 1 ORDER BY ec_product.title ASC LIMIT 500" );
		if( count( $products ) >= 500 ){
		?>
		<input type="text" name="product_filter" placeholder="Enter a Product ID" value="" />
		<?php }else{ ?>
        <select name="product_filter" style="max-width:300px;">
            <option value="0">No Product Filter</option>
            <?php foreach( $products as $product ){ ?>
            <option value="<?php echo $product->product_id; ?>"<?php if( $product_filter == $product->product_id ){ ?> selected="selected"<?php }?>><?php echo $product->title; ?></option>
            <?php }?>
        </select>
        <?php }?>
        <input type="submit" value="UPDATE CHART" />
    </form>
</div>

<div id="ec_admin_chart" class="ec_admin_chart_holder ec_admin_chart_holder_active">

	<canvas id="ec_admin_chart_data" class="ec_admin_chart"></canvas>

</div>

<div class="ec_admin_general_stats_box">
<a href="admin.php?page=wp-easycart-orders&subpage=orders" title="Manage Orders">
	<div class="ec_admin_general_stat_item ec_admin_stat_item_orders">
    	
        <div class="dashicons-before dashicons-tag"></div>
        
        <div class="ec_admin_general_stat_number"><?php echo $this->new_orders; ?></div>
        
        <div class="ec_admin_general_stat_label">Orders this Week</div>
        
        
    </div>
</a>
<a href="admin.php?page=wp-easycart-products&subpage=reviews" title="Manage Reviews">
	<div class="ec_admin_general_stat_item ec_admin_stat_item_reviews">
    	
        <div class="dashicons-before dashicons-format-chat"></div>
        
        <div class="ec_admin_general_stat_number"><?php echo $this->pending_reviews; ?></div>
        
        <div class="ec_admin_general_stat_label">Pending Reviews</div>
        
    </div>
</a>
<a href="admin.php?page=wp-easycart-users&subpage=accounts" title="Manage Customers">
	<div class="ec_admin_general_stat_item ec_admin_stat_item_accounts">
    	
        <div class="dashicons-before dashicons-groups"></div>
        
        <div class="ec_admin_general_stat_number"><?php echo $this->cart_users; ?></div>
        
        <div class="ec_admin_general_stat_label">Customers</div>
        
    </div>
</a>

</div>

<?php do_action( 'wp_easycart_admin_dashboard_post' ); ?>

<script>
var dashboard_data = {
	labels: [ <?php $first = false; for( $i=count( $dashboard_data ) - 1; $i >= 0; $i-- ){ if( $first ){ echo ","; }else{ $first = true; } echo '"' . $dashboard_data[$i]->date . '"'; } ?>],
	datasets: [
		{
			label: "Daily Sales",
			fillColor: "rgba(123,177,65,0.9)",
			strokeColor: "rgba(151,187,205,1)",
			pointColor: "rgba(151,187,205,1)",
			pointStrokeColor: "#fff",
			pointHighlightFill: "#fff",
			pointHighlightStroke: "rgba(151,187,205,1)",
			data: [<?php $first = false; for( $i=count( $dashboard_data ) - 1; $i >= 0; $i-- ){ if( $first ){ echo ","; }else{ $first = true; } echo $dashboard_data[$i]->total; } ?>]
		}
	]
};
var options = {

	//Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero : true,

    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines : true,

    //String - Colour of the grid lines
    scaleGridLineColor : "rgba(0,0,0,.90)",

    //Number - Width of the grid lines
    scaleGridLineWidth : 1,

    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,

    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,

    //Boolean - If there is a stroke on each bar
    barShowStroke : true,

    //Number - Pixel width of the bar stroke
    barStrokeWidth : 2,

    //Number - Spacing between each of the X value sets
    barValueSpacing : 5,

    //Number - Spacing between data sets within X values
    barDatasetSpacing : 1,

};

var ec_admin_dashboard_chart = jQuery( document.getElementById( 'ec_admin_chart_data' ) ).get( 0 ).getContext( "2d" );
new Chart( ec_admin_dashboard_chart ).Bar( dashboard_data, { barShowStroke: false } );
</script>