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

                        <div class="form-group{{ $errors->has('pricePerPerson') ? ' has-error' : '' }}">
                            <label for="pricePerPerson" class="col-md-4 control-label">Cost for 1 Receipt</label>

                            <div class="col-md-6">
                                <input id="pricePerPerson" class="form-control" name="pricePerPerson" value="{{ old('pricePerPerson') }}" required autofocus>

                                @if ($errors->has('pricePerPerson'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pricePerPerson') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('event_cost_for_one') ? ' has-error' : '' }}">
                            <label for="event_cost_for_one" class="col-md-4 control-label">Cost for Group</label>

                            <div class="col-md-6">
                                <div class="input_fields_wrap">
                                    <div>
                                        <table style="margin: 10px">
                                            <tr>
                                                <th>Number of people in group</th>
                                                <th>Price for them</th>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="noOfPeople[]"></td>
                                                <td><input type="text" name="priceForGroup[]"></td>
                                            </tr>
                                        </table>
                                        <button id="add_field_button" class = "btn btn-primary">+</button>
                                    </div>
                                </div>
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
    
@section('scripts')

    <script>
        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var wrapper         = $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $("#add_field_button"); //Add button ID
            
            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(wrapper).append('<div><table style="margin: 10px"><tr><th>Number of people in group</th><th>Price for them</th></tr><tr><td><input type="text" name="noOfPeople[]"></td><td><input type="text" name="priceForGroup[]"></td></tr></table><a href="#" class="remove_field">Remove</a></div>'); //add input box
                }
            });
            
            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent('div').remove(); x--;
            })
        });
    </script>

@endsection