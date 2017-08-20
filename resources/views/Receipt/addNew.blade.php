@extends('layouts.app')

@section('content')

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))

            <p class="alert alert-{{ $msg }}" >{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    @endforeach
</div> <!-- end .flash-message -->
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register for {{ $event->name }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('saveReceipt') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('numberInGroups') ? ' has-error' : '' }}">
                            <label for="numberInGroups" class="col-md-4 control-label">Number In Groups</label>

                            <div class="col-md-6">
                                <?php   
                                    $numberInGroups = $event->numberInGroups;
                                    $numberInGroups = json_decode($numberInGroups);          
                                ?>
                                <select id="numberInGroups" class="form-control" name="numberInGroups" value="{{ old('numberInGroups') }}" required autofocus>
                                    <option value="1">1</option>
                                    @foreach ($numberInGroups as $number)
                                        <option value="{{ $number }}">{{ $number }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('numberInGroups'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('numberInGroups') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <div id="number-of-name-inputs"><input type="text" class="form-control name-class" name="name[]" value="{{ old('name.0') }}" required></div>
                                

                                @if ($errors->has('name.0'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name.0') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <div id="number-of-email-inputs">
                                    <input type="email" class="form-control email-class" name="email[]" value="{{ old('email.0') }}" required>
                                </div>
                                @if ($errors->has('email.0'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email.0') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                      

                        <div class="form-group{{ $errors->has('college') ? ' has-error' : '' }}">
                            <label for="college" class="col-md-4 control-label">College</label>

                            <div class="col-md-6">
                                <input id="college" class="form-control" name="college" value="{{ old('college') }}" required>

                                @if ($errors->has('college'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('college') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('branch') ? ' has-error' : '' }}">
                            <label for="branch" class="col-md-4 control-label">Branch</label>

                            <div class="col-md-6">
                                <input id="branch" type="branch" class="form-control" name="branch" value="{{ old('branch') }}" required>

                                @if ($errors->has('branch'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('branch') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                            <label for="department" class="col-md-4 control-label">Department</label>

                            <div class="col-md-6">
                                <input id="department" type="department" class="form-control" name="department" value="{{ old('department') }}" required>

                                @if ($errors->has('department'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('department') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
                            <label for="mobile_number" class="col-md-4 control-label">Mobile Number</label>

                            <div class="col-md-6">
                                

                                <div id="number-of-mobile-inputs">
                                    <input type="text" class="form-control mobile-class" name="mobile_number[]" value="{{ old('mobile_number.0') }}" required>
                                </div>

                                @if ($errors->has('mobile_number.0'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile_number.0') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('alternate_number') ? ' has-error' : '' }}">
                            <label for="alternate_number" class="col-md-4 control-label">Alternate mobile Number</label>

                            <div class="col-md-6">
                                <input id="alternate_number" type="alternate_number" class="form-control" name="alternate_number" value="{{ old('alternate_number') }}">

                                @if ($errors->has('alternate_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alternate_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-4 control-label">Amount Paid</label>

                            <div class="col-md-6">
                                <input id="amount" class="form-control" name="amount" value="{{ old('amount') }}" required>

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <a href="{{ route('changeEvent') }}">Change Event</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $( document ).ready(function() {
            var valueSelected = $("#numberInGroups").val();
            var name = document.getElementById("number-of-name-inputs");
            var email = document.getElementById("number-of-email-inputs");
            var mobile = document.getElementById("number-of-mobile-inputs");
            //alert(valueSelected);
            $('.name-class').remove();
            $('.email-class').remove();
            $('.mobile-class').remove();
            var str1 = "<input type='text' class='form-control name-class' name='name[]' value='{{ old('name."+i+"') }}' required>";
            var str2 = "<input type='text' class='form-control email-class' name='email[]' value='{{ old('email."+i+"') }}' required>";
            var str3 = "<input type='text' class='form-control mobile-class' name='mobile_number[]'' value='{{ old('mobile_number."+i+"') }}' required>";
            for (i = 0; i < valueSelected; i++) {
                name.insertAdjacentHTML( 'beforeend', str1 );
                email.insertAdjacentHTML('beforeend', str2);
                mobile.insertAdjacentHTML('beforeend', str3);
            }
        });
        $('#numberInGroups').on('change', function (e) {

            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var name = document.getElementById("number-of-name-inputs");
            var email = document.getElementById("number-of-email-inputs");
            var mobile = document.getElementById("number-of-mobile-inputs");
            //alert(valueSelected);
            $('.name-class').remove();
            $('.email-class').remove();
            $('.mobile-class').remove();
            var str1 = "<input type='text' class='form-control name-class' name='name[]' value='{{ old('name."+i+"') }}' required>";
            var str2 = "<input type='text' class='form-control email-class' name='email[]' value='{{ old('email."+i+"') }}' required>";
            var str3 = "<input type='text' class='form-control mobile-class' name='mobile_number[]'' value='{{ old('mobile_number."+i+"') }}' required>";
            for (i = 0; i < valueSelected; i++) {
                name.insertAdjacentHTML( 'beforeend', str1 );
                email.insertAdjacentHTML('beforeend', str2);
                mobile.insertAdjacentHTML('beforeend', str3);
            }
        });
    </script>
@endsection