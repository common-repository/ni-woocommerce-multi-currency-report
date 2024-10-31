<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'NiWooMCR_Dashboard' ) ) {
	include_once('niwoomcr-function.php');
	class NiWooMCR_Dashboard  extends NiWooMCR_Function{
		function __construct(){
		//https://mdbootstrap.com/docs/jquery/css/gradients/
		//https://bootdey.com/snippets/view/Gradients-dashboard-cards
		//https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/html/ltr/vertical-menu-template/card-statistics.html
		//https://www.codeply.com/go/HeMnWL8to0/bootstrap-4-card-examples
		}
		function get_page_init(){
		$today 			 				 = date_i18n("Y-m-d");
		$last_order_date 				 = $this->get_last_order_date();
		$last_order_string 				 = $this->time_elapsed_string($last_order_date);
		$status		 	 				 = $this->get_order_status($today ,$today,"wc-completed" );
	    $today_completed_order_count 	 = $this->get_order_count($today , $today, "wc-completed"  );
		
		$today_total_customer 			 = $this->get_total_today_order_customer('custom',false,$today,$today);
		$today_total_guest_customer 	 = $this->get_total_today_order_customer('custom',true,$today,$today);
		
		//$this->prettyPrint($status	);
		  
		?>
       
      
        <div class="container" id="niwoomcr-dashboard">
        	<div class="row">
            	<div class="col-md-12 col-xl-12" style="margin-top:10px;">
                    <div class="card" style="max-width:100%">
                    	<div class="card-header">
                         <h3 style="text-align:center; font-size:20px; padding:0px; margin:10px; color:#78909C ">
                            Monitor your sales and grow your online business
                            </h3>
                        </div>	
                      <div class="card-body">
                      	<div class="ni-pro-info">
                           
                            
                            <h1 style="text-align:center; color:#2cc185">Buy Ni WooCommerce Sales Report Pro @ $24.00</h1>
                            <div style="width:33%; float:left; padding:5px">
                                <ul>
                                    <li>Dashboard order Summary</li>
                                    <li>Order List - Display order list</li>
                                    <li>Order Detail - Display Product information</li>
                                    <li style="font-weight:bold; color:#2cc185">Sold Product variation Report</li>
                                    <li>Customer Sales Report</li>
                                </ul>
                            </div>
                            <div style="width:33%;padding:5px; float:left">
                                <ul>
                                    <li>Payment Gateway Sales Report</li>
                                    <li>Country Sales Report</li>
                                    <li>Coupon Sales Report</li>
                                    <li>Order Status Sales Report</li>
                                    <li style="font-weight:bold; color:#2cc185">Stock Report(Simple, Variable and Variation Product)</li>
                                </ul>
                            </div>
                            <div>
                                <ul>
                                    <li><span style="color:#26A69A">Email at: <a href="mailto:support@naziinfotech.com">support@naziinfotech.com</a></span></li>
                                    <li><a href="http://demo.naziinfotech.com?demo_login=woo_sales_report" target="_blank">View Demo</a>  </li>
                                    <li><a href="http://naziinfotech.com/?product=ni-woocommerce-sales-report-pro" target="_blank">Buy Now</a>  </li>
                                    <li>Coupon Code: <span style="color:#26A69A; font-size:16px"><span style="font-size:24px; font-weight:bold;color:#F00">ni10</span>Get 10% OFF</span></li>
                                    
                                </ul>
                             </div>
                             
                           
                              <div style="clear:both"></div>
                              <div style="width:100%;padding:5px; float:left">
                              <p  style="width:100%;padding:5px; font-size:16px;color:#F00">
                             
                              </div>
                             
                              
                        </div>
                        <div class="card-footer text-white bg-primary">
                              We will create new custom report as per custom requirement, if you require more analytic report or require any customization in this report then please feel free to contact with us.
                           
                              <b> For any WordPress or woocommerce customization, queries and support please email at : <strong><a href="mailto:support@naziinfotech.com" style="color:#2cc185;">support@naziinfotech.com</a></strong></b>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    <div class="card bg-c-blue order-card" style="padding:10px;">
                        <div class="card-block">
                            <h6 class="m-b-20"><?php esc_html_e( 'Last Orders Received', 'niwoomcr' ); ?></h6>
                            <h2 class="text-right">
                                <i class="fa fa-cart-plus f-left"></i>
                                <span>&nbsp;&nbsp;</span>
                            </h2>
                            <p class="m-b-0"> &nbsp;&nbsp;
                                <span class="f-right"><?php  echo $last_order_string; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3">
                    <div class="card bg-c-green order-card" style="padding:10px;" >
                        <div class="card-block">
                            <h6 class="m-b-20"> <?php esc_html_e( 'Today Orders Received', 'niwoomcr' ); ?> </h6>
                            <h2 class="text-right">
                                <i class="fa fa-rocket f-left"></i>
                                <span><?php echo  $today_completed_order_count; ?></span>
                            </h2>
                            <p class="m-b-0">Completed Orders
                                <span class="f-right"> &nbsp;&nbsp;</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3">
                    <div class="card bg-c-yellow order-card" style="padding:10px;">
                        <div class="card-block">
                            <h6 class="m-b-20"><?php esc_html_e( 'Today registered Customer', 'niwoomcr' ); ?> </h6>
                            <h2 class="text-right">
                                <i class="fa fa-refresh f-left"></i>
                                <span>&nbsp;&nbsp;</span>
                            </h2>
                            <p class="m-b-0">&nbsp;&nbsp;
                                <span class="f-right"><?php echo $today_total_customer; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3">
                    <div class="card bg-c-pink order-card" style="padding:10px;">
                        <div class="card-block">
                            <h6 class="m-b-20"><?php esc_html_e( 'Today GUEST Customer', 'niwoomcr' ); ?></h6>
                            <h2 class="text-right">
                                <i class="fa fa-credit-card f-left"></i>
                                <span>&nbsp;&nbsp;</span>
                            </h2>
                            <p class="m-b-0">&nbsp;&nbsp;
                                <span class="f-right"><?php  echo $today_total_guest_customer ; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
        <?php
		}
		function get_order_count($start_date = NULL, $end_date =NULL, $order_status){
			global $wpdb;
			$query = "";
			$query .= " SELECT ";
			$query .= "	count(*)as 'order_count'";
			$query .= "	FROM {$wpdb->prefix}posts as posts	";
			$query .= " WHERE 1 = 1";  
			if ($start_date &&  $end_date)
			$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}'";
			$query .= " AND	posts.post_type ='shop_order' ";
			
			if ($order_status !=NULL){
				$query .= " AND	posts.post_status IN ('{$order_status}')";
			}
			
			
			$query .= " ORDER BY posts.post_date DESC";
			
			
			
			return $rows = $wpdb->get_var( $query );	
		}
		function get_last_order_date(){
			global $wpdb;
			$query = "";
			$query .= " SELECT ";
			$query .= "	posts.post_date as order_date";
			$query .= "	FROM {$wpdb->prefix}posts as posts	";
			$query .= " WHERE 1 = 1";  
			$query .= " AND	posts.post_type ='shop_order' ";
			
			
			
			
			$query .= " ORDER BY posts.post_date DESC";
			
			return $rows = $wpdb->get_var( $query );
			
		}
		function get_order_status($start_date, $end_date,$order_status =NULL){
			global $wpdb;
			$query = "";
			$query .= " SELECT ";
			$query .= "	posts.post_status as order_status";
			
			$query .= "	,SUM(ROUND(order_total.meta_value,2)) as order_total";
			
			$query .= "	,COUNT(*) as order_count";
			
			
			$query .= "	FROM {$wpdb->prefix}posts as posts	";
			
			$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";
			
			$query .= " WHERE 1 = 1";  
			$query .= " AND	posts.post_type ='shop_order' ";
			
			$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}'";
			$query .= " AND order_total.meta_key = '_order_total'";	
			
			if ($order_status !=NULL){
				$query .= " AND	posts.post_status IN ('{$order_status}')";
			}
			
			//$query .= " GROUP BY posts.post_status ";
			
			//$query .= " GROUP BY posts.post_status ";
			
			return $rows = $wpdb->get_results( $query );
			
		}
		function get_total_today_order_customer($type = 'total', $guest_user = false,$start_date = '',$end_date = ''){
			global $wpdb;
		
			
			$query = "SELECT ";
			if(!$guest_user){
				$query .= " users.ID, ";
			}else{
				$query .= " email.meta_value AS  billing_email,  ";
			}
			$query .= " posts.post_date
			FROM {$wpdb->prefix}posts as posts
			LEFT JOIN  {$wpdb->prefix}postmeta as postmeta ON postmeta.post_id = posts.ID";
			
			if(!$guest_user){
				$query .= " LEFT JOIN  {$wpdb->prefix}users as users ON users.ID = postmeta.meta_value";
			}else{
				$query .= " LEFT JOIN  {$wpdb->prefix}postmeta as email ON email.post_id = posts.ID";
			}
			
			$query .= " WHERE  posts.post_type = 'shop_order'";
			
			$query .= " AND postmeta.meta_key = '_customer_user'";
			
			if($guest_user){
				$query .= " AND postmeta.meta_value = 0";
				
				if($type == "today")		{$query .= " AND DATE(posts.post_date) = '{$this->today}'";}
				if($type == "yesterday")	{$query .= " AND DATE(posts.post_date) = '{$this->yesterday}'";}
				if($type == "custom")		{
						$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}' ";
				}
				
				$query .= " AND email.meta_key = '_billing_email'";
				
				$query .= " AND LENGTH(email.meta_value)>0";
			}else{
				$query .= " AND postmeta.meta_value > 0";
				if($type == "today")		{$query .= " AND DATE(users.user_registered) = '{$this->today}'";}
				if($type == "yesterday")	{$query .= " AND DATE(users.user_registered) = '{$this->yesterday}'";}
				if($type == "custom")		{
						$query .= " AND  date_format( users.user_registered, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}' ";
				}
				
				
			}
			
			if(!$guest_user){
				$query .= " GROUP BY  users.ID";
			}else{
				$query .= " GROUP BY  email.meta_value";		
			}
			
			$query .= " ORDER BY posts.post_date desc";
			
			
			$user =  $wpdb->get_results($query);
			
		
			
			$count = count($user);
			return $count;
		}
		function time_elapsed_string($datetime, $full = false) {
			$now = new DateTime;
			$ago = new DateTime($datetime);
			$diff = $now->diff($ago);
		
			$diff->w = floor($diff->d / 7);
			$diff->d -= $diff->w * 7;
		
			$string = array(
				'y' => 'year',
				'm' => 'month',
				'w' => 'week',
				'd' => 'day',
				'h' => 'hour',
				'i' => 'minute',
				's' => 'second',
			);
			foreach ($string as $k => &$v) {
				if ($diff->$k) {
					$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
				} else {
					unset($string[$k]);
				}
			}
		
			if (!$full) $string = array_slice($string, 0, 1);
			return $string ? implode(', ', $string) . ' ago' : 'just now';
		}
	} 
}
?>