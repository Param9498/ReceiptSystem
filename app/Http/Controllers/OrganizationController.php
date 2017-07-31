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
    	$event = new \App\Event();
    	$event->name = $request->event;
    	$event->organization_id = session('organizationSelectedByAdmin');
    	$event->save();
    	return redirect()->route('addEvent');
    }
}
