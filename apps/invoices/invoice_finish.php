<?php require_once('../../Connections/dbcon.php'); ?>
<?php
include_once('cart.php');
$cart =& $_SESSION['mycart']; // point $cart to session cart.
if(!is_object($cart)) $cart = new wfCart();
$carts=array($cart->get_contents());
mysql_select_db($database_dbcon, $dbcon);
include_once('lib.php');
if($cart->itemcount > 0) {
	if(mysql_query("INSERT INTO invoice_meta (custID, dated, inTotal) VALUES ( {$_SESSION['customerID']}, now(), ". $cart->total .")")){
		$insertid=mysql_insert_id();
		foreach($cart->get_contents() as $item) {
			if($item['id']>4000 && $item['id']< 4100){
				if(isset($_POST['taxable'][$item['id']]) &&  $_POST['taxable'][$item['id']]>0 ){
					$taxing=", 1"; //add the tax to the line total
					$taxed=$taxed+($item['subtotal']*.06); 
				}
				$i=rand(1,100);
				$item['id']=$insertid+$i; //database non relational DB
				list($productname, $details)=explode('//', $item['info']);
				$productname="'$productname'"; $details="'$details'";// gives me detials of none products
			}
			else{ $productname='NULL'; $details='NULL';  }
			if(!isset($taxing)){ $taxing=", NULL"; }	
			mysql_query("INSERT INTO invoice_lines (invoiceID, partID, nonpartname, specifics, qty, price, taxable) VALUES 
			( $insertid, {$item['id']}, $productname, $details, {$item['qty']}, {$item['price']} $taxing)"); 
			unset($taxing);
			}//Insert INTO db
			$i++;
		}//end foreach
		if(isset($taxed)){ mysql_query("INSERT INTO invoice_taxes VALUES ($insertid, 6, $taxed, now(), 'MI')"); }	
	 $cart->empty_cart();
	 $_SESSION['invoiceID']=$insertid; 
}

if(isset($_POST['sendInvoice'])){
	if(isset($_POST['discount'])){
		if(!empty($_POST['discount']) && $_POST['dtype']=='%'){$total= $_POST['total'] * (100 - $_POST['discount'])*.01; }
		else{ $total= $_POST['total'] - $_POST['discount']; }
		mysql_query("UPDATE invoice_meta SET Discount={$_POST['discount']}, dtype='{$_POST['dtype']}', inTotal=$total WHERE ID={$_SESSION['invoiceID']}");
		//This is where the line totals will not add up with the intotal but if you add the discounted amount to the total it will balance.
	}
	#foreach($_POST as $key=>$value){ echo "$key => $value <br />"; }
	if($_POST['amount'] > 0){//
		addpayment($_SESSION['invoiceID'], $_POST['amount'], $_POST['paymenttype']);
	}
	if(!empty($_POST['Notes']) ){ 
		mysql_query("INSERT INTO invoice_notes (invoice_id, Note) VALUES ({$_SESSION['invoiceID']}, '{$_POST['Notes']}')"); 
	}
	sendInvoice($_SESSION['invoiceID']);
	header('Location: http://daonlinebiz.com/apps/invoices/invoice_show.php?recordID='.$_SESSION['invoiceID']);
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
?>
<?php
$recordID_invoice = "10";
if (isset($insertid)) {
  $recordID_invoice = $insertid;
}
elseif(isset($_SESSION['invoiceID'])){ $recordID_invoice=$_SESSION['invoiceID']; }
$query_invoice = sprintf("SELECT * FROM invoice_meta AS invoice JOIN customers AS c ON custID = c.iD JOIN states AS s ON c.stateID = s.stateID  JOIN invoice_lines il ON invoice.ID = invoiceID LEFT JOIN invoice_payments p ON invoiceID = p.invoice_id LEFT JOIN invoice_notes notes ON notes.invoice_id = invoice.ID LEFT JOIN products pr ON pr.partID = il.partID LEFT JOIN invoice_taxes ON invoice.ID=taxedinvID WHERE invoice.ID=%s", GetSQLValueString($recordID_invoice, "int"));
$invoice = mysql_query($query_invoice, $dbcon) or die(mysql_error());
$row_invoice = mysql_fetch_assoc($invoice);
$totalRows_invoice = mysql_num_rows($invoice);

list($year, $month, $day)= explode('-', $row_invoice['dated']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Invoice #<?= $_SESSION['invoiceID']; ?> was Created!</title>
<link href="instd.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="pagecontainer">
  <div>Invoice was Created Home: Edit New Customers</div>
  <div id="header">Invoice</div>
  <div id="caddress">
    <?= $companyname; ?>
  </div>
  <div id="logo"><a href="http://daonlinebiz.com"><img src="http://www.daonlinebiz.com/images/dalogo.gif" alt="DaOnlinebiz.com Business in Perspective" /></a></div>
  <div class="clear">
  <div  id="compadd">CustomerID: <? echo str_pad($row_invoice['custID'], 4, '0', STR_PAD_LEFT);
	if(!is_null($row_rs_invoice['company'])){ echo "B <br />"; $showcompany="<br />". $row_invoice['company']; }else{ echo "C<br />"; } ?> <?php echo $row_invoice['fname']; ?> <?php echo $row_invoice['lname']."<br />"; ?>
 <?= $showcompany; ?>
<?php echo $row_invoice['address1']. "<br />"; ?>
<? if(isset($row_invoice['address2'])){ echo $row_invoice['address2']."<br />"; } ?>
    <?php echo $row_invoice['city']; ?> <?php echo $row_invoice['abrivation']; ?>  <?php echo $row_invoice['zipcode']; ?></div>
  <div id="invoicedetails">
    <table id="meta">
      <tr>
        <td class="meta-head">Invoice #</td>
        <td class="data"><?= "$month$day$year-{$_SESSION['invoiceID']}-{$row_invoice['custID']}"; ?></td>
      </tr>
      <tr>
        <td class="meta-head">Date</td>
        <td class="data"><?= "$month/$day/$year"; ?></td>
      </tr>
      <tr>
        <td class="meta-head">Amount Due</td>
        <td class="data"><? $total=money_format('$ %i', $row_invoice['inTotal']+$row_invoice['taxed']); echo $total;?></td>
      </tr>
    </table>
    </div>
    </div>
   
    <!-- Invoice details !-->
    <div class="clear">
    <form id="frmSendemail" name="frmSendemail" method="post" action="invoice_finish.php">
    <table id="items">
      <tr>
        <th>Item #</th>
        <th>Description</th>
        <th>Unit Cost</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
   
        <?php do {
			$subtotal=$row_invoice['price']*$row_invoice['qty']; 
		?><tr class="item-row">
          <td><?php echo $row_invoice['partID']; ?><? echo $row_invoice['il.partID']; ?></td>
          <td><?php echo $row_invoice['nonpartname']; ?><?php echo $row_invoice['product']; ?></td>
          <td><?php echo $row_invoice['price']; ?></td>
          <td><?php echo $row_invoice['qty']; ?></td>
          <td>
            <?= money_format('$ %i',$subtotal); ?>
            <? if($row_invoice['ptype']=='product' || $row_invoice['taxable']==1){
				//Add the T for taxable
				echo " T"; 
			}?>
          </td>
       </tr>
          <?php 
		  	if(!is_null($row_invoice['Note'])){$note[$row_invoice['id']]=$row_invoice['Note'];}
		  	if(!is_null($row_invoice['payment'])){ $payment[$row_invoice['id']]=$row_invoice['lastmodified'];} 
			$totalpayments=$totalpayment+$row_invoice['payment'];
			$totalamount=$totalamount+$subtotal;
			$discount=$row_invoice['discount']; $disrate=$row_invoice['dtype']; $taxamount=$row_invoice['taxed'];
			
			//Add Rows for payments if they've been made for rows
		  } while ($row_invoice = mysql_fetch_assoc($invoice)); ?>

        <tr>
          <td colspan="2" rowspan="8" class="blank"><? 
		if(is_array($note)){
			foreach($row_invoice['Note'] as $value){
				echo "<p>$value</p>";  
			}
		}
		?>
            <label for="Notes">Notes:</label>
          <input name="Notes" type="text" id="Notes" value="<?= $_POST['Notes']; ?>" /></td>
            <td colspan="2" class="total-line">SubTotal:</td>
            <td align="center" class="total-value"><?= money_format('$ %i', $totalamount); ?></td>
        </tr>
        <tr>
        <td colspan="2" class="total-line">Discount:<span class="total-value">
          <input name="discount" type="text" id="discount" value="<?= $row_invoice['discount']; ?>" size="2" maxlength="10" />
          <select name="dtype" id="dtype">
            <option value="%">%</option>
            <option value="$">$</option>
          </select>
        </span></td>
        <td align="center" class="total-value">
        -<? if($discount> 0){ 
				if($disrate=='%'){
					$discounted=$totalamount*$discount*.01;
				}
				else{$discounted=$totalamount - $discount; }
		}
				echo $discounted;
?>        </td>
      </tr>
      <tr>
      <td class="total-line" colspan="2">Taxed at <?= "$taxrate % $taxlocation"; ?>:</td>
      <td align="center"> <?=money_format('$ %i', $taxamount); ?>
        <input name="taxes" type="hidden" id="taxes" value="<?= $taxable; ?>" /></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line">Total:</td>
        <td align="center" class="total-value"><div id="total">
            <? if($taxable > 0 ){echo money_format('%i', $row_rs_invoice['inTotal'] + $taxamount); }
			   else{ echo $total; } 
			?>
            <span class="total-line">
            <input name="invoiceID" type="hidden" id="invoiceID" value="<?= $_SESSION['invoiceID']; ?>" />
          </span>
            <input name="total" type="hidden" id="total" value="<?= $totalamount; ?>" />
        </div></td>
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
        <td colspan="2" class="total-line">Amount Paid</td>
        <td class="total-value">$
          <input name="amount" type="text" id="amount" value="<?= money_format('%i',$totalpayments); ?>" size="10" maxlength="8" /></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line balance">Balance Due</td>
        <td align="center" class="total-value balance"><?= $total; ?></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line balance">Save Changes:</td>
        <td><input type="submit" name="sendInvoice" id="sendInvoice" value="Send Email" /></td>
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
mysql_free_result($invoice);

function strtovar ($str, $data){ 
  foreach($data as $key => $value){ 
     $str = preg_replace("/\[$key\]/i", $value, $str);  
  }
  return  $str;
  
}

?>
