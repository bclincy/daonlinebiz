<?php require_once('../../Connections/dbcon.php'); ?>
<?php
 session_start();
if(isset($_REQUEST['id']) && !isset($_POST['btnupdateCust'])){ include_once("customer_details.php"); exit; }
if(isset($_POST['cid']) ){ 
include_once('../../inc/functions.php');
		 $_SESSION['customerID']=$_POST['cid'];
		 $_SESSION['customer']=$_POST['fname'][$_POST['cid']]." ".$_POST['lname'][$_POST['cid']]." <br />\n".$_POST['email'][$_POST['cid']];
		 $_SESSION['address']=$_POST['address1'][$_POST['cid']]." <br />\n ".$_POST['address2'][$_POST['cid']]."<br />\n".$_POST['city'][$_POST['cid']].",".
		 $_POST['zipcode'][$_POST['cid']];
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

$maxRows_rs_customers = 25;
$pageNum_rs_customers = 0;
if (isset($_GET['pageNum_rs_customers'])) {
  $pageNum_rs_customers = $_GET['pageNum_rs_customers'];
}
$startRow_rs_customers = $pageNum_rs_customers * $maxRows_rs_customers;

mysql_select_db($database_dbcon, $dbcon);
$query_rs_customers = "SELECT customers.ID, customers.fname, customers.lname, customers.company, customers.email, customers.phone, invoice_meta.custID, count(invoice_meta.custID) as In_nums, customers.address1, customers.address2, customers.city, customers.stateID, customers.zipcode, customers.phone  FROM customers LEFT JOIN invoice_meta ON custID = customers.ID GROUP BY customers.ID";
$query_limit_rs_customers = sprintf("%s LIMIT %d, %d", $query_rs_customers, $startRow_rs_customers, $maxRows_rs_customers);
$rs_customers = mysql_query($query_limit_rs_customers, $dbcon) or die(mysql_error());
$row_rs_customers = mysql_fetch_assoc($rs_customers);

if (isset($_GET['totalRows_rs_customers'])) {
  $totalRows_rs_customers = $_GET['totalRows_rs_customers'];
} else {
  $all_rs_customers = mysql_query($query_rs_customers);
  $totalRows_rs_customers = mysql_num_rows($all_rs_customers);
}
$totalPages_rs_customers = ceil($totalRows_rs_customers/$maxRows_rs_customers );
$pageNum_rs_customers = 0;
if (isset($_GET['pageNum_rs_customers'])) {
  $pageNum_rs_customers = $_GET['pageNum_rs_customers'];
}
$startRow_rs_customers = $pageNum_rs_customers * $maxRows_rs_customers;

mysql_select_db($database_dbcon, $dbcon);
$query_rs_customers = "SELECT *, count(ID) as In_nums, sum(intotal) as total FROM users LEFT JOIN invoice_meta ON custID = userID GROUP BY custID";
$query_limit_rs_customers = sprintf("%s LIMIT %d, %d", $query_rs_customers, $startRow_rs_customers, $maxRows_rs_customers);
$rs_customers = mysql_query($query_limit_rs_customers, $dbcon) or die(mysql_error());
$row_rs_customers = mysql_fetch_assoc($rs_customers);

if (isset($_GET['totalRows_rs_customers'])) {
  $totalRows_rs_customers = $_GET['totalRows_rs_customers'];
} else {
  $all_rs_customers = mysql_query($query_rs_customers);
  $totalRows_rs_customers = mysql_num_rows($all_rs_customers);
}
$totalPages_rs_customers = ceil($totalRows_rs_customers/$maxRows_rs_customers)-1;

$queryString_rs_customers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_customers") == false && 
        stristr($param, "totalRows_rs_customers") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_customers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_customers = sprintf("&totalRows_rs_customers=%d%s", $totalRows_rs_customers, $queryString_rs_customers);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Customer Info</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="fmrEmailuser" name="fmrEmailuser" method="post" action="">
  <div id="page">
    <div id="header">
    	<div id="navi">
    	<ul><li><a href="invoices.php">Home</a></li><li><a href="invoice_new.php">Create New</a></li><li><a href="customers.php">Customers</a></li></ul>
    	</div>
    <h2>Customer List</h2>
    </div><!-- end Header -->
    <div id="content">
      <table border="1" align="center">
        <tr>
          <th>Email</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>View</th>
        </tr>
        <?php do { ?>
          <tr>
            <td align="center"><input type="checkbox" name="email[<?= $row_rs_customers['ID']; ?>" id="email[<?= $row_rs_customers['ID']; ?>]" value="1" /></td>
            <td><?php echo $row_rs_customers['fname']; ?> <?php echo $row_rs_customers['lname']; ?></td>
            <td><?php echo $row_rs_customers['email']; ?></td>
            <td><?php echo $row_rs_customers['phone']; ?></td>
            <td><? if(!is_null($row_rs_customers['custID'])){ ?><a href="customer_invoices.php?cid=<?php echo $row_rs_customers['ID']; ?>"><?php echo $row_rs_customers['In_nums']; ?> Invoices</a><? } else{ ?>
              <input name="fname[<?= $row_rs_customers['ID'];?>]" type="hidden" value="<?php echo $row_rs_customers['fname']; ?>" />
              <input name="lname[<?= $row_rs_customers['ID'];?>]" type="hidden" id="lname[<?= $row_rs_customers['ID'];?>]" value="<?php echo $row_rs_customers['lname']; ?>" />
              <input name="email[<?= $row_rs_customers['ID'];?>]" type="hidden" id="email[<?= $row_rs_customers['ID'];?>]" value="<?php echo $row_rs_customers['email']; ?>" />
             <input name="address1[<?= $row_rs_customers['ID']; ?>]" type="hidden" id="address1[<?= $row_rs_customers['ID']; ?>]" value="<?php echo $row_rs_customers['address1']; ?>" />
         <input name="address2[<?= $row_rs_customers['ID']; ?>]" type="hidden" id="address2[<?= $row_rs_customers['ID']; ?>]" value="<?php echo $row_rs_customers['address2']; ?>" />
         <input name="stateID[<?= $row_rs_customers['ID']; ?>]" type="hidden" id="stateID[<?= $row_rs_customers['ID']; ?>]" value="<?php echo $row_rs_customers['stateID']; ?>" />
         <input name="city[<?= $row_rs_customers['ID']; ?>]" type="hidden" id="city[<?= $row_rs_customers['ID']; ?>]" value="<?php echo $row_rs_customers['city']; ?>" />
         <input name="zipcode[<?= $row_rs_customers['ID']; ?>]" type="hidden" id="zipcode[<?= $row_rs_customers['ID']; ?>]" value="<?= $row_rs_customers['zipcode']; ?>" />
         <input name="phone[<?= $row_rs_customers['ID']; ?>]" type="hidden" id="phone[<?= $row_rs_customers['phone']; ?>]" value="<?= $row_rs_customers['phone']; ?>" />
              <input name="cid" type="radio" value="<?php echo $row_rs_customers['ID']; ?>" onclick="document.fmrEmailuser.submit();" /> 
            New<? }?></td>
          </tr>
          <?php } while ($row_rs_customers = mysql_fetch_assoc($rs_customers)); ?>
      </table>
      <br />
      <table border="0">
        <tr>
          <td><?php if ($pageNum_rs_customers > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rs_customers=%d%s", $currentPage, 0, $queryString_rs_customers); ?>">First</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rs_customers > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rs_customers=%d%s", $currentPage, max(0, $pageNum_rs_customers - 1), $queryString_rs_customers); ?>">Previous</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rs_customers < $totalPages_rs_customers) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rs_customers=%d%s", $currentPage, min($totalPages_rs_customers, $pageNum_rs_customers + 1), $queryString_rs_customers); ?>">Next</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_rs_customers < $totalPages_rs_customers) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rs_customers=%d%s", $currentPage, $totalPages_rs_customers, $queryString_rs_customers); ?>">Last</a>
              <?php } // Show if not last page ?></td>
        </tr>
      </table>
Records <?php echo ($startRow_rs_customers + 1) ?> to <?php echo min($startRow_rs_customers + $maxRows_rs_customers, $totalRows_rs_customers) ?> of <?php echo $totalRows_rs_customers ?>
    </div>
  </div>
</form>
</body>
</html>
<?php
mysql_free_result($rs_customers);
?>
