<?php require_once('../../Connections/dbcon.php'); ?>
<?php
mysql_select_db($database_dbcon, $dbcon);
include_once('lib.php');
if(isset($_REQUEST['resend'])){
	foreach($_POST['resend'] as $key=>$value){
		sendInvoice($value);
	}
	$msg="Invoice/s Resent";
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

$maxRows_rsCustInv = 30;
$pageNum_rsCustInv = 0;
if (isset($_GET['pageNum_rsCustInv'])) {
  $pageNum_rsCustInv = $_GET['pageNum_rsCustInv'];
}
$startRow_rsCustInv = $pageNum_rsCustInv * $maxRows_rsCustInv;

$cID_rsCustInv = "2";
if (isset($_REQUEST['cid'])) {
  $cID_rsCustInv = $_REQUEST['cid'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rsCustInv = sprintf("SELECT * FROM customers JOIN states ON customers.stateID=states.stateID JOIN invoice_meta inv ON custID=customers.ID LEFT JOIN invoice_payments ON inv.ID=invoice_id WHERE customers.ID=%s", GetSQLValueString($cID_rsCustInv, "int"));
$query_limit_rsCustInv = sprintf("%s LIMIT %d, %d", $query_rsCustInv, $startRow_rsCustInv, $maxRows_rsCustInv);
$rsCustInv = mysql_query($query_limit_rsCustInv, $dbcon) or die(mysql_error());
$row_rsCustInv = mysql_fetch_assoc($rsCustInv);

if (isset($_GET['totalRows_rsCustInv'])) {
  $totalRows_rsCustInv = $_GET['totalRows_rsCustInv'];
} else {
  $all_rsCustInv = mysql_query($query_rsCustInv);
  $totalRows_rsCustInv = mysql_num_rows($all_rsCustInv);
}
$totalPages_rsCustInv = ceil($totalRows_rsCustInv/$maxRows_rsCustInv)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?= "{$row_rsCustInv['fname']} {$row_rsCustInv['lname']} Invoices"; ?></title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="page">
  <div id="header">
    <div id="navi"><ul><li><a href="invoices.php">Home</a></li><li><a href="invoice_new.php">Create New</a></li><li><a href="customers.php">Customers</a></li></ul></div>
    <h2>Customer: <?= "{$row_rsCustInv['fname']} {$row_rsCustInv['lname']}"; ?></h2>
  </div>
  <div id="content">
  <? if(isset($msg)){ echo "<h2>$msg</h2>"; } ?>
    <p>Invoices</p>
    <p><a href="customer_details.php?id=<?= $_REQUEST['cID']; ?>"><?php echo $row_rsCustInv['fname']; ?> <?php echo $row_rsCustInv['lname']; ?></a><br />
    <?php echo $row_rsCustInv['company']; ?><br />
    <?php echo $row_rsCustInv['address1']; ?> <?php echo $row_rsCustInv['address2']; ?><br />
    <?php echo $row_rsCustInv['city']; ?>, <?php echo $row_rsCustInv['abrivation']; ?> <?php echo $row_rsCustInv['zipcode']; ?></p>
    <form id="frmCustInv" name="frmCustInv" method="post" action="customer_invoices.php"> 
    <table border="0" align="center" cellpadding="2">
      <tr>
        <th>Invoice #</th>
        <th>Invoice Total</th>
        <th>Sent</th>
        <th>Payment</th>
        <th>Payment Type</th>
        <th>Payment Date</th>
        <th>Resend</th>
      </tr>
      <?php do { ?>
        <tr align="center">
          <td><a href="invoice_show.php?recordID=<?= $row_rsCustInv['ID']; ?>"><?php echo $row_rsCustInv['ID']; ?></a></td>
          <td><?php echo $row_rsCustInv['inTotal']; ?></td>
          <td><?php list($year,$month, $day)=split('-', $row_rsCustInv['dated']); echo "$month/$day/$year"; ?></td>
          <td><? if(is_null($row_rsCustInv['payment'])){
	   echo "<input type=\"text\" name=\"payment[{$row_rsCustInv['ID']}] value=\"\" id=\"payment\" size=\"4\"/>";
}
else{ echo $row_rsCustInv['payment']; }
?>
		  </td>
          <td><?php echo $row_rsCustInv['type']; ?></td>
          <td><? if(!is_null($row_rsCustInv['lastmodifed'])){
			  list($year,$month,$day)=split('-', $row_rsCustInv['lastmodifed']); }?></td>
          <td><input type="checkbox" name="resend[]" id="resend[]" value="<?= $row_rsCustInv['ID']; ?>" /></td>
        </tr>
        <?php } while ($row_rsCustInv = mysql_fetch_assoc($rsCustInv)); ?>
        <tr>
         <td colspan="5"><input name="cid" type="hidden" id="cID" value="<?= $_REQUEST['cid']; ?>" /></td>
         <td colspan="2"><input name="send" type="button" onClick="document.frmCustInv.submit();" value="Send" /></td>
        </tr>
    </table>
  </form>
  </div>
</div><!-- Page -->
  
</body>
</html>
<?php
mysql_free_result($rsCustInv);
?>
