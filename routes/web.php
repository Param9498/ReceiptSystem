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

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;

//Route::controller('/', 'Auth\AuthController');

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

//Auth
//	{
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
//	}

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', function(){
	$user = \Auth::user();

	if($user->website_admin == 1)
		return view('admin.websiteadmin');
	elseif (isset($user->roles()->where('name', 'Organization Admin')->first()->id)) {
		$organizations = $user->organizations()->get();
		return view('admin.organizationAdminSelectOrganization', compact('organizations'));
	}
})->middleware('auth', 'websiteAdmin:both')->name('admin');




//Website Admin Routes

//	{
		Route::get('/admin/addCollege', function(){
			$colleges = \App\College::all();
			return view('admin.addCollege', compact('colleges'));
		})->name('addCollege')->middleware('websiteAdmin');

		Route::post('/admin/addCollege', 'CollegeController@addNewCollege')->middleware('websiteAdmin');



		Route::get('/admin/addOrganization', function(){
			$colleges = \App\College::all();
			$organizations = \App\Organization::all();
			return view('admin.addOrganization', compact('colleges', 'organizations'));
		})->name('addOrganization')->middleware('websiteAdmin');

		Route::post('/admin/addOrganization', 'OrganizationController@addNewOrganization')->middleware('websiteAdmin');



		Route::get('/admin/addOrganizationAdmin', function(){
			$colleges = \App\College::all();
			$organizations = \App\Organization::all();
			return view('admin.addOrganizationAdmin', compact('colleges', 'organizations'));
		})->name('addOrganizationAdmin')->middleware('websiteAdmin');

		Route::post('/admin/addOrganizationAdmin', 'RoleController@addNewOrganizationAdmin')->middleware('websiteAdmin');
//	}


//Organization Admin Routes

//	{
		Route::post('/admin/dashboard', function(Request $request){
			$organization_id = $request->organization;
			session(['organizationSelectedByAdmin' => $organization_id]);
			$organizations = \App\Organization::where('id', session('organizationSelectedByAdmin'))->get();
			return view('admin.organizationAdmin', compact('organizations'));
		});

		Route::get('/admin/dashboard', function(){
			
			if(session('organizationSelectedByAdmin'))
			{	
				$organizations = \App\Organization::where('id', session('organizationSelectedByAdmin'))->get();
				return view('admin.organizationAdmin', compact('organizations'));
			}
			else 
				return redirect()->route('admin');
		})->middleware('OrganizationSelected');
		
		Route::get('/admin/addRole', function(){
			$organizations = \App\Organization::where('id', session('organizationSelectedByAdmin'))->get();
			//$roles = $events->roles()->get();
			return view('admin.addRole', compact('organizations'));
		})->name('addRole')->middleware('OrganizationSelected');

		Route::post('/admin/addRole', 'RoleController@addNewRole')->name('addRole')->middleware('OrganizationSelected');

		Route::post('/admin/addRole/{role_id}', 'RoleController@addRoleProfile')->middleware('OrganizationSelected');
		Route::get('/admin/addRole/{role_id}', function($role_id){
			$role_id = decrypt($role_id);
			$role = \App\Role::where('id', $role_id)->first();
			$users = $role->users()->get();
			$profiles = [];
			foreach ($users as $user) {
				array_push($profiles, $user->profile()->first());
			}
			return view('admin.addRoleMember', compact('role', 'users', 'profiles'));
		})->middleware('OrganizationSelected');




		Route::get('/admin/addEvent', function(){
			$events = \App\Event::where('organization_id', session('organizationSelectedByAdmin'))->get();
			return view('admin.addEvent', compact('events'));
		})->name('addEvent')->middleware('OrganizationSelected', 'auth');

		Route::post('/admin/addEvent', 'OrganizationController@addNewEvent')->name('addEvent')->middleware('OrganizationSelected', 'auth');
		/*Route::post('/admin/addEvent', function(Request $request){
			$numberInGroups = $request->noOfPeople;
			$numberInGroups = json_encode($numberInGroups);
			dd($numberInGroups);
		})->name('addEvent')->middleware('OrganizationSelected');*/

		Route::get('/admin/events', function(){
			$events = \App\Event::where('organization_id', session('organizationSelectedByAdmin'))->get();
			return $events->toJson();
		});

		Route::get('/admin/ReceiptsHandlePrivileges', function(){
			$organizations = \App\Organization::where('id', session('organizationSelectedByAdmin'))->get();
			//$roles = $events->roles()->get();
			return view('admin.receiptsHandlePrivileges', compact('organizations'));
		})->name('addReceiptsHandlePrivileges')->middleware('OrganizationSelected', 'auth');

		Route::post('/admin/ReceiptsHandlePrivileges', 'OrganizationController@addReceiptsHandlePrivileges')->name('addReceiptsHandlePrivileges')->middleware('OrganizationSelected', 'auth');
//	}

// Receipt Route:

//	{

		Route::get('/newReceipt', function(){
			//$events = \App\Event::where('organization_id', session('organizationSelectedByAdmin'))->get();
			$event = \App\Event::where('id', session('eventSelectedByUserForReceipt'))->first();
			return view('Receipt.addNew', compact('event'));
		})->name('newReceiptView')->middleware('auth', 'ChangeEvent');

		Route::get('/changeEvent', function(){
			$user = \Auth::user();
			//$organizations = \App\Organization::where('college_id', $user->college()->first()->id)->get();
			$organizations = $user->organizations;
			$events = [];
			foreach ($organizations as $organization) {
				array_push($events, $organization->events()->get());
			}
			return view('Receipt.changeEvent', compact('organizations', 'events'));
		})->name('changeEvent')->middleware('auth');

		Route::post('/saveEventNameForUser', function(Request $request){
			session(['eventSelectedByUserForReceipt' => $request->event]);
			return redirect()->route('receiptMaster');
		})->middleware('auth');

		Route::post('/newReceipt', 'ReceiptController@saveReceipt')->name('saveReceipt')->middleware('auth', 'ChangeEvent');

		/*Route::get('/viewReceipts', function(){
			return view('Receipt.viewAll');
		})->middleware('auth');*/

		Route::get('/amountToBeSubmitted', function(){
			if(!session('eventSelectedByUserForReceipt'))
			{
				return redirect()->route('changeEvent');
			}
			$event = \App\Event::where('id', session('eventSelectedByUserForReceipt'))->first();
			return view('Receipt.amountToBeSubmitted', compact('event'));
		})->name('amountToBeSubmitted')->middleware('auth', 'ChangeEvent');





		Route::get('/Receipts/FullyPaid',function(){
			$event = \App\Event::where('id', session('eventSelectedByUserForReceipt'))->first();
			$receipts = \App\Receipt::where('event_id', $event->id)->get();
			return view('Receipt.viewFullyPaid', compact('event', 'receipts'));
			//return $receipts;
		})->name('viewFullyPaid')->middleware('auth', 'ChangeEvent');

		Route::get('/Receipts/NotFullyPaid',function(){
			$event = \App\Event::where('id', session('eventSelectedByUserForReceipt'))->first();
			$receipts = \App\Receipt::where('event_id', $event->id)->get();
			return view('Receipt.viewNotFullyPaid', compact('event', 'receipts'));
		})->name('viewNotFullyPaid')->middleware('auth', 'ChangeEvent');


		Route::get('/editReceipt/singular/{i}', function($i){
			$receipt = \App\Receipt::where('id', $i)->first();
			$amountPaidPreviously = $receipt->amount;
			return view('Receipt.editAmountPaid', compact('amountPaidPreviously'));
		})->middleware('auth', 'ChangeEvent');

		Route::post('/editReceipt/singular/{i}', function($i, Request $request){
			$receipt = \App\Receipt::where('id', $i)->first();
			$user_amount = new \App\UserAmount();
			$user_amount->user_id = \Auth::user()->id;
			$user_amount->amount_collected = $request->amount - $receipt->amount;
			$user_amount->event_id = session('eventSelectedByUserForReceipt');
			$user_amount->save();
			$receipt->amount = $request->amount;
			$receipt->save();
			return redirect()->route('viewFullyPaid');
		})->middleware('auth', 'ChangeEvent');

		Route::get('/editReceipt/multiple/{i}', function($i){
			$receipts = \App\Receipt::where('group_id', $i)->get();
			$amountPaidPreviously = $receipts[0]->amount;
			return view('Receipt.editAmountPaid', compact('amountPaidPreviously'));
		})->middleware('auth', 'ChangeEvent');

		Route::post('/editReceipt/multiple/{i}', function($i, Request $request){
			$receipts = \App\Receipt::where('group_id', $i)->get();
			$user_amount = new \App\UserAmount();
			$user_amount->user_id = \Auth::user()->id;
			$user_amount->amount_collected = $request->amount - $receipts[0]->amount;
			$user_amount->event_id = session('eventSelectedByUserForReceipt');
			$user_amount->save();
			foreach ($receipts as $receipt) {
				$receipt->amount = $request->amount;
				$receipt->save();
			}
			return redirect()->route('viewFullyPaid');
		})->middleware('auth', 'ChangeEvent');


		Route::get('/Receipts/DateWisePayment', function(){
			return view('Receipt.dateWisePayment');
		})->name('dateWisePayment')->middleware('auth', 'ChangeEvent', 'ReceiptAdmin');

		Route::get('/Receipts/master', function(){
			return view('Receipt.receiptMaster');
		})->name('receiptMaster')->middleware('auth', 'ChangeEvent');
//	}



//JSON DATA - API

//	{
		
//	}