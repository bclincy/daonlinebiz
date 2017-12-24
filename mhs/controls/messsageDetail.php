<?php require_once('../Connections/dbcon.php'); ?><?php
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

$maxRows_DetailRS1 = 30;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_DetailRS1 = sprintf("Select * From messages LEFT JOIN sports ON messages.sportID=sports.sportID WHERE messageID = %s", GetSQLValueString($colname_DetailRS1, "int"));
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
?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Message Details :: <?php echo $row_DetailRS1['subject']; ?></title>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>
<? $activity="Message Details {$row_DetailRS1['subject']}"; ?>

<body>
<? include_once('header.php'); ?>
<div class="breadcrum"><ul>
<li><a href="./">Home</a></li>
<li><a href="messageslist.php">Message Center</a></li>
<li><a href="messages.php">Compose Message</a></li>
<li>Message Details</li>
</ul>
</div>
		
<table border="0" align="center">
  
  <tr>
    <td>Subject</td>
    <td><?php echo $row_DetailRS1['subject']; ?> </td>
  </tr>
  <tr>
    <td>To:</td>
    <td><?php echo $row_DetailRS1['sport']; ?> <?php echo $row_DetailRS1['toother']; ?></td>
  </tr>
  <tr>
    <td>Message:</td>
    <td><?php echo $row_DetailRS1['message']; ?> </td>
  </tr>
  <tr>
    <td>From:</td>
    <td><?php echo $row_DetailRS1['msgfrom']; ?> </td>
  </tr>
  <tr>
    <td>Dated:</td>
    <td><?php echo $row_DetailRS1['edited']; ?> </td>
  </tr>
  <tr>
    <td>attachments</td>
    <td><?php echo $row_DetailRS1['attachments']; ?> </td>
  </tr>
  
  
</table>
<? include_once('footer.php'); ?>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>