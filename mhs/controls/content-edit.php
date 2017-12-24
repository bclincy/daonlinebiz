<?php require_once('../Connections/dbcon.php'); ?>
<?php 
if(!headers_sent()){
  session_start();
  header('Cache-Control: no-cache');
  header('Pragma: no-cache');
  session_cache_expire(30); 
}
if(!isset($_SESSION['admin'])){ $msg ="MUST BE LOGGED IN"; header('location: ./?notin=true?msg=Must%20be%20logged%20In'); exit; }
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$dhom=mysqldateconv($_POST['doc_date']);
	$_POST['doc_date']=$dhom[3];
  $updateSQL = sprintf("UPDATE docs SET title=%s, `description`=%s, keywords=%s, content=%s, doc_date=%s, catID=%s, active=%s WHERE ID=%s",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['keywords'], "text"),
                       GetSQLValueString($_POST['content'], "text"),
                       GetSQLValueString($_POST['doc_date'], "date"),
                       GetSQLValueString($_POST['categoryID'], "int"),
                       GetSQLValueString(isset($_POST['active']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['ID'], "int"));

  mysql_select_db($database_dbcon, $dbcon);
  $Result1 = mysql_query($updateSQL, $dbcon) or die(mysql_error());

  $updateGoTo = "content.php?update={$_POST['title']}";
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
$query_rsDoc = sprintf("SELECT *, date_format(doc_date, '%%M/%%d/%%Y') as doc_date  FROM docs LEFT JOIN category ON cat_id=catID WHERE ID=%s", GetSQLValueString($pageID_rsDoc, "int"));
$rsDoc = mysql_query($query_rsDoc, $dbcon) or die(mysql_error());
$row_rsDoc = mysql_fetch_assoc($rsDoc);
$totalRows_rsDoc = mysql_num_rows($rsDoc);$pageID_rsDoc = "1";
if (isset($_REQUEST['pageID'])) {
  $pageID_rsDoc = $_REQUEST['pageID'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rsDoc = sprintf("SELECT *, date_format(doc_date, '%%m/%%d/%%Y') as doc_date FROM docs LEFT JOIN category ON cat_id=catID WHERE ID=%s", GetSQLValueString($pageID_rsDoc, "int"));
$rsDoc = mysql_query($query_rsDoc, $dbcon) or die(mysql_error());
$row_rsDoc = mysql_fetch_assoc($rsDoc);
$totalRows_rsDoc = mysql_num_rows($rsDoc);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Edit Page :: <?php echo $row_rsDoc['title']; ?></title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="../scripts/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>
<body>
<? include_once('header.php'); ?>
<div class="breadcrum"><ul><li><a href="./">Home</a></li><li><a href="content.php">Content Management</a></li><li>Editing :: <?php echo $row_rsDoc['title']; ?></li></ul></div>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
<p><label for="title">Title:</label><input type="text" name="title" value="<?php echo htmlentities($row_rsDoc['title'], ENT_COMPAT, 'UTF-8'); ?>" id="title" size="32"></p>
 <p><label for="category">category:</label><?  echo listcats( 'Content' , $row_rsDoc['catID']); ?>
      </p>
    <p><label for="">Description:</label><input type="text" id="description" name="description" value="<?php echo htmlentities($row_rsDoc['description'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></p>
    <p><label for="keywords">Keywords:</label><input type="text" id="keywords" name="keywords" value="<?php echo htmlentities($row_rsDoc['keywords'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></p>
    <p><label for="dcontent">Content:</label>
      <textarea name="content" cols="80%" rows="35" id="dcontent"><?php echo htmlentities($row_rsDoc['content'], ENT_COMPAT, 'UTF-8'); ?></textarea>
    </p>
     <script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "dcontent",
		theme : "advanced",
		skin : "default",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,print,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,|,image,media,|,forecolor,backcolor,|,insertdate,inserttime,",
		theme_advanced_buttons3 : "hr,cite,abbr,acronym,del,ins,sub,sup,visualchars,nonbreaking,charmap,emotions,ltr,rtl,|,code,preview,fullscreen,help,cleanup,removeformat,|,styleprops,attribs,",
		theme_advanced_buttons4 : "tablecontrols,visualaid,|,insertlayer,moveforward,movebackward,absolute,visualaid,|,template,pagebreak,restoredraft,",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/editor_styles.css",

		// Drop lists for link/image/media/template dialogs, You shouldn't need to touch this
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats: You must add here all the inline styles and css classes exposed to the end user in the styles menus
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		]
	});
		
// EndOAWidget_Instance_2204022
  </script>
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
