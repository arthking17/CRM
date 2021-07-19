function deleteUser(id) {
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
                    error: function (error) {
                        console.log(error)
                        Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
                    }
                })
                : e.dismiss === Swal.DismissReason.cancel && Swal.fire({ title: "Cancelled", text: "Operation canceled :)", icon: "error", confirmButtonColor: "#4a4fea" });
        }
    );
}

function viewUser(id) {
    $.get('/users/get/' + id + '/0', function (data) {
        $('#user-info-card').empty().html(data);
    })
}
function editUser(id) {
    $.get('/users/get/' + id + '/1', function (user) {
        $('#edit-user-id').val(id)
        $('#edit-user-username').val(user.username)
        $('#edit-user-login').val(user.login)
        $('#edit-user-role').val(user.role)
        $('#edit-user-language').val(user.language)
        $('#edit-user-account_id').val(user.account_id)
        $('#edit-user-photo').attr('data-default-file', url_photo + '/' + user.photo)
        $('.dropify').dropify();
        $('#btn-delete').attr('onClick', 'deleteUser(' + id + ');')
    })
}

$(document).ready(function () {
    /**
     * datatable js init
     */
    var a = $("#datatable-users").DataTable({
        lengthChange: !1,
        buttons: [
            { extend: "copy", className: "btn-light" },
            { extend: "print", className: "btn-light" },
            { extend: "pdf", className: "btn-light" },
        ],
        language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
    });
    dataTableLogs = $("#datatable-logs").DataTable({
        stateSave: !0,
        language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
    }),
        dataTableUsers_Permissions = $("#datatable-users_permissions").DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
        dataTableNotification = $("#datatable-notification").DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
        dataTableSecurity = $("#datatable-security").DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
        dataTableNotes = $("#datatable-notes").DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
        $(".dataTables_length select").addClass("form-select form-select-sm"),
        $(".dataTables_length select").removeClass("custom-select custom-select-sm"),
        $(".dataTables_length label").addClass("form-label");
    // Setup - add a text input to each footer cell
    $('#datatable-users tfoot th').each(function () {
        if (!$(this).hasClass('select')) {
            var title = $(this).text();
            $(this).html('<input class="form-control form-control-sm" type="text" placeholder="Search ' + title + '" />');
        }
    });
    $('.disabled').each(function () {
        $(this).html('');
    })
    a.columns().every(function () {
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
            if ($(column.footer()).hasClass('account')) {
                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            } else {
                column.data().unique().sort().each(function (d, j) {
                    d = d.slice(d.indexOf(">") + 1, d.indexOf("<", 1))
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            }
        }
    });
    // DataTable filter
    a.columns('.text-filter').every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });

    /**
     * end datatable js init
     */

    $('#btn-create').on('click', function () {
        cleanErrorsInForm('create-user', form_create_errors)
        form_create_errors = null
    })
    $('#btn-edit').on('click', function () {
        cleanErrorsInForm('edit-user', form_edit_errors)
        form_edit_errors = null
    })
    $('#btn-create_permissions').on('click', function () {
        cleanErrorsInForm('create-permissions', create_permission_errors)
        create_permission_errors = null
    })
    $('#btn-create-note').on('click', function () {
        cleanErrorsInForm('create-note', create_note_errors)
        create_note_errors = null
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
                $('#create-user')[0].reset()
                //setTimeout(function () { window.location.href = route('accounts'); }, 1500);
                $('#create-modal').modal('toggle')
                newRow = '<tr id="userid' + response.user.id + '"><td>' + response.user.id + '</td><td>' + response.user.username + '</td>';
                if (response.user.role == 1)
                    newRow += '<td><span class="badge label-table bg-danger">Admin</span></td>';
                if (response.user.role == 2)
                    newRow += '<td><span class="badge bg-success">User</span></td>';
                if (response.user.role == 3)
                    newRow += '<td><span class="badge bg-blue text-light">Visitor</span></td>';
                newRow += '<td><img class="img-fluid avatar-sm rounded" src="' + url_photo + '/' + response.user.photo + '" /></td>';
                newRow += '<td>' + response.user.account_id + '</td>';
                if (response.user.status == 1)
                    newRow += '<td><span class="badge bg-success">Active</span></td>';
                if (response.user.status == 0)
                    newRow += '<td><span class="badge label-table bg-danger">Disabled</span></td>';
                newRow += '</tr>'
                //a.destroy()
                //a.rows.add(newRow).draw()
                //$('#datatable-users>tbody').prepend(newRow);
                //a = $('#datatable-users').DataTable()

                /*a.row.add({
                    "id": response.user.id,
                    "username": response.user.username,
                    "role": "Admin",
                    "photo": "Admin",
                    "account": response.user.account_id,
                    "status": response.user.status,
                }).draw();*/
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding this user", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON.errors !== 'undefined') {
                    form_create_errors = error.responseJSON.errors
                    laravelValidation('create-user', error.responseJSON.errors)
                }
            }
        });
    });

    $('#edit-user').submit(function (e) {
        e.preventDefault();
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

    $('#button-view-grid').on('click', function () {
        if ($('#view-grid').hasClass('d-none')) {
            $('#button-view-list').attr('class', 'btn btn-link text-dark')
            $('#button-view-grid').attr('class', 'btn btn-dark')
            $('#view-grid').removeClass('d-none')
            $('#view-list').addClass('d-none')
            //$('#datatable-users').addClass('d-none')
            //a.hide()
        }
    })
    $('#button-view-list').on('click', function () {
        if ($('#view-list').hasClass('d-none')) {
            $('#button-view-grid').attr('class', 'btn btn-link text-dark')
            $('#button-view-list').attr('class', 'btn btn-dark')
            $('#view-grid').addClass('d-none')
            $('#view-list').removeClass('d-none')
            //a.show()
            //$('#datatable-users').removeClass('d-none')
            /*var a = $("#datatable-users").DataTable({
                lengthChange: !1,
                buttons: [
                    { extend: "copy", className: "btn-light" },
                    { extend: "print", className: "btn-light" },
                    { extend: "pdf", className: "btn-light" },
                ],
                language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
                drawCallback: function () {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                },
            });*/
        }
    })
    $('#create-note').submit(function (e) {
        e.preventDefault();
        $("input[name=element_id]").val($('#card-note a:nth-of-type(1)').attr('data-id'));
        formData = $('#create-note').serialize();
        $.ajax({
            type: "POST",
            url: route('note.create'),
            data: formData,
            dataType: "json",
            success: function (response) {
                $('#add_note-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                $('#create-note')[0].reset();
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that note", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON.errors !== 'undefined') {
                    create_note_errors = error.responseJSON.errors
                    laravelValidation('create-note', error.responseJSON.errors)
                }
            }
        });
    })

    $('#create-permissions').submit(function (e) {
        e.preventDefault();
        formData = $('#create-permissions').serialize();
        $.ajax({
            type: "POST",
            url: route('users_permission.create'),
            data: formData,
            dataType: "json",
            success: function (response) {
                $('#add_permission-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                $('#create-permissions')[0].reset();
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that note", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON.errors !== 'undefined') {
                    create_permission_errors = error.responseJSON.errors
                    laravelValidation('create-permissions', error.responseJSON.errors)
                }
            }
        });
    })

    function fetch_data(sort_type = null, sort_by = null, query = null) {
        $.ajax({
            url: "/users/pagination/fetch_data?sortby=" + sort_by + "&sorttype=" + sort_type + "&query=" + query,
            success: function (data) {
                console.log(data)
                $('#view-grid-users').html('');
                $('#view-grid-users').html(data);
            },
            error: function (error) {
                console.log(error)
            }
        })
    }

    $('#view-grid-search').on('keyup', function () {
        var query = $('#view-grid-search').val();
        var column_name = $('#view-grid-sort').val();
        var sort_type = 'asc';
        //var page = $('#hidden_page').val();
        fetch_data(sort_type, column_name, query);
    });

    $('.view-grid-page-item').on('click', function () {
        if (!$(this).hasClass('active')) {
            visiblepageid = $('#activepage').val()
            $('#page' + visiblepageid).addClass('d-none')
            $('.view-grid-page-item.active').removeClass('active')
            $(this).addClass('active')
            page = $(this).attr('id').substr(6)
            $('#activepage').val(page)
            $('#page' + page).removeClass('d-none')
        }
    })
    $('.view-grid-nextpage').on('click', function () {
        visiblepageid = $('#activepage').val()
        if (visiblepageid < $('#numberofpage').val()) {
            $('#page' + visiblepageid).addClass('d-none')
            $('.view-grid-page-item.active').removeClass('active')
            page = parseInt(visiblepageid) + 1
            $('#pageno' + page).addClass('active')
            $('#activepage').val(page)
            $('#page' + page).removeClass('d-none')
        }
    })
    $('.view-grid-previouspage').on('click', function () {
        visiblepageid = $('#activepage').val()
        if (visiblepageid != 1) {
            $('#page' + visiblepageid).addClass('d-none')
            $('.view-grid-page-item.active').removeClass('active')
            page = parseInt(visiblepageid) - 1
            $('#pageno' + page).addClass('active')
            $('#activepage').val(page)
            $('#page' + page).removeClass('d-none')
        }

    })
})


function viewLogs(id) {
    $.get('/users/logs/get/' + id, function (data) {
        dataTableLogs.destroy()
        $('#logs-div').empty().html(data);
        dataTableLogs = $('#datatable-logs').DataTable({
            stateSave: 0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
            $('#datatable-logs tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<input class="form-control form-control-sm logs" type="text" placeholder="Search ' + title + '" />');
            });
        dataTableLogs.columns().every(function () {
            var that = this;

            $('.logs', this.footer()).on('keyup change clear', function () {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
        dataTableLogs.columns().every(function () {
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
                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            }
        });
        $('#logs-modal').modal('toggle')
    })
}
function viewUsers_Permissions(id) {
    $.get('/users/users_permissions/get/' + id, function (data) {
        dataTableUsers_Permissions.destroy()
        $('#users_permissions-div').empty().html(data);
        dataTableUsers_Permissions = $('#datatable-users_permissions').DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
            $('#users_permissions-modal').modal('toggle')
    })
}
function viewNotification(id) {
    $.get('/users/notification/get/' + id, function (data) {
        dataTableNotification.destroy()
        $('#notification-div').empty().html(data);
        dataTableNotification = $('#datatable-notification').DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
            $('#notification-modal').modal('toggle')
    })
}
function addPermission(id, username) {
    $('#create-permissions-user_id').val(id)
    $('#create-permissions-username').val(username)
}
function viewNotes(user_id) {
    $.get('/notes/get/' + user_id, function (data) {
        dataTableNotes.destroy()
        $('#notes-div').empty().html(data);
        dataTableNotes = $('#datatable-notes').DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
            $('#notes-modal').modal('toggle')
    })
}
function deleteUsers_Permission(user_id, code) {
    Swal.fire({ title: "Are you sure?", text: "This user permission will be disabled!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function (e) {
            e.value
                ? $.ajax({
                    type: "DELETE",
                    url: route('users_permission.delete', { 'user_id': user_id, 'code': code }),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        code = response.users_permission.code.replace('.', '')
                        $('#user_permission-' + code + ' td:nth-child(4)').html('<span class="badge label-table bg-danger">Disabled</span>')
                        $('#user_permission-' + code + ' td:nth-child(5)').html('<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>')
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    },
                    error: function (error) {
                        console.log(error)
                        Swal.fire({ icon: "error", title: "Error while deleting permission", showConfirmButton: !1, timer: 1500 });
                    }
                })
                : e.dismiss === Swal.DismissReason.cancel && Swal.fire({ title: "Cancelled", text: "Operation canceled :)", icon: "error", confirmButtonColor: "#4a4fea" });
        }
    );
}