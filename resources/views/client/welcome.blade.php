@extends('client.layout.client')

@section('content')

<div style="display: table; position: absolute; top: 0; left: 0; height: 100%; width: 100%; background: #E0E5EC;">
    <div style="display: table-cell; vertical-align: middle;">
      <div class="text-center" style="margin-left: auto; margin-right: auto; width: 100%;">
      	<img src="{{asset('assets/img/favicon_dark.png')}}" style="color: white;" />
        <h1 class="cast-text" style="color: #7b6be2; font-size: 30px;">Welcome to on-line <br>secure voting by VotRite</h1>
      </div>
    </div>
</div>

<div class="col-md-12" style="margin-top: 15px; display: none;">
    <a href="https://www.w3counter.com" class="w3-statu">
        <img src="https://www.w3counter.com/tracker.php?id=133786" style="border: 0" alt="W3Counter" />
    </a>
</div>

@endsection
@section('script')
<script>
  setTimeout(function(){
    window.location.href = "{{url('/client/ballot')}}"; 
  }, 3000);
</script>
@endsection