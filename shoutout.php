<?php require_once('Connections/dbcon.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_dbcon, $dbcon);
$query_rslinks = "SELECT * FROM users";
$rslinks = mysql_query($query_rslinks, $dbcon) or die(mysql_error());
$row_rslinks = mysql_fetch_assoc($rslinks);
$totalRows_rslinks = mysql_num_rows($rslinks);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Special Thanks :: Resource and Support</title>
</head>

<body>
<p><a href="http://www.komodomedia.com/" title="Social Media Icons">komoodomedia - Social Media Icons
</a></p>
<p><a href="http://tools.dynamicdrive.com/favicon/">Dynamic Drive</a> - Fav Icon Generator</p>
<p><a href="http: //freehtml5templates.com">marija zaric</a> of html5templates</p>
<p><a href="http://www.phpclasses.org/">php classes</a></p>
<p><a href="http://www.youtube.com/">youtube</a> html &amp; jscript tutorials</p>
<p><a href="http://www.youtube.com/user/killerphp">killerphp</a>Youtube Channel</p>
<p>New Boston (crazy nice) Youtube Channel</p>
</body>
</html>
<?php
mysql_free_result($rslinks);
?>
