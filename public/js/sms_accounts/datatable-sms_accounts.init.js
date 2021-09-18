$(document).ready(function() {
    dataTableSmsAccounts = $('#datatable-sms_accounts').DataTable({
            stateSave: 0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
            "columnDefs": [ {
                "targets": 7,
                "orderable": false,
                "searchable": false
                } ],
        }),
        $('#datatable-sms_accounts tfoot th').each(function() {
            if (!$(this).hasClass('disabled')) {
                var title = $(this).text();
                $(this).html('<input class="form-control form-control-sm sms_accounts" type="text" placeholder="Search ' + title + '" />');
            }
        });
    dataTableSmsAccounts.columns().every(function() {
        var that = this;

        $('.sms_accounts', this.footer()).on('keyup change clear', function() {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });
    dataTableSmsAccounts.columns().every(function() {
        var column = this;
        if ($(column.footer()).hasClass('select')) {
            var select = $('<select class="form-select"><option value=""></option></select>')
                .appendTo($(column.footer()).empty())
                .on('change', function() {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            if ($(column.footer()).hasClass('with-span')) {
                column.data().unique().sort().each(function(d, j) {
                    d = d.slice(d.indexOf(">") + 1, d.indexOf("<", 1))
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            } else {
                column.data().unique().sort().each(function(d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            }
        }
    });
})