<? 
include_once('../inc/functions.php');
include_once('../Connections/dbcon.php');
mysql_select_db($database_dbcon, $dbcon);
$activity='New Document '. $_POST['title'];
if(isset($_POST['Save']) && $_POST['categoryID'] != 0){
    $musthave = frmMustHave('title', 'content');
    if(musthave!=NULL){ $msg = "Must Have"; }
	if(isset($_SESSION['userID'])){ $authorID= $_SESSION['userID']; }
	else{$authorID=1; }
     $sql = "INSERT INTO docs (authorID, title, description, keywords, content, doc_date,
		catID) VALUES ($authorID, '{$_POST['title']}', '{$_POST['description']}',
		'{$_POST['keywords']}','{$_POST['doc']}', now(), 		
		{$_POST['categoryID']}) 
		ON DUPLICATE KEY UPDATE content='{$_POST['doc']}', keywords='{$_POST['keywords']}', doc_date=now(), description='{$_POST['description']}', title='{$_POST['title']}', authorID=$authorID";
	$results = queryDB($sql);
	$id = mysql_insert_id(); 
    $uploaded = multiupload($id, 'picture');
	$updateGoTo = "content.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
elseif(isset($_POST['Save']) && $_POST['categoryID']== 0){ 
   $msg="Please Select a category"; $error['categoryID']= "* $msg";
}
elseif(isset($_POST['Save']) && empty($_POST['doc'])){ $msg ="Content is required field"; $error['doc'] = '* content field is required'; }
?>
<!doctype html> 
<html lang="en"> 
<head>
<meta charset="UTF-8">
<title>Content New Document <?= $title; ?></title>
<script type="text/javascript" src="../scripts/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<link href="css/default.css" rel="stylesheet" type="text/css">
<script type="text/xml">
<!--
<oa:widgets>
  <oa:widget wid="2204022" binding="#doc" />
</oa:widgets>
-->
</script>
</head>
<body>
<? include_once('header.php'); ?>
<div class="breadcrum">
<ul><li><a href="./">Home</a></li><li><a href="content.php">Content</a></li><li>New Content</li></ul>
</div>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="newdocs" class="formstyles" id="form1">
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
<? if(isset($msg)){ echo "<h2>$msg</h2>"; } ?>
  <p><label for="categoryID">Category :</label><?  if(reposted('categoryID')){ echo listcats( 'Content' , $_POST['categoryID']); } else{ echo listcats('Content');} ?> *<? if(isset($error['categoryID'])){ echo "<span class=\"error\">{$error['categoryID']}</span>"; } ?></p>
  <p>
  <label for="title">Title:</label>  <input name="title" type="text" id="title" size="35" maxlength="266" value="<?= reposted('title'); ?>"/>
  *</p>
  <p>
    <label for="keywords">Tags/Keywords:</label>
    <input name="keywords" type="text" id="keywords" size="35" maxlength="255" value="<?= reposted('keywords'); ?>"/>
  </p>
  <p>
   <label for="description">Short Description:</label>
    <input name="description" type="text" id="description" value="<?= reposted('description'); ?>" size="25" maxlength="255">
  </p>
  
  <p>
  <label for="doc">Content:</label>
  <script type="text/javascript">
// BeginOAWidget_Instance_2204022: #postContent

	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "doc",
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
		
// EndOAWidget_Instance_2204022
  </script>
  <!-- Textarea gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
  <textarea id="doc" name="doc" rows="20" style="width:70%"><?= stripslashes($_POST['doc']); ?></textarea>
<? if(isset($error['doc'])){ echo "<span style=\"error\">{$error['doc']}</span>"; } ?>
	 *
  </p>
  <p>
    <label for="frontpage">Add to Frontpage:</label>
    <input type="checkbox" name="frontpage" id="frontpage">
  </p>
  <fieldset>
  <legend>Adding Images</legend>
  <? 
  if(!isset($_POST['numofpixs'])){ $numofpix = 3; }
  else{$numofpix = $_POST['numofpixs']; }
  ?><p><label for="numofpix">Number of Images:</label><select name="numofpixs" onchange="document.newdocs.submit();">
  <? 
  $i=1;
  while($i<=10){
	  echo "<option value=\"$i\"";
      if($numofpix==$i){echo "selected=\"selected\""; }
	  echo ">$i</option>\n"; $i++;
  }
 ?></select></p>
  <?
 $i=1;
  do{?>
  <p>
    <label for="picture">Picture
      <?=$i; ?></label>
      <input type="file" name="picture[]" id="picture<?= $i; ?>" />  
  </p>
  <? $i++;} while($i <=$numofpix); ?>
 </fieldset>
 <p><label for="alignment">alignment of images</label> Left <input type="radio" value="left" id="left" name="alignment" /> Right <input type="radio" value="right" name="alignment" id="right">
  
</p>

 <input type="submit" name="Save" value="Save" id="Save" />  
 </form>

<? include_once('footer.php'); ?>
</body>
</html>