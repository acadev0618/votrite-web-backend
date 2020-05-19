var TableEditable = function () {
    
    var clientTable = function () {

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function addRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[0] + '">';
            jqTds[1].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[1] + '">';
            jqTds[2].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[2] + '">';
            jqTds[3].innerHTML = '<select class="form-control input-small" value="' + aData[4] + '"><option>Customer</option><option>Provider</option></select>';
            jqTds[4].innerHTML = '<a class="edit" href="">Add</a>';
            jqTds[5].innerHTML = '<a class="cancel" href="">Cancel</a>';
        }

        function editRow(oTable, nRow, id) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[0] + '">';
            jqTds[1].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[1] + '">';
            jqTds[2].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[2] + '">';
            jqTds[3].innerHTML = '<select class="form-control input-small" value="' + aData[4] + '"><option>Customer</option><option>Provider</option></select>';
            jqTds[4].innerHTML = '<a class="edit" href="" data-id="'+id+'">Save</a>';
            jqTds[5].innerHTML = '<a class="cancel" href="" data-id="'+id+'">Cancel</a>';
        }

        function saveRow(oTable, nRow, dataId) {
            var jqInputs = $('input', nRow);
            var jqSelect = $('select', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(jqSelect[0].value, nRow, 3, false);
            oTable.fnUpdate('<a class="edit" href="" data-id="'+dataId+'">Edit</a>', nRow, 4, false);
            oTable.fnUpdate('<a class="delete" href="" data-id="'+dataId+'">Delete</a>', nRow, 5, false);
            oTable.fnDraw();
        }

        function cancelEditRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(jqSelect[0].value, nRow, 3, false);
            oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 4, false);
            oTable.fnDraw();
        }

        var table = $('#client_table');

        var oTable = table.dataTable({
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],

            "pageLength": 10,

            "language": {
                "lengthMenu": " _MENU_ records"
            },
            "columnDefs": [{ // set default column settings
                'orderable': true,
                'targets': [0]
            }, {
                "searchable": true,
                "targets": [0]
            }],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = $("#sample_editable_1_wrapper");

        tableWrapper.find(".dataTables_length select").select2({
            showSearchInput: false //hide search box with special css class
        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        $('#add_client').click(function(e) {
            e.preventDefault();

            if (nNew && nEditing) {
                alert("Please enter informations");
                
                oTable.fnDeleteRow(nEditing); // cancel
                nEditing = null;
                nNew = false;
                return;
            }

            var aiNew = oTable.fnAddData(['', '', '', '', '', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            addRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("Are you sure to delete this row ?") == false) {
                return;
            }

            var nRow = $(this).parents('tr')[0];
            var id = $(this).data('id');
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: 'http://localhost/Ordering/public/deleteClient',
                type: 'post',
                data: { 
                    id : id
                },
                
                success:function(response){
                    console.log(response); 
                }
            });
            oTable.fnDeleteRow(nRow);
        });

        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();

            var nRow = $(this).parents('tr')[0];
            var id = $(this).data('id');

            if (nEditing !== null && nEditing != nRow) {
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow, id);
                nEditing = nRow;
            } else if (nEditing == nRow) {
                var jqInputs = $('input', nRow);
                var jqSelect = $('select', nRow);

                var client_name = jqInputs[0].value;
                var client_address = jqInputs[1].value;
                var client_vat = jqInputs[2].value;
                var client_type = jqSelect[0].value;
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                if(this.innerHTML == "Add") {
                    $.ajax({
                        url: 'http://localhost/Ordering/public/addClient',
                        type: 'post',
                        data: { 
                            name : client_name,
                            address : client_address,
                            vat : client_vat,
                            type: client_type
                        },
                        
                        success:function(response){
                            saveRow(oTable, nEditing, response);
                            nEditing = null;
                        }
                    });
                } 
                
                if (this.innerHTML == "Save") {
                    $.ajax({
                        url: 'http://localhost/Ordering/public/updateClient',
                        type: 'post',
                        data: {
                            id: id,
                            name : client_name,
                            address : client_address,
                            vat : client_vat,
                            type: client_type
                        },
                        
                        success:function(response){
                            saveRow(oTable, nEditing, id);
                            nEditing = null; 
                        }
                    });
                }
            } else {
                editRow(oTable, nRow, id);
                nEditing = nRow;
            }
        });
    }

    var orderTable = function () {

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow, id) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<select type="text" class="form-control input-small" value="' + aData[0] + '" readonly><option>' + aData[0] + '</option></select>';
            jqTds[1].innerHTML = '<input value="' + aData[1] + '" readonly class="form-control">';
            jqTds[2].innerHTML = '<input value="' + aData[2] + '" readonly class="form-control">';
            jqTds[3].innerHTML = '<input value="' + aData[3] + '" readonly class="form-control">';
            jqTds[4].innerHTML = '<input value="' + aData[4] + '" readonly class="form-control">';
            jqTds[5].innerHTML = '<input value="' + aData[5] + '" readonly class="form-control">';
            jqTds[6].innerHTML = '<input value="' + aData[6] + '" readonly class="form-control">';
            jqTds[7].innerHTML = '<input value="' + aData[7] + '" readonly class="form-control">';
            jqTds[8].innerHTML = '<select class="form-control input-small" value="' + aData[8] + '"><option>Searching</option><option>In Transit</option><option>Confirmed</option></select>';
            jqTds[9].innerHTML = '<a class="edit" href="" data-id="'+id+'">Save</a>';
            jqTds[10].innerHTML = '<a class="cancel" href="" data-id="'+id+'">Cancel</a>';
        }

        function saveRow(oTable, nRow, id) {
            var jqInputs = $('input', nRow);
            var jqSelect = $('select', nRow);
            oTable.fnUpdate(jqSelect[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[0].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 3, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 4, false);
            oTable.fnUpdate(jqInputs[4].value, nRow, 5, false);
            oTable.fnUpdate(jqInputs[5].value, nRow, 6, false);
            oTable.fnUpdate(jqInputs[6].value, nRow, 7, false);
            oTable.fnUpdate(jqSelect[1].value, nRow, 8, false);
            oTable.fnUpdate('<a class="edit" href="" data-id="'+id+'">Edit</a>', nRow, 9, false);
            oTable.fnUpdate('<a class="delete" href="" data-id="'+id+'">Delete</a>', nRow, 10, false);
            oTable.fnUpdate('<a class="print" href="" data-id="'+id+'">Print</a>', nRow, 11, false);
            oTable.fnDraw();
        }

        function cancelEditRow(oTable, nRow) {
            var jqSelect = $('select', nRow);
            oTable.jqSelect(jqInputs[0].value, nRow, 9, false);
            oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 10, false);
            oTable.fnDraw();
        }

        var table = $('#order_table');

        var oTable = table.dataTable({
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],

            "pageLength": 10,

            "language": {
                "lengthMenu": " _MENU_ records"
            },
            "columnDefs": [{ // set default column settings
                'orderable': true,
                'targets': [0]
            }, {
                "searchable": true,
                "targets": [0]
            }],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = $("#sample_editable_1_wrapper");

        tableWrapper.find(".dataTables_length select").select2({
            showSearchInput: false //hide search box with special css class
        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        table.on('click', '.delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            if (confirm("Are you sure to delete this row ?") == false) {
                return;
            }

            var nRow = $(this).parents('tr')[0];
            var id = $(this).data('id');
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: 'http://localhost/Ordering/public/deleteOrder',
                type: 'post',
                data: { 
                    id : id
                },
                
                success:function(response){
                    console.log(response); 
                }
            });
            oTable.fnDeleteRow(nRow);
        });

        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();

            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];
            var id = $(this).data('id');

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow, id);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == "Save") {
                var jqSelect = $('select', nRow);
                var status = jqSelect[1].value;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: 'http://localhost/Ordering/public/updateOrder',
                    type: 'post',
                    data: {
                        id: id,
                        order_status_id: status
                    },
                    
                    success:function(response){
                        saveRow(oTable, nEditing, id);
                        nEditing = null; 
                    }
                });
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow, id);
                nEditing = nRow;
            }
        });
    }

    var invoiceTable = function () {

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow, id) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<select type="text" class="form-control input-small" value="' + aData[0] + '" readonly><option>' + aData[0] + '</option></select>';
            jqTds[1].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[1] + '" readonly>';
            jqTds[2].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[2] + '" readonly>';
            jqTds[3].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[3] + '" readonly>';
            jqTds[4].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[4] + '" readonly>';
            jqTds[5].innerHTML = '<select class="form-control input-small" value="' + aData[5] + '"><option>Waiting</option><option>Sent</option><option>Paid</option></select>';
            jqTds[6].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[6] + '" readonly>';
            jqTds[7].innerHTML = '<a class="edit" href="" data-id="'+id+'">Save</a>';
            jqTds[8].innerHTML = '<a class="cancel" href="" data-id="'+id+'">Cancel</a>';
        }

        function saveRow(oTable, nRow, id) {
            var jqInputs = $('input', nRow);
            var jqSelect = $('select', nRow);
            oTable.fnUpdate(jqSelect[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[0].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 3, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 4, false);
            oTable.fnUpdate(jqSelect[1].value, nRow, 5, false);
            oTable.fnUpdate(jqInputs[4].value, nRow, 6, false);
            oTable.fnUpdate('<a class="edit" href="" data-id="'+id+'">Edit</a>', nRow, 7, false);
            oTable.fnUpdate('<a class="delete" href="" data-id="'+id+'">Delete</a>', nRow, 8, false);
            oTable.fnUpdate('<a class="print" href="" data-id="'+id+'">Print</a>', nRow, 9, false);
            oTable.fnDraw();
        }

        function cancelEditRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            var jqSelect = $('select', nRow);
            oTable.fnUpdate(jqSelect[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[0].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 3, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 4, false);
            oTable.fnUpdate(jqSelect[1].value, nRow, 5, false);
            oTable.fnUpdate(jqInputs[4].value, nRow, 6, false);
            oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 7, false);
            oTable.fnDraw();
        }

        var table = $('#invoice_table');

        var oTable = table.dataTable({
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],

            "pageLength": 10,

            "language": {
                "lengthMenu": " _MENU_ records"
            },
            "columnDefs": [{ // set default column settings
                'orderable': true,
                'targets': [0]
            }, {
                "searchable": true,
                "targets": [0]
            }],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = $("#sample_editable_1_wrapper");

        tableWrapper.find(".dataTables_length select").select2({
            showSearchInput: false //hide search box with special css class
        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("Are you sure to delete this row ?") == false) {
                return;
            }

            var nRow = $(this).parents('tr')[0];
            var id = $(this).data('id');
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: 'http://localhost/Ordering/public/deleteInvoice',
                type: 'post',
                data: { 
                    id : id
                },
                
                success:function(response){
                    console.log(response); 
                }
            });
            oTable.fnDeleteRow(nRow);
        });

        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();

            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];
            var id = $(this).data('id');

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow, id);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == "Save") {
                /* Editing this row and want to save it */
                var jqSelect = $('select', nRow);
                var status = jqSelect[1].value;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: 'http://localhost/Ordering/public/updateInvoice',
                    type: 'post',
                    data: {
                        id: id,
                        status: status
                    },
                    
                    success:function(response){
                        saveRow(oTable, nEditing, id);
                        nEditing = null; 
                    }
                });
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow, id);
                nEditing = nRow;
            }
        });

        // table.on('click', '.print', function(e){
        //     e.preventDefault();
        //     // var nRow = $(this).parents('tr')[0];
        //     // var aData = oTable.fnGetData(nRow);
        //     // window.open('print_invoice');

        //     // var doc = new jsPDF();
        //     var elementHTML = $('#invoice_doc').html();
        //     alert(elementHTML);
        //     // var specialElementHandlers = {
        //     //     '#elementH': function (element, renderer) {
        //     //         return true;
        //     //     }
        //     // };
        //     // doc.fromHTML(elementHTML, 15, 15, {
        //     //     'width': 170,
        //     //     'elementHandlers': specialElementHandlers
        //     // });

        //     // // Save the PDF
        //     // doc.save('invoice-document.pdf');
        // });
    }

    return {
        //main function to initiate the module
        init: function () {
            clientTable();
            invoiceTable();
            orderTable();
        }
    };

}();