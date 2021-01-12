@extends('intranet')

@section('content')

<?php


$contactDetails = DB::table('Contact')->where('Contact_ID', '16')->first();
	 
?>
<div class="row">

	<div class="col-md-8">
	
		<div class="card">
		<div class="card-header primary-color text-white">Corporate Compliance Documents</div></div>
		<div class="card-body row">
			<div class="col-md-12 row mb-1 card-header bg-transparent">
			<div class="col-md-1"><i class="fas fa-file-pdf fa-2x"></i></div>
			<div class="align-middle"><a href="https://themis.ukht.org/__files/document/1866757/latest/"  target="_blank">00000-HUK-GHR-XX-PC-Z-0010 – Whistleblowing</a></div>
			</div>
			
			<div class="col-md-12 row my-1 card-header bg-transparent">
			<div class="col-md-1"><i class="fas fa-file-pdf fa-2x"></i></div>
			<div class="align-middle"><a href="https://themis.ukht.org/__files/document/1809345/latest/"  target="_blank">00000-HUK-GEN-XX-GD-Z-0001 - HOCHTIEF Code of Conduct</a></div>
			</div>
			
			<div class="col-md-12 row my-1 card-header bg-transparent">
			<div class="col-md-1"><i class="fas fa-file-pdf fa-2x"></i></div>
			<div class="align-middle"><a href="https://themis.ukht.org/__files/document/1801434/latest/"  target="_blank">00000-HUK-GCM-XX-PC-Z-0008 - Handling Gifts, Hospitality and Invitations Procedure</a></div>
			</div>
			
			<div class="col-md-12 row my-1 card-header bg-transparent">
			<div class="col-md-1"><i class="fas fa-file-pdf fa-2x"></i></div>
			<div class="align-middle"><a href="https://themis.ukht.org/__files/document/1905996/latest/"  target="_blank">00000-HUK-GFA-XX-FM-Z-0008 - Gifts &amp; Hospitality Reporting Form</a></div>
			</div>
		
			<div class="col-md-12 row my-1 card-header bg-transparent">
			<div class="col-md-1"><i class="fas fa-file-pdf fa-2x"></i></div>
			<div class="align-middle"><a href="https://hochtief.co.uk/wp-content/uploads/2020/06/HOCHTIEF-ethical-business-contacts.pdf"  target="_blank">HOCHTIEF Ethical Business Contacts</a></div>
			</div>
			
			<div class="col-md-12 row my-1 card-header bg-transparent">
			<div class="col-md-1"><i class="fas fa-file-pdf fa-2x"></i></div>
			<div class="align-middle"><a href="https://indoor.hochtief.de/en/Richtlinien/Richtlinien_im_Konzern/Directives/10_2016_Group%20Directive%20Antitrust%20Law%20and%20Merger%20Control.pdf"  target="_blank">10_2016_Group Directive Antitrust Law and Merger Control</a></div>
			</div>
			
			<div class="col-md-12 row my-1 card-header bg-transparent">
			<div class="col-md-1"><i class="fas fa-file-pdf fa-2x"></i></div>
			<div class="align-middle"><a href="https://indoor.hochtief.de/en/Richtlinien/Richtlinien_im_Konzern/Directives/05_2016_Group%20Directive%20Compliance%20Organization.pdf"  target="_blank">05_2016_Group Directive Compliance Organization</a></div>
			</div>
			
			<div class="col-md-12 row my-1 card-header bg-transparent">
			<div class="col-md-1"><i class="fas fa-file-pdf fa-2x"></i></div>
			<div class="align-middle"><a href="https://indoor.hochtief.de/en/Konzernthemen/Compliance/Richtlinien/Documents/1.%2003_2016_Group%20Directive%20on%20Agreements%20with%20Intermediaries%20with%20attachments.pdf"  target="_blank">2003_2016 Group Directive on Agreements with Intermediaries with attachments</a></div>
			</div>
			
			<div class="col-md-12 row my-1 card-header bg-transparent">
			<div class="col-md-1"><i class="fas fa-file-pdf fa-2x"></i></div>
			<div class="align-middle"><a href="https://indoor.hochtief.de/en/Konzernthemen/Compliance/Richtlinien/Documents/2.%2003_2016_Consultancy%20Directive_attachment%201.docx"  target="_blank">03_2016_Consultancy Directive_attachment 1</a></div>
			</div>
			
			<div class="col-md-12 row my-1 card-header bg-transparent">
			<div class="col-md-1"><i class="fas fa-file-pdf fa-2x"></i></div>
			<div class="align-middle"><a href="https://indoor.hochtief.de/en/Konzernthemen/Compliance/Richtlinien/Documents/3.%2003_2016_Consultancy%20Directive_attachment%202_new.docx"  target="_blank">03_2016_Consultancy Directive_attachment 2_new</a></div>
			</div>
			
			<div class="col-md-12 row my-1 card-header bg-transparent">
			<div class="col-md-1"><i class="fas fa-file-pdf fa-2x"></i></div>
			<div class="align-middle"><a href="https://themis.ukht.org/__files/document/1803245/latest/"  target="_blank">00000-HUK-GCM-XX-FM-Z-2001 - HOCHTIEF Supply Chain Code of Conduct</a></div>
			</div>
		</div>
		
		
	</div>
	<div class="col-md-4">

		<div class="card z-depth-0">
		
						<div class="card-header bg-transparent text-primary border-primary"><i class="fas fa-info"></i> Info</div>
			
			
			<div class="card-body">
				<p class="card-text">
				
					The reputation of HOCHTIEF is our highest priority and we must ensure that it is preserved and safeguarded, we have a long standing tradition of conducting our business activities in accordance with ethical principles. By conducting ourselves in compliance with these principles we will ensure that HOCHTIEF enjoys an outstanding reputation and is successful in its business endeavours. If you have any questions or wish to discuss compliance please contact Chris Barlow, Compliance Officer.
					
				</p>
				<a href="https://indoor.hochtief.de/en/Konzernthemen/Compliance/Pages/default.aspx" target="_blank"><h6 class="card-title text-primary"  >Indoor Corporate Compliance</h6></a>
				<small class="text-danger">Please note that Indoor links will need to be accessed whilst on the VPN or via the Internal Network.</small>
				</p>
				<h6 class="card-title text-primary"  >Contact Information</h6>
				<p>Compliance Officer:<a href="https://themis.ukht.org/XWeb/entity/entity.aspx?ec=1&code=16" target="_blank"> {{$contactDetails->Forename}} {{$contactDetails->Surname}}
				</a></p>
				<strong><p> Compliance Issues and Queries should be directed to: <a href="mailto:compliance@hochtief.co.uk">compliance@hochtief.co.uk</a></p></strong>
			</div>	
</div>

		
		
</div>
</div>
@stop