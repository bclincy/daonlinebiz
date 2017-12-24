<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dbcon = "localhost";
$database_dbcon = "daonline_mhs";
$username_dbcon = "daonline_mhsuser";
$password_dbcon = "bcuz1Isb";
$dbcon = mysql_pconnect($hostname_dbcon, $username_dbcon, $password_dbcon) or trigger_error(mysql_error(),E_USER_ERROR);
$mysqli = new mysqli("localhost", "daonline_mhsuser", "bcuz1Isb", "daonline_mhs");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} 
?>