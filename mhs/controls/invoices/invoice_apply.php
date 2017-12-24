<?php require_once('../../Connections/dbcon.php');
mysql_select_db($database_dbcon, $dbcon);
if(isset($_POST['paymenttype'])){
	$i=1;
	foreach($_POST['paymenttype'] as $key=>$value){
		if($_POST['payment'][$key] > 0){
			$sql="INSERT INTO invoice_payments (payment, invoice_id, type, lastmodified) VALUES({$_POST['payment'][$key]}, $key, '$value', now())";
			$results=mysql_query($sql);
			if(mysql_insert_id()!=0){ $record[$i]=mysql_insert_id();$i++;}
		}//A value was used higher than zero
		if(!empty($_POST['note'][$key])){
			$sql="INSERT INTO invoice_notes (invoice_id, Note) VALUES($key, '{$_POST['note'][$key]}')";
			$results=mysql_query($sql);
		}
	}
	if(count($record) > 0){ 
		$msg="Payment for ". count($record)." items were posted";
		include_once('invoices.php'); 
		exit;
	}
	else { $msg="<h2>Error Processing the payment</h2>"; } 
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Apply Payment</title>
<link href="default.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="page">
  <div id="header">
    <div id="navi"><ul><li><a href="invoices.php">Home</a></li><li>Create New</li></ul></div>
    <h2>Customers</h2>
  </div>
  <div id="content"> 
<form id="frmMethod" name="frmMethod" method="post" action="invoice_apply.php">
<?
foreach($_POST['payment'] as $key=>$value){		
                if($value > 0){
			?><div><?= "Invoice#: $key<br />Customer: {$_POST['fname'][$key]} {$_POST['lname'][$key]}<br />Total: {$_POST['intotal'][$key]}<br /> "; ?> 
	<label for="payment[<?= $key; ?>]">Payment:</label>
	<span id="val_payment">
    <input name="payment[<?=$key; ?>]" type="text" id="payment[]" value="<?= $value; ?>" size="5" maxlength="10" />
    <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span><span class="textfieldMinValueMsg">The entered value is less than the minimum required.</span></span><br />
			<label for="paymenttype">Payment Method:</label>
			<select name="paymenttype[<?= $key; ?>]">
  				<option value="cash">Cash</option>
  				<option value="check">Check</option>
  				<option value="ccredit">Credit Card</option>
			</select><br />
        <label for="note">Notes:</label><input name="note[<?=$key; ?>]" type="text" value="<?= $_POST['note'][$key]; ?>" size="40" />
</div>

<?
		}
	}
?>
<input name="apply" type="button" value="Apply Payment" onclick="document.forms[0].submit()" />
</form>
</div><!-- Content -->
</div><!-- Page -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("val_payment", "integer", {minValue:1});
</script>
</body>
</html>