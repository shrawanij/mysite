<option value="price" <?php if( wp_easycart_admin( )->settings->shipping_method == 'price' ) echo ' selected'; ?>>Price Trigger System</option>
<option value="weight" <?php if( wp_easycart_admin( )->settings->shipping_method == 'weight' ) echo ' selected'; ?>>Weight Trigger System</option>
<option value="quantity" <?php if( wp_easycart_admin( )->settings->shipping_method == 'quantity' ) echo ' selected'; ?>>Quantity Trigger System</option>
<option value="percentage" <?php if( wp_easycart_admin( )->settings->shipping_method == 'percentage' ) echo ' selected'; ?>>Percentage Based Shipping</option>
<option value="method" <?php if( wp_easycart_admin( )->settings->shipping_method == 'method' ) echo ' selected'; ?>>Static Shipping Method</option>
<option value="fraktjakt" <?php if( wp_easycart_admin( )->settings->shipping_method == 'fraktjakt' ) echo ' selected'; ?>>Fraktjakt</option>