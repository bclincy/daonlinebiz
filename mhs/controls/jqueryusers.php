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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsUsers = 20;
$pageNum_rsUsers = 0;
if (isset($_GET['pageNum_rsUsers'])) {
  $pageNum_rsUsers = $_GET['pageNum_rsUsers'];
}
$startRow_rsUsers = $pageNum_rsUsers * $maxRows_rsUsers;

$qstring_rsUsers = "-";
if (isset($_REQUEST['qstring'])) {
  $qstring_rsUsers = $_REQUEST['qstring'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rsUsers = sprintf("SELECT *  FROM users WHERE fname LIKE %s OR lname LIKE %s", GetSQLValueString("%" . $qstring_rsUsers . "%", "text"),GetSQLValueString("%" . $qstring_rsUsers . "%", "text"));
$query_limit_rsUsers = sprintf("%s LIMIT %d, %d", $query_rsUsers, $startRow_rsUsers, $maxRows_rsUsers);
$rsUsers = mysql_query($query_limit_rsUsers, $dbcon) or die(mysql_error());
$row_rsUsers = mysql_fetch_assoc($rsUsers);

if (isset($_GET['totalRows_rsUsers'])) {
  $totalRows_rsUsers = $_GET['totalRows_rsUsers'];
} else {
  $all_rsUsers = mysql_query($query_rsUsers);
  $totalRows_rsUsers = mysql_num_rows($all_rsUsers);
}
$totalPages_rsUsers = ceil($totalRows_rsUsers/$maxRows_rsUsers)-1;

$queryString_rsUsers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsUsers") == false && 
        stristr($param, "totalRows_rsUsers") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsUsers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsUsers = sprintf("&totalRows_rsUsers=%d%s", $totalRows_rsUsers, $queryString_rsUsers);
if(!is_null($row_rsUsers['fname'])){
?>
<table border="0" align="center" width="100%">
  <thead>
  	<th>#</th>
    <th>First name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>City</th>
    <th>Zip Code</th>
    <th>Phone</th>
    <th>Mobile</th>
    <th>Work</th>
    <th>Srv</th>
  </thead>
  <?php do { ?>
    <tr class="row" onClick="DoNav('pregister-edit.php?MHSAAID=<?php echo $row_rsUsers['MHSAAID']; ?>');">
      <td><?php echo $row_rsUsers['userID']; ?> </td>
      <td><?php echo $row_rsUsers['fname']; ?> </td>
      <td><?php echo $row_rsUsers['lname']; ?> </td>
      <td><?php echo $row_rsUsers['email']; ?> </td>
      <td><?php echo $row_rsUsers['city']; ?> </td>
      <td><?php echo $row_rsUsers['zipcode']; ?> </td>
      <td><?php echo $row_rsUsers['phone']; ?> </td>
      <td><?php echo $row_rsUsers['mobile']; ?> </td>
      <td><?php echo $row_rsUsers['work']; ?> </td>
      <td><? if(!is_null($row_rsUsers['email'])){?><a href="email.php?userid=<?php echo $row_rsUsers['userID']; ?>" class="btnemail">Email </a><? } ?></td>
    </tr>
    <?php } while ($row_rsUsers = mysql_fetch_assoc($rsUsers)); ?>
</table>
<br>
<table border="0">
  <tr>
    <td><?php if ($pageNum_rsUsers > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rsUsers=%d%s", $currentPage, 0, $queryString_rsUsers); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_rsUsers > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rsUsers=%d%s", $currentPage, max(0, $pageNum_rsUsers - 1), $queryString_rsUsers); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_rsUsers < $totalPages_rsUsers) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rsUsers=%d%s", $currentPage, min($totalPages_rsUsers, $pageNum_rsUsers + 1), $queryString_rsUsers); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_rsUsers < $totalPages_rsUsers) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rsUsers=%d%s", $currentPage, $totalPages_rsUsers, $queryString_rsUsers); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_rsUsers + 1) ?> to <?php echo min($startRow_rsUsers + $maxRows_rsUsers, $totalRows_rsUsers) ?> of <?php echo $totalRows_rsUsers ?>
<?php
}
else{
	echo "<h2>No Results</h2>\n<p style='padding-bottom:20em;'>{$_REQUEST['qstring']} - Not Found</p>\n\n";
}
?>
<?
mysql_free_result($rsUsers);
?>
