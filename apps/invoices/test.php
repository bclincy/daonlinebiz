<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<?
include_once('lib.php');
echo getCurrentDirectory();
echo $_SERVER['DOCUMENT_ROOT'];
echo dirname($_SERVER['PHP_SELF']). "<br />". $_SERVER['SCRIPT_NAME']. "<br />". dirname($_SERVER['SCRIPT_FILENAME']); 
print_r(  pathinfo($_SERVER['SCRIPT_FILENAME'])); 
echo $_SERVER['HTTP_HOST']. dirname($_SERVER['PHP_SELF']). "<br />";
?>
</body>
</html>