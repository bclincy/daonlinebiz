<?php require_once('../../Connections/dbcon.php'); ?>
<?php
include_once('cart.php');
$cart =& $_SESSION['mycart']; // point $cart to session cart.
if(!is_object($cart)) $cart = new wfCart();
$carts=array($cart->get_contents());
if(isset($_POST['addtoInvoice'])){
	
	foreach($_POST['addtoInvoice'] as $key => $value){
		$cart->add_item( $key, $_POST['qty'][$key], $_POST['price'][$key], $_POST['info'][$key]);
	}
}
if(isset($_POST['addtoInvoice'])){include_once('../../inc/functions.php'); test();
/*$carts=array($cart->get_contents());
if(isset($_REQUEST['pid']) && !isset($_POST['pid'])){
	$cart->add_item($_REQUEST['pid'],$_REQUEST['qty'], $_REQUEST['price'], $_REQUEST['name']);
	$title="{$_REQUEST['name']} Added to your Cart";
}
if(isset($_POST['update'])){
	foreach($_POST['pid'] as $key=>$value){
		$cart->add_item($value,$_POST['qty'][$value], $_POST['price'][$value], $_REQUEST['name']);
		$title="Added {$_REQUEST['name']}";
	}
}
if(isset($_POST['remove'])){
	foreach($_POST['remove'] as $key=>$value){
		$rid = intval($key);
		$cart->del_item($rid);
	}
}
elseif(isset($_POST['emtpy'])){
	$cart->empty_cart();
	$msg="Shopping Cart was Emptied"; 
}

	foreach($_POST['newproduct'] as $key=> $value){
		if(empty($value)){ continue; }
		$sql="INSERT INTO products (catID, product, description, price, service, lastmodified) 
		VALUES({$_POST['catID'][$key]}, '$value', '{$_POST[description][$key]}', {$_POST['priced'][$key]}, '{$_POST['ptype'][$key]}', now())";
		
		exit;
	}
*/
 }
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

$currentPage = "invoice_products.php";

$maxRows_rsProducts = 10;
$pageNum_rsProducts = 0;
if (isset($_GET['pageNum_rsProducts'])) {
  $pageNum_rsProducts = $_GET['pageNum_rsProducts'];
}
$startRow_rsProducts = $pageNum_rsProducts * $maxRows_rsProducts;

mysql_select_db($database_dbcon, $dbcon);
$query_rsProducts = "SELECT partID, product, description, Price, unit, type, cat_name FROM products LEFT JOIN category ON catID=cat_id";
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
$queryString_rsProducts = sprintf("&totalRows_rsProducts=%d%s", $totalRows_rsProducts, $queryString_rsProducts);?>
<form name="frmProdstoInv" id="frmProdstoInv">
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <th scope="col">Qty</th>
      <th scope="col">Product</th>
      <th scope="col">Price</th>
      <th scope="col">Unit</th>
      <th scope="col">Included</th>
    </tr>
    <?php do { ?>
    <tr class="row">
      <td align="center" valign="top"><input name="qty[<?php echo $row_rsProducts['partID']; ?>]" type="text" id="qty[<?php echo $row_rsProducts['partID']; ?>]" value="<?= $_POST['qty'][$row_rsProducts['partID']]; ?>" size="5" maxlength="4" /></td>
      <td><h2><?php echo $row_rsProducts['product']; ?>
        <input name="info[<?= $row_rsProducts['partID']; ?>]" type="hidden" id="hidden" value="<?php echo $row_rsProducts['product']; ?>" />
      </h2>
        <?php echo $row_rsProducts['description']; ?>
       </td>
      <td align="center" valign="top"><input name="price[<?=$row_rsProducts['partID']; ?>]" type="text" id="price[<?=$row_rsProducts['partID']; ?>]" value="<?php echo $row_rsProducts['Price']; ?>" size="5" maxlength="10" /></td>
      <td align="center" valign="top">per <?php echo $row_rsProducts['unit']; ?></td>
      <td align="center" valign="top"><input name="addtoInvoice[<?= $row_rsProducts['partID']; ?>]" type="checkbox" id="onInvoice" value="<?=$row_rsProducts['partID']; ?>" 
	  <? if(isset($_POST['addtoInvoice'][$row_rsProducts['partID']])){ echo "checked=\"checked\""; } ?> /></td>
    </tr>
    <?php } while ($row_rsProducts = mysql_fetch_assoc($rsProducts)); ?>
    <tr>
      <td align="center" valign="middle">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3" align="center" valign="middle"><input type="button" name="Add" id="Add" value="Add" onclick="savecart();"/>
      <input type="submit" name="moreProducts" id="moreProducts" value="Custom Products" /></td>
    </tr>
  </table>
      <h2>Current Products</h2>
      <p>Displaying Products <?php echo ($startRow_rsProducts + 1) ?> to <?php echo min($startRow_rsProducts + $maxRows_rsProducts, $totalRows_rsProducts) ?> of <?php echo $totalRows_rsProducts ?></p>
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
