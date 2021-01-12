<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="full-height h-100">
<head>      
@include('Head_Scripts')
<title>@yield('title')</title>
      
    </head>
   <body class="fixed-sn hochtief-skin w-100 bg-light lighten-5 h-100 p-4 d-flex justify-content-center">
	


    <div class="container-fluid col-lg-6 z-depth-1 rounded m-0 p-3  h-100 bg-white custom-scrollbar border-primary border-top" style="overflow-y: auto">
		 	
<h4 class="card-title text-primary font-weight-bold" >@yield('title')</h4>

			
				@yield('content')
		
		
		   </div>

 <div id="footer"></div>		
		@include('Footer_Scripts')

    </body>
</html>
