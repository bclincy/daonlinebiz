<?php require_once('../../Connections/dbcon.php'); ?>
<?php
include_once('cart.php');
$cart =& $_SESSION['mycart']; // point $cart to session cart.
if(!is_object($cart)) $cart = new wfCart();
$carts=array($cart->get_contents());
mysql_select_db($database_dbcon, $dbcon);
if($cart->itemcount > 0) {
	if(mysql_query("INSERT INTO invoice_meta (custID, dated, inTotal) VALUES ({$_SESSION['customerID']}, now(), ". $cart->total .")")){
		$insertid=mysql_insert_id();
		foreach($cart->get_contents() as $item) {
			if(preg_match('/\-/', $item['id'])){
				$item['id']=0; //database non relational DB
				list($productname, $details)=explode('->', $item['info']);
				$productname="'$productname'"; $details="'$details'";// gives me detials of none products
			}
			else{ $productname='NULL'; $details='NULL'; }
			mysql_query("INSERT INTO invoice_lines (invoiceID, partID, nonpartname, specifics, qty, price) VALUES 
				($insertid, {$item['id']}, $productname, $details, {$item['qty']}, {$item['price']})");
			}//Insert INTO db
		}//end foreach		
	 $cart->empty_cart();
	 $_SESSION['invoiceID']=$insertid; 
}
if(isset($_POST['sendInvoice'])){ 
	$url = "invoiceTemplate.php";
	$str = file_get_contents($url, true);
	$results=mysql_query("SELECT * FROM invoices WHERE ID={$_SESSION['invoiceID']}");
	$nresults=$results;
	$rows=mysql_fetch_assoc($results);
	list($year, $month, $day) =explode('-', $rows['dated']);
	$innum=$month.$day.$year."-{$_SESSION['invoiceID']}-{$rows['custID']}";
	if(!is_null($rows['company'])){ $customerdata="CustomerID: ". str_pad($rows['custID'], 4, '0', STR_PAD_LEFT)."B <br />"; $showcompany=$rows['company']."<br />"; }
	if(!is_null($rows['address2'])){ $address2="<br />{$rows['address2']}<br />"; }
	else{$customerdata= "CustomerID: ".str_pad($rows['custID'], 4, '0', STR_PAD_LEFT)."C\n<br />"; }
	$customerdata.="{$rows['fname']} {$rows['lname']}<br />Username/Email: {$rows['email']}<br /> $showcompany {$rows['address1']}<br /> $address2 {$rows['city']} ".
	"{$rows['abrivation']} {$rows['zipcode']}<br />Phone: {$rows['phone']}";
	list($header, $footer)= explode('*PART*', $str);
	
	$replacments = array(
					 'total'=>$rows['inTotal'],
					 'date'=>"$month/$day/$year",
					 'invoiceid'=>$innum,
					 'invoicenum'=>$_SESSION['invoiceID'],
					 'customerdata'=>$customerdata,
					 'company'=>$company, 
					 'dated'=>"$month-$day-$year",
					 'customer'=>"{$rows['fname']} {$rows['lname']}",
					 					 
	);  
	echo strtovar($header, $replacments);
	 
		  echo dataset(1);
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
$query_invoice = sprintf("SELECT * FROM invoice_meta AS invoice JOIN customers AS c ON custID = c.iD JOIN states AS s ON c.stateID = s.stateID  JOIN invoice_lines il ON invoice.ID = invoiceID LEFT JOIN invoice_payments p ON invoiceID = p.invoice_id LEFT JOIN invoice_notes notes ON notes.invoice_id = invoice.ID LEFT JOIN products pr ON pr.partID = il.partID WHERE invoice.ID=%s", GetSQLValueString($recordID_invoice, "int"));
$invoice = mysql_query($query_invoice, $dbcon) or die(mysql_error());
$row_invoice = mysql_fetch_assoc($invoice);
$totalRows_invoice = mysql_num_rows($invoice);

list($year, $month, $day)= explode('-', $row_invoice['dated']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Invoice # <?= $insertid; ?> was Created</title>
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
<? if(!is_null($row_invoice['address2'])){ echo $row_invoice['address2']."<br />"; } ?>
    <?php echo $row_invoice['city']; ?> <?php echo $row_invoice['abrivation']; ?> <?php echo $row_invoice['zipcode']; ?></div>
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
        <td class="data"><? $total=money_format('$ %i', $row_invoice['inTotal']); echo $total;?></td>
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
          <td><?php echo $row_invoice['partID']; ?></td>
          <td><?php echo $row_invoice['nonpartname']; ?><?php echo $row_invoice['product']; ?></td>
          <td><?php echo $row_invoice['price']; ?></td>
          <td><?php echo $row_invoice['qty']; ?></td>
          <td>
            <?= money_format('$ %i',$subtotal); ?>
          </td>
       </tr>
          <?php 
		  	if(!is_null($row_invoice['Note'])){$note[$row_invoice['id']]=$row_invoice['Note'];}
		  	if(!is_null($row_invoice['payment'])){ $payment[$row_invoice['id']]=$row_invoice['lastmodified'];} 
			$totalpayments=$totalpayment+$row_invoice['payment'];
			//Add Rows for payments if they've been made for rows
		  } while ($row_invoice = mysql_fetch_assoc($invoice)); ?>

      <tr>
        <td colspan="2" rowspan="7" class="blank"><? 
		if(is_array($note)){
			foreach($row_invoice['Note'] as $value){
				echo "<p>$value</p>";  
			}
		}
		?></td>
        <td colspan="2" class="total-line">Discount:</td>
        <td class="total-value"><input name="discount" type="text" id="discount" size="2" maxlength="10" />
          <select name="dtype" id="dtype">
            <option value="%">%</option>
            <option value="$">$</option>
          </select></td>
      </tr>
      <tr>
      <td colspan="2">Taxes:</td>
      <td><?= money_format('%i', $taxable * .06); ?>
        <input name="taxes" type="hidden" id="taxes" value="<?= $taxable; ?>" /></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line">Total:</td>
        <td class="total-value"><div id="total">
            <? if($taxable > 0 ){echo money_format('%i', $row_rs_invoice['inTotal'] * $taxable); }
			   else{ echo $total; } 
			?>
            <span class="total-line">
            <input name="invoiceID" type="hidden" id="invoiceID" value="<?= $_SESSION['invoiceID']; ?>" />
          </span></div></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line">Payment Type:</td>
        <td class="total-value"><?php echo $row_invoice['type']; ?></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line">Amount Paid</td>
        <td class="total-value">$
          <input name="amount" type="text" id="paid" value="<?= money_format('%i',$totalpayments); ?>" size="10" maxlength="8" /></td>
      </tr>
      <tr>
        <td colspan="2" class="total-line balance">Balance Due</td>
        <td class="total-value balance"><?= $total; ?></td>
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
function dataset($record=NULL){
	$sql = "SELECT il.partID, il.qty as inqty, nonpartname, product, il.price as inprice, Note, payment FROM invoice_meta AS invoice JOIN customers AS c ON custID = c.iD JOIN invoice_lines il ON invoice.ID = invoiceID LEFT JOIN invoice_payments p ON invoiceID = p.invoice_id LEFT JOIN invoice_notes notes ON notes.invoice_id = invoice.ID LEFT JOIN products pr ON pr.partID = il.partID WHERE invoice.ID={$_SESSION['invoiceID']} ";

	$new=mysql_query($sql);
	while($recset=mysql_fetch_assoc($new)) { 
		$subtotal=$recset['inprice']*$recset['inqty']; 
		$indata.="<tr class=\"item-row\">
          <td>{$recset['partID']}</td>
          <td>{$recset['nonpartname']}{$recset['product']}</td>
          <td>{$recset['inprice']}</td>
          <td>{$recset['inqty']}</td>
          <td>".money_format('$ %i',$subtotal)."</td>\n
       </tr>\n"; 
		if(!is_null($recset['Note'])){$note=$recset['Note']."<br />";}
		if(!is_null($recset['payment'])){ $payment=$payment+$recset['payment'];} 
			$totalpayments=$totalpayment+$recset['payment'];
			//Add Rows for payments if they've been made for rows
	}#while ($rows =mysql_fetch_assoc($results));
	return $indata;
}
?>
