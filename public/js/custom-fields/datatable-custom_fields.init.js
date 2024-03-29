$(document).ready(function () {
    dataTableCustomFields = $('#datatable-custom-fields').DataTable({
        stateSave: !1,
        "pageLength": 10,
        language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
        "columnDefs": [{
            "targets": 6,
            "orderable": false,
            "searchable": false
        }],
        "aaSorting": [],
    }),
        $('#datatable-custom-fields tfoot th').each(function () {
            if (!$(this).hasClass('disabled')) {
                var title = $(this).text();
                $(this).html('<input class="form-control form-control-sm custom-fields" type="text" placeholder="Search ' + title + '" />');
            }
        });
    dataTableCustomFields.columns().every(function () {
        var that = this;

        $('.custom-fields', this.footer()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });
    dataTableCustomFields.columns().every(function () {
        var column = this;
        if ($(column.footer()).hasClass('select')) {
            var select = $('<select class="form-select"><option value=""></option></select>')
                .appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            if ($(column.footer()).hasClass('with-span')) {
                column.data().unique().sort().each(function (d, j) {
                    d = d.slice(d.indexOf(">") + 1, d.indexOf("<", 1))
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            } else {
                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            }
        }
    });
})