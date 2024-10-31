<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'NiWooMCR_Order_Product_Report' ) ) {
	class NiWooMCR_Order_Product_Report {
		function __construct(){
		}
		function get_page_init(){
			$this->get_data();
		}
		function get_data(){
			$this->prettyPrint("dsad");
			echo "dsadsa";
		}
		function get_ajax(){
		}
	} 
}
?>