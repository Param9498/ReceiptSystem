@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Hello, {{ $organization->name }} Admin</div>
                <div class="panel-body">
                    <a href="{{ route('addEvent') }}">Add a new event</a><br>
                    <a href="{{ route('addRole') }}">Add Roles for the Event</a><br>
                    <?php
                        $events = $organization->events()->get(); 
                    ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Event</th>
                            <th>Role</th>  
                            <th>Privilege Level</th>                         
                        </tr>
                        <?php $i = 1; ?>
                        @foreach($events as $event)
                            @foreach($event->roles()->get(); as $role)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{ $event->name }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->privilege_level }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
