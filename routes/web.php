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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

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
			$organization = \App\Organization::where('id', $organization_id)->first();
			return view('admin.organizationAdmin', compact('organization'));
		});
		
		Route::get('/admin/addRole', function(){
			$events = \App\Event::where('organization_id', session('organizationSelectedByAdmin'))->get();
			//$roles = $events->roles()->get();
			return view('admin.addRole', compact('events'));
		})->name('addRole')->middleware('OrganizationSelected');

		Route::post('/admin/addRole', 'RoleController@addNewRole')->name('addRole')->middleware('OrganizationSelected');


		Route::get('/admin/addEvent', function(){
			$events = \App\Event::where('organization_id', session('organizationSelectedByAdmin'))->get();
			return view('admin.addEvent', compact('events'));
		})->name('addEvent')->middleware('OrganizationSelected');

		Route::post('/admin/addEvent', 'OrganizationController@addNewEvent')->name('addEvent')->middleware('OrganizationSelected');


//	}