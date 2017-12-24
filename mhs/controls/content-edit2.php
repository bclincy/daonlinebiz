<?php require_once('../Connections/dbcon.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE docs SET title=%s, `description`=%s, keywords=%s, content=%s, doc_date=%s, catID=%s, active=%s WHERE ID=%s",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['keywords'], "text"),
                       GetSQLValueString($_POST['content'], "text"),
                       GetSQLValueString($_POST['doc_date'], "date"),
                       GetSQLValueString($_POST['catID'], "int"),
                       GetSQLValueString(isset($_POST['active']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['ID'], "int"));

  mysql_select_db($database_dbcon, $dbcon);
  $Result1 = mysql_query($updateSQL, $dbcon) or die(mysql_error());

  $updateGoTo = "content.php?update=title";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$pageID_rsDoc = "1";
if (isset($_REQUEST['pageID'])) {
  $pageID_rsDoc = $_REQUEST['pageID'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rsDoc = sprintf("SELECT * FROM docs JOIN category ON cat_id=catID WHERE ID=%s", GetSQLValueString($pageID_rsDoc, "int"));
$rsDoc = mysql_query($query_rsDoc, $dbcon) or die(mysql_error());
$row_rsDoc = mysql_fetch_assoc($rsDoc);
$totalRows_rsDoc = mysql_num_rows($rsDoc);
include_once('../inc/functions.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Edit Page ::<?php echo $row_rsDoc['title']; ?></title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="../scripts/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>
<body>
<? include_once('header.php'); ?>
<p> Nice</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
<p><label for="title">Title:</label><input type="text" name="title" value="<?php echo htmlentities($row_rsDoc['title'], ENT_COMPAT, 'UTF-8'); ?>" id="title" size="32"></p>
 <p><label for="category">category:</label><?  if(reposted('categoryID')){ echo listcats( 'Content' , $row_rsDoc['catID']); } else{ echo listcats('Content');} ?> *<? if(isset($error['categoryID'])){ echo "<span class=\"error\">{$error['categoryID']}</span>"; } ?>
      </p>
    <p><label for="">Description:</label><input type="text" id="description" name="description" value="<?php echo htmlentities($row_rsDoc['description'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></p>
    <p><label for="keywords">Keywords:</label><input type="text" id="keywords" name="keywords" value="<?php echo htmlentities($row_rsDoc['keywords'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></p>
    <p><label for="dcontent">Content:</label>
      <textarea name="content" cols="60%" rows="10" id="dcontent"><?php echo htmlentities($row_rsDoc['content'], ENT_COMPAT, 'UTF-8'); ?></textarea>
    </p>
    <p><label for="doc_date">Dated</label><input type="text" id="doc_date" name="doc_date" value="<?php echo htmlentities($row_rsDoc['doc_date'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></p>
    <p><label for="active">Active:</label><input type="checkbox" name="active" value=""  <?php if (!(strcmp(htmlentities($row_rsDoc['active'], ENT_COMPAT, 'UTF-8'),1))) {echo "checked=\"checked\"";} ?>></p>
    <p><label for="submit">&nbsp;</label><input type="submit" value="Save Changes"></p>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="ID" value="<?php echo $row_rsDoc['ID']; ?>">
</form>
<p>&nbsp;</p>
<? include_once('footer.php'); ?>
<?
mysql_free_result($rsDoc);
?>
