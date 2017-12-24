<?php require_once('../../Connections/dbcon.php'); ?>
<?php
include_once('cart.php');
$cart =& $_SESSION['mycart']; // point $cart to session cart.
if(!is_object($cart)) $cart = new wfCart();
$carts=array($cart->get_contents());
mysql_select_db($database_dbcon, $dbcon);
if(isset($_POST['addtoInvoice'])){
	foreach($_POST['addtoInvoice'] as $key => $value){
		$cart->add_item( $key, $_POST['qty'][$key], $_POST['price'][$key], $_POST['info'][$key]);
		if($_POST['ptype'][$key]=='product'){ $_SESSION['taxable'][$key]=1; }
	}
}
function insertline($key){
	$sql="INSERT INTO products (catID, product, description, price, type, lastmodified) 
	VALUES({$_POST['catID'][$key]}, '{$_POST['newproduct'][$key]}','{$_POST[description][$key]}', {$_POST['priced'][$key]}, '{$_POST['ptype'][$key]}', now())";
    if(mysql_query($sql)){ return mysql_insert_id(); }
	else{ echo "Problem "; exit; }
}
if(isset($_POST['newproduct'])){
	foreach($_POST['newqty'] as $key=>$value){
		if(empty($value)){continue; }
		if(isset($_POST['add'][$key-1])){// they start at zero and w
			$id=insertline($key); 
			$cart->add_item($id, $value, $_POST['priced'][$key], $_POST['newproduct'][$key]);
		}
		else{
		if(in_array($key,$cart->get_contents())){ echo "<p>already in the cart</p>"; }
		$num=rand(4000,4100);
		if($_POST['ptype'][$key]=='product'){ $_SESSION['taxable'][$num]=1; }
		$cart->add_item($num, $value, $_POST['priced'][$key], $_POST['newproduct'][$key] ."//". $_POST['description'][$key]);
		}
		//Insert line to shopping cart script
	}
}
if(isset($_REQUEST['remove']) && is_numeric($_REQUEST['remove'])){
		$cart->del_item($_REQUEST['remove']);
}
if(isset($_POST['emptyInvoice'])){
	$cart->empty_cart();
 }
 if(isset($_POST['finishInvoice'])){
	include_once('invoice_finish.php');
	exit;
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
$queryString_rsProducts = sprintf("&totalRows_rsProducts=%d%s", $totalRows_rsProducts, $queryString_rsProducts);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Creating Customers Invoice</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="page">
  <div id="header">
    <div id="navi"><ul><li><a href="invoices.php">Home</a></li><li><a href="invoice_new.php">Create New</a></li>
    <li><a href="customers.php">Customers</a></li></ul></div>
    <h2>Create Invoice</h2>
  </div>
  <div id="content">
  <?= $_SESSION['customer'] ."<br />". $_SESSION['address']; ?>
  
  <?
  if($cart->itemcount > 0){
	  ?> 
      <h2>Invoice Contents</h2>
      <form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" name="createInvoice" id="createInvoice">
 <table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <th scope="col">Qty</th>
    <th scope="col">Product</th>
    <th scope="col">Price</th>
    <th scope="col">Line Total</th>
    <th scope="col">Taxable</th>
    <th scope="col">&nbsp;</th>
     
  </tr>
<? foreach($cart->get_contents() as $item) { ?>
  <tr class="rowdata">
    <td><?= $item['qty']; ?></td>
    <td><?= $item['info']; ?></td>
    <td><?= money_format('$ %i', $item['price']); ?></td>
    <td><?= money_format('$ %i', $item['subtotal']); ?></td>
    <td><input type="checkbox" name="taxable[<?= $item['id']; ?>]" value="1" <? if(isset($_SESSION['taxable'][$item['id']])){ echo "checked=\"checked\" ";}?> />
    <td><a href="?remove=<?= $item['id']; ?>">Remove</a></td>
  </tr>
<? } //end current invoice ?>
<tr>
  <td colspan="5">&nbsp;</td>
  <td><?= "total: $".number_format($cart->total,2); ?>
<tr>
  <td colspan="5">&nbsp;</td>
  <td align="center"><input type="submit" name="finishInvoice" id="finishInvoice" value="Save Invoice" /></td>
</tr>
</table>
</form>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="Empty"><input type="hidden" name="emptyInvoice" value="all" /><input name="emptyInvoice" type="button" value="Remove All" onclick="r=confirm('Sure you want to Remove Contents');if(r){document.Empty.submit();}" /></form>
<h2>Continue Adding</h2>
      <?
  }
  
  if(!isset($_POST['custProducts'])){ //Don't show when you're putting customer
  ?>
<form action="invoice_products.php" method="post" enctype="multipart/form-data" name="frmProdstoInv" id="frmProdstoInv">
<input name="custProducts" type="submit" value="Customer Products" />
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
      <td colspan="3" align="center" valign="middle"><input type="submit" name="Add" id="Add" value="Add" />
        <input type="submit" name="custProducts" id="custProducts" value="Custom Products" /></td>
    </tr>
  </table></form>
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
  <? 
  }// End db stuff
  if(isset($_POST['custProducts'])){  
	   ?>    
  <h2>New Products</h2>
  <form action="<?= $_POST['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="customprods">
  <a href="#">Products List</a>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr class="row">
      <th scope="col">Line</th>
      <th scope="col">Qty</th>
      <th scope="col" colspan="2">Product</th>
      <th scope="col">Price</th>
      <th scope="col">Unit</th>
      <th scope="col">Category</th>
      <th scope="col">Type</th>
      <th scope="col">Save</th>
    </tr>
    <? $i=1;
	do{?>
    <tr class="row">
      <td rowspan="2" align="center" valign="top"><?= $i; ?></td>
      <td rowspan="2" align="center" valign="top"><input name="newqty[<?= $i;?>]" type="text" id="newqty[<?=$i;?>]" value="<?=$_POST['newqty'][$i]; ?>" size="2" maxlength="10" /></td>
      <td align="right">Product:</td>
      <td><input name="newproduct[<?=$i;?>]" type="text" id="newproduct[<?=$i;?>]" value="<?= $_POST['newproduct'][$i]; ?>" size="20" maxlength="255" /></td>
      <td  rowspan="2" align="center" valign="top"><input name="priced[<?= $i; ?>]" type="text" id="priced[<?= $i; ?>]" value="<? 
	  if(is_numeric($_POST['priced'][$i])){ echo money_format('%i',$_POST['priced'][$i]); } else{ echo '0.00';}  ?>" size="5" maxlength="8" /></td>
      <td align="center" valign="top"  rowspan="2"><select name="units[<?= $i; ?>]" id="units[<?= $i; ?>]">
        <option value="each" <? if($_POST['units'][$i]=='each'){ echo "selected=\"selected\" "; }?> >Each</option>
        <option value="hr" <? if($_POST['units'][$i]=='hr'){ echo "selected=\"selected\" "; }?>>Hour</option>
        <option value="month" <? if($_POST['units'][$i]=='month'){ echo "selected=\"selected\" "; }?> >Month</option>
        <option value="Yr" <? if($_POST['units'][$i]=='Yr'){ echo "selected=\"selected\" "; }?>>Year</option>
        <option value="LB" <? if($_POST['units'][$i]=='LB'){ echo "selected=\"selected\" "; }?>>Pounds</option>
        <option value="Grams" <? if($_POST['units'][$i]=='Grams'){ echo "selected=\"selected\" "; }?>>Grams</option>
      </select></td>
      <td align="center" valign="top"  rowspan="2"><?= selectAcategory($i, $_POST['catID'][$i]); ?> </td>
      <td align="center" valign="top"  rowspan="2">
      <select name="ptype[<?= $i; ?>]" id="ptype[<?= $i; ?>]">
        <option value="service" <? if($_POST['ptype'][$i]=='service'){ echo "selected=\"selected\" "; }?>>Service</option>
        <option value="product" <? if($_POST['ptype'][$i]=='product'){ echo "selected=\"selected\" "; }?>>Product</option>
      </select>
      </td>
      <td rowspan="2" align="center" valign="top"><input name="add[]" type="checkbox" value="<?= $i; ?>" />
    </tr>
    <tr><td align="right">Description:</td>
        <td><input name="description[<?=$i;?>]" type="text" value="<?= $_POST['description'][$i]; ?>" size="20" /></td></tr>
    <? $i++; } while($i <= 10); ?>
  </table>
  <p>
    <input type="submit" name="addItems" id="addItems" value="Save" />
  </p>
</form>
<? }// End new Product
?>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($rsProducts);
function selectAcategory($id,$cat_id){
	$sql="SELECT node.cat_id, node.cat_name
FROM category AS node, category AS parent
WHERE node.lft
BETWEEN parent.lft+1
AND parent.rgt-1
AND parent.cat_name =  'Products' ORDER BY cat_name";
	$results=mysql_query($sql);
	if(!$results || $results==0){return false;}
	$display="<select name=\"catID[$id]\" id=\"catID\"><option value=\"0\">Category</option>\n";
	  while($records=mysql_fetch_assoc($results)){ 
	  	$display.="<option value=\"".$records['cat_id']."\""; 
		if($records['cat_id']==$cat_id){ $display.=" selected=\"selected\" ";}
		$display.=">{$records['cat_name']}</option>\n"; 
	  }
		$display.="</select>";
		mysql_free_result($results); 
	return $display;
}

?>
