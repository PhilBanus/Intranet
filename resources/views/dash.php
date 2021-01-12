<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="full-height">
    <head>
       
		<?php include('Head_Scripts.blade.php') ?>
        <title>Laravel</title>

	
       
        <!-- Styles -->
    </head>
   <body class="fixed-sn mdb-skin bg-dark h-100">
		             
	 
    <div class="container-fluid p-2 h-100">
				@yield('content')
		   </div>
			
        
		
		<?php include('Footer_Scripts.blade.php') ?>
		
    </body>
</html>
