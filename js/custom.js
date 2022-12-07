window.IMGURL = "";
window.QUEUE = [];
window.CURRENNT = 0;

$(document).ready(function() {

	$("#post_to_page_form").submit(function(e) {
		e.preventDefault();

		jQuery(".hidden_loader").show();
		
		window.QUEUE = $(".group_label input:checked");

		call_next_page(window.QUEUE);
		return false;
	});

});

function call_next_page(queue) {
	
	console.log(queue.length);
	if(queue.length == 0) {
		return calls_completed();
	}
	
	var me = queue.pop();  

	var caption = $("#post_to_page_form").find("textarea").val();

	var data =  {
		page_id: me.value,
		img: window.IMGURL,
		text: caption
	}

	var pagname = jQuery("input[value="+me.value+"]").parent().text();

	jQuery(".loader_current_span").html("Posting to "+pagname);

	$.post(SITE_URL+"ajax-post.php" , data ).done(function() {
		//if(queue.length) {
			call_next_page(queue);		
		//}
	})/*.error(function() {
		if(queue.length) {
			call_next_page(queue);		
		}
	})*/




}


(function( $ ) {
    $.fn.pop = function() {
        var top = this.get(-1);
        this.splice(this.length-1,1);
        return top;
    };

    $.fn.shift = function() {
        var bottom = this.get(0);
        this.splice(0,1);
        return bottom;
    };
})( jQuery );

function calls_completed() {
	jQuery(".hidden_loader").hide();
	alert("Completed");
	location.reload();
}