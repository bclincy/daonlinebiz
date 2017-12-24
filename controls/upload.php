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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsUploads = 20;
$pageNum_rsUploads = 0;
if (isset($_GET['pageNum_rsUploads'])) {
  $pageNum_rsUploads = $_GET['pageNum_rsUploads'];
}
$startRow_rsUploads = $pageNum_rsUploads * $maxRows_rsUploads;

mysql_select_db($database_dbcon, $dbcon);
$query_rsUploads = "SELECT * FROM uploads LEFT JOIN docs ON doc_id=ID LEFT JOIN category ON cat_id=catID";
$query_limit_rsUploads = sprintf("%s LIMIT %d, %d", $query_rsUploads, $startRow_rsUploads, $maxRows_rsUploads);
$rsUploads = mysql_query($query_limit_rsUploads, $dbcon) or die(mysql_error());
$row_rsUploads = mysql_fetch_assoc($rsUploads);

if (isset($_GET['totalRows_rsUploads'])) {
  $totalRows_rsUploads = $_GET['totalRows_rsUploads'];
} else {
  $all_rsUploads = mysql_query($query_rsUploads);
  $totalRows_rsUploads = mysql_num_rows($all_rsUploads);
}
$totalPages_rsUploads = ceil($totalRows_rsUploads/$maxRows_rsUploads)-1;$maxRows_rsUploads = 20;
$pageNum_rsUploads = 0;
if (isset($_GET['pageNum_rsUploads'])) {
  $pageNum_rsUploads = $_GET['pageNum_rsUploads'];
}
$startRow_rsUploads = $pageNum_rsUploads * $maxRows_rsUploads;

mysql_select_db($database_dbcon, $dbcon);
$query_rsUploads = "SELECT *, date_format(lastmodified, '%m-%d-%Y') as lastmodified FROM uploads LEFT JOIN docs ON doc_id=ID LEFT JOIN category ON cat_id=catID ORDER BY uploadID DESC";
$query_limit_rsUploads = sprintf("%s LIMIT %d, %d", $query_rsUploads, $startRow_rsUploads, $maxRows_rsUploads);
$rsUploads = mysql_query($query_limit_rsUploads, $dbcon) or die(mysql_error());
$row_rsUploads = mysql_fetch_assoc($rsUploads);

if (isset($_GET['totalRows_rsUploads'])) {
  $totalRows_rsUploads = $_GET['totalRows_rsUploads'];
} else {
  $all_rsUploads = mysql_query($query_rsUploads);
  $totalRows_rsUploads = mysql_num_rows($all_rsUploads);
}
$totalPages_rsUploads = ceil($totalRows_rsUploads/$maxRows_rsUploads)-1;

$queryString_rsUploads = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsUploads") == false && 
        stristr($param, "totalRows_rsUploads") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsUploads = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsUploads = sprintf("&totalRows_rsUploads=%d%s", $totalRows_rsUploads, $queryString_rsUploads);
?>
<?
$title='Uploaded Files'; 
$activity='Uploaded Files';
include_once('../inc/functions.php');
if(isset($_REQUEST['msg'])){ $msg=$_REQUEST['msg']; }
start_page('Upload Files');
if(isset($_REQUEST['delete'])){
	$filename=realpath('../uploads/'). '/'.$_REQUEST['filename'];
	$results=queryDB(
		sprintf("DELETE uploads, docs FROM uploads LEFT JOIN docs ON doc_id=docs.ID WHERE uploadID=%d",
			mysql_real_escape_string($_REQUEST['delete']) )
			);
	if(unlink($filename)){ $delete='deleted'; 
		$msg="FILE: {$_REQUEST['filename']} was removed";
	}
}
if(isset($_POST['upload'])){ 
	if(!isset($_POST['displayname']) || empty($_POST['displayname'])){ $msg['error']='Display Name is Required'; }
	else{
		if(uploaddoc('uploadfile')){//update the database  
			if(isset($_POST['newdescription'])){ 
				$sql="INSERT INTO docs (title, keywords, content, catID, doc_date) 
				VALUE ('{$_POST['displayname']}', 'Uploaded file', '{$_POST['newdescription']}', 7, now())
				ON DUPLICATE KEY UPDATE title='{$_POST['displayname']}', content='{$_POST['newdescription']}', catID=7, doc_date=now()"; 
				 $results=queryDB($sql);
				$id=mysql_insert_id();
				$sql="INSERT INTO uploads (doc_id, filename, displayname, lastmodified) 
				VALUES ($id, '{$_FILES['uploadfile']['name']}', '{$_POST['displayname']}', now())";
				$results=queryDB($sql);
			}
			else{
				$results=queryDB("INSERT INTO uploads (filename, displayname, lastmodified) VALUES ('{$_FILES['uploadfile']['name']}', '{$_POST['displayname']}', now())");
			}
		}//End Upload
	}//end else for bad form
}
elseif(isset($_POST['saveChanges'])){
	foreach($_POST['upload_id'] as $value){
		if(isset($_POST['nodescription'][$value]) && !empty($_POST['decription'][$value])){
			//insert a new document with the data and update the upload table
			echo "Hello";
		}
		elseif(!empty($_POST['description'][$value])){
			//update sql;
			$sql = "UPDATE uploads LEFT JOIN docs ON doc_id=docs.ID 
			SET displayname='{$_POST['display'][$value]}', content='{$_POST['description'][$value]}',title='{$_POST['display'][$value]}',  lastmodified=now(), catID=7 WHERE uploadID=$value";
			$results=queryDB($sql);
		}
		#$results=queryDB("UPDATE uploads SET displayname='{$_POST['display'][$value]}', lastmodified=now(), WHERE uploadID=$value");
		
	}
	if(isset($_POST['delete'])){
		foreach($_POST['delete'] as $key=>$value){
			list($filename, $doc_id)=explode('^',$value);
			$filename=realpath('../uploads/'). '/'.$filename;
			#echo $filename;
			$results=queryDB("DELETE uploads, docs FROM uploads LEFT JOIN docs ON doc_id=docs.ID WHERE uploadID=$key");
			if(unlink($filename)){ $delete='deleted'; }
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Upload Documents</title>
<script type="text/javascript" src="../scripts/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>
<body>
<? include_once('header.php'); ?>
<div class="breadcrum"><ul>
  <li><a href="./">Home</a></li><li>File Controls</li></ul></div>
<h1>New Uploaded files</h1>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="frmUpload" id="frmUpload">
 <p>Upload File: Only (Word Docs, Excel, PDF, Presentation, JPEG) Max upload 10 Megs</p>
  <? if(isset($msg)){ echo "<p>$msg</p>"; } ?>   
      <script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "newdescription",
		theme : "advanced",
		skin : "default",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,print,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,cut,copy,paste,pastetext,pasteword,link,unlink,anchor,|,image,media,",
		theme_advanced_buttons2 : "search,replace,|,bullist,numlist,undo,redo,|,visualchars,nonbreaking,charmap,emotions,|,code,preview,fullscreen,help,|,cleanup,removeformat,",
		theme_advanced_buttons3 : "search,replace,tablecontrols,visualaid,",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "/css/editor_styles.css",

		// Drop lists for link/image/media/template dialogs, You shouldn't need to touch this
		template_external_list_url : "/lists/template_list.js",
		external_link_list_url : "/lists/link_list.js",
		external_image_list_url : "/lists/image_list.js",
		media_external_list_url : "/lists/media_list.js",

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
		
</script>
     <h2>Upload New File</h2>
      <p><label for="uploadfile">Upload File:</label>
      <input name="uploadfile" type="file" id="uploadfile" size="15" /></p>
      <p><label for="displayname">Display Name:</label>
      <input name="displayname" type="text" id="displayname" size="15" maxlength="150" /><input type="hidden" name="MAX_FILE_SIZE" value="1000000" /></p>
      <p><label for="newdescription">New Description</label><textarea name="newdescription" cols="30" rows="5" id="newdescription"><?= $_POST['newdescription']; ?></textarea></p>
      <p><label for="upload">&nbsp;</label><input type="submit" name="upload" id="upload" value="Upload" /></p>

 </form>
<table border="0" align="center" class="tabledata">
  <thead>
    <th>File Name<br>
      View</th>
    <th>Display Name<br>
      Edit</th>
    <th>Date<br>
      Edit</th>
    <th>Description<br>
      Edit</th>
     <th>Category<br>
      Edit</th>
     <th>Size</th>
     <th>Delete</th>
  </thead>
  <?php do { ?>
    <tr class="row">
      <td><a href="../uploads/<?=$row_rsUploads['filename']; ?>" target="/"><?php echo $row_rsUploads['filename']; ?>&nbsp;</a> </td>
      <td><a href="upload-edit.php?recordID=<?php echo $row_rsUploads['uploadID']; ?>"><?php echo $row_rsUploads['displayname']; ?>&nbsp;</a></td>
      <td><?php echo $row_rsUploads['lastmodified']; ?>&nbsp; </td>
      <td><?php echo showwords($row_rsUploads['content'], 30); ?>&nbsp; </td>
      <td><?= formatBytes(filesize( "../uploads/{$row_rsUploads['filename']}")); ?> </td>
      <td><?php echo $row_rsUploads['cat_name']; ?>&nbsp; </td>
      <td><a href="?delete=<?= $row_rsUploads['uploadID']; ?>">Remove</a></td>
    </tr>
    <?php } while ($row_rsUploads = mysql_fetch_assoc($rsUploads)); ?>
</table>
<br>
<table border="0">
  <tr>
    <td><?php if ($pageNum_rsUploads > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rsUploads=%d%s", $currentPage, 0, $queryString_rsUploads); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_rsUploads > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rsUploads=%d%s", $currentPage, max(0, $pageNum_rsUploads - 1), $queryString_rsUploads); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_rsUploads < $totalPages_rsUploads) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rsUploads=%d%s", $currentPage, min($totalPages_rsUploads, $pageNum_rsUploads + 1), $queryString_rsUploads); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_rsUploads < $totalPages_rsUploads) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rsUploads=%d%s", $currentPage, $totalPages_rsUploads, $queryString_rsUploads); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_rsUploads + 1) ?> to <?php echo min($startRow_rsUploads + $maxRows_rsUploads, $totalRows_rsUploads) ?> of <?php echo $totalRows_rsUploads ?>

 <? include_once('footer.php'); ?>
 <?
 function formatBytes($b,$p = null) {
    /**
     * 
     * @author Martin Sweeny
     * @version 2010.0617
     * 
     * returns formatted number of bytes. 
     * two parameters: the bytes and the precision (optional).
     * if no precision is set, function will determine clean
     * result automatically.
     * 
     **/
    $units = array("B","kB","MB","GB","TB","PB","EB","ZB","YB");
    $c=0;
    if(!$p && $p !== 0) {
        foreach($units as $k => $u) {
            if(($b / pow(1024,$k)) >= 1) {
                $r["bytes"] = $b / pow(1024,$k);
                $r["units"] = $u;
                $c++;
            }
        }
        return number_format($r["bytes"],2) . " " . $r["units"];
    } else {
        return number_format($b / pow(1024,$p)) . " " . $units[$p];
    }
}
?>
 <?php
mysql_free_result($rsUploads);
?>
