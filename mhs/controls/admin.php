<?php require_once('../Connections/dbcon.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE accountsettings SET email=%s, name=%s, passwd=%s, telephone=%s, address=%s, address2=%s, city=%s, stateID=%s, zip=%s, companyname=%s, fax=%s, `lastmodified`=%s WHERE username=%s",
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['passwd'], "text"),
                       GetSQLValueString($_POST['telephone'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['address2'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['stateID'], "int"),
                       GetSQLValueString($_POST['zip'], "text"),
                       GetSQLValueString($_POST['companyname'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['lastmodified'], "date"),
                       GetSQLValueString($_POST['username'], "text"));

  mysql_select_db($database_dbcon, $dbcon);
  $Result1 = mysql_query($updateSQL, $dbcon) or die(mysql_error());

  $updateGoTo = "home.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_dbcon, $dbcon);
$query_rsAdmininfo = "SELECT * FROM accountsettings ";
$rsAdmininfo = mysql_query($query_rsAdmininfo, $dbcon) or die(mysql_error());
$row_rsAdmininfo = mysql_fetch_assoc($rsAdmininfo);
$totalRows_rsAdmininfo = mysql_num_rows($rsAdmininfo);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Document</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Username:</td>
      <td><?php echo $row_rsAdmininfo['username']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Email:</td>
      <td><input type="text" name="email" value="<?php echo htmlentities($row_rsAdmininfo['email'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input type="text" name="name" value="<?php echo htmlentities($row_rsAdmininfo['name'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Passwd:</td>
      <td><input type="password" name="passwd" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Telephone:</td>
      <td><input type="text" name="telephone" value="<?php echo htmlentities($row_rsAdmininfo['telephone'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Address:</td>
      <td><input type="text" name="address" value="<?php echo htmlentities($row_rsAdmininfo['address'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Address2:</td>
      <td><input type="text" name="address2" value="<?php echo htmlentities($row_rsAdmininfo['address2'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">City:</td>
      <td><input type="text" name="city" value="<?php echo htmlentities($row_rsAdmininfo['city'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">State</td>
      <td><input type="text" name="stateID" value="<?php echo htmlentities($row_rsAdmininfo['stateID'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Zip:</td>
      <td><input type="text" name="zip" value="<?php echo htmlentities($row_rsAdmininfo['zip'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Company Name:</td>
      <td><input type="text" name="companyname" value="<?php echo htmlentities($row_rsAdmininfo['companyname'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Fax:</td>
      <td><input type="text" name="fax" value="<?php echo htmlentities($row_rsAdmininfo['fax'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Last Change:</td>
      <td><input type="text" name="lastmodified" value="<?php echo htmlentities($row_rsAdmininfo['lastmodified'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="username" value="<?php echo $row_rsAdmininfo['username']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsAdmininfo);
?>
