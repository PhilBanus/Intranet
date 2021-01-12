<?php
      
      $file = base64_decode($_GET['filename']);


    // clean buffer(s)
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
header('Content-Description: File Transfer');
header('Content-Type: ' . mime_content_type($file));
header('Content-Disposition: attachment; filename="'.basename($file).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($file)); //Absolute URL
readfile($file); //Absolute URL
exit();