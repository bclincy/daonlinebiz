<?php require_once('../../Connections/dbcon.php'); ?>
<?php
include_once('cart.php');
$cart =& $_SESSION['mycart']; // point $cart to session cart.
if(!is_object($cart)) $cart = new wfCart();
$carts=array($cart->get_contents());

if($cart->itemcount <1 ){
	echo "<h2>Sorry</h2><p>Nothing to View <a href=\"javascript: history.go(-1)\" OnClick=\"javascript: history.go(-1)\">Go Back</a> and Start over</p>"; 
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Invoice for
<?= "{$_SESSION['customer']}"; ?>
</title>
<style type="text/css">
<!--
#pagecontainer {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
body {
	margin: 0 10% 0 10%;
	font-size:10px;
}
table td {
	border: 1px solid black;
	padding: 5px;
}
#header {
	font-size: 1.5em;
	font-style: normal;
	font-weight: 800;
	color: #FFF;
	background-color: #000;
	letter-spacing: 5pt;
	text-align: center;
	width: 100%;
	padding-top: 10px;
	padding-bottom: 10px;
}
#caddress {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 12pt;
	color: #000;
	float: left;
	width: 40%;
	padding:20px 0 5px 15px;
}
#logo {
	float: right;
	width: 50%;
	margin-left: 5%;
	padding: 20px 0 5px 0;
	text-align: center;
}
#logo img {
	text-align:center;
	border:none;
}
.clear {
	float:none;
	clear:both;
}
#compadd {
	font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
	font-size: 1em;
	font-weight: 600;
	float: left;
	width: 40%;
	padding:0 5px 0 10px;
}
#invoicedetails {
	float: right;
	width: 50%;
	margin-right: 5%;
}
#meta {
	margin-top: 1px;
	width: 300px;
	float: right;
	border: thin #000 solid;
}
#meta td {
	padding: 0 5px 0 10px;
	margin:0;
}
#meta td.meta-head {
	text-align: right;
	background: #eee;
}
#meta td .data {
	width: 150px;
	height: 20px;
	text-align: right;
}
th {
	padding: 1em 5px 1em 5px;
	background-color:#ECECEC;
	font-family:"Times New Roman", Times, serif;
	font-size:14pt;
}
#items {
	width: 90%;
	margin: 3em auto 0 auto;
	padding:5em 0;
}
.item-row {
	text-align:center;
}
-->
</style>
</head>
<body>
<div id="navi"><ul><li><a href="invoices.php">Home</a></li>
<li><a href="invoice_new.php">Create New</a></li>
<li><a href="customers.php">Customers</a></li></ul></div>
<div id="pagecontainer">
  <div id="header">Invoice</div>
  <div id="caddress">
    <?= $companyname; ?>
  </div>
  <div id="logo"><a href="http://daonlinebiz.com"><img src="http://www.daonlinebiz.com/images/dalogo.gif" alt="DaOnlinebiz.com Business in Perspective" /></a></div>
  <div class="clear">
  <div  id="compadd">CustomerID: <? echo str_pad($row_rs_invoice['custID'], 4, '0', STR_PAD_LEFT);
	if(!is_null($row_rs_invoice['company'])){ echo "B <br />"; $showcompany="<br />". $row_rs_invoice['company']; }else{ echo "C<br />"; } ?> <?php echo $row_rs_invoice['fname']; ?> <?php echo $row_rs_invoice['lname']; ?>
    <?= $showcompany; ?>
    <br />
    <? echo $row_rs_invoice['address1']; ?>
    <? if(!is_null($row_rs_invoice['address2'])){ echo "<br />". $row_rs_invoice['address2']; } ?>
    <br />
    <?php echo $row_rs_invoice['city']; ?><?php echo $row_rs_invoice['abrivation']; ?> <?php echo $row_rs_invoice['zipcode']; ?></div>
  <div id="invoicedetails">
    <table id="meta">
      <tr>
        <td class="meta-head">Invoice #</td>
        <td class="data"><?= "$month$day$year-{$row_rs_invoice['invoiceID']}-{$row_rs_invoice['custID']}"; ?></td>
      </tr>
      <tr>
        <td class="meta-head">Date</td>
        <td class="data"><?=$dated; ?></td>
      </tr>
      <tr>
        <td class="meta-head">Amount Due</td>
        <td class="data"><? $total=money_format('$ %i', $row_rs_invoice['inTotal']); echo $total;?></td>
      </tr>
    </table>
    </div>
    </div>
   
    <!-- Invoice details !-->
    <div class="clear">
    <div><label for="linenum">Add Line Items:</label><select name="addline[]" size="1"></select></div>
    <form id="form1" name="form1" method="post" action="">
    <table id="items">
      <tr>
        <th>Del</th>
        <th>Item #</th>
        <th>Description</th>
        <th>Unit Cost</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
      <?php 
	  foreach($cart->get_contents() as $item){ $i=1; ?>
      <tr class="item-row">
        <td><input type="checkbox" name="delete[<?= $item['id']; ?>]" value="1" />
        <td><?= $item['id']; ?></td>
        <td><?php echo $item['info']; ?></td>
        <td><?php echo money_format('$ %i', $item['price']); ?></td>
        <td><?php echo $item['qty']; ?></td>
        <td>
          $<input name="price[<?= $item['id']; ?>]" type="text" id="price[<?= $item['id']; ?>]" size="5" maxlength="20" value="<?= money_format('%i', $item['subtotal']); ?>" />
        </td>
      </tr>
      <?
 $i++;//End items
} 
?>

      <? 
$checkoutfrm="<form method=\"POST\"
  action=\"https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/741888562733894\"
      accept-charset=\"utf-8\">";


// $i is starting at record now which is zero
$i = 0; 
#$results = queryDB($sql); 
/*while($record=mysql_fetch_assoc($results)) { 



?>
		  <tr class="item-row">
		      <td class="item-name">
			  <? 
			  if(is_null($record['specifics'])){ echo $record['product']; $checkoutfrm.=$record['product']."\" />\n"; } 
			  else{ echo $record['nonpartname']; }
			  ?>
			  </td>
		      <td class="description">
              <? 
	  		  if(is_null($record['specifics'])){ echo $record['description']; } 
			  else{ echo $record['specifics'];  }
			  ?>
              </td>
		      <td><?= $record['price']; ?></td>
		      <td><?= $record['qty']; ?></td>
		      <td><?= money_format('$ %i', ($record['price'] * $record['qty'])); ?></td>
		  </tr>
<? $i++; $invoice = $record['invoiceID']; 
}//End while*/
?>
      <tr>
        <td colspan="3" class="blank">&nbsp;</td>
        <td colspan="2" class="total-line">Discount:</td>
        <td class="total-value"><input name="discount" type="text" id="discount" size="2" maxlength="10" />
          <select name="dtype" id="dtype">
            <option value="%">%</option>
            <option value="$">$</option>
          </select></td>
      </tr>
      <tr>
        <td colspan="3" class="blank"></td>
        <td colspan="2" class="total-line">Total</td>
        <td class="total-value"><div id="total">
            <?=$total; ?>
          </div></td>
      </tr>
      <tr>
        <td colspan="3" class="blank"></td>
        <td colspan="2" class="total-line">Payment Type:</td>
        <td class="total-value"><select name="paymenttype" size="1">
            <option value="Cash">Cash</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Check">Check</option>
          </select></td>
      </tr>
      <tr>
        <td colspan="3" class="blank"></td>
        <td colspan="2" class="total-line">Amount Paid</td>
        <td class="total-value">$
          <input name="amount" type="text" id="paid" value="0.00" size="10" maxlength="8" /></td>
      </tr>
      <tr>
        <td colspan="3" class="blank"></td>
        <td colspan="2" class="total-line balance">Balance Due</td>
        <td class="total-value balance"><?= $total; ?></td>
      </tr>
      <tr>
        <td colspan="3" class="blank"></td>
        <td colspan="2" class="total-line balance">Apply Changes:</td>
        <td><input type="submit" name="SaveInvoice" id="SaveInvoice" value="Save" /></td>
      </tr>
    </table>
  </form>
</div>
</div>
</div>
<div id="footer"></div>
</body>
</html>
<?php
mysql_free_result($rs_invoice);

#mysql_free_result($rs_invoiced);
?>

</body>
</html>