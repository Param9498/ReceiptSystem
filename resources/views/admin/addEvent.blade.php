@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add College</div>
                <div class="panel-body">
                    <ul>
                        @foreach ($events as $event)
                            <li>{{$event->name}}</li>
                        @endforeach
                    </ul>
                    <form class="form-horizontal" method="POST" action="{{ route('addEvent') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('event') ? ' has-error' : '' }}">
                            <label for="event" class="col-md-4 control-label">Event Name</label>

                            <div class="col-md-6">
                                <input id="event" class="form-control" name="event" value="{{ old('event') }}" required autofocus>

                                @if ($errors->has('event'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('event') }}</strong>
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
