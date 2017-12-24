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

$maxRows_rsMessages = 50;
$pageNum_rsMessages = 0;
if (isset($_GET['pageNum_rsMessages'])) {
  $pageNum_rsMessages = $_GET['pageNum_rsMessages'];
}
$startRow_rsMessages = $pageNum_rsMessages * $maxRows_rsMessages;

$sorted_rsMessages = "messageID";
if (isset($_REQUEST['sortby'])) {
  $sorted_rsMessages = $_REQUEST['sortby'];
}
mysql_select_db($database_dbcon, $dbcon);
$query_rsMessages = sprintf("SELECT *,  date_format(edited, '%%m/%%d/%%Y %%r') as edited FROM messages LEFT JOIN sports ON messages.sportID=sports.sportID ORDER BY %s DESC", GetSQLValueString($sorted_rsMessages, ""));
$query_limit_rsMessages = sprintf("%s LIMIT %d, %d", $query_rsMessages, $startRow_rsMessages, $maxRows_rsMessages);
$rsMessages = mysql_query($query_limit_rsMessages, $dbcon) or die(mysql_error());
$row_rsMessages = mysql_fetch_assoc($rsMessages);

if (isset($_GET['totalRows_rsMessages'])) {
  $totalRows_rsMessages = $_GET['totalRows_rsMessages'];
} else {
  $all_rsMessages = mysql_query($query_rsMessages);
  $totalRows_rsMessages = mysql_num_rows($all_rsMessages);
}
$totalPages_rsMessages = ceil($totalRows_rsMessages/$maxRows_rsMessages)-1;

$queryString_rsMessages = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsMessages") == false && 
        stristr($param, "totalRows_rsMessages") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsMessages = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsMessages = sprintf("&totalRows_rsMessages=%d%s", $totalRows_rsMessages, $queryString_rsMessages);
include_once('../inc/functions.php'); 
if(isset($_POST['removeMsg']) && is_array($_POST['removeMsg'])){
	$remove=implode(',', $_POST['removeMsg']);
	$sql="DELETE FROM messages WHERE messageID IN ($remove)";
	$results=mysql_query($sql);
	$msg="<h1>".count($_POST['removeMsg']). " messages have been removed";
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Messages</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>
<script type="text/javascript">
function deletechecked(message){
	var r=confirm(message)
	if (r==true){return true;}
	else{
		alert("No Messages were Removed");
		return false;
  	}
}

</script>
<body>
<? include_once('header.php'); ?>
  <div class="breadcrum">
    <ul>
      <li><a href="./">Home</a></li>
      <li><a href="messages.php">Compose Message</a></li>
      <li>Messages</li>
    </ul>
  </div>
  <h1>Message Inbox</h1>
  <form name="form1" method="post" action="messageslist.php" id="box-table-a">
    <table width="100%" border="0" align="center">
      <thead>
      <th>Remove</th>
        <th <? if($_REQUEST['sortby']=='sport, toother'){ echo "class=\"highlighted\"";} ?>> <a href="?sortby=sport, toother">To:</a></th>
        <th <? if($_REQUEST['sortby']=='subject'){ echo "class=\"highlighted\"";} ?>><a href="?sortby=subject">Subject</a></th>
        <th <? if($_REQUEST['sortby']=='message'){ echo "class=\"highlighted\"";} ?>><a href="?sortby=message">Message</a></th>
        <th <? if($_REQUEST['sortby']=='edited'){ echo "class=\"highlighted\"";} ?>><a href="?sortby=edited">Dated</a></th>
        <th <? if($_REQUEST['sortby']=='attachments'){ echo "class=\"highlighted\"";} ?>><a href="?sortby=attachments">Files</a></th>
          </thead>
      </tr>
      <?php do { ?>
        <tr class="msginbox">
          <td><input type="checkbox" name="removeMsg[]" id="removeMsg[]" value="<?= $row_rsMessages['messageID']; ?>"></td>
          <td><?php echo $row_rsMessages['toother']; ?>
            <?= $row_rsMessages['sport']; ?></td>
          <td align="left"><a href="messsageDetail.php?recordID=<?php echo $row_rsMessages['messageID']; ?>"><?php echo $row_rsMessages['subject']; ?></a>&nbsp; </td>
          <td align="left"><?= strip_tags(showwords($row_rsMessages['message'],8)); ?></td>
          <td><?php echo $row_rsMessages['edited']; ?></td>
          <td><? if(!empty($row_rsMessages['attachments'])){ ; ?>
            <img src="../images/attachment.png" width="20" height="20" alt="Attached Documents <?= $row_rsMessages['attachments']; ?>">
            <? } ?></td>
        </tr>
        <?php } while ($row_rsMessages = mysql_fetch_assoc($rsMessages)); ?>
      <tr>
        <td colspan="6"><input name="btnRemove" type="submit" value="Remove" onClick="return deletechecked('Are You Sure?');"></td>
      </tr>
    </table>
  </form>
  <br>
  <table border="0">
    <tr>
      <td><?php if ($pageNum_rsMessages > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsMessages=%d%s", $currentPage, 0, $queryString_rsMessages); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_rsMessages > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsMessages=%d%s", $currentPage, max(0, $pageNum_rsMessages - 1), $queryString_rsMessages); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_rsMessages < $totalPages_rsMessages) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsMessages=%d%s", $currentPage, min($totalPages_rsMessages, $pageNum_rsMessages + 1), $queryString_rsMessages); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_rsMessages < $totalPages_rsMessages) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsMessages=%d%s", $currentPage, $totalPages_rsMessages, $queryString_rsMessages); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
  Records <?php echo ($startRow_rsMessages + 1) ?> to <?php echo min($startRow_rsMessages + $maxRows_rsMessages, $totalRows_rsMessages) ?> of <?php echo $totalRows_rsMessages ?>
  <? include_once('footer.php'); ?>
</body>
</html>
<?php
mysql_free_result($rsMessages);

function showemails($sendto){
	switch ($sentto) {
		case 0:
			$where="WHERE Status='Active' AND email !='' ";
			if(strtotime('now') > strtotime(date(Y).'-05-1')){$where.='AND regyear='.date('Y');}
			break;
		case 'all':
			$where=" WHERE email !=''";
			break;
		default:
		$where=" JOIN officialsports ON MHSAAID=mhsaa_id WHERE sport_id={$_POST['sendto']}";
		break;
	}
	$sql="SELECT CONCAT (fname, ' ', lname) as name, email, altemail FROM users $where";
	$results=mysql_query($sql);
	if($results && mysql_num_rows($results) > 0){
		while($records=mysql_fetch_assoc($results)){
			echo "<p>{$records['name']} <{$records['email']}></p>";
		}
	}
	else{	return false; }
}

?>
