function deleteUser(id) {
    Swal.fire({ title: "Are you sure?", text: "This user will be disabled!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function(e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('user.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#edit-modal').modal('toggle')
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                        $('#btn-edit-' + id).addClass('disabled');
                        $('#btn-delete-' + id).text('Active');
                        $('#btn-delete-' + id).attr("onclick", "restoreUser(" + id + ")");
                        $('#userid' + id + ' td:nth-child(6)').html('<span class="badge label-table bg-danger">Disabled</span>')
                        $('#user-info2 p:nth-of-type(6)').html('<span class="badge label-table bg-danger">Disabled</span>')
                        $('#user-info1 a:nth-of-type(4)').attr('data-bs-toggle', '')
                        $('#user-info1 a:nth-of-type(4)').attr('onClick', '')
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

function restoreUser(id) {
    Swal.fire({ title: "Are you sure?", text: "This user will be actived !", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, restore it!" }).then(
        function(e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('user.restore', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#edit-modal').modal('toggle')
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                        $('#btn-edit-' + id).removeClass('disabled');
                        $('#btn-delete-' + id).text('Disable');
                        $('#btn-delete-' + id).attr("onclick", "deleteUser(" + id + ")");
                        $('#userid' + id + ' td:nth-child(6)').html('<span class="badge bg-success">Active</span>')
                        $('#user-info2 p:nth-of-type(6)').html('<span class="badge bg-success">Active</span>')
                        $('#user-info1 a:nth-of-type(4)').attr('data-bs-toggle', 'modal')
                        $('#user-info1 a:nth-of-type(4)').attr('onClick', 'editUser(' + id + ');')
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

function viewInfoCardUser(id) {
    $.get('/users/get/' + id + '/0', function(data) {
        $('#user-info-card').empty().html(data);
        tippy('[title]', {
            // change these to your liking
            arrow: true,
            placement: 'bottom', // top, right, bottom, left
            duration: [600, 300], //ms
            distance: 15, //px or string
            maxWidth: 300, //px or string
            animation: 'perspective',
            // leave these as they are
            allowHTML: true,
            theme: 'custom',
            ignoreAttributes: true,
            content(reference) {
                const title = reference.getAttribute('title');
                reference.removeAttribute('title');
                return title;
            },
        });
    })
}

function viewUser(id) {
    $.get('/users/get/' + id + '/0', function(data) {
        $('#user-info-card').empty().html(data.html);
        viewUsers_Permissions(id)
        viewLogsInCard(id)
        viewNotes(id, data.elementClass)
        tippy('[title]', {
            // change these to your liking
            arrow: true,
            placement: 'bottom', // top, right, bottom, left
            duration: [600, 300], //ms
            distance: 15, //px or string
            maxWidth: 300, //px or string
            animation: 'perspective',
            // leave these as they are
            allowHTML: true,
            theme: 'custom',
            ignoreAttributes: true,
            content(reference) {
                const title = reference.getAttribute('title');
                reference.removeAttribute('title');
                return title;
            },
        });
    })
}

function editUser(id) {
    $.get('/users/get/' + id + '/1', function(user) {
        $('#edit-user-id').val(id)
        $('#edit-user-username').val(user.username)
        $('#edit-user-login').val(user.login)
        $('#edit-user-role').val(user.role)
        $('#edit-user-language').val(user.language)
        $('#edit-user-account_id').val(user.account_id)
        $('#edit-user-photo').attr('data-default-file', url_photo + '/' + user.photo)
        $('.dropify').dropify();
        $('#btn-delete').attr('onClick', 'deleteUser(' + id + ');')
        $('#edit-user-photo-img').attr('src', url_photo + '/' + user.photo)
    })
}

$(document).ready(function() {
    /**
     * datatable js init
     */
    dataTableLogs = $("#datatable-logs").DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
        dataTableNotification = $("#datatable-notification").DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
        dataTableSecurity = $("#datatable-security").DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),

        $(".dataTables_length select").addClass("form-select form-select-sm"),
        $(".dataTables_length select").removeClass("custom-select custom-select-sm"),
        $(".dataTables_length label").addClass("form-label");
    // Setup - add a text input to each footer cell
    $('.disabled').each(function() {
        $(this).html('');
    })

    /**
     * end datatable js init
     */

    $('#btn-create').on('click', function() {
        cleanErrorsInForm('create-user', form_create_errors)
        form_create_errors = null
    })
    $('#btn-edit').on('click', function() {
        cleanErrorsInForm('edit-user', form_edit_errors)
        form_edit_errors = null
    })
    $('#create-user').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: route('user.create'),
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                $('#create-user')[0].reset()
                    //setTimeout(function () { window.location.href = route('accounts'); }, 1500);
                $('#create-modal').modal('toggle')

                showViewGrid('id', 'asc')

                showViewGrid()

                $('#view-list').html(response.html);
                $.getScript(url_jsfile + "/datatable-users.init.js")
                    .done(function(script, textStatus) {
                        console.log(textStatus);
                    })
                    .fail(function(jqxhr, settings, exception) {
                        console.log("Triggered ajaxError handler.");
                    });
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding this user", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON.errors !== 'undefined') {
                    form_create_errors = error.responseJSON.errors
                    laravelValidation('create-user', error.responseJSON.errors)
                }
            }
        });
    });

    $('#edit-user').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: route('user.update', $('#edit-user-id').val()),
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //setTimeout(function () { window.location.href = route('accounts'); }, 1500);
                $('#edit-modal').modal('toggle')
                $('#view-list').html(response.html);
                viewInfoCardUser(response.user.id)

                showViewGrid('id', 'asc')

                $.getScript(url_jsfile + "/datatable-users.init.js")
                    .done(function(script, textStatus) {
                        console.log(textStatus);
                    })
                    .fail(function(jqxhr, settings, exception) {
                        console.log("Triggered ajaxError handler.");
                    });
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while saving that user", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON.errors !== 'undefined') {
                    form_edit_errors = error.responseJSON.errors
                    laravelValidation('edit-user', error.responseJSON.errors)
                }
            }
        });
    });

    /**
     * tippy initialisation
     */
    tippy('[title]', {
        // change these to your liking
        arrow: true,
        placement: 'bottom', // top, right, bottom, left
        duration: [600, 300], //ms
        distance: 15, //px or string
        maxWidth: 300, //px or string
        animation: 'perspective',
        // leave these as they are
        allowHTML: true,
        theme: 'custom',
        ignoreAttributes: true,
        content(reference) {
            const title = reference.getAttribute('title');
            reference.removeAttribute('title');
            return title;
        },
    });
    /**
     * tippy initialisation end
     */
})


function viewLogs(id) {
    $.get('/users/logs/get/' + id + '/1', function(data) {
        dataTableLogs.destroy()
        $('#logs-div').empty().html(data);
        dataTableLogs = $('#datatable-logs').DataTable({
                stateSave: 0,
                language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                },
            }),
            $('#datatable-logs tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input class="form-control form-control-sm logs" type="text" placeholder="Search ' + title + '" />');
            });
        dataTableLogs.columns().every(function() {
            var that = this;

            $('.logs', this.footer()).on('keyup change clear', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
        dataTableLogs.columns().every(function() {
            var column = this;
            if ($(column.footer()).hasClass('select')) {
                var select = $('<select class="form-select"><option value=""></option></select>')
                    .appendTo($(column.footer()).empty())
                    .on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });
                column.data().unique().sort().each(function(d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            }
        });
        $('#logs-modal').modal('toggle')
    })
}

function viewNotification(id) {
    $.get('/users/notification/get/' + id, function(data) {
        dataTableNotification.destroy()
        $('#notification-div').empty().html(data);
        dataTableNotification = $('#datatable-notification').DataTable({
                stateSave: !0,
                language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                },
            }),
            $('#notification-modal').modal('toggle')
    })
}

function viewLogsInCard(id) {
    $.get('/users/logs/get/' + id + '/0', function(data) {
        $('#logs-info-card').empty().html(data);
    })
}