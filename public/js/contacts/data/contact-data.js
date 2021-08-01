function displayFormContactData(formId, id, contactClass, data = null) {
    $('#' + formId + '-element').val(5)
    $('#' + formId + '-element_id').val(id)
    $('#' + formId + '-class').val(contactClass)
    contactType = getContactTypeByClass(contactClass).replace('_', ' ')
    $('#' + formId + '-data').val(data)
    $('#' + formId + '  label:nth-child(1)').html(contactType + '<span class="text-danger">*</span>')
    if (formId == 'create-contact-data' || formId == 'edit-contact-data') {
        setPatternTypeByClass(formId + '-data', contactClass)
        $('#' + formId + '-data').attr('data-parsley-pattern-message', 'This value should be a valid ' + contactType + ' format')
        $('#' + formId + '-data').attr('placeholder', contactType + ' account name')
        setTypeInput(formId, formId + '-data', contactClass)
    } else if (formId == 'create-phone-data') {
        iti = setUpTypeInputFormCreate($("#create-phone-data-data"))
    } else if (formId == 'edit-phone-data') {
        edit_iti = setUpTypeInputFormEdit($("#edit-phone-data-data"))
    }
}

function resetFormPhoneData(input) {
    $('#error-' + input).remove()
    $('#' + input).removeClass("parsley-error");
    $('#' + input).removeClass("parsley-success");
}

function editContactData(id, formId) {
    $.get('/contacts/data/edit/' + id, function(contact_data) {
        console.log(contact_data)
        $('#' + formId + '-id').val(id)
        displayFormContactData(formId, contact_data.element_id, contact_data.class, contact_data.data)
    })
}

function viewContactData(id) {
    $.get('/contacts/data/get/' + id, function(contact_data) {
        if (contact_data.length) {
            $('#contact_data-info-card').empty().html(contact_data);
        }
    })
}

function deleteContactData(id) {
    Swal.fire({ title: "Are you sure?", text: "This contact Data will be permanently deleted!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function(e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('contacts.data.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                            //$('#edit-modal').modal('toggle')
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                        $.get('/contacts/data/get/' + response.contact_data.element_id, function(contact_data) {
                            if (contact_data.length) {
                                $('#contact_data-info-card').empty().html(contact_data);
                            }
                        })
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

$(document).ready(function() {
    $(function() {

        /**
         * creating contact ajax + validation
         */
        $('#create-contact-data').submit(function(e) {
            e.preventDefault();
            cleanErrorsInForm('create-contact-data', create_contact_data_errors)
            $.ajax({
                type: "POST",
                url: route('contacts.data.create'),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    console.log(response)
                    $('#create-contact-data-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    //$('#create-contact-data')[0].reset();
                    $.get('/contacts/data/get/' + response.contact_data.element_id, function(contact_data) {
                        if (contact_data.length) {
                            $('#contact_data-info-card').empty().html(contact_data);
                        }
                    })
                },
                error: function(error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that contact Data", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        create_contact_data_errors = error.responseJSON.errors
                        laravelValidation('create-contact-data', error.responseJSON.errors)
                    }
                }
            });
        });

        /**
         * updating contact ajax+validation
         */
        $('#edit-contact-data').submit(function(e) {
            e.preventDefault();
            cleanErrorsInForm('edit-contact-data', edit_contact_data_errors)
            $.ajax({
                type: "POST",
                url: route('contacts.data.update'),
                data: new FormData(this),
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    console.log(response)
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    $('#edit-contact-data-modal').modal('toggle')
                    $.get('/contacts/data/get/' + response.contact_data.element_id, function(contact_data) {
                        if (contact_data.length) {
                            $('#contact_data-info-card').empty().html(contact_data);
                        }
                    })
                },
                error: function(error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while updating that contact Data", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        edit_contact_data_errors = error.responseJSON.errors
                        laravelValidation('edit-contact-data', error.responseJSON.errors)
                    }
                }
            });
        });
    })
})