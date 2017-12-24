<? 
include_once('../inc/functions.php');
include_once('../Connections/dbcon.php');
mysql_select_db($database_dbcon, $dbcon);
if(!isset($_REQUEST['numofrec'])){
	$results=mysql_query("SELECT * FROM links");
	$totalrecs=mysql_num_rows($results);
	$pages=ceil($totalrecs/30);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Managed Links</title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>
<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="createlink">
  <p>
    <label for="link">Link:</label>
    <input type="text" name="link" id="link" placeholder="www.discounttires.com">
  </p>
  <p>
    <label for="name">Display Name:</label>
    <input type="text" name="name" id="name" placeholder="Discount Tires">
  </p>
  <p>
    <label for="description">Description:</label>
    <textarea name="description" cols="30" rows="4" id="description" placeholder="Use our Discount at discount tires and recieve an extra 20% off"></textarea>
  </p>
  <p>
    <label for="frontpage">Add to Frontpage:</label>
    <input type="checkbox" name="frontpage" id="frontpage">
    
  </p>
  <p>
    <input type="submit" name="btnSaveLink" id="btnSaveLink" value="Submit">
  </p>
  <p>&nbsp;</p>
</form>
<? include_once('footer.php'); ?>
</body>
</html>
