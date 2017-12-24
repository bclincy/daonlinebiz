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
#logo {
	float: right;
	width: 50%;
	margin-left: 5%;
	padding: 20px 0 5px 0;
	text-align: center;
}
#logo h1{
	margin-bottom:0;
	color:#F00;
	padding-bottom:0;
}
#logo p{
	margin-top:0;
	padding-top:0;
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
  <div id="header">Reciept</div>
  <div id="caddress">USA Officials Association<br />
    C/O Rick Anderegg<br />
    2261 N. Hilltop Dr.<br />
  Norton Shores, Michigan 49441</div>
  <div id="logo">
  <h1><img src="http://usaofficialsassn.com/images/logo.png" width="200" height="111" /></h1>
  <p>&lt;USAOA&gt; West Michigan Officials Association</p>
  </div>
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
        <td colspan="2" class="total-line balance">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>

 </div>
 <!-- Itemize -->  
<div id="footer">Thank You for your Payment</div>
 </div>
</body>
</html>
