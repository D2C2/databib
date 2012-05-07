
$(function() {
	
	  $("#post").click(function() {
		  
		  var commenttext =  $.trim($("#commenttext").val());
		  var recordid = $("#recordid").val();  
	      var author = $("#author").val();  
	      
	      var dataString = 'comment='+ commenttext + "\&recordid=" + recordid + "\&author=" + author ;  
		  
		  $.ajax({
	      type: "POST",
	      url: "./include/insertcomments.php",
	      data: dataString,
	      success: function(data) {
			$('#commentsform').append("<div id='message'></div>");
	        $('#message').html("<p> Your comment was successfully posted !</p>");
	      },
	      error : function(XMLHttpRequest, textStatus, errorThrown) {
	    		$('#commentsform').append("<div id='message'></div>");
		        $('#message').html("<p> <font color=\"Red\"> Your must be logged in !</font></p>");
	    	  }
	      
	     });
	    return false;
		});
});

