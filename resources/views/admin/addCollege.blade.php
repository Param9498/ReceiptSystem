@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add College</div>
                <div class="panel-body">
                    <ul>
                        @foreach ($colleges as $college)
                            <li>{{$college->name}}</li>
                        @endforeach
                    </ul>
                    <form class="form-horizontal" method="POST" action="{{ route('addCollege') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('college') ? ' has-error' : '' }}">
                            <label for="college" class="col-md-4 control-label">College Name</label>

                            <div class="col-md-6">
                                <input id="college" type="college" class="form-control" name="college" value="{{ old('college') }}" required autofocus>

                                @if ($errors->has('college'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('college') }}</strong>
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
