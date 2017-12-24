<? 
include_once('../../Connections/dbcon.php'); 
mysql_select_db($database_dbcon, $dbcon);
include_once('lib.php');
if (!isset($_REQUEST['recordID']) && !is_int($_REQUEST['recordID'])){
	error("No Invoice Selected", 'Serious'); exit;
}
echo sendInvoice($_REQUEST['recordID'],true);

?>