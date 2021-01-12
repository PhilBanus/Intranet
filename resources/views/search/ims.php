

<?php

//get the q parameter from URL
$q= explode(" ",$_GET["q"]);


foreach($q as $word){
    $sql[] = "(Title LIKE '%".$word."%' or Keywords LIKE '%".$word."%')";
}

//Lookup where name is simular





$hint = "";

$Lookup = App\Documents::has('imsdoc')->whereRaw(implode(' AND ', $sql))->get();


foreach ($Lookup as $document) {
?>
<a href="https://themis.ukht.org/__files/document/<?php echo $document->Document_ID ?>/latest/" class="IMSDoc list-group-item list-group-item-action" target="_blank"><?php echo $document->Title ?> - <?php echo $document->Keywords ?> </a>

<?php

}



if($Lookup->isEmpty()){ echo "Sorry no results... " ;}


?>



