<?php require_once('../../Connections/dbcon.php'); ?>
<?php
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

$orderby_rsInvoice = "lname ASC";
if (isset($_REQUEST['order'])) {
  $orderby_rsInvoice = $_REQUEST['order'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rsInvoice = sprintf("SELECT *, sum(payment) as paytotal FROM invoices GROUP BY invoiceID ORDER BY %s", GetSQLValueString($orderby_rsInvoice, ''));
$rsInvoice = mysql_query($query_rsInvoice, $dbcon) or die(mysql_error());
$row_rsInvoice = mysql_fetch_assoc($rsInvoice);
$maxRows_rsInvoice = 50;
$pageNum_rsInvoice = 0;
if (isset($_GET['pageNum_rsInvoice'])) {
  $pageNum_rsInvoice = $_GET['pageNum_rsInvoice'];
}
$startRow_rsInvoice = $pageNum_rsInvoice * $maxRows_rsInvoice;

$totalRows_rsInvoice = "lname ASC";
if (isset($_REQUEST['orderby'])) {
  $totalRows_rsInvoice = $_REQUEST['orderby'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rsInvoice = sprintf("SELECT *, sum(payment) as paytotal FROM invoices GROUP BY invoiceID ORDER BY %s", GetSQLValueString($orderby_rsInvoice, "text"));
$query_limit_rsInvoice = sprintf("%s LIMIT %d, %d", $query_rsInvoice, $startRow_rsInvoice, $maxRows_rsInvoice);
$rsInvoice = mysql_query($query_limit_rsInvoice, $dbcon) or die(mysql_error());
$row_rsInvoice = mysql_fetch_assoc($rsInvoice);

if (isset($_GET['totalRows_rsInvoice'])) {
  $totalRows_rsInvoice = $_GET['totalRows_rsInvoice'];
} else {
  $all_rsInvoice = mysql_query($query_rsInvoice);
  $totalRows_rsInvoice = mysql_num_rows($all_rsInvoice);
}
$totalPages_rsInvoice = ceil($totalRows_rsInvoice/$maxRows_rsInvoice)-1;

if(isset($_POST['savechng'])){
  include_once('invoice_apply.php'); exit;
}
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
        <?php do { ?>
          <tr>
            <td><a href="invoice_show.php?recordID=<?php echo $row_invoices['invoiceID']; ?>"><?php echo $row_rsInvoice['invoiceID']; ?>&nbsp; </a></td>
            <td><a href="customers.php?id=<?= $row_invoices['custID']; ?>"><?php echo $row_rsInvoice['fname']; ?> <?php echo $row_rsInvoice['lname']; ?></a></td>
            <td><?= $row_invoices['company']; ?>
            <td><?php echo $row_rsInvoices['inTotal']; ?></td>
            <td><?= $sDate; ?></td>
            <td><? if(!isset($row_invoices['balance'])){ echo $row_invoices['inTotal']. "</td>
		  <td><input name=\"fname[{$row_invoices['invoiceID']}]\" type=\"hidden\" value=\"{$row_invoices['fname']}\" />
		  <input name=\"lname[{$row_invoices['invoiceID']}]\" type=\"hidden\" value=\"{$row_invoices['lname']}\" />
		  <input name=\"intotal[{$row_invoices['invoiceID']}]\" type=\"hidden\" value=\"{$row_invoices['inTotal']}\" />
		  <input name=\"payment[{$row_invoices['invoiceID']}]\" type=\"text\" size=\"5\" maxlength=\"10\" />"; 
		  
		  } else{ echo $row_invoices['balance']. "</td><td>Paid"; } ?></td>        
          </tr>
          <?php } while ($row_rsInvoice = mysql_fetch_assoc($rsInvoice)); ?>
<tr>
  <td colspan="6">&nbsp;</td>
       <td><input name="savechng" type="submit" value="Apply" /></td>
  </tr>
  </table>
    <br />
  </form> 
  </div><!-- End content -->
</div>
</body>
</html>
<?php
mysql_free_result($rsInvoice);

?>
