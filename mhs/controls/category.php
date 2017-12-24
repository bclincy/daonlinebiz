<? 
if(!headers_sent()){
   session_start();
   if(!isset($_SESSION['adminusr'])){ $msg ="MUST BE LOGGED IN"; include_once('index.php'); exit; }
   Header('Cache-Control: no-cache');
   Header('Pragma: no-cache');
   session_cache_expire(30); 
}
include_once('../inc/functions.php');
$activity = "Category Pages"; 
?>
<!doctype html> 
<html lang="en"> 
<head>
<meta charset="UTF-8">
<title>Category Page</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>
<? include_once('header.php'); ?>
<?php

require "catclass.php";
$params = array(
'separator'=> '&nbsp; / &nbsp;',
'area' => 'admin',              //or client
'seo' => true                //if false it can't produce seo link
);

$phpcat = new php_cat($parametres);
//var_dump($phpcat);


$data['cat_id'] = $_GET['category_id'];                   //you can list categories by cat_id
$path_row = $phpcat->path($data); //breadcrumb
foreach($path_row as $row){
$ahref = "<a href=\"category.php?category_id={$row['cat_id']}\">"; //you can set also $row['cat_id'];
$a = "</a>";
echo $ahref.$row['cat_name'].$a.$phpcat->separator;
}
?>
<hr />
<?php
/***************************************************************************/
  $add_data['cat_id'] = $_POST['parent'];         //under parent cat_id in mysql table (add under the...)
  $add_data['parent_id'] = $_POST['parent_id'];  //parent_id in mysql table
  $add_data['new_name'] = $_POST['new_name']; //new category name.
  $add_data['dsc'] = $_POST['dsc']; //category description.
/***************************************************************************/
  //if no record in database.
  if(isset($_POST['add']) && $phpcat->fetch_num() == 0){
  $phpcat->add_cat($add_data);

  //if category has children use add_cat
  }elseif(isset($_POST['add']) && $_POST['children'] > 0){
  $phpcat->add_cat($add_data);

  //if category has no children use add_subcat
  }elseif(isset($_POST['add']) && $_POST['children'] == 0){
  $phpcat->add_subcat($add_data);

  }elseif($_GET['del']){
  $del_data['cat_id'] = $_GET['cat_id'];
  $phpcat->del_cat($del_data);

  }elseif(isset($_POST['edit'])){
  $update_data['cat_id'] = $_POST['cat_id'];
  $update_data['new_name'] = $_POST['new_name'];
  $update_data['dsc'] = $_POST['dsc'];
  $phpcat->update_cat($update_data);
  }

?>
<table align="center" class="list_category">
<tr>
<th width="76%"><b>Category</b></th>
<th width="24%"><b>Options</b></th>
</tr>
<?php
$result = $phpcat->list_cat($data);          //list categories..
$children = count($result);                  //count how many sub categories ?

if(!empty($result)) {
foreach($result as $row){ ?>

  <tr>
  <td>&nbsp;
  <a href="category.php?category_id=<?=$row['cat_id']?>"><b><?=$row['cat_name']?></b>
  </a>
  </td>

  <td>
  &nbsp;
  <a href="category.php?category_id=<?=$_GET['category_id']?>&amp;cat_id=<?=$row['cat_id']?>&amp;del=true">Delete</a>
  &nbsp;|&nbsp;
  <a href="category.php?category_id=<?=$_GET['category_id']?>&amp;edit_id=<?=$row['cat_id']?>&amp;cat_id=<?=$row['cat_id']?>">Edit</a>
  </td>
  </tr>

  <!-- CAT EDIT START -->
  <? if($_GET['edit_id'] == $row['cat_id']) {?>
  <tr>
  <td colspan="2">
  <div style="padding:8px;">
  <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post" name="update_form">
  <input type="text" name="new_name" size="30" value="<?=$row['cat_name']?>" />
  <textarea name="dsc" cols="35"><?=$row['dsc']?></textarea>
  <input name="cat_id" type="hidden" value="<?=$_GET['cat_id']?>" />
  <input type="submit" name="edit" value="Update" />
  </form>
  <div>
  </td>
  </tr>
  <? } ?>
  <!-- CAT EDIT END -->

<?php
} //end foreach result..
} else {  //if empty result !!
?>
  <tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<?php
} //empty result end.
?>
</table>

<br>
<!-- ADD CATEGORY TABLE START -->
<form name="form2" method="post" action="<?=$_SERVER['REQUEST_URI'];?>">
<table align="center" class="list_category">
<tr>
<th colspan="2" align="center">
<strong>Add New <? if($children == 0 && $phpcat->fetch_num() !== 0) {
echo "<font color=red>SubCategory</font>";} else { echo "<font color=red>Category</font>";}?></strong>
</th>
</tr>

<tr>
<td><b>Add under the:</b></td>
<td>
<?php
## PARENT ##
if(!empty($result)) {
echo "<select name=\"parent\" size=\"1\">";
foreach($result as $row){
echo "<option value=\"{$row['cat_id']}\">{$row['cat_name']}</option>";
}
echo "</select>";
}else{
echo "<input name=\"parent\" type=\"hidden\" value=\"{$_GET['category_id']}\">"; //mysql cat_id
}
## PARENT ID ##
echo "<input name=\"parent_id\" type=\"hidden\" value=\"{$_GET['category_id']}\">"; //mysql parent_id

?>
</td>
</tr>

<tr>
<td><b>Category Name:</b></td>
<td>
<input name="new_name" type="text" value="" size="35">
</td>
</tr>

<tr>
<td><b>Description:</b></td>
<td>
<textarea name="dsc" cols="35"></textarea>
</font></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>
<input type="hidden" name="children" value="<?=$children;?>" />
<input type="submit" name="add" value="Add Category" />
</td>
</tr>

</table>
</form>
<!-- ADD CATEGORY TABLE END -->
<? include_once('footer.php'); ?>