<?php

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
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];


// if there is not action variable, set the default action of 'process'
#if (empty($_GET['action'])) $_GET['action'] = 'process';  

switch ($_GET['action']) {
    
   case 'process':      // Process and order...

      // There should be no output at this point.  To process the POST data,
      // the submit_paypal_post() function will output all the HTML tags which
      // contains a FORM which is submited instantaneously using the BODY onload
      // attribute.  In other words, don't echo or printf anything when you're
      // going to be calling the submit_paypal_post() function.
 
      // This is where you would have your form validation  and all that jazz.
      // You would take your POST vars and load them into the class like below,
      // only using the POST values instead of constant string expressions.
 
      // For example, after ensureing all the POST variables from your custom
      // order form are valid, you might have:
      //
      // $p->add_field('first_name', $_POST['first_name']);
      // $p->add_field('last_name', $_POST['last_name']);
      
      $p->add_field('business', 'bclincy@daonlinebiz.com');
      $p->add_field('return', $this_script.'?action=success');
      $p->add_field('cancel_return', $this_script.'?action=cancel');
      $p->add_field('notify_url', $this_script.'?action=ipn');
      $p->add_field('item_name', 'Paypal Test Transaction');
      $p->add_field('amount', '1.99');

      $p->submit_paypal_post(); // submit the fields to paypal
      //$p->dump_fields();      // for debugging, output a table of all the fields
      break;
	  
   case 'success':      // Order was successful...
   
      // This is where you would probably want to thank the user for their order
      // or what have you.  The order information at this point is in POST 
      // variables.  However, you don't want to "process" the order until you
      // get validation from the IPN.  That's where you would have the code to
      // email an admin, update the database with payment status, activate a
      // membership, etc.  
 
      echo "<html><head><title>Success</title></head><body><h3>Thank you for your order.</h3>";
      foreach ($_POST as $key => $value) { echo "$key: $value<br>"; }
      echo "</body></html>";
      
      // You could also simply re-direct them to another page, or your own 
      // order status page which presents the user with the status of their
      // order based on a database (which can be modified with the IPN code 
      // below).
      
      break;
      
   case 'cancel':       // Order was canceled...

      // The order was canceled before being completed.
 
      include_once('pay-cancel.php');
      break;
   case 'invoice':
      //
	  echo "<h2>invoice should be here</h2>";
	break;
      
   case 'ipn':          // Paypal is calling page for IPN validation...
   
      // It's important to remember that paypal calling this script.  There
      // is no output here.  This is where you validate the IPN data and if it's
      // valid, update your database to signify that the user has payed.  If
      // you try and use an echo or printf function here it's not going to do you
      // a bit of good.  This is on the "backend".  That is why, by default, the
      // class logs all IPN data to a text file.
      if($_POST['payment_status']!='Completed'){
		  //send me an email with all the data so I can see what's up as well as customer saying payment was not complete
		incompletepayment();
	  }
		  
	   $subject = 'Instant Payment Notification - Recieved Payment';
 		$to="Brian Clincy <bcincy@gmail.com>";
		$from="{$_POST['first_name']} {$_POST['lname']} <{$_POST['payemail']}>";         
		$body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
        $body .= " at ".date('g:i A')."\n\nDetails:\n";
         
         foreach ($_REQUEST as $key => $value) { $body .= "\n$key: $value"; }
         mail($to, $subject, $body);
      if ($p->validate_ipn()) {
          
         // Payment has been recieved and IPN is verified.  This is where you
         // update your database to activate or process the order, or setup
         // the database with the user's order details, email an administrator,
         // etc.  You can access a slew of information via the ipn_data() array.
  
         // Check the paypal documentation for specifics on what information
         // is available in the IPN POST variables.  Basically, all the POST vars
         // which paypal sends, which we send back for validation, are now stored
         // in the ipn_data() array.
  
         // For this example, we'll just email ourselves ALL the data.
         $subject = 'Instant Payment Notification - Recieved Payment';
         $to = 'bclincy@gmail.com';    //  your email
         $body =  "An instant payment notification was successfully recieved\n";
         $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
         $body .= " at ".date('g:i A')."\n\nDetails:\n";
         
         foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
         mail($to, $subject, $body);
      }
      break;
 }     
function incompletepayment(){
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	// Additional headers
	$headers .= "To: {$_POST['first_name']} {$_POST['last_name']} <{$_POST['payer_email']}> \r\n";
	$headers .= 'From: Biling Department <info@daonlinebiz.com>' . "\r\n";
	$headers .= 'Bcc: Brian Clincy <bclincy@gmail.com>' . "\r\n";
	
	$email_body = <<<EOT
	<html>
<head>
  <title>Canceled Payment</title>
</head>
<body>
<p>Dear {CUSTOMER NAME},<br />

Thank you for purchasing {PRODUCT NAME}.</p>
<p>Payapl was not able to process your payment. We do not have any reasons why your payment was not process. If you should go and login to 
Paypal and they should give you a reason why your payment wasnt' processed. So your order number {ORDER} billed on {DATE}is on hold pending payment. There are other options for payment if you'd liked to use another form for payment please login and click on your invoice and payment option.</p
<p>We appreciate your business and should you need any assistance, just reply to this email.</p>

<p>Customer Service<br />
{Company}</p>
</body>
</html>
EOT;
$replacements = array(
					 'PRODUCT NAME'=>$_POST['item_name1'],
					 'CUSTOMER NAME'=>money_format('$ %i', $total),
					 'date'=>"$month/$day/$year",
					 'ORDER'=>$_POST['invoice']
	);
	$mesg=replacemsg($email_body, $replacements);
	mailinvoice($name,$email, $mesg, $subject, $headers);
}
function replacemsg($str, $data){ 
  foreach($data as $key => $value){ 
     $str = preg_replace("/\[$key\]/i", $value, $str);  
  }
  return  $str;
  
}
function mailinvoice($name, $email, $message, $invoice, $headers=null){
	if(!is_null($headers)){
			// To send HTML mail, the Content-type header must be set
		$to = "$name <$email>"; 	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$subject="$name here's the Invoice from Muskegon";
		// Additional headers
		$headers .= "From: Computer Service Center<info@daonlinebiz.com>\r\n";
		$headers .= 'BCC: bclincy@gmail.com' . "\r\n";
	}
  if(mail($to, $subject, $message, $headers)){ 
  	return true;
  }
  else{	 error('Problem Registering', "There were a registration"); }
}


?>