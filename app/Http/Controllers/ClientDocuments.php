<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClientFolders;
use App\ClientDocumentsTable;
use App\ClientDocuments_Folders;
use View;
use ZipArchive;
use Storage;
use Carbon\Carbon;
use DB;
use DataTables;

class ClientDocuments extends Controller
{
    //
	
	public function route(Request $request){
		$check = new ClientFolders;
		if($check->init($request->code,$request->ec) ){
			
			return $this->find_TopFolder($request->code,$request->ec);
		}else{
			return View::make('Client_Documents.setup');
		}
		
	}
	
	
	
	public function upload(Request $request){
		
		ClientFolders::where(['entity_id' => $request->code, 'class_id' => $request->ec])->delete();
		ClientDocumentsTable::where(['entity_id' => $request->code, 'class_id' => $request->ec])->delete();
		
		$input = $request->cdDoc;
		
	
		$zip = new ZipArchive();
		$zip->open($input);
		
		$array = [];
		$filearray = [];
		$foldercount = 1;
		$filecount = 0;
		
		 for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
			
			 $is_dir = substr($filename, -1) == '/';
			 if( $is_dir ){
				 $foldercount++;
			 }else{
				 $filecount++;
			 }

			
        }
		
	
		
		
	
		
		array_push($array, ['count' => $filecount]);
	
		array_push($array, ['foldercount' =>$foldercount]);

		
		
		return $array;
		
		
		
		
		
		
		
		
	
	
		
		
	}
	
	public function extractfile(Request $request){
		
		$input = $request->cdDoc;
		
		Storage::disk('clientDocs')->makeDirectory('Temp'.$request->code.'_'.$request->ec.'_'.carbon::now()->format('jmyhis'));
		
		$path = Storage::disk('clientDocs')->getDriver()->getAdapter()->applyPathPrefix('Temp'.$request->code.'_'.$request->ec);
		
		$zip = new ZipArchive();
		$zip->open($input);
		
		$zip->extractTo($path);
		
		return $this->seedDB($path,$request->code,$request->ec,null);
		
		
	
	}
	
	public function seedDB($dir,$code,$ec,$parent){
	
		$result = array();

   $cdir = scandir($dir);
   foreach ($cdir as $key => $value)
   {
      if (!in_array($value,array(".","..")))
      {
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
         {
			$newparent = ClientFolders::insertGetId([
				'Name' => $value, 'Parent_ID' => $parent, 'active' => 0, 'entity_id' => $code, 'class_id' => $ec
			]);
            $result[$value] = $this->seedDB($dir . DIRECTORY_SEPARATOR . $value,$code,$ec,$newparent);
         }
         else
         {
			 $docID = ClientDocumentsTable::insertGetID([
				 'folder_id' => $parent, 
				 'title' => pathinfo($dir . DIRECTORY_SEPARATOR . $value, PATHINFO_FILENAME),
				 'extension' => pathinfo($dir . DIRECTORY_SEPARATOR . $value, PATHINFO_EXTENSION ),
				 'size' => filesize($dir . DIRECTORY_SEPARATOR . $value),
				 'version' => '1.0',
				 'deleted' => 0,
				 'folder_location' => pathinfo($dir . DIRECTORY_SEPARATOR . $value, PATHINFO_DIRNAME  ),
				 'checked_out' => 0,
				 'uploaded_by' => session('MY_ID'),
				 'upload_date' => carbon::now(), 
				 'active' => 0, 
				 'file_location' => $this->moveFile($dir . DIRECTORY_SEPARATOR . $value,$code,$ec),
				 'entity_id' => $code,
				 'class_id' => $ec
				 
			 ]);
			 
		
            $result[] = $value;
         }
      }
   }
  
   return $result;
}
	
	public function moveFile($file,$code,$ec){
		
		$firstFolder = chr(rand(97,122));
		$secondFolder = chr(rand(65,90)).rand(1,9);
		$fileName = substr(md5(time()), 0, 16).'.'.pathinfo($file, PATHINFO_EXTENSION );
		Storage::disk('clientDocs')->makeDirectory($firstFolder.'/'.$secondFolder.'/');
		$newLocation = Storage::disk('clientDocs')->getDriver()->getAdapter()->applyPathPrefix($firstFolder.'/'.$secondFolder.'/'.$fileName);
		rename($file,$newLocation);
		return $newLocation;
		
		
		
	}
	
	public function checkDB(Request $request){
		
		$folders = ClientFolders::where(['entity_id' => $request->code, 'class_id' => $request->ec])->count();
		$files = ClientDocumentsTable::where(['entity_id' => $request->code, 'class_id' => $request->ec])->count();
		
		return array($folders,$files);
		
	}
	
	public function find_TopFolder($code, $ec){
		//$top = ClientFolders::where(['entity_id' => $code, 'class_id' => $ec])
			//->whereNull('Parent_ID')->first();
			//->get();
		$folders = new ClientFolders;
		$top = $folders->getChildren($code, $ec, null, 0);
		return View::make('Client_Documents.home')
			->with('top',$top)
			;
	} 
	
	public function getallDocuments(Request $request){
		
		
		$folders = new ClientFolders;
		$theFolders = $folders->return_childrenIDs($request->id, $request->code, $request->ec);
		if($request->id > 0){
		array_push($theFolders, $request->id);
	}
		return Datatables::of(ClientDocumentsTable::whereIn('folder_id',$theFolders)
							  ->join('Contact as uploader','uploader.Contact_ID','uploaded_by')
							  ->leftjoin('Contact as edit','edit.Contact_ID','editor')
							  
							  ->select(
			'edit.Forename as editorFName',
			'uploader.Forename as uploaderFName',
			'edit.Surname as editorSName',
			'uploader.Surname as uploaderSName',
			'UKHT_CD_Document.id',
      'UKHT_CD_Document.folder_id',
      'UKHT_CD_Document.title',
      'UKHT_CD_Document.description',
      'UKHT_CD_Document.extension',
      'UKHT_CD_Document.size',
      'UKHT_CD_Document.file_location',
      'UKHT_CD_Document.superceeded_by',
      'UKHT_CD_Document.version',
      'UKHT_CD_Document.deleted',
      'UKHT_CD_Document.folder_location',
      'UKHT_CD_Document.checked_out',
      'UKHT_CD_Document.uploaded_by',
      'UKHT_CD_Document.upload_date',
      'UKHT_CD_Document.document_series',
      'UKHT_CD_Document.active',
      'UKHT_CD_Document.entity_id',
      'UKHT_CD_Document.class_id'
		))->make();
		
		
    }
		
	public function download(Request $request){
		$id = $request->id;
		$data = DB::table('UKHT_CD_Document')->where("id", "=", $id)->first();
		
		DB::table('UKHT_CD_Document_Read')->updateorinsert(
		['document_id' => $id, 'contact_id' => session('MY_ID'), 'version' => $data->version ],
		['read_date' => carbon::now()]
		);
		
		
		return Storage::disk('clientDocs')->download(str_replace('\\\\ukhts055\\Data\\ClientDocs\\','',$data->file_location), $data->title.".".$data->extension);
		
		
	}
	
		
	public function readHistory(Request $request){
		$id = $request->id;
		$ver = $request->ver;
		$data = DB::table('UKHT_CD_Document_History')->where(['document_id' => $id, 'version' => $ver])->first();
		
		DB::table('UKHT_CD_Document_Read')->updateorinsert(
		['document_id' => $id, 'contact_id' => session('MY_ID'), 'version' => $data->version ],
		['read_date' => carbon::now()]
		);
		
		
		return Storage::disk('clientDocs')->download(str_replace('\\\\ukhts055\\Data\\ClientDocs\\','',$data->file_location), $data->title.".".$data->extension);
		
		
	}
	
	public function EditFile(Request $request){
		$id = $request->id;
		$data = DB::table('UKHT_CD_Document')->where("id", "=", $id)->first();
		
		DB::table('UKHT_CD_Document')->where('id',$id)
		->update(['checked_out' => 1,'editor' =>session('MY_ID')])
			;
		
		
		DB::table('UKHT_CD_Document_Read')->updateorinsert(
		['document_id' => $id, 'contact_id' => session('MY_ID'), 'version' => $data->version ],
		['read_date' => carbon::now()]
		);
		
		return Storage::disk('clientDocs')->download(str_replace('\\\\ukhts055\\Data\\ClientDocs\\','',$data->file_location), $data->title.".".$data->extension);
		
		
	}

	
	public function checkIn(Request $request) {
		
		
		$document = $request->document;
		$size = filesize($document);
		$firstFolder = chr(rand(97,122));
		$secondFolder = chr(rand(65,90)).rand(1,9);
		$fileName = substr(md5(time()), 0, 16).'.'.pathinfo($document, PATHINFO_EXTENSION );
		$extension =$request->file('document')->extension();
		Storage::disk('clientDocs')->makeDirectory($firstFolder.'/'.$secondFolder.'/');
		$newLocation = Storage::disk('clientDocs')->getDriver()->getAdapter()->applyPathPrefix($firstFolder.'/'.$secondFolder.'/'.$fileName);
		rename($document,$newLocation);
		$name =  str_replace(".$extension",'',$request->file('document')->getClientOriginalName());
		
		if($request->name){
			
			
		DB::table('UKHT_CD_Document')->where('id',$request->id)
		->update(['checked_out' => 0,'editor' =>session('MY_ID'),'uploaded_by' =>session('MY_ID'),'file_location' => $newLocation, 'upload_date' => Carbon::now(), 'description' => $request->description, 'version' => $request->version, 'size' => $size, 'extension' => $extension, 'title' => $name])
			;
			
		}else{
			
			
		DB::table('UKHT_CD_Document')->where('id',$request->id)
		->update(['checked_out' => 0,'editor' =>session('MY_ID'),'uploaded_by' =>session('MY_ID'),'file_location' => $newLocation, 'upload_date' => Carbon::now(), 'description' => $request->description, 'version' => $request->version, 'size' => $size, 'extension' => $extension ])
			;
		}
		
		
		
		return redirect()->back();
		
	}
	
	public function CDcancel(Request $request){
		
		DB::table('UKHT_CD_Document')->where(['id' => $request->id])->update(['checked_out' => 0]);
		
		
	}
	
	
	
}
