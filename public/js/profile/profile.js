$(document).ready(function() {
    $('#btn-profile-save').on('click', function() {
        cleanErrorsInForm('profile', profile_errors)
        profile_errors = null
    })
    $('#profile').submit(function(e) {
        e.preventDefault();
        formData = $('#profile').serialize();
        console.log($('#profile')[0])
        $.ajax({
            type: "POST",
            url: route('profile.update'),
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //setTimeout(function () { window.location.href = route('accounts'); }, 1500);
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while saving that user", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON.errors !== 'undefined') {
                    profile_errors = error.responseJSON.errors
                    laravelValidation('profile', error.responseJSON.errors)
                }
            }
        });
    });
});