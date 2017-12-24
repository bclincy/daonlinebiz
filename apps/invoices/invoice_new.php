<?php require_once('../../Connections/dbcon.php'); ?>
<?php
session_start();
mysql_select_db($database_dbcon, $dbcon);
include_once('lib.php');
if(isset($_POST['MM_insert'])){
	$maybes=themaybes(array('company', 'address2', 'fax'));
	$sql="INSERT INTO customers (fname, lname, email, address1, city, stateID, zipcode, phone , company, address2, fax)
	 VALUES ('{$_POST['fname']}', '{$_POST['lname']}', '{$_POST['email']}', '{$_POST['address1']}', '{$_POST['city']}', {$_POST['stateID']}, 
	 '{$_POST['zipcode']}', '{$_POST['phone']}', '{$_POST['company']}','{$_POST['address2']}','{$_POST['fax']}' )";
	 if(mysql_query($sql)){
		 $_SESSION['customerID']=mysql_insert_id();
		 $_SESSION['customer']="{$_POST['fname']} {$_POST['lname']} <br />\n{$_POST['email']}";
		 $_SESSION['address']="{$_POST['address1']}";
		 if(isset($_POST['address2'])){ $_SESSION['address'].="<br />{$_POST['address2']}"; }
		 $_SESSION['address'].="<br />{$_POST['city']}, {$_POST['zipcode']}";
		 include_once('invoice_products.php');
		exit; 
 	 }else{ $msg="<h2>Sorry, problem</h2>"; }
}
if(isset($_POST['customerID'])){
	$_SESSION['customerID']=$_POST['customerID'];
	$_SESSION['customer']=$_POST['fname'][$_POST['customerID']]." ".$_POST['lname'][$_POST['customerID']]."<br />\n".$_POST['email'][$_POST['customerID']];
	$_SESSION['address']=$_POST['address1'][$_POST['customerID']]." <br />\n ".$_POST['address2'][$_POST['customerID']]."<br />\n".$_POST['city'][$_POST['customerID']].", ".
	$_POST['zipcode'][$_POST['customerID']];
	include_once('invoice_products.php'); exit;
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

$currentPage = $_SERVER["PHP_SELF"];
?>
<?php
$maxRows_rsCustomer = 20;
$pageNum_rsCustomer = 0;
if (isset($_GET['pageNum_rsCustomer'])) {
  $pageNum_rsCustomer = $_GET['pageNum_rsCustomer'];
}
$startRow_rsCustomer = $pageNum_rsCustomer * $maxRows_rsCustomer;

$Orderby_rsCustomer = "lname";
if (isset($_REQUEST['orderby'])) {
  $Orderby_rsCustomer = $_REQUEST['orderby'];
}
if(isset($_POST['by'])){
	$where="WHERE fname like '%{$_POST['search']}%' OR lname like '%{$_POST['search']}%' OR email like '%{$_POST['search']}%'";
}
$maxRows_rsCustomer = 10;
$pageNum_rsCustomer = 0;
if (isset($_GET['pageNum_rsCustomer'])) {
  $pageNum_rsCustomer = $_GET['pageNum_rsCustomer'];
}
$startRow_rsCustomer = $pageNum_rsCustomer * $maxRows_rsCustomer;

mysql_select_db($database_dbcon, $dbcon);
$query_rsCustomer = "SELECT customers.ID, customers.fname, customers.lname, customers.email, customers.phone, customers.address1, customers.city, customers.stateID, customers.zipcode, customers.address2 FROM customers $where ORDER BY $Orderby_rsCustomer";
$query_limit_rsCustomer = sprintf("%s LIMIT %d, %d", $query_rsCustomer, $startRow_rsCustomer, $maxRows_rsCustomer);
$rsCustomer = mysql_query($query_limit_rsCustomer, $dbcon) or die(mysql_error());
$row_rsCustomer = mysql_fetch_assoc($rsCustomer);

if (isset($_GET['totalRows_rsCustomer'])) {
  $totalRows_rsCustomer = $_GET['totalRows_rsCustomer'];
} else {
  $all_rsCustomer = mysql_query($query_rsCustomer);
  $totalRows_rsCustomer = mysql_num_rows($all_rsCustomer);
}
$totalPages_rsCustomer = ceil($totalRows_rsCustomer/$maxRows_rsCustomer)-1;

$queryString_rsCustomer = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsCustomer") == false && 
        stristr($param, "totalRows_rsCustomer") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsCustomer = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsCustomer = sprintf("&totalRows_rsCustomer=%d%s", $totalRows_rsCustomer, $queryString_rsCustomer);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Create Customer Invoice</title>
<link href="default.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="page">
  <div id="header">
    <div id="navi">
    <ul>
      <li><a href="invoices.php">Home</a></li>
      <li><a href="invoice_new.php">Create New</a></li>
      <li><a href="customers.php">Customers</a></li>
    </ul>
    </div>
    <h2>Create Invoice</h2>
  </div>
  <div id="content">
    <form action="" method="post" enctype="multipart/form-data" name="frmSelectCust" id="frmSelectCust">
      <fieldset>
        <legend>Customer Status</legend>
        <p>
        <label for="custStatus">New Customers:</label>
        <input type="radio" name="rdcustStatus" id="custStatus" value="newCust" <? if($_POST['rdcustStatus']=="newCust"){ echo "checked=\"checked\""; }?>  OnClick="document.frmSelectCust.submit();"/>
          
        </p>
        <p>
          <label for="custStatus2">Previous Customer:</label>
          <input name="rdcustStatus" type="radio" id="custStatus2" value="currentCust" <? if($_POST['rdcustStatus']=="currentCust"){ echo "checked=\"checked\""; }?> OnClick="document.frmSelectCust.submit();" />
        </p>
      </fieldset>
    </form>
  <? if($_POST['rdcustStatus']=='newCust'){ ?>
   <fieldset >
    <legend>New Customer</legend>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" name="frmNewCust" id="frmNewCust">
           <p><label for="fname">First Name:</label>
             <span id="verf_fname">
             <input name="fname" type="text" value="<?= reposted('fname'); ?>" size="20" maxlength="55" />
           <span class="textfieldRequiredMsg">Must have First Name.</span></span></p>
      <p>
        <label for="lname">Last Name:</label>
        <span id="verfy_lname">
        <input name="lname" type="text" value="<?= reposted('lname'); ?>" size="20" maxlength="122" />
        <span class="textfieldRequiredMsg">Last Name Required.</span></span></p>
        <p>
        <label for="company">Company:</label>
        <input name="company" type="text" value="<?= reposted('company'); ?>" size="20" maxlength="100" /></p>
        <p>
        <label for="password">Password:</label><input name="password" type="text" size="20" maxlength="100" /></p>
        <p>
        <label for="email">Email:</label>
        <span id="verify_email">
        <input name="email" type="text" value="<?= reposted('email'); ?>" size="20" maxlength="200" />
        <span class="textfieldRequiredMsg">Email address is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></p>
        <p><label for="address1">Address:</label><input name="address1" type="text" value="<?= reposted('address1'); ?>" size="20" maxlength="250" /></p>
        <p><label for="address2">Address2:</label><input name="address2" type="text" value="<?= reposted('address2'); ?>" size="20" maxlength="200" /></p>
        <p><label for="city">City:</label><input name="city" type="text" value="<?= reposted('city'); ?>" size="20" maxlength="250" /></p>
        <p><label for="stateID">State:</label><?= stateSelect($_POST['stateID']); ?>
        </p>
      	<p><label for="zipcode">Zipcode:</label><input name="zipcode" type="text" value="<?= reposted('zipcode'); ?>" size="20" maxlength="10" /></p>
      <p>
        <label for="phone">Phone:</label>
        <span id="var_phone">
        <input name="phone" type="text" value="<?= reposted('phone'); ?>" size="20" maxlength="14" />
        <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Phone format 231-555-1212.</span></span></p>
      <p>
        <label for="fax">Fax:</label><input name="fax" type="text" value="<?= reposted('fax'); ?>" size="20" maxlength="15" /></p>
        <p><input type="submit" value="Add New Customer" />
    <input type="hidden" name="MM_insert" value="frmNewCust" /></p>
    </form>
    </fieldset>
  </form>

<? 
  }//end the new customer

if($_POST['rdcustStatus']=='currentCust'){ ?>
<form action="<?= $_REQUEST['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="currentsort">
<p><input type="hidden" name="rdcustStatus" value="<?= $_POST['rdcustStatus']; ?>" />
  Search:
  <input name="search" type="text" value="<?= $_POST['search']; ?>" size="25" maxlength="50" />
<input type="submit" name="by" id="search" value="go" />
Sort:<select name="orderby" size="1" onChange="document.currentsort.submit();">
  <option value="lname" <? if($_POST['orderby']=='lname'){ echo "selected=\"selected\""; }?> >Last Name</option>
  <option value="fname" <? if($_POST['orderby']=='fname'){ echo "selected=\"selected\""; }?>>First Name</option>
  <option value="ID" <? if($_POST['orderby']=='ID'){ echo "selected=\"selected\""; }?>>Date</option>
  <option value="email">email</option>
</select>
<select name="order" size="1">
  <option value="ASC">Newest (a-z)</option>
  <option value="DESC">Oldest (z-a)</option>
</select></p>
</form><br clear="all" />
<form action="<?= $_SERVER['PHP_SELF']; ?>" name="selectCust" method="post" id="selectCust">
 <table width="90%" border="0" cellspacing="2" cellpadding="0">
   <tr>
     <th>&nbsp;</th>
     <th scope="col">First</th>
     <th scope="col">Last</th>
     <th scope="col">email</th>
     <th scope="col">Phone</th>
   </tr>
   <?php do { ?>
     <tr align="center" class="row">
       <td><input type="radio" name="customerID" id="customerID" value="<?= $row_rsCustomer['ID']; ?>" onclick="document.selectCust.submit();" /></td>
       <td><?php echo $row_rsCustomer['fname']; ?>
         <input name="fname[<?= $row_rsCustomer['ID']; ?>]" type="hidden" id="fname[]" value="<?php echo $row_rsCustomer['fname']; ?>" />
         <input name="lname[<?= $row_rsCustomer['ID']; ?>]" type="hidden" id="lname[]" value="<?php echo $row_rsCustomer['lname']; ?>" />
         <input name="address1[<?= $row_rsCustomer['ID']; ?>]" type="hidden" id="address1[<?= $row_rsCustomer['ID']; ?>]" value="<?= $row_rsCustomer['address1']; ?>" />
         <input name="address2[<?= $row_rsCustomer['ID']; ?>]" type="hidden" id="address2[<?= $row_rsCustomer['ID']; ?>]" value="<?= $row_rsCustomer['address2']; ?>" />
         <input name="stateID[<?= $row_rsCustomer['ID']; ?>]" type="hidden" id="stateID[<?= $row_rsCustomer['ID']; ?>]" value="<?= $row_rsCustomer['stateID']; ?>" />
         <input name="city[<?= $row_rsCustomer['ID']; ?>]" type="hidden" id="city[<?= $row_rsCustomer['ID']; ?>]" value="<?= $row_rsCustomer['city']; ?>" />
         <input name="zipcode[<?= $row_rsCustomer['ID']; ?>]" type="hidden" id="zipcode[<?= $row_rsCustomer['ID']; ?>]" value="<?= $row_rsCustomer['zipcode']; ?>" />
         <input name="email[<?= $row_rsCustomer['ID']; ?>]" type="hidden" id="email[<?= $row_rsCustomer['ID']; ?>]" value="<?= $row_rsCustomer['email']; ?>" />
         <input name="phone[<?= $row_rsCustomer['ID']; ?>]" type="hidden" id="phone[<?= $row_rsCustomer['phone']; ?>]" value="<?= $row_rsCustomer['phone']; ?>" /></td>
       <td><?php echo $row_rsCustomer['lname']; ?></td>
       <td><?php echo $row_rsCustomer['email']; ?></td>
       <td><?php echo $row_rsCustomer['phone']; ?></td>
       </tr>
       <?php } while ($row_rsCustomer = mysql_fetch_assoc($rsCustomer)); ?>
 </table>
 <table border="0">
   <tr>
     <td><?php if ($pageNum_rsCustomer > 0) { // Show if not first page ?>
         <a href="<?php printf("%s?pageNum_rsCustomer=%d%s", $currentPage, 0, $queryString_rsCustomer); ?>">First</a>
         <?php } // Show if not first page ?></td>
     <td><?php if ($pageNum_rsCustomer > 0) { // Show if not first page ?>
         <a href="<?php printf("%s?pageNum_rsCustomer=%d%s", $currentPage, max(0, $pageNum_rsCustomer - 1), $queryString_rsCustomer); ?>">Previous</a>
         <?php } // Show if not first page ?></td>
     <td><?php if ($pageNum_rsCustomer < $totalPages_rsCustomer) { // Show if not last page ?>
         <a href="<?php printf("%s?pageNum_rsCustomer=%d%s", $currentPage, min($totalPages_rsCustomer, $pageNum_rsCustomer + 1), $queryString_rsCustomer); ?>">Next</a>
         <?php } // Show if not last page ?></td>
     <td><?php if ($pageNum_rsCustomer < $totalPages_rsCustomer) { // Show if not last page ?>
         <a href="<?php printf("%s?pageNum_rsCustomer=%d%s", $currentPage, $totalPages_rsCustomer, $queryString_rsCustomer); ?>">Last</a>
         <?php } // Show if not last page ?></td>
   </tr>
 </table>
<? 
  } // end current Customers
?> </form>
   <p>&nbsp;</p>
  </div><!-- End Content -->
  
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("verf_fname");
var sprytextfield2 = new Spry.Widget.ValidationTextField("verfy_lname");
var sprytextfield3 = new Spry.Widget.ValidationTextField("verify_email", "email");
var sprytextfield4 = new Spry.Widget.ValidationTextField("var_phone", "phone_number", {format:"phone_custom", pattern:"000-000-0000", hint:"231-555-1212", useCharacterMasking:true});
</script>
</body>
</html>
<?php
mysql_free_result($rsCustomer);
?>
