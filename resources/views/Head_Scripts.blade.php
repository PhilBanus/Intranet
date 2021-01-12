<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">
<meta name="csrf-token" content="{{ Session::token() }}"> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
<link rel="stylesheet" href="{{ asset('FA6/css/all.css') }}">



<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote-bs4.css" rel="stylesheet">


<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

<style>

.text-word{
color: #2b579a
}

.text-excel{
color:#217346
}

.text-powerpoint, .text-pdf{
color: #d24726
}



.pink-textarea textarea.md-textarea:focus:not([readonly]) {
border-bottom: 1px solid #f48fb1;
box-shadow: 0 1px 0 0 #f48fb1;
}
.active-pink-textarea.md-form label.active {
color: #f48fb1;
}
.active-pink-textarea.md-form textarea.md-textarea:focus:not([readonly])+label {
color: #f48fb1;
}


.amber-textarea textarea.md-textarea:focus:not([readonly]) {
border-bottom: 1px solid #ffa000;
box-shadow: 0 1px 0 0 #ffa000;
}
.active-amber-textarea.md-form label.active {
color: #ffa000;
}
.active-amber-textarea.md-form textarea.md-textarea:focus:not([readonly])+label {
color: #ffa000;
}


.active-pink-textarea-2 textarea.md-textarea {
border-bottom: 1px solid #f48fb1;
box-shadow: 0 1px 0 0 #f48fb1;
}
.active-pink-textarea-2.md-form label.active {
color: #f48fb1;
}
.active-pink-textarea-2.md-form label {
color: #f48fb1;
}
.active-pink-textarea-2.md-form textarea.md-textarea:focus:not([readonly])+label {
color: #f48fb1;
}


.active-amber-textarea-2 textarea.md-textarea {
border-bottom: 1px solid #ffa000;
box-shadow: 0 1px 0 0 #ffa000;
}
.active-amber-textarea-2.md-form label.active {
color: #ffa000;
}
.active-amber-textarea-2.md-form label {
color: #ffa000;
}
.active-amber-textarea-2.md-form textarea.md-textarea:focus:not([readonly])+label {
color: #ffa000;
}
</style>


