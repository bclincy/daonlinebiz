<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Invoice for [customer] [date]</title>
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
#caddress h1{
    margin-bottom: 5px;
    padding-bottom: 0;
    font-size:18pt;
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
#footer{ 
text-align:center;
border-bottom:#000 thin solid;
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
    <h1>Brian Clincy</h1>
      338 Yuba St<br />
      Muskegon, MI 49442    </p>
  </div>
  <div id="logo"><a href="http://daonlinebiz.com"><img src="http://www.daonlinebiz.com/images/dalogo.gif" alt="DaOnlinebiz.com Business in Perspective" /></a></div>
  <div class="clear">
    <div  id="compadd">
      [customerdata]
    </div>
    <div id="invoicedetails">
      <table id="meta">
        <tr>
          <td class="meta-head">Invoice #</td>
          <td class="data">[invoiceid]</td>
        </tr>
        <tr>
          <td class="meta-head">Date</td>
          <td class="data">[date]</td>
        </tr>
        <tr>
          <td class="meta-head">Amount Due</td>
          <td class="data">[balance]</td>
        </tr>
      </table>
    </div>
  </div>
  <!-- Invoice detials !-->
 <div class="clear">
 <table id="items">
		
		  <tr>
		      <th>Item</th>
		      <th>Description</th>
		      <th>Unit Cost</th>
		      <th>Qty</th>
		      <th>Price</th>
      </tr>
*PART*
      <tr>
        <td colspan="2" rowspan="8" class="blank">[notes]<br />
          t means the item was taxed</td>
        <td colspan="2" align="right" class="total-line">Subtotal</td>
        <td class="total-value">[subtotal]</td>
      </tr>
      <tr>
        <td colspan="2" align="right" class="total-line">Discount:</td>
        <td class="total-value">[discount]</td>
      </tr>
      <tr>
      <td colspan="2" align="right">Taxes at [rate]:</td>
      <td>[taxes]</td>
      </tr>
      <tr>
        <td colspan="2" align="right" class="total-line">Total:</td>
        <td class="total-value"><div id="total">[total]<span class="total-line"></span></div></td>
      </tr>
      <tr>
        <td colspan="2" align="right" class="total-line">Payment Type:</td>
        <td class="total-value">[paymenthod]</td>
      </tr>
      <tr>
        <td colspan="2" align="right" class="total-line">Amount Paid</td>
        <td class="total-value"> [paid]</td>
      </tr>
      <tr>
        <td colspan="2" align="right" class="total-line balance">Balance Due</td>
        <td class="total-value balance">[balance]</td>
      </tr>
      <tr>
        <td colspan="2" class="total-line balance">Pay with Paypal</td>
        <td><a href="http://daonlinebiz.com/paypalinv.php?invoice=[invoice#]"><img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" alt="Pay via Paypal" style="margin-right:7px; border:none;" /></a></td>
      </tr>
    </table>

 </div>
 <!-- Itemize -->  
<div id="footer">Please make alll checks payable to ClinCorp Group LLC, You can also pay by credit card to your technician!<br />Thank You for your business!</div>
 </div>
</body>
</html>
