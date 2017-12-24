<? 
#include_once('../inc/functions.php');
if(isset($_FILES['docfile'])){
	if(is_uploaded_file($_FILES['docfile']['tmp_name'])) {
		echo readDocx($_FILES['docfile']['tmp_name']);
	}
	
}
//FUNCTION :: read a docx file and return the string
function readDocx($filePath) {
    // Create new ZIP archive
    $zip = new ZipArchive;
    $dataFile = 'word/document.xml';
    // Open received archive file
    if (true === $zip->open($filePath)) {
        // If done, search for the data file in the archive
        if (($index = $zip->locateName($dataFile)) !== false) {
            // If found, read it to the string
            $data = $zip->getFromIndex($index);
            // Close archive file
            $zip->close();
            // Load XML from a string
            // Skip errors and warnings
            $xml = DOMDocument::loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            // Return data without XML formatting tags

            $contents = explode('\n',strip_tags($xml->saveXML()));
            $text = '';
            foreach($contents as $i=>$content) {
				echo $contents[$i];
                $text .= $contents[$i];
            }
            return $text;
        }
        $zip->close();
    }
    // In case of failure return empty string
    return "";
}
/*****************************************************************
This approach uses detection of NUL (chr(00)) and end line (chr(13))
to decide where the text is:
- divide the file contents up by chr(13)
- reject any slices containing a NUL
- stitch the rest together again
- clean up with a regular expression
*****************************************************************/

function parseWord($userDoc) 
{
    $fileHandle = fopen($userDoc, "r");
    $word_text = @fread($fileHandle, filesize($userDoc));
    $line = "";
    $tam = filesize($userDoc);
    $nulos = 0;
    $caracteres = 0;
    for($i=1536; $i<$tam; $i++)
    {
        $line .= $word_text[$i];

        if( $word_text[$i] == 0)
        {
            $nulos++;
        }
        else
        {
            $nulos=0;
            $caracteres++;
        }

        if( $nulos>1996)
        {   
            break;  
        }
    }

    //echo $caracteres;

    $lines = explode(chr(0x0D),$line);
    //$outtext = "<pre>";

    $outtext = "";
    foreach($lines as $thisline)
    {
        $tam = strlen($thisline);
        if( !$tam )
        {
            continue;
        }

        $new_line = ""; 
        for($i=0; $i<$tam; $i++)
        {
            $onechar = $thisline[$i];
            if( $onechar > chr(240) )
            {
                continue;
            }

            if( $onechar >= chr(0x20) )
            {
                $caracteres++;
                $new_line .= $onechar;
            }

            if( $onechar == chr(0x14) )
            {
                $new_line .= "</a>";
            }

            if( $onechar == chr(0x07) )
            {
                $new_line .= "\t";
                if( isset($thisline[$i+1]) )
                {
                    if( $thisline[$i+1] == chr(0x07) )
                    {
                        $new_line .= "\n";
                    }
                }
            }
        }
        //troca por hiperlink
        $new_line = str_replace("HYPERLINK" ,"<a href=",$new_line); 
        $new_line = str_replace("\o" ,">",$new_line); 
        $new_line .= "\n";

        //link de imagens
        $new_line = str_replace("INCLUDEPICTURE" ,"<br><img src=",$new_line); 
        $new_line = str_replace("\*" ,"><br>",$new_line); 
        $new_line = str_replace("MERGEFORMATINET" ,"",$new_line); 


        $outtext .= nl2br($new_line);
    }

 return $outtext;
} 

$userDoc = "custo.doc";
$userDoc = "Cultura.doc";
#$text = parseWord($userDoc);

echo $text;
include_once('../Connections/dbcon.php');
mysql_select_db($database_dbcon, $dbcon);

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Document Upload</title>
</head>
<? include_once('invoices/lib.php'); 
echo sendInvoice(2);
?>
<body>
<form action="<?= $_SERVER['PHP_SERVER']; ?>" method="post" enctype="multipart/form-data" name="testupload" id="testupload">
  <p>
    <label for="docfile">Doc/Docx file:</label>
    <input type="file" name="docfile" id="docfile">
  </p>
  <p>
    <input type="submit" name="save" id="save" value="Submit">
  </p>
</form>
</body>
</html>