
<?php 

$id = $_GET['id'];

	if($id == "home"){
	$id = null;
		
	}

		
		$folderSorter = new App\ClientFolders;
	
	

		?>

<style>
	
	thead input {
  width: 100%; padding: 0 !important; font-size: 80% !important
}
	.dataTables_scrollBody{
		height: 500px
	}
	table .fa-stack { font-size: 0.7em; }
  i { vertical-align: middle; }
	.scrollStyle {overflow-x:auto;}
	
	table i{
		font-size: 1.2em;
	}
	
	table.dataTable tbody td.select-checkbox:before, table.dataTable tbody th.select-checkbox.select-checkbox-all:before, table.dataTable thead td.select-checkbox:before, table.dataTable thead th.select-checkbox.select-checkbox-all:before, table.dataTable tr.selected td.select-checkbox:after, table.dataTable tr.selected th.select-checkbox:after{
		margin: 0; 
		padding: 0;
	}
	
	table.dataTable tr.selected td.select-checkbox:after, table.dataTable tr.selected th.select-checkbox:after{
		background-color: #024a94; 
		content: '\f00c';
		font-size: 0.9rem;
		    font-weight: 300;
		    font-family: "Font Awesome 5 Pro", sans-serif;
	}
	
	
/*#dtMaterialDesignExample {
    font-size: 8px;
    table-layout: fixed
}
 
td {
    word-wrap: break-word;
}
	
	.scrollStyle {overflow-x:auto;}
</style>

		<table id="dtMaterialDesignExample" class="table table-sm table-striped table-bordered text-nowrap"  width="100%" cellspacing="0" >
  <thead>
    <tr>
    	<th style="width: 50px !important"></th>
    	<th></th>
      <th>Title</th>
      <th>Description</th>
      <th>Version</th>
      <th>Published Date</th>
      <th>Published By</th>
      <th>File Type</th>
      

    </tr>
  </thead>
<tbody></tbody>

</table>


 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.22/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.js"></script>


<script>
 $(document).ready(function () {
  var table = $('#dtMaterialDesignExample').DataTable(
  {
	  processing: true,
        serverSide: true,
       paging: true,
	  "pagingType": "full_numbers",
	  

	 
	  ajax: "getClientDocs?code={{request('code')}}&ec={{request('ec')}}&id={{request('id')}}",
	/*  createdRow: function ( row, data, index ) {
     $(row).addClass('col');
		$(row).attr('data', "hello" ); //[{ data: 'id'}]
  		}, */
	  columns: [
		 
		  { data: null},
		  { data: null},
		  { data: 'title'},
		  { data: 'description'},
		  { data: 'version'},
		  { data: 'upload_date'},
		  { data: null },
		  { data: 'extension'},
		  
		 
		
	  ],
	    select: {
            style:    'multi',
            selector: 'td:first-child'
        },
	  columnDefs: [ {
            "targets": 1,
            "render": function ( data, type, row ) {
				if(data.checked_out == 1){
                    return '<div class="d-flex justify-content-between"><a class="text-primary"  href="CDdownload?id='+data.id+'" ><i class="fas fa-file-download" data-toggle="tooltip"  title="Download Document"></i></a>\
					<span class="fa-stack m-0" data-toggle="tooltip" title="Checked out to: '+data.editorFName+' '+data.editorSName+'">\
  <i class="fas fa-ban fa-stack-2x" style="color:Tomato"></i>\
  <i class="fas fa-pencil-alt fa-stack-1x"></i>\
</span><a class="text-primary ml-2"  href="#" onClick(emailSingleDoc('+data.id+'))" data-toggle="tooltip" style="font-size: 80%"  title="Email Document"><i class="fas fa-envelope"></i></a></div>';					}
					else{
                    return '<div class="d-flex justify-content-between"><a class="text-primary"  href="CDdownload?id='+data.id+'" data-toggle="tooltip"  title="Download Document"><i class="fas fa-file-download"></i></a><a class="text-primary ml-2"  href="CDedit?id='+data.id+'" data-toggle="tooltip" style="font-size: 80%"  title="Edit Document"><i class="fas fa-pencil-alt"></i></a><a class="text-primary ml-2"  href="#" onClick(emailSingleDoc('+data.id+'))" data-toggle="tooltip" style="font-size: 80%"  title="Email Document"><i class="fas fa-envelope"></i></a></div>';
					}
                },
		  orderable: false,
		 "searchable": false,
		  "width": "120px"
        },{
			targets: 6, 
			"render": function ( data, type, row ){
				return '<a href="https://themis.ukht.org/XWeb/entity/entity.aspx?ec=1&code='+data.uploaded_by+'" target="_blank" ><i class="fad fa-user"></i>'+ data.uploaderFName+' '+data.uploaderSName+'</a>'
			},
			 "searchable": false,
			 orderable: false,
		},
				  {
            orderable: false,
					  data: null,
					  defaultContent: "",
            className: 'select-checkbox m-0 p-0',
            targets:   0,
					 "searchable": false,
					  
					  "width": "50px"
        },
				   {width: "250px", targets: [2,3]},
				   {width: "50px", targets: [4,7]}
				  ],
	  
	  order: [5, 'desc'],
	  
	   initComplete: function () {
            // Apply the search
            /*this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.header() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );*/
		   
		  changeHeight();
		   				$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
		   
		   
		   
		
        }
     
	  
    } );

	 
	  $('#dtMaterialDesignExample_wrapper').find('label').each(function () {
    $(this).parent().append($(this).children());
  });
  $('#dtMaterialDesignExample_wrapper .dataTables_filter').find('input').each(function () {
    const $this = $(this);
    $this.attr("placeholder", "Search");
    $this.removeClass('form-control-sm');
  });
  $('#dtMaterialDesignExample_wrapper .dataTables_length').addClass('d-flex flex-row');
  $('#dtMaterialDesignExample_wrapper .dataTables_filter').addClass('md-form');
  $('#dtMaterialDesignExample_wrapper select').removeClass('custom-select custom-select-sm form-control form-control-sm');
  $('#dtMaterialDesignExample_wrapper select').addClass('mdb-select');
  $('#dtMaterialDesignExample_wrapper .mdb-select').materialSelect();
  $('#dtMaterialDesignExample_wrapper .dataTables_filter').find('label').remove();
	
	/*$('#dtMaterialDesignExample thead th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control border-0" placeholder="'+title+'" />' );
    } );*/
	 
	 $('#dtMaterialDesignExample tbody').on('click', 'tr', function () {
        var data = table.row(this).data();
        
		 doc_ID = data.id
		 
		 $('#detailsArea').load('CDAjaxDetails?id=1&Data=' + data.id)
    } );
	 

	 

}); 
	

	
</script>

<!---->

