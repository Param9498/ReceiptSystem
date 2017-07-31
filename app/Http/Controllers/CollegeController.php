<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function addNewCollege(Request $request)
    {
    	$college = new \App\College();
    	$college->name = $request->college;
    	$college->save();

    	return redirect()->route('addCollege');
    }
}
