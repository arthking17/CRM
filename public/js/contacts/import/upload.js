$(document).ready(function() {
    $('#btn-upload').on('click', function() {
        cleanErrorsInForm('upload-contact', upload_contact_errors)
        upload_contact_errors = null
        cleanErrorsInForm('mapping-column', upload_contact_column_errors)
        upload_contact_column_errors = null
        $('#preview-list-contact-card').addClass('d-none')
    })
    $('#btn-import').on('click', function() {
        cleanErrorsInForm('upload-contact', upload_contact_errors)
        upload_contact_errors = null
        cleanErrorsInForm('mapping-column', upload_contact_column_errors)
        upload_contact_column_errors = null
    })

    $('#upload-contact').submit(function(e) {
        e.preventDefault();
        cleanErrorsInForm('upload-contact', upload_contact_errors)
        upload_contact_errors = null
        $.ajax({
            type: "POST",
            url: route('contacts.upload.preview'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                $('#preview-list-contact-card').removeClass('d-none')
                $('#preview-list-contact').empty().html(response.html);
                $.getScript(url_jsfile + "/datatable-contacts-preview.init.js")
                    .done(function(script, textStatus) {
                        console.log(textStatus);
                    })
                    .fail(function(jqxhr, settings, exception) {
                        console.log("Triggered ajaxError handler.");
                    });
                console.log(response.file_path)
                console.log(response.account_id)
                console.log(response.file_path)
                $('#mapping-column-file_path').val(response.file_path)
                $('#mapping-column-import_id').val(response.import.id)
                $('#mapping-column-account_id').val(response.account_id)

                $('#btn-import').html('import')
                $('#btn-import').removeClass('btn-warning').addClass('btn-success')
                $('#btn-import').attr('onclick', '')
                skipErrors = 0
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while uploading that contact file", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    upload_contact_errors = error.responseJSON.errors
                    laravelValidation('upload-contact', error.responseJSON.errors)
                }
            }
        });
    });

    $('#btn-import').on('click', function(e) {
        e.preventDefault();
        //console.log($('#mapping-column')[0])
        cleanErrorsInForm('mapping-column', upload_contact_column_errors)
        upload_contact_column_errors = null
        $.ajax({
            type: "POST",
            url: route('contacts.upload', skipErrors),
            data: new FormData($('#mapping-column')[0]),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                $('#import-success').removeClass('d-none')
                $('#import-errors').addClass('d-none')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                setTimeout(function() { window.location.href = route('contacts') }, 1500)
            },
            error: function(error) {
                console.log(error)
                    /*Swal.fire({ position: "top-end", icon: "error", title: "Error while uploading that contact file", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        upload_contact_column_errors = error.responseJSON.errors
                        laravelValidation('mapping-column', error.responseJSON.errors)
                    }*/
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    errors = error.responseJSON.errors
                    $('#import-errors').removeClass('d-none')
                    $('#import-success').addClass('d-none')
                    $('#import-errors p:nth-child(2)').empty()
                    for (i = 0; i < $('#rowCount').val(); i++) {
                        for (j = 0; j < $('#columnCount').val(); j++) {
                            $('#import-errors p:nth-child(2)').append(errors[i + '.' + j])
                        }
                    }
                    if ($('#import-errors p:nth-child(2)').html()) {
                        $('#btn-import').html('<i class="fe-alert-triangle"></i> Skip rows with errors and import')
                        $('#btn-import').removeClass('btn-success').addClass('btn-warning')
                        $('#btn-import').attr('onclick', skipErrorAndImport())
                    }
                    if (typeof error.responseJSON.message !== 'undefined')
                        Swal.fire({ position: "top-end", icon: "error", title: error.responseJSON.message, showConfirmButton: !1, timer: 1500 });
                    else
                        Swal.fire({ position: "top-end", icon: "error", title: error.responseJSON.errors, showConfirmButton: !1, timer: 1500 });
                } else {
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while uploading that contact file", showConfirmButton: !1, timer: 1500 });
                }
            }
        });
    });
});

function skipErrorAndImport() {
    skipErrors = 1
}