<?
function reposted($fieldname){
   if(isset($_REQUEST[$fieldname])){ return $_REQUEST[$fieldname]; }
   return false;
}
function themaybes($question){ 
//Send array of possible inserts, where the field name and the db name are the same. The function will allow you to add two sides of the sql statement INSERT and values
	foreach($question as $value){
	  if(!empty($_POST[$value])){ 
	    $include.=", $value ";
		if(is_numeric($_POST[$value])){ $data.=", {$_POST[$value]} ";}
		else{  $data.=", '{$_POST[$value]}' "; }
	  }
	}
	$returns['include'] = lastcomas($include);
	$returns['value'] = lastcomas($data);
	return $returns;
}
function lastcomas($str){ 
  return preg_replace('/,\s*$/i','', $str);
} 


?>