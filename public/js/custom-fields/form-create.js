$(document).ready(function() {
    $('#btn-create-custom-field').on('click', function() {
        cleanErrorsInForm('create-custom-field', create_custom_field_errors)
        create_custom_field_errors = null
    })


    $('#create-custom-field').submit(function(e) {
        e.preventDefault();
        cleanErrorsInForm('create-custom-field', create_custom_field_errors)
        $.ajax({
            type: "POST",
            url: route('custom-fields.create'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                $('#create-custom-field-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                $('#create-custom-field')[0].reset();

                setTimeout(function() { 
                    $('#list-custom_fields').html(response.html);
                    $.getScript(url_jsfile_custom_fields + "/datatable-custom_fields.init.js")
                        .done(function (script, textStatus) {
                            console.log(textStatus);
                        })
                        .fail(function (jqxhr, settings, exception) {
                            console.log("Triggered ajaxError handler.");
                        });
                 }, 1500);
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that Custom Field", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    create_custom_field_errors = error.responseJSON.errors
                    laravelValidation('create-custom-field', error.responseJSON.errors)
                }
            }
        });
    });
});