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
		})->name('addEvent')->middleware('OrganizationSelected');

		Route::post('/admin/addEvent', 'OrganizationController@addNewEvent')->name('addEvent')->middleware('OrganizationSelected');

		Route::get('/admin/events', function(){
			$events = \App\Event::where('organization_id', session('organizationSelectedByAdmin'))->get();
			return $events->toJson();
		});
//	}