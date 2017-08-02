@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Hello, Admin</div>
                <div class="panel-body">
                    <a href="{{ route('addEvent') }}">Add a new event</a><br>
                    <a href="{{ route('addRole') }}">Add Roles in the event</a><br>
                    Add Users :- <br>
                    <table class="table table-bordered">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Organization</th>
                            <th>Role</th>  
                            <th>Privilege Level</th> 
                            <th>Add/Edit/View</th>                      
                        </tr>
                        <?php $i = 1; ?>
                        @foreach($organizations as $organization)
                            @foreach($organization->roles()->get() as $role)
                                @if($role->privilege_level != 0)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{ $organization->name }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->privilege_level }}</td>
                                        <td><a href="{{  url('/admin/addRole/'.encrypt($role->id))  }}">Click Here</a></td>
                                    </tr>
                                    <?php $i++; ?>
                                @endif
                            @endforeach
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
