<?
if(!headers_sent()){ session_start(); }
include_once('Connections/dbcon.php');
mysql_select_db($database_dbcon, $dbcon);

if(isset($_REQUEST['in']) && isset($_REQUEST['out'])){
	$sql = sprintf("SELECT node .cat_id , node.cat_name , (\n"
    . "	 COUNT( parent.cat_name ) -1) AS depth \n"
    . " FROM category AS node, category AS parent WHERE node.lft\n"
    . "	 BETWEEN %d AND %d AND parent.lft between %d AND %d\n"
    . "	 GROUP BY node.cat_name ORDER BY node.lft", mysql_real_escape_string($_REQUEST['in']), mysql_real_escape_string($_REQUEST['out']),mysql_real_escape_string($_REQUEST['in']), mysql_real_escape_string($_REQUEST['out']));
  #echo $sql;
}
if(isset($_REQUEST['cat'])){
	$category=explode(' ', $_REQUEST['cat']);
	$categories= array('Mobile'=>5, 'Computer'=> 4, 'Technology'=>6, 'Web'=>'3');
	$sql="SELECT * FROM products where catID={$categories[$category[0]]} && supplierID is NULL ORDER by product";
	if($results=mysql_query($sql)){
		$showprod=true;
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>DaOnlineBiz (The Online Biz) :: Products in Muskegon, Michigan</title>
<meta name="description" content="Customer Login to update their customer profile, show, check on their repair details or even schedule a repair." />
<meta name="keywords" content="Customer Login, User Login, Computers, Tablets, Mobile Phones, VOIP, Website, Computer Support, computer Recycling, technical supports" />
<meta name="Author" content="ClinCorp Group LLC, Brian Clincy" />
<meta name="copyright" content="(c)1997-<?= date('Y'); ?>ClinCorp Group LLC All rights reserved." />
<meta name="robots" content="index,follow" />
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>


<?
if($showprod){
	echo "<h1>{$_REQUEST['cat']}</h1>";
	while($records=mysql_fetch_assoc($results)){
		?><div class="prodlist"><h1><?= $records['product']; ?></h1>
        <p><?= $records['description']; ?></p>
        <p><? if($records['Price']<1){ echo "<a href=\"prodquote.php?id={$records['partID']}\" class=\"btnquote\">Online Quote</a>"; }
		else{
			echo money_format('$ %i', $records['Price']);
		}?>
        </div>
        <?
	}
}
else{
	echo "Sorry, but there are no products to display ";
}
?>
<? include_once('footer.php'); ?>

</body>
</html>