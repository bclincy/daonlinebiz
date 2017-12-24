<?
/*  PHP Paypal IPN Integration Class Demonstration File
 *  4.16.2005 - Micah Carrick, email@micahcarrick.com
 *
 *  This file demonstrates the usage of paypal.class.php, a class designed  
 *  to aid in the interfacing between your website, paypal, and the instant
 *  payment notification (IPN) interface.  This single file serves as 4 
 *  virtual pages depending on the "action" varialble passed in the URL. It's
 *  the processing page which processes form data being submitted to paypal, it
 *  is the page paypal returns a user to upon success, it's the page paypal
 *  returns a user to upon canceling an order, and finally, it's the page that
 *  handles the IPN request from Paypal.
 *
 *  I tried to comment this file, aswell as the acutall class file, as well as
 *  I possibly could.  Please email me with questions, comments, and suggestions.
 *  See the header of paypal.class.php for additional resources and information.
*/

// Setup class
require_once('paypal.class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class
//$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
            
// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://'.$_SERVER['HTTP_HOST'].'/paypal.php';

include_once('inc/functions.php');
if(isset($_REQUEST['invoice'])){ 
  	if(!is_numeric($_REQUEST['invoice']) && stopinjection($_REQUEST['invoice'])){ error('Bad Request', 'Bad data'); } 
  	$sql="SELECT *
		FROM invoices
		WHERE ID={$_REQUEST['invoice']}";
  	$results=queryDB($sql);
	$records=mysql_fetch_assoc($results); 
  	if($results == 0 ){ error('Invoice don\'t exists', 'bad invoice'); }
	  	//$p->add_field('business', 'bclinc_1278881074_biz@daonlinebiz.com');
		$p->add_field('business', 'ceo@daonlinebiz.com');
      	$p->add_field('return', $this_script.'?action=success');
      	$p->add_field('cancel_return', $this_script."?action=cancel&id={$_REQUEST['invoice']}");
      	$p->add_field('notify_url', $this_script.'?action=ipn');
	  	$p->add_field('cmd', '_cart'); // you need this for multiple items
	  	$p->add_field('txn_type', 'cart'); // you need this for multiple items
		$p->add_field('upload', 1); 
		$p->add_field('currency_code', 'USD');
		$p->add_field('invoice',$_REQUEST['invoice']);
		$p->add_field('first_name', $records['fname']);
	  	$p->add_field('last_name', $records['lname']);
		$p->add_field('email', $records['email']);
		$p->add_field('address1', $records['address1']);
		if(!is_null($records['address2'])){ 
				$p->add_field('adddress2', $records['address2']);
		}
		$p->add_field('city', $records['city']);
		$p->add_field('state', $records['state']);
		$p->add_field('zip', $records['zipcode']); 
		$i=1;
		$total=$records['inTotal'];
		if($records['shipping'] >0){ $shipping=$records['shipping']; }
		if($records['taxed']>0 ){ $p->add_field('tax', $records['taxed']); $taxes=$records['taxed']; }
		$add2inv='Invoice Includes:';
	mysql_data_seek($results,0);
      	while($records= mysql_fetch_assoc($results)){
			//Instead of itemizing Paypal receipt I'm going to make it all one item the invoice with all details being that one cart item
			$add2inv.="[Line Item: {$records['inqty']} X ".addslashes($records['product']).addslashes($records['nonpartname'])."- {$records['inprice']}/per ] ";
			$payment=$payments+$records['payment'];
			$realtotal =($records['inprice']*$records['inqty'])+$realtotal;
		/*	if(is_null($records['nonpartname'])){ 
				$p->add_field("item_name_$i", addslashes($records['product']));
				$p->add_field("item_number_$i", $records['partID']);
				$p->add_field("amount_$i", $records['inprice']); 
		  	}
			else{ 
			    $p->add_field("item_name_$i", addslashes($records['nonpartname']));
				$p->add_field("item_number_$i", $records['pID']);
				$p->add_field("amount_$i", $records['inprice']);
			}
			$p->add_field("quantity_$i",$records['inqty']);
			$realtotal =$records['inprice']*$records['inqty']+$realtotal;*/
			$i++;
	  	}//End Records while*/
		// Add shipping if exists
		$discount=$realtotal-$total;
		$balance=$total+$taxes-$payment+$discount;
		if($payment>0){ $payment=money_format('$ %i', $payment); $add2inv.=" - [Payment of $payment]"; }
		$p->add_field("item_name_1", $add2inv);
		$p->add_field('item_number_1', $_REQUEST['invoice']);
		$p->add_field("amount_1", $balance);
		$p->add_field('quantity_1', 1);
		if(isset($shipping) && $shipping > 0){ $p->add_field('shipping', $shipping); }
		else{ $p->add_field('shipping', 0); }
		#mysql_data_seek($results,0);
		
      $p->submit_paypal_post();
	  //$p->dump_fields();
}
else{
      $p->add_field('business', 'bclinc_1278881074_biz@daonlinebiz.com');
      $p->add_field('return', $this_script.'?action=success&invoiceID='.$_REQUEST['invoice']);
      $p->add_field('cancel_return', $this_script.'?action=cancel');
      $p->add_field('notify_url', $this_script.'?action=ipn');
      $p->add_field('item_name', 'Paypal Test Transaction');
      $p->add_field('amount', '1.99');

/*	  $p->add_field('business', 'bclinc_1278881074_biz@daonlinebiz.com');
      $p->add_field('return', $this_script.'?action=success');
      $p->add_field('cancel_return', $this_script.'?action=cancel');
      $p->add_field('notify_url', $this_script.'?action=ipn');
      $p->add_field('item_name', 'Paypal Test Transaction');
      $p->add_field('amount', '1.99');
      $p->add_field('business', 'bclinc_1278881074_biz@daonlinebiz.com');
      $p->add_field('return', $this_script.'?action=success');
      $p->add_field('cancel_return', $this_script.'?action=cancel');
      $p->add_field('notify_url', $this_script.'?action=ipn');
      $p->add_field('item_name_1', 'Paypal Test Transaction');
	  $p->add_field('cmd', '_cart'); // you need this for multiple items
	  $p->add_field('txn_type', 'cart'); // you need this for multiple items
	  $p->add_field('currency_code', 'USD');

	  $p->add_field('amount_1', '1.99');
	  $p->add_field('item_name_2', 'War filed'); 
	  $p->add_field('amount_2', '2.35');
	  $p->add_field('last_name', 'Clincy');
	  $p->add_field('first_name', 'Brian');
	  //$p->add_field('address1', '338 Yuba St');
	 // $p->add_field('email', 'bclincy@daonlinebiz.com');

*/
      $p->submit_paypal_post(); // submit the fields to paypal
//      $p->dump_fields();      // for debugging, output a table of all the fields
}

?>	
