$(document).ready(function () {

    $('#btn-edit-sip_account').on('click', function () {
        cleanErrorsInForm('edit-sip_account', edit_sip_account_errors)
        edit_sip_account_errors = null
    });

    $('#btn-create-sip_account').on('click', function () {
        cleanErrorsInForm('create-sip_account', create_sip_account_errors)
        create_sip_account_errors = null
    });
    /**
     * creating sip_account ajax + validation
     */
    $("#create-sip_account").parsley().on("field:validated", function () {
        var e = 0 === $(".parsley-error").length;
        $("#create-sip_account .alert-info").toggleClass("d-none", !e), $("#create-sip_account .alert-warning").toggleClass("d-none", e);
    }).on("submit", function () {
        return !1;
    });
});

$('#create-sip_account').submit(function (e) {
    e.preventDefault();
    cleanErrorsInForm('create-sip_account', create_sip_account_errors)
    $.ajax({
        type: "POST",
        url: route('sip_accounts.create'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        success: function (response) {
            console.log(response)
            $('#create-sip_account-modal').modal('toggle')
            Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
            //$('#create-sip_account')[0].reset();

            $('#view-list-sip_accounts').html(response.html);
            $.getScript(url_jsfile_sip_accounts + "/datatable-sipaccounts.init.js")
                .done(function (script, textStatus) {
                    console.log(textStatus);
                })
                .fail(function (jqxhr, settings, exception) {
                    console.log("Triggered ajaxError handler.");
                });

            viewSipAccount(response.sip_account.id)
        },
        error: function (error) {
            console.log(error)
            Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that SIP Account", showConfirmButton: !1, timer: 1500 });
            if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                create_sip_account_errors = error.responseJSON.errors
                laravelValidation('create-sip_account', error.responseJSON.errors)
            }
        }
    });
});
$('#edit-sip_account').submit(function (e) {
    e.preventDefault();
    cleanErrorsInForm('edit-sip_account', edit_sip_account_errors)
    $.ajax({
        type: "POST",
        url: route('sip_accounts.update'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        success: function (response) {
            console.log(response)
            $('#edit-sip_account-modal').modal('toggle')
            Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
            //$('#edit-sip_account')[0].reset();

            $('#view-list-sip_accounts').html(response.html);
            $.getScript(url_jsfile_sip_accounts + "/datatable-sipaccounts.init.js")
                .done(function (script, textStatus) {
                    console.log(textStatus);
                })
                .fail(function (jqxhr, settings, exception) {
                    console.log("Triggered ajaxError handler.");
                });

            viewSipAccount(response.sip_account.id)
        },
        error: function (error) {
            console.log(error)
            Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that SIP Account", showConfirmButton: !1, timer: 1500 });
            if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                edit_sip_account_errors = error.responseJSON.errors
                laravelValidation('edit-sip_account', error.responseJSON.errors)
            }
        }
    });
});

function editSipAccount(id) {
    $('#edit-sip_accounts-modal').modal('toggle')
    $.get(route('sip_accounts.get', id), function (data) {
        console.log(data)
        $('#edit-sip_account-id').val(id)
        $('#edit-sip_account-channel_id').val(data.sip_account.channel_id)
        $('#edit-sip_account-host').val(data.sip_account.host)
        $('#edit-sip_account-port').val(data.sip_account.port)
        $('#edit-sip_account-username').val(data.sip_account.username)
        $('#edit-sip_account-pwd').val(data.sip_account.pwd)
        $('#edit-sip_account-name').val(data.sip_account.name)
        $('#edit-sip_account-priority').val(data.sip_account.priority)
    })
}

function deleteSipAccount(id) {
    Swal.fire({ title: "Are you sure?", text: "This SIP Account will be remove!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function (e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('sip_accounts.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                        setTimeout(function () {
                            $('#sip_accountid' + id + ' td:nth-child(7)').html('<span class="badge bg-danger">Disabled</span>')
                            $('#sip_accountid' + id + ' a:nth-child(1)').attr('onclick', '')
                            $('#sip_accountid' + id + ' a:nth-child(1)').attr('data-bs-toggle', '')
                            $('#sip_accountid' + id + ' a:nth-child(2)').attr('onclick', '')

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

function viewSipAccount(id) {
    $.get(route('sip_accounts.show', id), function (response) {
        console.log(response)

        $('#datatable-sip_accounts tbody tr').removeClass('selected')
        $('#sip_accountid' + id).addClass('selected')

        try {
            $('#sip_accounts-info-card').empty().html(response.html);
        } catch (e) {
            Swal.fire({ icon: "error", title: 'error !!!', showConfirmButton: !1, timer: 1500 });
        }
    }).fail(function (error) {
        console.log(error)
        Swal.fire({ icon: "error", title: 'error !!!', showConfirmButton: !1, timer: 1500 });
    })
}

function viewListCallLogs() {
    $.get('/sip_accounts/calls/logs', function (data) {
        //console.log(data)
        if (typeof dataTableCustomFields !== 'undefined')
            dataTableCustomFields.destroy()
        $('#calls-logs-div').empty().html(data.html);
        dataTableCustomFields = $('#datatable-calls-logs').DataTable({
            stateSave: 0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
            $('#datatable-calls-logs tfoot th').each(function () {
                if (!$(this).hasClass('disabled')) {
                    var title = $(this).text();
                    $(this).html('<input class="form-control form-control-sm calls-logs" type="text" placeholder="Search ' + title + '" />');
                }
            });
        dataTableCustomFields.columns().every(function () {
            var that = this;

            $('.calls-logs', this.footer()).on('keyup change clear', function () {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
        dataTableCustomFields.columns().every(function () {
            var column = this;
            if ($(column.footer()).hasClass('select')) {
                var select = $('<select class="form-select"><option value=""></option></select>')
                    .appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });
                if ($(column.footer()).hasClass('with-span')) {
                    column.data().unique().sort().each(function (d, j) {
                        d = d.slice(d.indexOf(">") + 1, d.indexOf("<", 1))
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                } else {
                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                }
            }
        });
        $('#calls-logs-modal').modal('toggle')
    })
}