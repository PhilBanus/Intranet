


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="full-height">
    <head>
       
		@include('Head_Scripts')
        <title>Intranet</title>

	
       <style>
		
		   header, main, footer, nav {
  padding-left: 240px !important;
}
		   

		   
		@media only screen and (max-width : 1000px) {
  header, main, footer, nav {
    padding-left: 0 !important;
	 
  }
			.button-collapse{
				display: block;
			}
}
		
		</style>
        <!-- Styles -->
    </head>
   <body class="fixed-sn hochtief-skin w-100 lighten-5 ">
	

	
				

        @include('intranet.nav')

             
	   <main class="m-0">
		   
	<ul class="imssearch mx-auto list-group p-3 border-0" id="imsSearch" ></ul>
		     
    <div class="container-fluid ">
		 	
		   
			
				@yield('content')
		   </div>
		</main>		
        
	   <div id="footer"></div>
		
		@include('Footer_Scripts')
			<script>
$('#imsSearch').hide();

</script> 
    </body>
</html>
