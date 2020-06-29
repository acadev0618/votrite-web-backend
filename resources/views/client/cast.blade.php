@extends('client.layout.client')

@section('content')
<div style="position:absolute;width:100%;height:100%;background:#7b6be2">
    <span class="glyphicon glyphicon-ok-circle" style="top: 40%;left: 40%;color: white;font-size: 300px;"></span>
    <span style=" position: absolute; top: 60%; left: 28%; color: white; font-size: 100px;">You are Voted</span>
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