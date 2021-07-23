$(document).ready(function () {
    var a = $("#datatable-contacts").DataTable({
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
    a.buttons().container().appendTo("#datatable-contacts_wrapper .col-md-6:eq(0)"),
        $(".dataTables_length select").addClass("form-select form-select-sm"),
        $(".dataTables_length select").removeClass("custom-select custom-select-sm"),
        $(".dataTables_length label").addClass("form-label");


    // Setup - add a text input to each footer cell
    $('#datatable-contacts tfoot th').each(function () {
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

function viewContact(id, type) {
    $.get('/contacts/get/' + id + '/0', function (contact) {
        if (!contact.length) {
            //NotificationApp.send("Plain transition", "Contact Not Found.", "top-right", "#3b98b5", "warning", 3e3, 1, "plain");
            Swal.fire({ icon: "error", title: "Contact Not Found", showConfirmButton: !1, timer: 1500 });
        } else {
            if (type == 1) {
                if (!$('#contacts_companie-info-card').hasClass('d-none')) {
                    $('#contacts_companie-info-card').addClass('d-none')
                    $('#contacts_person-info-card').removeClass('d-none')
                }
                $('#contacts_person-info-card').empty().html(contact);
            } else if (type == 2) {
                $('#contacts_companie-info-card').empty().html(contact);
                if (!$('#contacts_person-info-card').hasClass('d-none')) {
                    $('#contacts_person-info-card').addClass('d-none')
                    $('#contacts_companie-info-card').removeClass('d-none')
                }
            }
        }
    })
}
function editContact(id) {
    $.get('/contacts/get/' + id + '/1', function (contact) {
        contact = contact[0]
        console.log(contact)
        $('#form_edit-id').val(id)
        $('#form_edit-account_id').val(contact.account_id)
        $('#form_edit-class').val(contact.class)
        $('#form_edit-class-disabled').val(contact.class)
        $('#form_edit-source').val(contact.source)
        $('#form_edit-status').val(contact.status)
        $('#form_edit-source_id').val(contact.source_id)
        if (contact.class == 1) {
            $('#edit-nav-tab-info a:nth-of-type(1)').attr('href', '#edit-personcontact')
            //disable validation on companies contact tab
            $('#form_edit .companie-required').attr('required', false)
            //active validation on person contact tab
            $('#form_edit .person-required').attr('required', true)
            $('#form_edit-first_name').val(contact.first_name)
            $('#form_edit-nickname').val(contact.nickname)
            $('#form_edit-birthdate').val(contact.birthdate)
            $('#form_edit-person_country').val(contact.country)
            $('#form_edit-last_name').val(contact.last_name)
            $('#form_edit-profile').val(contact.profile)
            $('#form_edit-gender').val(contact.gender)
            $('#form_edit-person_language').val(contact.language)
        } else if (contact.class == 2) {
            $('#edit-nav-tab-info a:nth-of-type(1)').attr('href', '#edit-companiescontact')
            //active validation on companies contact tab
            $('#form_edit .companie-required').attr('required', true)
            //disable validation on person contact tab
            $('#form_edit .person-required').attr('required', false)
            $('#form_edit-companies_country').val(contact.country)
            $('#form_edit-name').val(contact.name)
            $('#form_edit-companies_class').val(contact.companies_class)
            $('#form_edit-registered_number').val(contact.registered_number)
            $('#form_edit-companies_language').val(contact.language)
            $('#form_edit-activity').val(contact.activity)
            console.log(url_photo + '/' + contact.logo)
            $('#form_edit-logo').attr('src', url_photo + '/' + contact.logo)
        }
        $('#delete').attr('onClick', 'deleteContact(' + id + ');')
    })
}
function deleteContact(id) {
    Swal.fire({ title: "Are you sure?", text: "This contact will be disabled!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function (e) {
            e.value
                ? $.ajax({
                    type: "DELETE",
                    url: route('contacts.delete', id),
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