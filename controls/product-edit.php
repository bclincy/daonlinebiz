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
  $updateSQL = sprintf("UPDATE products SET catID=%s, product=%s, `description`=%s, QOH=%s, minQty=%s, supPtNum=%s, supplierID=%s, unit=%s, shipping=%s, Price=%s, type=%s, webapp_id=%s WHERE partID=%s",
                       GetSQLValueString($_POST['categoryID'], "int"),
                       GetSQLValueString($_POST['product'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['QOH'], "int"),
                       GetSQLValueString($_POST['minQty'], "text"),
                       GetSQLValueString($_POST['supPtNum'], "text"),
                       GetSQLValueString($_POST['supplierID'], "int"),
                       GetSQLValueString($_POST['unit'], "text"),
                       GetSQLValueString($_POST['shipping'], "double"),
                       GetSQLValueString($_POST['Price'], "double"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['webappID'], "int"),
					   GetSQLValueString($_POST['partID'], "int"));

  mysql_select_db($database_dbcon, $dbcon);
  $Result1 = mysql_query($updateSQL, $dbcon) or die(mysql_error());

  $updateGoTo = "products-list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_DetailRS1 = 30;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$part_DetailRS1 = "-1";
if (isset($_REQUEST['recordID'])) {
  $part_DetailRS1 = $_REQUEST['recordID'];
}
$colname_DetailRS1 = "partID";
if (isset($_REQUEST['sortby'])) {
  $colname_DetailRS1 = $_REQUEST['sortby'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_DetailRS1 = sprintf("SELECT *, date_format('M/d/Y', lastmodified) as dated FROM products LEFT JOIN category ON cat_id=catID WHERE partID = %s ORDER BY %s", GetSQLValueString($part_DetailRS1, "int"),GetSQLValueString($colname_DetailRS1, "text"));
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
?>
<? include_once('../inc/functions.php'); $activity="Edit ".$row_DetailRS1['product']; ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Edit Product <?php echo $row_DetailRS1['product']; ?></title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="../scripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/prod.js"></script>
<script type="text/javascript" src="../js/jqvalidate.js"></script>
<link href="basic.css" rel="stylesheet" type="text/css">
<link href="standard.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>
<div id="navlinks"><ul><li><a href="./">Home</a></li><li><a href="products-list.php">Products</a></li><li>Edit :: <?php echo $row_DetailRS1['product']; ?></li></ul></div>
<form method="post" name="frmUpProd" action="<?php echo $editFormAction; ?>">
  <p>
    <label for="category">Category:</label>
    <?= listcats('Products', $row_DetailRS1['catID']); ?>
  </p>
  <p>
    <label for="">Product:</label>
    <input type="text" name="product" id="product" value="<?php echo htmlentities($row_DetailRS1['product'], ENT_COMPAT, 'UTF-8'); ?>" size="32">
  </p>
   <script type="text/javascript">
// BeginOAWidget_Instance_2204022: #postContent

	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "description",
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

  <p><label for="description">Description:</label>
      <textarea name="description" id="description" cols="50" rows="5"><?php echo htmlentities($row_DetailRS1['description'], ENT_COMPAT, 'UTF-8'); ?></textarea>
  </p>
      <p>
        <label for="QOH">Quantity On Hand:</label>
        <input name="QOH" type="text" id="QOH" value="<?php echo htmlentities($row_DetailRS1['QOH'], ENT_COMPAT, 'UTF-8'); ?>" size="32" maxlength="8">
      </p>
      <p>
        <label for="minQty">Min Quantity:</label>
        <input name="minQty" type="text" id="minQty" value="<?php echo htmlentities($row_DetailRS1['minQty'], ENT_COMPAT, 'UTF-8'); ?>" size="32" maxlength="8">
      </p>
      <p>
        <label for="supPtNum">Supplier Part #:</label>
        <input type="text" name="supPtNum" id="supPtNum" value="<?php echo htmlentities($row_DetailRS1['supPtNum'], ENT_COMPAT, 'UTF-8'); ?>" size="32">
      </p>
      <p>
        <label for="supplierID">Supplier:</label>
        <select name="supplierID" id="supplierID">
          <option value="0">No Supplier</option>
        </select>
      </p>
      <p>
        <label for="unit">Unit:</label>
        <select name="unit" id="unit">
          <option value="Each" <?php if (!(strcmp("Each", htmlentities($row_DetailRS1['unit'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>>Each</option>
          <option value="LB" <?php if (!(strcmp("LB", htmlentities($row_DetailRS1['unit'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>>LB</option>
          <option value="Hour" <?php if (!(strcmp("Hour", htmlentities($row_DetailRS1['unit'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>>Hr</option>
          <option value="Visit" <?php if (!(strcmp("Visit", htmlentities($row_DetailRS1['unit'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>>vt</option>
        </select>
      </p>
      <p>
        <label for="shipping">Shipping:</label>
        <input type="text" name="shipping" id="shipping" value="<?php echo htmlentities($row_DetailRS1['shipping'], ENT_COMPAT, 'UTF-8'); ?>" size="32">
      </p>
      <p>
        <label for="Price">Price:</label>
        <input type="text" name="Price" id="Price" value="<?php echo htmlentities($row_DetailRS1['Price'], ENT_COMPAT, 'UTF-8'); ?>" size="32">
      </p>
      <p>
        <label for="type">Type:</label>
        <select name="type" id="type">
          <option value="Product" <?php if (!(strcmp("Product", htmlentities($row_DetailRS1['type'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>>Product</option>
          <option value="Service" <?php if (!(strcmp("Service", htmlentities($row_DetailRS1['type'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>>Service</option>
        </select>
      </p>
      <p><label for="webApp">Web Application</label><? $select=selectID('webappID', 'webapp', 'webappID', 'name', $row_DetailRS1['webapp_id']);
	  if($select=='No Record'){ echo "<input type=\"hidden\" name=\"webappID\" value=\"\">"; }
	  else{ echo $select; }
	   ?></p>
      <p>
        <label for="">&nbsp;</label>
        <input type="submit" value="Save Changes">
      </p>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="partID" value="<?php echo $row_DetailRS1['partID']; ?>">  
</form>
<?= "<select name=\"catID\">".categoryselect(3). "</select> hello" 	; ?>
<p>&nbsp;</p>
<? include_once('footer.php'); ?>
</body>
</html>
<?php
mysql_free_result($DetailRS1);

function categoryselect($selectID){
	if(!isset($selected)){
		 $sql=" SELECT node .cat_id , node.cat_name , (
			COUNT( parent.cat_name ) -1
			) AS depth
      		FROM category AS node, category AS parent  WHERE node.lft
	  		BETWEEN parent.lft AND parent.rgt AND parent.cat_id=2
	  		GROUP BY node.cat_name ORDER BY node.lft";
		$results=mysql_query($sql); 		
		global $selected;
		if($results){
			while($records=mysql_fetch_assoc($results)){
				$selected[$records['cat_id']]=array("<option value=\"{$records['cat_id']}\" ",  ">". 
				str_repeat("&nbsp;&nbsp;", $records['depth'])."{$records['cat_name']}</option>");
			}
		}
		else{  return false; }
	}
	foreach($selected as $key=>$value){
			$selmenu.=$value[0];
			if($key==$selectID){
				$selmenu.=" selected=\"selected\"";
			}
			$selmenu.=$value[1];
	} 
	global $selected;
	return $selmenu;
}

?>