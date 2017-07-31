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
                    <form class="form-horizontal" method="POST" action="">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('event') ? ' has-error' : '' }}">
                            <label for="event" class="col-md-4 control-label">Event Name</label>

                            <div class="col-md-6">

                                <select id="event" class="form-control" name="event" required autofocus>
                                    @foreach($events as $event)
                                        <option value="{{$event->id}}">{{$event->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('event'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('event') }}</strong>
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