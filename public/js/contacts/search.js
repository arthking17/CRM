$('#search-contact').submit(function (e) {
    e.preventDefault();
    cleanErrorsInForm('search-contact', upload_contact_errors)
    $.ajax({
        type: "POST",
        url: route('contacts.search'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        success: function (response) {
            console.log(response)
            Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
        },
        error: function (error) {
            console.log(error)
            Swal.fire({ position: "top-end", icon: "error", title: "Error while searching that contact file", showConfirmButton: !1, timer: 1500 });
            if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                upload_contact_errors = error.responseJSON.errors
                laravelValidation('search-contact', error.responseJSON.errors)
            }
        }
    });
});