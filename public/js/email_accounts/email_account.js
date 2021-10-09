$(document).ready(function () {
    $('#btn-edit-email-account').on('click', function () {
        cleanErrorsInForm('edit-email-account', edit_email_account_errors)
        edit_email_account_errors = null
    });

    $('#btn-create-email-account').on('click', function () {
        cleanErrorsInForm('create-email-account', create_email_account_errors)
        create_email_account_errors = null
    });

    $('#create-email-account').submit(function (e) {
        e.preventDefault();
        cleanErrorsInForm('create-email-account', create_email_account_errors)
        $.ajax({
            type: "POST",
            url: route('email_accounts.create'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(response)
                $('#create-email_account-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#create-email-account')[0].reset();
                setTimeout(function () {
                    $('#list-email_accounts').html(response.html);
                    $.getScript(url_jsfile_email_accounts + "/datatable-email_accounts.init.js")
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
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that email-account", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    create_email_account_errors = error.responseJSON.errors
                    laravelValidation('create-email-account', error.responseJSON.errors)
                }
            }
        });
    });
    $('#edit-email-account').submit(function (e) {
        e.preventDefault();
        cleanErrorsInForm('edit-email-account', edit_email_account_errors)
        $.ajax({
            type: "POST",
            url: route('email_accounts.update'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(response)
                $('#edit-email_account-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#edit-email-account')[0].reset();
                setTimeout(function () {
                    $('#list-email_accounts').html(response.html);
                    $.getScript(url_jsfile_email_accounts + "/datatable-email_accounts.init.js")
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
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that email-account", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    edit_email_account_errors = error.responseJSON.errors
                    laravelValidation('edit-email-account', error.responseJSON.errors)
                }
            }
        });
    });
});



function editEmailAccount(id) {
    $.get(route('email_accounts.get', id), function (data) {
        console.log(data)
        $('#edit-email-account-id').val(id)
        $('#edit-email-account-account_id').val(data.email_account.account_id)
        $('#edit-email-account-host').val(data.email_account.host)
        $('#edit-email-account-email').val(data.email_account.email)
        $('#edit-email-account-username').val(data.email_account.username)
        $('#edit-email-account-smtpauth').val(data.email_account.smtpauth)
        $('#edit-email-account-smtpsecure').val(data.email_account.smtpsecure)
        $('#edit-email-account-type').val(data.email_account.type)
        $('#edit-email-account-port').val(data.email_account.port)
    })
}

function deleteEmailAccount(id) {
    Swal.fire({ title: "Are you sure?", text: "This Email Account will be remove!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function (e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('email_accounts.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                        setTimeout(function () {
                            $('#email_accountid' + id + ' td:nth-child(11)').html('<span class="badge bg-danger">Disabled</span>')
                            $('#email_accountid' + id + ' a:nth-child(1)').attr('onclick', '')
                            $('#email_accountid' + id + ' a:nth-child(1)').attr('data-bs-toggle', '')
                            $('#email_accountid' + id + ' a:nth-child(2)').attr('onclick', '')

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