<?
if(!headers_sent()){session_start();}
include_once('inc/functions.php'); 
include_once('Connections/dbcon.php');
mysql_select_db($database_dbcon, $dbcon);
if(isset($_REQUEST['id'])){
	//slecting a document
	$sql=sprintf("SELECT * FROM docs LEFT JOIN admin ON authorID=userID LEFT JOIN uploads ON ID=doc_id WHERE ID=%d", mysql_real_escape_string($_REQUEST['id']));
	$results=mysql_query($sql);
	if($results){
		$records=mysql_fetch_assoc($results);
		$title=$records['title'];
		if(hasHtml($records['content'])){ $content=$records['content']; }
		else{ $content=htmlcontent($records['content']); }
		if(!is_null($records['filename'])){$content.="<p><a href=\"uploads/{$records['filename']}\" target=\"_new\">Download: {$records['displayname']}</a></p>"; }
	}
	else{ $content="<div class=\"breadcrum\"><ul><li><a href=\"./\">Home</a></li><li>Page Not found</li></ul></div>
	<h2>Sorry No Page Found</h2><p>Sorry, but the page or document you were looking for either doesn't exsists or was removed. 
					A message has been sent to the administrator. Please come back again try again later.
					</p>";
	}
	
		
}
elseif(isset($_REQUEST['cat_id'])){
	//collecting doc
	
	$sql=showlistdocs($_REQUEST['cat_id']);
	if($sql=='No Results'){
		$content="<h1>No Results</h1><p>Sorry there are no documents available</p>";
	}
	 else{
	 	$results=queryDB($sql);
		if($results!=0){
			while($records=mysql_fetch_assoc($results)){
				if(!isset($title)){$title=$records['cat_name']; }
				$content.= " <article>
				<h2><a href=\"?id={$records['ID']}\">{$records['title']}</a></h2>
				<p>Category: {$records['cat_name']}</p>
				<p>".showwords($records['description'],100)."...</p>
			 	<div class=\"meta\"><a href=\"?id={$records['ID']}\">Read More</a></div>
				</article>";
			}
			$content=stripslashes($content);
		}
	 }
}
else{header('Location: http://'. $_SERVER['HTTP_HOST']); }
?>

<!doctype html>
<head>
<title>Muskegon Heights Public School Academy ::
<?=$title; ?>
</title>
<meta name="keywords" content="<?= $keywords; ?>" />
<link href="css/default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<? include_once('header.php'); ?>
<?= "<h2>$title</h2>\n $content"; ?>
<? include_once('footer.php'); ?>
</body>
</html>