<?
if(isset($_REQUEST['logout'])){
	$username=$_SESSION['user']; 
	session_destroy(); 
	header('location: login.php?logout=true&user='.$username.'session=');
}
if(isset($_SESSION['user'])){
	header('location: home.php');
}
if(isset($_POST['email']) && !empty($_POST['password'])){
	$sql = sprintf("SELECT * FROM users WHERE email=%s && passwd=password(%s)", 
	GetSQLValueString($_POST['email'], "text"),GetSQLValueString($_POST['password'], "text"));
	$results=mysql_query($sql);
	if($results){ $num_rows= mysql_num_rows($results); }
	if($num_rows > 0){
		$record=mysql_fetch_assoc($results);
		$_SESSION['user']="{$record['fname']} {$record['lname']}"; 
		$_SESSION['userID']=$record['userID'];
		$_SESSION['username']=$record['username'];
		$_SESSION['MHSAAID']=$record['MHSAAID']; 
		$_SESSION['email']=$record['email'];
		include_once('home.php');
		exit;
	}
	else{
		$sql=sprintf("SELECT * FROM users WHERE email=%s && passwd IS NULL", GetSQLValueString($_POST['email'], 'text'));
		$results=mysql_query($sql);
		if($results){ $num_rows= mysql_num_rows($results); }
		if($num_rows>0){
			$records=mysql_fetch_assoc($results);
			$name=urlencode("{$records['fname']} {$records['lname']}");
			header("location: register.php?setup=true&name=$name");
		}
		$msg['login']='Username or Password don\'t match our records'; }
}
elseif(isset($_POST['password']) && empty($_POST['password'])){ $msg['Password']="Password was empty"; }
if(isset($_REQUEST['user'])){
	$msg['loggedout']="{$_REQUEST['user']} is logged out.";
}
if(isset($_REQUEST['msg'])){ $msg=$_REQUEST['msg']; }
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>DaOnlineBiz (the Online Business) :: User Login</title>
<meta name="description" content="Customer Login to update their customer profile, show, check on their repair details or even schedule a repair." />
<meta name="keywords" content="Customer Login, User Login, Computers, Tablets, Mobile Phones, VOIP, Website, Computer Support, computer Recycling, technical supports" />
<meta name="Author" content="ClinCorp Group LLC, Brian Clincy" />
<meta name="copyright" content="(c)1997-<?= date('Y'); ?>ClinCorp Group LLC All rights reserved." />
<meta name="robots" content="index,follow" />
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>
<aside class="twocol">
<h1>Sign-In</h1>
<form action="login.php" method="post" enctype="multipart/form-data" name="frmLogin"id="frmLogin">
  <p>
    <label for="email">Email:</label>
    <input type="text" name="email" id="email">
  </p>
  <p>
    <label for="password2">Password:</label>
    <input type="text" name="password2" id="password2">
  </p>
  <p>&nbsp; </p>
</form>
</aside>
<aside class="twocol">
<h1>Sign-Up</h1>
<form action="register.php" method="post" enctype="multipart/form-data" name="frmRegister" id="frmRegister">

</form>
</aside>
<br class="clearing">
<? include_once('footer.php'); ?>
</body>
</html>