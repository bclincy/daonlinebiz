<?php require_once('../Connections/dbcon.php'); ?><?php
include_once('../inc/functions.php'); 
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

$maxRows_DetailRS1 = 20;
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
$query_DetailRS1 = sprintf("SELECT links.ID as link_id, name, description, url, frontpage.id as frontID, description FROM links LEFT JOIN frontpage ON linkID=links.ID WHERE links.ID = %s", GetSQLValueString($colname_DetailRS1, "-1"));
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
?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Link Details :: <?= $row_DetailsRS1['name']; ?></title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>
<div class="breadcrum">
<ul><li><a href="./">Home</a></li><li><a href="quicklink.php">Links</a></li><li>Link Details</li></ul></div>
<form action="<?=$_SERVER['PHP_SELF']; ?>" name="frmEdit">
<p>
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?php echo $row_DetailRS1['name']; ?>" />
</p>
 <p>
   <label for="url">Link/URL:</label>
   <input type="text" name="url" id="url" value="<?php echo $row_DetailRS1['url']; ?>">
   </p>
  <p>
    <label for="description">Description:</label>
    <textarea name="description" cols="25" rows="3" id="description"><?php echo $row_DetailRS1['description']; ?></textarea>
  </p>
  <p><label for="frontpage">Display on Frontpage:</label>
  <input type="checkbox" name="frontpage" value="1" <? if(!empty($row_DetailRS1['frontID'])){ echo "checked=\"checked\""; }?> />
  </p>
  <p>
    <label>&nbsp;</label><input type="submit" name="btnSave" id="btnSave" value="Save Changes">
  </p>
 </form>
<p>&nbsp;</p>
<? include_once('footer.php'); ?>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>