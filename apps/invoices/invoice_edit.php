<?php require_once('../../Connections/dbcon.php'); ?>
<?php
mysql_select_db($database_dbcon, $dbcon);
if(isset($_POST['applychng'])){
	include_once('../../inc/functions.php');
	if(isset($_POST['delete'])){
		foreach($_POST['delete'] as $key=>$value){
			if(mysql_query("DELETE FROM invoice_lines WHERE line_id=$key")){
				$msg[]="Item Delete";
			}
		}
	}
	if(isset($_POST['price'])){ 
	    foreach($_POST['price'] as $key=>$value){
			if(mysql_query("UPDATE invoice_lines SET price=$value WHERE line_id=$key")){
				$msg[]="Item Updated";
				mysql_query("UPDATE invoice_meta SET inTotal=(SELECT sum(price) FROM invoice_lines WHERE invoiceID={$_POST['invoiceID']} GROUP by invoiceID) 
					WHERE ID={$_POST['invoiceID']}");
			}
		}
	}
	if(isset($_POST['noted'])){
		$sql="INSERT INTO invoice_notes (invoice_id, Note) VALUES ({$_POST['invoiceID']}, '{$_POST['noted']}') ON DUPLICATE KEY UPDATE Note='{$_POST['noted']}'";
		//if It already exists update the table;
		
		if(mysql_query($sql)){$msg[]="Notes Added"; }
	}
	if(isset($_POST['discount']) && !empty($_POST['discount'])){
		$sql="UPDATE invoice_meta SET discount={$_POST['discount']} && dtype='{$_POST['dtype']}'";
	}
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

$voice_rs_invoice = "5";
if (isset($_REQUEST['recordID'])) {
  $voice_rs_invoice = $_REQUEST['recordID'];
}

$query_rs_invoice = sprintf("SELECT * 
FROM invoice_meta AS invoice
JOIN customers AS c ON custID = c.iD
JOIN states AS s ON c.stateID = s.stateID 
JOIN invoice_lines il ON invoice.ID = invoiceID
LEFT JOIN invoice_payments p ON invoiceID = p.invoice_id
LEFT JOIN invoice_notes notes ON notes.invoice_id = invoice.ID
LEFT JOIN products pr ON pr.partID = il.partID
WHERE invoice.ID=%s", GetSQLValueString($voice_rs_invoice, "int")); 
$rs_invoice = mysql_query($query_rs_invoice, $dbcon) or die(mysql_error());
$row_rs_invoice = mysql_fetch_assoc($rs_invoice);
$totalRows_rs_invoice = "5";
if (isset($_REQUEST['recordID'])) {
  $totalRows_rs_invoice = $_REQUEST['recordID'];
}
list($year, $month, $day)=explode('-', $row_rs_invoice['dated']);
$dated="$month/$day/$year"; 
include_once('../../inc/curconfig.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
    <br />Email: <?= $row_rs_invoice['email']; ?><br />
    <? echo $row_rs_invoice['address1']; ?><br />
    <? if(!is_null($row_rs_invoice['address2'])){ echo $row_rs_invoice['address2']."<br />"; } ?>
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
    <form id="frmEditInvoice" name="frmEditInvoice" method="post" action="">
    <table id="items">
      <tr>
        <th>Del</th>
        <th>Item #</th>
        <th>Description</th>
        <th>Unit Cost</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
      <?php do { $i=1; ?>
      <tr class="item-row">
        <td><input type="checkbox" name="delete[<?= $row_rs_invoice['line_id']; ?>]" value="1" />
        <td><? if($row_rs_invoice['partID'] == 0){ echo $row_rs_invoice['custID']."-".$row_rs_invoice['line_id']; $partnum=$row_rs_invoice['id']."-".$row_rs_invoice['line_id'];} 
		  else{ echo $row_rs_invoice['partID']; $partnum=$row_rs_invoice['partID']; } ?></td>
        <td><?php echo $row_rs_invoice['nonpartname']; ?><?php echo $row_rs_invoice['specifics']; ?><?php echo $row_rs_invoice['product']; ?></td>
        <td><?php echo $row_rs_invoice['price']; ?></td>
        <td><?php echo $row_rs_invoice['qty']; ?></td>
        <td>
          $<input name="price[<?=$row_rs_invoice['line_id']; ?>]" type="text" id="price[<?= $row_rs_invoice['partID']; ?>]" size="5" maxlength="20" value="<?=$row_rs_invoice['price']; ?>" /> <? if($row_rs_invoice['type']=='product' || !is_null($row_rs_invoice['taxable'])){ echo "+"; $taxable=$taxable+$subtotal; } ?>
        </td>
      </tr>
      <?
		  	if(!is_null($row_rs_invoice['Note'])){$note.=$row_rs_invoice['Note'];}
		  	if(!is_null($row_rs_invoice['payment'])){ $payment[$row_rs_invoice['id']]=$row_rs_invoice['lastmodified'];} 
			$totalpayments=$totalpayment+$row_rs_invoice['payment'];
			//Add Rows for payments if they've been made for rows
 $i++;
} while ($row_rs_invoice = mysql_fetch_assoc($rs_invoice)); ?>
      <tr>
        <td colspan="3" rowspan="7"><span class="blank">
          <label for="noted">Note:</label>
          <textarea name="noted" cols="25" rows="4" id="noted"><?= $note; ?></textarea>
        </span></td>
        <td colspan="2" class="total-line">Discount:</td>
        <td class="total-value"><input name="discount" type="text" id="discount" size="2" maxlength="10" />
          <select name="dtype" id="dtype">
            <option value="%">%</option>
            <option value="$">$</option>
          </select></td>
      </tr>
      <tr>
       <td colspan="2" class="total-line">Tax:</td>
       <td class="total-line"><?= money_format('%i', $taxable * .06); ?>
         <input name="invoiceID" type="hidden" id="invoiceID" value="<?= $_REQUEST['recordID']; ?>" /></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line">Total:</td>
        <td class="total-value" id="total">
            <? if($taxable > 0 ){echo money_format('%i', $row_rs_invoice['inTotal'] * $taxable); }
			   else{ echo $total; } 
			?>
         </td>
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
        <td class="total-value">$
          <input name="amount" type="text" id="paid" value="<?= $totalpayment; ?>" size="10" maxlength="8" /></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line balance">Balance Due:</td>
        <td class="total-value balance"><?= $total; ?></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line balance">Apply Changes:</td>
        <td><input type="submit" name="applychng" id="applychng" value="Apply" /></td>
      </tr>
    </table>
  </form>
</div>
<!-- Itemize -->
<div class="clear"> Pay by Credit Card: <a href="http://daonlinebiz.com/paypalinv.php?invoice=<?= $_REQUEST['recordID']; ?>"><img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" alt="Pay via Paypal" style="margin-right:7px; border:none;"></a> 
</div>
</div>
<div id="footer"></div>
</body>
</html>
<?php
mysql_free_result($rs_invoice);

?>

</body>
</html>