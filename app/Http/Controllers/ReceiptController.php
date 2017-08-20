<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    
    public function saveReceipt(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|array|min:1',
            'email.*' => 'required|string|email|max:255|unique:receipts,email',
            'branch' => 'required|min:3',
            'mobile_number.*' => 'required|integer|digits:10',
            'department' => 'required|string|min:2',
            'alternate_number' => 'integer|digits:10',
            'college' => 'string|min:1',
            'amount' => 'integer|digits_between:2,3',
		]);
		/*foreach($request->name as $key => $val)
		{
			//$rules['name.'.$key] = 'required|string|max:255';
			$this->validate($request, [
				'name'.$key => 'required|string|max:255',
			]);
		}
		foreach($request->email as $key => $val)
		{
			//$rules['email.'.$key] = 'required|string|max:255';
			$this->validate($request, [
				'email'.$key => 'required|string|email|max:255|unique:users',
			]);
		}
		foreach($request->mobile_number as $key => $val)
		{
			//$rules['mobile_number.'.$key] = 'required|string|max:255';
			$this->validate($request, [
				'mobile_number'.$key => 'required|integer|digits:10',
			]);
		}*/
		$names = $request->name;
		$emails = $request->email;
		$mobile_numbers = $request->mobile_number;
		$group = $request->numberInGroups;
		if($group > 1)
		{
			$g = new \App\Group();
			$g->numberOfReceipts = $group;
			$g->save();
		}
		//dd($emails);
		for ($i=0; $i < $group; $i++) { 
			$receipt = new \App\Receipt();
			$receipt->name = $names[$i];
			$receipt->email = $emails[$i];
			$receipt->branch = $request->branch;
			$receipt->mobile_number = $mobile_numbers[$i];
			$receipt->department = $request->department;
			$receipt->alternate_number = $request->alternate_number;
			$receipt->college = $request->college;
			$receipt->amount = $request->amount;
			$user = \Auth::user();
			$receipt->user_id = $user->id;
			$receipt->event_id = session('eventSelectedByUserForReceipt');
			if($group > 1)
				$receipt->group_id = $g->id;
			$receipt->save();
		}
		\DB::table('user_amount')->insert([
			'user_id' => \Auth::user()->id,
			'amount_collected' =>$request->amount,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'event_id' => session('eventSelectedByUserForReceipt'),
		]);

		$request->session()->flash('alert-success', 'Receipt was successful saved!');
		return redirect()->route('newReceiptView');	
    }
}
