$(document).ready(function () {
    var a = $("#datatable-groups").DataTable({
        lengthChange: !1,
        buttons: [
            { extend: "copy", className: "btn-light" },
            { extend: "print", className: "btn-light" },
            { extend: "pdf", className: "btn-light" },
        ],
        language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
        stateSave: 0,
        language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
    });
    a.buttons().container().appendTo("#datatable-groups_wrapper .col-md-6:eq(0)"),
        $(".dataTables_length select").addClass("form-select form-select-sm"),
        $(".dataTables_length select").removeClass("custom-select custom-select-sm"),
        $(".dataTables_length label").addClass("form-label");


    // Setup - add a text input to each footer cell
    $('#datatable-groups tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input class="form-control form-control-sm" type="text" placeholder="Search ' + title + '" />');
    });
    $('.disabled').each(function () {
        $(this).html('');
    })
    // DataTable filter
    a.columns('.text-filter').every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });
    a.columns().every(function () {
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
            if ($(column.footer()).hasClass('account')) {
                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            } else {
                column.data().unique().sort().each(function (d, j) {
                    d = d.slice(d.indexOf(">") + 1, d.indexOf("<", 1))
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            }
        }
    });
});
function editGroup(id) {
    $.get('/groups/get/' + id + '/1', function (contact) {
        contact = contact[0]
        console.log(contact)
        $('#form_edit-id').val(id)
        $('#form_edit-account_id').val(contact.account_id)
        $('#form_edit-class').val(contact.class)
        $('#form_edit-source').val(contact.source)
        $('#form_edit-status').val(contact.status)
        $('#form_edit-source_id').val(contact.source_id)
        $('#delete').attr('onClick', 'deleteContact(' + id + ');')
    })
}
function deleteGroup(id) {
    Swal.fire({ title: "Are you sure?", text: "This group will be disabled!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function (e) {
            e.value
                ? $.ajax({
                    type: "DELETE",
                    url: route('groups.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        //$('#edit-modal').modal('toggle')
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                        $('#btn-edit-' + id).addClass('disabled');
                        $('#btn-delete-' + id).addClass('disabled');
                        $('#contactid' + id + ' td:nth-child(7)').html('<span class="badge label-table bg-danger">Not interested</span>')
                        $('#contact-info2 p:nth-of-type(4)').html('<span class="badge label-table bg-danger">Not interested</span>')
                        $('#contact-info1 a:nth-of-type(4)').attr('data-bs-toggle', '')
                        $('#contact-info1 a:nth-of-type(4)').attr('onClick', '')
                        $('#contact-info1 a:nth-of-type(5)').attr('onClick', '')
                    },
                    error: function (error) {
                        console.log(error)
                        Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
                    }
                })
                : e.dismiss === Swal.DismissReason.cancel && Swal.fire({ title: "Cancelled", text: "Operation canceled :)", icon: "error", confirmButtonColor: "#4a4fea" });
        }
    );
}