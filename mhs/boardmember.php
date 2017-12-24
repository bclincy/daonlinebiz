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
$query_rsBoard = "SELECT * FROM boardmembers";
$rsBoard = mysql_query($query_rsBoard, $dbcon) or die(mysql_error());
$row_rsBoard = mysql_fetch_assoc($rsBoard);
$totalRows_rsBoard = mysql_num_rows($rsBoard);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Muskegon Height Academy :: Executive Board</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>
<div class="breadcrum"><ul>
    <li><a href="./" title="Home">Home</a></li>
    <li><a href="show.php?cat_id=1" title="About USAOA">About</a></li><li>Executive Board</li></ul></div>
<?php do { ?>
  <div>
    <h2><?php echo $row_rsBoard['title']; ?></h2>
    <p><?php echo $row_rsBoard['Name']; ?></p>
    <p>Bio: <?php echo $row_rsBoard['Bio']; ?></p>
  </div>
  <?php } while ($row_rsBoard = mysql_fetch_assoc($rsBoard)); ?>
<? include_once('footer.php'); ?>
</body>
</html>
<?php
mysql_free_result($rsBoard);
?>
