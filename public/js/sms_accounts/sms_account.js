$(document).ready(function() {
    $('#btn-edit-sms_account').on('click', function() {
        cleanErrorsInForm('edit-sms_account', edit_sms_account_errors)
        edit_sms_account_errors = null
    });

    $('#btn-create-sms_account').on('click', function() {
        cleanErrorsInForm('create-sms_account', create_sms_account_errors)
        create_sms_account_errors = null
    });

    $('#create-sms_account').submit(function(e) {
        e.preventDefault();
        cleanErrorsInForm('create-sms_account', create_sms_account_errors)
        $.ajax({
            type: "POST",
            url: route('sms_accounts.create'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                $('#create-sms_account-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#create-sms_account')[0].reset();
                setTimeout(function() { 
                    $('#list-sms_accounts').html(response.html);
                    $.getScript(url_jsfile_sms_accounts + "/datatable-sms_accounts.init.js")
                        .done(function (script, textStatus) {
                            console.log(textStatus);
                        })
                        .fail(function (jqxhr, settings, exception) {
                            console.log("Triggered ajaxError handler.");
                        });
                 }, 1500);
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that SMS Account", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    create_sms_account_errors = error.responseJSON.errors
                    laravelValidation('create-sms_account', error.responseJSON.errors)
                }
            }
        });
    });
    $('#edit-sms_account').submit(function(e) {
        e.preventDefault();
        cleanErrorsInForm('edit-sms_account', edit_sms_account_errors)
        $.ajax({
            type: "POST",
            url: route('sms_accounts.update'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                $('#edit-sms_account-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#edit-sms_account')[0].reset();
                setTimeout(function() { 
                    $('#list-sms_accounts').html(response.html);
                    $.getScript(url_jsfile_sms_accounts + "/datatable-sms_accounts.init.js")
                        .done(function (script, textStatus) {
                            console.log(textStatus);
                        })
                        .fail(function (jqxhr, settings, exception) {
                            console.log("Triggered ajaxError handler.");
                        });
                 }, 1500);
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that SMS Account", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    edit_sms_account_errors = error.responseJSON.errors
                    laravelValidation('edit-sms_account', error.responseJSON.errors)
                }
            }
        });
    });
});



function editSMSAccount(id) {
    $.get('/sms_accounts/get/' + id, function(data) {
        console.log(data)
        $('#edit-sms_account-id').val(id)
        $('#edit-sms_account-name').val(data.sms_account.name)
        $('#edit-sms_account-username').val(data.sms_account.username)
    })
}

function deleteSMSAccount(id) {
    Swal.fire({ title: "Are you sure?", text: "This SMS Account will be remove!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function(e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('sms_accounts.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                        setTimeout(function () {
                            $('#sms_accountid' + id + ' td:nth-child(7)').html('<span class="badge bg-danger">Disabled</span>')
                            $('#sms_accountid' + id + ' a:nth-child(1)').attr('onclick', '')
                            $('#sms_accountid' + id + ' a:nth-child(1)').attr('data-bs-toggle', '')
                            $('#sms_accountid' + id + ' a:nth-child(2)').attr('onclick', '')

                            $('#edit-' + id).attr('onclick', '')
                            $('#edit-' + id).attr('data-bs-toggle', '')
                            $('#delete-' + id).attr('onclick', '')
                        }, 1500);
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