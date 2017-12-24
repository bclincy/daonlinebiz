<?php require_once('../Connections/dbcon.php'); ?><?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE boardmembers SET title=%s, Name=%s, Bio=%s, email=%s, memberdate=%s, Phone=%s WHERE boardID=%s",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Bio'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['memberdate'], "date"),
                       GetSQLValueString($_POST['Phone'], "text"),
                       GetSQLValueString($_POST['boardID'], "int"));

  mysql_select_db($database_dbcon, $dbcon);
  $Result1 = mysql_query($updateSQL, $dbcon) or die(mysql_error());

  $updateGoTo = "boardmember.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_DetailRS1 = sprintf("SELECT * FROM boardmembers WHERE boardID = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysql_query($query_DetailRS1, $dbcon) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysql_num_rows($DetailRS1);
$activity='Update Board Member';
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Update <?php echo $row_DetailRS1['Name']; ?> - <?php echo $row_DetailRS1['Name']; ?></title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="css/default.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>
<script type="text/javascript">
	$("#mmemberdate").focus(
		function(){ alert("I'm trying to get it"); }
	);
	function(){
		alert(1); 
	  $( "#memberdate" ).datepicker();
	}
	</script>
<h2>Edit :: <?php echo $row_DetailRS1['title']; ?> - <?php echo $row_DetailRS1['Name']; ?> </h2>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Title:</td>
      <td><input type="text" name="title" value="<?php echo htmlentities($row_DetailRS1['title'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input type="text" name="Name" value="<?php echo htmlentities($row_DetailRS1['Name'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Bio:</td>
      <td><textarea name="Bio" cols="32"><?php echo htmlentities($row_DetailRS1['Bio'], ENT_COMPAT, 'UTF-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Email:</td>
      <td><input type="text" name="email" value="<?php echo htmlentities($row_DetailRS1['email'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Memberdate:</td>
      <td><input type="text" name="memberdate" value="<?php echo htmlentities($row_DetailRS1['memberdate'], ENT_COMPAT, 'UTF-8'); ?>" id="memberdate" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Phone:</td>
      <td><input type="text" name="Phone" value="<?php echo htmlentities($row_DetailRS1['Phone'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="btnUpdate" type="submit" id="btnUpdate" value="Save Changes"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="boardID" value="<?php echo $row_DetailRS1['boardID']; ?>">
</form>
<? include_once('footer.php'); ?>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>