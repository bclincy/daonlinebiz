<?
session_start();
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
session_cache_expire(30);
include('../inc/functions.php');
if(isset($_POST['nickname']) &&  !isset($_POST['delete'])){
	if(empty($_POST['nickname']) ){ $error="Please enter a Nickname"; }
	elseif(checkname($_POST['nickname'])){ $error="Already Exists"; }
	elseif(stopinjection($_POST['nickname'])){$error="#32 Data Error"; }
	else{
		$ok = true;/*okay to execute, next data so can't inject directly into db*/
		include('contentmenu-new.php'); exit;
	}
}
elseif(isset($_POST['nameID'])){ $ok=true; include_once('contentmenu-new.php'); exit; }
elseif(isset($_POST['Delete']) && is_numeric($_POST['Delete'])){ 
	$sql="DELETE FROM pagemenu_names as pn JOIN pagemenu p ON menuID=pn.id WHERE id={$_POST['Delete']}";
	echo $sql;
}
if(isset($_POST['edit'])){include_once('contentmenu_edit.php'); /// edit goes to the edit page.
}
$title='Create Menu';
$activity='Create Menu';
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Messages</title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="../scripts/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link href="css/default.css" rel="stylesheet" type="text/css">
<style type="text/css">
#addfiles {
	display: none;
}
</style>
</head>

<body>
<? include_once('header.php'); ?>
<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
<div class="lf2col"><?
$sql = "SELECT * FROM pagemenu_names pn INNER JOIN pagemenu p ON pn.ID = menuID"; 
$results=queryDB($sql);
if($results == 0){ $emptylist=1; echo "No Menus";}
else{
	echo "<select name=\"pagemenus\" size=\"10\">\n";
	while($records=mysql_fetch_assoc($results)){ 
	  echo "<option value='{$records['id']}'>{$records['nickname']}</option>\n";
	}
	echo "</select>\n  <input type=\"submit\" name=\"Edit\" id=\"Edit\" value=\"Edit\" />\n
  <input type=\"submit\" name=\"Delete\" id=\"Delete\" value=\"Delete\" onclick=\" areYouSure('You want to delete the menu');\" />\n";
	
}
?>

</div>
<div class="rt2col">
<h2>New Menu</h2>

  <? if(isset($error)){ echo "<p style=\"color:#ff0000; font-weight:bold;\">$error</p>"; }?>
  <p>Name:<input type="text" size="20" name="nickname" />
  <input type="submit" name="createmenu" id="createmenu" value="Save" />
</p>
</div>
</form>
<? include_once('footer.php'); ?>
<?
function checkname($name){
	if(stopinjection($name)){ return true; }
	$results = queryDB("SELECT * FROM pagemenu_names WHERE nickname='$name'");
	if($results == 1){return true;}
	return false;
}
?>