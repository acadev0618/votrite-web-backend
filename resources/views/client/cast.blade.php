@extends('client.layout.client')

@section('content')

<div style="position:absolute;width:100%;height:100%;background:white">
    @if (count($result) != 0)
    @foreach($result as $val)
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $val->state }}</strong>
            <strong>{{ $val->message }}</strong>
    </div>
    @endforeach
    @endif
    <img src="{{asset('assets/img/ic_finish.png')}}" style="top: 40%;left: 40%;color: white;" alt="logo" class=""/>
    <!-- <span class="glyphicon glyphicon-ok-circle" style="top: 40%;left: 40%;color: white;font-size: 300px;"></span> -->
    <span style=" position: absolute; top: 70%; left: 28%; color: #7b6be2; font-size: 100px;">You are Voted</span>
</div>
<!-- END FOOTER -->
@endsection
@section('script')
<script>
setTimeout(function(){
     window.location.href = "{{url('/')}}"; 
}, 5000);
</script>
@endsection