<?
if(!headers_sent()){
  session_start();
  header('Cache-Control: no-cache');
  header('Pragma: no-cache');
  session_cache_expire(30); 
}
if(!isset($_SESSION['admin'])){ $msg ="MUST BE LOGGED IN"; header('location: ./?notin=true?msg=Must%20be%20logged%20In'); exit; }
include_once('../inc/functions.php'); 
require_once('../Connections/dbcon.php');
mysql_select_db($database_dbcon, $dbcon);
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
	if(isset($_POST['emails']) && is_array($_POST['emails'])){
		$sendto=implode($_POST['emails'], ',');
		$dbattc=implode(',',$_FILES['attachment']['name']);
		$dbattc=rtrim($dbattc, ',');
		if(empty($dbattc)){ $dbattc='NULL'; }
		else{ $dbattc="'". $dbattc. "'"; }
		$insert="INSERT INTO messages (sportID, subject, message, msgfrom, edited, toother,attachments) VALUES(
		NULL, '{$_POST['subject']}', '{$_POST['message']}', 'USA Sec, <info@usaofficialsassn.com>', now(), '$sendto', $dbattc)";
		$results=mysql_query($insert);
		$succesful=sprintf( "%d", mysql_affected_rows());
		multi_attach_mail($sendto, $attachments,'info@usaofficialsassn.com',$_POST['subject'], stripslashes($_POST['message']));
	
	}//end send email
	if(isset($_POST['emails']) && !empty($_POST['emails'])){
		$sendto=$_POST['emails'];
		if(empty($dbattc)){ $dbattc='NULL'; }
		else{ $dbattc="'". $dbattc. "'"; }
		$insert="INSERT INTO messages (sportID, subject, message, msgfrom, edited, toother,attachments) VALUES(
		NULL, '{$_POST['subject']}', '{$_POST['message']}', 'USA Sec, <info@usaofficialsassn.com>', now(), '$sendto', $dbattc)";
		$results=mysql_query($insert);
		$succesful=sprintf( "%d", mysql_affected_rows());
		$sendto.=', info@usaofficialsassn.com';
		multi_attach_mail($sendto, $attachments,'info@usaofficialsassn.com',$_POST['subject'], stripslashes($_POST['message']));
		include_once('messageslist.php'); exit;
	}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Email Officials:</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>

<body> 
<? include_once('header.php'); ?>
<p>All Officials</p>
<p>Sports</p>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="emailusrs" id="emailusrs">
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
<p>
  <label for="emails">Select Users</label>
  <select name="emails" size="10" multiple id="emails"><?
  if(!is_null($_REQUEST['userid'])){
	$results=mysql_query(sprintf("SELECT CONCAT(fname, ' ', lname) as name, email FROM users WHERE userID = %d", mysql_real_escape_string($_REQUEST['userid'])));
	$select=true;
  }
  else{ $results=mysql_query("SELECT CONCAT(fname , ' ', lname) as name, email FROM users ORDER BY lname"); }
if($results!=0){
	while($records=mysql_fetch_assoc($results)){
		$records['name']=str_replace(',', ' ', $records['name']);
		echo "<option value=\"{$records['name']} <{$records['email']}>\"";
		if($select){ echo " selected=\"selected\" "; }
		echo ">{$records['name']} {$records['email']}</option>\n";
	}
}
?>
  </select>
</p>
<p>
<label for="subject">Subject</label><input name="subject" type="text" size="32" maxlength="200"></p>

<p>
<label for="message">Message:</label>
<textarea name="message" id="message" cols="80" rows="25" class="mscadv"><?= reposted('message'); ?></textarea><?=$msg['description']; ?></p>
<p><input name="btnEmail" type="button" value="Send Message" onClick="document.emailusrs.submit();"></p>
</form>
<? include_once('footer.php'); ?>
</body>
</html>