<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'session'],function(){

Route::get('AutoUpload', function(){
	//
	return View::make('fileSync');
});


Route::get('home', function()
{
	//
    return View::make('intranet.homes');
});

Route::get('/', function()
{
	//
    return View::make('intranet.homes');
})->name('home');





Route::get('dashboard', function()
{
	//
    return View::make('pages.dashboard');
});



Route::get('imssearch', function()
{
	//
     return View::make('search.ims');
});

Route::get('locationSettings', function()
{
	//
     return View::make('obs.locationSettings');
});

Route::get('occuranceFurtherInfo', function()
{
     return View::make('obs.occuranceFurtherInfo');
});

Route::get('OccuranceView', function()
{
     return View::make('obs.OccuranceViewer');
});
	
	Route::get('HARTHistory', function()
{
     return View::make('obs.HistoryCheck');
});

 Route::post('locationPosts', function()
{
     return View::make('obs.locationPosts');
});

	Route::post('OccuranceAllocate','OccuranceController@Allocate');
	Route::post('OccuranceAction','OccuranceController@Action');
	Route::post('CloseOccurance','OccuranceController@Close');
	Route::post('OccuranceUploadDocument','OccuranceController@UploadDocument');
	Route::get('OccuranceDocDownload','OccuranceController@DocDownload');
	Route::get('OccuranceOldPhotos','OccuranceController@ReadHistoryPhotos');
	Route::post('OccuranceAddRoot','OccuranceController@AddRoot');
	Route::post('OccuranceRemoveRoot','OccuranceController@RemoveRoot');
	Route::post('OccuranceAddSubRoot','OccuranceController@AddSubRoot');
	Route::post('OccuranceRemoveSubRoot','OccuranceController@RemoveSubRoot');
	Route::post('OccuranceAddSubCategory','OccuranceController@AddSubCategory');
	Route::post('OccuranceRemoveSubCategory','OccuranceController@RemoveSubCategory');
	Route::post('OccuranceAddCategory','OccuranceController@AddCategory');
	Route::post('OccuranceRemoveCategory','OccuranceController@RemoveCategory');
	Route::post('OccuranceAddRIDDOR','OccuranceController@AddRIDDOR');
	Route::post('OccuranceRemoveRIDDOR','OccuranceController@RemoveRIDDOR');
	Route::post('OccuranceEditName','OccuranceController@EditName');
	
	
	Route::post('OccuranceSaveCategory','OccuranceController@SaveCategory');
	Route::post('OccuranceUploadPhotos','OccuranceController@OccuranceUploadPhotos');
	Route::post('OccuranceChangeOCC','OccuranceController@ChangeOCC');
	Route::post('OccuranceMember','OccuranceController@Member');
	Route::post('OccuranceLocations','OccuranceController@Location');
	Route::post('OccuranceSecretCategory','OccuranceController@SecretCategory');
	Route::post('OccuranceSaveSettings','OccuranceController@SaveSettings');
	Route::post('updateandgetLocations','OccuranceController@updateandgetLocations');
	
	Route::get('HARTDuplicateCheck','OccuranceController@DuplicateCheck');
	Route::get('HARTChartData','OccuranceController@HARTChartData');
	Route::Post('HARTDeleteHART','OccuranceController@DeleteHART');
	
	Route::view('CloseOccuranceEmail','emails.occurance.close');
	
	Route::view('ManHoursInput','obs.ManHoursInput');
	Route::view('ManHours','obs.ManHoursReporting');
	Route::get('GETmanhours','ManHoursController@GETmanhours');
	Route::post('GETmanhours','ManHoursController@GETmanhours');
	Route::Post('ManHoursGetCardData','ManHoursController@GetCardData');
	Route::Post('GlobalManHoursGetCardData','ManHoursController@GlobalGetCardData');
	Route::Post('GetManHoursDay','ManHoursController@GetManHoursDay');
	Route::Post('SaveManHours','ManHoursController@SaveManHours');
 
	
	


Route::get('clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";

});

// Monitor Capture


Route::get('Monitorinput', function()
{
     return View::make('asset.input');
});


//ICT Projects

Route::get('ictProjectCreate', function()
{
     return View::make('ICT.projectCreate1');
});

Route::get('ictProjectTasks', function()
{
     return View::make('ICT.projectTask2');
});

Route::get('ProjectsUser', function()
{
     return View::make('ICT.projectOverview_User');
});

Route::get('projectExtendedView', function()
{
     return View::make('ICT.projectExtendedView2');
});

Route::post('Historic_View', function()
{
     return View::make('ICT.Historic_View');
});

Route::get('ictProjectView', function()
{
     return View::make('ICT.projectView');
});

Route::get('ictProjectMessages', function()
{
     return View::make('ICT.Messages');
});

Route::get('ictUserTasks', function()
{
     return View::make('ICT.User_tasksView1');
});

Route::get('ictTaskextended', function()
{
     return View::make('ICT.Project_task_extended');
});


Route::post('monitorPost', function()
{
     return View::make('asset.post');
});

Route::post('sendAlert', function()
{
     return View::make('alerts.sendAlerts');
});



Route::post('postProjectMessage', function()
{
     return View::make('ICT.postMessage');
});



Route::post('AddProjectPHP', function()
{
     return View::make('ICT.AddProjectPHP');
});

Route::post('EditDetails', function()
{
     return View::make('ICT.EditDetails');
});


Route::post('AddContact', function()
{
     return View::make('ICT.AddContact');
});

Route::post('AddTask', function()
{
     return View::make('ICT.AddTaskPHP');
});

Route::post('AddNewTask', function()
{
     return View::make('ICT.AddNewTaskPHP');
});

Route::post('navRoleAccess', function()
{
     return View::make('Admin.navRoleAccess');
});
Route::post('userRoleAccess', function()
{
     return View::make('Admin.userRoleAccess');
});

Route::post('alertImageUploads', function()
{
     return View::make('alerts.alertImageUploads');
});

Route::post('readAlert', function()
{
     return View::make('alerts.readAlert');
});

Route::post('alertGroupDeleteUser', function()
{
     return View::make('alerts.alertGroupDeleteUser');
});
//Extra Curricular 

Route::get('emailExport', function()
		   {
     return View::make('Extras.emailExport');
});

Route::view('MyNotifications','me.MyNotifications');

Route::get('DownloadAppraisal', function()
		   {
     return View::make('Me.DownloadAppraisal');
});

Route::post('MyProfile/SendRequest', 'User_Personal_Data@save');

Route::post('HR/UserAmmend/Confirm', 'User_Personal_Data@commit');

Route::post('HR/UserAmmend/Deny', 'User_Personal_Data@deny');

Route::view('HR/UserAmmendments', 'Me.HR_Amendments');

Route::get('HR/UserAmmendments_Notify', 'User_Personal_Data@Notify');

Route::get('HRUserAjax', function()
{
     return View::make('HR.InternalEmployeesAJAX');
});

Route::post('getEmailExport', function()
{
     return View::make('Extras.getEmailExport');
});



//navs


$routes = DB::table("UKHT_Nav")->get(); 

foreach($routes as $route){
	  $link = $route->Page;

	Route::view($route->Link, $link)->name($route->Name);
	
	
	
	
};

Route::post('addUsefulLinks','Intranet@add');
Route::get('delUsefulLinks','Intranet@delete');
	
//Occurances
Route::view('OccuranceProjectDash', 'obs.OccuranceProjectDash');
Route::view('OccuranceProjectFilter', 'obs.OccuranceProjectFilterd');
Route::view('OccuranceFilter', 'obs.OccuranceFilter');
Route::view('OccuranceProjectExport', 'obs.ExcelExport');
Route::get('OccuranceExport', 'OccuranceController@export');


//Helpdesk
Route::view('MyOpenUnassigned', 'HelpDesk.MyOpenUnassigned');
Route::view('OtherOpen', 'HelpDesk.OtherOpen');
Route::view('Download', 'Dowload');
Route::view('LogaCall', 'HelpDesk.LogaCall');
Route::view('TicketDetails', 'HelpDesk.Ticket');
Route::post('HelpPosts', function(){
	 return View::make('HelpDesk.HelpPosts');
});Route::post('HelpUpdate', function(){
	 return View::make('HelpDesk.HelpUpdates');
});


//LPT2
Route::view('LPT2', 'LPTtwo.home');
Route::view('LPT2intranet', 'LPTtwo.intranet');
Route::view('LPT2contacts', 'LPTtwo.contacts');
Route::view('LPT2/addContact', 'LPTtwo.Addcontact');
Route::post('LPT2/createContact', 'LPT2Controller@CreateContact');
Route::get('LPT2/removeContact', 'LPT2Controller@removeFromLPT2');
Route::get('LPT2/addtoLPT2', 'LPT2Controller@addtoLPT2');
	
Route::post('LPT2/continueCreateContact', 'LPT2Controller@continueCreateContact');
Route::view('LPT2/TimeUsers', 'LPTtwo.Time.Users');
Route::view('LPT2/User', 'LPTtwo.Time.TUsers');
Route::get('LPT2/User/export/', 'LPT2Export@export');
Route::get('LPT2/User/exportBulk/', 'LPT2Export@exportBulk');
Route::get('LPT2/User/summaryExport/', 'LPT2Export@summary');
Route::view('LPT2/User/exporter/', 'LPTtwo.Time.UserSummary');
Route::post('LPT2Update', function(){
	 return View::make('LPTtwo.Time.LPT2Update');
});


//OVERTIME
Route::post('OvertimePosts', function(){
	 return View::make('Me.OvertimePoster'); 
});
Route::post('OvertimeApprovalPosts', function(){
	 return View::make('HR.OvertimeApprovalPosts'); 
});
Route::view('OvertimePastItems','Me.OvertimePastItem');
Route::view('OvertimeDashTable','HR.OvertimeDashTable');
Route::view('MeOvertimeDashTable','Me.OvertimeDashTable');
Route::view('OvertimeApproval','HR.OvertimeApproval');
Route::view('MyOvertimeDash','Me.MyOvertimeDash');




//Request Forms
Route::view('ICT/NewStarter','HelpDesk.Forms.starter');


//Acq Pages 
Route::view('ACQ/General','Acq.General');
Route::view('ACQ/General_Edit','Acq.General_Edit');
Route::view('ACQ/New','Acq.New');
Route::post('ACQ/Posts', function(){
	 return View::make('Acq.Posts'); 
});
//ACQ Time 
Route::view('ACQ/Time','Acq.Time.dash');
Route::view('ACQ/ExcelTime','Acq.Time.exceldash');
Route::get('ACQ/ExcelExport','ACQExports@export');
Route::post('ACQ/UpdateACQTimeRole','ACQTime@UpdateACQTimeRole');
Route::post('ACQ/ACQAddRole','ACQTime@ACQAddRole');
Route::post('ACQ/OneOffAssign','ACQTime@OneOffAssign');
Route::post('ACQ/editWeeklyEst','ACQTime@editWeeklyEst');
Route::post('ACQ/editWeeklyExtraEst','ACQTime@editWeeklyExtraEst');
Route::post('ACQ/editExtraEst','ACQTime@editExtraEst');
Route::post('ACQ/editWeeklyExtraActual','ACQTime@editWeeklyExtraActual');
Route::post('ACQ/deleteUserFromWeek','ACQTime@deleteUserFromWeek');
Route::post('ACQ/BulkAssign','ACQTime@BulkAssign');

Route::get('SearchTheOrganisations',['as'=>'SearchTheOrganisations','uses'=>'SearchTheOrganisations@SearchTheOrganisations']);

//ClientDocs
Route::get('ClientDocuments','ClientDocuments@route')->name('Client_Documents');
Route::post('CDupload','ClientDocuments@upload');
Route::post('CDextract','ClientDocuments@extractfile');
Route::post('CDdatabase','ClientDocuments@seedData');
Route::post('CDcheckDB','ClientDocuments@checkDB');
Route::get('getRouteFolder','ClientDocuments@find_TopFolder');
route::get('CDdownload', 'ClientDocuments@download');
route::get('Readhistory', 'ClientDocuments@readHistory');
route::get('CDedit', 'ClientDocuments@EditFile');
route::post('CDcheckIn', 'ClientDocuments@checkIn');
route::post('CDcancel', 'ClientDocuments@CDcancel');
	
	Route::get('getClientDocs', ['uses'=>'ClientDocuments@getallDocuments', 'as'=>'getClientDocs.index']);

Route::get('CDAjaxTable', function()
{
     return View::make('Client_Documents.ajax_CD_Table');
});

Route::get('CDAjaxDetails', function()
{
     return View::make('Client_Documents.ajax_CD_Details');
});
	
Route::get('CDAjaxCheckout', function()
{
     return View::make('Client_Documents.ajax_CheckedOut');
});
	
Route::get('CD_EditProp', function()
{
     return View::make('Client_Documents.ajax_EditProperties');
});

Route::post('opexIdea', 'VariousEmailFunctions@opexIdea');

//Me Forms 
Route::view('MyProfile/Amend','Me.Amendments2');

Route::view('Covid','Covid.COVID');
	
	Route::post('postNewWorkWinning', 'WorkWinningDash@update');
Route::post('tickerNewWorkWinning', 'WorkWinningDash@ticker');
Route::post('DeletepostNewWorkWinning', 'WorkWinningDash@deletepost');
Route::post('sloganNewWorkWinning', 'WorkWinningDash@slogan');


	});


Route::view('WorkWinning', 'WorkWinningDash');


// Corporate Compliance

Route::view('CorporateCompliance', 'Corporate.Compliance');



Route::view('FieldViewList','FieldView.List');

