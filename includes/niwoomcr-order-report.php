<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'NiWooMCR_Order_Report' ) ) {
	include_once('niwoomcr-function.php');
	class NiWooMCR_Order_Report extends NiWooMCR_Function{
		function __construct(){
			
		}
		function get_page_init(){
		$currency   = $this->get_order_currency();
			
		?>
        <div class="container">
        	<div class="card">
              <div class="card-header">
                <?php _e('Search Order Report', 'niwoomcr'); ?>
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
                  <?php do_action('ni_woocommerce_search_form_bottom',$this);?>
                  
                  
                  <div class="form-group row" >
                   <div class="col-sm-12" style="text-align:right">
                   	 <input type="submit" class="btn btn-primary" value="<?php esc_html_e( 'Search', 'niwoomcr' ); ?>"   />
                   </div>
                  	 
                    
                  </div>
                  
                  <input type="hidden" name="sub_action" id="sub_action" value="niwoomcr-order-report" />
                  <input type="hidden" name="action" id="action" value="niwoomcr_ajax" />
                
                </form>
                </div>
            </div>
 			
            
            <div class="niwoomcr_ajax_content" style="padding-top:20px;"></div>
		</div>
        <?php
			do_action('ni_woocommerce_footer',$this);					
		}
		function get_order_data(){
			$rows  = $this->get_query();
			foreach($rows  as $row_key=>$row_value ){
				$order_id =$row_value->order_id;
				$order_detail = $this->get_order_detail($order_id);
				foreach($order_detail as $dkey => $dvalue){
							$rows[$row_key]->$dkey =$dvalue;
						
				}
			}
			//$this->prettyPrint($rows);
			return $rows;
		}
		function get_ajax_action(){
			//echo json_encode($_REQUEST);
			$this->get_report_table();
		}
		function get_report_table(){
			$columns  		= $this->get_columns();
			$rows			= $this->get_order_data();
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
                        
                          <?php case "billing_country": ?>
                          <?php $td_vale = $this->get_country_name($row_value->billing_country) ;  ?>
                          <?php break; ?>
                        
                         <?php case "order_status": ?>	
                         <?php $td_vale =  ucfirst ( str_replace("wc-","", $row_value->order_status));   ?>
                         <?php break; ?>
                        
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
		}
		function get_query($type='rows'){
			global $wpdb;
			$today 			= date_i18n("Y-m-d");
			$order_period	= $this->get_request("order_period");
			$order_currency = $this->get_request("order_currency");
			
			$query  = "";
			$query = "SELECT ";
			$query .= "	posts.ID as order_id ";
			$query .= "		,posts.post_status as order_status ";
			$query .= "		, date_format( posts.post_date, '%Y-%m-%d') as order_date  ";
			$query .= "		FROM {$wpdb->prefix}posts as posts	";
			if ( $order_currency !="-1"){
				$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as order_currency ON order_currency.post_id=posts.ID ";
			}
			$query .= "  WHERE 1 = 1";  
			$query .= " AND	posts.post_type ='shop_order' ";
			if ( $order_currency !="-1"){
				$query .= " AND order_currency.meta_value = '{$order_currency}'";	
			}
			$query .= " AND posts.post_status NOT IN('auto-draft') ";
			$date_query = "";
			switch ($order_period) {
					case "today":
						$date_query = " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
						break;
					case "yesterday":
						$date_query = " AND  date_format( posts.post_date, '%Y-%m-%d') = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y-%m-%d')";
						break;
					case "last_7_days":
						$date_query = " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY), '%Y-%m-%d') AND   '{$today}' ";
						break;
					case "last_10_days":
						$date_query = " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY), '%Y-%m-%d') AND   '{$today}' ";
						break;	
					case "last_30_days":
							$date_query = " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND   '{$today}' ";
					 case "last_60_days":
							$date_query = " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND   '{$today}' ";		
						break;	
					case "this_year":
						$date_query =" AND  YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(date_format(CURDATE(), '%Y-%m-%d'))";			
						break;
					default:
						$date_query = " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
				}
				
			$query .= apply_filters('ni_woocommerce_search_query_date_range', $date_query,$this);
				
			$query .= "order by posts.post_date DESC";	
		
			$rows = $wpdb->get_results( $query );
			
			return $rows;
		}
		function get_order_detail($order_id){
			$order_detail	= get_post_meta($order_id);
			$order_detail_array = array();
			foreach($order_detail as $k => $v){
				$k =substr($k,1);
				$order_detail_array[$k] =$v[0];
			}
			return 	$order_detail_array;
		}
		function get_columns(){
			//echo json_encode($_REQUEST);
			
			$columns 		= array();
			
			$columns["order_id"] = __("#ID","niwoomcr");
			$columns["order_date"] = __("Date","niwoomcr");
			$columns["billing_first_name"] = __("First Name","niwoomcr");
			$columns["billing_email"] = __("Email","niwoomcr");
			$columns["order_status"] = __("Status","niwoomcr");
			
			$columns["payment_method_title"] = __("Payment Method","niwoomcr");
			$columns["billing_country"] = __("Country","niwoomcr");
			
			$columns["order_currency"] = __("Currency","niwoomcr");
			
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