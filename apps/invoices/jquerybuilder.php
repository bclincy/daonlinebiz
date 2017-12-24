<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="default.css" rel="stylesheet" type="text/css" />
<script type="application/javascript" src="../../inc/jquery-1.6.1.min.js" ></script>
<script type="application/javascript">
function get(){
	$.post('jquerydata.php', {name: form.name.value}, 
	function(output){
		$('#age').html(output).show();
	}
	
	);
}
function savecart(){ 
   $.post("jquerydata.php",{addtoInvoice: frmProdstoInv.addtoInvoice.value, qty: frmProdstoInv.qty.value}, 
   function(output){
		$('#age').html(output).show();
	}
    );
}
</script>

</head>

<body> 
<p>
<form name="form"><input type="button" value="Products" onclick="get();" />
  <input type="button" name="showproduct" id="showproduct" value="Show" OnClick="saveproduct()" />
</form>

<div id="age">
</div>
</p>
</body>
</html>