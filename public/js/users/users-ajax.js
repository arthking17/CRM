$(document).ready(function () {
    $('#btn-create').on('click', function () {
        cleanErrorsInForm('create-user', create_user_errors)
        create_user_errors = null
    })
    $('#btn-edit').on('click', function () {
        cleanErrorsInForm('edit-user', edit_user_errors)
        edit_user_errors = null
    })

    $('#create-user').submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: route('user.create'),
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(response)
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                setTimeout(function () { window.location.href = route('users'); }, 1500);
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding this user", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON.errors !== 'undefined') {
                    create_user_errors = error.responseJSON.errors
                    laravelValidation('create-user', error.responseJSON.errors)
                }
            }
        });
    });
    $('#edit-user').submit(function (e) {
        e.preventDefault();
        formData = $('#edit-user').serialize();
        console.log($('#edit-user')[0])
        $.ajax({
            type: "POST",
            url: route('user.update', $('#edit-user-id').val()),
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //setTimeout(function () { window.location.href = route('accounts'); }, 1500);
                $('#edit-modal').modal('toggle')
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while saving that user", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON.errors !== 'undefined') {
                    form_edit_errors = error.responseJSON.errors
                    laravelValidation('edit-user', error.responseJSON.errors)
                }
            }
        });
    });
    /**/
    /*$('#edit-user').submit(function (e) {
        e.preventDefault();
        form = $('#edit-user')[0];
        console.log(form)
        photo = $('#photo')[0];
        photofile = photo.files[0];
        formData = $('#edit-user').serialize();
        formData1 = new FormData(this);
        console.log(formData)
        console.log($('[name="_token"]').val());
        //formData1.append('_token', $('[name="_token"]').val())
        //formData1.append('photo', photofile, photofile.name);
        console.log(formData1)
        $.ajax({
            type: "PUT",
            url: route('user.update', $('#edit-user-id').val()),
            data: formData,
            dataType: "json",
            processData: false,
            success: function (response) {
                console.log("test : " + formData)
                console.log(response)
                Swal.fire({ position: "top-end", icon: "success", title: response[2], showConfirmButton: !1, timer: 1500 });
                //setTimeout(function () { window.location.href = route('accounts'); }, 1500);
            },
            error: function (error) {
                console.log("test : " + formData)
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while saving that user", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON.errors !== 'undefined') {
                    edit_user_errors = error.responseJSON.errors
                    laravelValidation('edit-user', error.responseJSON.errors)
                }
            }
        });
    });*/
})
function deleteUser(id) {
    console.log("id : " + id)
    Swal.fire({ title: "Are you sure?", text: "This user will be disabled!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function (e) {
            e.value
                ? $.ajax({
                    type: "DELETE",
                    url: route('user.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                        setTimeout(function () { window.location.href = route('users'); }, 1500);
                    },
                    error: function (error) {
                        console.log(error)
                        Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
                    }
                })
                : e.dismiss === Swal.DismissReason.cancel && Swal.fire({ title: "Cancelled", text: "Operation canceled :)", icon: "error", confirmButtonColor: "#4a4fea" });
        }
    );
}
function restoreUser(id) {
    console.log("id : " + id)
    Swal.fire({ title: "Are you sure?", text: "This user will be actived !", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, restore it!" }).then(
        function (e) {
            e.value
                ? $.ajax({
                    type: "DELETE",
                    url: route('user.restore', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                        setTimeout(function () { window.location.href = route('users'); }, 1500);
                    },
                    error: function (error) {
                        console.log(error)
                        Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
                    }
                })
                : e.dismiss === Swal.DismissReason.cancel && Swal.fire({ title: "Cancelled", text: "Operation canceled :)", icon: "error", confirmButtonColor: "#4a4fea" });
        }
    );
}