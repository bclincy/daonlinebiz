// JavaScript Document
$(document).ready(function (){
}
);
$("#frmSports").validate({
		rules: {
			newsport: "required"
		},
		messages: {
			newsport:{ required: 'Sport is Required'}
		}
});
$(".confirm").easyconfirm();
	$("#alert").click(function() {
		$('#frmMansports').submit();
});
/*$.post("registprocessing.php", $("#frmPinfo").serialize(), function(output){	
		if(output==0){
			$('.error').replaceWith('<div class="error"><h2>Email Exists already!</h2><p><a href="../signin.php">Sign In</a></p></div>');
		}
		else if(output==44){
			$('.error').replaceWith('<div class="error"><h2>Are You Human?</h2><p>Something is not right about the data you submited we entered </p></div>');
		}
		else if(output==1){
			$('.error').replaceWith('<div class="error"><h2>Passwords don\'t Match</h2><p>Something is not right about the data you submited we entered </p></div>');
		}
		else{ alert(output);
			return false;
		}//show
		});*/