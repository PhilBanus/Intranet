


    <div class="table-wrapper">

<table  class="table table-striped table-bordered table-sm  @yield('tabletheme') data-table" cellspacing="0" width="100%">
  <thead>
      @yield('headers')
  </thead>
  <tbody>
	  
	  @yield('rows')

	  
   
  </tbody>
  <tfoot>
	  
	  @yield('headers')
    
  </tfoot>
</table>

	  </div>

