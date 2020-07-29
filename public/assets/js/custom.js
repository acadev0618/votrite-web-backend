var api_url = "ec2-3-90-78-113.compute-1.amazonaws.com:9191/api";
var base_url="";

var TableManaged = function () {
    var dashboardTable = function () {

        var table = $('#dashboard_table');

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
                "zeroRecords": "No matching records found"
            },
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            
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

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });
    }

    var ballotTable = function () {

        var table = $('#ballot_table');
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
                "zeroRecords": "No matching records found"
            },
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            
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
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        table.on('click', '.editBallotModal', function(){
            var id = $(this).data('id');
            var start = ($(this).data('start').slice(0, 16));
            var end = ($(this).data('end')).slice(0, 16);

            var modal = $('#editBallotModal');
            $('#editClient').val($(this).data('client'));
            $('#editElection').val($(this).data('election'));
            $('#editAddress').val($(this).data('address'));
            $('#editBoard').val($(this).data('board'));
            $('#editStart').val(start);
            $('#editEnd').val(end);
            modal.find('#editBallot_id').val(id);
            modal.modal('show');
        });

        table.on('click', '.previewBallotModal', function(){
            var start = ($(this).data('start').slice(0, 16));
            var end = ($(this).data('end')).slice(0, 16);

            var modal = $('#previewBallotModal');
            $('#previewClient').val($(this).data('client'));
            $('#previewElection').val($(this).data('election'));
            $('#previewAddress').val($(this).data('address'));
            $('#previewBoard').val($(this).data('board'));
            $('#previewStart').val(start);
            $('#previewEnd').val(end);
            modal.modal('show');
        });

        table.on('click', '.deleteBallotModal', function(){
            var target_id= 'ballot_id';
            var id = $(this).data('id');
            var api = api_url+'/ballot/delete';

            var modal = $('#deleteBallotModal');

            modal.find('.id').val(id);
            modal.find('.target_id').val(target_id);
            modal.find('.api').val(api);
            modal.modal('show');
        });

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        table.find('.checkboxes').change(function(){
            var checked = $(this).is(":checked");
            if (checked) {
                $(this).attr("checked", true);
            } else {
                $(this).attr("checked", false);
            }
        });

        $(document).on('click', '.deleteBallotsModal', function(){
            var modal = $('#deleteBallotsModal');
            var allVals = [];

            table.find(".checkboxes:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });

            if(allVals.length <= 0) {
                var confrim = $('#confirmModal');
                confrim.modal('show');
            } else {
                modal.modal('show');
                var target_id = 'ballot_id';
                var ids = allVals.join(",");
                var api = api_url+'/ballot/delete';

                modal.find('.target_id').val(target_id);
                modal.find('.ids').val(ids);
                modal.find('.api').val(api);
            }
        });

        $("[name='active_ballot_checkbox']").bootstrapSwitch({
            on:'Actived',
            off:'No',
            onLabel:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
            offLabel:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
            same:false,
            size:'md',
            onClass:'primary',
            offClass:'default'
        });
        
        $("[name='active_ballot_checkbox']").change(function() {
            var checked = $(this).is(":checked");
            var ballot_id = $(this).data('id');
            if (checked) {
                $(this).attr("checked", true);
                var is_deleted = "false";
            } else {
                $(this).attr("checked", false);
                var is_deleted = "true";
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/changeBallotActive',
                type: 'post',
                data: {
                    is_deleted : is_deleted,
                    ballot_id : ballot_id
                },
                success: function(response) {
                    var response = JSON.parse(response);
                    if(response.state == 'success'){
                        toastr[response.state]('Ballot activation state is changed successfully.');
                    } else {
                        toastr['error']('Whoops! Something went wrong.');
                    }
                }
            });
        });

        $('#active_change_option').on('change', function(){
            var state = $(this).val();
        
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: base_url+'/getChangedBallot',
                type: 'POST',
                data: {
                    state : state
                },
                success:function(response){
                    $('#confirmModal').remove();
                    $('#change_table').html(response);
    
                    var table = $('#ballot_table');
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
                            "zeroRecords": "No matching records found"
                        },
                        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                        
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
                            'targets': [0]
                        }, {
                            "searchable": false,
                            "targets": [0]
                        }],
                        "order": [
                            [1, "asc"]
                        ] // set first column as a default sort by asc
                    });

                    table.on('click', '.editBallotModal', function(){
                        var id = $(this).data('id');
                        var start = ($(this).data('start').slice(0, 16));
                        var end = ($(this).data('end')).slice(0, 16);

                        var modal = $('#editBallotModal');
                        $('#editClient').val($(this).data('client'));
                        $('#editElection').val($(this).data('election'));
                        $('#editAddress').val($(this).data('address'));
                        $('#editBoard').val($(this).data('board'));
                        $('#editStart').val(start);
                        $('#editEnd').val(end);
                        modal.find('#editBallot_id').val(id);
                        modal.modal('show');
                    });

                    table.on('click', '.previewBallotModal', function(){
                        var start = ($(this).data('start').slice(0, 16));
                        var end = ($(this).data('end')).slice(0, 16);

                        var modal = $('#previewBallotModal');
                        $('#previewClient').val($(this).data('client'));
                        $('#previewElection').val($(this).data('election'));
                        $('#previewAddress').val($(this).data('address'));
                        $('#previewBoard').val($(this).data('board'));
                        $('#previewStart').val(start);
                        $('#previewEnd').val(end);
                        modal.modal('show');
                    });

                    table.on('click', '.deleteBallotModal', function(){
                        var target_id= 'ballot_id';
                        var id = $(this).data('id');
                        var api = api_url+'/ballot/delete';

                        var modal = $('#deleteBallotModal');

                        modal.find('.id').val(id);
                        modal.find('.target_id').val(target_id);
                        modal.find('.api').val(api);
                        modal.modal('show');
                    });

                    table.find('.group-checkable').change(function () {
                        var set = jQuery(this).attr("data-set");
                        var checked = jQuery(this).is(":checked");
                        jQuery(set).each(function () {
                            if (checked) {
                                $(this).attr("checked", true);
                            } else {
                                $(this).attr("checked", false);
                            }
                        });
                        jQuery.uniform.update(set);
                    });

                    table.find('.checkboxes').change(function(){
                        var checked = $(this).is(":checked");
                        if (checked) {
                            $(this).attr("checked", true);
                        } else {
                            $(this).attr("checked", false);
                        }
                    });

                    $(document).on('click', '.deleteBallotsModal', function(){
                        var modal = $('#deleteBallotsModal');
                        var allVals = [];

                        table.find(".checkboxes:checked").each(function() {  
                            allVals.push($(this).attr('data-id'));
                        });

                        if(allVals.length <= 0) {
                            var confrim = $('#confirmModal');
                            confrim.modal('show');
                        } else {
                            modal.modal('show');
                            var target_id = 'ballot_id';
                            var ids = allVals.join(",");
                            var api = api_url+'/ballot/delete';

                            modal.find('.target_id').val(target_id);
                            modal.find('.ids').val(ids);
                            modal.find('.api').val(api);
                        }
                    });

                    $("[name='active_ballot_checkbox']").bootstrapSwitch({
                        on:'Actived',
                        off:'No',
                        onLabel:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                        offLabel:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                        same:false,
                        size:'md',
                        onClass:'primary',
                        offClass:'default'
                    });
                    
                    $("[name='active_ballot_checkbox']").change(function() {
                        var checked = $(this).is(":checked");
                        var ballot_id = $(this).data('id');
                        if (checked) {
                            $(this).attr("checked", true);
                            var is_deleted = "false";
                        } else {
                            $(this).attr("checked", false);
                            var is_deleted = "true";
                        }

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/changeBallotActive',
                            type: 'post',
                            data: {
                                is_deleted : is_deleted,
                                ballot_id : ballot_id
                            },
                            success: function(response) {
                                var response = JSON.parse(response);
                                if(response.state == 'success'){
                                    toastr[response.state]('Ballot activation state is changed successfully.');
                                } else {
                                    toastr['error']('Whoops! Something went wrong.');
                                }
                            }
                        });
                    });
                }
            });
        });
    }

    var raceTable = function () {

        var table = $('#change_table #race_table');

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
                "zeroRecords": "No matching records found"
            },
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            
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
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        table.find('.checkboxes').change(function(){
            var checked = $(this).is(":checked");
            if (checked) {
                $(this).attr("checked", true);
            } else {
                $(this).attr("checked", false);
            }
        });

        $('.max_cand').on('change', function(){
            var max_cand = $(this).val();
            var option = '';
            if(max_cand == 0) {
                option += "<option value='0'>0</opiton>"
            } else {
                for(i = 0; i <= max_cand; i ++) {
                    option += "<option value='"+i+"'>"+i+"</opiton>"
                }
            }
            $('.max_w_cand').html(option);
        });

        $(document).on('click', '.deleteRacesModal', function(){
            var ballot_id = $('#select_ballot_name').val();
            var modal = $('#deleteRacesModal');
            var allVals = [];

            table.find(".checkboxes:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });

            if(allVals.length <= 0) {
                var confrim = $('#confirmModal');
                confrim.modal('show');
            } else {
                modal.modal('show');
                var target_id = 'race_id';
                var ids = allVals.join(",");
                var api = api_url+'/race/delete';

                modal.find('#ballot_id').val(ballot_id);
                modal.find('.target_id').val(target_id);
                modal.find('.ids').val(ids);
                modal.find('.api').val(api);
            }
        });

        $('.addRaceModal').click(function(){
            var ballot_id = $('#select_ballot_name').val();
            if(ballot_id == -1) {
                var modal = $('#confirmModal');
                modal.find('.modal_content').text("Please make ballot, first.");
                modal.modal('show');
            } else {
                var modal = $('#addRaceModal');
                modal.find('#ballot_id').val(ballot_id);
                modal.modal('show');
            }
        });

        table.on('click', '.previewRaceModal', function(){
            var race_id = $(this).data('id');
            var modal = $('#previewRaceModal');

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneRace',
                type: 'post',
                data: {
                    race_id : race_id
                },
                success: function(response) {
                    var race = JSON.parse(response);

                    var max_cand = race.data[0].max_num_of_votes;
                    var option = '';
                    for(i = 0; i <= max_cand; i ++) {
                        option += "<option disabled value='"+i+"'>"+i+"</opiton>"
                    }
                    modal.find('.max_w_cand').html(option);

                    modal.find('#race_name').val(race.data[0].race_name);
                    modal.find('#race_type').val(race.data[0].race_type);
                    modal.find('#min_num_of_votes').val(race.data[0].min_num_of_votes);
                    modal.find('#max_num_of_votes').val(race.data[0].max_num_of_votes);
                    modal.find('#max_num_of_write_ins').val(race.data[0].max_num_of_write_ins);
                    if(race.data[0].race_lang_id == null) {
                        modal.find('#race_lang_id').val(0);
                    } else {
                        modal.find('#race_lang_id').val(race.data[0].race_lang_id);
                    }
                    if(race.data[0].race_location_id == null) {
                        modal.find('#race_location_id').val(0);
                    } else {
                        modal.find('#race_location_id').val(race.data[0].race_location_id);
                    }
                    modal.find('#race_title').val(race.data[0].race_title);
                    modal.find('#race_voted_position').val(race.data[0].race_voted_position);
                }
            });

            modal.modal('show');
        });

        table.$('.editRaceModal').click(function(){
            var ballot_id = $('#select_ballot_name').val();
            var race_id = $(this).data('id');
            var modal = $('#editRaceModal');
            modal.find('#ballot_id').val(ballot_id);

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneRace',
                type: 'post',
                data: {
                    race_id : race_id
                },
                success: function(response) {
                    var race = JSON.parse(response);

                    var max_cand = race.data[0].max_num_of_votes;
                    var option = '';
                    for(i = 0; i <= max_cand; i ++) {
                        option += "<option value='"+i+"'>"+i+"</opiton>"
                    }
                    modal.find('.max_w_cand').html(option);

                    modal.find('#edit_race_id').val(race_id);
                    modal.find('#edit_race_name').val(race.data[0].race_name);
                    modal.find('#edit_race_type').val(race.data[0].race_type);
                    modal.find('#edit_min_num_of_votes').val(race.data[0].min_num_of_votes);
                    modal.find('#edit_max_num_of_votes').val(race.data[0].max_num_of_votes);
                    modal.find('#edit_max_num_of_write_ins').val(race.data[0].max_num_of_write_ins);
                    if(race.data[0].race_lang_id == null) {
                        modal.find('#race_lang_id').val(0);
                    } else {
                        modal.find('#race_lang_id').val(race.data[0].race_lang_id);
                    }
                    if(race.data[0].race_location_id == null) {
                        modal.find('#race_location_id').val(0);
                    } else {
                        modal.find('#race_location_id').val(race.data[0].race_location_id);
                    }
                    modal.find('#edit_race_title').val(race.data[0].race_title);
                    modal.find('#edit_race_voted_position').val(race.data[0].race_voted_position);
                }
            });

            modal.modal('show');
        });
            
        table.$('.deleteRaceModal').click(function(){
            var ballot_id = $('#select_ballot_name').val();
            var target_id= 'race_id';
            var id= $(this).data('id');
            var api = api_url+'/race/delete';
            var modal = $('#deleteRaceModal');

            modal.find('#ballot_id').val(ballot_id);
            modal.find('.id').val(id);
            modal.find('.target_id').val(target_id);
            modal.find('.api').val(api);
            modal.modal('show');
        });

        $('#select_ballot_name').on('change', function(){
            var ballot_id = $(this).val();
        
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getChangedRaces',
                type: 'POST',
                data: {
                    ballot_id : ballot_id,
                },
                success:function(response){
                    $('#addRaceModal').remove();
                    $('#deleteRacesModal').remove();
                    $('#confirmModal').remove();
                    $('#change_table').html(response);        
                    
                    var table = $('#change_table #race_table');

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
                            "zeroRecords": "No matching records found"
                        },
                        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                        
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
                            'targets': [0]
                        }, {
                            "searchable": false,
                            "targets": [0]
                        }],
                        "order": [
                            [1, "asc"]
                        ] // set first column as a default sort by asc
                    });
            
                    table.find('.group-checkable').change(function () {
                        var set = jQuery(this).attr("data-set");
                        var checked = jQuery(this).is(":checked");
                        jQuery(set).each(function () {
                            if (checked) {
                                $(this).attr("checked", true);
                            } else {
                                $(this).attr("checked", false);
                            }
                        });
                        jQuery.uniform.update(set);
                    });
            
                    table.find('.checkboxes').change(function(){
                        var checked = $(this).is(":checked");
                        if (checked) {
                            $(this).attr("checked", true);
                        } else {
                            $(this).attr("checked", false);
                        }
                    });
            
                    $('.max_cand').on('change', function(){
                        var max_cand = $(this).val();
                        var option = '';
                        if(max_cand == 0) {
                            option += "<option value='0'>0</opiton>"
                        } else {
                            for(i = 0; i <= max_cand; i ++) {
                                option += "<option value='"+i+"'>"+i+"</opiton>"
                            }
                        }
                        $('.max_w_cand').html(option);
                    });

                    $(document).on('click', '.deleteRacesModal', function(){
                        var ballot_id = $('#select_ballot_name').val();
                        var modal = $('#deleteRacesModal');
                        var allVals = [];
            
                        table.find(".checkboxes:checked").each(function() {  
                            allVals.push($(this).attr('data-id'));
                        });
            
                        if(allVals.length <= 0) {
                            var confrim = $('#confirmModal');
                            confrim.modal('show');
                        } else {
                            modal.modal('show');
                            var target_id = 'race_id';
                            var ids = allVals.join(",");
                            var api = api_url+'/race/delete';
            
                            modal.find('#ballot_id').val(ballot_id);
                            modal.find('.target_id').val(target_id);
                            modal.find('.ids').val(ids);
                            modal.find('.api').val(api);
                        }
                    });
            
                    $('.addRaceModal').click(function(){
                        var ballot_id = $('#select_ballot_name').val();
                        if(ballot_id == -1) {
                            var modal = $('#confirmModal');
                            modal.find('.modal_content').text("Please make ballot, first.");
                            modal.modal('show');
                        } else {
                            var modal = $('#addRaceModal');
                            modal.find('#ballot_id').val(ballot_id);
                            modal.modal('show');
                        }
                    });
            
                    table.on('click', '.previewRaceModal', function(){
                        var race_id = $(this).data('id');
                        var modal = $('#previewRaceModal');
            
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/getOneRace',
                            type: 'post',
                            data: {
                                race_id : race_id
                            },
                            success: function(response) {
                                var race = JSON.parse(response);
            
                                var max_cand = race.data[0].max_num_of_votes;
                                var option = '';
                                for(i = 0; i <= max_cand; i ++) {
                                    option += "<option disabled value='"+i+"'>"+i+"</opiton>"
                                }
                                modal.find('.max_w_cand').html(option);
            
                                modal.find('#race_name').val(race.data[0].race_name);
                                modal.find('#race_type').val(race.data[0].race_type);
                                modal.find('#min_num_of_votes').val(race.data[0].min_num_of_votes);
                                modal.find('#max_num_of_votes').val(race.data[0].max_num_of_votes);
                                modal.find('#max_num_of_write_ins').val(race.data[0].max_num_of_write_ins);
                                if(race.data[0].race_lang_id == null) {
                                    modal.find('#race_lang_id').val(0);
                                } else {
                                    modal.find('#race_lang_id').val(race.data[0].race_lang_id);
                                }
                                if(race.data[0].race_location_id == null) {
                                    modal.find('#race_location_id').val(0);
                                } else {
                                    modal.find('#race_location_id').val(race.data[0].race_location_id);
                                }
                                modal.find('#race_title').val(race.data[0].race_title);
                                modal.find('#race_voted_position').val(race.data[0].race_voted_position);
                            }
                        });
            
                        modal.modal('show');
                    });

                     table.$('.editRaceModal').click(function(){
                           var ballot_id = $('#select_ballot_name').val();
                           var race_id = $(this).data('id');
                           var modal = $('#editRaceModal');
                           modal.find('#ballot_id').val(ballot_id);
                           
                           $.ajax({
                              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                              url: base_url+'/getOneRace',
                              type: 'post',
                              data: {
                                 race_id : race_id
                              },
                              success: function(response) {
                                 var race = JSON.parse(response);

                                 var max_cand = race.data[0].max_num_of_votes;
                                 var option = '';
                                 for(i = 0; i <= max_cand; i ++) {
                                       option += "<option value='"+i+"'>"+i+"</opiton>"
                                 }
                                 modal.find('.max_w_cand').html(option);

                                 modal.find('#edit_race_id').val(race_id);
                                 modal.find('#edit_race_name').val(race.data[0].race_name);
                                 modal.find('#edit_race_type').val(race.data[0].race_type);
                                 modal.find('#edit_min_num_of_votes').val(race.data[0].min_num_of_votes);
                                 modal.find('#edit_max_num_of_votes').val(race.data[0].max_num_of_votes);
                                 modal.find('#edit_max_num_of_write_ins').val(race.data[0].max_num_of_write_ins);
                                 if(race.data[0].race_lang_id == null) {
                                       modal.find('#race_lang_id').val(0);
                                 } else {
                                       modal.find('#race_lang_id').val(race.data[0].race_lang_id);
                                 }
                                 if(race.data[0].race_location_id == null) {
                                       modal.find('#race_location_id').val(0);
                                 } else {
                                       modal.find('#race_location_id').val(race.data[0].race_location_id);
                                 }
                                 modal.find('#edit_race_title').val(race.data[0].race_title);
                                 modal.find('#edit_race_voted_position').val(race.data[0].race_voted_position);
                              }
                           });

                           modal.modal('show');
                     });
            
                    table.$('.deleteRaceModal').click(function(){
                        var ballot_id = $('#select_ballot_name').val();
                        var target_id= 'race_id';
                        var id= $(this).data('id');
                        var api = api_url+'/race/delete';
                        var modal = $('#deleteRaceModal');
            
                        modal.find('#ballot_id').val(ballot_id);
                        modal.find('.id').val(id);
                        modal.find('.target_id').val(target_id);
                        modal.find('.api').val(api);
                        modal.modal('show');
                    });
                }
            });
        });
    }

    var candidateTable = function () {

        var table = $('#candidate_table');

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
                "zeroRecords": "No matching records found"
            },
            "bStateSave": true,



            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"]
            ],
            "pageLength": 5,
            "language": {
                "lengthMenu": " _MENU_ records"
            },
            "columnDefs": [{
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ]
        });

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        table.find('.checkboxes').change(function(){
            var checked = $(this).is(":checked");
            if (checked) {
                $(this).attr("checked", true);
            } else {
                $(this).attr("checked", false);
            }
        });

        $('.addCandidateModal').click(function(){
            var ballot_id = $('#cand_ballot_name').val();
            var race_id = $('#cand_race_name').val();
            var lang_id = $('#cand_lang_name').val();
            var party_id = $('#add_cand_party').val();
            var confirmModal = $('#candConfirmModal');
            var addModal = $('#addCandidateModal');

            addModal.find('#ballot_id').val(ballot_id);
            addModal.find('#race_id').val(race_id);
            addModal.find('#lang_id').val(lang_id);

            if(ballot_id == null) {
                confirmModal.find('.modal_content').text("There aren't any ballots. Please make the ballot, first.");
                confirmModal.modal('show');
            } else if(race_id == null) {
                confirmModal.find('.modal_content').text("There aren't any races in this ballot. Please make the race, first.");
                confirmModal.modal('show');
            } else if(party_id == null) {
                confirmModal.find('.modal_content').text("There aren't any parties in this ballot. Please make the party, first.");
                confirmModal.modal('show');
            } else if(lang_id == null) {
                confirmModal.find('.modal_content').text("There aren't any languages in this ballot. Please make the language, first.");
                confirmModal.modal('show');
            } else {
                addModal.modal('show');
            }
        });

        $(document).on('click', '.deleteCandidatesModal', function(){
            var modal = $('#deleteCandidatesModal');
            var allVals = [];
            var ballot_id = $('#cand_ballot_name').val();
            var race_id = $('#cand_race_name').val();
            modal.find('#ballot_id').val(ballot_id);
            modal.find('#race_id').val(race_id);

            table.find(".checkboxes:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });

            if(allVals.length <= 0) {
                var confrim = $('#candConfirmModal');
                confrim.modal('show');
            } else {
                modal.modal('show');
                var target_id = 'candidate_id';
                var ids = allVals.join(",");
                var api = api_url+'/candidate/delete';

                modal.find('.target_id').val(target_id);
                modal.find('.ids').val(ids);
                modal.find('.api').val(api);
            }
        });

        var confirmModal = $('#candConfirmModal');
        confirmModal.find('.modal_hide').click(function(){
            confirmModal.modal('hide');
            confirmModal.find('.modal_content').text('Please select porpositions.');
        });

        table.$('.previewCandidateModal').click(function(){
            var cand_id = $(this).data('id');
            var modal = $('#previewCandidateModal');

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneCand',
                type: 'post',
                data: {
                    candidate_id : cand_id
                },
                success: function(response) {
                    var cand = JSON.parse(response);

                    modal.find('#prev_candidate_name').val(cand.data[0].candidate_name);

                    if(cand.data[0].photo == null) {
                        modal.find('#prev_cand_photo').text("");
                    } else {
                        modal.find('#prev_cand_photo').attr("src", ""+cand.data[0].photo);
                    }

                    if(cand.data[0].party_logo == null) {
                        modal.find('#prev_party_logo').text("");
                    } else {
                        modal.find('#prev_party_logo').attr("src", ""+cand.data[0].party_logo);
                    }

                    modal.find('#email').val(cand.data[0].email);
                    modal.find('#party_id').val(cand.data[0].party_id);
                }
            });

            modal.modal('show');
        });

        $('.del_photo').change(function () {
            var checked = jQuery(this).is(":checked");
            console.log(checked);
            $('#editCandidateModal #edit_del_photo').val(checked);
         });

        table.$('.editCandidateModal').click(function(){
            var ballot_id = $('#cand_ballot_name').val();
            var race_id = $('#cand_race_name').val();
            var cand_id = $(this).data('id');
            var lang_id = $('#cand_lang_name').val();
            var modal = $('#editCandidateModal');

            modal.find('#ballot_id').val(ballot_id);
            modal.find('#edit_cand_id').val(cand_id);
            modal.find('#edit_lang_id').val(lang_id);
            modal.find('#race_id').val(race_id);

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneCand',
                type: 'post',
                data: {
                    candidate_id : cand_id
                },
                success: function(response) {
                    var cand = JSON.parse(response);

                    modal.find('#edit_candidate_name').val(cand.data[0].candidate_name);
                    modal.find('#edit_cand_photo').val(cand.data[0].photo);
                    modal.find('#edit_email').val(cand.data[0].email);
                    modal.find('#edit_party_id').val(cand.data[0].party_id);
                }
            });

            modal.modal('show');
        });

        table.$('.deleteCandidateModal').click(function(){
            var ballot_id = $('#cand_ballot_name').val();
            var target_id= 'candidate_id';
            var race_id = $('#cand_race_name').val();

            var id = $(this).data('id');
            var api = api_url+'/candidate/delete';

            var modal = $('#deleteCandidateModal');
            modal.find('#race_id').val(race_id);
            modal.find('#ballot_id').val(ballot_id);
            modal.find('.id').val(id);
            modal.find('.target_id').val(target_id);
            modal.find('.api').val(api);
            modal.modal('show');
        });

        $('#cand_ballot_name').change(function(){
            var ballot_id = $(this).val();
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: base_url+'/getCandRaces',
                type: 'POST',
                data: {
                    ballot_id : ballot_id
                },
                success:function(response){
                    var response = JSON.parse(response);
                    var races = response.races;

                    if($.isEmptyObject(races)){
                        var race_id = -1;
                    } else {
                        for (var x in races.data) {
                            var race_id = races.data[0]['race_id'];
                        }
                    }

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: base_url+'/getChangedCand',
                        type: 'POST',
                        data: {
                            ballot_id : ballot_id,
                            race_id : race_id
                        },
                        success:function(response){
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: base_url+'/getCandRaces',
                                type: 'POST',
                                data: {
                                    ballot_id : ballot_id
                                },
                                success:function(response){
                                    var response = JSON.parse(response);
                                    var races = response.races;
                                    var langs = response.langs;

                                    if($.isEmptyObject(races)){
                                        var race_options = "";
                                    } else {
                                        for (var x in races.data) {
                                            race_options += "<option value="+races.data[x]['race_id']+">"+races.data[x]['race_name']+"</opiton>";
                                        }
                                    }

                                    if($.isEmptyObject(langs)){
                                        var lang_options = "";
                                    } else {
                                        for (var x in langs.data) {
                                            lang_options += "<option value="+langs.data[x]['lang_id']+">"+langs.data[x]['language_name']+"</opiton>";
                                        }
                                    }

                                    $('#cand_race_name').html(race_options);
                                    $('#cand_lang_name').html(lang_options);
                                }
                            });

                            $('#addCandidateModal').remove();
                            $('#deleteCandidatesModal').remove();
                            $('#change_table').html(response);

                            var table = $('#candidate_table');

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
                                    "zeroRecords": "No matching records found"
                                },
                                "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                                
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
                                    'targets': [0]
                                }, {
                                    "searchable": false,
                                    "targets": [0]
                                }],
                                "order": [
                                    [1, "asc"]
                                ] // set first column as a default sort by asc
                            });

                            table.find('.group-checkable').change(function () {
                                var set = jQuery(this).attr("data-set");
                                var checked = jQuery(this).is(":checked");
                                jQuery(set).each(function () {
                                    if (checked) {
                                        $(this).attr("checked", true);
                                    } else {
                                        $(this).attr("checked", false);
                                    }
                                });
                                jQuery.uniform.update(set);
                            });

                            table.find('.checkboxes').change(function(){
                                var checked = $(this).is(":checked");
                                if (checked) {
                                    $(this).attr("checked", true);
                                } else {
                                    $(this).attr("checked", false);
                                }
                            });

                            $('.del_photo').change(function () {
                                var checked = jQuery(this).is(":checked");
                                console.log(checked);
                                $('#editCandidateModal #edit_del_photo').val(checked);
                            });

                            $('.addCandidateModal').click(function(){
                                var ballot_id = $('#cand_ballot_name').val();
                                var race_id = $('#cand_race_name').val();
                                var lang_id = $('#cand_lang_name').val();
                                var party_id = $('#add_cand_party').val();
                                var confirmModal = $('#candConfirmModal');
                                var addModal = $('#addCandidateModal');
                    
                                addModal.find('#ballot_id').val(ballot_id);
                                addModal.find('#race_id').val(race_id);
                                addModal.find('#lang_id').val(lang_id);
                                
                                if(ballot_id == null) {
                                    confirmModal.find('.modal_content').text("There aren't any ballots. Please make the ballot, first.");
                                    confirmModal.modal('show');
                                } else if(race_id == null) {
                                    confirmModal.find('.modal_content').text("There aren't any races in this ballot. Please make the race, first.");
                                    confirmModal.modal('show');
                                } else if(party_id == null) {
                                    confirmModal.find('.modal_content').text("There aren't any parties in this ballot. Please make the party, first.");
                                    confirmModal.modal('show');
                                } else if(lang_id == null) {
                                    confirmModal.find('.modal_content').text("There aren't any languages in this ballot. Please make the language, first.");
                                    confirmModal.modal('show');
                                } else {
                                    addModal.modal('show');
                                }
                            });

                            $(document).on('click', '.deleteCandidatesModal', function(){
                                var modal = $('#deleteCandidatesModal');
                                var allVals = [];
                                var ballot_id = $('#cand_ballot_name').val();
                                var race_id = $('#cand_race_name').val();
                                modal.find('#ballot_id').val(ballot_id);
                                modal.find('#race_id').val(race_id);
                    
                                table.find(".checkboxes:checked").each(function() {  
                                    allVals.push($(this).attr('data-id'));
                                });
                    
                                if(allVals.length <= 0) {
                                    var confrim = $('#candConfirmModal');
                                    confrim.modal('show');
                                } else {
                                    modal.modal('show');
                                    var target_id = 'candidate_id';
                                    var ids = allVals.join(",");
                                    var api = api_url+'/candidate/delete';
                    
                                    modal.find('.target_id').val(target_id);
                                    modal.find('.ids').val(ids);
                                    modal.find('.api').val(api);
                                }
                            });
                    
                            var confirmModal = $('#candConfirmModal');
                            confirmModal.find('.modal_hide').click(function(){
                                confirmModal.modal('hide');
                                confirmModal.find('.modal_content').text('Please select porpositions.');
                            });
                    
                            table.$('.previewCandidateModal').click(function(){
                                var cand_id = $(this).data('id');
                                var modal = $('#previewCandidateModal');
                    
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: base_url+'/getOneCand',
                                    type: 'post',
                                    data: {
                                        candidate_id : cand_id
                                    },
                                    success: function(response) {
                                        var cand = JSON.parse(response);
                    
                                        modal.find('#prev_candidate_name').val(cand.data[0].candidate_name);
                    
                                        if(cand.data[0].photo == null) {
                                            modal.find('#prev_cand_photo').text("");
                                        } else {
                                            modal.find('#prev_cand_photo').attr("src", ""+cand.data[0].photo);
                                        }
                    
                                        if(cand.data[0].party_logo == null) {
                                            modal.find('#prev_party_logo').text("");
                                        } else {
                                            modal.find('#prev_party_logo').attr("src", ""+cand.data[0].party_logo);
                                        }
                    
                                        modal.find('#email').val(cand.data[0].email);
                                        modal.find('#party_id').val(cand.data[0].party_id);
                                    }
                                });
                    
                                modal.modal('show');
                            });
                    
                            $('.del_photo').change(function () {
                                var checked = jQuery(this).is(":checked");
                                console.log(checked);
                                $('#editCandidateModal #edit_del_photo').val(checked);
                            });
                    
                            table.$('.editCandidateModal').click(function(){
                                var ballot_id = $('#cand_ballot_name').val();
                                var race_id = $('#cand_race_name').val();
                                var cand_id = $(this).data('id');
                                var lang_id = $('#cand_lang_name').val();
                                var modal = $('#editCandidateModal');
                    
                                modal.find('#ballot_id').val(ballot_id);
                                modal.find('#edit_cand_id').val(cand_id);
                                modal.find('#edit_lang_id').val(lang_id);
                                modal.find('#race_id').val(race_id);
                    
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: base_url+'/getOneCand',
                                    type: 'post',
                                    data: {
                                        candidate_id : cand_id
                                    },
                                    success: function(response) {
                                        var cand = JSON.parse(response);
                    
                                        modal.find('#edit_candidate_name').val(cand.data[0].candidate_name);
                                        modal.find('#edit_cand_photo').val(cand.data[0].photo);
                                        modal.find('#edit_email').val(cand.data[0].email);
                                        modal.find('#edit_party_id').val(cand.data[0].party_id);
                                    }
                                });
                    
                                modal.modal('show');
                            });
                    
                            table.$('.deleteCandidateModal').click(function(){
                                var ballot_id = $('#cand_ballot_name').val();
                                var target_id= 'candidate_id';
                                var race_id = $('#cand_race_name').val();
                    
                                var id = $(this).data('id');
                                var api = api_url+'/candidate/delete';
                    
                                var modal = $('#deleteCandidateModal');
                                modal.find('#race_id').val(race_id);
                                modal.find('#ballot_id').val(ballot_id);
                                modal.find('.id').val(id);
                                modal.find('.target_id').val(target_id);
                                modal.find('.api').val(api);
                                modal.modal('show');
                            });
                        }
                    });
                }
            });
        });

        $('#cand_race_name').change(function(){
            var ballot_id = $('#cand_ballot_name').val();
            var race_id = $(this).val();
            console.log(race_id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: base_url+'/getChangedCand1',
                type: 'POST',
                data: {
                    ballot_id : ballot_id,
                    race_id : race_id
                },
                success:function(response){

                    $('#addCandidateModal').remove();
                    $('#deleteCandidatesModal').remove();
                    $('#candConfirmModal').remove();
                    $('#change_table').html(response);

                    var table = $('#candidate_table');

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
                            "zeroRecords": "No matching records found"
                        },
                        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                        
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
                            'targets': [0]
                        }, {
                            "searchable": false,
                            "targets": [0]
                        }],
                        "order": [
                            [1, "asc"]
                        ] // set first column as a default sort by asc
                    });

                    table.find('.group-checkable').change(function () {
                        var set = jQuery(this).attr("data-set");
                        var checked = jQuery(this).is(":checked");
                        jQuery(set).each(function () {
                            if (checked) {
                                $(this).attr("checked", true);
                            } else {
                                $(this).attr("checked", false);
                            }
                        });
                        jQuery.uniform.update(set);
                    });

                    table.find('.checkboxes').change(function(){
                        var checked = $(this).is(":checked");
                        if (checked) {
                            $(this).attr("checked", true);
                        } else {
                            $(this).attr("checked", false);
                        }
                    });

                    $('.del_photo').change(function () {
                        var checked = jQuery(this).is(":checked");
                        console.log(checked);
                        $('#editCandidateModal #edit_del_photo').val(checked);
                     });

                    $('.addCandidateModal').click(function(){
                        var ballot_id = $('#cand_ballot_name').val();
                        var race_id = $('#cand_race_name').val();
                        var lang_id = $('#cand_lang_name').val();
                        var party_id = $('#add_cand_party').val();
                        var confirmModal = $('#candConfirmModal');
                        var addModal = $('#addCandidateModal');

                        addModal.find('#ballot_id').val(ballot_id);
                        addModal.find('#race_id').val(race_id);
                        addModal.find('#lang_id').val(lang_id);
                        
                        if(ballot_id < 0) {
                            confirmModal.find('.modal_content').text("There aren't any ballots. Please make the ballot, first.");
                            confirmModal.modal('show');
                        } else if(race_id < 0) {
                            confirmModal.find('.modal_content').text("There aren't any races in this ballot. Please make the race, first.");
                            confirmModal.modal('show');
                        } else if(party_id < 0) {
                            confirmModal.find('.modal_content').text("There aren't any parties in this ballot. Please make the party, first.");
                            confirmModal.modal('show');
                        } else {
                            addModal.modal('show');
                        }
                    });

                    $(document).on('click', '.deleteCandidatesModal', function(){
                        var modal = $('#deleteCandidatesModal');
                        var allVals = [];
                        var ballot_id = $('#cand_ballot_name').val();
                        var race_id = $('#cand_race_name').val();
                        modal.find('#ballot_id').val(ballot_id);
                        modal.find('#race_id').val(race_id);
            
                        table.find(".checkboxes:checked").each(function() {  
                            allVals.push($(this).attr('data-id'));
                        });
            
                        if(allVals.length <= 0) {
                            var confrim = $('#candConfirmModal');
                            confrim.modal('show');
                        } else {
                            modal.modal('show');
                            var target_id = 'candidate_id';
                            var ids = allVals.join(",");
                            var api = api_url+'/candidate/delete';
            
                            modal.find('.target_id').val(target_id);
                            modal.find('.ids').val(ids);
                            modal.find('.api').val(api);
                        }
                    });
            
                    var confirmModal = $('#candConfirmModal');
                    confirmModal.find('.modal_hide').click(function(){
                        confirmModal.modal('hide');
                        confirmModal.find('.modal_content').text('Please select porpositions.');
                    });
            
                    table.$('.previewCandidateModal').click(function(){
                        var cand_id = $(this).data('id');
                        var modal = $('#previewCandidateModal');
            
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/getOneCand',
                            type: 'post',
                            data: {
                                candidate_id : cand_id
                            },
                            success: function(response) {
                                var cand = JSON.parse(response);
            
                                modal.find('#prev_candidate_name').val(cand.data[0].candidate_name);
            
                                if(cand.data[0].photo == null) {
                                    modal.find('#prev_cand_photo').text("");
                                } else {
                                    modal.find('#prev_cand_photo').attr("src", ""+cand.data[0].photo);
                                }
            
                                if(cand.data[0].party_logo == null) {
                                    modal.find('#prev_party_logo').text("");
                                } else {
                                    modal.find('#prev_party_logo').attr("src", ""+cand.data[0].party_logo);
                                }
            
                                modal.find('#email').val(cand.data[0].email);
                                modal.find('#party_id').val(cand.data[0].party_id);
                            }
                        });
            
                        modal.modal('show');
                    });
            
                    $('.del_photo').change(function () {
                        var checked = jQuery(this).is(":checked");
                        console.log(checked);
                        $('#editCandidateModal #edit_del_photo').val(checked);
                     });
            
                    table.$('.editCandidateModal').click(function(){
                        var ballot_id = $('#cand_ballot_name').val();
                        var race_id = $('#cand_race_name').val();
                        var cand_id = $(this).data('id');
                        var lang_id = $('#cand_lang_name').val();
                        var modal = $('#editCandidateModal');
            
                        modal.find('#ballot_id').val(ballot_id);
                        modal.find('#edit_cand_id').val(cand_id);
                        modal.find('#edit_lang_id').val(lang_id);
                        modal.find('#race_id').val(race_id);
            
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/getOneCand',
                            type: 'post',
                            data: {
                                candidate_id : cand_id
                            },
                            success: function(response) {
                                var cand = JSON.parse(response);
            
                                modal.find('#edit_candidate_name').val(cand.data[0].candidate_name);
                                modal.find('#edit_cand_photo').val(cand.data[0].photo);
                                modal.find('#edit_email').val(cand.data[0].email);
                                modal.find('#edit_party_id').val(cand.data[0].party_id);
                            }
                        });
            
                        modal.modal('show');
                    });
            
                    table.$('.deleteCandidateModal').click(function(){
                        var ballot_id = $('#cand_ballot_name').val();
                        var target_id= 'candidate_id';
                        var race_id = $('#cand_race_name').val();
            
                        var id = $(this).data('id');
                        var api = api_url+'/candidate/delete';
            
                        var modal = $('#deleteCandidateModal');
                        modal.find('#race_id').val(race_id);
                        modal.find('#ballot_id').val(ballot_id);
                        modal.find('.id').val(id);
                        modal.find('.target_id').val(target_id);
                        modal.find('.api').val(api);
                        modal.modal('show');
                    });
                }
            });
        });
    }

    var languageTable = function () {
        var list = $("#lang_list");

        $('.lang_check').change(function() {
            var checked = $(this).is(":checked");
            var ballot_id = $('#ballot_lang_option').val();

            if (checked) {
                $(this).attr("checked", true);
                var avaliable = "true";
                var lang_id = $(this).data('id');
            } else {
                $(this).attr("checked", false);
                var avaliable = "false";
                var lang_id = $(this).data('id');
            }
           
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/setAvalBallotLang',
                type: 'post',
                data: {
                    ballot_id : ballot_id,
                    lang_id : lang_id,
                    avaliable : avaliable
                },
                success: function(response) {
                    var response = JSON.parse(response);
                    if(response.state == 'success'){
                        if(response.message == "0") {
                            toastr['warning']('Warning! This language have already deleted.');    
                        } else {
                            if(avaliable == 'true') {
                                toastr['success']('Success! Add is successfully.');
                            } else if(avaliable == 'false'){
                                toastr['info']('Success! Deleted is successfully.');
                            }
                        }
                    } else {
                        toastr['warning']('Warning! This language have already added.');
                    }
                }
            });
        });

        $('.select_all_ballot_lang').change(function () {
            $('.save_all_ballot_lang').removeClass("disabled");
            $('.save_all_ballot_lang_').removeClass("disabled");
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });
        
        $(document).on('click', '.save_all_ballot_lang', function(){
            var allVals = [];
            $('.save_all_ballot_lang').addClass("disabled");
            list.find(".lang_check:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });
            
            var ids = allVals.join(",");
            var ballot_id = $('#ballot_lang_option').val();

            var checkedAll = $('.select_all_ballot_lang').is(":checked");
            if (checkedAll) {
                $(this).attr("checked", true);
                var avaliable = "true";
            } else {
                $(this).attr("checked", false);
                var avaliable = "false";
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/saveAllLang',
                type: 'post',
                data: {
                    ballot_id : ballot_id,
                    ids : ids,
                    avaliable : avaliable
                },
                success: function(response) {
                    $('.save_all_ballot_lang').removeClass("disabled");
                    var response = JSON.parse(response);
                    if(response.state == 'success'){
                        if(response.message == "-1") {
                            toastr['warning']('Have already deleted all.');
                        } else if(response.message == "1") {
                            toastr['info']('All languages is deleted in this ballot successfully.');
                        } else if(response.message == "-2") {
                            toastr['warning']('Have already added all.');
                        } else {
                            toastr['success']('All languages is added in this ballot successfully.');
                        }
                    } else {
                        toastr['error']('Whoops! Something went wrong.');
                    }
                }
            });
        });

        $('#ballot_lang_option').change(function(){
            $('.save_all_ballot_lang').remove();
            $('.save_all_ballot_lang_').show();
            var ballot_id = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: base_url+'/getChangedLangs',
                type: 'POST',
                data: {
                    ballot_id : ballot_id
                },
                success:function(response){
                    $('#change_table').html(response);
                    
                    $('.lang_check').change(function() {
                        var checked = $(this).is(":checked");
                        var ballot_id = $('#ballot_lang_option').val();

                        if (checked) {
                            $(this).attr("checked", true);
                            var avaliable = "true";
                            var lang_id = $(this).data('id');
                        } else {
                            $(this).attr("checked", false);
                            var avaliable = "false";
                            var lang_id = $(this).data('id');
                        }
                    
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/setAvalBallotLang',
                            type: 'post',
                            data: {
                                ballot_id : ballot_id,
                                lang_id : lang_id,
                                avaliable : avaliable
                            },
                            success: function(response) {
                                var response = JSON.parse(response);
                                if(response.state == 'success'){
                                    if(response.message == "0") {
                                        toastr['warning']('Warning! This language have already deleted.');    
                                    } else {
                                        if(avaliable == 'true') {
                                            toastr['success']('Success! Add is successfully.');
                                        } else if(avaliable == 'false'){
                                            toastr['info']('Success! Deleted is successfully.');
                                        }
                                    }
                                } else {
                                    toastr['warning']('Warning! This language have already added.');
                                }
                            }
                        });
                    });
        
                    $(document).on('click', '.save_all_ballot_lang_', function(){
                        var allVals = [];
                        $('.save_all_ballot_lang').addClass("disabled");
                        list.find(".lang_check:checked").each(function() {  
                            allVals.push($(this).attr('data-id'));
                        });
                        
                        var ids = allVals.join(",");
                        var ballot_id = $('#ballot_lang_option').val();
            
                        var checkedAll = $('.select_all_ballot_lang').is(":checked");
                        if (checkedAll) {
                            $(this).attr("checked", true);
                            var avaliable = "true";
                        } else {
                            $(this).attr("checked", false);
                            var avaliable = "false";
                        }
            
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/saveAllLang',
                            type: 'post',
                            data: {
                                ballot_id : ballot_id,
                                ids : ids,
                                avaliable : avaliable
                            },
                            success: function(response) {
                                $('.save_all_ballot_lang').removeClass("disabled");
                                var response = JSON.parse(response);
                                if(response.state == 'success'){
                                    if(response.message == "-1") {
                                        toastr['warning']('Have already deleted all.');
                                    } else if(response.message == "1") {
                                        toastr['info']('All languages is deleted in this ballot successfully.');
                                    } else if(response.message == "-2") {
                                        toastr['warning']('Have already added all.');
                                    } else {
                                        toastr['success']('All languages is added in this ballot successfully.');
                                    }
                                } else {
                                    toastr['error']('Whoops! Something went wrong.');
                                }
                            }
                        });
                    });
                }
            });
        });
    }    
    
    var countyTable = function () {
        var list = $("#county_list");

        $('.county_check').change(function() {
            var checked = $(this).is(":checked");
            var ballot_id = $('#county_ballot_option').val();
            var state_id = $('#county_state_option').val();

            if (checked) {
                $(this).attr("checked", true);
                var avaliable = "true";
                var county_id = $(this).parents('.change_aval_county').data('id');
            } else {
                $(this).attr("checked", false);
                var avaliable = "false";
                var county_id = $(this).parents('.change_aval_county').data('id');
            }
           
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/setAvalBallotCounty',
                type: 'post',
                data: {
                    ballot_id : ballot_id,
                    state_id : state_id,
                    county_id : county_id,
                    avaliable : avaliable
                },
                success: function(response) {
                    var response = JSON.parse(response);
                    if(response.state == 'success'){
                        if(response.message == "0") {
                            toastr['warning']('Warning! This county have already deleted.');    
                        } else {
                            if(avaliable == 'true') {
                                toastr['success']('Success! Add is successfully.');
                            } else if(avaliable == 'false'){
                                toastr['info']('Success! Deleted is successfully.');
                            }
                        }
                    } else {
                        toastr['warning']('Warning! This county have already added.');
                    }
                }
            });
        });

        $('.select_all_ballot_county').change(function () {
            $('.save_all_ballot_county').removeClass("disabled");
            $('.save_all_ballot_county_').removeClass("disabled");
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });
        
        $(document).on('click', '.save_all_ballot_county', function(){
            var allVals = [];
            $('.save_all_ballot_county').addClass("disabled");
            list.find(".county_check:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });
            
            var ids = allVals.join(",");
            var ballot_id = $('#county_ballot_option').val();
            var state_id = $('#county_state_option').val();

            var checkedAll = $('.select_all_ballot_county').is(":checked");
            if (checkedAll) {
                $(this).attr("checked", true);
                var avaliable = "true";
            } else {
                $(this).attr("checked", false);
                var avaliable = "false";
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/saveAllCounty',
                type: 'post',
                data: {
                    ballot_id : ballot_id,
                    state_id : state_id,
                    ids : ids,
                    avaliable : avaliable
                },
                success: function(response) {
                    $('.save_all_ballot_county').removeClass("disabled");
                    var response = JSON.parse(response);
                    if(response.state == 'success'){
                        if(response.message == "-1") {
                            toastr['warning']('Have already deleted all.');
                        } else if(response.message == "1") {
                            toastr['info']('All counties is deleted in this ballot successfully.');
                        } else if(response.message == "-2") {
                            toastr['warning']('Have already added all.');
                        } else {
                            toastr['success']('All counties is added in this ballot successfully.');
                        }
                    } else {
                        toastr['error']('Whoops! Something went wrong.');
                    }
                }
            });
        });
        
        $('#county_ballot_option').on('change', function(){
            var ballot_id = $('#county_ballot_option').val();
            var state_id = $('#county_state_option').val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getChangedCountyOfBallot',
                type: 'POST',
                data: {
                    ballot_id : ballot_id,
                    state_id : state_id
                },
                success:function(response){
                    $('#change_table').html(response);
                    
                    $('.county_check').change(function() {
                        var checked = $(this).is(":checked");
                        var ballot_id = $('#county_ballot_option').val();
                        var state_id = $('#county_state_option').val();
            
                        if (checked) {
                            $(this).attr("checked", true);
                            var avaliable = "true";
                            var county_id = $(this).parents('.change_aval_county').data('id');
                        } else {
                            $(this).attr("checked", false);
                            var avaliable = "false";
                            var county_id = $(this).parents('.change_aval_county').data('id');
                        }
                       
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/setAvalBallotCounty',
                            type: 'post',
                            data: {
                                ballot_id : ballot_id,
                                state_id : state_id,
                                county_id : county_id,
                                avaliable : avaliable
                            },
                            success: function(response) {
                                var response = JSON.parse(response);
                                if(response.state == 'success'){
                                    if(response.message == "0") {
                                        toastr['warning']('Warning! This county have already deleted.');    
                                    } else {
                                        if(avaliable == 'true') {
                                            toastr['success']('Success! Add is successfully.');
                                        } else if(avaliable == 'false'){
                                            toastr['info']('Success! Deleted is successfully.');
                                        }
                                    }
                                } else {
                                    toastr['warning']('Warning! This county have already added.');
                                }
                            }
                        });
                    });
                }
            });
        });
        
        $('#county_state_option').on('change', function(){
            $('.save_all_ballot_county').remove();
            $('.save_all_ballot_county_').show();
            var ballot_id = $('#county_ballot_option').val();
            var state_id = $('#county_state_option').val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getChangedCountyOfBallot',
                type: 'POST',
                data: {
                    ballot_id : ballot_id,
                    state_id : state_id
                },
                success:function(response){
                    $('#change_table').html(response);
                    
                    var list = $("#county_list");
                    $('.county_check').change(function() {
                        var checked = $(this).is(":checked");
                        var ballot_id = $('#county_ballot_option').val();
                        var state_id = $('#county_state_option').val();
            
                        if (checked) {
                            $(this).attr("checked", true);
                            var avaliable = "true";
                            var county_id = $(this).parents('.change_aval_county').data('id');
                        } else {
                            $(this).attr("checked", false);
                            var avaliable = "false";
                            var county_id = $(this).parents('.change_aval_county').data('id');
                        }
                       
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/setAvalBallotCounty',
                            type: 'post',
                            data: {
                                ballot_id : ballot_id,
                                state_id : state_id,
                                county_id : county_id,
                                avaliable : avaliable
                            },
                            success: function(response) {
                                var response = JSON.parse(response);
                                if(response.state == 'success'){
                                    if(response.message == "0") {
                                        toastr['warning']('Warning! This county have already deleted.');    
                                    } else {
                                        if(avaliable == 'true') {
                                            toastr['success']('Success! Add is successfully.');
                                        } else if(avaliable == 'false'){
                                            toastr['info']('Success! Deleted is successfully.');
                                        }
                                    }
                                } else {
                                    toastr['warning']('Warning! This county have already added.');
                                }
                            }
                        });
                    });
        
                    $(document).on('click', '.save_all_ballot_county_', function(){
                        var allVals = [];
                        $('.save_all_ballot_county_').addClass("disabled");
                        list.find(".county_check:checked").each(function() {  
                            allVals.push($(this).attr('data-id'));
                        });
                        
                        var ids = allVals.join(",");
                        var ballot_id = $('#county_ballot_option').val();
                        var state_id = $('#county_state_option').val();
            
                        var checkedAll = $('.select_all_ballot_county').is(":checked");
                        if (checkedAll) {
                            $(this).attr("checked", true);
                            var avaliable = "true";
                        } else {
                            $(this).attr("checked", false);
                            var avaliable = "false";
                        }
            
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/saveAllCounty',
                            type: 'post',
                            data: {
                                ballot_id : ballot_id,
                                state_id : state_id,
                                ids : ids,
                                avaliable : avaliable
                            },
                            success: function(response) {
                                $('.save_all_ballot_county_').removeClass("disabled");
                                var response = JSON.parse(response);
                                if(response.state == 'success'){
                                    if(response.message == "-1") {
                                        toastr['warning']('Have already deleted all.');
                                    } else if(response.message == "1") {
                                        toastr['info']('All counties is deleted in this ballot successfully.');
                                    } else if(response.message == "-2") {
                                        toastr['warning']('Have already added all.');
                                    } else {
                                        toastr['success']('All counties is added in this ballot successfully.');
                                    }
                                } else {
                                    toastr['error']('Whoops! Something went wrong.');
                                }
                            }
                        });
                    });
                }
            });
        });
    }  
    
    var propositionTable = function () {
        var table = $('#change_table #proposition_table');
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
                "zeroRecords": "No matching records found"
            },
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            
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
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        table.find('.checkboxes').change(function(){
            var checked = $(this).is(":checked");
            if (checked) {
                $(this).attr("checked", true);
            } else {
                $(this).attr("checked", false);
            }
        });

        $('.addPropositionModal').click(function() {
            var ballot_id = $('#prop_ballot_name').val();

            if(ballot_id == -1) {
                var modal = $('#confirmModal');
                modal.find('.modal_content').text("Please make ballot, first.");
                modal.modal('show');
            } else {
                var modal = $('#addPropositionModal');
                modal.find('#ballot_id').val(ballot_id);
                modal.modal('show');
            }
        });

        table.$('.previewPropositionModal').click(function(){
            var prop_id = $(this).data('id');
            var modal = $('#previewPropositionModal');

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneProp',
                type: 'post',
                data: {
                    prop_id : prop_id
                },
                success: function(response) {
                    var prop = JSON.parse(response);

                    modal.find('#prev_prop_name').val(prop.data[0].prop_name);
                    modal.find('#prev_prop_lang_id').val(prop.data[0].prop_lang_id);
                    modal.find('#prev_prop_answer_type').val(prop.data[0].prop_answer_type);
                    modal.find('#prev_prop_location_id').val(prop.data[0].prop_location_id);
                    modal.find('#prev_prop_title').val(prop.data[0].prop_title);
                    modal.find('#prev_prop_text').val(prop.data[0].prop_text);
                }
            });

            modal.modal('show');
        });

        table.$('.editPropositionModal').click(function(){
            var prop_id = $(this).data('id');
            var modal = $('#editPropositionModal');

            var ballot_id = $('#prop_ballot_name').val();
            modal.find('#ballot_id').val(ballot_id);

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneProp',
                type: 'post',
                data: {
                    prop_id : prop_id,
                },
                success: function(response) {
                    var prop = JSON.parse(response);

                    modal.find('#edit_prop_id').val(prop_id);
                    modal.find('#edit_prop_name').val(prop.data[0].prop_name);
                    modal.find('#edit_prop_lang_id').val(prop.data[0].prop_lang_id);
                    modal.find('#edit_prop_answer_type').val(prop.data[0].prop_answer_type);
                    modal.find('#edit_prop_location_id').val(prop.data[0].prop_location_id);
                    modal.find('#edit_prop_title').val(prop.data[0].prop_title);
                    modal.find('#edit_prop_text').val(prop.data[0].prop_text);
                }
            });

            modal.modal('show');
        });

        table.$('.deletePropositionModal').click(function(){
            var target_id= 'proposition_id';
            var id = $(this).data('id');
            var api = api_url+'/proposition/delete';

            var modal = $('#deletePropositionModal');

            var ballot_id = $('#prop_ballot_name').val();
            modal.find('#ballot_id').val(ballot_id);

            modal.find('.id').val(id);
            modal.find('.target_id').val(target_id);
            modal.find('.api').val(api);
            modal.modal('show');
        });

        $(document).on('click', '.deletePropositionsModal', function(){
            var modal = $('#deletePropositionsModal');
            var allVals = [];

            var ballot_id = $('#prop_ballot_name').val();
            modal.find('#ballot_id').val(ballot_id);

            table.find(".checkboxes:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });

            if(allVals.length <= 0) {
                var confrim = $('#confirmModal');
                confrim.modal('show');
            } else {
                modal.modal('show');
                var target_id = 'proposition_id';
                var ids = allVals.join(",");
                var api = api_url+'/proposition/delete';

                modal.find('.target_id').val(target_id);
                modal.find('.ids').val(ids);
                modal.find('.api').val(api);
            }
        });

        $('#prop_ballot_name').on('change', function(){
            var ballot_id = $(this).val();
        
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: base_url+'/getChangedProps',
                type: 'POST',
                data: {
                    ballot_id : ballot_id,
                    prop_type : 'P'
                },
                success:function(response){
                    $('#addPropositionModal').remove();
                    $('#deletePropositionsModal').remove();
                    $('#confirmModal').remove();
                    $('#change_table').html(response);
    
                    var table = $('#change_table #proposition_table');
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
                            "zeroRecords": "No matching records found"
                        },
                        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                        
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
                            'targets': [0]
                        }, {
                            "searchable": false,
                            "targets": [0]
                        }],
                        "order": [
                            [1, "asc"]
                        ] // set first column as a default sort by asc
                    });

                    table.find('.group-checkable').change(function () {
                        var set = jQuery(this).attr("data-set");
                        var checked = jQuery(this).is(":checked");
                        jQuery(set).each(function () {
                            if (checked) {
                                $(this).attr("checked", true);
                            } else {
                                $(this).attr("checked", false);
                            }
                        });
                        jQuery.uniform.update(set);
                    });

                    table.find('.checkboxes').change(function(){
                        var checked = $(this).is(":checked");
                        if (checked) {
                            $(this).attr("checked", true);
                        } else {
                            $(this).attr("checked", false);
                        }
                    });

                    $('.addPropositionModal').click(function() {
                        var ballot_id = $('#prop_ballot_name').val();

                        if(ballot_id == -1) {
                            var modal = $('#confirmModal');
                            modal.find('.modal_content').text("Please make ballot, first.");
                            modal.modal('show');
                        } else {
                            var modal = $('#addPropositionModal');
                            modal.find('#ballot_id').val(ballot_id);
                            modal.modal('show');
                        }
                    });

                    table.$('.previewPropositionModal').click(function(){
                        var prop_id = $(this).data('id');
                        var modal = $('#previewPropositionModal');

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/getOneProp',
                            type: 'post',
                            data: {
                                prop_id : prop_id
                            },
                            success: function(response) {
                                var prop = JSON.parse(response);

                                modal.find('#prev_prop_name').val(prop.data[0].prop_name);
                                modal.find('#prev_prop_lang_id').val(prop.data[0].prop_lang_id);
                                modal.find('#prev_prop_answer_type').val(prop.data[0].prop_answer_type);
                                modal.find('#prev_prop_location_id').val(prop.data[0].prop_location_id);
                                modal.find('#prev_prop_title').val(prop.data[0].prop_title);
                                modal.find('#prev_prop_text').val(prop.data[0].prop_text);
                            }
                        });

                        modal.modal('show');
                    });

                    table.$('.editPropositionModal').click(function(){
                        var prop_id = $(this).data('id');
                        var modal = $('#editPropositionModal');
            
                        var ballot_id = $('#prop_ballot_name').val();
                        modal.find('#ballot_id').val(ballot_id);
            
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/getOneProp',
                            type: 'post',
                            data: {
                                prop_id : prop_id,
                            },
                            success: function(response) {
                                var prop = JSON.parse(response);
            
                                modal.find('#edit_prop_id').val(prop_id);
                                modal.find('#edit_prop_name').val(prop.data[0].prop_name);
                                modal.find('#edit_prop_lang_id').val(prop.data[0].prop_lang_id);
                                modal.find('#edit_prop_answer_type').val(prop.data[0].prop_answer_type);
                                modal.find('#edit_prop_location_id').val(prop.data[0].prop_location_id);
                                modal.find('#edit_prop_title').val(prop.data[0].prop_title);
                                modal.find('#edit_prop_text').val(prop.data[0].prop_text);
                            }
                        });
            
                        modal.modal('show');
                    });
            
                    table.$('.deletePropositionModal').click(function(){
                        var target_id= 'proposition_id';
                        var id = $(this).data('id');
                        var api = api_url+'/proposition/delete';
            
                        var modal = $('#deletePropositionModal');
            
                        var ballot_id = $('#prop_ballot_name').val();
                        modal.find('#ballot_id').val(ballot_id);
            
                        modal.find('.id').val(id);
                        modal.find('.target_id').val(target_id);
                        modal.find('.api').val(api);
                        modal.modal('show');
                    });
            
                    $(document).on('click', '.deletePropositionsModal', function(){
                        var modal = $('#deletePropositionsModal');
                        var allVals = [];
            
                        var ballot_id = $('#prop_ballot_name').val();
                        modal.find('#ballot_id').val(ballot_id);
            
                        table.find(".checkboxes:checked").each(function() {  
                            allVals.push($(this).attr('data-id'));
                        });
            
                        if(allVals.length <= 0) {
                            var confrim = $('#confirmModal');
                            confrim.modal('show');
                        } else {
                            modal.modal('show');
                            var target_id = 'proposition_id';
                            var ids = allVals.join(",");
                            var api = api_url+'/proposition/delete';
            
                            modal.find('.target_id').val(target_id);
                            modal.find('.ids').val(ids);
                            modal.find('.api').val(api);
                        }
                    });
                }
            });
        });
    }
    
    var massPropositionTable = function () {
        var table = $('#change_table #mass_proposition_table');
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
                "zeroRecords": "No matching records found"
            },
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            
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
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        table.find('.checkboxes').change(function(){
            var checked = $(this).is(":checked");
            if (checked) {
                $(this).attr("checked", true);
            } else {
                $(this).attr("checked", false);
            }
        });

        $('.addMassPropositionModal').click(function() {
            var ballot_id = $('#mass_prop_ballot_name').val();

            if(ballot_id == -1) {
                var modal = $('#confirmModal');
                modal.find('.modal_content').text("Please make ballot, first.");
                modal.modal('show');
            } else {
                var modal = $('#addMassPropositionModal');
                modal.find('#ballot_id').val(ballot_id);
                modal.modal('show');
            }
        });

        table.$('.previewMassPropositionModal').click(function(){
            var prop_id = $(this).data('id');
            var modal = $('#previewMassPropositionModal');

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneProp',
                type: 'post',
                data: {
                    prop_id : prop_id
                },
                success: function(response) {
                    var prop = JSON.parse(response);

                    modal.find('#prev_prop_name').val(prop.data[0].prop_name);
                    modal.find('#prev_prop_lang_id').val(prop.data[0].prop_lang_id);
                    modal.find('#prev_prop_answer_type').val(prop.data[0].prop_answer_type);
                    modal.find('#prev_prop_location_id').val(prop.data[0].prop_location_id);
                    modal.find('#prev_prop_title').val(prop.data[0].prop_title);
                    modal.find('#prev_prop_text').val(prop.data[0].prop_text);
                }
            });

            modal.modal('show');
        });

        table.$('.editMassPropositionModal').click(function(){
            var prop_id = $(this).data('id');
            var modal = $('#editMassPropositionModal');

            var ballot_id = $('#mass_prop_ballot_name').val();
            modal.find('#ballot_id').val(ballot_id);
            
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneProp',
                type: 'post',
                data: {
                    prop_id : prop_id,
                },
                success: function(response) {
                    var prop = JSON.parse(response);

                    modal.find('#edit_prop_id').val(prop_id);
                    modal.find('#edit_prop_name').val(prop.data[0].prop_name);
                    modal.find('#edit_prop_lang_id').val(prop.data[0].prop_lang_id);
                    modal.find('#edit_prop_answer_type').val(prop.data[0].prop_answer_type);
                    modal.find('#edit_prop_location_id').val(prop.data[0].prop_location_id);
                    modal.find('#edit_prop_title').val(prop.data[0].prop_title);
                    modal.find('#edit_prop_text').val(prop.data[0].prop_text);
                }
            });

            modal.modal('show');
        });

        table.$('.deleteMassPropositionModal').click(function(){
            var target_id= 'proposition_id';
            var id = $(this).data('id');
            var api = api_url+'/proposition/delete';

            var modal = $('#deleteMassPropositionModal');

            var ballot_id = $('#mass_prop_ballot_name').val();
            modal.find('#ballot_id').val(ballot_id);

            modal.find('.id').val(id);
            modal.find('.target_id').val(target_id);
            modal.find('.api').val(api);
            modal.modal('show');
        });

        $(document).on('click', '.deleteMassPropositionsModal', function(){
            var modal = $('#deleteMassPropositionsModal');
            var allVals = [];

            var ballot_id = $('#mass_prop_ballot_name').val();
            modal.find('#ballot_id').val(ballot_id);

            table.find(".checkboxes:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });

            if(allVals.length <= 0) {
                var confrim = $('#confirmModal');
                confrim.modal('show');
            } else {
                modal.modal('show');
                var target_id = 'proposition_id';
                var ids = allVals.join(",");
                var api = api_url+'/proposition/delete';

                modal.find('.target_id').val(target_id);
                modal.find('.ids').val(ids);
                modal.find('.api').val(api);
            }
        });

        $('#mass_prop_ballot_name').on('change', function(){
            var ballot_id = $(this).val();
        
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getChangedMassProps',
                type: 'POST',
                data: {
                    ballot_id : ballot_id,
                    prop_type : 'M'
                },
                success:function(response){
                    $('#addMassPropositionModal').remove();
                    $('#deleteMassPropositionsModal').remove();
                    $('#confirmModal').remove();
                    $('#change_table').html(response);
    
                    var table = $('#change_table #mass_proposition_table');
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
                            "zeroRecords": "No matching records found"
                        },
                        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                        
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
                            'targets': [0]
                        }, {
                            "searchable": false,
                            "targets": [0]
                        }],
                        "order": [
                            [1, "asc"]
                        ] // set first column as a default sort by asc
                    });

                    table.find('.group-checkable').change(function () {
                        var set = jQuery(this).attr("data-set");
                        var checked = jQuery(this).is(":checked");
                        jQuery(set).each(function () {
                            if (checked) {
                                $(this).attr("checked", true);
                            } else {
                                $(this).attr("checked", false);
                            }
                        });
                        jQuery.uniform.update(set);
                    });

                    table.find('.checkboxes').change(function(){
                        var checked = $(this).is(":checked");
                        if (checked) {
                            $(this).attr("checked", true);
                        } else {
                            $(this).attr("checked", false);
                        }
                    });

                    $('.addMassPropositionModal').click(function() {
                        var ballot_id = $('#mass_prop_ballot_name').val();

                        if(ballot_id == -1) {
                            var modal = $('#confirmModal');
                            modal.find('.modal_content').text("Please make ballot, first.");
                            modal.modal('show');
                        } else {
                            var modal = $('#addMassPropositionModal');
                            modal.find('#ballot_id').val(ballot_id);
                            modal.modal('show');
                        }
                    });

                    table.$('.previewMassPropositionModal').click(function(){
                        var prop_id = $(this).data('id');
                        var modal = $('#previewMassPropositionModal');

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/getOneProp',
                            type: 'post',
                            data: {
                                prop_id : prop_id
                            },
                            success: function(response) {
                                var prop = JSON.parse(response);

                                modal.find('#prev_prop_name').val(prop.data[0].prop_name);
                                modal.find('#prev_prop_lang_id').val(prop.data[0].prop_lang_id);
                                modal.find('#prev_prop_answer_type').val(prop.data[0].prop_answer_type);
                                modal.find('#prev_prop_location_id').val(prop.data[0].prop_location_id);
                                modal.find('#prev_prop_title').val(prop.data[0].prop_title);
                                modal.find('#prev_prop_text').val(prop.data[0].prop_text);
                            }
                        });

                        modal.modal('show');
                    });

                    table.$('.editMassPropositionModal').click(function(){
                        var prop_id = $(this).data('id');
                        var modal = $('#editMassPropositionModal');
            
                        var ballot_id = $('#mass_prop_ballot_name').val();
                        modal.find('#ballot_id').val(ballot_id);
                        
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/getOneProp',
                            type: 'post',
                            data: {
                                prop_id : prop_id,
                            },
                            success: function(response) {
                                var prop = JSON.parse(response);
            
                                modal.find('#edit_prop_id').val(prop_id);
                                modal.find('#edit_prop_name').val(prop.data[0].prop_name);
                                modal.find('#edit_prop_lang_id').val(prop.data[0].prop_lang_id);
                                modal.find('#edit_prop_answer_type').val(prop.data[0].prop_answer_type);
                                modal.find('#edit_prop_location_id').val(prop.data[0].prop_location_id);
                                modal.find('#edit_prop_title').val(prop.data[0].prop_title);
                                modal.find('#edit_prop_text').val(prop.data[0].prop_text);
                            }
                        });
            
                        modal.modal('show');
                    });
            
                    table.$('.deleteMassPropositionModal').click(function(){
                        var target_id= 'proposition_id';
                        var id = $(this).data('id');
                        var api = api_url+'/proposition/delete';
            
                        var modal = $('#deleteMassPropositionModal');
            
                        var ballot_id = $('#mass_prop_ballot_name').val();
                        modal.find('#ballot_id').val(ballot_id);
            
                        modal.find('.id').val(id);
                        modal.find('.target_id').val(target_id);
                        modal.find('.api').val(api);
                        modal.modal('show');
                    });
            
                    $(document).on('click', '.deleteMassPropositionsModal', function(){
                        var modal = $('#deleteMassPropositionsModal');
                        var allVals = [];
            
                        var ballot_id = $('#mass_prop_ballot_name').val();
                        modal.find('#ballot_id').val(ballot_id);
            
                        table.find(".checkboxes:checked").each(function() {  
                            allVals.push($(this).attr('data-id'));
                        });
            
                        if(allVals.length <= 0) {
                            var confrim = $('#confirmModal');
                            confrim.modal('show');
                        } else {
                            modal.modal('show');
                            var target_id = 'proposition_id';
                            var ids = allVals.join(",");
                            var api = api_url+'/proposition/delete';
            
                            modal.find('.target_id').val(target_id);
                            modal.find('.ids').val(ids);
                            modal.find('.api').val(api);
                        }
                    });
                }
            });
        });
    }

    var usersTable = function () {
        var table = $('#users_table');
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
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
                "zeroRecords": "No matching records found"
            },
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            
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
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        $(document).on('click', '.addUserModal', function(){
            var modal = $('#addUserModal');
            modal.modal('show');
        });  

        table.on('click', '.previewUserModal', function(){
            var modal = $('#previewUserModal');
            var user_id = $(this).data('id');

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneUser',
                type: 'post',
                data: {
                    user_id : user_id
                },
                success: function(response) {
                    var user = JSON.parse(response);
                    
                    $('#preview_user_name').val(user.data[0].user_name);
                    $('#preview_display_name').val(user.data[0].display_name);
                    $('#preview_user_email').val(user.data[0].user_email);
                    if(user.data[0].user_avatar == null){
                        $('#preview_user_avatar').text('');
                    } else{
                        $('#preview_user_avatar').attr("src", ""+user.data[0].user_avatar);
                    }
                }
            });

            modal.modal('show');
        });

        table.on('click', '.editUserModal', function(){
            var user_id = $(this).data('id');
            var modal = $('#editUserModal');
            modal.find(".user_id").val(user_id);

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneUser',
                type: 'post',
                data: {
                    user_id : user_id
                },
                success: function(response) {
                    var user = JSON.parse(response);

                    modal.find('#edit_user_name').val(user.data[0].user_name);
                    modal.find('#edit_display_name').val(user.data[0].display_name);
                    modal.find('#edit_user_email').val(user.data[0].user_email);
                    modal.find('#edit_user_avatar').attr("src", ""+user.data[0].user_avatar)
                }
            });

            modal.modal('show');
        });

        table.on('click', '.deleteUserModal', function(){
            $this = $(this);
            var target_id= 'user_id';
            var id= $(this).data('id');
            var api = api_url+'/user/delete';
            var modal = $('#deleteUserModal');

            modal.find('.id').val(id);
            modal.find('.target_id').val(target_id);
            modal.find('.api').val(api);
            modal.modal('show');
        });

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        table.find('.checkboxes').change(function(){
            var checked = $(this).is(":checked");
            if (checked) {
                $(this).attr("checked", true);
            } else {
                $(this).attr("checked", false);
            }
        });

        $(document).on('click', '.deleteUsersModal', function(){
            var modal = $('#deleteUsersModal');
            var allVals = [];

            table.find(".checkboxes:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });

            if(allVals.length <= 0) {
                var confrim = $('#confirmModal');
                confrim.modal('show');
            } else {
                modal.modal('show');
                var target_id = 'user_id';
                var ids = allVals.join(",");
                var api = api_url+'/user/delete';

                modal.find('.target_id').val(target_id);
                modal.find('.ids').val(ids);
                modal.find('.api').val(api);
                
                // modal.find('.delete').on('click', function(){
                //     var join_selected_values = allVals.join(",");

                //     $.ajax({
                //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //         url: base_url+'/deleteUsers',
                //         type: 'post',
                //         data: 'ids='+join_selected_values,
                //         success: function (response) {
                //             allVals = [];
                //             var res = JSON.parse(response);
                //             if (res.state == 'success') {
                //                 $(".checkboxes:checked").each(function() {
                //                     $(this).parents('tr').fadeOut(function(){
                //                         $(this).remove();
                //                     }); 
                //                 });
                //                 toastr[res.state]('Users deleted successfully.');
                //             } else {
                //                 toastr["error"]('Whoops. Something went wrong.');
                //             }
                //         },
                //         error: function(response) {
                //             toastr["error"]('Whoops. Something went wrong.');
                //         }
                //     });
                // });
            }
        });
    }

    var partyTable = function () {
        var table = $('#change_table #party_table');
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
                "zeroRecords": "No matching records found"
            },
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            
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
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        table.find('.checkboxes').change(function(){
            var checked = $(this).is(":checked");
            if (checked) {
                $(this).attr("checked", true);
            } else {
                $(this).attr("checked", false);
            }
        });

        table.$('.previewPartyModal').click(function(){
            var party_id = $(this).data('id');
            var modal = $('#previewPartyModal');

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneParty',
                type: 'post',
                data: {
                    party_id : party_id
                },
                success: function(response) {
                    var party = JSON.parse(response);

                    modal.find('#party_name').val(party.data[0].party_name);
                    modal.find('#party_logo').attr("src", ""+party.data[0].party_logo);
                }
            });

            modal.modal('show');
        });

        $('.addPartyModal').click(function(){
            var ballot_id = $('#party_ballot_name').val();
            var addModal = $('#addPartyModal');

            addModal.find('#ballot_id').val(ballot_id);
            
            if(ballot_id == -1) {
                confirmModal.find('.modal_content').text("Please make ballot, first.");
                confirmModal.modal('show');
            } else {
                addModal.modal('show');
            }
        });

        table.$('.editPartyModal').click(function(){
            var ballot_id = $('#party_ballot_name').val();
            var party_id = $(this).data('id');
            var modal = $('#editPartyModal');
            modal.find('#edit_ballot_id').val(ballot_id);
            modal.find('#edit_party_id').val(party_id);

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getOneParty',
                type: 'post',
                data: {
                    party_id : party_id
                },
                success: function(response) {
                    var party = JSON.parse(response);

                    modal.find('#edit_party_name').val(party.data[0].party_name);
                    modal.find('#edit_party_logo').attr("src", ""+party.data[0].party_logo);
                }
            });

            modal.modal('show');
        });

        table.$('.deletePartyModal').click(function(){
            var ballot_id = $('#party_ballot_name').val();
            var target_id= 'party_id';
            var id = $(this).data('id');
            var api = api_url+'/ballot/party/delete';

            var modal = $('#deletePartyModal');

            modal.find('#ballot_id').val(ballot_id);
            modal.find('.id').val(id);
            modal.find('.target_id').val(target_id);
            modal.find('.api').val(api);
            modal.modal('show');
        });

        $(document).on('click', '.deletePartiesModal', function(){
            var ballot_id = $('#party_ballot_name').val();
            var modal = $('#deletePartiesModal');
            var allVals = [];

            modal.find('#ballot_id').val(ballot_id);

            table.find(".checkboxes:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });

            if(allVals.length <= 0) {
                var confrim = $('#confirmModal');
                confrim.modal('show');
            } else {
                modal.modal('show');
                var target_id = 'party_id';
                var ids = allVals.join(",");
                var api = api_url+'/ballot/party/delete';

                modal.find('.target_id').val(target_id);
                modal.find('.ids').val(ids);
                modal.find('.api').val(api);
            }
        });

        $('#party_ballot_name').on('change', function(){
            var ballot_id = $(this).val();
        
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: base_url+'/getChangedParty',
                type: 'POST',
                data: {
                    ballot_id : ballot_id
                },
                success:function(response){
                    $('#addPartyModal').remove();
                    $('#deletepartiesModal').remove();
                    $('#confirmModal').remove();
                    $('#change_table').html(response);
    
                    var table = $('#change_table #party_table');
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
                            "zeroRecords": "No matching records found"
                        },
                        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                        
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
                            'targets': [0]
                        }, {
                            "searchable": false,
                            "targets": [0]
                        }],
                        "order": [
                            [1, "asc"]
                        ] // set first column as a default sort by asc
                    });

                    table.find('.group-checkable').change(function () {
                        var set = jQuery(this).attr("data-set");
                        var checked = jQuery(this).is(":checked");
                        jQuery(set).each(function () {
                            if (checked) {
                                $(this).attr("checked", true);
                            } else {
                                $(this).attr("checked", false);
                            }
                        });
                        jQuery.uniform.update(set);
                    });

                    table.find('.checkboxes').change(function(){
                        var checked = $(this).is(":checked");
                        if (checked) {
                            $(this).attr("checked", true);
                        } else {
                            $(this).attr("checked", false);
                        }
                    });

                    table.$('.previewPartyModal').click(function(){
                        var party_id = $(this).data('id');
                        var modal = $('#previewPartyModal');

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/getOneParty',
                            type: 'post',
                            data: {
                                party_id : party_id
                            },
                            success: function(response) {
                                var party = JSON.parse(response);

                                modal.find('#party_name').val(party.data[0].party_name);
                                modal.find('#party_logo').attr("src", ""+party.data[0].party_logo);
                            }
                        });

                        modal.modal('show');
                    });

                    $('.addPartyModal').click(function(){
                        var ballot_id = $('#party_ballot_name').val();
                        var addModal = $('#addPartyModal');

                        addModal.find('#ballot_id').val(ballot_id);
                        
                        if(ballot_id == -1) {
                            confirmModal.find('.modal_content').text("Please make ballot, first.");
                            confirmModal.modal('show');
                        } else {
                            addModal.modal('show');
                        }
                    });

                    table.$('.editPartyModal').click(function(){
                        var ballot_id = $('#party_ballot_name').val();
                        var party_id = $(this).data('id');
                        var modal = $('#editPartyModal');
                        modal.find('#edit_ballot_id').val(ballot_id);
                        modal.find('#edit_party_id').val(party_id);

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: base_url+'/getOneParty',
                            type: 'post',
                            data: {
                                party_id : party_id
                            },
                            success: function(response) {
                                var party = JSON.parse(response);

                                modal.find('#edit_party_name').val(party.data[0].party_name);
                                modal.find('#edit_party_logo').attr("src", ""+party.data[0].party_logo);
                            }
                        });

                        modal.modal('show');
                    });

                     table.$('.deletePartyModal').click(function(){
                           var ballot_id = $('#party_ballot_name').val();
                           var target_id= 'party_id';
                           var id = $(this).data('id');
                           var api = api_url+'/ballot/party/delete';

                           var modal = $('#deletePartyModal');

                           modal.find('#ballot_id').val(ballot_id);
                           modal.find('.id').val(id);
                           modal.find('.target_id').val(target_id);
                           modal.find('.api').val(api);
                           modal.modal('show');
                     });

                     $(document).on('click', '.deletePartiesModal', function(){
                           var ballot_id = $('#party_ballot_name').val();
                           var modal = $('#deletePartiesModal');
                           var allVals = [];

                           modal.find('#ballot_id').val(ballot_id);
                           
                           table.find(".checkboxes:checked").each(function() {  
                              allVals.push($(this).attr('data-id'));
                           });

                           if(allVals.length <= 0) {
                              var confrim = $('#confirmModal');
                              confrim.modal('show');
                           } else {
                              modal.modal('show');
                              var target_id = 'party_id';
                              var ids = allVals.join(",");
                              var api = api_url+'/ballot/party/delete';

                              modal.find('.target_id').val(target_id);
                              modal.find('.ids').val(ids);
                              modal.find('.api').val(api);
                           }
                     });
                }
            });
        });
    }

    var stateTable = function () {
        var table = $('#state_change_table #state_table');

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
                "zeroRecords": "No matching records found"
            },
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            
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

        $('.addStateModal').click(function(){
            var addModal = $('#addStateModal');
            addModal.modal('show');
        });

        table.$('.editStateModal').click(function(){
            var state_id = $(this).data('id');
            var state_code = $(this).data('code');
            
            var modal = $('#editStateModal');
            modal.find('#edit_state_id').val(state_id);
            modal.find('#edit_state_code').val(state_code);

            modal.modal('show');
        });

        table.$('.deleteStateModal').click(function(){
            var state_id = $(this).data('id');
            var target_id= 'state_id';
            var api = api_url+'/location/state/delete';

            var modal = $('#deleteStateModal');

            modal.find('#id').val(state_id);
            modal.find('.target_id').val(target_id);
            modal.find('.api').val(api);
            modal.modal('show');
        });
    }

    var stateCTable = function () {
        var table = $('#county_change_table #county_table');
        
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
                "zeroRecords": "No matching records found"
            },
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            
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

        $('.addCountyModal').click(function(){
            var state_id = $('#loc_state_name').val();
            var addModal = $('#addCountyModal');

            addModal.find('#add_state_id').val(state_id);
            addModal.modal('show');
        });

        table.$('.editCountyModal').click(function(){
            var county_id = $(this).data('id');
            var county_name = $(this).data('name');
            
            var modal = $('#editCountyModal');
            modal.find('#edit_county_id').val(county_id);
            modal.find('#edit_county_name').val(county_name);

            modal.modal('show');
        });

        table.$('.deleteCountyModal').click(function(){
            var county_id = $(this).data('id');
            var target_id= 'county_id';
            var api = api_url+'/location/county/delete';

            var modal = $('#deleteCountyModal');

            modal.find('#id').val(county_id);
            modal.find('.target_id').val(target_id);
            modal.find('.api').val(api);
            modal.modal('show');
        });

        $('#loc_state_name').on('change', function(){
            var state_id = $(this).val();
        
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: base_url+'/getChangedCountyOfState',
                type: 'POST',
                data: {
                    state_id : state_id
                },
                success:function(response){
                    $('#addCountyModal').remove();
                    $('#county_change_table').html(response);
                    
                    var table = $('#county_change_table #county_table');
                    
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
                            "zeroRecords": "No matching records found"
                        },
                        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                        
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

                    $('.addCountyModal').click(function(){
                        var state_id = $('#loc_state_name').val();
                        var addModal = $('#addCountyModal');

                        addModal.find('#add_state_id').val(state_id);
                        addModal.modal('show');
                    });

                    table.$('.editCountyModal').click(function(){
                        var county_id = $(this).data('id');
                        var county_name = $(this).data('name');
                        
                        var modal = $('#editCountyModal');
                        modal.find('#edit_county_id').val(county_id);
                        modal.find('#edit_county_name').val(county_name);

                        modal.modal('show');
                    });

                    table.$('.deleteCountyModal').click(function(){
                        var county_id = $(this).data('id');
                        var target_id= 'county_id';
                        var api = api_url+'/location/county/delete';

                        var modal = $('#deleteCountyModal');

                        modal.find('#id').val(county_id);
                        modal.find('.target_id').val(target_id);
                        modal.find('.api').val(api);
                        modal.modal('show');
                    });
                }
            });
        });
    }

    return {
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

            dashboardTable();
            ballotTable();
            raceTable();
            candidateTable();
            languageTable();
            countyTable();
            propositionTable();
            massPropositionTable();
            usersTable();
            partyTable();
            stateTable();
            stateCTable();
        }
    };
}();
