<?php require_once('../../Connections/dbcon.php'); ?>
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

$voice_rs_invoice = "5";
if (isset($_REQUEST['recordID'])) {
  $voice_rs_invoice = $_REQUEST['recordID'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rs_invoice = sprintf("SELECT * 
FROM invoice_meta AS invoice
JOIN customers AS c ON custID = c.iD
JOIN states AS s ON c.stateID = s.stateID 
JOIN invoice_lines il ON invoice.ID = invoiceID
LEFT JOIN invoice_payments p ON invoiceID = p.invoice_id
LEFT JOIN invoice_notes notes ON notes.invoice_id = invoice.ID
LEFT JOIN products pr ON pr.partID = il.partID  LEFT JOIN invoice_taxes ON invoice.ID=taxedinvID
WHERE invoice.ID=%s", GetSQLValueString($voice_rs_invoice, "int")); 
$rs_invoice = mysql_query($query_rs_invoice, $dbcon) or die(mysql_error());
$row_rs_invoice = mysql_fetch_assoc($rs_invoice);
$totalRows_rs_invoice = "5";
if (isset($_REQUEST['recordID'])) {
  $totalRows_rs_invoice = $_REQUEST['recordID'];
}
list($year, $month, $day)=explode('-', $row_rs_invoice['dated']);
$dated="$month/$day/$year"; $row_rs_invoice['dated']; 
include_once('../../inc/curconfig.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<LINK rel="stylesheet" type"text/css"
     href="print.css" media="print">
<title>Invoice for
<?= "{$row_rs_invoice['fname']} {$row_rs_invoice['lname']} #$month$day$year-{$_REQUEST['recordID']}"; ?>
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
<div id="menu"><a href="invoices.php">Home</a> <a href="invoice_edit.php?recordID=<?= $_REQUEST['recordID']; ?>">Edit</a><a href="customer_invoices.php?cid=<?=$row_rs_invoice['custID']; ?>"> Resend/Apply Payment</a></div>
<div id="pagecontainer">
  <div id="header">Invoice</div>
  <div id="caddress">
    <?= $companyname; ?>
  </div>
  <div id="logo"><a href="http://daonlinebiz.com"><img src="http://www.daonlinebiz.com/images/dalogo.gif" alt="DaOnlinebiz.com Business in Perspective" /></a></div>
  <div class="clear">
  <div  id="compadd">CustomerID: <? echo str_pad($row_rs_invoice['custID'], 4, '0', STR_PAD_LEFT);
	if(!is_null($row_rs_invoice['company'])){ echo "B <br />"; $showcompany="<br />". $row_rs_invoice['company']; }else{ echo "C<br />"; } ?> <?php echo $row_rs_invoice['fname']; ?>
    <?php echo $row_rs_invoice['lname']; ?>
    <br /><? echo $row_rs_invoice['email']; ?>
    <?= $showcompany; ?>
    <br />
    <? echo $row_rs_invoice['address1']; ?>
    <? if(!is_null($row_rs_invoice['address2'])){ echo "<br />". $row_rs_invoice['address2']; } ?>
    <br />
    <?php echo $row_rs_invoice['city']; ?> <?php echo $row_rs_invoice['abrivation']; ?> <?php echo $row_rs_invoice['zipcode']; ?></div>
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

    <!-- Invoice detials !-->
    <div class="clear">
    <table id="items">
      <tr>
        <th>Item #</th>
        <th>Description</th>
        <th>Unit Cost</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
      <?php do {
		  $i=1;
		  $subtotal=$row_rs_invoice['price']*$row_rs_invoice['qty']; 
	   ?>
      <tr class="item-row">
        <td><? if($row_rs_invoice['partID'] == 0){ echo $row_rs_invoice['custID']."-".$row_rs_invoice['line_id']; $partnum=$row_rs_invoice['id']."-".$row_rs_invoice['line_id'];} 
		  else{ echo $row_rs_invoice['partID']; $partnum=$row_rs_invoice['partID']; } ?></td>
        <td><?php echo $row_rs_invoice['nonpartname']; ?><?php echo $row_rs_invoice['specifics']; ?><?php echo $row_rs_invoice['product']; ?></td>
        <td><?php echo $row_rs_invoice['price']; ?></td>
        <td><?php echo $row_rs_invoice['qty']; ?></td>
        <td><?= money_format('$ %i', $subtotal); ?>  <? if($row_invoice['type']=='product'){ echo "+"; $taxable=$taxable+$subtotal; } ?></td>
      </tr>
      <?
	  $notes=$row_rs_invoice['Note']."<br />";
} while ($row_rs_invoice = mysql_fetch_assoc($rs_invoice)); ?>
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
        <td colspan="2" rowspan="7"><?= $notes; ?></td>
        <td colspan="2" class="total-line">Discount:</td>
        <td class="total-value">&nbsp;
         </td>
      </tr>
      <tr>
       <td colspan="2" class="total-line">Tax:</td>
       <td class="total-line"><?= $taxable; ?></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line">Total:</td>
        <td class="total-value" id="total"><? if($taxable > 0 ){echo money_format('%i', $row_rs_invoice['inTotal'] * $taxable); }
			   else{ echo $total; } 
			?></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line">Payment Type:</td>
        <td class="total-value"><select name="paymenttype" size="1">
            <option value="Cash">Cash</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Check">Check</option>
          </select></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line">Amount Paid:</td>
        <td class="total-value"><?= money_format('%i', $totalpayment); ?></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line balance">Balance Due</td>
        <td><span class="total-value balance">
          <?= $total; ?>
        </span></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line balance">Pay by Credit Card:
        <!-- Google Check Out: <?=$checkoutfrm; ?>  <input type="hidden" name="_charset_"/><input type="image" name="Google Checkout" alt="Fast checkout through Google"
src="http://checkout.google.com/buttons/checkout.gif?merchant_id=741888562733894&w=180&h=46&style=white&variant=text&loc=en_US"
height="46" width="180"/>--></td>
        <td><a href="http://daonlinebiz.com/paypalinv.php?invoice=<?= $_REQUEST['recordID']; ?>"><img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" alt="Pay via Paypal" style="margin-right:7px; border:none;" /></a></td>
      </tr>
    </table>
  </form>
  </form>
</div>
<!-- Itemize -->
<div class="clear"></div>
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