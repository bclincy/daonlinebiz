<?php require_once('../Connections/dbcon.php'); ?>
<?php
require_once('../inc/functions.php');
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$_POST['url']=remove_http($_POST['url']); 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmNewlink")) {
  $insertSQL = sprintf("INSERT INTO links (name, url, `description`) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['url'], "text"),
                       GetSQLValueString($_POST['description'], "text"));

  mysql_select_db($database_dbcon, $dbcon);
  $Result1 = mysql_query($insertSQL, $dbcon) or die(mysql_error());
  $link_id=mysql_insert_id();
  if(isset($_POST['frontpage'])){
	  $insertsql="INSERT INTO frontpage (link_id, modified ) VALUES ( $link_id, now())";
	  $result=mysql_query($insertsql); 
  }
  $insertGoTo = "quicklink.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_rsLinks = 20;
$pageNum_rsLinks = 0;
if (isset($_GET['pageNum_rsLinks'])) {
  $pageNum_rsLinks = $_GET['pageNum_rsLinks'];
}
$startRow_rsLinks = $pageNum_rsLinks * $maxRows_rsLinks;

$sort_rsLinks = "name";
if (isset($_REQUEST['sort'])) {
  $sort_rsLinks = $_REQUEST['sort'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rsLinks = sprintf("SELECT linkID, name, url, frontpage.id as frontID FROM links LEFT JOIN frontpage ON linkID=link_id ORDER BY %s", GetSQLValueString($sort_rsLinks, "text"));
$query_limit_rsLinks = sprintf("%s LIMIT %d, %d", $query_rsLinks, $startRow_rsLinks, $maxRows_rsLinks);
$rsLinks = mysql_query($query_limit_rsLinks, $dbcon) or die(mysql_error());
$row_rsLinks = mysql_fetch_assoc($rsLinks);

if (isset($_GET['totalRows_rsLinks'])) {
  $totalRows_rsLinks = $_GET['totalRows_rsLinks'];
} else {
  $all_rsLinks = mysql_query($query_rsLinks);
  $totalRows_rsLinks = mysql_num_rows($all_rsLinks);
}
$totalPages_rsLinks = ceil($totalRows_rsLinks/$maxRows_rsLinks)-1;

$queryString_rsLinks = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsLinks") == false && 
        stristr($param, "totalRows_rsLinks") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsLinks = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsLinks = sprintf("&totalRows_rsLinks=%d%s", $totalRows_rsLinks, $queryString_rsLinks);
if(isset($_POST['remove'])){
	foreach($_POST['remove'] as $key=>$value){
		$msg['Success'].="
		<p><strong>$value</strong>was Removed</p>
		";
		$results=mysql_query("DELETE FROM links WHERE ID=$key");
		$results=mysql_query("DELETE FROM frontpage WHERE linkID=$key"); 
	}
}
?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Managed Links</title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php');?>
  <? if(isset($msg)){
	  echo "<div class=\"msg\">";
	  foreach($msg as $key=>$value){echo "<h2>$key</h2> $value</p>\n"; }
	  echo "</div>\n";
  }
  elseif(isset($error)){
	  echo "<div class=\"error\">";
	  foreach($error as $key=>$value){echo "<p> $key :: $value</p>\n"; }
	  echo "</div>\n";
  }
  ?>
  <div class="breadcrum">
  <ul><li><a href="./">Home</a></li><li>Links</li></ul>
  </div>
  <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="frmNewlink" id="frmNewlink">
    <p>
      <label for="name">Name:</label>
      <input type="text" name="name" size="25" placeholder="Footer Locker" />
    </p>
    <p>
      <label for="url">Link/Url:</label>
      <input type="text" name="url" value="" size="25" placeholder="www.footlocker.com" />
    </p>
    <p>
      <label for="description">Description:</label>
      <textarea name="description" cols="32" rows="3" placeholder="We recieve a 20% discount with Footer locker use this link and you'll recieve 20% off at the check out"></textarea>
    </p>
    <p>
      <label for="frontpage">Add to Frontpage:</label>
      <input type="checkbox" name="frontpage" id="frontpage" />
    </p>
    <p><input type="hidden" name="MM_insert" value="frmNewlink" />
      <label for="btnSavelink">&nbsp;</label>
      <input name="btnSavelink" type="submit" id="btnSavelink" value="Save" />
    </p>
    
  </form>
  <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" name="removelink">
  <table border="0" align="center" class="tabledata">
    <thead>
      <th>Name/Edit</th>
      <th>Link/URL</th>
      <th>On Frontpage</th>
      <th>Remove</th>
    </thead>
    <?php do { ?>
      <tr class="row">
        <td><a href="linksdetails.php?recordID=<?php echo $row_rsLinks['link_id']; ?>"><?php echo $row_rsLinks['name']; ?></a></td>
        <td><?php echo $row_rsLinks['url']; ?> </td>
        <td><? if(!empty($row_rsLinks['frontID'])){ echo "Yes"; }
		else{echo "No"; }  ?></td>
        <td><input name="remove[<?= $row_rsLinks['link_id']; ?>]" type="checkbox" value="<?= $row_rsLinks['name']; ?>" /></td>
      </tr>
      <?php } while ($row_rsLinks = mysql_fetch_assoc($rsLinks)); ?>
      <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2" align="right">
        <input type="submit" name="btnRemove" id="btnRemove" value="Remove" /></td>
      </tr>
  </table></form>
  <br>
  <table border="0">
    <tr>
      <td><?php if ($pageNum_rsLinks > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsLinks=%d%s", $currentPage, 0, $queryString_rsLinks); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_rsLinks > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsLinks=%d%s", $currentPage, max(0, $pageNum_rsLinks - 1), $queryString_rsLinks); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_rsLinks < $totalPages_rsLinks) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsLinks=%d%s", $currentPage, min($totalPages_rsLinks, $pageNum_rsLinks + 1), $queryString_rsLinks); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_rsLinks < $totalPages_rsLinks) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsLinks=%d%s", $currentPage, $totalPages_rsLinks, $queryString_rsLinks); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_rsLinks + 1) ?> to <?php echo min($startRow_rsLinks + $maxRows_rsLinks, $totalRows_rsLinks) ?> of <?php echo $totalRows_rsLinks ?>
<? include_once('footer.php'); ?>
</body>
</html>
<?php
mysql_free_result($rsLinks);
?>
