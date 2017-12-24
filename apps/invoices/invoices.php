<?php require_once('../../Connections/dbcon.php'); ?>
<?php
if(isset($_POST['savechng'])){
  include_once('invoice_apply.php'); exit;
}
?>
<?
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

$maxRows_invoices = 25;
$pageNum_invoices = 0;
if (isset($_GET['pageNum_invoices'])) {
  $pageNum_invoices = $_GET['pageNum_invoices'];
}
$startRow_invoices = $pageNum_invoices * $maxRows_invoices;
if(isset($_GET['order'])){ $orderby=$_GET['order']; }
else{ $orderby="invoiceID"; }
if(isset($_GET['sort'])){ $sort=$_GET['sort']; }
else{ $sort='DESC'; }
mysql_select_db($database_dbcon, $dbcon);
$totalPages_invoices = ceil($totalRows_invoices/$maxRows_invoices)-1;$maxRows_invoices = 25;
$pageNum_invoices = 0;
if (isset($_GET['pageNum_invoices'])) {
  $pageNum_invoices = $_GET['pageNum_invoices'];
}
$startRow_invoices = $pageNum_invoices * $maxRows_invoices;

mysql_select_db($database_dbcon, $dbcon);
$query_invoices = "SELECT n.ID as invoiceID, fname, lname, inTotal, custID, dated,(inTotal - payment) as balance, company FROM invoice_meta AS n 	JOIN customers AS c ON custID = c.ID 	JOIN states AS s ON c.stateID = s.stateID 	LEFT JOIN invoice_payments p ON n.ID = invoice_id ORDER BY $orderby $sort";
$query_limit_invoices = sprintf("%s LIMIT %d, %d", $query_invoices, $startRow_invoices, $maxRows_invoices);
$invoices = mysql_query($query_limit_invoices, $dbcon) or die(mysql_error());
$row_invoices = mysql_fetch_assoc($invoices);

if (isset($_GET['totalRows_invoices'])) {
  $totalRows_invoices = $_GET['totalRows_invoices'];
} else {
  $all_invoices = mysql_query($query_invoices);
  $totalRows_invoices = mysql_num_rows($all_invoices);
}
$totalPages_invoices = ceil($totalRows_invoices/$maxRows_invoices)-1;

$queryString_invoices = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_invoices") == false && 
        stristr($param, "totalRows_invoices") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_invoices = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_invoices = sprintf("&totalRows_invoices=%d%s", $totalRows_invoices, $queryString_invoices);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Company Invoices</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="page">
  <div id="header">
    <div id="navi"><ul><li><a href="invoices.php">Home</a></li><li><a href="invoice_new.php">Create New</a></li><li><a href="customers.php">Customers</a></li></ul></div>
    <h2>Customer Invoices</h2>
  </div>
  <div id="content"> 
  <? if(isset($msg)){ echo "<h2>$msg</h2>\n"; } ?>
  <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="frmCustomer" id="frmCustomer">
    <table border="1" align="center">
      <tr>
        <th><a href="?order=invoiceID<? if($_GET['order']=='invoiceID'){ echo "&sort=desc";}?>">Invoice #</a></th>
        <th><a href="?order=lname<? if($_GET['order']=='lname'){ echo "&sort=desc"; }?>">Name </a></th>
        <th><a href="?order=company<? if($_GET['order']=='company'){ echo "&sort=desc"; }?>">Company</a></th>
        <th><a href="?order=inTotal<? if($_GET['order']=='inTotal'){ echo "&sort=desc"; }?>">Total</a></th>
        <th><a href="?order=dated<? if($_GET['order']=='dated'){ echo "&sort=desc"; }?>">Date</a></th>
        <th><a href="?order=balance<? if($_GET['order']=='balance'){ echo "&sort=desc"; }?>">balance</a></th>
        <th>Payment</th>
      </tr>
      <?php do {
		  $oDate = strtotime($row_invoices['dated']);
		 $sDate = date("m/d/y", $oDate);
		   ?>
        <tr>
          <td><a href="invoice_show.php?recordID=<?php echo $row_invoices['invoiceID']; ?>"> <?php echo $row_invoices['invoiceID']; ?>&nbsp; </a></td>
          <td><a href="customers.php?id=<?= $row_invoices['custID']; ?>"><?php echo $row_invoices['fname']; ?> <?php echo $row_invoices['lname']; ?></a></td>
          <td><?= $row_invoices['company']; ?>
          <td><?php echo $row_invoices['inTotal']; ?></td>
          <td><?= $sDate; ?></td>
          <td><? if(!isset($row_invoices['balance'])){ echo $row_invoices['inTotal']. "</td>
		  <td><input name=\"fname[{$row_invoices['invoiceID']}]\" type=\"hidden\" value=\"{$row_invoices['fname']}\" />
		  <input name=\"lname[{$row_invoices['invoiceID']}]\" type=\"hidden\" value=\"{$row_invoices['lname']}\" />
		  <input name=\"intotal[{$row_invoices['invoiceID']}]\" type=\"hidden\" value=\"{$row_invoices['inTotal']}\" />
		  <input name=\"payment[{$row_invoices['invoiceID']}]\" type=\"text\" size=\"5\" maxlength=\"10\" />"; 
		  
		  } else{ echo $row_invoices['balance']. "</td><td>Paid"; } ?></td>        
          </tr>
      
        <?php } while ($row_invoices = mysql_fetch_assoc($invoices)); ?>
  <tr>
       <td colspan="6">&nbsp;</td>
       <td><input name="savechng" type="submit" value="Apply" /></td>
      </tr>
  </table>
    <br />
    <table border="0">
      <tr>
        <td><?php if ($pageNum_invoices > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_invoices=%d%s", $currentPage, 0, $queryString_invoices); ?>">First</a>
        <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_invoices > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_invoices=%d%s", $currentPage, max(0, $pageNum_invoices - 1), $queryString_invoices); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_invoices < $totalPages_invoices) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_invoices=%d%s", $currentPage, min($totalPages_invoices, $pageNum_invoices + 1), $queryString_invoices); ?>">Next</a>
        <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_invoices < $totalPages_invoices) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_invoices=%d%s", $currentPage, $totalPages_invoices, $queryString_invoices); ?>">Last</a>
        <?php } // Show if not last page ?></td>
      </tr>
      
    </table>
Records <?php echo ($startRow_invoices + 1) ?> to <?php echo min($startRow_invoices + $maxRows_invoices, $totalRows_invoices) ?> of <?php echo $totalRows_invoices ?>
  </form> 
  </div><!-- End content -->
</div>
</body>
</html>
<?php
mysql_free_result($invoices);
?>
