<?php require_once('../Connections/dbcon.php'); ?>
<?php
if(!headers_sent()){
  session_start();
  header('Cache-Control: no-cache');
  header('Pragma: no-cache');
  session_cache_expire(30); 
}
if(!isset($_SESSION['admin'])){ $msg ="MUST BE LOGGED IN"; header('location: ./?notin=true?msg=Must%20be%20logged%20In'); exit; }
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

$field_rsDocs = "title";
if (isset($_REQUEST['sort'])) {
  $field_rsDocs = $_REQUEST['sort'];
}
$direction_rsDocs = "ASC";
if (isset($_REQUEST['sortoption'])) {
  $direction_rsDocs = $_REQUEST['sortoption'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rsDocs = sprintf("SELECT * FROM docs LEFT JOIN category ON cat_id=catID ORDER BY %s %s", mysql_real_escape_string($field_rsDocs),mysql_real_escape_string($direction_rsDocs));
$rsDocs = mysql_query($query_rsDocs, $dbcon) or die(mysql_error());
$row_rsDocs = mysql_fetch_assoc($rsDocs);
$maxRows_rsDocs = 50;
$pageNum_rsDocs = 0;
if (isset($_GET['pageNum_rsDocs'])) {
  $pageNum_rsDocs = $_GET['pageNum_rsDocs'];
}
$startRow_rsDocs = $pageNum_rsDocs * $maxRows_rsDocs;

$direction_rsDocs = "ASC";
if (isset($_REQUEST['sortoption'])) {
  $direction_rsDocs = $_REQUEST['sortoption'];
}
$field_rsDocs = "title";
if (isset($_REQUEST['sort'])) {
  $field_rsDocs = $_REQUEST['sort'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rsDocs = sprintf("SELECT *, date_format(doc_date, '%%m/%%d/%%Y') as doc_date FROM docs LEFT JOIN category ON cat_id=catID  ORDER BY %s %s", mysql_real_escape_string($field_rsDocs),mysql_real_escape_string($direction_rsDocs));
$query_limit_rsDocs = sprintf("%s LIMIT %d, %d", $query_rsDocs, $startRow_rsDocs, $maxRows_rsDocs);
$rsDocs = mysql_query($query_limit_rsDocs, $dbcon) or die(mysql_error());
$row_rsDocs = mysql_fetch_assoc($rsDocs);

if (isset($_GET['totalRows_rsDocs'])) {
  $totalRows_rsDocs = $_GET['totalRows_rsDocs'];
} else {
  $all_rsDocs = mysql_query($query_rsDocs);
  $totalRows_rsDocs = mysql_num_rows($all_rsDocs);
}
$totalPages_rsDocs = ceil($totalRows_rsDocs/$maxRows_rsDocs)-1;
?>
<? 
//login in test block; 
$activity='Content Management';
include_once('../inc/functions.php');
?>
<!doctype html> 
<html lang="en"> 
<head>
<meta charset="UTF-8">
<title>Content Menu</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function DoNav(theUrl)
  {
  document.location.href = theUrl;
  }
 </script>
 <script type="text/javascript">
function deletechecked(message){
	var r=confirm(message)
	if (r==true){return true;}
	else{
		alert("No Messages were Removed");
		return false;
  	}
}

</script>
</head>

<body>
<? include_once('header.php'); ?>
<div class="breadcrum">
<ul><li><a href="./">Home</a></li><li>Content</li></ul>
</div>
<? if(isset($msg)){ echo "<h2>$msg</h2>"; }  ?>
<section>
<form action="content-new.php" method="post" enctype="multipart/form-data" name="frmDoc" id="frmDoc">
  <p>
    <label for="title">Create New Document:</label>
    <input type="text" name="title" id="title">
    <input type="submit" name="btnNew" id="btnNew" value="Create">
  </p>
</form>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="application/x-www-form-urlencoded" name="remove">
<p>Home</p>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <th scope="col">#</th>
    <th scope="col">Title</th>
    <th scope="col">Category</th>
    <th scope="col">Last Changed</th>
    <th scope="col">Live</th>
    <th scope="col">Remove</th>
    <th scope="col">View</th>
  </tr>
  <?php 
  $i=1; do {
	  if(is_null($row_rsDocs['title'])){
		  echo "<tr class=\"row\"><td colspan=\"7\"><h1>Sorry No Comment</h1></td></tr>"; break;
	  }
	   ?>
    <tr class="row">
      <td onClick="DoNav('content-edit.php?pageID=<?php echo $row_rsDocs['ID']; ?>');"><?= $i; ?></td>
      <td onClick="DoNav('content-edit.php?pageID=<?php echo $row_rsDocs['ID']; ?>');"><?php echo $row_rsDocs['title']; ?></td>
      <td onClick="DoNav('content-edit.php?pageID=<?php echo $row_rsDocs['ID']; ?>');"><?php echo $row_rsDocs['cat_name']; ?></td>
      <td onClick="DoNav('content-edit.php?pageID=<?php echo $row_rsDocs['ID']; ?>');"><?php echo $row_rsDocs['doc_date']; ?></td>
      <td><input <?php if (!(strcmp($row_rsDocs['active'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="activate" id="activate"></td>
      <td><input type="checkbox" name="remove2" id="remove"></td>
      <td><a href="../show.php?id=<?=$row_rsDocs['ID']; ?>" target="_new">view</a></td>
    </tr>
    <?php  $i++; } while ($row_rsDocs = mysql_fetch_assoc($rsDocs)); ?>
    <tr><td colspan="5">&nbsp;</td><td colspan="2"><input name="btnRemove" type="submit" value="Remove" onClick="return deletechecked('Are You Sure?');"></td>
    </tr>
</table>
Records <?php echo ($startRow_rsDocs + 1) ?> to <?php echo min($startRow_rsDocs + $maxRows_rsDocs, $totalRows_rsDocs) ?> of <?php echo $totalRows_rsDocs ?>
</form>
</section>
<? include_once('footer.php'); ?>
</body>
</html><?php
mysql_free_result($rsDocs);
?>
<?
$sql="SELECT * FROM docs WHERE "; ?>