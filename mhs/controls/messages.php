<?
if(!headers_sent()){ session_start(); }
include_once('../inc/functions.php');
include_once('../Connections/dbcon.php');
mysql_select_db($database_dbcon, $dbcon);
if(isset($_POST['btnSend'])){
	//grab email from group
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
	if(!is_numeric($_POST['sendto'])){$sportid='NULL'; $senditto='\''. $_POST['sendto']. ' Officials\''; }
	else{ $senditto='NULL'; $sportid=$_POST['sendto']; }
	$dbattc=implode(',',$_FILES['attachment']['name']);
	$dbattc=rtrim($dbattc, ',');
	$insert="INSERT INTO messages (sportID, subject, message, msgfrom, edited, toother,attachments) VALUES(
	$sportid, '{$_POST['subject']}', '{$_POST['message']}', 'USA Sec, <info@usaofficialsassn.com>', now(), $senditto, '$dbattc')"; 
	$results=mysql_query($insert);
	$insertid=mysql_insert_id();
	if(strtotime('now') > strtotime(date('Y').'08-01')){
			$regyear=date('Y');
		}
		else{ $regyear=date('Y')-1; }
	switch ($_POST['sendto']) {
		case 'Active':
			$where="WHERE Status='Active' AND email !='' ";
			if(time() > strtotime(date(Y).'-05-1')){$where.='AND regyear='.date('Y');}
			break;
		case 'All':
			$where=" WHERE email !='' AND  regyear=$regyear";
			break;
		case 'inactive':
		  $dated=date('Y')-1;
			$where="WHERE regyear=$dated AND email !=''";
			break;
		default:
		if(time() > strtotime(date('Y').'-08-01')){
			$regyear=date('Y');
		}
		else{ $regyear=date('Y')-1; }
		$where=" JOIN officialsports ON MHSAAID=mhsaa_id WHERE sport_id={$_POST['sendto']} AND regyear=$regyear ";
		break;
	} 
	$sql="SELECT CONCAT (fname, ' ', lname) as name, email, altemail FROM users $where";
	$results=mysql_query($sql); 
	if($results){
		while($records=mysql_fetch_assoc($results)){
		   $records['name']=str_replace(',', ' ', $records['name']);
		   $update[]="{$records['name']} {$records['email']} {$records['altemail']}";
			multi_attach_mail("{$records['name']} <{$records['email']}>, {$records['altemail']}",
			$attachments,'info@usaofficialsassn.com',stripslashes($_POST['subject']), stripslashes($_POST['message']));
		}
		$numofpeople= count($update);
		$sentto=implode('<br />', $update);

		$_POST['message']= "<h1>Online Message Center</h1><p>For your records the following message was sent to $numofpeople :<br> $sentto". $_POST['message']; 
		multi_attach_mail( 'info@usaofficialsassn.com, bclincy@gmail.com', $attachments, 'Web Message Center <info@usaofficialsassn.com>', stripslashes($_POST['subject']), stripslashes($_POST['message'])); 
	}
	include('messageslist.php'); exit;
		
}


if(!headers_sent()){
  session_start();
  header('Cache-Control: no-cache');
  header('Pragma: no-cache');
  session_cache_expire(30); 
}
if(!isset($_SESSION['admin'])){ $msg ="MUST BE LOGGED IN"; header('location: ./?notin=true?msg=Must%20be%20logged%20In'); exit; }

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Messages</title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="../scripts/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link href="css/default.css" rel="stylesheet" type="text/css">
<style type="text/css">
#addfiles {
	display: none;
}
</style>
</head>

<body>
<? include_once('header.php'); ?>
<div class="breadcrum">
<ul><li><a href="./">Home</a></li><li>Messaging</li></ul>
</div>
  <script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "message",
		theme : "advanced",
		skin : "default",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

// Theme options
		theme_advanced_buttons1 : "save,newdocument,print,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,|,image,media,|,forecolor,backcolor,|,insertdate,inserttime,",
		theme_advanced_buttons3 : "hr,cite,abbr,acronym,del,ins,sub,sup,visualchars,nonbreaking,charmap,emotions,ltr,rtl,|,code,preview,fullscreen,help,cleanup,removeformat,|,styleprops,attribs,",
		theme_advanced_buttons4 : "tablecontrols,visualaid,|,insertlayer,moveforward,movebackward,absolute,visualaid,|,template,pagebreak,restoredraft,",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/editor_styles.css",

		// Drop lists for link/image/media/template dialogs, You shouldn't need to touch this
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats: You must add here all the inline styles and css classes exposed to the end user in the styles menus
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		]
	});
			
  </script>
<form action="messages.php" method="post" enctype="multipart/form-data" name="frmMessg" id="frmMessg">
<h2>Email Officials</h2>
<p>
<?
if(time() > strtotime(date('Y').'-08-01')){ 
	  	 $sql="SELECT sportID, sport, count(mhsaa_id) as num FROM sports JOIN officialsports ON sportID=sport_id  JOIN users ON mhsaa_id =MHSAAID WHERE regyear=".date('Y')." GROUP BY sport_id ORDER BY num DESC";

  }
  else{$year=date('Y')-1;
     $sql = "SELECT sportID, sport, count(mhsaa_id) as num FROM sports JOIN officialsports ON sportID=sport_id  JOIN users ON mhsaa_id =MHSAAID WHERE regyear=$year GROUP BY sport_id ORDER BY num DESC"; }
  ?>
  <label for="sendto">Send To:</label>
  <select name="sendto" id="sendto">
    <option value="Active">Active Officials</option>
  <option value="All">All Officials</option>
  <option value="inactive">Inactive</option
  ><? 
  
  $results=mysql_query($sql);
  if($results){
	  while($records=mysql_fetch_assoc($results)){
		  echo "<option value=\"{$records['sportID']}\">{$records['sport']} ({$records['num']})</option>\n";
	  }
  }
  ?>
  </select>
</p>
<p>
  <label for="subject">Subject:</label>
  <input name="subject" type="text" id="subject" size="20" maxlength="155" />
</p>
<p>
  <label for="message">Message:</label>
  <textarea name="message" cols="50" rows="12" id="message"  style="font-size:12px;"><p>&nbps;</p><p>Rick Anderegg<br>Secretary/Treasurer<br>USA Officials Association</p></textarea>
</p>
<p>
  <label for="attachments">Attachment:</label>
  <input type="checkbox" name="attachments" id="attachments" value="1" />
</p>
<div id="addfiles">
<p>
  <label for="file1">Attachment</label>
  <input type="file" name="attachment[]" id="file1" class="upload" />
</p>
</div>
<p><label for="btnSend">&nbsp;</label>
<input type="submit" value="Send" name="btnSend" />
<script src="../js/ext.js"></script>
</form>

<? include_once('footer.php'); ?>
</body>
</html> 