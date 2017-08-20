@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Hello, Admin</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="">
                        <table class="table table-bordered">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Organization</th>
                                <th>Role</th>  
                                <th>Privilege Level</th>
                                <th>Give Privileges</th>
                            </tr>
                            <?php $i = 1; ?>
                            
                            @foreach($organizations as $organization)
                                @foreach($organization->roles()->get() as $role)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{ $organization->name }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->privilege_level }}</td>
                                        <td align="center"><input type="checkbox" name="addReceiptHandlePrivileges[]" value="{{ $role->privilege_level }}" ></td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            @endforeach
                        </table>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
