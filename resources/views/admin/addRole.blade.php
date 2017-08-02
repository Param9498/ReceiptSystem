@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Role</div>
                <div class="panel-body">

                    <table class="table table-bordered">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Event</th>
                            <th>Role</th>  
                            <th>Privilege Level</th>                         
                        </tr>
                        <?php $i = 1; ?>
                        @foreach($organizations as $organization)
                            @foreach($organization->roles()->get() as $role)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{ $organization->name }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->privilege_level }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </table>
                    <form class="form-horizontal" method="POST" action="">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('organization') ? ' has-error' : '' }}">
                            <label for="organization" class="col-md-4 control-label">Organization Name</label>

                            <div class="col-md-6">

                                <select id="organization" class="form-control" name="organization" required autofocus>
                                    @foreach($organizations as $organization)
                                        <option value="{{$organization->id}}">{{$organization->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('organization'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('organization') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="role" class="col-md-4 control-label">Role Name</label>

                            <div class="col-md-6">
                                <input id="role" class="form-control" name="role" value="{{ old('role') }}" required autofocus>

                                @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('privilege_level') ? ' has-error' : '' }}">
                            <label for="privilege_level" class="col-md-4 control-label">Privilege Level</label>

                            <div class="col-md-6">
                                <input id="privilege_level" class="form-control" name="privilege_level" value="{{ old('privilege_level') }}" required autofocus>

                                @if ($errors->has('privilege_level'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('privilege_level') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

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