<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dbcon = "localhost";
$database_dbcon = "daonline_sitedb";
$username_dbcon = "daonline_bclincy";
$password_dbcon = "bcuz1Isb";
//$dbcon = mysql_pconnect($hostname_dbcon, $username_dbcon, $password_dbcon) or trigger_error(mysql_error(),E_USER_ERROR); 
//$dbcon = new mysqli($hostname_dbcon, $database_dbcon, $password_dbcon);
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//} 
$conn = mysqli_connect($hostname_dbcon, $username_dbcon, $password_dbcon);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
