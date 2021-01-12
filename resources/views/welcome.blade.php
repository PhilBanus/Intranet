<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="full-height">
    <head>
       
		@include('Head_Scripts')
        <title>ICT Portal</title>

	
       
        <!-- Styles -->
    </head>
   <body class="fixed-sn mdb-skin bg-light">
		
	
				

        @include('header')
 
             
	   <main class="m-0">
    <div class="container-fluid">
		
		<div class="container">
    @if(isset($details))
        <p> The Search results for your query <b> {{ $query }} </b> are :</p>
    <h2>Sample User details</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
		
				@yield('content')
		   </div>
		</main>		
        
		
		@include('Footer_Scripts')
		
    </body>
</html>
