<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    
    public function saveReceipt(Request $request)
    {
    	$this->validate($request, [
		    'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'branch' => 'required|min:3',
            'mobile_number' => 'required|integer|digits:10',
            'department' => 'required|string|min:2',
            'alternate_number' => 'integer|digits:10',
            'college' => 'string|min:1',
            'amount' => 'integer|digits_between:2,3',
		]);
		$receipt = new \App\Receipt();
		$receipt->name = $request->name;
		$receipt->email = $request->email;
		$receipt->branch = $request->branch;
		$receipt->mobile_number = $request->mobile_number;
		$receipt->department = $request->department;
		$receipt->alternate_number = $request->alternate_number;
		$receipt->college = $request->college;
		$receipt->amount = $request->amount;
		$user = \Auth::user();
		$receipt->user_id = $user->id;
		$receipt->event_id = session('eventSelectedByUserForReceipt');
		$receipt->save();
		$request->session()->flash('alert-success', 'User was successful added!');
		return redirect()->route('newReceiptView');	
    }
}
