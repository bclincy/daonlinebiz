<? 
  Header('Cache-Control: no-cache');
  Header('Pragma: no-cache');
require("../inc/functions.php");
start_page('category');
if(isset($_POST['newcategory']) && preg_match('/\w+/', $_POST['newcategory'])){ insertSingle(); }
if(isset($_REQUEST['processchanges'])){ updateCategory(); }
elseif(isset($_POST['multipleCatAdds'])){ multipleInsert(); }
else { displayCategory(); }

?>
<body>
<?
function updateCategory() {
   $i = 0;
// Check to see if anything needs to be updated, test to see if any were change
 if(isset($_POST['category_new'])){
     while($i < count($_REQUEST['category_new'])){ 
       if($_POST['category_new'][$i] != $_POST['category_old'][$i]){
	     $results = queryDB("UPDATE category SET category = '" . $_POST['category_new'][$i] . "' WHERE catID = " .$_POST['category_id'][$i]); 
		 $output = "Changes Were Made!";
	   }
	   $i++;
	}
   }
  if(isset($_POST['multipleAdds']) && $_POST['multipleAdds'] > 0){
	$i=0;
	$display = "<form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"POST\" name=\"additionADDs\" id=\"additionADDs\"><table border=\"0\" cellspacing=\"0\" align=\"center\">\n<tr><td>Adding Sub Categories to <strong>". $_POST['parentName'] . "</strong></td></tr>";
	while ($i < $_POST['multipleAdds']){
	   $display .= "<tr>\n<td><input type=\"text\" name=\"multiInsertCats[]\" size=\"25\" /></td></tr>";
	   $i++;
	}
	$display .= "<tr><td><input type=\"hidden\" name=\"displaySubCat\" value=\"". $_POST['parentID'] ."\"> <input type=\"hidden\" name=\"parentName\" value=\"". $_POST['parentName'] ."\"> <input type=\"submit\" name=\"multipleCatAdds\" value=\"Process\" /></td></tr></table></form>\n";
  }
  if(isset($display)){ echo $display; }
  if(isset($output)){ echo $output; }
  if(isset($_POST['remove']) && $_POST['remove'][0] != ''){ $i=0;
     while($i < count($_POST['remove'])){
	    echo "The one you selected and all items sub categories has been deleted <br>";
		$results = queryDB("DELETE FROM category WHERE catID = " . $_POST['remove'][$i]);
		echo "$results Initial deleted. <br>";
		$results = queryDB("DELETE FROM category WHERE parentID = ". $_POST['remove'][$i]);
		echo "$results Sub Categories Delete";
		$i++;
	 }
  }
  if(!isset($display)){ displayCategory(); }
} 
function displayCategory(){
// See if somebody is Requesting a Parent to list subCategory if not Get root
// Will also need to add who is the parent
 if(!isset($_REQUEST['displaySubCat'])){ $parentID = 0; $parentName = "Root"; }
 else { $parentID = $_REQUEST['displaySubCat']; $parentName = $_REQUEST['parentName']; }
 if(isset($_POST['parentID']) && $_POST['parentID'] > $parentID ){ $parentID = $_POST['parentID']; }
    $row = '';
    $results = queryDB("SELECT * FROM category");
    if($results == 0) { $row = "<tr><td colspan=\"3\">No Sub Category for $parentName</td></tr>\n"; }
	else{
	   while($records = mysql_fetch_assoc($results)){
	     $row .= "
	     <tr>
	        <td align=\"right\"><a href=\"?displaySubCat=". $records['catID'] . "&parentName=" . $records['category']. "\"> + </a></td>
	        <td align=\"center\"><input type=\"text\" name=\"category_new[]\" value=\"". $records['category'] . "\" size=\"25\"><input type=\"hidden\" name=\"category_old[]\" value=\"" . $records['category']. "\" size=\"25\"><input type=\"hidden\" name=\"category_id[]\" value=\"" . $records['catID']. "\" size=\"25\"> </td>
		    \n<td>";
			  if(queryDB("SELECT * FROM category WHERE parentID = "  . $records['catID']) != 0 ){
			    $row .= "<img src=\"../images/nodelete.gif\" alt=\"Has Sub Categories Delet them first\" />";
			  }
			  else{ $row .= "<input type=\"checkbox\" name=\"remove[]\" value=\"" . $records['catID'] . "\">";}
			$row .=" </td>
	     </tr> \n";
       }
	}
	?>
<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" name="category" id="category">
  <table border="0" cellpadding="2" cellspacing="0">
   <tr align="center" bgcolor="#CCCCCC">
     <td>Subs</td>
	 <td>Name</td>
	 <td>Delete</td>
   </tr>
   <tr>
      <td colspan="3" class="headline">Category Listing: <? echo $parentName; ?></td>
   </tr>
    <? if(isset($row)){	echo $row; }?>
    <tr>
      <td align="right">Add:</td>
      <td><input name="newcategory" type="text" id="newcategory" size="25"><input type="hidden" name="parentID" value="<? echo $parentID; ?>"><input type="hidden" name="parentName" value="<? echo $parentName; ?>" /></td>
    </tr>
	<tr>
	 <td colspan="3">Multiple Adds: 
	   <select name="multipleAdds" id="multipleAdds">
	     <option value="0" selected>0</option>
	     <option value="1">1</option>
	     <option value="2">2</option>
	     <option value="3">3</option>
	     <option value="4">4</option>
	     <option value="5">5</option>
	     <option value="7">6</option>
	     <option value="8">8</option>
	     <option value="9">9</option>
	     <option value="10">10</option>
        </select></td>
	</tr>
	<tr>
	  <td colspan="3"><input type="submit" name="processchanges" value="Process Changes"></td>
	</tr>
  </table>
</form>
	
	<?

}

function multipleInsert(){ 
  $i = 0;
  if(!isset($display)){ $display = ''; }
  while($i < count($_POST['multiInsertCats'])){ 
     if($_POST['multiInsertCats'][$i] != ''){
       $results = queryDB("INSERT INTO category VALUES ('', '" . $_POST['multiInsertCats'][$i] . "', " . $_POST['displaySubCat'] . ")");
	   $display .= "<strong>" . $_POST['multiInsertCats'][$i] . "</strong> was Added Successfully</br>";
	 }
	 $i++;
  }
  echo $display;
  displayCategory();
}
function insertSingle(){
   global $output;
   $check = queryDB("SELECT category FROM category WHERE category = '" . $_POST['newcategory'] . "'");
   if($check == 0){ 
     $results = queryDB("INSERT INTO category (category, parentID) VALUES ('". $_POST['newcategory'] . "', ". $_POST['parentID'] . ")");
	    if(isset($output)){ echo "<b>". $_POST['newcategory'] . "</b> has Been Added!<br>"; }
	    else { echo  "<strong>" . $_POST['newcategory'] . " </strong> has been added! <b> $results</b><br>"; }
  }
  else { echo $_POST['newcategory'] . " Already Exist! <br>"; }
}	  
?>
    <table>
      <tr>
        <td><a href="index.php">Controls</a></td>
        <td width="10">&nbsp;</td>
        <td><a href="pageCategories.php?displaySubCat=0&parentName=Roots">Category: Root </a></td>
		<td></td>
      </tr>
    </table>
</body>
</html>
