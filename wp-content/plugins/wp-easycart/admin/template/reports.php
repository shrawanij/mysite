<div class="ec_admin_head_section">

    <div class="ec_admin_head_content">
        <h1>Reports</h1>
        <h3>Track your progress and your sales grow</h3>
    </div>
    
    <div class="ec_admin_head_buttons_row">
        <div class="ec_admin_head_button">
        	<span><a href="admin.php?page=wp-easycart-users" title="Store Users"></a></span>
            <div class="dashicons-before dashicons-groups"></div>
        </div>
        <div class="ec_admin_head_button">
        	<span><a href="admin.php?page=wp-easycart-products&amp;subpage=customer-reviews" title="Customer Reviews"></a></span>
            <div class="dashicons-before dashicons-admin-comments"></div>
        </div>
        <div class="ec_admin_head_button">
        	<span><a href="admin.php?page=wp-easycart-orders" title="Orders"></a></span>
            <div class="dashicons-before dashicons-tag"></div>
        </div>
        <div class="ec_admin_head_button">
        	<span><a href="admin.php?page=wp-easycart-settings" title="Settings"></a></span>
            <div class="dashicons-before dashicons-admin-tools"></div>
        </div>
    </div>

</div>
	
<div class="ec_admin_graph_header">
	
	<select id="ec_admin_chart_data_type_select">
    	<option value="orders">Orders</option>
    	<option value="customers">Customers</option>
    	<option value="stock">Stock</option>
    </select>
    
    <select id="ec_admin_chart_date_type_select">
    	<option value="daily">Daily</option>
    	<option value="weekly">Weekly</option>
    	<option value="monthly">Monthly</option>
    	<option value="yearly">Yearly</option>
    </select>
    
    <select id="ec_admin_chart_type_select">
    	<option value="sales">Sales (<?php echo get_option( 'ec_option_base_currency' ); ?>)</option>
        <option value="items_sold">Items Sold</option>
    	<option value="abandonment">Carts Abandoned</option>
    </select>

</div>
