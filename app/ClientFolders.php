<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ClientFolders extends Model
{
    //
	protected $table = 'UKHT_CD_Folders';
	
		public function documents(){
		return $this->hasMany('App\ClientDocumentsTable','folder_id','id');
	}
	
	public function init($id,$class){
		
		return $this->where(['entity_id' => $id, 'class_id' => $class])->exists();
		
	}
	
	public function getChildren($id,$class,$parent){
	$int = $this->countParents($parent);
		$tab = "";
	
		while($int > 0){
			$tab .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$int--;
		}
		
		$body = "";
		foreach($this->where(['entity_id' => $id, 'class_id' => $class])->where('Parent_ID',$parent)->get() as $folder){
			
			
				
			
			/*if($this->where(['entity_id' => $id, 'class_id' => $class])->where('Parent_ID',$folder->id)->exists()){
				$body .= '<li tag="parent"><a data-id="'.$folder->id.'" class="collapsible-header waves-effect arrow-r">'.$tab.'<i
              class=" fas fa-folder"></i> &nbsp;&nbsp;&nbsp;'.$folder->Name.'<i class="fas fa-angle-down rotate-icon"></i></a>
			  <div class="collapsible-body">';
				$body .= "<ul tag='child'>".$this->getChildren($id,$class,$folder->id)."</ul>";
				$body .= "</div>";
				$body .= "</li>";
			}else{
				$body .= '<li tag="parent"><a data-id="'.$folder->id.'" class="waves-effect">'.$tab.'<i
              class=" fas fa-folder mr-2"></i> '.$folder->Name.'</a>';
				$body .= "</li>";
			}*/
			
			
			if($this->where(['entity_id' => $id, 'class_id' => $class])->where('Parent_ID',$folder->id)->exists()){
				$body .= '<li class="list-group-item text-white"><a  tag="parent" data-id="'.$folder->id.'" class="collapsible-header  waves-effect ">'.$tab.'<i
              class=" fas fa-folder"></i>'.$folder->Name.'<i class="fas fa-angle-down  rotate"></i></a><div class="collapsible-body">';
				$body .= "<ul tag='child' class='m-0  collapsible collapsible-accordion list-group  list-group-flush'>".$this->getChildren($id,$class,$folder->id)."</ul>";
				$body .= "</div>";
				$body .= "</li>";
			}else{
				$body .= '<li tag="child" class="list-group-item  text-white"><a data-id="'.$folder->id.'" class="collapsible-header ">'.$tab.'<i
              class=" fas fa-folder mr-2"></i> '.$folder->Name.'</a>';
				$body .= "</li>";
			} 
			
		}
		
			
		return $body;
		
	}
	
	public function countParents($id){
		if($id != null){
			$i = 1;
			
		$parent = $this->where('id',$id)->first();
		
			while($parent->Parent_ID > 0){
				
				$parent = $this->where('id',$parent->Parent_ID)->first();
				$i++;
			}
		
			
			
			return $i;
		}
		else{
			return 0; 
		}
			
		
		
		
	}
	
	
	public function return_childrenIDs($id,$code,$ec) {
		$id = $id > 0 ? $id : NULL;
		
		if($id === NULL){
			$alldata = $this->where(['class_id' => $ec, 'entity_id' => $code])->whereNULL('Parent_ID')->pluck('id');
		}else{
			$alldata = $this->where(['class_id' => $ec, 'entity_id' => $code, 'Parent_ID' => $id])->pluck('id');
		}
		
		$needed_Data =$alldata->toArray();
		foreach ($alldata as $folder) {
			
				
				$Childneeded_Data = $this->return_childrenIDs($folder,$code,$ec);
				$needed_Data = array_merge($needed_Data, $Childneeded_Data);
				
			}
		
		return $needed_Data;
	}
	

}
