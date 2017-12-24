<?
if(!headers_sent()){session_start();}
include_once('../inc/functions.php');
if(isset($_REQUEST['logout'])){ session_destroy(); header('location: index.php?log=true'); }
elseif(isset($_SESSION['admin']) && !isset($_REQUEST['logout'])){include_once('home.php'); exit;}
if(isset($_POST['btnSignin']) && $_POST['usrname']=='admin' && $_POST['passwd']=='get2go'){
	$_SESSION['name']="Moni Breed";
	$_SESSION['admin']="Administrator";
	include_once('home.php'); exit;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Controls Login</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="../js/jqvalidate.js"></script>
</head>

<body>
<form id="frm" name="frm" method="post" action="./">
  <div id="loginfrm">
<? if(is_array($msg)){ echo "<h3>{$msg['message']}</h3>"; }elseif(is_string($msg)){ echo "<h3>$msg</h3>"; } 
	elseif(isset($_REQUEST['logged'])){ echo "<h3>You've been logged out!</h3>"; }
	if(isset($_REQUEST['log'])){echo "<h3>You have been logged out</h3>"; }
	
?>
    <h2>Control Panel</h2>
    <fieldset id="login"><legend>User Login</legend>
    <p>
      <label for="usrname">Login:</label>
      <input name="usrname" type="text" id="usrname" size="25" maxlength="12" />
      <? if(isset($msg['usrname'])){ $msg['usrname']; } ?>
    </p>
    <p>
      <label for="passwd">Password:</label>
      <input name="passwd" type="password" id="passwd" size="25" maxlength="10" />
      <? if(isset($msg['passwd'])){ echo $msg['passwd']; } ?>
    </p>
    <p>
      <label for="signin">&nbsp;</label>
      <input type="submit" name="btnSignin" id="signin" value="Sign In" />
    </p>  
    <p>Forgot Password</p>
    </fieldset>
 
  </div>
</form>
</body>
</html>