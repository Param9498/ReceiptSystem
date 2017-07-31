@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Organization</div>
                <div class="panel-body">

                    <table class="table table-bordered">
                        <tr>
                            <th>Sr. No.</th>
                            <th>College</th>
                            <th>Organization</th>                           
                        </tr>
                        <?php $i = 1; ?>
                        @foreach($organizations as $organization)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{ $organization->college->name }}</td>
                                <td>{{ $organization->name }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <form class="form-horizontal" method="POST" action="{{ route('addOrganization') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('college') ? ' has-error' : '' }}">
                            <label for="college" class="col-md-4 control-label">College Name</label>

                            <div class="col-md-6">

                                <select id="college" class="form-control" name="college" required autofocus>
                                    @foreach($colleges as $college)
                                        <option value="{{$college->id}}">{{$college->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('college'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('college') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('organization') ? ' has-error' : '' }}">
                            <label for="organization" class="col-md-4 control-label">organization Name</label>

                            <div class="col-md-6">
                                <input id="organization" class="form-control" name="organization" value="{{ old('organization') }}" required autofocus>

                                @if ($errors->has('organization'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('organization') }}</strong>
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
