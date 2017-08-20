@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Hello</div>
                <div class="panel-body">
                    <form method="POST" action="{{ url('/saveEventNameForUser') }}" class="form-horizontal">
                    {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Select Event</label>

                            <div class="col-md-6">
                                <select class="form-control" name ="event" id = "event">
                                    @foreach ($events as $event)
                                        @for ($i = 0; $i < count($event); $i++)
                                            <option value="{{ $event[$i]->id }}">{{ $event[$i]->name }}</option>
                                        @endfor
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Go
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