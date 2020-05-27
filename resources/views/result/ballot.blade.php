@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Active Ballots
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							Ballot Table
						</div>
					</div>
					<div class="portlet-body">
						<!-- <div class="table-toolbar">
							<div class="row">
								<div class="col-md-6">
									<div class="btn-group">
                                            <select class="form-control" id="active_change_option" name="active_change_option">
                                                <option value="1">Actived</option>
                                                <option value="2">Show All</option>
                                            </select>
									</div>
								</div>
							</div>
						</div> -->
                        <div id="change_table">
                            <table class="table table-striped table-bordered table-hover" id="result_ballot_table">
                            <thead>
                                <tr>
                                    <th>Address</th>
                                    <th>Candidate Name</th>
                                    <th>Election</th>
                                    <th>Race Name</th>
                                    <th>Race Title</th>
                                    <th>Race Voted Position</th>
                                    <th>Photo</th>
                                </tr>
                            </thead>
                            </table>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
function getImg(data, type, full, meta) {
    return '<img src='+data+' />';
}

var TableAjax = function () {
    console.log(baseurl);
    
    // $.ajax({
    //     type: 'GET',
    //     url: baseurl+'result/all',
    //     crossDomain: true,
    //     dataType: 'json',
    //     success: function(responseData, textStatus, jqXHR) {
    //         console.log(responseData);
    //             },
    //     error: function (responseData, textStatus, errorThrown) {
    //         alert('POST failed.');
    //     }
    // });
    var handleRecords = function () {

        var table = $('#result_ballot_table');

        table.dataTable({

            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "processing": "No Result"
            },
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            // "ajax":{
            //     type: 'GET',
            //     url: baseurl+'result/all',
            //     crossDomain: true,
            //     dataType: 'json',
            // },
            ajax: function (data, callback, settings) {
                $.ajax({
                url: baseurl+'result/all',
                type: 'GET',
                dataType: 'json',
                success:function(data){
                    console.log(data);
                    callback(data);
                }
                });
            },
            "columns": [
                { "data": "address" },
                { "data": "candidate_name" },
                { "data": "election" },
                { "data": "race_name" },
                { "data": "race_title" },
                { "data": "race_voted_position" },
                { "data": "photo", render: getImg}
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 5,
            "language": {
                "lengthMenu": " _MENU_ records"
            },
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [-1]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });

    }

    return {

        //main function to initiate the module
        init: function () {
            handleRecords();
        }

    };

}();
TableAjax.init();
</script>
@endsection
