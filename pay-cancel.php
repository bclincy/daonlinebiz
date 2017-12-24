<?php require_once('Connections/dbcon.php'); ?>
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

$inid_rs_invoice = "42";
if (isset($_REQUEST['id'])) {
  $inid_rs_invoice = $_REQUEST['id'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rs_invoice = sprintf("SELECT * FROM invoices  WHERE ID=%s", GetSQLValueString($inid_rs_invoice, "int"));
$rs_invoice = mysql_query($query_rs_invoice, $dbcon) or die(mysql_error());
$row_rs_invoice = mysql_fetch_assoc($rs_invoice);
$totalRows_rs_invoice = mysql_num_rows($rs_invoice);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PayPal Cancelled: {$name; }</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
<? include_once('header.php'); ?>
<? foreach($_REQUEST as $key=>$value){
	echo "$key -> $value<br />";
}
?>
<? include_once('footer.php'); ?>
<?php
mysql_free_result($rs_invoice);
?>
</body>
</html>