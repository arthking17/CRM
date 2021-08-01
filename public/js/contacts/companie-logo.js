var updateContactCompanieLogo = function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: route('contacts.logo.update'),
        data: new FormData($('#form-edit-contact-companie-logo')[0]),
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
            console.log(response)
            Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
            var image = document.getElementById('contact-companie-logo');
            image.src = URL.createObjectURL(e.target.files[0]);
        },
        error: function(error) {
            console.log(error)
            if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined' && typeof error.responseJSON.errors.logo !== 'undefined') {
                Swal.fire({ position: "top-end", icon: "error", title: error.responseJSON.errors.logo[0], showConfirmButton: !1, timer: 1500 });
            } else
                Swal.fire({ position: "top-end", icon: "error", title: "Failed to save that companie logo", showConfirmButton: !1, timer: 1500 });
        }
    });
};
var updateContactCompanieLogoImg = function(e) {
    src = e.target.files[0].name
    var fileExtension = src.split('.').pop();
    if (fileExtension == 'jpg' || fileExtension == 'png' || fileExtension == 'jpeg') {
        var image = document.getElementById('form_edit-logo-img');
        image.src = URL.createObjectURL(e.target.files[0]);
    } else {
        Swal.fire({ position: "top-end", icon: "error", title: "The logo must be a file of type: jpg, png, jpeg.", showConfirmButton: !1, timer: 1500 });
    }
}