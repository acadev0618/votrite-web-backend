<h4 style="font-weight: bold;" id="ballot_board">{{$ballots->data[0]->board}}</h4>
<h4 style="font-weight: bold;" >{{$ballots->data[0]->address}}</h4>
<h4 style="font-weight: bold;" >{{$ballots->data[0]->client}}</h4>
<h4 style="font-weight: bold;" >{{$ballots->data[0]->election}}</h4>
<h4 style="font-weight: bold;" >Start : {{date_format(date_create($ballots->data[0]->start_date),"l, F j, Y")}}</h4>
<h4 style="font-weight: bold;" >End : {{date_format(date_create($ballots->data[0]->end_date),"l, F j, Y")}}</h4>
<br>
@csrf
<h3 class="text-center" style="width: 400px;border-bottom:1px solid;font-weight: bold;">END OF DAY - REPORT</h3>
<h4 style="font-weight: bold;" >TOTAL VOTES ON MACHINE........{{$blt_cnt}}</h4>
<hr style="border: 1px solid;width: 400px;">
<div id="countresult" class="form-group" style="margin-left:25px;">
@if(count($candidates) != 0)
@foreach($candidates as $race)
    <h4 style="font-weight: bold;">{{$race[0]->race_title}}</h4>
    <h4 style="font-weight: bold;">{{$race[0]->race_name}}</h4>
    @foreach($race as $cand)
    <h4>{{$cand->candidate_name}} - {{$cand->cast_counter}}</h4>
    @endforeach
@endforeach
@else
No Candidate
@endif
</div>
<hr style="border: 1px solid;width: 400px;">
<h2>Proposition</h2>
<div id="propresult" class="form-group" style="margin-left:25px;">
@if(count(get_object_vars($props)) != 0 && property_exists($props, "data"))
@if(count($props->data) != 0)
@foreach($props->data as $pro)
    <h4>{{$pro->prop_name}}</h4>
    @if($pro->prop_answer_type == 1)
    <h4>Yes - {{$pro->cast_yes}}</h4>
    <h4>No - {{$pro->cast_no}}</h4>
    @else
    <h4>For - {{$pro->cast_yes}}</h4>
    <h4>Against - {{$pro->cast_no}}</h4>
    @endif
@endforeach
@else
No Proposition
@endif                            
@endif                            
</div>