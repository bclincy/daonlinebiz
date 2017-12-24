<?php require_once('../../Connections/dbcon.php'); ?><?php
if(!isset($_SESSION['session_id'])){ session_start(); }
mysql_select_db($database_dbcon, $dbcon);
if(isset($_POST['btnupdateCust'])){ 
	include_once('../../inc/functions.php');
	$sql="UPDATE customers SET fname='{$_POST['fname']}', lname='{$_POST['lname']}', email='{$_POST['email']}', phone='{$_POST['phone']}', address1='{$_POST['address1']}', ";	
	$sql.="city='{$_POST['city']}', zipcode='{$_POST['zipcode']}', stateID={$_POST['stateID']}"; 
	if(!empty($_POST['company'])){ $sql.=", company='{$_POST['company']}' "; }
	if(!empty($_POST['address2'])){ $sql.=", address2='{$_POST['address2']}'"; }
	if(!empty($_POST['fax'])){$sql.=", fax='{$_POST['fax']}'"; }
	$sql.=" WHERE id={$_POST['id']}";
	$results = mysql_query($sql);
	if(mysql_affected_rows() > 0){
		$msg="<h2>Customer: {$_POST['fname']} {$_POST['lname']} was updated</h2>";
		include_once('customers.php');
		exit;
	}
	$msg="<h2>Problem Updating Customer: {$_POST['fname'] } {$_POST['lname']}</h2>"; 
}
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_DetailRS1 = 25;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$custID_DetailRS1 = "-1";
if (isset($_REQUEST['id'])) {
  $custID_DetailRS1 = $_REQUEST['id'];
}
$query_DetailRS1 = sprintf("SELECT c.ID, fname, c.lname, company, email, phone, address1, address2, city, zipcode, fax, c.stateID, abrivation FROM customers as c JOIN states as s ON s.stateID=c.stateID WHERE c.ID = %s", GetSQLValueString($custID_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $dbcon) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;

mysql_select_db($database_dbcon, $dbcon);
$query_rs_state = "SELECT * FROM states";
$rs_state = mysql_query($query_rs_state, $dbcon) or die(mysql_error());
$row_rs_state = mysql_fetch_assoc($rs_state);
$totalRows_rs_state = mysql_num_rows($rs_state);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Customer information: <?= $row_DetailRS1['fname'] . " " . $row_DetailRS1['lname']; ?></title>
<link href="default.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="page">
  <div id="header">
    <div id="navi"><ul><li><a href="invoices.php">Home</a></li><li><a href="invoice_new.php">Create New</a></li>
    <li><a href="customers.php">Customers</a></li></ul></div>
    <h2>Customer: <?php echo $row_DetailRS1['fname']; ?> <?php echo $row_DetailRS1['lname']; ?></h2>
  </div>
  <div id="content">
<? if(isset($msg)){ echo $msg; } ?>
<form action="customer_details.php" method="post" enctype="multipart/form-data" name="frmCustUpdate" id="frmCustUpdate">
<p>
    <label for="fname">First Name:</label>
    <span id="spryfname">
    <input name="fname" type="text" id="fname" value="<?php echo $row_DetailRS1['fname']; ?>" size="20" maxlength="55" />
    <span class="textfieldRequiredMsg">Name Required.</span></span></p>
<p>
    <label for="lname">Last Name:</label>
    <input name="lname" type="text" id="lname" value="<?php echo $row_DetailRS1['lname']; ?>" size="20" maxlength="55" />
</p>
<p>
    <label for="company">Company:</label>
    <input name="company" type="text" id="company" value="<?php echo $row_DetailRS1['company']; ?>" size="20" maxlength="100" />
</p>
<p>
    <label for="email">email:</label>
<input name="email" type="text" id="email" value="<?php echo $row_DetailRS1['email']; ?>" size="20" />
    <span class="textfieldRequiredMsg">Email Is Required.</span><span class="textfieldInvalidFormatMsg">Invalid Email.</span></p>
<p>
    <label for="address">Address:</label>
    <span id="spryAddress1">
    <input name="address1" type="text" id="address1" value="<?php echo $row_DetailRS1['address1']; ?>" size="20" maxlength="240" />
    <span class="textfieldRequiredMsg">Please Include Address.</span></span></p>
  <? if(!is_null($row_DetailRS1['address2'])){?>
  <p>
    <label for="address2">Address Line 2:</label>
    <input name="address2" type="text" id="address2" value="<?php echo $row_DetailRS1['address2']; ?>" size="20" maxlength="50" />
  </p>
  <? }// End address ?>
  <p>
    <label for="city">City:</label>
    <span id="sprycity">
    <input name="city" type="text" id="city" value="<?php echo $row_DetailRS1['city']; ?>" size="20" maxlength="150" />
    <span class="textfieldRequiredMsg">City is Required.</span></span></p>
  <p>
    <label for="stateID">State:</label> <select name="stateID">
      <option value="value" <?php if (!(strcmp("value",$row_DetailRS1['stateID']))) {echo "selected=\"selected\"";} ?>>label</option>
      <?php
do {  
?>
      <option value="<?php echo $row_rs_state['stateID']?>"<?php if (!(strcmp($row_rs_state['stateID'], $row_DetailRS1['stateID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_state['state']?></option>
      <?php
} while ($row_rs_state = mysql_fetch_assoc($rs_state));
  $rows = mysql_num_rows($rs_state);
  if($rows > 0) {
      mysql_data_seek($rs_state, 0);
	  $row_rs_state = mysql_fetch_assoc($rs_state);
  }
?>
    </select>
  </p>
  <p><label for="zipcode">Zipcode:</label>
    <span id="sprytextfield4">
    <input name="zipcode" type="text" id="zipcode" value="<?php echo $row_DetailRS1['zipcode']; ?>" size="20" maxlength="10" />
  <span class="textfieldRequiredMsg">Zipcode is required.</span></span></p>
  <p>
    <label for="phone">Phone #:</label>
    <span id="spryPhone">
    <input name="phone" type="text" value="<?= $row_DetailRS1['phone']; ?>" size="20" maxlength="15" />
    <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Phone 231-555-1212.</span></span></p>
  <p>
    <label>Fax #:</label><input name="fax" type="text" value="<?= $row_DetaileRS1['fax'];?>" size="20" maxlength="15" />
    <input name="id" type="hidden" id="id" value="<?= $_REQUEST['id']; ?>" />
  </p>
  <p>
    <input type="submit" name="btnupdateCust" id="btnupdateCust" value="Update" />
  </p>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("spryfname");
var sprytextfield3 = new Spry.Widget.ValidationTextField("spryAddress1");
</script>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprycity");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("spryPhone", "phone_number", {format:"phone_custom"});
</script>
</div>
</div>
</body>
</html><?php
mysql_free_result($DetailRS1);

mysql_free_result($rs_state);
?>