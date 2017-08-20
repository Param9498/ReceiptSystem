@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Date Wise Payment Per User</div>
                <div class="panel-body">
                    <?php 
                        $dates = \App\UserAmount::select(\DB::raw('DATE(created_at) AS day'))->distinct('day')->get('day');
                        foreach ($dates as $date) {
                            echo "<h4>".$date->day."-> </h4>";
                            $users = \App\UserAmount::select([\DB::raw('sum(amount_collected) AS amountCollectedForTheDay'), \DB::raw('user_id AS uid') ])->whereRaw('DATE(created_at) = "'.$date->day.'"')->where('event_id', session('eventSelectedByUserForReceipt'))->groupBy('uid')->get();
                            foreach ($users as $user) {
                                echo \App\User::where('id', $user->uid)->first()->name.' : '.$user->amountCollectedForTheDay.'<br>';
                            }
                        }
                    ?>
                    <a href="{{ route('changeEvent') }}">Change Event</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection