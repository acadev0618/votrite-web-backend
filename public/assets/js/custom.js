var api_url = "http://10.10.10.143:9191/api";
var base_url="http://localhost/VotRiteBackend/public";

var TableManaged = function () {

    var dashboardTable = function () {

        var table = $('#dashboard_table');

        // begin: third table
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

        var tableWrapper = jQuery('#sample_3_wrapper');

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

        tableWrapper.find('.dataTables_length select').select2();
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

        var tableWrapper = jQuery('#sample_3_wrapper');

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
            var $this = $(this);
            var id = $(this).data('id');
            var modal = $('#deleteBallotModal');
            modal.find('#ballot_id').val(id);
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
                var ballot_ids = allVals.join(",");
                modal.find('.ballot_ids').val(ballot_ids);
            }
        });

        tableWrapper.find('.dataTables_length select').select2();
    }

    var raceTable = function () {

        var table = $('#race_table');

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

        var tableWrapper = jQuery('#sample_3_wrapper');

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

        $(document).on('click', '.deleteRacesModal', function(){
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

                modal.find('.target_id').val(target_id);
                modal.find('.ids').val(ids);
                modal.find('.api').val(api);
            }
        });

        $('.addRaceModal').click(function(){
            var modal = $('#addRaceModal');
            modal.modal('show');
        });

        $('.previewRaceModal').click(function(){
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
                    var response = JSON.parse(response);
                    console.log(response);
                    // var race = JSON.parse(response.race);
                    // var languages = JSON.parse(response.languages);
                    // var countries = JSON.parse(response.countries);

                    // modal.find('#race_name').val(race.data[0].race_name);
                    // modal.find('#race_type').val(race.data[0].race_type);
                    // modal.find('#min_num_of_votes').val(race.data[0].min_num_of_votes);
                    // modal.find('#max_num_of_votes').val(race.data[0].max_num_of_votes);
                    // modal.find('#max_num_of_write_ins').val(race.data[0].max_num_of_write_ins);
                    // // modal.find('#race_lang_id').val(res.data[0].race_lang_id);
                    // // modal.find('#race_location_id').val(res.data[0].race_location_id);
                    // modal.find('#race_title').val(race.data[0].race_title);
                    // modal.find('#race_voted_position').val(race.data[0].race_voted_position);
                }
            });

            modal.modal('show');
        });

        $('.editRaceModal').click(function(){
            var race_id = $(this).data('id');
            var modal = $('#editRaceModal');

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+'/getRaceData',
                type: 'post',
                data: {
                    race_id : race_id
                },
                success: function(response) {
                    var response = JSON.parse(response);
                    var race = JSON.parse(response.race);
                    var languages = JSON.parse(response.languages);
                    var countries = JSON.parse(response.countries);

                    modal.find('#edit_race_id').val(race_id);
                    modal.find('#edit_race_name').val(race.data[0].race_name);
                    modal.find('#edit_race_type').val(race.data[0].race_type);
                    modal.find('#edit_min_num_of_votes').val(race.data[0].min_num_of_votes);
                    modal.find('#edit_max_num_of_votes').val(race.data[0].max_num_of_votes);
                    modal.find('#edit_max_num_of_write_ins').val(race.data[0].max_num_of_write_ins);
                    // modal.find('#edit_race_lang_id').val(res.data[0].race_lang_id);
                    // modal.find('#edit_race_location_id').val(res.data[0].race_location_id);
                    modal.find('#edit_race_title').val(race.data[0].race_title);
                    modal.find('#edit_race_voted_position').val(race.data[0].race_voted_position);
                }
            });

            modal.modal('show');
        });

        $('.deleteRaceModal').click(function(){
            var target_id= 'race_id';
            var id= $(this).data('id');
            var api = api_url+'/race/delete';
            var modal = $('#deleteRaceModal');

            modal.find('.id').val(id);
            modal.find('.target_id').val(target_id);
            modal.find('.api').val(api);
            modal.modal('show');
        });

        tableWrapper.find('.dataTables_length select').select2();
    }

    var candidateTable = function () {

        var table = $('#candidate_table');

        // begin: third table
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

        var tableWrapper = jQuery('#sample_3_wrapper');

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

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

    var languageTable = function () {

        var table = $('#language_table');

        // begin: third table
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

        var tableWrapper = jQuery('#sample_3_wrapper');

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

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }    
    
    var countryTable = function () {

        var table = $('#country_table');

        // begin: third table
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

        var tableWrapper = jQuery('#sample_3_wrapper');

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

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }  
    
    var propositionTable = function () {

        var table = $('#proposition_table');

        // begin: third table
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

        var tableWrapper = jQuery('#sample_3_wrapper');

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

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
    
    var massPropositionTable = function () {

        var table = $('#mass_proposition_table');

        // begin: third table
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

        var tableWrapper = jQuery('#sample_3_wrapper');

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

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

    var voterTable = function () {

        var table = $('#voter_table');

        // begin: third table
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

        var tableWrapper = jQuery('#sample_3_wrapper');

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

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
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

        var tableWrapper = jQuery('#sample_3_wrapper');

        $(document).on('click', '.addUserModal', function(){
            var modal = $('#addUserModal');
            modal.modal('show');
        });  

        table.on('click', '.previewUserModal', function(){
            var modal = $('#previewUserModal');
            $('#preview_user_name').val($(this).data('username'));
            $('#preview_display_name').val($(this).data('alias'));
            $('#preview_user_email').val($(this).data('email'));
            $('#preview_user_avatar').val($(this).data('avatar'));
            modal.modal('show');
        });

        table.on('click', '.editUserModal', function(){
            var id = $(this).data('id');
            var modal = $('#editUserModal');
            $('#edit_user_name').val($(this).data('username'));
            $('#edit_display_name').val($(this).data('alias'));
            $('#edit_user_email').val($(this).data('email'));
            $('#edit_user_password').val("password");
            $('#edit_user_avatar').val($(this).data('avatar'));
            modal.find(".user_id").val(id);
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

            // modal.find('.delete').click(function() {
            //     $.ajax({
            //         headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //         url : base_url+'/deleteUser',
            //         data : {
            //             user_id : id
            //         },
            //         type : 'post',
            //         success : function(response){
            //             response = JSON.parse(response);
            //             if(response.state == 'success') {
            //                 $this.parents('tr').fadeOut(function(){
            //                     $this.remove();
            //                 });
            //                 toastr[response.state]('User deleted successfully.');
            //             } else {
            //                 toastr['error']('Whoops! Something went wrong.');
            //             }
            //         }
            //     });
            // });
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

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

    var partyTable = function () {

        var table = $('#party_table');

        // begin: third table
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

        var tableWrapper = jQuery('#sample_3_wrapper');

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

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
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
            countryTable();
            propositionTable();
            massPropositionTable();
            voterTable();
            usersTable();
            partyTable();
        }
    };

}();

$('#ballot_name').on('change', function(){
    var ballot_id = $(this).val();

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: base_url+'/getData',
        type: 'POST',
        data: {
            key : "ballot_id=",
            id : ballot_id,
            api : api_url+'/race'
        },
        success:function(response){
            var res = JSON.parse(response);
            console.log(res);
            // var trs = " ";
            // trs += '<tr class="odd gradeX">'
            //         + '<td><input type="checkbox" class="checkboxes" value="1"/></td>'
            //         + '<td>'+res.data[0].race_id+'</td>'
            //         + '<td>'+res.data[0].race_id+'</td>'
            //         + '<td>'+res.data[0].race_id+'</td>'
            //         + '<td>'+res.data[0].race_id+'</td>'
            //         + '<td>'+res.data[0].race_id+'</td>'
            //         + '<td>'+res.data[0].race_id+'</td>';

            // $('#race_tbody').html(trs);
        }
    });
});

$('.manage_ul li').click(function() {
    $(this).addClass('active');
});