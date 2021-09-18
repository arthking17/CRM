function editAccount(id) {
    $.get('/accounts/' + id, function(account) {
        $('#edit-account-id').val(id)
        $('#edit-account-name').val(account.name)
        $('#edit-account-url').val(account.url)
        $('#edit-account-status').val(account.status)
    })
}
$(document).ready(function() {
    $('#btn-create').on('click', function() {
        cleanErrorsInForm('create-account', create_account_errors)
        create_account_errors = null
    })
    $('#btn-edit').on('click', function() {
        cleanErrorsInForm('edit-account', edit_account_errors)
        edit_account_errors = null
    })
    $('#create-account').submit(function(e) {
        e.preventDefault();
        formData = $('#create-account').serialize();

        $.ajax({
            type: "POST",
            url: route('account.create'),
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("test : " + formData)
                console.log(response)
                $('#create-account-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                $('#create-account')[0].reset();

                $('#view-list').html(response.html);
                $.getScript(url_jsfile + "/datatable-accounts.init.js")
                    .done(function(script, textStatus) {
                        console.log(textStatus);
                    })
                    .fail(function(jqxhr, settings, exception) {
                        console.log("Triggered ajaxError handler.");
                    });
            },
            error: function(error) {
                console.log("test : " + formData)
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that account", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    create_account_errors = error.responseJSON.errors
                    laravelValidation('create-account', error.responseJSON.errors)
                }
            }
        });
    })

    $('#edit-account').submit(function(e) {
        e.preventDefault();
        id = $('#id').val();
        console.log('id : ' + id)

        formData = $('#edit-account').serialize();

        console.log("test : " + formData)
        $.ajax({
            type: "PUT",
            url: route('account.update'),
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log(response)
                $('#edit-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                $('#view-list').html(response.html);
                $.getScript(url_jsfile + "/datatable-accounts.init.js")
                    .done(function(script, textStatus) {
                        console.log(textStatus);
                    })
                    .fail(function(jqxhr, settings, exception) {
                        console.log("Triggered ajaxError handler.");
                    });
                $('#edit-account')[0].reset();
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while saving that account", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    edit_account_errors = error.responseJSON.errors
                    laravelValidation('edit-account', error.responseJSON.errors)
                }
            }
        });
    });

});

function deleteAccount(id) {
    console.log("id : " + id)
    Swal.fire({ title: "Are you sure?", text: "You won't be able to revert this!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function(e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('account.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                        $('#view-list').html(response.html);
                        $.getScript(url_jsfile + "/datatable-accounts.init.js")
                            .done(function(script, textStatus) {
                                console.log(textStatus);
                            })
                            .fail(function(jqxhr, settings, exception) {
                                console.log("Triggered ajaxError handler.");
                            });
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