@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Change Password
		</h3>
		<div class="row">
			<div class="col-md-4">
                <form action="#">
                    <div class="form-group">
                        <label class="control-label">Current Password</label>
                        <input id='currentpwd' type="password" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">New Password</label>
                        <input id='newpwd' type="password" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Re-type New Password</label>
                        <input id='rnewpwd' type="password" class="form-control"/>
                    </div>
                    <div class="margin-top-10">
                        <a id="changebtn" class="btn green-haze">
                        Change Password </a>
                        <a id="reset" class="btn default">
                        Cancel </a>
                    </div>
                </form>
            </div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
    $('#changebtn').click(function(){
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        const baseurl = document.head.querySelector("[name~=baseurl][content]").content;
        var userid = $('#userid').val();
        var newpwd = $('#newpwd').val();
        var rnewpwd = $('#rnewpwd').val();
        if(newpwd == rnewpwd && newpwd != ''){

            let order = {
                "user_password": newpwd,
                "keys": {"user_id":userid}
            }
            console.log(order);
            fetch(baseurl+'user/update', {
                mode: 'no-cors',
                method: 'post',
                body: JSON.stringify(order),
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    "X-CSRF-Token": csrfToken
                }
            })
            .then(response => {
                console.log(response.text());
                return response.text();
            })
            .then(text => {
                return console.log(text);
            })
            .catch(error => console.error(error));
        }else{
            toastr.warning("Please re-enter password");
        }
        
    });
    $('#reset').click(function(){
        $('#currentpwd').val(null);
        $('#newpwd').val(null);
        $('#rnewpwd').val(null);
    });
</script>
@endsection
