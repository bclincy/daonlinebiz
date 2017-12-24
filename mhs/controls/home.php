<?
if(!headers_sent()){
  session_start();
  header('Cache-Control: no-cache');
  header('Pragma: no-cache');
  session_cache_expire(30); 
}
if(!isset($_SESSION['adminusr'])){ $msg ="MUST BE LOGGED IN"; header('location: ./?notin=true?msg=Must%20be%20logged%20In'); exit; }
elseif(isset($_POST['btnlogin'])){
	$_SESSION['name']="Rick Anderegg";
	$_SESSION['admin']="Administrator";
	include_once('home.php'); exit;
}
$activity='Control Panel'; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Controls :: Home</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="2" id="box-table-a">
  <tr>
    <th scope="col">Content</th>
    <th scope="col">Assessment Data</th>
    <th scope="col">Settings</th>
  </tr>
  <tr>
    <td><a href="category.php">Category</a></td>
    <td>&nbsp;</td>
    <td><a href="admin.php">Account</a></td>
  </tr>
  <tr>
    <td><a href="content.php">Documents</a></td>
    <td>&nbsp;</td>
    <td><a href="boardmember.php">Executive Board</a></td>
  </tr>
  <tr>
    <td><a href="quicklink.php">Links</a></td>
    <td>&nbsp;</td>
    <td><a href="invoices/invoices.php">Invoices</a></td>
  </tr>
  <tr>
    <td><a href="contentmenus.php">Menus</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="upload.php">Uploads</a></td>
    <td>Volunteer Data</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br clear="all" />
<aside>
<h2>&nbsp;</h2>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Event</p>
<p>Frontpage</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</aside>
<aside>
  <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</aside>
<aside>
<h2>&nbsp;</h2>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Passwords</p>

</aside>
<br clear="all" />

<? include_once('footer.php'); ?>
</body>
</html>