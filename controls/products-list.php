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

$maxRows_rsProducts = 30;
$pageNum_rsProducts = 0;
if (isset($_GET['pageNum_rsProducts'])) {
  $pageNum_rsProducts = $_GET['pageNum_rsProducts'];
}
$startRow_rsProducts = $pageNum_rsProducts * $maxRows_rsProducts;

$varprod_rsProducts = "product ASC";
if (isset($_REQUEST['orderby'])) {
  $varprod_rsProducts = $_REQUEST['orderby'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rsProducts = sprintf("SELECT *, date_format(lastmodified, '%%m/%%d/%%Y') as dated FROM products LEFT JOIN category ON cat_id=catID ORDER BY %s", GetSQLValueString($varprod_rsProducts, "text"));
$query_limit_rsProducts = sprintf("%s LIMIT %d, %d", $query_rsProducts, $startRow_rsProducts, $maxRows_rsProducts);
$rsProducts = mysql_query($query_limit_rsProducts, $dbcon) or die(mysql_error());
$row_rsProducts = mysql_fetch_assoc($rsProducts);

if (isset($_GET['totalRows_rsProducts'])) {
  $totalRows_rsProducts = $_GET['totalRows_rsProducts'];
} else {
  $all_rsProducts = mysql_query($query_rsProducts);
  $totalRows_rsProducts = mysql_num_rows($all_rsProducts);
}
$totalPages_rsProducts = ceil($totalRows_rsProducts/$maxRows_rsProducts)-1;

$queryString_rsProducts = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsProducts") == false && 
        stristr($param, "totalRows_rsProducts") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsProducts = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsProducts = sprintf("&totalRows_rsProducts=%d%s", $totalRows_rsProducts, $queryString_rsProducts);
?>
<? $activity="Products"; ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Products</title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="../js/utility.js"></script>
<link href="standard.css" rel="stylesheet" type="text/css">
<link href="basic.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>
<form action="" method="post" enctype="application/x-www-form-urlencoded" name="frmRemove">
  <table align="center" id="box-table-a">
    <thead>
      <th scope="col">Part #</th>
      <th scope="col">Category</th>
      <th scope="col" width="25%">Product</th>
      <th scope="col">Unit</th>
      <th scope="col">Price</th>
      <th scope="col">Type</th>
      <th scope="col">Date</th>
      <th scope="col" width="7%">Sel</th>
    </thead>
    <?php do { 
	if(is_null($row_rsProducts['partID'])){
		echo "<tr class=\"row\"><td colspan=\"8\"><h1>No Products</h1></td></tr>";
		break;
	}
	?>
      <tr>
        <td class="clickable" onClick="DoNav('product-edit.php?recordID=<?=$row_rsProducts['partID']; ?>')"><a href="product-edit.php?recordID=<?php echo $row_rsProducts['partID']; ?>"> <?php echo str_pad($row_rsProducts['partID'], 5, "0", STR_PAD_LEFT); ?>&nbsp; </a></td>
        <td class="clickable"  onClick="DoNav('product-edit.php?recordID=<?=$row_rsProducts['partID']; ?>')"><?php echo $row_rsProducts['cat_name']; ?>&nbsp; </td>
        <td class="clickable" onClick="DoNav('product-edit.php?recordID=<?=$row_rsProducts['partID']; ?>')"><?php echo $row_rsProducts['product']; ?>&nbsp; </td>
        <td class="clickable" onClick="DoNav('product-edit.php?recordID=<?=$row_rsProducts['partID']; ?>')"><?php echo $row_rsProducts['unit']; ?>&nbsp; </td>
        <td class="clickable" onClick="DoNav('product-edit.php?recordID=<?=$row_rsProducts['partID']; ?>')"><?php echo $row_rsProducts['Price']; ?>&nbsp; </td>
        <td class="clickable" onClick="DoNav('product-edit.php?recordID=<?=$row_rsProducts['partID']; ?>')"><?php echo $row_rsProducts['type']; ?>&nbsp; </td>
        <td class="clickable" onClick="DoNav('product-edit.php?recordID=<?=$row_rsProducts['partID']; ?>')"><?php echo $row_rsProducts['dated']; ?>&nbsp; </td>
        <td><input name="selected[<?= $row_rsProducts['partID']; ?>]" type="checkbox" value="<?= $row_rsProducts['product']; ?>" class="sel">
      </tr>
      <?php } while ($row_rsProducts = mysql_fetch_assoc($rsProducts)); ?>
      <tr>
      <td colspan="7">
      </td>
      <td>&nbsp;</td>
      </tr>
  </table>
  <br>
  <table border="0">
    <tr>
      <td><?php if ($pageNum_rsProducts > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsProducts=%d%s", $currentPage, 0, $queryString_rsProducts); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_rsProducts > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsProducts=%d%s", $currentPage, max(0, $pageNum_rsProducts - 1), $queryString_rsProducts); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_rsProducts < $totalPages_rsProducts) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsProducts=%d%s", $currentPage, min($totalPages_rsProducts, $pageNum_rsProducts + 1), $queryString_rsProducts); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_rsProducts < $totalPages_rsProducts) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsProducts=%d%s", $currentPage, $totalPages_rsProducts, $queryString_rsProducts); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_rsProducts + 1) ?> to <?php echo min($startRow_rsProducts + $maxRows_rsProducts, $totalRows_rsProducts) ?> of <?php echo $totalRows_rsProducts ?>
</form>
<? include_once('footer.php'); ?>

<? 

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
				$selected[$records['cat_id']]=array("<option value=\"{$records['cat_id']} ",  ">", 
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
}
?>
</body>
</html>
<?php
mysql_free_result($rsProducts);
?>
