// JavaScript Document
$('document').ready(
function(){
	//$('#addfiles').hide();
}
);
$('#attachments').click(
	function(){
		$('#addfiles').slideToggle('fast');
	}
);
$('.upload').live({
	change:function(){
		 var attachment=$('*:file').length + 1;
		$(this).after('<br /><label for="attachment">Attachment '+attachment+'</label><input type="file" class="upload" name="attachment[]" />');
	}
}
);
$('#qstring').keyup(
function (){
	var strlen = $("#qstring").val().length;
	if(strlen > 2){
		$('#data').hide();
		$.post("/inc/jqueryusers.php", { qstring: $("#qstring").val() },
   			function(data){
			$('#search').show().html(data);		
		});
	}
	else if( strlen < 3 && strlen > 0){$('#search').show().html("<h2>Search for  "+ $('#qstring').val()+"</h2>"); }
	else{ 
		$('#search').empty().hide(); 
		$('#data').show(); 
	}
	
}
);
