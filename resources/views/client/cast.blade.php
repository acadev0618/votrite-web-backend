@extends('client.layout.client')

@section('content')

<div class="cast row" style="height:100%;background:white">
    @if (count($result) != 0)
    @foreach($result as $val)
    @if($val == null || property_exists($val, "500"))
    @else
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $val->state }}</strong>
            <strong>{{ $val->message }}</strong>
    </div>
    @endif
    @endforeach
    @endif
    <div class="col-xs-12 text-center">
        <img src="{{asset('assets/img/ic_finish.png')}}" style="color: white;" alt="logo" class=""/>
    </div>
    <!-- <span class="glyphicon glyphicon-ok-circle" style="top: 40%;left: 40%;color: white;font-size: 300px;"></span> -->
    <div class="col-xs-12 text-center">
        <span style="color: #7b6be2; font-size: 100px;">You are Voted</span>
    </div>
</div>
<!-- END FOOTER -->
@endsection
@section('script')
<script>
setTimeout(function(){
     window.location.href = "{{url('/')}}"; 
}, 15000);
</script>
@endsection