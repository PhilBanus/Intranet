<?php 


//$fp = fopen("\\\\ukhts055\\Data\\HelpDesk\\NewLog\\","w");



$ID = DB::table('HELPDESK_Calls')->insertGetID(
[ 'Contact' => session('MY_ID')
 , 'Subject' => base64_encode($_POST['Subject'])
 , 'Description' => base64_encode($_POST['Details'])
 , 'Category' => $_POST['Category']
 , 'Phone' => $_POST['Contact']

]
);


$variable = "HELPDESK-$ID";




$target_dir = "\\\\ukhts055\\Data\\HelpDesk\\$variable\\";



if( isset($_FILES['documents']['name'])) {
    if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}
  
  $total_files = count($_FILES['documents']['name']);
  
  for($key = 0; $key < $total_files; $key++) {
    
    // Check if file is selected
    if(isset($_FILES['documents']['name'][$key]) 
                      && $_FILES['documents']['size'][$key] > 0) {
      
      $original_filename = $_FILES['documents']['name'][$key];
      $target = $target_dir . basename($original_filename);
      $tmp  = $_FILES['documents']['tmp_name'][$key];
      move_uploaded_file($tmp, $target);
    }
    
  }
     
}

$Previous = URL::previous(); 


header("Location: $Previous?HelpThanks=$ID");
