$(document).ready(function() {
    /**
     * datatable js init
     */
    var a = $("#datatable-users").DataTable({
        lengthChange: !1,
        buttons: [
            { extend: "copy", className: "btn-light" },
            { extend: "print", className: "btn-light" },
            { extend: "pdf", className: "btn-light" },
        ],
        language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
        "columnDefs": [ {
            "targets": 6,
            "orderable": false,
            "searchable": false
            } ],
    });

    $(".dataTables_length select").addClass("form-select form-select-sm"),
        $(".dataTables_length select").removeClass("custom-select custom-select-sm"),
        $(".dataTables_length label").addClass("form-label");
    // Setup - add a text input to each footer cell
    $('#datatable-users tfoot th').each(function() {
        if (!$(this).hasClass('select')) {
            var title = $(this).text();
            $(this).html('<input class="form-control form-control-sm" type="text" placeholder="Search ' + title + '" />');
        }
    });
    $('.disabled').each(function() {
        $(this).html('');
    })
    a.columns().every(function() {
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
            if ($(column.footer()).hasClass('account')) {
                column.data().unique().sort().each(function(d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            } else {
                column.data().unique().sort().each(function(d, j) {
                    d = d.slice(d.indexOf(">") + 1, d.indexOf("<", 1))
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            }
        }
    });
    // DataTable filter
    a.columns('.text-filter').every(function() {
        var that = this;

        $('input', this.footer()).on('keyup change clear', function() {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });

    /**
     * end datatable js init
     */

})