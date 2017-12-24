// JavaScript Document

$(document).ready(
function (){
	$("#add").click(
		function(){
			var filecount=$('input[type="file"]').length  + 1;
			$('#fileuploads').after('<p><input type="file" name="eventpic_'+filecount+' id="eventpic_'+filecount+'" /></p>');
		}
	);
}
);