$(document).ready(function(){
	
	var user;
	
	/* Sign in with Twitter */
	
	// On load we check whether user's logged in or not:

	$.get("api/oauth_ajax.php", null, function(data){
		$("#spinner").hide();
		if (data && data.id_str) {
			// We have a signed-in Twitter user
		}
	});
	
	
	$(".signin").click(function(){
		$.ajax({
			url: "api/oauth_ajax.php?start=1", 
			success: function(data){
				if (data && data.authurl) {
					window.location = data.authurl;
				}
			},
			error: function(data){
				// Display error message
			}
		});
	});
	
	$(".logout").click(function(e){
		e.preventDefault();
		$.ajax({
			url: "api/oauth_ajax.php?wipe=1",
			success: function(){
				window.location.reload();
			}
		}); 
	});
});