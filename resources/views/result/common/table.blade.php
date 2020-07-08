<h3 id="ballot_board">{{$ballots->data[0]->board}}</h3>
<h3 >{{$ballots->data[0]->address}}</h3>
<h3 >{{$ballots->data[0]->client}}</h3>
<h3 >{{$ballots->data[0]->election}}</h3>
<br>
@csrf
<h2 class="text-center" style="border-bottom:1px solid">END OF DAY - REPORT</h2>
<h2 >TOTAL VOTES ON MACHINE...........................{{$blt_cnt}}</h2>
<hr style="border: 1px solid;width: 500px;">
<div id="countresult" class="form-group" style="margin-left:25px;">
@if(count($candidates) != 0)
@foreach($candidates as $race)
    <h3>{{$race[0]->race_title}}</h3>
    <br>
    <h3>{{$race[0]->race_name}}</h4>
    @foreach($race as $cand)
    <h4>{{$cand->candidate_name}} - {{$cand->cast_counter}}</h4>
    @endforeach
@endforeach
@else
No Candidate
@endif
</div>
<hr style="border: 1px solid;width: 500px;">
<h2>Proposition</h2>
<div id="propresult" class="form-group" style="margin-left:25px;">
@if(count(get_object_vars($props)) != 0 && property_exists($props, "data"))
@if(count($props->data) != 0)
@foreach($props->data as $pro)
    <h3>{{$pro->prop_name}}</h3>
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