$(document).ready(function() {
    $('#edit-user-password').submit(function(e) {
        cleanErrorsInForm('edit-user-password', edit_password_errors)
        e.preventDefault();
        formData = $('#edit-user-password').serialize();
        $.ajax({
            type: "POST",
            url: route('password.update'),
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log(response)
                $('#security-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                $('#edit-user-password')[0].reset();
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while updating password", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON.errors !== 'undefined') {
                    edit_password_errors = error.responseJSON.errors
                    laravelValidation('edit-user-password', error.responseJSON.errors)
                }
            }
        });
    })
})