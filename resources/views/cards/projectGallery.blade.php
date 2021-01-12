  <div id="mdb-lightbox-ui"></div>

  <!-- First column -->
  <div class="col-md-12 card p-0 border-0">

  
    <div class="mdb-lightbox no-margin card-columns p-0 m-0" style="column-gap: 0; column-count: 3">

		
	
		
		
		<?php 
		
		$Images = DB::table('Document')->join('Document_Categories', 'Document_Categories.Document_ID', '=', 'Document.Document_ID')
			->where('Document_Categories.Category_ID','=','5475')
			->whereNull('Document.Superceded_By')
			->orderBy('Document.Published_Date', 'DESC')
			->take(9)
			->get();
		
		
		foreach($Images as $Image){
			
			?>
		
		 <figure class="card p-0 m-0 w-100">
        <a href="https://themis.ukht.org/__files/rendition/<?php echo $Image->Document_Series_ID; ?>/-5" data-size="1600x1067" class="w-100">
          <img src="https://themis.ukht.org/__files/rendition/<?php echo $Image->Document_Series_ID; ?>/-5" style="height: 100px;" class="img-fluid w-100">
        </a>
        <figcaption><?php echo $Image->Title; ?></figcaption>
      </figure>
		
		
		<?php 
			
		}
		
		
		?>
		
		
     

    </div>

  </div>
  <!-- First column -->

