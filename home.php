<?php
if(!headers_sent()){session_start();}
if(!isset($_SESSION['user'])){ $msg['login']='Must Be Logged in'; include_once('login.php'); exit;}
require_once('Connections/dbcon.php');
include_once('inc/functions.php');
$results=queryDB(sprintf("SELECT * FROM officialsports WHERE mhsaa_id=%d", $_SESSION['MHSAAID']));
if($results != 0){ 
	while($records=mysql_fetch_assoc($results)){
		$sportid[]=$records['sport_id'];
	}
}
$removeside=true;
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?=$_SESSION['user']; ?> Login</title>
<META name="googlebot" content="NOARCHIVE, NOODP, NOSNIPPET" />
<META name="slurp" content="NOARCHIVE, NOYDIR, NOSNIPPET" />
<meta name="Author" content="ClinCorp Group LLC, Brian Clincy" />
<meta name="copyright" content="(c)1997-<?= date('Y'); ?>ClinCorp Group LLC All rights reserved." />
<meta name="robots" content="index,follow" />
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>
<aside class="sidebar1">
<ul class="cssmenu">
<li><a href="home.php">Home</a></li>
<li><a href="bordinfo.php">Executive Board</a></li>
<!-- <li>Invoices</li> -->
<li><a href="officials.php">Membership</a></li>
<li><a href="profile.php">My Contact Info</a></li>
<li><a href="renew.php">Renew</a></li>
<li><a href="logout.php?logout=true" title="Official Logout">Sign-Out</a></li>
</ul>
</aside>
<div class="content">
    <h2>Welcome <?=$_SESSION['user']; ?></h2>
    <h3>Officiates</h3>
   <? echo listsportsnmigs($sportid, $_SESSION['MHSAAID']); ?>
<?
$results=queryDB("SELECT * FROM uploads ORDER BY uploadID DESC LIMIT 5"); 
if($results!=0){
	?> <article>
<h1>Important information</h1><?
	while($records=mysql_fetch_assoc($results)){
		echo "<p><a href=\"uploads/{$records['filename']}\">{$records['displayname']}</a></p>";
	}
	?><div class="meta"><a href="show.php?cat_id=7">More...</a></div></article>
    <?
}//important files

$results=queryDB("SELECT * FROM docs JOIN category on catID=cat_id WHERE cat_name='Officials' ORDER BY ID DESC LIMIT 5");
#echo "SELECT * FROM docs JOIN category on catID=cat_id WHERE cat_name='Officials' ORDER BY ID DESC LIMIT 5"; 
if($results!=0){
?>
    <article>
<h1>Official Information Center</h1><?
	while($records=mysql_fetch_assoc($results)){
		echo "<p><a href=\"show.php?id={$records['ID']}\">{$records['title']}</a></p>";
		$id=$records['cat_id'];
	}
	?><div class="meta"><a href="show.php?cat_id=<?=$id; ?>">More...</a></div></article>
    <?
}//important files
 ?></div>

<? include_once('footer.php'); ?>
</body>
</html>
<?php
mysql_free_result($rsSports);
?>
