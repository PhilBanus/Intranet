<?php 

$team = DB::table("UKHT_ICT_Team")->get(); 

foreach($team as $member){
	
	echo $member->ID;
}