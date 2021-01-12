<?php 



$Pages = DB::table('UKHT_Images_Syncer')->get();
	foreach($Pages as $Page){ 
								
								$int = '\\\\ukhts097\e$\DeltekPIM\XWeb\\'.$Page->Internal_Path;
								$ex1 = "\\\\10.4.252.5\c$\workspace\xWeb\\".$Page->Internal_Path;
								$ex2 = "\\\\10.4.252.4\c$\workspace\xWeb\\".$Page->Internal_Path;

						



//internal to external 1
custom_copy($int, $ex1);
//internal to external 2
custom_copy($int, $ex2);

//internal from external 1
custom_copy($ex1, $int);
//internal from external 2
custom_copy($ex2, $int);
								
								
							}


function custom_copy($src, $dst) {  
   // open the source directory 
    $dir = opendir($src);  
   
    // Make the destination directory if not exist 
    @mkdir($dst);  
   
    // Loop through the files in source directory 
    foreach (scandir($src) as $file) {  
   
		if($file === "Thumbs.db"){}else{
		
        if (( $file != '.' ) && ( $file != '..' )) {  
            if ( is_dir($src . '/' . $file) )  
            {  
   
                // Recursively calling custom copy function 
                // for sub directory  
             
     custom_copy($src . '/' . $file, $dst . '/' . $file);  
            }  
            else {  
                copy($src . '/' . $file, $dst . '/' . $file);  
            }  
        }  
	}
    }  
   
    closedir($dir); 

}


$string = <<<XML
<success></success>
XML;

$xml = new SimpleXMLElement($string);

echo $xml->asXML();

?>