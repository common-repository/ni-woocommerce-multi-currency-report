<?php
/*
Plugin Name: Ni WooCommerce Multi Currency Report
Description: Ni WooCommerce Multi Currency Report provide the sales report base on product sold currency
Author: 	 anzia
Version: 	 1.3.0
Author URI:  http://naziinfotech.com/
Plugin URI:  https://wordpress.org/plugins/ni-woocommerce-multi-currency-report/
License:	 GPLv3 or later
License URI: http://www.gnu.org/licenses/agpl-3.0.html
Text Domain: niwoomcr
Domain Path: /languages/
Requires at least: 4.7
Tested up to: 6.4.1
WC requires at least: 3.0.0
WC tested up to: 8.3.1 
Last Updated Date: 26-November-2023
Requires PHP: 7.0
*/
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_WooCommerce_Multi_Currency_Report' ) ) { 
	class Ni_WooCommerce_Multi_Currency_Report {
		function __construct(){
			add_action( 'plugins_loaded',  array(&$this,'plugins_loaded') );
			include_once('includes/niwoomcr-core.php'); 
			$obj = new NiWooMCR_Core();
		}
		function plugins_loaded(){
			load_plugin_textdomain('niwoomcr', WP_PLUGIN_DIR.'/ni-woocommerce-multi-currency-report/languages','ni-woocommerce-multi-currency-report/languages');
			//load_plugin_textdomain('nisalesreport', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		 }
	}
	$obj_niwoomcr =  new Ni_WooCommerce_Multi_Currency_Report();
}
?>