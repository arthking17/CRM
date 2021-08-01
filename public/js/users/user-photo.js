var updateUserPhoto = function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: route('user.photo.update'),
        data: new FormData($('#form-edit-user-photo')[0]),
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
            console.log(response)
            Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
            var image = document.getElementById('user-photo');
            image.src = URL.createObjectURL(e.target.files[0]);
            if (typeof response.user.id !== 'undefined')
                $('#userid' + response.user.id + ' td:nth-of-type(4)').html('<img class="img-fluid avatar-sm rounded" src="' + url_photo + '/' + response.user.photo + '" />')
        },
        error: function(error) {
            console.log(error)
            if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined' && typeof error.responseJSON.errors.photo !== 'undefined') {
                Swal.fire({ position: "top-end", icon: "error", title: error.responseJSON.errors.photo[0], showConfirmButton: !1, timer: 1500 });
            } else
                Swal.fire({ position: "top-end", icon: "error", title: "Error while saving that user photo", showConfirmButton: !1, timer: 1500 });
        }
    });
};
var updateUserPhotoImg = function(e) {
    src = e.target.files[0].name
    var fileExtension = src.split('.').pop();
    if (fileExtension == 'jpg' || fileExtension == 'png' || fileExtension == 'jpeg') {
        var image = document.getElementById('edit-user-photo-img');
        image.src = URL.createObjectURL(e.target.files[0]);
    } else {
        Swal.fire({ position: "top-end", icon: "error", title: "The photo must be a file of type: jpg, png, jpeg.", showConfirmButton: !1, timer: 1500 });
    }
}