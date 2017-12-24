<?
// Library list of common used funtions.
// Query DB Access database and retrieve or input data into DB

// dateformat - Formats date for forms input for What ever
// error - Error Reporting function that reports errors to screen 2 Arguments $msg - Displayed Error, $serious- which link to display
// serverNameFormat - Format the server Name for email address only return core server name
// isEmailValid - check the format of email address $email - email address to check!
// startPage - start html for title of the page and setup a global varible to make check before calling again: $title - page title
// formMustHave -form validator, what keys does the form need to have and returns a key needs value for if problem and zero if not.
// 
function queryDB($sql){
	$db = mysql_pconnect("localhost", "daonline_mhsuser", "bcuz1Isb");
		mysql_select_db("daonline_mhs", $db);
	$results = mysql_query($sql);
	if(!$results){ error("INVALID QUERY ". mysql_error(), "Results returned NO Value at all");}
	elseif(preg_match('/update|delete|insert/i', $sql)){ return sprintf( "%d", mysql_affected_rows()); }
	elseif(mysql_num_rows($results) > 0){ return $results; }
	elseif(mysql_num_rows($results) == 0 ){ return 0; }
	else{ die("Results All results test have come up failed"); }
}
 
function dateformat() {
// limited to current year unless it's in last 3 months of the year, then next year available.
	    $return = "<select name=\"month\" id=\"month\">\n
        <option value=\"01\" selected>Jan</option>\n
        <option value=\"02\">Feb</option>\n
        <option value=\"03\">Mar</option>\n
        <option value=\"04\">Apr</option>\n
        <option value=\"05\">May</option>\n
        <option value=\"06\">June</option>\n
        <option value=\"07\">July</option>\n
        <option value=\"08\">Aug</option>\n
        <option value=\"09\">Sep</option>\n
        <option value=\"10\">Oct</option>\n
        <option value=\"11\">Nov</option>\n
        <option value=\"12\">Dec</option>\n
      </select> &nbsp; &nbsp; <select name=\"day\" id=\"day\">";
	  $i = 1; 
	     while ($i <= 31) { 
		 	if($i <= 9) {$return .="<option value=\"0$i\">0$i</option>"; }
			else {$return .="<option value=\"$i\">$i</option>\n";  }
			$i++;
		}
      $return .= "</select> &nbsp; &nbsp; <select name=\"year\" id=\"year\">";
	  if(date("m") > 9){   $year = date("Y") + 1; }
	  else{ $year = date("Y"); }
	  $i = 1920;  
	     while ($year >= $i) {
		    $return .= "<option value=\"$year\">$year</option>\n";
			$year--;
		}
		$return .="   </select>\n"; 
		return $return;

}
 function error ($msg, $serious = '') {

	// if the page has already been set up, just show a small header
	if (isset($set_up)) {
		echo "<H2>Whoops</H2>";

	// otherwise set up the page to show that an error has occured
	} else {
		start_page ("Error", "Whoops");
	}
	echo "<p>Sorry. There has been an error (".$msg.").<BR><br>";

	// if 'serious' is true (the second argument passed in a call to this function)
	// then the user must return all the way to the site entrance
	if ($serious != '') {
		echo "<A HREF='index.php'>Please click here to return to the site entrance.</A>";

	// if its not a 'serious' error then the user has to go to the main thread listing page
	} else {
		echo "<A HREF='index.php'>Please click here to return to the main page.</A>";
	}

	// show a link to mail the technical help
	echo "<BR><BR><A HREF='mailto:webmaster@". serverNameformat()."?subject=$msg'>Click here to inform
		our technical staff of this problem.</A></p>";
	exit;
}

function serverNameFormat(){
  return preg_replace('/^w{3}\./', '', $_SERVER['HTTP_HOST']);
}

function isValidEmail ($email) {
	return eregi("^[a-z0-9_]+@[a-z0-9\-]+\.[a-z0-9\-\.]+$", $email);
}
 function start_page ($title){
 	echo "
	<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
        <link href=\"standard.css\" rel=\"stylesheet\" type=\"text/css\"> 		
		<TITLE>".$title."</TITLE>
		<script language=\"javascript1.2\" src=\"../inc/functions.js\"></script>
		<script type=\"text/javascript\" src=\"../scripts/ckeditor/ckeditor.js\"></script>
	<script src=\"../scripts/ckeditor/sample.js\" type=\"text/javascript\"></script>
	<link href=\"../scripts/cheditor/sample.css\" rel=\"stylesheet\" type=\"text/css\" />
		</head>";

	// set up a global variable to show that the page has been set up
	global $set_up;
	$set_up = TRUE;
 }		
function test(){
	foreach ($_REQUEST as $key => $val){
		echo "$key => $val <br>";
		}
}
function breadcrum($parentID){
  $results = queryDB("SELECT * FROM pagecategory WHERE parentID = " . $parentID);
  if($results == 0){ return '<a href="contactus.php">Contact us</a>'; }
  $display_breadcrum = ''; $i = 1;
  while($records = mysql_fetch_assoc($results)){
    $display_breadcrum .= ':: <a href="/document.php?cat_display=' . $records['catID'];
     $display_breadcrum .= '">' . $records['category'] . ' </a> ';
     $i++;
  }
return $display_breadcrum;
}
function unhtmlentities ($string){
	$trans_tbl = get_html_translation_table (HTML_ENTITIES);
	$trans_tbl = array_flip ($trans_tbl);
	return strtr ($string, $trans_tbl);
}
function editableStr($str){
   $str = unhtmlentities($str);
    $str = preg_replace('/\\\+\'/', '\'', $str);
    return preg_replace('/\\\+\"/', '"', $str);
}
function docsbyCategory(){
   $sql = "SELECT ID, title, category FROM docs, pagecategory WHERE docs.catID =pagecategory.catID ORDER BY category";
   $results = queryDB($sql);
   if($results == 0){ return 'No Documents: You must first <a href="?page=new">Add Documents</a>.'; }
   $display_docs = "<select name=\"docID\">"; 
   $lastCategory = '';
   while($records = mysql_fetch_assoc($results)){
     if($lastCategory != $records['category']){
       $display_docs .= '<option value="NonSelected">' . $records['category'] . " - Category </option>\n";
       $display_docs .= '<option value="' . $records['ID'] . '">&nbsp;&nbsp;' . stripslashes($records['title']) . "</option>\n";
       $lastCategory = $records['category'];
     }
     else { $display_docs .= '<option value"' .$records['ID'] . '">&nbsp;&nbsp;'. stripslashes($records['title']) . "</option>\n";}
   }
   return $display_docs . "</select>";
}
function sortoftitle($objectToOrder, $order, $name){
    $sql = "Select title, ID FROM docs ORDER BY $objectToOrder $order";
    $results = queryDB($sql);
    if($results == 0){ return 'No Documents: You must first <a href="?page=new">Add Documents</a>'; }
    $display_doc = "<select name=\"$name\">";
    while($records = mysql_fetch_assoc($results)){
      $display_doc .= '<option value="'. $records['ID'] . '">' . stripslashes($records['title']) . "</option>\n";
    }
    $display_doc .="</select>";
    return $display_doc;
}
function stateSelect($selected = null) {
	$results = queryDB("SELECT * FROM states ORDER BY state");
     $display = "<select name=\"stateID\" id=\"stateID\">\n";
	While($records = mysql_fetch_assoc($results)){
	  if($records["stateID"] == 27 && $select == NULL) { $display .= "<option value=\"" . $records["stateID"] . "\" selected > ". $records["state"] . "</option>\n"; }
	  elseif($records["stateID"] == $select) {$display .= "<option value=\"" . $records["stateID"] . "\" selected > ". $records["state"] . "</option>\n"; }
	  else {$display .= "<option value=\"" . $records["stateID"] . "\">". $records["state"] . "</option>\n"; }
    }
	$display .="</select>";
	return $display;
}
function secquestion($id=NULL){
	$results=queryDb("SELECT * FROM secQuestions"); 
	if($results==0){ return "No Records"; }
	$display = "<select name=\"secquestID\" id=\"secquestID\">\n";
	while($records=mysql_fetch_assoc($results)){
		$display .= "<option value=\"" .$records['ID']. "\"";
		if($records['ID']== $id){ $display.= " selected=\"selected\""; }
		$display.=">{$records['question']}</option>\n";
	}
	$display .="</select>";
	return $display;
}
function selectID ($selname, $tablename, $optionvalue, $option, $selected=null, $order = null){
	//echo "SELECT $optionvalue, $option FROM $tablename $order"; 
	echo $selected;
  $results = queryDB("SELECT $optionvalue, $option FROM $tablename $order");
  if($results == 0){ return "No Record"; }
  $display = "<select name=\"$selname\" id=\"$selname\">\n";
  while($records = mysql_fetch_assoc($results)){
	  
    $display .= "<option value=\"" . $records[$optionvalue];  
	if($selected==$optionvalue){ $display.=" selected=\"selected\" "; } 
	$display.="\">". $records[$option] . "</option>\n";
  } 
	$display .="</select>";
	return $display;
}
function frmMustHave($arrMustHave) {
   // if form submitted doesn't have this send str of the unfound value
   if(!is_array($arrMustHave)){ 
       if(!isset($_REQUEST[$arrMustHave]) || empty($_REQUEST[$arrMustHave])){ return $arrMustHave; }
	   else { return null; }
	}//error('Error 00TPF01, Tech: Failure to send array to checkValues', ''); }
   foreach($arrMustHave as $values) { 
     if(!isset($_REQUEST[$values]) ){$return[]=$values;  } 
	 if(empty($_REQUEST[$values])){ $return[]=$values; }
   }
   if(is_array($return)){ return $return; }
   return NULL;
}

function phpSafe($strText) {
 //removes backslash created by php from the string
    $tmpString = $strText;
    $tmpString = str_replace(chr(92), "", $tmpString); 
    return $tmpString;
}
function httpfileup($filename, $id = '' ){
    if(!isset($_FILES[$filename]) ) {return FALSE; } 
    if( preg_match('/(\w+).([gif|jpg|png])$/i', $_FILES[$filename]['name'], $matches) ){
     $path =  realpath('../images'); 
	 if(is_uploaded_file($_FILES[$filename]['tmp_name'])) {
	   if($id != '') { $namefile = $id.".".$matches[0]; }
	   else{$namefile = $_FILES[$filename]['name']; } 
         move_uploaded_file($_FILES[$filename]['tmp_name'],  "$path/".$namefile);
		 if(!is_file("$path/".$namefile) ){ return FALSE; }
  	     return TRUE; 
     } 
	 else {   return FALSE; /*echo "Possible file upload attack. Filename: " . $_FILES['classImage']['name'];    */ }
   }
}
function multiupload($id, $filename, $dir=null){
    $i = 0; $message = array();
   foreach($_FILES[$filename] as $values){
      if(!isset($_FILES[$filename]['name'][$i]) ) { return false; } 
	  if(preg_match('/(\w+).([gif|jpg|png])$/i', $_FILES[$filename]['name'][$i], $matches) ){ 
	    if(is_null($dir)){ $path =  realpath('../cimages'); }
		else{$path=realpath('../'.$dir); }
		if(is_uploaded_file($_FILES[$filename]['tmp_name'][$i])) { 
	       //if($id != '') { $namefile = $id.".".$matches[0]; }
		   $name = $path.'/'.$id."_".($i+1).".".$matches[0]; 
		   move_uploaded_file($_FILES[$filename]['tmp_name'][$i],  $name);
		   if(!is_file($name) ){ $message[$i] .= $_FILES[$filename]['name'][$i] . "didn't make it<br />";}
		   else{ $message[$i] .= $_FILES[$filename]['name'][$i] . "was uploaded"; }
	     }
	 }
	  $i++;
   }
   return $message;
}
function formatphone(){
  $phone = $_REQUEST['areacode'].'-'.$_REQUEST['mid'].'-'.$_REQUEST['lastfour'];
  return $phone;
}
function showProducts($display){
  if(!is_array($display) ){ return "Error bad info type"; }
  $sql = "SELECT * FROM products p, category c WHERE catID = c.ID ";
  switch ($display[0]) {
    case "type":
	 $sql .= " AND type = \'".$display[1]."'";
	 break;
	case "price": 
	 $sql .= " AND price < ".$display[1];
	 break;
	case "category":
	 $sql .= " AND category = '".$display[1]."'";
	 break;
   }
   return $sql;
} 
class shoppingcart {
 function add2cart( $user =''){
    // add later 
 }
 
}
function displayProducts ($productCat = NULL, $shortDesc = 0){
   if(is_null($productCat) && $shortDesc == 0){ 
     $sql = "SELECT partID, product FROM products p INNER JOIN category c ON p.catID = c.ID ORDER by product";}
   elseif(is_null($productCat)){ 
     $sql = "SELECT partID, product, SUBSTR(description, 1, 260) as shortDesc FROM products p INNER JOIN category c ON p.catID =c.ID";
	 $description = 1;
   }
   elseif($shortDesc = 0){ 
     $sql ="SELECT partID, product FROM products p INNER JOIN category c ON catID = c.ID WHERE Category LIKE '$productCat'";
	 $sql .= " ORDER by product";
   }
   else{ 
     $sql ="SELECT partID, product, SUBSTRING(description, 1, 260) as shortDesc FROM products p INNER JOIN category c ON catID = c.ID";
	 $sql .= " WHERE Category LIKE '".$productCat."%' ORDER by product'";
	 $description = 1;
   }
   return $sql;    
}
function phone_number($sPhone = null){
if(!isset($sPhone)){ return; }
$sPhone = ereg_replace("[^0-9]",'',$sPhone);
if(strlen($sPhone) != 10) return(False);
$sArea = substr($sPhone,0,3);
$sPrefix = substr($sPhone,3,3);
$sNumber = substr($sPhone,6,4);
$sPhone = $sArea."-".$sPrefix."-".$sNumber;
return($sPhone);
}
function WriteToFile($strFilename, $strText) {  
      if($fp = @fopen($strFilename,"w "))  
     {  
          $contents = fwrite($fp, $strText);  
          fclose($fp);  
          return true;  
      }else{  
          return false;  
      }  

}  

function displayPics($id){  

if ($dir = @opendir("images/")) {
    $i = 0;
	$picture = ''; 
    while (($file = readdir($dir)) !== false) {
       if(preg_match("/^".$id . "_/", $file)){ 
	      if($i == 5){ $pictures.='<br />';  $i = 0; }
		  
	     $pictures .=  "<a href=\"tours.php?id=$id\" target=\"_new\" >"; 
		 $pictures .= "<img src=\"images/$file\" border=\"0\" height=\"120\" width=\"113\"/></a>";
		 $i++;
	  } 
    }//while  
  closedir($dir);
  }//opendir

  if($pictures !== ''){ return $pictures; }
  return false;
}
function displaydoc($category){ 
  $results = queryDB("SELECT * FROM docs
INNER JOIN category ON catID = cat_id
WHERE cat_name LIKE '$category' ORDER BY cat_name");
  if(count($results) <= 1 ){ 
  	while($records=mysql_fetch_assoc($results)){ 
  		$data.="<li><a href=\"display.php?ID={$records['ID']}\">". ucwords($records['title'])."</a></li>";
	}
	if(!empty($data)){ return $data;}
	return false;
}
  echo count($results);  
}
function htmlcontent ($text){
		// put all text into <p> tags
        $text = '<p>' . $text . '</p>';
		/* add line breaks to single newline characters */
        $text = str_replace("\n",'<br \>',$text);
		/* replace all newline characters with paragraph 
		ending and starting tags */
        $text = str_replace("\n\n",'</p><p>',$text);
        // remove any cariage return characters
        $text = str_replace("\r",'',$text);
        // remove empty paragraph tags
        $text = str_replace('<p></p>','',$text);
        /* optional replacement, if you need a nice-looking 
        XHTML source and not all source in one line.*/
        $text = str_replace('</p><p>', "</p>\n<p>", $text);
		$text = str_replace('<br />', "<br />\n", $text); 
        return $text;
}
function timelogged(){
  if(!isset($_SESSION['timelogged'])){ 
    session_destroy(); $msg = "Session Timed out";  include('index.php'); exit; }
  if($_SESSION['timelogged'] + (60 * 15) < time()){  session_destroy(); $msg = "Inactivity Session Close";  include('index.php'); exit; }
  else{ $_SESSION['timelogged'] = time(); }
}
function loggedin(){ 
   if(!isset($_SESSION['admin'])){ session_destroy(); $msg = "Please login first";  include_once('index.php'); }
}
function stopinjection($userinfo){ 
	return preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\')|(\-\-)|(\%3B)|(;))|(select|delete|insert \s*)/i', $userinfo );
}

function reposted($fieldname){
   if(isset($_REQUEST[$fieldname])){ return $_REQUEST[$fieldname]; }
   return false;
}
function checkCaptcha($fieldname) {  

  include_once('captcha/securimage.php');
    $image = new Securimage();
    if ($image->check($_POST[$fieldname]) == true) { return true;} 
	else {return false;    }
}
function arraysports(){
	$results=queryDB("Select sportID, sport FROM sports order by sport ");
	if($results==0){ return array(); }
	while($records=mysql_fetch_assoc($results)){
		$sport[$records['sportID']]=$records['sport'];
	}
	return $sport;
}
function listcats ($parentid = NULL, $selected = NULL){ 
//parent is the branch of the categories to go down
   if(!is_null($parentid)){
	   $results=queryDB("SELECT * FROM category WHERE cat_name = '$parentid'");
	   if($results !=0){
		   $record=mysql_fetch_assoc($results);
		   $left=$record['lft']+1; $right=$record['rgt'];
		   $sql=" SELECT node .cat_id , node.cat_name , (
			COUNT( parent.cat_name ) -1) AS depth
      		FROM category AS node, category AS parent  WHERE node.lft
	  		BETWEEN parent.lft AND parent.rgt AND parent.lft between $left AND $right
	  GROUP BY node.cat_name ORDER BY node.lft";
	   }
		
   }
   else{
	 $sql=" SELECT node .cat_id , node.cat_name , (
		COUNT( parent.cat_name ) -1) AS depth
      	FROM category AS node, category AS parent  WHERE node.lft
	  	BETWEEN parent.lft AND parent.rgt
	  	GROUP BY node.cat_name ORDER BY node.lft";
   } 
	$results = queryDB($sql); 
  echo "<select name=\"categoryID\">"; 
     if($selected == NULL){
		  echo "<option value=\"0\" selected=\"selected\">Select Option</option>"; 
	  }
	while($records=mysql_fetch_assoc($results)){
		$output="<option value=\"{$records['cat_id']}\" ";
		if($selected == $records['cat_id']){ $output.=" selected=\"selected\""; }
		$output.=">";
		if($records['depth']> 0 ) { $output .= str_repeat("&nbsp;&nbsp;", $records['depth']);}
		$output.=$records['cat_name']."</option>\n";
		echo $output;
	}
	echo "</select>";
}
function bulletcats ($parentid = NULL){ 
//parent ID has to be equal or not equal
   if($parentid != NULL){ $parent=" WHERE node.cat_name='$parentid'";  }
 $sql=" SELECT node.cat_id, node.cat_name
FROM category AS node,
category AS parent
WHERE node.lft BETWEEN parent.lft AND parent.rgt
AND parent.cat_name = 'categories'
ORDER BY node.cat_name;"; 
	  $results = queryDB($sql);
	  while($record = mysql_fetch_assoc($results)){
		  $display.="<li><a href=\"show.php?cat={$record['cat_id']}&cat={$record['cat_name']}\">". ucwords($record['cat_name']). "</a></li>";
	  }
	  return $display;
}
function imageResize($width, $height, $target){

//takes the larger size of the width and height and applies the  
//formula accordingly...this is so this script will work  
//dynamically with any size image

if ($width > $height) {
$percentage = ($target / $width);
} else {
$percentage = ($target / $height);
}

//gets the new value and applies the percentage, then rounds the value
$width = round($width * $percentage);
$height = round($height * $percentage);

//returns the new sizes in html image tag format...this is so you
//can plug this function inside an image tag and just get the

return "width=\"$width\" height=\"$height\"";

}
function getdomain($url){
	$parsed = parse_url($url);
	$hosturl = ereg_replace('www.', '', $url);
	return $hosturl;
}	

function themaybes($question){ 
//Send array of possible inserts, where the field name and the db name are the same. The function will allow you to add two sides of the sql statement INSERT and values
	foreach($question as $value){
	  if(!empty($_POST[$value])){ 
	    $include.=", $value ";
		if(is_numeric($_POST[$value])){ $data.=", {$_POST[$value]} ";}
		else{  $data.=", '". $_POST[$value]."' "; }
	  }
	}
	$returns['include'] = lastcomas($include);
	$returns['value'] = lastcomas($data);
	return $returns;
}
function lastcomas($str){ 
  return preg_replace('/,\s$/i','', $str);
} 
function menufrmdb(){
	//creates ad order list for dbmenus options output a formated string easy css can install too.
  $sql="SELECT *
  FROM pagemenu p
  LEFT JOIN docs d ON docID = d.ID
  LEFT JOIN category c ON c.cat_id = p.catID ORDER BY name";

  $results = queryDB($sql);
  if($results == 0){ return NULL; }
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
  }// End while
  return $menu;
}// END menufrmdb
function showwords($string, $word_limit) {
   $words = explode(' ', $string);
   return implode(' ', array_slice($words, 0, $word_limit));
}
function firstpargr($str){
	$parag=explode('<p>', $str);
}
function updatelastmod ($table, $field='lastmodified', $date='now()', $where=null, $equalwhat=null){
	//if up need to update the last modified date for our tables
	$sql = "UPDATE $table SET $field = $date WHERE $where = $equalwhat";
}
function activeuser($email){
	$results =queryDB("SELECT confirmed FROM users WHERE email='$email' ");
	$records=mysql_fetch_assoc($results);
	if($records['confirmed'] < 1){ return false; }
	else{ return true; }
}
function getAge( $p_strDate ) {
    list($Y,$m,$d)    = explode("-",$p_strDate);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}
function mysqldateconv($sqldate){
	$sqldate=preg_replace('/[\-]/i', '/', $sqldate);
	if(strtotime($sqldate)){
		$bdate=strtotime($sqldate); 
		$format[]=date('m-d-Y', $bdate);
		$format[]=date("F jS, Y", $bdate);
		$format[]=date("M j, Y", $bdate);
		$format[]=date('Y-m-d', $bdate);
		return $format;
	}else{ return false; }
}
function uploaddoc($filename ){
	if(!isset($_FILES[$filename]) ) {return FALSE; } 
    if( preg_match('/(\w+).([gif|jpg|png|doc|docx|pdf])$/i', $_FILES[$filename]['name'], $matches) ){
     $path =  realpath('../uploads'); 
	 if(is_uploaded_file($_FILES[$filename]['tmp_name'])) {
	   if($id != '') { $namefile = $id.".".$matches[0]; }
	   else{$namefile = $_FILES[$filename]['name']; } 
         move_uploaded_file($_FILES[$filename]['tmp_name'],  "$path/".$namefile);
		 if(!is_file("$path/".$namefile) ){ return FALSE; }
  	     return TRUE; 
     } 
	 else {   return FALSE; /*echo "Possible file upload attack. Filename: " . $_FILES['classImage']['name'];    */ }
   }
}
function remove_http($url='') {
       return preg_replace("/^https?:\/\/(.+)$/i","\\1", $url);
 }
function multi_attach_mail($to, $files, $sendermail, $subject, $newmess){
    // email fields: to, from, subject, and so on
    $from = "USAOfficials Association <".$sendermail.">"; 
    //$subject = date("d.M H:i")." F=".count($files); 
	$newmess="<html>
	<head>
  	<title>USAOfficials Association</title>
  	<link href=\"http://usaofficialassn.com/css/default.css\" rel=\"stylesheet\" type=\"text/css\">
	</head>
	<body>
	$newmess
	</body>
	</html>";
    $message = $newmess . "Date &amp; Time sent: ".date("m/d/Y H:i:s")."\n".count($files)." attachments";
    $headers = "From: $from";
 
    // boundary 
    $semi_rand = md5(time()); 
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
 
    // headers for attachment 
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 
    // multipart boundary 
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
    "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
 
    // preparing attachments
    for($i=0;$i<count($files);$i++){
        if(is_file($files[$i])){
            $message .= "--{$mime_boundary}\n";
            $fp =    @fopen($files[$i],"rb");
        $data =    @fread($fp,filesize($files[$i]));
                    @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"".basename($files[$i])."\"\n" .
            "Content-Description: ".basename($files[$i])."\n" .
            "Content-Disposition: attachment;\n" . " filename=\"".basename($files[$i])."\"; size=".filesize($files[$i]).";\n" . 
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
	$message .= "--{$mime_boundary}--";	
    $returnpath = "-f" . $sendermail;
    $ok = @mail($to, $subject, $message, $headers, $returnpath); 
    if($ok){ return $i; } else { return 0; }
}
function hasHtml($str){
  //we compare the length of the string with html tags and without html tags
  if(strlen($str) != strlen(strip_tags($str)))
      return true;  
  return false;
}
function updatesports(){
	if(!is_array($_POST['sport'])){ return 0; }
	$results=queryDB("DELETE FROM officialsports WHERE mhsaa_id = {$_POST['oldMHSAAID']}");
	if($_POST['oldMHSAAID']!=$_POST['MHSAAID']){ $mhsaaid=$_POST['MHSAAID']; }
	else{ $mhsaaid=$_POST['MHSAAID']; }
	foreach($_POST['sport'] as $key=>$value){
		$sport[]=queryDB("INSERT INTO officialsports VALUES ($mhsaaid, $key)");
	}
	$numsport=count($sport);
	if($numsport > 0){ return $numsport; }
	else{ return false; }
}
function addlatefee(){
	$today=strtotime('now');
	//test after the first of the year make sure they're paying the late fee
	if(strtotime(date('Y').'-05-15') > strtotime('now')){
		$lyr=date('Y')-1;
	}
	else{ $lyr=date('Y'); }
	#$cutoff=strtotime(date('Y')."-06-01");  
	$ldate=strtotime($lyr."-08-01");
	#echo "$todays - $ldate";
	if($today > $ldate){return true; }
	return false;
}
function changeover(){
	$newreg=strtotime(date('Y')."-08-01");
	if($newreg > strtotime('today')){ $return=date('Y')-1; }
	else{ $return=date('Y'); }
	return $return;
}
function removeuser($mhsaaID){
	$query=queryDB("DELETE FROM users WHERE MHSAAID=$mhsaaID LIMIT 1");
	$query=queryDB("DELETE FROM officialsports WHERE mhsaa_id=$mhsaaID");
	$query=queryDB("DELETE FROM migs WHERE MHSAAID=$mhsaaID"); 
}
function listsportsnmigs($jam=null, $mhsaaid){
	$results=queryDB("SELECT * FROM migs WHERE MHSAAID=$mhsaaid AND status=1");
	if($results != 0){
		while($records=mysql_fetch_assoc($results)){
			$migs[]=$records['sport_id']; #echo $records['sports'];
		}
	}
	$personsports=implode(',', $jam);
	#'SELECT * FROM sports WHERE sportID IN ($personsports) ORDER BY sport'
	$results=mysql_query("SELECT * FROM sports WHERE sportID IN ($personsports) ORDER BY sport") or die ;
	$num=mysql_num_rows($results); 
	if($num < 1){return false; }
	$half=ceil($num/2);
	#$i=1;$return="<aside class=\"twoCols\">\n";
	while($records=mysql_fetch_assoc($results)){
		
		#if($i> $half){$return.="</aside>\n<aside class=\"twoCols\">\n"; $i=0; }
		#else{$return.="</aside>\n<aside>\n"; $i=0;}//Close and open a new aside Reset to zero so it won't keep doing it
		$return.="<p>{$records['sport']}"; 
		if(is_array($migs) && in_array($records['sportID'], $migs)){
			$return.=" [MIGS] ";
		}
		$return.="</p>";  
		$i++;
	}
	#$return.='</aside>';
	return $return; 
}
function showlistdocs($parentID){
	$results=queryDB("SELECT * FROM category WHERE cat_id = ".$parentID);
	if($results ==0){ return 'No Results'; }
	$record=mysql_fetch_assoc($results);
	$left=$record['lft']; $right=$record['rgt'];
	$sql=" SELECT node .cat_id , node.cat_name , (
			COUNT( parent.cat_name ) -1) AS depth
      		FROM category AS node, category AS parent  WHERE node.lft
	  		BETWEEN parent.lft AND parent.rgt AND parent.lft between $left AND $right
	  GROUP BY node.cat_name ORDER BY node.lft"; 
	  $results=queryDB($sql);
	  if($results==0){return 'No Results'; }
	  while($records=mysql_fetch_assoc($results)){
		  $catsql[]=$records['cat_id'];
	  }
	  $sql="SELECT * FROM docs JOIN category ON cat_id=catID WHERE catID IN (".implode(',', $catsql).") ORDER BY cat_id, ID DESC";
	  return $sql;
}
?>
