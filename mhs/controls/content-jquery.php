<?
if ( !eregi ($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'] ) ){// do something
	exit;
}
echo "safe";
include_once('../inc/functions.php');
include_once('../Connections/Dbcon.php');
mysql_select_db($database_dbcon, $dbcon);
if(isset($_POST['newsport']) && !empty($_POST['newsport'])){
	$sql="INSERT INTO sports (sport, lastmodified) VALULE('{$_POST['newsport']}', now())";
	$results=mysql_query($sql);
	return sprintf( "%d", mysql_affected_rows());
}
?>