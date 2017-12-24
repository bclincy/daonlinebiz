<?php require_once('../Connections/dbcon.php'); ?>
<?php
mysql_select_db($database_dbcon, $dbcon);

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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO boardmembers (title, Name, Bio, email, memberdate, Phone) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Bio'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['memberdate'], "date"),
                       GetSQLValueString($_POST['Phone'], "text"));

  
  $Result1 = mysql_query($insertSQL, $dbcon) or die(mysql_error());
  if(mysql_affected_rows($Result1) > 0){
	  include_once('../inc/functions.php');   
	  $msg['success']= "<h2>{$_POST['title']} - {$_POST['name']} was added</h2>"; 
  }
  else{ $msg['unsuccessful']="<h2>{$_POST['title']} - {$_POST['name']} was not added</h2>"; }
}
$query_rsBoard = "SELECT * FROM boardmembers";
$rsBoard = mysql_query($query_rsBoard, $dbcon) or die(mysql_error());
$row_rsBoard = mysql_fetch_assoc($rsBoard);
$totalRows_rsBoard = mysql_num_rows($rsBoard);
$activity='Board Members'; 
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Board Member</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="../js/jsquery.js"></script>
<script src="../js/frmReg.js"></script>

</head>

<body>
<? include_once('header.php'); ?>
<h1>Board Members</h1>
<h2>Add New Board Member</h2>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
  <p><label for="title">Title:</label>
  <input name="title" type="text" id="title" value="" size="25" maxlength="200"></p><p><label for="">Name:</label>
  <input name="Name" type="text" value="" size="25" id="Name" maxlength="200"></p>
  <p><label for="">Bio:</label>
    <textarea name="Bio" cols="40%" rows="4" id="Bio"></textarea>
  </p>
  <p><label for="">Email:</label>
  <input type="text" name="email" value="" size="32"></p>
  <p><label for="">Member Date:</label>
  <input type="text" name="memberdate" value="" size="32"></p>
  <p><label for="">Phone:</label><input type="text" name="Phone" value="" size="32"></p>
  <p>
    <label for="uploadphot">Upload Photo:</label>
    <input name="uploadphot" type="file" id="uploadphot" size="20">
  * (.jpg, .png files only)</p>
  <p><label for="send">&nbsp;</label>
      <input name="btnNewBoar" type="submit" id="btnNewBoar" value="Save">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<div id="showboard">
<h2>Board Members</h2>
<table border="0" align="center" class="tabledata">
  <thead>
    <th>Title</th>
    <th>Name</th>
    <th>Bio</th>
    <th>Email</th>
    <th>Date</th>
    <th>Phone</th>
    <th>Remove</th>
 </thead>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsBoard['title']; ?>&nbsp; </td>
      <td><a href="board-details.php?recordID=<?php echo $row_rsBoard['boardID']; ?>"> <?php echo $row_rsBoard['Name']; ?>&nbsp; </a></td>
      <td><?php echo $row_rsBoard['Bio']; ?>&nbsp; </td>
      <td><?php echo $row_rsBoard['email']; ?>&nbsp; </td>
      <td><?php echo $row_rsBoard['memberdate']; ?>&nbsp; </td>
      <td><?php echo $row_rsBoard['Phone']; ?>&nbsp; </td>
      <td><a href="?remove=<?= $row_rsBoard['boardID']; ?>">Remove</a></td>
    </tr>
    <?php } while ($row_rsBoard = mysql_fetch_assoc($rsBoard)); ?>
</table>
<br>
<?php echo $totalRows_rsBoard ?> Records Total

</div>
<p>&nbsp;</p>
<? include_once('footer.php'); ?>
</body>
</html>
<?php
mysql_free_result($rsBoard);
?>
