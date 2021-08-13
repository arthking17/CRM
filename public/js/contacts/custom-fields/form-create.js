$(document).ready(function() {
    $('#btn-create-custom-field').on('click', function() {
        cleanErrorsInForm('create-custom-field', errors_create_custom_field)
        errors_create_custom_field = null
    })


    $('#create-custom-field').submit(function(e) {
        e.preventDefault();
        cleanErrorsInForm('create-custom-field', errors_create_custom_field)
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
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that Custom Field", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    errors_create_custom_field = error.responseJSON.errors
                    laravelValidation('create-custom-field', error.responseJSON.errors)
                }
            }
        });
    });
});