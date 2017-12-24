<?php require_once('../Connections/dbcon.php'); ?>
<?php
if(!headers_sent()){
  session_start();
  header('Cache-Control: no-cache');
  header('Pragma: no-cache');
  session_cache_expire(30); 
}
if(!isset($_SESSION['admin'])){ $msg ="MUST BE LOGGED IN"; header('location: ./?notin=true?msg=Must%20be%20logged%20In'); exit; }

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

$maxRows_rsEvents = 10;
$pageNum_rsEvents = 0;
if (isset($_GET['pageNum_rsEvents'])) {
  $pageNum_rsEvents = $_GET['pageNum_rsEvents'];
}
$startRow_rsEvents = $pageNum_rsEvents * $maxRows_rsEvents;

mysql_select_db($database_dbcon, $dbcon);
$query_rsEvents = "SELECT * FROM events";
$query_limit_rsEvents = sprintf("%s LIMIT %d, %d", $query_rsEvents, $startRow_rsEvents, $maxRows_rsEvents);
$rsEvents = mysql_query($query_limit_rsEvents, $dbcon) or die(mysql_error());
$row_rsEvents = mysql_fetch_assoc($rsEvents);

if (isset($_GET['totalRows_rsEvents'])) {
  $totalRows_rsEvents = $_GET['totalRows_rsEvents'];
} else {
  $all_rsEvents = mysql_query($query_rsEvents);
  $totalRows_rsEvents = mysql_num_rows($all_rsEvents);
}
$totalPages_rsEvents = ceil($totalRows_rsEvents/$maxRows_rsEvents)-1;

$queryString_rsEvents = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsEvents") == false && 
        stristr($param, "totalRows_rsEvents") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsEvents = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsEvents = sprintf("&totalRows_rsEvents=%d%s", $totalRows_rsEvents, $queryString_rsEvents);
?>
<? 
include_once('../inc/functions.php'); 
if(!headers_sent()){
  session_start();
  header('Cache-Control: no-cache');
  header('Pragma: no-cache');
  session_cache_expire(30); 
}
if(!isset($_SESSION['admin'])){ $msg ="MUST BE LOGGED IN"; header('location: ./?notin=true?msg=Must%20be%20logged%20In'); exit; }


if(isset($_POST['event'])){
	$musthave = frmMustHave(array('event', 'date1','hour','minutes', 'meridiem', 'location', 'description'));
	if(!is_null($musthave)){
		$dated=mysqldateconv($_POST['date1']);
		
	if(isset($_FILES['attachment'])){
		$i=0;
		foreach($_FILES['attachment'] as $key=>$values){
      		if(!isset($_FILES['attachment']['name'][$i]) ) { continue; } 
	  			if(preg_match('/(\w+).([gif|jpg|png|pdf|doc|docs|xls|xlsx|csv])$/i', $_FILES['attachment']['name'][$i], $matches) ){
					$path=realpath('../attachments/');//echo "$path <br />";
					if(is_uploaded_file($_FILES['attachment']['tmp_name'][$i])){
		         		$name = $path.'/'. $_FILES['attachment']['name'][$i];
		   				if(move_uploaded_file($_FILES['attachment']['tmp_name'][$i],  $name)){ $attachments[]=$name;}
		   				else{ $message[] .= $_FILES['attachment']['name'][$i] . " did not upload"; }
	     			}
				}//end preg match
			$i++;
	    }//end foreach
	}
	
	}
}
?>
<!DOCTYPE HTML>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>USAOA Events</title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" src="../js/epochCalsel.js"></script>
<script type="text/javascript" src="../scripts/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
 tinyMCE.init({
			  mode : "textareas",
			  theme : "advanced",
			  theme_advanced_toolbar_location : "top",
			  plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
			  theme_advanced_buttons1 :"|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			  theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			  theme_advanced_toolbar_align : "left",
			  theme_advanced_statusbar_location : "bottom",
			  editor_selector : "mscadv"
			  });
 </script>
<style type="text/css">
<!--
@import url("../js/epochCalstyle.css");
-->
</style>
<link href="css/default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include_once('header.php'); ?>
<div class="breadcrum"><ul>
  <li><a href="./">Home</a></li>
<li>Event Controls</li></ul></div>
  <form id="frmEvent" name="frmEvent" method="post" action="">
    <p>
      <label for="event">Event Name:</label>
      <input name="event" type="text" id="event" class="req" value="<?= $_POST['event']; ?>" size="25" maxlength="200" />
    </p>
    <p>
      <label for="dateandtime">Date and Time:</label>
      <script type="text/javascript">
	var dp_cal;
	window.onload = function () {
	dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('popup_container'));
	};
	</script>
      <input name="date1" class="date-pick" id="popup_container" placeholder="MM/DD/YYYY" value="<?= $_POST['date1']; ?>" size="25" maxlength="10" />
      <select name="hour">
        <? $i=1; 
	  while($i<= 12){
		  if($i < 10){ $i="0".$i; }
		  ?>
        <option value="<?=$i;?>">
        <?= $i; ?>
        </option>
        <?
	  $i++;
	  }?>
      </select>
      :
      <select name="minutes" id="minutes">
        <option value="00">00</option>
        <option value="15">15</option>
        <option value="30">30</option>
        <option value="45">45</option>
      </select>
      <select name="meridiem" size="1">
        <option value="am">AM</option>
        <option value="pm">PM</option>
      </select>
    </p>
    <p>
      <label for="location" >Location:</label>
      <input name="location" class="req"  type="text" id="location" placeholder="Hotel, Community" value="<?=$_POST['location']; ?>" size="25" maxlength="200" />
    </p>
    <p>
      <label for="address">Address:</label>
      <textarea name="address" class="req" cols="50%" rows="4" id="address" placeholder="Street address | City| State| zipcode"><?= $_POST['address']; ?>
</textarea>
    </p>
    <p>
      <label for="description">Description:</label>
      <textarea name="description" id="description" cols="80%" rows="15" class="mscadv"></textarea>
    </p>
    <p>
      <label for="file1">Attachment</label>
      <input type="file" name="attachment[]" id="file1" class="upload" />
    </p>
    <p>
      <input type="submit" name="Save" id="Save" value="Submit" />
    </p>
  </form>
  <table border="0" align="center" cellspacing="2" class="tabledata">
    <tr>
      <td>Event Title</td>
      <td>Start Time</td>
      <td>End Time</td>
      <td>Description</td>
      <td>Featured</td>
    </tr>
    <?php do { ?>
      <tr class="rowdata">
        <td><a href="event-details.php?recordID=<?php echo $row_rsEvents['eventID']; ?>"> <?php echo $row_rsEvents['title']; ?>&nbsp; </a></td>
        <td><?php echo $row_rsEvents['start_time']; ?>&nbsp; </td>
        <td><?php echo $row_rsEvents['end_time']; ?>&nbsp; </td>
        <td><?php echo $row_rsEvents['description']; ?>&nbsp; </td>
        <td><?php echo $row_rsEvents['featured']; ?>&nbsp; </td>
      </tr>
      <?php } while ($row_rsEvents = mysql_fetch_assoc($rsEvents)); ?>
  </table>
  <br>
  <table border="0">
    <tr>
      <td><?php if ($pageNum_rsEvents > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsEvents=%d%s", $currentPage, 0, $queryString_rsEvents); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_rsEvents > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rsEvents=%d%s", $currentPage, max(0, $pageNum_rsEvents - 1), $queryString_rsEvents); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_rsEvents < $totalPages_rsEvents) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsEvents=%d%s", $currentPage, min($totalPages_rsEvents, $pageNum_rsEvents + 1), $queryString_rsEvents); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_rsEvents < $totalPages_rsEvents) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rsEvents=%d%s", $currentPage, $totalPages_rsEvents, $queryString_rsEvents); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_rsEvents + 1) ?> to <?php echo min($startRow_rsEvents + $maxRows_rsEvents, $totalRows_rsEvents) ?> of <?php echo $totalRows_rsEvents ?> </div>
   <div>
     <p>Stuff</p>
   </div>
<script language="javascript" src="frmevent.js"></script> 
<script language="javascript" src="../js/uploads.js"></script>
  <? include_once('footer.php'); ?>
</body>
</html><?php
mysql_free_result($rsEvents);
?>
