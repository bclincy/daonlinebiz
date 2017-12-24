<?
if(!function_exists('reposted')){
function reposted($fieldname){
   if(isset($_REQUEST[$fieldname])){ return $_REQUEST[$fieldname]; }
   return false;
}
function error ($msg, $serious = '') {

	// if the page has already been set up, just show a small header
	if (isset($set_up)) {
		echo "<H2>Whoops</H2>";

	// otherwise set up the page to show that an error has occured
	} else {
		start_page ("Error", "Whoops");
	}
	echo "<p>Sorry. There has been an error (".$msg.").<BR><br>";

	// if 'serious' is true (the second argument passed in a call to this function)
	// then the user must return all the way to the site entrance
	if ($serious != '') {
		echo "<A HREF='index.php'>Please click here to return to the site entrance.</A>";

	// if its not a 'serious' error then the user has to go to the main thread listing page
	} else {
		echo "<A HREF='index.php'>Please click here to return to the main page.</A>";
	}

	// show a link to mail the technical help
	echo "<BR><BR><A HREF='mailto:webmaster@". serverNameformat()."?subject=$msg'>Click here to inform
		our technical staff of this problem.</A></p>";
	exit;
}

function serverNameFormat(){
  return preg_replace('/^w{3}\./', '', $_SERVER['HTTP_HOST']);
}
function start_page ($title){
 	echo "
	<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
        <link href=\"standard.css\" rel=\"stylesheet\" type=\"text/css\"> 		
		<TITLE>".$title."</TITLE>
		<script language=\"javascript1.2\" src=\"../inc/functions.js\"></script>
		</head>";

	// set up a global variable to show that the page has been set up
	global $set_up;
	$set_up = TRUE;
 }		

function themaybes($question){ 
//Send array of possible inserts, where the field name and the db name are the same. The function will allow you to add two sides of the sql statement INSERT and values
	foreach($question as $value){
	  if(!empty($_POST[$value])){ 
	    $include.=", $value ";
		if(is_numeric($_POST[$value])){ $data.=", {$_POST[$value]} ";}
		else{  $data.=", '{$_POST[$value]}' "; }
	  }
	}
	$returns['include'] = lastcomas($include);
	$returns['value'] = lastcomas($data);
	return $returns;
}
function lastcomas($str){ 
  return preg_replace('/,\s*$/i','', $str);
} 
function stateSelect($selected = null) {
	$results = mysql_query("SELECT * FROM states ORDER BY state");
     $display = "<select name=\"stateID\" id=\"stateID\">\n";
	While($records = mysql_fetch_assoc($results)){
	  if($records["stateID"] == 27 && $select == NULL) { $display .= "<option value=\"" . $records["stateID"] . "\" selected > ". $records["state"] . "</option>\n"; }
	  elseif($records["stateID"] == $select) {$display .= "<option value=\"" . $records["stateID"] . "\" selected > ". $records["state"] . "</option>\n"; }
	  else {$display .= "<option value=\"" . $records["stateID"] . "\">". $records["state"] . "</option>\n"; }
    }
	$display .="</select>";
	mysql_free_result($results);
	return $display;
}
}
function grabstate($stateID=27, $field='abrivation'){
	$results=mysql_query("SELECT $field FROM states WHERE stateID=$stateID");
	$record=mysql_fetch_assoc($results);
	return  $record[$field];
}
function deleteinvoice($id){
	$sql = "DELETE il.*, invoiced.*, notes.*, p.* FROM invoice_meta AS invoiced JOIN users AS c ON custID = userID JOIN invoice_lines il ON invoiced.ID = invoiceID LEFT JOIN invoice_payments p ON invoiceID = p.invoice_id LEFT JOIN invoice_notes notes ON notes.invoice_id = invoiced.ID LEFT JOIN products pr ON pr.partID = il.partID WHERE invoiced.ID= $id";
	if(mysql_query($sql)){ return true; }
	else{ return false; }
}
function addpayment($invoice_id, $amount, $ptype){
	//first check to see if the same payment has been posted with a refresh
	$results=mysql_query("SELECT * FROM invoice_payments WHERE invoice_id=$invoice_id && payment=$amount");
	if(mysql_num_rows($results)>0){ return; }
	$sql="INSERT INTO invoice_payments (invoice_id, lastmodified, payment, type) VALUES ($invoice_id, now(), $amount, '$ptype')";
	if(mysql_query($sql)){ return true; }
	return false;
} 
function sendInvoice($invoiceID, $show=false){
	$servdir=dirname($_SERVER['PHP_SELF']);
	if($servdir == '/controls'){ $url=realpath('../controls/invoices/').'/invoiceTemplate.php'; }
	else{$url = "invoiceTemplate.php"; }
	$str = file_get_contents($url, true);
	$results=mysql_query("SELECT * FROM invoices WHERE ID=$invoiceID"); 
	$rows=mysql_fetch_assoc($results);
	$name="{$rows['fname']} {$rows['lname']}";
	$email=$rows['email'];
	$total=$rows['inTotal']+$rows['taxed'];
	$taxation=" {$rows['Location']} {$rows['rate']}%"; $taxrate=$rows['rate'] *.01;
	$tax=$rows['taxed']; $paymethod=$rows['paytype']; $dbtotal=$rows['intotal']; 
	#$balance=$rows['inTotal'] + $rows['taxed'] - $rows['payment'];//problem with this is if they made multiple payments this won't be accurate
	list($year, $month, $day) =explode('-', $rows['dated']);
	$innum=$month.$day.$year."-$invoiceID-{$rows['custID']}";
	if(!is_null($rows['company'])){ $customerdata="CustomerID: ". str_pad($rows['custID'], 4, '0', STR_PAD_LEFT)."B <br />"; $showcompany=$rows['company']."<br />"; }
	if(!is_null($rows['address2'])){ $address2="<br />{$rows['address2']}<br />"; }
	else{$customerdata= "CustomerID: ".str_pad($rows['custID'], 4, '0', STR_PAD_LEFT)."C\n<br />"; }
	$customerdata.="$name <br />Username/Email: {$rows['email']} <br />";
	if(isset($showcompany)){ $customerdata.="$showcompany"; }
	$customerdata.=" {$rows['address']} <br />$address2 {$rows['city']} {$rows['abrivation']} {$rows['zipcode']}<br />Phone: {$rows['phone']}";
	#if($rows['dtype']=='%'){
	list($header, $footer)= explode('*PART*', $str);
	do { 
		$subtotal=$rows['inprice']*$rows['inqty']; 
		$indata.="<tr class=\"item-row\">
          <td>{$rows['pID']}</td>
          <td>{$rows['nonpartname']}{$rows['product']}</td>
          <td>{$rows['inprice']}</td>
          <td>{$rows['inqty']}</td>
          <td>".money_format('$ %i',$subtotal);
       if($rows['ptype']=='product' || $rows['taxable']==1){
				//Add the T for taxable
				$indata.= " t"; 
			}
			
		  $indata.="</td>\n
       </tr>\n"; 
		if(!is_null($rows['Note'])){$noted.=$rows['Note']."<br />";}
		if($rows['ptype'] !='service' && !is_null($rows['ptype'])){$taxed=$taxed+$subtotal; }
		elseif($rows['taxable']==1){$taxed=$taxed+$subtotal; }//Gives me Taxed amount
		if(!is_null($rows['payment'])){ $payment[$rows['pay_id']]=$rows['payment'];} //made an array with only unique payments Just Replaces
		$realtotal=$realtotal+$subtotal;
	}while ($rows =mysql_fetch_assoc($results));
	$discount=$realtotal - ($total - $tax);//The only way real total and discounted total would be a difference is if a realtotal doesn't equal intotal
	if(!is_numeric($totalpayments)){$totalpayments=0;  }
	$totaltax=$taxed*$taxrate;
	if(is_array($payment)){$payment=array_sum($payment);} else{ $payment=0; }
	$balance=$realtotal+$totaltax-$payment;
	$replacements = array(
					 'subtotal'=>money_format('$ %i', $realtotal),
					 'total'=>money_format('$ %i', $total),
					 'date'=>"$month/$day/$year",
					 'invoiceid'=>$innum,
					 'invoicenum'=>$_SESSION['invoiceID'],
					 'customerdata'=>$customerdata,
					 'company'=>$company, 
					 'dated'=>"$month-$day-$year",
					 'customer'=>$name,
					 'discount'=>money_format('- $ %i',$discount),
					 'paid'=>money_format('$ %i', $payment),
					 'paymenthod'=>$paymethod,
					 'balance'=>money_format('$ %i',$balance),
					 'taxes'=>money_format('$ %i',$tax),
					 'notes'=>$noted,
					 'invoice#'=>$invoiceID,
					 'rate'=>$taxation
	);
	$mesg="<div>Having trouble you can <a href=\"http://usaofficialsassn.com/login.php\">login</a> and click view receipts tag</div>";
	$mesg.=invoicetemplate($header, $replacements);
	$mesg.= $indata;
	$mesg.= invoicetemplate($footer, $replacements);
	if($show){ return $mesg; }
	mailinvoice($name,$email, $mesg, "$month/$day/$year # $invoiceID");
}
function invoicetemplate($str, $data){ 
  foreach($data as $key => $value){ 
     $str = preg_replace("/\[$key\]/i", $value, $str);  
  }
  return  $str;
  
}
function mailinvoice($name, $email, $message, $invoice){
			// To send HTML mail, the Content-type header must be set
	$to = "$name <$email>"; 	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$subject="USA Official Association Receipt";
	// Additional headers
	$headers .= "From: USA Officials Association <info@usaofficialsassn.com>\r\n";
	$headers .= 'BCC: bclincy@gmail.com' . "\r\n";
  if(mail($to, $subject, $message, $headers)){ 
  	return true;
  }
  else{	 error('Problem Registering', "There were a registration"); }
}

function getCurrentDirectory() {
	$path = dirname($_SERVER['PHP_SELF']);
	$position = strrpos($path,'/') + 1;
	return substr($path,$position);
}
function mkcustomers($userID){
	$sql="INSERT INTO customers (fname, lname, email, address1, address2, city, stateID, zipcode, phone, fax) 
	SELECT fname, lname, email, address, address2, city, stateID, zipcode, phone, faxFROM users WHERE userID=$userID";
	$results=mysql_query($sql); 
	if($results){ $insertID=mysql_insert_id(); if($insertID>0){ return $insertID; }
	else{ return 0; }
	}
}
function createinvoice($custID=NULL, $items){
	// Make sure it's a customers
	$insert="INSERT INTO invoice_meta (custID, dated) VALUES ($custID, now())";
	
	foreach($item as $value){
		$sql[]="INSERT INTO ";
	}
}
function viewsql(){
	$sql = "CREATE VIEW invoices AS SELECT  n.ID AS invoiceID, inTotal, discount, dtype, L.partID AS partID, nonpartname, specifics, qty, L.price, fname, lname, company, email, address1, address2, city, state, zipcode, phone, fax, rate, taxed, Location, Note, payment, pay.type as pay_type, pay.lastmodified as pay_date 
FROM invoice_meta AS n
JOIN invoice_lines AS L ON n.ID = invoiceID
JOIN customers AS c ON custID = c.ID
JOIN states AS s ON c.stateID = s.stateID
LEFT JOIN products AS p ON p.partID = L.partID
LEFT JOIN invoice_notes inote ON inote.invoice_id = invoiceID
LEFT JOIN invoice_taxes ON invoiceID = taxedinvID
LEFT JOIN invoice_payments pay ON invoiceID=pay.invoice_id";
	
}

?>