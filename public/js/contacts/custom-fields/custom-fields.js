$(document).ready(function() {
    $('#create-custom-field-field_type').on('click', function() {
        if ($(this).val() == 'select')
            $('#create-custom-field-options').removeClass('d-none')
        else
            $('#create-custom-field-options').addClass('d-none')
    })
    $('#btn-edit-custom-field').on('click', function() {
        cleanErrorsInForm('edit-custom-field', errors_edit_custom_field)
        errors_edit_custom_field = null
    })

    $('#create-custom-field-select_option').selectize({
        create: true,
    });

    $('#edit-custom-field').submit(function(e) {
        e.preventDefault();
        cleanErrorsInForm('edit-custom-field', errors_edit_custom_field)
        $.ajax({
            type: "POST",
            url: route('custom-fields.update'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                $('#edit-custom-field-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                viewCustomFields()
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while updating that Custom Field", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    errors_edit_custom_field = error.responseJSON.errors
                    laravelValidation('edit-custom-field', error.responseJSON.errors)
                }
            }
        });
    });
});

function viewCustomFields() {
    $.get('/contacts/custom-fields', function(data) {
        //console.log(data)
        if (typeof dataTableCustomFields !== 'undefined')
            dataTableCustomFields.destroy()
        $('#custom-fields-div').empty().html(data);
        dataTableCustomFields = $('#datatable-custom-fields').DataTable({
                stateSave: 0,
                "pageLength": 5,
                language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                },
            }),
            $('#datatable-custom-fields tfoot th').each(function() {
                if (!$(this).hasClass('disabled')) {
                    var title = $(this).text();
                    $(this).html('<input class="form-control form-control-sm custom-fields" type="text" placeholder="Search ' + title + '" />');
                }
            });
        dataTableCustomFields.columns().every(function() {
            var that = this;

            $('.custom-fields', this.footer()).on('keyup change clear', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
        dataTableCustomFields.columns().every(function() {
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
        $('#custom-fields-modal').modal('toggle')
    })
}

function editCustomField(id) {
    $('#custom-fields-modal').modal('toggle')
    $.get('/contacts/custom-fields/get/' + id, function(data) {
        console.log(data)
        $('#edit-custom-field-id').val(id)
        $('#edit-custom-field-acccount_id').val(data.custom_field.acccount_id)
        $('#edit-custom-field-name').val(data.custom_field.name)
        $('#edit-custom-field-field_type').val(data.custom_field.field_type)
        $('#edit-custom-field-tag').val(data.custom_field.tag)
        $('#edit-custom-field-options').addClass('d-none')
        if (data.custom_field.field_type == 'select') {
            var options = [];
            $('#edit-custom-field-options').removeClass('d-none');
            /*var $select = $('#edit-custom-field-select_option').selectize({
                create: true,
                options: ['ddd'],
                items: ['ddd'],
            });

            var select_options = $select[0].selectize;*/

            (data.options).forEach(opt => {
                options.push(opt.title)
                    //select_options.addOption(opt.title);
                    //select_options.addItem(opt.title, true);
            })
            console.log(options)
                //select_options.refreshItems();
            $('#edit-custom-field-select_option').val(options)
        }
    })
}

function deleteCustomField(id) {
    $.ajax({
        type: "DELETE",
        url: route('custom-fields.delete', id),
        data: {
            _token: $("input[name=_token]").val(),
        },
        dataType: "json",
        success: function(response) {
            Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

            $('#custom-field' + id + ' a:nth-child(1)').attr('onclick', '')
            $('#custom-field' + id + ' a:nth-child(1)').attr('data-bs-toggle', '')
            $('#custom-field' + id + ' a:nth-child(2)').attr('onclick', '')
        },
        error: function(error) {
            console.log(error)
            Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
        }
    })
}

function deleteContactFieldFile(id, tag) {
    $.ajax({
        type: "DELETE",
        url: route('contacts_field_file.delete', id),
        data: {
            _token: $("input[name=_token]").val(),
        },
        dataType: "json",
        success: function(response) {
            Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

            $('#form_edit-' + tag + '-preview').addClass('d-none')
            $('#form_edit-' + tag + '-preview').attr('href', '#')
            $('#form_edit-' + tag + '-delete').attr('onclick', '')
            $('#form_edit-' + tag + '-delete').addClass('d-none')
        },
        error: function(error) {
            console.log(error)
            Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
        }
    })
}