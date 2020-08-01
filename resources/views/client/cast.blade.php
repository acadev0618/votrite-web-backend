@extends('client.layout.client')

@section('content')

<div style="display: table; position: absolute; top: 0; left: 0; height: 100%; width: 100%; background:white;">
    <div style="display: table-cell; vertical-align: middle;">
      <div class="text-center" style="margin-left: auto; margin-right: auto; width: 600px;">
      	<img src="{{asset('assets/img/ic_finish.png')}}" style="color: white;" />
        <h1 style="color: #7b6be2; font-size: 80px;">You are Voted</h1>
      </div>
    </div>
</div>

@endsection
@section('script')
<script>
setTimeout(function(){
    window.location.href = "{{url('/')}}"; 
     window.location.href = "{{url('/')}}"; 
    window.location.href = "{{url('/')}}"; 
    window.location.href = "{{url('/')}}"; 
    window.location.href = "{{url('/')}}"; 
}, 15000);
</script>
@endsection