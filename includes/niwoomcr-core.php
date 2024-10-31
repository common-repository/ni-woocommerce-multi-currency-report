<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'NiWooMCR_Core' ) ) { 
	include_once('niwoomcr-function.php');
	class NiWooMCR_Core extends NiWooMCR_Function{
		function __construct(){
			add_action( 'admin_menu',  array(&$this,'admin_menu' ));
			add_action( 'admin_enqueue_scripts',  array(&$this,'admin_enqueue_scripts' ));
			add_action( 'wp_ajax_niwoomcr_ajax',  array(&$this,'niwoomcr_ajax' )); /*used in form field name="action" value="my_action"*/
			//add_filter( 'gettext', array($this, 'get_text'),20,3);
		}
		function get_text($translated_text, $text, $domain){
			if($domain == 'niwoomcr'){
				return '['.$translated_text.']';
			}		
			return $translated_text;
		}
		function niwoomcr_ajax(){
			$sub_action =	$this->get_request("sub_action");
			if ($sub_action  =="niwoomcr-currency-report"){
				include_once("niwoomcr-currency-report.php");
				$obj = new NiWooMCR_Currency_Report();
				$obj->get_ajax_action();	
			}
			if ($sub_action  =="niwoomcr-order-report"){
				include_once("niwoomcr-order-report.php");
				$obj = new NiWooMCR_Order_Report();
				$obj->get_ajax_action();	
			}
			//niwoomcr-order-report
			//echo json_encode($_REQUEST);
			die;
		}
		function admin_enqueue_scripts(){
			$page =	$this->get_request("page");
			if ($page =="niwoomcr-currency-report" || $page =="niwoomcr-order-report" || $page =="niwoomcr-dashboard"){
				wp_enqueue_script( 'niwoomcr-script', plugins_url( '../admin/js/niwoomcr-currency-report.js', __FILE__ ), array('jquery') );	
			
				wp_enqueue_script( 'niwoomcr-script', plugins_url( '../admin/js/script.js', __FILE__ ), array('jquery') );	
				wp_localize_script( 'niwoomcr-script','niwoomcr_ajax_object',array('niwoomcr_ajaxurl'=>admin_url('admin-ajax.php')));
				
				
				wp_register_style('niwoomcr-bootstrap-css', plugins_url('../admin/css/lib/bootstrap.min.css', __FILE__ ));
		 		wp_enqueue_style('niwoomcr-bootstrap-css' );
				
				
				wp_register_style('niwoomcr-font-awesome-css', plugins_url('../admin/css/font-awesome.min.css', __FILE__ ));
		 		wp_enqueue_style('niwoomcr-font-awesome-css' );
				
				
				wp_register_style('niwoomcr-currency-report-css', plugins_url('../admin/css/niwoomcr-currency-report.css', __FILE__ ));
		 		wp_enqueue_style('niwoomcr-currency-report-css' );
				
				wp_enqueue_script('niwoomcr-bootstrap-script', plugins_url( '../admin/js/lib/bootstrap.min.js', __FILE__ ) );
					
			}
		}
		function admin_menu(){
			add_menu_page(__(  'Currency Report', 'niwoomcr')
			,__(  'Currency Report', 'niwoomcr')
			,'manage_options'
			,'niwoomcr-dashboard'
			,array(&$this,'add_page')
			,'dashicons-chart-pie'
			,59.85);
			
			add_submenu_page('niwoomcr-dashboard'
			,__( 'Dashboard', 'niwoomcr' )
			,__( 'Dashboard', 'niwoomcr' )
			,'manage_options'
			,'niwoomcr-dashboard' 
			,array(&$this,'add_page'));
			
		
			add_submenu_page('niwoomcr-dashboard'
			,__( 'Order Report', 'niwoomcr' )
			,__( 'Order Report', 'niwoomcr' )
			, 'manage_options', 'niwoomcr-order-report' 
			, array(&$this,'add_page'));
			
			
			add_submenu_page('niwoomcr-dashboard'
			,__( 'Currency Report', 'niwoomcr' )
			,__( 'Currency Report', 'niwoomcr' )
			, 'manage_options', 'niwoomcr-currency-report' 
			, array(&$this,'add_page'));
			
			
			
			
		}
		function add_page(){
			$page =	$this->get_request("page");
		
			$page =	$this->get_request("page");
			if ($page =="niwoomcr-dashboard"){
				include_once("niwoomcr-dashboard.php");
				$obj =  new NiWooMCR_Dashboard();
				$obj->get_page_init();
			}
			if ($page =="niwoomcr-order-report"){
				include_once("niwoomcr-order-report.php");
				$obj = new NiWooMCR_Order_Report();
				$obj->get_page_init();
			}
			if ($page =="niwoomcr-order-product-report"){
				include_once("niwoomcr-order-product-report.php");
				$obj = new NiWooMCR_Order_Product_Report();
				$obj->get_page_init();
			}
			if ($page =="niwoomcr-currency-report"){
				include_once("niwoomcr-currency-report.php");
				$obj = new NiWooMCR_Currency_Report();
				$obj->get_page_init();
			}
		}
	}
}
?>