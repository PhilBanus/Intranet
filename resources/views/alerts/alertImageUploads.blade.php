<?php 

$target_dir = public_path('alertImages');
$target_file = $target_dir . '\\' . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
$errors = "Sorry, your file was not uploaded. \n";

echo $target_file;


    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;

		
    } else {
        $errors .= "File is not an image. \n";
        $uploadOk = 0;
    }

   
 // Check if file already exists
if (file_exists($target_file)) {
    $errors .= "Sorry, file already exists. \n";
    $uploadOk = 0;
}  


if ($_FILES["fileToUpload"]["size"] > 500000) {
    $errors .= "Sorry, your file is too large. \n";
    $uploadOk = 0;
}


// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "mp4" ) {
    $errors .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. \n";
    $uploadOk = 0;
}


if ($uploadOk == 0) {
   
	Session::put('errors', $errors);
		header('Location: alertCreate');
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		
		Session::put('success', "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.");
		header('Location: alertCreate');
		
		
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
		



?>