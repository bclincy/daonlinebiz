// JavaScript Document
$('#frmEvent').submit(function (){
 var noerror=true;
 $(this).find(".req").each(function (){
	var r = $(this);
	 if(r.attr("name")){
		 if(!r.val()){
			$("#"+r.attr("name")).css("background-color",'#F00').css('font-weight', 'bold');
			noerror=false;
		 }//end if
		 else{
			 $("#"+r.attr("name")).css("background-color",'FFF');
		 }
	 }
 }//end each
 );
if(noerror){
	$.post("eventprocessing.php", $("#frmEvent").serialize(), function(output){
		if(output==1){
			$('h2:eq(0)').empty(); 
			$("p:eq(0)").before('<h2>Error: Complete All Fields</h2>'); 
		}
		if(output==2){
			$('h2:eq(0)').empty(); 
			$("p:eq(0)").before('<h2>Error: Bad Data in Field</h2>');
		}
	alert(output);	
	});
}
return false;
}); 