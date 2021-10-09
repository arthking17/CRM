$(document).ready(function () {
    "use strict";
    $('#form_edit-class').on('change', function () {
        if ($(this).val() == "1") {
            $('#edit-nav-tab-info a:nth-of-type(1)').attr('href', '#edit-personcontact')
            //disable validation on companies contact tab
            $('#form_edit .companie-required').attr('required', false)
            //active validation on person contact tab
            $('#form_edit .person-required').attr('required', true)
        } else if ($(this).val() == "2") {
            $('#edit-nav-tab-info a:nth-of-type(1)').attr('href', '#edit-companiescontact')
            //active validation on companies contact tab
            $('#form_edit .companie-required').attr('required', true)
            //disable validation on person contact tab
            $('#form_edit .person-required').attr('required', false)
        }
    })

    $('#form_edit-account_id').on('change', function () {
        $.get(route('custom-fields.form', {'account_id':$('#form_edit-id').val(), 'form_type':'edit'}), function (data) {
           $('#edit-custom-fields').html(data.html);

           (data.custom_fields).forEach(field => {
               if (field.field_type == 'checkbox') {
                   $('#form_edit-' + field.tag).attr('checked', false)
               } else if (field.field_type == 'file') {
                   $('#form_edit-' + field.tag + '-preview').addClass('d-none')
                   $('#form_edit-' + field.tag + '-preview').attr('href', '#')
                   $('#form_edit-' + field.tag + '-delete').attr('onclick', '#')
                   $('#form_edit-' + field.tag + '-delete').addClass('d-none')
               } else if (field.field_type == 'select') {
                   $('#form_edit-' + field.tag).val('')
               } else {
                   $('#form_edit-' + field.tag).val('')
               }
               if (field.field_type == 'datetime') {
                   $('#form_edit-' + field.tag).flatpickr({
                       enableTime: true,
                       altInput: true,
                       defaultDate: null,
                       dateFormat: "Y-m-d H:i",
                   })
               }
           });
           (data.contact_field).forEach(field => {
               if (field.field_type == 'checkbox') {
                   $('#form_edit-' + field.tag).attr('checked', true)
               } else if (field.field_type == 'file') {
                   $('#form_edit-' + field.tag + '-preview').removeClass('d-none')
                   $('#form_edit-' + field.tag + '-preview').attr('href', url_custom_field + '/' + field.field_value)
                   $('#form_edit-' + field.tag + '-delete').removeClass('d-none')
                   $('#form_edit-' + field.tag + '-delete').attr('onclick', 'deleteContactFieldFile(' + field.id + ', "' + field.tag + '")')
               } else {
                   $('#form_edit-' + field.tag).val(field.field_value)
               }
               if (field.field_type == 'datetime') {
                   $('#form_edit-' + field.tag).flatpickr({
                       enableTime: true,
                       altInput: true,
                       defaultDate: field.value,
                       dateFormat: "Y-m-d H:i",
                   })
               }
           });
        });
    })

    $("#edit-contactwizard").bootstrapWizard({
        onTabShow: function (t, r, a) {
            var o = ((a + 1) / r.find("li").length) * 100;
            $("#edit-contactwizard")
                .find(".bar")
                .css({ width: o + "%" });
        },
    });

    /**
         * updating contact ajax+validation
         */
    $("#form_edit").parsley().on("field:validated", function () {
        var e = 0 === $(".parsley-error").length;
        $("#form_edit .alert-info").toggleClass("d-none", !e), $("#form_edit .alert-warning").toggleClass("d-none", e);
    }).on("submit", function () {
        return !1;
    });
    $('#form_edit').submit(function (e) {
        e.preventDefault();

        cleanErrorsInForm('form_edit', form_edit_errors)

        var currentUrl = window.location.href;
        var urlTable = currentUrl.split('/');
        var page_name;
        if (typeof urlTable[4] !== 'undefined') {
            page_name = 'page_view';
        } else page_name = 'page_list';

        $.ajax({
            type: "POST",
            url: route('contacts.update', page_name),
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                //$('#form_edit')[0].reset();
                console.log(response)
                $('#edit-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                console.log(page_name)
                setTimeout(function () {
                    if (page_name == 'page_list') {
                        var contact = response.contact;
                        $('#contactid' + contact.id + ' td:nth-child(2)').html(contact.account_id)
                        var html;

                        if (contact.class == 1)
                            html = '<span class="badge bg-blue text-light">Person</span>'
                        else if (contact.class == 2)
                            html = '<span class="badge bg-success">Company</span>'
                        $('#contactid' + contact.id + ' td:nth-child(3)').html(html)

                        if (contact.source == 1)
                            html = '<span class="badge label-table bg-danger">Telephone prospecting</span>'
                        else if (contact.source == 2)
                            html = '<span class="badge bg-warning">Landing pages</span>'
                        else if (contact.source == 3)
                            html = '<span class="badge bg-success">Affiliation</span>'
                        else if (contact.source == 4)
                            html = '<span class="badge bg-blue text-light">Database purchased</span>'
                        $('#contactid' + contact.id + ' td:nth-child(4)').html(html)

                        if (contact.status == 1)
                            html = '<span class="badge label-table bg-success">Lead</span>'
                        else if (contact.status == 2)
                            html = '<span class="badge bg-blue text-light">Customer</span>'
                        else if (contact.status == 3)
                            html = '<span class="badge bg-secondary">Not interested</span>'
                        else if (contact.status == 4)
                            html = '<span class="badge bg-danger">Disabled</span>'
                        $('#contactid' + contact.id + ' td:nth-child(6)').html(html)
                        
                        $('#contactid' + contact.id + ' td:nth-child(7)').html(contact.source_id)

                    } else if (page_name == 'page_view') {
                        if (response.contact.class == 1)
                            $('#contacts_person-info-card').html(response.html);
                        else if (response.contact.class == 2)
                            $('#contacts_companie-info-card').html(response.html);
                    }
                }, 1500);
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while updating that contact", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    form_edit_errors = error.responseJSON.errors
                    laravelValidation('form_edit', error.responseJSON.errors)
                }
            }
        });
    });
});
