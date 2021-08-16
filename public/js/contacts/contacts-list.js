$(document).ready(function() {
    tippy('[title]', {
        // change these to your liking
        arrow: true,
        placement: 'bottom', // top, right, bottom, left
        duration: [600, 300], //ms
        distance: 15, //px or string
        maxWidth: 300, //px or string
        animation: 'perspective',
        // leave these as they are
        allowHTML: true,
        theme: 'custom',
        ignoreAttributes: true,
        content(reference) {
            const title = reference.getAttribute('title');
            reference.removeAttribute('title');
            return title;
        },
    });
})

function viewInfoCardContact(id, type) {
    $.get('/contacts/get/' + id + '/0', function(response) {
        console.log(response)
        try {
            if (type == 1) {
                if (!$('#contacts_companie-info-card').hasClass('d-none')) {
                    $('#contacts_companie-info-card').addClass('d-none')
                    $('#contacts_person-info-card').removeClass('d-none')
                }
                $('#contacts_person-info-card').empty().html(response.html);
            } else if (type == 2) {
                if (!$('#contacts_person-info-card').hasClass('d-none')) {
                    $('#contacts_person-info-card').addClass('d-none')
                    $('#contacts_companie-info-card').removeClass('d-none')
                }
                $('#contacts_companie-info-card').empty().html(response.html);
            }
            tippy('[title]', {
                // change these to your liking
                arrow: true,
                placement: 'bottom', // top, right, bottom, left
                duration: [600, 300], //ms
                distance: 15, //px or string
                maxWidth: 300, //px or string
                animation: 'perspective',
                // leave these as they are
                allowHTML: true,
                theme: 'custom',
                ignoreAttributes: true,
                content(reference) {
                    const title = reference.getAttribute('title');
                    reference.removeAttribute('title');
                    return title;
                },
            });
        } catch (e) {
            Swal.fire({ icon: "error", title: 'error !!!', showConfirmButton: !1, timer: 1500 });
        }
    }).fail(function() {
        Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
    })
}

function viewContact(id, type) {
    $.get('/contacts/get/' + id + '/0', function(response) {
        console.log(response)
        try {
            if (type == 1) {
                $('#contacts_info_not_found').addClass('d-none')
                $('#contacts_companie-info-card').addClass('d-none')
                $('#contacts_person-info-card').removeClass('d-none')

                $('#contacts_person-info-card').empty().html(response.html);
            } else if (type == 2) {
                $('#contacts_info_not_found').addClass('d-none')
                $('#contacts_person-info-card').addClass('d-none')
                $('#contacts_companie-info-card').removeClass('d-none')

                $('#contacts_companie-info-card').empty().html(response.html);
            }
            tippy('[title]', {
                // change these to your liking
                arrow: true,
                placement: 'bottom', // top, right, bottom, left
                duration: [600, 300], //ms
                distance: 15, //px or string
                maxWidth: 300, //px or string
                animation: 'perspective',
                // leave these as they are
                allowHTML: true,
                theme: 'custom',
                ignoreAttributes: true,
                content(reference) {
                    const title = reference.getAttribute('title');
                    reference.removeAttribute('title');
                    return title;
                },
            });
            viewNotes(id, response.elementClass)
        } catch (e) {
            Swal.fire({ icon: "error", title: 'error !!!', showConfirmButton: !1, timer: 1500 });
            $('#contacts_info_not_found').removeClass('d-none')
            $('#contacts_person-info-card').addClass('d-none')
            $('#contacts_companie-info-card').addClass('d-none')
        }
    }).fail(function(error) {
        console.log(error)
        Swal.fire({ icon: "error", title: 'error !!!', showConfirmButton: !1, timer: 1500 });
        $('#contacts_info_not_found').removeClass('d-none')
        $('#contacts_person-info-card').addClass('d-none')
        $('#contacts_companie-info-card').addClass('d-none')
    })
    viewContactData(id)
}

function editContact(id) {
    $.get('/contacts/get/' + id + '/1', function(data) {
        console.log(data)
        $('#form_edit-id').val(id)
        $('#form_edit-account_id').val(data.contact.account_id)
        $('#form_edit-class').val(data.contact.class)
        $('#form_edit-class-disabled').val(data.contact.class)
        $('#form_edit-source').val(data.contact.source)
        $('#form_edit-status').val(data.contact.status)
        $('#form_edit-source_id').val(data.contact.source_id)
        if (data.contact.class == 1) {
            $('#edit-nav-tab-info a:nth-of-type(1)').attr('href', '#edit-personcontact')
                //disable validation on companies contact tab
            $('#form_edit .companie-required').attr('required', false)
                //active validation on person contact tab
            $('#form_edit .person-required').attr('required', true)
            $('#form_edit-first_name').val(data.contact.first_name)
            $('#form_edit-nickname').val(data.contact.nickname)
            $('#form_edit-birthdate').flatpickr({
                altInput: true,
                defaultDate: data.contact.birthdate,
                dateFormat: "Y-m-d",
            })
            $('#form_edit-person_country').val(data.contact.country)
            $('#form_edit-last_name').val(data.contact.last_name)
            $('#form_edit-profile').val(data.contact.profile)
            $('#form_edit-gender').val(data.contact.gender)
            $('#form_edit-person_language').val(data.contact.language)
        } else if (data.contact.class == 2) {
            $('#edit-nav-tab-info a:nth-of-type(1)').attr('href', '#edit-companiescontact')
                //active validation on companies contact tab
            $('#form_edit .companie-required').attr('required', true)
                //disable validation on person contact tab
            $('#form_edit .person-required').attr('required', false)
            $('#form_edit-companies_country').val(data.contact.country)
            $('#form_edit-name').val(data.contact.name)
            $('#form_edit-companies_class').val(data.contact.companies_class)
            $('#form_edit-registered_number').val(data.contact.registered_number)
            $('#form_edit-companies_language').val(data.contact.language)
            $('#form_edit-activity').val(data.contact.activity)
            if (data.contact.logo != null)
                $('#form_edit-logo-img').attr('src', url_logo + '/' + data.contact.logo)
            else
                $('#form_edit-logo-img').attr('src', url_logo + '/image-not-found.png')
        }
        //custom field
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

        $('#btn-delete').attr('onClick', 'deleteContact(' + id + ');')
    })
}

function deleteContact(id) {
    Swal.fire({ title: "Are you sure?", text: "This contact will be disabled!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function(e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('contacts.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        //$('#edit-modal').modal('toggle')
                        if ($('#edit-modal').is(':visible')) {
                            $('#edit-modal').modal('toggle')
                        }
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                        $('#contacts-result').html(response.html);

                        $.getScript(url_jsfile + "/datatable-contacts.init.js")
                            .done(function(script, textStatus) {
                                console.log(textStatus);
                            })
                            .fail(function(jqxhr, settings, exception) {
                                console.log("Triggered ajaxError handler.");
                            });
                        $('#btn-edit').addClass('disabled');
                        $('#btn-delete').addClass('disabled');
                        //person
                        $('#contacts-person-info1 a:nth-of-type(4)').attr('data-bs-toggle', '')
                        $('#contacts-person-info1 a:nth-of-type(4)').attr('onClick', '')
                        $('#contacts-person-info1 a:nth-of-type(5)').attr('onClick', '')
                            //companie
                        $('#contacts-companie-info1 a:nth-of-type(4)').attr('data-bs-toggle', '')
                        $('#contacts-companie-info1 a:nth-of-type(4)').attr('onClick', '')
                        $('#contacts-companie-info1 a:nth-of-type(5)').attr('onClick', '')
                    },
                    error: function(error) {
                        console.log(error)
                        Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
                    }
                }) :
                e.dismiss === Swal.DismissReason.cancel && Swal.fire({ title: "Cancelled", text: "Operation canceled :)", icon: "error", confirmButtonColor: "#4a4fea" });
        }
    );
}

function viewFormCreateAppointment(contact_id, user_id) {
    $('#create-appointment-contact_id').val(contact_id)
    $('#create-appointment-user_id').val(user_id)
}