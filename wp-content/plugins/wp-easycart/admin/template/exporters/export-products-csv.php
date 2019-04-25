<?php 
if( current_user_can( 'manage_options' ) ){
	global $wpdb;
	
	if( isset( $_GET['bulk'] ) && $_GET['ec_admin_form_action'] == 'export-products-csv' ) {
		if( is_array( $_GET['bulk'] ) ){
			$orderidarray = $_GET['bulk'];
		}else{
			$orderidarray = array( $_GET['bulk'] );
		}
	}
	
	$header = ""; 
	$data = "";
	
	$setnum = 1;
	if( isset( $_GET['setnum'] ) )
		$setnum = $_GET['setnum'];
	
	if( isset( $orderidarray ) ){	
		$ids = $orderidarray; 
		$ids = array_map( function( $v ){
			return "'" . esc_sql( $v ) . "'";
		}, $ids );
		$ids = implode( ',', $ids );
		$sql = "SELECT * FROM ec_product WHERE ec_product.product_id IN (".$ids.")";
		$results = $wpdb->get_results( $sql, ARRAY_A );
		$total = $wpdb->get_var( "SELECT COUNT( ec_product.product_id ) as total FROM ec_product WHERE ec_product.product_id IN (".$ids.") ORDER BY product_id ASC" );
	
	}else{
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ec_product ORDER BY ec_product.product_id ASC LIMIT %d, 500", ( $setnum-1 )*500 ), ARRAY_A );
		$total = $wpdb->get_var( "SELECT COUNT( ec_product.product_id ) as total FROM ec_product" );
	}
	
	// Get advanced options
	$last_advanced_option_read = 0;
	$advanced_options = $wpdb->get_results( "SELECT * FROM ec_option_to_product ORDER BY product_id ASC, option_id ASC" );
	
	//$data .= chr(0xEF) . chr(0xBB) . chr(0xBF);
	
	if( count( $results ) > 0 ){
		$keys = array_keys( $results[0] );
		$first = true;
		foreach( $keys as $key ){
			
			if( !$first )
				$data .= ',';
			
			$data .= $key;
			$first = false;
		
		}
		$data .= ",advanced_option_ids";
		$data .= "\n";
		
		foreach( $results as $result ){
			$first = true;
			foreach( $result as $value ){
			
				if( !$first )
					$data .= ',';
				$data .= '"' . str_replace( '"', '""', stripslashes_deep( preg_replace( "/\n{2,}/", "\n\n", str_replace( "\r", "\n", str_replace( "\r\n", "\n", $value ) ) ) ) ) . '"';
				$first = false;
			
			}
			if( !$result['use_advanced_optionset'] ){
				$data .= ',""';
			}else{
				$data .= ',"';
				$is_first_ao = true;
				for( $ao_index = $last_advanced_option_read; $ao_index < count( $advanced_options ); $ao_index++ ){
					if( $advanced_options[$ao_index]->product_id == $result['product_id'] ){
						if( !$is_first_ao )
							$data .= ',';
						$data .= $advanced_options[$ao_index]->option_id;
						$is_first_ao = false;
						$last_advanced_option_read++;
					}else{
						break;
					}
				}
				$data .= '"';
			}
			
			$data .= "\n";
		}
		
	}else{
		if( $data == "" ){
			$data = "\nno matching records found\n";
		}
	}
	
	if( $total > ( $setnum * 500 ) ){ // More files to generate
		
		file_put_contents( "productexport" . $setnum . ".csv", $data );
		header( "location:admin.php?page=wp-easycart-products&subpage=products&ec_admin_form_action=export-all-products-csv&setnum=" . ($setnum+1) );
		
	}else if( $total > 500 ){ // Combine and zip generate files
		
		file_put_contents( "productexport" . $setnum . ".csv", $data );
		$files = array( );
		for( $i=1; $i<=$setnum; $i++ ){
			$files[] = "productexport" . $i . ".csv";
		}
		$zipname = 'productexport-' . date( 'Y-m-d' ) . '.zip';
		$zip = new ZipArchive;
		$zip->open($zipname, ZipArchive::CREATE);
		foreach ($files as $file) {
		  $zip->addFile($file);
		}
		$zip->close();
		
		header('Content-Type: application/zip');
		header('Content-disposition: attachment; filename='.$zipname);
		header('Content-Length: ' . filesize($zipname));
		readfile($zipname);
		
		for( $i=1; $i<=$setnum; $i++ ){
			unlink( "productexport" . $i . ".csv" );
		}
		unlink( $zipname );
		
	}else{ // Download a single file
	
		header("Content-type: text/csv; charset=UTF-8");
		header("Content-Transfer-Encoding: binary"); 
		header("Content-Disposition: attachment; filename=product-export-" . date( 'Y-m-d' ). ".csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $data;
	}
}else{
	echo 'Not Authenticated'; 
	die( );
}

?>