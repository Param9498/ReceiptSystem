@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Hello, Website Admin</div>
                <div class="panel-body">
                    <a href="{{ route('addCollege') }}"> Register a new College</a><br>
                    <a href="{{ route('addOrganization') }}"> Register a new Organization</a><br>
                    <a href="{{ route('addOrganizationAdmin') }}"> Register a new Organization Admin</a><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
