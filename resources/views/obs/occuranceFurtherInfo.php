
<?php 
use Carbon\Carbon;
if($_GET['type'] == "Open"){
	
	$table = DB::table($_GET['table'])->leftjoin('Project','Site','Project_ID')->where('Occurance',$_GET['occurance'])->whereNull('Closed_Date')->orderby('Reported_Date','asc')->get();
	
	?> 
<table id="dt-material-checkbox" class="table table-striped" cellspacing="0" width="100%">
  <thead>
    <tr>
<th>#</th>
      <th class="th-sm">Reported Date
      </th>
      <th class="th-sm">Occurance Date
      </th>
      <th class="th-sm">Site
      </th>
      <th class="th-sm">Category
      </th>
      <th class="th-sm">Details
      </th>
    </tr>
  </thead>
  <tbody>
	  
	  
	  <?php foreach($table as $row){
		?>
	    <tr onClick="openWin('OccuranceView?id=<?php echo $row->ID?>')">
 <td  class="linked" ><?php echo $row->Global_Number ?></td>
      <td><?php echo Carbon::createFromFormat('Y-m-d H:i:s.u',$row->Reported_Date)->toRfc7231String() ?></td>
      <td><?php echo Carbon::createFromFormat('Y-m-d H:i:s.u',$row->Date)->toRfc7231String() ?></td>
      <td><?php echo $row->Name ?></td>
      <td><?php echo $row->Category." - ".$row->Sub ?></td>
      <td class="text-truncate" style="max-width: 300px;"><?php echo $row->Details ?></td>
    </tr>
	  
	  <?php
	}
	  ?>
 
    
  </tbody>
  <tfoot>
    <tr>
	 <th></th>
      <th>Reported Date
      </th>
      <th>Occurance Date
      </th>
      <th>Site
      </th>
      <th>Category
      </th>
      <th>Details
      </th>
      
    </tr>
  </tfoot>
</table>

<?php 
}?>


<script>$('#dt-material-checkbox').dataTable();

	function openWin(link){
		  window.open(link, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=0,width=1200,height=800");
}
	

</script>