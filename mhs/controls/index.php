<? 
if(!headers_sent()){session_start();}
include_once('../inc/functions.php'); 
require_once('../Connections/dbcon.php'); 
mysql_select_db($database_dbcon, $dbcon);
if(isset($_REQUEST['logout'])){
	session_destroy();
	$msg="Logged Out";
}
if(isset($_SESSION['adminusr'])){include_once('home.php'); exit; }
if(isset($_POST['login']) && !empty($_POST['login']) && !empty($_POST['pass'])){
	$username=$mysqli->real_escape_string($_POST['login']);
	$password=$mysqli->real_escape_string($_POST['pass']);
	$sql="SELECT *, date_format(lastmodified, '%d %b %Y %T') as login FROM accountsettings WHERE username='$username' AND passwd=password('$password')";
	if ($result = $mysqli->query($sql, MYSQLI_USE_RESULT)) {
		
		$record=mysqli_fetch_assoc($result);
		$_SESSION['name']=$record['name'];
		$_SESSION['adminusr']=$record['username'];
		$_SESSION['lastin']=$records['login'];
		
		include_once('home.php'); exit; 
		
    /* Note, that we can't execute any functions which interact with the
       server until result set was closed. All calls will return an
       'out of sync' error */
    if (!$mysqli->query("SET @a:='this will not work'")) {
		echo "HELO"; 
		$msg="Username and password don't match our records"; 
        printf("Error: %s\n", $mysqli->error);
    }
    $result->close();
}

$mysqli->close();
	
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>MHHSA Login</title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="../js/jqvalidate.js"></script>
<link rel="stylesheet" type="text/css" href="css/login.css" media="screen" />
</head>
<body>
<div class="wrap">
	<div id="content">
		<div id="main">
			<div class="full_w">
            <? if(isset($msg)){ echo "<h1>$msg</h1>"; } ?>
				<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" id="userlogin">
					<label for="login">Username:</label>
					<input id="login" name="login" class="text" />
					<label for="pass">Password:</label>
					<input id="pass" name="pass" type="password" class="text" />
					<div class="sep"></div>
					<button type="submit" class="ok">Login</button> <a class="button" href="">Forgotten password?</a>
				</form>
<script>
$().ready(function(){
	$('#userlogin').validate({
		 rules: {
            login:{
				required: true,
				minlength:5
	        },
			pass:{
				required: true,
				menlength:5
			}
		 },
        messages: {
            login:{
				required:"Username is Required",
				minlength:"Too Short to qualify"
			},
            pass:{
				required:"Password is Required",
				minlength:"Password is too short"
			}
        }
	}
	);
});
</script>                
			</div>
			<div class="footer">&raquo; <a href="http://muskegonheightsAcademy.com">http://muskegonheightsAcademy.com</a> |<a href="./"> Admin Panel</a></div>
		</div>
	</div>
</div>

</body>
</html>
