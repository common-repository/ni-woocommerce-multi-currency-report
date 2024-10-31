jQuery(document).ready(function($) {
	$( "#frm_niwoomcr" ).submit(function( event ) {
			$(".niwoomcr_ajax_content").html("Please wait..");
		$.ajax({
			url:niwoomcr_ajax_object.niwoomcr_ajaxurl,
			data: $(this).serialize(),
			success:function(data) {
				$(".niwoomcr_ajax_content").html(data);
			},
			error: function(errorThrown){
				console.log(errorThrown);
				//alert("e");
			}
		}); 
		return false; 
	});
	
	
	$("#frm_niwoomcr").trigger("submit");
});
