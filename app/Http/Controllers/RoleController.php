<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function addNewOrganizationAdmin(Request $request)
    {
    	$this->validate($request, [
		    'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'class' => 'required|string|min:2|max:10',
            'division' => 'required|integer',
            'branch' => 'required|min:3',
            'mobile_number' => 'required|integer|digits:10',
            'roll_number' => 'required|string|min:1',
            'department' => 'required|string|min:2',
            'alternate_number' => 'integer|digits:10',
            'college' => 'integer|min:1',
			'organization' => 'integer|min:1',            
		]);
    	$user = new \App\User();
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = bcrypt($request->password);
    	$user->college_id = $request->college;
    	$user->save();

    	$profile = new \App\Profile([
    		'class' => $request->class,
    		'division' => $request->division,
    		'branch' => $request->branch,
    		'mobile_number' =>$request->mobile_number,
    		'roll_number' => $request->roll_number,
    		'department' => $request->department,
    		'alternate_number' => $request->alternate_number,
    	]);

    	$user = \App\User::find($user->id);

    	$user->profile()->save($profile);

    	$role = $user->roles()->create([
		    'name' => "Organization Admin",
	    	'organization_id' => $request->organization,
	    	'privilege_level' => 0,
	    	'created_at'        => new \dateTime,
		]);

    	$organization = \App\Organization::find($request->organization);

    	$user->organizations()->save($organization);


    	return redirect()->route('admin');

    }

    public function addNewRole(Request $request)
    {
        $role = new \App\Role();
        $role->organization_id = $request->organization;
        $role->name = $request->role;
        $role->privilege_level = $request->privilege_level;
        $role->save();
        return redirect()->route('addRole');
    }
    public function addRoleProfile($role_id, Request $request)
    {
        $role = \App\Role::where('id', $role_id)->first();
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'class' => 'required|string|min:2|max:10',
            'division' => 'required|integer',
            'branch' => 'required|min:3',
            'mobile_number' => 'required|integer|digits:10',
            'roll_number' => 'required|string|min:1',
            'department' => 'required|string|min:2',
            'alternate_number' => 'integer|digits:10',            
        ]);
        $organization = $role->organization()->first();
        $college = $organization->college()->first();
        $user = new \App\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->college_id = $college->id;
        $user->save();

        $profile = new \App\Profile([
            'class' => $request->class,
            'division' => $request->division,
            'branch' => $request->branch,
            'mobile_number' =>$request->mobile_number,
            'roll_number' => $request->roll_number,
            'department' => $request->department,
            'alternate_number' => $request->alternate_number,
        ]);

        $user = \App\User::find($user->id);

        $user->profile()->save($profile);

        $user->roles()->save($role);

        $organization = \App\Organization::find($organization->id);

        $user->organizations()->save($organization);


        return redirect('/admin/dashboard');
    }
}
