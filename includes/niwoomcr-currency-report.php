<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'NiWooMCR_Currency_Report' ) ) {
	include_once('niwoomcr-function.php');
	class NiWooMCR_Currency_Report extends NiWooMCR_Function{
		function __construct(){
		}
		function get_page_init(){
		$currency   = $this->get_order_currency();
		
		?>
        <div class="container" style="padding-top:10px;">
        	<div class="card">
              <div class="card-header">
                
                <?php esc_html_e( 'Search Currency Report', 'niwoomcr' ); ?>
              </div>
              <div class="card-body">
                  <form name="frm_niwoomcr" id="frm_niwoomcr">
                  
                  <?php do_action('ni_woocommerce_search_form_top',$this);?>
                  
                  <div class="form-group row">
                    <label for="order_period" class="col-sm-2 col-form-label"><?php _e('Order Period', 'niwoomcr'); ?></label>
                    <div class="col-sm-4">
                    <select name="order_period"  id="order_period" class="form-control" >
                          <option value="today"><?php _e('Today', 'niwoomcr'); ?></option>
                          <option value="yesterday"><?php _e('Yesterday', 'niwoomcr'); ?></option>
                          <option value="last_7_days"><?php _e('Last 7 days', 'niwoomcr'); ?></option>
                          <option value="last_10_days"><?php _e('Last 10 days', 'niwoomcr'); ?></option>
                          <option value="last_30_days"><?php _e('Last 30 days', 'niwoomcr'); ?></option>
                          <option value="last_60_days"><?php _e('Last 60 days', 'niwoomcr'); ?></option>
                          <option value="this_year"><?php _e('This year', 'niwoomcr'); ?></option>
                    </select>
                    </div>
                    
                    <label for="group_by" class="col-sm-2 col-form-label"><?php _e('Group by', 'niwoomcr'); ?></label>
                    <div class="col-sm-4">
                         <select name="group_by" id="group_by"  class="form-control">
                            <option value="crrency" ><?php esc_html_e( 'Currency', 'niwoomcr' ); ?> </option>
                            <option value="currency-country"> <?php esc_html_e( 'Currency + Country', 'niwoomcr' ); ?> </option>
                            <option value="currency-payment-method"> <?php esc_html_e( 'Currency + Payment Method', 'niwoomcr' ); ?></option>
                        </select>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    
                    <label for="order_currency" class="col-sm-2 col-form-label"><?php _e('Order Currency', 'niwoomcr'); ?></label>
                    <div class="col-sm-4">
                     <select name="order_currency" id="order_currency"  class="form-control">
                          <option value="-1" ><?php _e('--Select Currency--', 'niwoomcr'); ?></option>
						 <?php foreach($currency as $key=>$value): ?>
                         <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                         <?php endforeach;?>
                    </select>
                    </div>
                  </div>
                  
                  <div class="form-group row" >
                   <div class="col-sm-12" style="text-align:right">
                   	 <input type="submit" class="btn btn-primary" value="<?php esc_html_e( 'Search', 'niwoomcr' ); ?>"   />
                   </div>
                  	 
                    
                  </div>
                  
                  <input type="hidden" name="sub_action" id="sub_action" value="niwoomcr-currency-report" />
                  <input type="hidden" name="action" id="action" value="niwoomcr_ajax" />
                
                </form>
                </div>
            </div>
        	<div class="niwoomcr_ajax_content" style="padding-top:20px;"></div>
		</div>
        
        
        <?php	
			do_action('ni_woocommerce_footer',$this);
		}
		function get_data(){
			//$rows =  $this->get_query();
			//$this->prettyPrint($rows);
			
		}
		function get_ajax_action(){
			//echo json_encode($_REQUEST);
			$this->get_report_table();
		}
		function get_report_table(){
			$group_by 		= $this->get_request("group_by");
			$columns  		= $this->get_columns($group_by );
			$rows 	  =  $this->get_query();
			//$this->prettyPrint($columns);
			$td_vale  = "";
			$td_class = ""; 
			?>
            <div class="table-responsive">
            	<table class="table  table-bordered">
           		<thead class="thead-light">
                	<tr>
                	<?php foreach($columns as $key=>$value): ?>
                    	<th><?php echo $value; ?></th>
                    <?php endforeach; ?>
                	</tr>
                </thead>
                <tbody>
                 <?php foreach($rows  as $row_key=>$row_value): ?>
                  <tr>
                  	 <?php foreach($columns  as $col_key=>$col_value): ?>
                     	<?php switch($col_key): case 1: break; ?>
                        
                        
                         <?php default; ?>
                         <?php $td_vale = isset($row_value->$col_key)?$row_value->$col_key:""; ?>
                        <?php endswitch; ?>
                     <td <?php echo $td_class; ?>><?php echo $td_vale ;  ?></td>
                     <?php endforeach; ?>
                    
                  </tr>
                 <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            
            <?php

			
			
			
			
			//$this->prettyPrint($rows);
			
		}
		function get_query($type='rows'){
			//echo json_encode($_REQUEST);
			global $wpdb;
			$group_by 		= $this->get_request("group_by");
			$today 			= date_i18n("Y-m-d");
			$order_period	= $this->get_request("order_period");
			$order_currency = $this->get_request("order_currency");
			
			
			$query = "";
			$query .= " SELECT ";
			//$query .= "	posts.ID as order_id";
			//$query .= "	,posts.post_status as order_status";
			$query .= "	order_currency.meta_value as order_currency";
			
			/*cart_discount*/
			$query .= ",SUM(ROUND(cart_discount.meta_value,2)) as cart_discount";
			/*cart_discount_tax*/
			$query .= "	,SUM(ROUND(cart_discount_tax.meta_value,2)) as cart_discount_tax";
			
			/*order_shipping*/
			$query .= "	,SUM(ROUND(order_shipping.meta_value,2)) as order_shipping";
			/*order_shipping*/
			$query .= "	,SUM(ROUND(order_shipping_tax.meta_value,2)) as order_shipping_tax";
			/*order_tax*/
			$query .= "	,SUM(ROUND(order_tax.meta_value,2)) as order_tax";
			/*order_tax*/
			$query .= "	,SUM(ROUND(order_total.meta_value,2)) as order_total";
			
			/*billing_country*/
			if ($group_by =="currency-country"){
				$query .= ",	billing_country.meta_value as billing_country";
			}
			/*payment_method*/
			if ($group_by =="currency-payment-method"){
				$query .= ",	payment_method.meta_value as payment_method";
				$query .= ",	payment_method_title.meta_value as payment_method_title";
			}
			
			
			$query .= "	FROM {$wpdb->prefix}posts as posts	";
			$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as order_currency ON order_currency.post_id=posts.ID ";
			
			/*cart_discount*/
			$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as cart_discount ON cart_discount.post_id=posts.ID ";
			/*cart_discount_tax*/
			$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as cart_discount_tax ON cart_discount_tax.post_id=posts.ID ";
			/*order_shipping*/
			$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as order_shipping ON order_shipping.post_id=posts.ID ";
			/*order_shipping_tax*/
			$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as order_shipping_tax ON order_shipping_tax.post_id=posts.ID ";
			/*order_tax*/
			$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as order_tax ON order_tax.post_id=posts.ID ";
			/*order_total*/
			$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";
			
			/*billing_country*/
			if ($group_by =="currency-country"){
				$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id=posts.ID ";
			}
			
			/*payment_method*/
			if ($group_by =="currency-payment-method"){
				$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as payment_method ON payment_method.post_id=posts.ID ";
				$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as payment_method_title ON payment_method_title.post_id=posts.ID ";
			}
			
			
			$query .= " WHERE 1 = 1";  
			$query .= " AND	posts.post_type ='shop_order' ";
			$query .= " AND order_currency.meta_key = '_order_currency'";	
			/*cart_discount*/
			$query .= " AND cart_discount.meta_key = '_cart_discount'";	
			/*cart_discount_tax*/
			$query .= " AND cart_discount_tax.meta_key = '_cart_discount_tax'";	
			/*order_shipping*/
			$query .= " AND order_shipping.meta_key = '_order_shipping'";	
			/*order_shipping_tax*/
			$query .= " AND order_shipping_tax.meta_key = '_order_shipping_tax'";	
			/*order_tax*/
			$query .= " AND order_tax.meta_key = '_order_tax'";	
			/*order_tax*/
			$query .= " AND order_total.meta_key = '_order_total'";	
			
			/*billing_country*/
			if ($group_by =="currency-country"){
				$query .= " AND billing_country.meta_key = '_billing_country'";	
			}
			/*payment_method*/
			if ($group_by =="currency-payment-method"){
				$query .= " AND payment_method.meta_key = '_payment_method'";	
				$query .= " AND payment_method_title.meta_key = '_payment_method_title'";	
			}
			
			if ( $order_currency !="-1"){
				$query .= " AND order_currency.meta_value = '{$order_currency}'";	
			}
			$date_query = "";
			switch ($order_period) {
					case "today":
						$date_query = " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
						break;
					case "yesterday":
						$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y-%m-%d')";
						break;
					case "last_7_days":
						$date_query = " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY), '%Y-%m-%d') AND   '{$today}' ";
						break;
					case "last_10_days":
						$date_query =  " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY), '%Y-%m-%d') AND   '{$today}' ";
						break;	
					case "last_30_days":
							$date_query = " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND   '{$today}' ";
					 case "last_60_days":
							$date_query =  " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND   '{$today}' ";		
						break;	
					case "this_year":
						$date_query =  " AND  YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(date_format(CURDATE(), '%Y-%m-%d'))";			
						break;		
					default:
						$date_query =  " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
				}
				
				$query .= apply_filters('ni_woocommerce_search_query_date_range', $date_query,$this);
				
				if ($group_by =="crrency"){
					$query .= " GROUP BY order_currency.meta_value";
				}
				
				if ($group_by =="currency-country"){
					$query .= " GROUP BY order_currency.meta_value, billing_country.meta_value";
				}
				if ($group_by =="currency-payment-method"){
					$query .= " GROUP BY order_currency.meta_value, payment_method.meta_value";
				}
			
			
			$rows = $wpdb->get_results( $query );
			
			return $rows;
		}
		function get_columns($group_by ="crrency"){
			//echo json_encode($_REQUEST);
			
			$columns 		= array();
			
			
			$columns["order_currency"] = __("Currency","niwoomcr");
			if ($group_by =="currency-payment-method"){
				
				//$columns["payment_method"] = __("payment_method","niwoomcr");
				$columns["payment_method_title"] = __("Payment Method","niwoomcr");
			}
			if ($group_by =="currency-country"){
				$columns["billing_country"] = __("Country","niwoomcr");
			}
			
			$columns["cart_discount"] = __("Cart Discount","niwoomcr");
			$columns["cart_discount_tax"] = __("Cart Discount Tax","niwoomcr");
			$columns["order_shipping"] = __("Order Shipping","niwoomcr");
			$columns["order_shipping_tax"] = __("Order Shipping Tax","niwoomcr");
			$columns["order_tax"] = __("Order Tax","niwoomcr");
			$columns["order_total"] = __("Order Total","niwoomcr");
			
			
			return $columns;
		}
	} 
}
?>