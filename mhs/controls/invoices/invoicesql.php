<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<? 
$sql = "SELECT fname, lname, invoiceID, name, address1, address2, city, state, zipcode, phone, email, custID, dated, discount, dtype, inTotal, nonpartname, p.partID as part_id, inline.price as inprice, p.price as prodprice, qty, product, p.type as ptype, unit, taxable, inpay.lastmodified as paidon, payment, inpay.type as paytype, innotes.note as invoicenotes FROM customers c \n"
    . "JOIN states s ON c.stateID=s.stateID \n"
    . "JOIN invoice_meta im ON c.ID=custID \n"
    . "JOIN invoice_lines inline ON invoiceID=im.ID \n"
    . "LEFT JOIN club ON clubID=club \n"
    . "LEFT JOIN products p ON p.partID=inline.partID \n"
    . "LEFT JOIN invoice_payments inpay ON invoiceID=inpay.invoice_id \n"
    . "LEFT JOIN invoice_notes innotes ON innotes.invoice_id=invoiceID LIMIT 0, 30 ";
	?>
<body>
</body>
</html>