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
    viewNotes(id, 5)
    viewContactData(id)
}

function editContact(id) {
    $.get('/contacts/get/' + id + '/1', function(contact) {
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
            if (contact.logo != null)
                $('#form_edit-logo-img').attr('src', url_logo + '/' + contact.logo)
            else
                $('#form_edit-logo-img').attr('src', url_logo + '/image-not-found.png')
        }
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
                        $('#contact-info1 a:nth-of-type(4)').attr('data-bs-toggle', '')
                        $('#contact-info1 a:nth-of-type(4)').attr('onClick', '')
                        $('#contact-info1 a:nth-of-type(5)').attr('onClick', '')
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