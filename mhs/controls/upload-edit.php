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
$query_DetailRS1 = sprintf("SELECT * FROM uploads LEFT JOIN docs ON doc_id=ID LEFT JOIN category ON cat_id=catID WHERE uploadID = %s", GetSQLValueString($colname_DetailRS1, "int"));
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
include_once('../inc/functions.php');
if(isset($_POST['btnSaveChanges'])){
	if(isset($_FILES['upload'])){
		if(uploaddoc('upload')){ $display= "filename='{$_FILES['upload']['name']}' ";
			$filename=realpath('../uploads/'). '/'.$_REQUEST['filename'];
			unlink($filename);
		}
	}
	$sql = sprintf("UPDATE uploads LEFT JOIN docs ON doc_id=docs.ID 
			SET displayname=%s, content=%s, title=%s,  lastmodified=now(), catID=%d WHERE uploadID=%d", GetSQLValueString($_POST['display'], 'text'),
			GetSQLValueString($_POST['description'], 'text'), GetSQLValueString($_POST['display'], 'text'), GetSQLValueString($_POST['categoryID'], 'int'), GetSQLValueString($_POST['uploadID'], 'int'));
	$results=queryDB($sql);
	if($results>0){ header("location: upload.php?edit={$_POST['display']} Successful edited"); }
	else{ $msg="Error Saving changes"; } 
}
?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Edit Upload</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>

<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="frmUpload" id="frmUpload">
  <p><label for="filename">File Name:</label><?php echo $row_DetailRS1['filename']; ?>
    <input type="hidden" name="filename" id="filename" value="<?php echo $row_DetailRS1['filename']; ?>">
    <input name="uploadID" type="hidden" id="uploadID" value="<?= $_REQUEST['recordID']; ?>">
  </p>
  <p><label for="Displayname">Display Named:</label><input type="text" name="display" id="display" value=" <?php echo $row_DetailRS1['displayname']; ?>" /></p>
  <p><label for="category">Category:</label><?  echo listcats( 'Content' , $row_DetailRS1['catID']); ?></p>
  <p><label for="description">Description:</label><? if(empty($row_DetailRS1['content'])){ echo "<input type=\"hidden\" name=\"nodescription\" value=\"1\" />"; } ?>
        <textarea name="description" cols="50" rows="5" id="description"><?= $row_DetailRS1['content']; ?></textarea></p>
  <p>
    <label for="uploads">Replacement File:</label>
    <input type="file" name="uploads" id="uploads">
    <input name="update" type="hidden" id="update" value="1">
  </p>
  <p>
    <label for="btnsave">&nbsp;</label><input type="submit" name="btnSaveChanges" id="btnSaveChanges" value="Save Changes">
  </p>
</form>
<p>&nbsp;</p>
<? include_once('footer.php'); ?>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>