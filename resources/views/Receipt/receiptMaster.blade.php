@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <?php $event = \App\Event::where('id', session('eventSelectedByUserForReceipt'))->first()->name;  ?>
                <div class="panel-heading">Receipt Master : {{ $event }}</div>
                <div class="panel-body">
                    <a href="{{ route('newReceiptView') }}">New Receipt</a><br>
                    <a href="{{ route('changeEvent') }}">Change Event</a><br>
                    <a href="{{ route('viewFullyPaid') }}">View Full Paid Receipts</a><br>
                    <a href="{{ route('viewNotFullyPaid') }}">View Not Fully paid receipts</a><br>
                    <?php 
                        $event = \App\Event::where('id', session('eventSelectedByUserForReceipt'))->first();
                        $privileged = $event->organization->receipts_handle_privileges;
                        $privileged = json_decode($privileged);
                        $user = \Auth::user();
                        $user_privilege = $user->roles()->where('organization_id', $event->organization->id)->get();
                        $privileges = [];
                        foreach ($user_privilege as $userprivilege) {
                            array_push($privileges, $userprivilege->privilege_level);
                        }
                        if (!empty(array_intersect($privileges, $privileged))) {
                    ?>
                            <a href="{{ route('dateWisePayment') }}">Date Wise Payment</a><br>
                    <?php 
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection