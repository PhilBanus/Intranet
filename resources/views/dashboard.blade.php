<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="full-height">
    <head>
       
		@include('Head_Scripts')
        <title>Laravel</title>

	
       
        <!-- Styles -->
    </head>
   <body class="fixed-sn mdb-skin bg-dark h-100">
		             
	 
    <div class="container-fluid p-2 h-100">
				@yield('content')
		   </div>
			
        
		
		@include('Footer_Scripts')
		
    </body>
</html>
