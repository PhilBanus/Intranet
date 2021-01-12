<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="full-height h-100">
<head>      
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">
<meta name="csrf-token" content="{{ Session::token() }}"> 
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote-bs4.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<title>{{$Title ?? 'Project'}}</title>
    
    </head>
   <body class="fixed-sn hochtief-skin w-100 lighten-5" style="height: auto; overflow-x: hidden">
       
        
	


    <div class="container-fluid m-0 p-1 h-100">
		 	
		   
			
				@yield('content')
		   </div>

 <div id="footer"></div>		
		@include('Footer_Scripts')

       <script>
       
  
       
       </script>
    </body>
</html>
