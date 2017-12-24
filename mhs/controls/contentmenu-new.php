<?
session_start();
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
session_cache_expire(30);
//check the data make sure it not her
include_once('../inc/functions.php'); 
if(!isset($ok)){ 
  unset($_POST['nickname']); 
  $error="Bad Referrer: Not set here";
  include('contentmenus.php'); exit;
}
elseif(!isset($_POST['nameID'])){
	$sl="INSERT INTO pagemenu_names (nickname, lastmodified) VALUES ('{$_POST['nickname']}', now())";
    $results=queryDB($sl);
	if($results == 1){$nameID=mysql_insert_id();}
	else{error('#bad in pagemenu', "Serious"); }
}
if(isset($_POST['docket'])){
   if(is_numeric($_POST['docs']) && $_POST['docs'] !=0){ 
      $sql = "INSERT INTO pagemenu (menuID, docID, modified, name ) VALUE ({$_POST['nameID']},{$_POST['docs']}, now()";
	  if(!empty($_POST['docshowas']) && !preg_match('/^\s+$/', $_POST['catshowas'])){ $sql.=", '{$_POST['docshowas']}')";}
	  else{$sql.=", 'Need Rename')"; }
   }
   elseif(isset($docconv[$_POST['docs']])){ 
     $sql="INSERT INTO pagemenu (menuID, filename, modified, name) VALUES({$_POST['nameID']},'".$docconv[$_POST['docs']]."', now()"; 
	 if(!empty($_POST['docshowas']) && !preg_match('/^\s+$/', $_POST['catshowas'])){ $sql.=",'{$_POST['docshowas']}')";}
	 else{$sql.=",'". $_POST['docs']."')"; }
   }
}
elseif(isset($_POST['addcat'])&&$_POST['categoryID']!=0){
   $sql="INSERT INTO pagemenu (menuID, catID, modified, name) VALUES({$_POST['nameID']},{$_POST['categoryID']}, now()";
	if(isset($_POST['catshowas']) && !empty($_POST['catshowas']) && !preg_match('/^\s+$/', $_POST['catshowas'])){ 
	 $sql.=", '{$_POST['catshowas']}')";
	}
	else{$sql.=", NULL)"; }
}
elseif(isset($_POST['removeBtn']) && is_numeric($_POST['remove'])){ 
  $sql="DELETE from pagemenu WHERE id = {$_POST['remove']} LIMIT 1"; 
}
if(isset($sql)){ $results=queryDB($sql); }
$docconv=array(
			'contact'=>'contact.php', 'about'=>'about.php','facebook'=>'facebook.php', 'volunteer'=>'volunteer.php',
			'link'=>'link.php', 'donations'=>'difference.php', 'endorsement'=>'endorsementlist.php');
$title='Create Menu';
$activity='Create Menu';
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
<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" enctype="application/x-www-form-urlencoded" name="savemenu"><input type="hidden" name="nameID" value="<? if(isset($nameID)){echo "$nameID"; } else{ echo $_POST['nameID']; }?>" />
<div class="lf2col">
<h3>Menu <?="for ".$_POST['nickname']; ?><input type="hidden" value="<?=$_POST['nickname'];?>" name="nickname" /></h3>	
<? 
$sql="SELECT *
FROM pagemenu p
JOIN pagemenu_names pn On menuID =pn.id";/*docs d ON docID = d.ID
LEFT JOIN category c ON c.cat_id = p.catID";*/

$results = queryDB($sql);
if($results == 0){ echo "No menu items"; }
else{
	echo "REMOVE: <select name=\"remove\">";
	while($records=mysql_fetch_assoc($results)){
		echo "<option value=\"{$records['id']}\">{$records['name']}-";
		if(isset($records['title'])){ echo "Title:: ".$records['title']; }
		elseif(isset($records['cat_name'])){ echo "Category:: ".$records['cat_name'];}
		elseif(isset($records['filename'])){ echo "Apps:: ". array_search($records['filename'],$docconv); }
		echo"</option>"; 
	}
	echo "</select>\n<input type=\"submit\" name=\"removeBtn\" id=\"removeBtn\" value=\"Remove\" />";
}
?>
</div>
<div class="rt2col">
<h3>Add a Category</h3>
<? echo listcats(); ?> Rename: 
<input name="catshowas" type="text" size="15" maxlength="50" />
<input type="submit" name="addcat" id="addcat" value="Save" />
<h3>Add a Doc</h3>
<select name="docs" id="docs">
<option value="0">Select One</option>
<? 
foreach($docconv as $key => $value){
	echo "<option value=\"$key\">".ucfirst($key)."</option>\n";
}
$results=queryDB("SELECT ID, title FROM docs");
if($results != 0){ 
   while($records=mysql_fetch_assoc($results)){ 
      echo "<option value=\"{$records['ID']}\">{$records['title']}</option>";
   }
}
?>
</select>
Rename:
<input name="docshowas" type="text" id="docshowas" size="20" maxlength="50" /> 
<input type="submit" name="docket" id="docket" value="Save" />
</div>
</form>
<p style="clear:both">Form Preview</p>
<?
if(isset($_POST['nameID'])){ $menuid = $_POST['nameID']; }// makes it so I won't error out sql statement with an empty set
else{ $menuid =0; }
$sql="SELECT *
FROM pagemenu p
LEFT JOIN docs d ON docID = d.ID
LEFT JOIN category c ON c.cat_id = p.catID WHERE menuID={$_POST['nameID']}";

$results = queryDB($sql);
if($results != 0){
 while($records = mysql_fetch_assoc($results)){
  	  if(isset($records['cat_id'])){ 
	    $menu .= "<li><a href=\"/show.php?cat_id={$records['cat_id']}\">";
	    if(isset($records['name'])){ $menu .= ucfirst($records['name'])."</a></li>";}
	    else{ $menu.=ucfirst($records['cat_name'])."</a></li>\n"; }
	  }
	  elseif(isset($records['docID'])){
	  	  $menu.="<li><a href=\"docs.php?id={$records['docID']}\">";
	      if(isset($records['name'])){ $menu .= ucfirst($records['name'])."</a></li>";}
	      else{ $menu.=ucfirst($records['cat_name'])."</a></li>\n"; }
	  }
	  elseif(isset($records['filename'])){ 
	     $menu.="<li><a href=\"/{$records['filename']}\">".ucfirst($records['name'])."</a></li>\n";
	  }
	
  }
}//results

if(isset($menu)){ echo "<ul id=\"navigation\">$menu</ul>"; }
?>
<? include_once('footer.php'); ?>

