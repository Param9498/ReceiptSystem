<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function addNewOrganization(Request $request)
    {
    	$organization = new \App\Organization();
    	$organization->name = $request->organization;
    	$organization->college_id = $request->college;
    	$organization->save();
    	return redirect()->route('addOrganization');
    }
    public function addNewEvent(Request $request)
    {
        $numberInGroups = $request->noOfPeople;
        $numberInGroups = json_encode($numberInGroups);
        $priceForGroup = $request->priceForGroup;
        $priceForGroup = json_encode($priceForGroup);
    	$event = new \App\Event();
    	$event->name = $request->event;
        $event->pricePerPerson = $request->pricePerPerson;
        $event->numberInGroups = $numberInGroups;
        $event->priceForGroup = $priceForGroup;
    	$event->organization_id = session('organizationSelectedByAdmin');
    	$event->save();
    	return redirect()->route('addEvent');
    }
    public function addReceiptsHandlePrivileges(Request $request)
    {
        $organization = \App\Organization::where('id', session('organizationSelectedByAdmin'))->first();
        $addReceiptHandlePrivileges = $request->addReceiptHandlePrivileges;
        $addReceiptHandlePrivileges = json_encode($addReceiptHandlePrivileges);
        $organization->receipts_handle_privileges = $addReceiptHandlePrivileges;
        $organization->save();
        return redirect()->route('addReceiptsHandlePrivileges');
    }
}
