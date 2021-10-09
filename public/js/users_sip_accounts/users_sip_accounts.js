$(document).ready(function () {
    $('#btn-edit-users_sip_account').on('click', function () {
        cleanErrorsInForm('edit-users_sip_account', edit_users_sip_account_errors)
        edit_users_sip_account_errors = null
    });

    $('#btn-create-users_sip_account').on('click', function () {
        cleanErrorsInForm('create-users_sip_account', create_users_sip_account_errors)
        create_users_sip_account_errors = null
    });

    $('#create-users_sip_account').submit(function (e) {
        e.preventDefault();
        cleanErrorsInForm('create-users_sip_account', create_users_sip_account_errors)
        $.ajax({
            type: "POST",
            url: route('users_sip_accounts.create'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(response)
                $('#create-users_sip_account-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#create-users_sip_account')[0].reset();
                setTimeout(function () {
                    $('#list-users_sip_accounts').html(response.html);
                    $.getScript(url_jsfile_users_sip_accounts + "/datatable-users_sip_accounts.init.js")
                        .done(function (script, textStatus) {
                            console.log(textStatus);
                        })
                        .fail(function (jqxhr, settings, exception) {
                            console.log("Triggered ajaxError handler.");
                        });
                }, 1500);
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that Users Sip Accounts", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    create_users_sip_account_errors = error.responseJSON.errors
                    laravelValidation('create-users_sip_account', error.responseJSON.errors)
                }
            }
        });
    });
    $('#edit-users_sip_account').submit(function (e) {
        e.preventDefault();
        cleanErrorsInForm('edit-users_sip_account', edit_users_sip_account_errors)
        $.ajax({
            type: "POST",
            url: route('users_sip_accounts.update'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(response)
                $('#edit-users_sip_account-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#edit-users_sip_account')[0].reset();
                var users_sip_account = response.users_sip_account;
                setTimeout(function () {
                    $('#users_sip_accountid' + users_sip_account.id + ' td:nth-child(2)').html(users_sip_account.user_id)
                    $('#users_sip_accountid' + users_sip_account.id + ' td:nth-child(3)').html(users_sip_account.sipaccount_id)
                }, 1500);
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that Users Sip Accounts", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    edit_users_sip_account_errors = error.responseJSON.errors
                    laravelValidation('edit-users_sip_account', error.responseJSON.errors)
                }
            }
        });
    });
});



function editUserSipAccount(id) {
    $.get(route('users_sip_accounts.get', id), function (data) {
        console.log(data)
        $('#edit-users_sip_account-id').val(id)
        $('#edit-users_sip_account-user_id').val(data.users_sip_account.user_id)
        $('#edit-users_sip_account-sipaccount_id').val(data.users_sip_account.sipaccount_id)
    })
}

function deleteUserSipAccount(id) {
    Swal.fire({ title: "Are you sure?", text: "This Users Sip Accounts will be remove!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function (e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('users_sip_accounts.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                        console.log(response)
                        setTimeout(function () {
                            $('#users_sip_accountid' + id + ' td:nth-child(5)').html(response.users_sip_accounts.end_date)
                            $('#users_sip_accountid' + id + ' td:nth-child(6)').html('<span class="badge bg-danger">Disabled</span>')
                            $('#users_sip_accountid' + id + ' a:nth-child(1)').attr('onclick', '')
                            $('#users_sip_accountid' + id + ' a:nth-child(1)').attr('data-bs-toggle', '')
                            $('#users_sip_accountid' + id + ' a:nth-child(2)').attr('onclick', '')

                            $('#edit-' + id).attr('onclick', '')
                            $('#edit-' + id).attr('data-bs-toggle', '')
                            $('#delete-' + id).attr('onclick', '')
                        }, 1500);
                    },
                    error: function (error) {
                        console.log(error)
                        Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
                    }
                }) :
                e.dismiss === Swal.DismissReason.cancel && Swal.fire({ title: "Cancelled", text: "Operation canceled :)", icon: "error", confirmButtonColor: "#4a4fea" });
        }
    );
}