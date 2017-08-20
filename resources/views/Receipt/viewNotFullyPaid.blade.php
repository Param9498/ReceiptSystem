@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Not Fully Paid Receipts</div>
                <div class="panel-body">
                <?php
                    $numberInGroups = $event->numberInGroups;
                    $numberInGroups = json_decode($numberInGroups);
                    $priceForGroup = $event->priceForGroup;
                    $priceForGroup = json_decode($priceForGroup); 
                ?>
                Not in Group(Singular):
                    <table class="table table-bordered">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Name</th>
                            <th>Email-ID</th> 
                            <th>Mobile Number</th>
                            <th>Amount Paid</th>
                            <th>Amount Remaining</th>
                            <th>Edit Amount Paid</th>                         
                        </tr>
                        <?php $i = 1; $j = 0; ?>
                        @foreach($receipts as $receipt)                                                
                            @if($receipt->group_id == NULL)
                                @if($receipt->amount != $event->pricePerPerson)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{ $receipt->name }}</td>
                                        <td>{{ $receipt->email }}</td>
                                        <td>{{ $receipt->mobile_number }}</td>
                                        <td>{{ $receipt->amount }}</td>
                                        <td>{{ $event->pricePerPerson - $receipt->amount}}</td>
                                        <td align="center"><a href="{{ url('/editReceipt/singular/'.$receipt->id) }}">Edit</a></td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </table>
                    In Group:
                    <table class="table table-bordered">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Name</th>
                            <th>Email-ID</th>
                            <th>Mobile Number</th>
                            <th>Amount Paid</th> 
                            <th>Amount Remaining</th>
                            <th>Edit Amount Paid</th>                       
                        </tr>
                        <?php $i = 1; $j = 0; $groupsCounted = [];?>
                        @for($j = 0; $j< count($receipts); $j++)
                            @if($receipts[$j]->group_id != NULL)
                                <?php
                                    if(in_array($receipts[$j]->group_id, $groupsCounted))
                                    {
                                        continue;
                                    }
                                    if (!in_array($receipts[$j]->amount, $priceForGroup))
                                    {
                                        $numberOfMembersInGroup = $receipts[$j]->group->numberOfReceipts;
                                        $key = array_search($numberOfMembersInGroup, $numberInGroups);
                                        $amountToBePaid = $priceForGroup[$key];
                                        $rs = \App\Receipt::where('group_id', $receipts[$j]->group_id)->get();
                                ?>
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>
                                            @foreach($rs as $r)
                                                {{ $r->name }}, 
                                            @endforeach
                                            </td>
                                            <td>
                                                @foreach($rs as $r)
                                                    {{ $r->email }}, 
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($rs as $r)
                                                    {{ $r->mobile_number }}, 
                                                @endforeach
                                            </td>
                                            <td>{{ $r->amount }}</td>
                                            <td>{{ $amountToBePaid - $r->amount }}</td>
                                            <td align="center"><a href="{{ url('/editReceipt/multiple/'.$r->group_id) }}">Edit</a></td>
                                        </tr>
                                        
                                <?php
                                    array_push($groupsCounted, $receipts[$j]->group_id);
                                    }
                                ?>
                            @endif
                        @endfor
                    </table>
                    <a href="{{ route('changeEvent') }}">Change Event</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection