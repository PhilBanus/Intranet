
<?php 

$id = $_GET['id'];

	if($id == "home"){
	$id = null;
		
	}

		
		$folderSorter = new App\ClientFolders;
	
	

		?>
<div class="container">
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>title</th>
   
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('getClientDocs.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
     
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>

<!---->

