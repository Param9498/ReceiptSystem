<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CollegeController extends Controller
{
    public function addNewCollege(Request $request)
    {
    	$data = Input::all(); //$data = $request->json()->all(); should also work
		$college = new \App\College();
		$college->name = $data['college'];
		$college->save();

    	return redirect()->route('addCollege');
    }
    public function addNewCollegeThroughAPI(Request $request)
    {
    	$data = Input::all(); //$data = $request->json()->all(); should also work
		$college = new \App\College();
		$college->name = $data['college'];
		$college->save();
		$user = \Auth::user();
		return $user;
    }
}
