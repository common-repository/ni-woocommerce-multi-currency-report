<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'NiWooMCR_Function' ) ) {
	class NiWooMCR_Function {
		function __construct(){
		}
		function get_country_name($code){	
			$name = "";
			if (strlen($code)>0){
				$name= WC()->countries->countries[ $code];	
				$name  = isset($name) ? $name : $code;
			}
			return $name;
		}
		/*Start Request*/
		function get_request($name,$default = NULL,$set = false){
			if(isset($_REQUEST[$name])){
				$newRequest = $_REQUEST[$name];
				
				if(is_array($newRequest)){
					$newRequest = implode(",", $newRequest);
					//$newRequest = implode("','", $newRequest);
				}else{
					$newRequest = trim($newRequest);
				}
				
				if($set) $_REQUEST[$name] = $newRequest;
				
				return $newRequest;
			}else{
				if($set) 	$_REQUEST[$name] = $default;
				return $default;
			}
		}
		/*End Request*/
		/*Start Print*/
		function prettyPrint($a, $t='pre') {echo "<$t>".print_r($a,1)."</$t>";}
		/*End Print*/
		
		/*Order Currency*/
		function get_order_currency(){
			global $wpdb;
			$query = "";
			$query .= " SELECT ";
			$query .= "	order_currency.meta_value as order_currency";
			$query .= "	FROM {$wpdb->prefix}posts as posts	";
			$query .= " LEFT JOIN  {$wpdb->prefix}postmeta as order_currency ON order_currency.post_id=posts.ID ";
			$query .= " WHERE 1 = 1";  
			$query .= " AND	posts.post_type ='shop_order' ";
			$query .= " AND order_currency.meta_key = '_order_currency'";	
			$query .= " GROUP BY order_currency.meta_value";
			
			$rows = $wpdb->get_results( $query );
			$data = array();
			foreach($rows as $key=>$value){
				$data [$value->order_currency]  =$value->order_currency;
			}
			return $data;
		}
		/*End Order Currency*/
		
		/*Order Country*/
		function get_order_country(){
			global $wpdb;
			$query = "";
			$query .= " SELECT ";
			$query .= "	billing_country.meta_value as billing_country";
			$query .= "	FROM {$wpdb->prefix}posts as posts	";
			$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id=posts.ID ";
			$query .= " WHERE 1 = 1";  
			$query .= " AND	posts.post_type ='shop_order' ";
			$query .= " AND billing_country.meta_key = '_billing_country'";		
			$query .= " GROUP BY  billing_country.meta_value";
			
			$rows = $wpdb->get_results( $query );
			$data = array();
			foreach($rows as $key=>$value){
				$data [$value->billing_country]  =$value->billing_country;
			}
			return $data;
		}
		/*End Order country*/
	} 
}
?>