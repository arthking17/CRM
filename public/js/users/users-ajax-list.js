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
                        $('#edit-' + id).addClass('disabled');
                        $('#delete-' + id).text('Active');
                        $('#delete-' + id).attr("onclick", "restoreUser(" + id + ")");
                        $('#userid' + id + ' td:nth-child(6)').html('<span class="badge label-table bg-danger">Disabled</span>')
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
                        $('#edit-' + id).removeClass('disabled');
                        $('#delete-' + id).text('Disable');
                        $('#delete-' + id).attr("onclick", "deleteUser(" + id + ")");
                        $('#userid' + id + ' td:nth-child(6)').html('<span class="badge bg-success">Active</span>')
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
    $.get('/users/get/' + id, function (data) {
        /*old_id = $('#user-info1 p:nth-of-type(3)').text()
        $('#userid'+old_id).toggleClass('selected')
        $('#userid'+id).toggleClass('selected')*/
        $('#user-photo').attr("src", url_photo + "/" + data.user.photo);
        $('#user-info1 h4:nth-of-type(1)').text(data.user.username)
        $('#user-info1 p:nth-of-type(1)').text(data.user.login)
        $('#user-info1 p:nth-of-type(2)').html('<i class="mdi mdi-office-building"></i> ' + data.user.account_id)
        $('#user-info1 a:nth-of-type(4)').attr('onClick', 'editUser(' + id + ');')
        if (data.user.role == 1)
            $('#user-info2 p:nth-of-type(1)').html('<span class="badge label-table bg-danger">Admin</span>')
        if (data.user.role == 2)
            $('#user-info2 p:nth-of-type(1)').html('<span class="badge bg-success">User</span>')
        if (data.user.role == 3)
            $('#user-info2 p:nth-of-type(1)').html('<span class="badge bg-blue text-light">Visitor</span>')
        $('#user-info2 p:nth-of-type(2)').text(data.user.language)
        $('#user-info2 p:nth-of-type(3)').text(data.user.timezone)
        $('#user-info2 p:nth-of-type(4)').text(data.user.browser)
        $('#user-info2 p:nth-of-type(5)').text(data.user.ip_address)
        if (data.user.status == 0) {
            $('#user-info2 p:nth-of-type(6)').html('<span class="badge label-table bg-danger">Disabled</span>')
            $('#user-info1 a:nth-of-type(4)').attr('data-bs-toggle', '')
            $('#user-info1 a:nth-of-type(4)').attr('onClick', '')
        } else {
            $('#user-info2 p:nth-of-type(6)').html('<span class="badge bg-success">Active</span>')
            $('#user-info1 a:nth-of-type(4)').attr('data-bs-toggle', 'modal')
            $('#user-info1 a:nth-of-type(4)').attr('onClick', 'editUser(' + id + ');')
        }
        $('#user-info2 p:nth-of-type(7)').text(data.user.last_auth)
        $('#user-info2 a:nth-of-type(1)').attr('data-bs-target', '#logs-modal-' + id)
        $('#user-info2 a:nth-of-type(2)').attr('data-bs-target', '#users_permissions-modal-' + id)
        $('#card-note a:nth-of-type(1)').attr('data-id', id)
        if (data.notes.length)
            $('#card-note-body p:nth-of-type(1)').text(data.notes[0].content)
        else
            $('#card-note-body p:nth-of-type(1)').text('empty')


    })
}
function editUser(id) {
    $.get('/users/get/' + id, function (user) {
        $('#id').val(id)
        $('#username').val(user.username)
        $('#login').val(user.login)
        $('#role').val(user.role)
        $('#language').val(user.language)
        $('#account_id').val(user.account_id)
        console.log(url_photo + '/' + user.photo)
        $('#photo').attr('data-default-file', url_photo + '/' + user.photo)
        $('#photo').dropify({
            defaultFile: url_photo + '/' + user.photo
        });
    })
}

$(document).ready(function () {
    /**
     * datatable js init
     */
    $("#basic-datatable").DataTable({
        language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
    });
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
    $("#selection-datatable").DataTable({
        select: { style: "multi" },
        language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
    }),
        $("#key-datatable").DataTable({
            keys: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
        a.buttons().container().appendTo("#datatable-users_wrapper .col-md-6:eq(0)"),
        $("#alternative-page-datatable").DataTable({
            pagingType: "full_numbers",
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
        $("#scroll-vertical-datatable").DataTable({
            scrollY: "350px",
            scrollCollapse: !0,
            paging: !1,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
        $("#scroll-horizontal-datatable").DataTable({
            scrollX: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
        $("#complex-header-datatable").DataTable({
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
            columnDefs: [{ visible: !1, targets: -1 }],
        }),
        $("#row-callback-datatable").DataTable({
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
            createdRow: function (a, e, t) {
                15e4 < +e[5].replace(/[\$,]/g, "") && $("td", a).eq(5).addClass("text-danger");
            },
        }),
        $(".users-state-datatable").DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        }),
        $(".dataTables_length select").addClass("form-select form-select-sm"),
        $(".dataTables_length select").removeClass("custom-select custom-select-sm"),
        $(".dataTables_length label").addClass("form-label");

    /* $('#datatable-users').dataTable( {
         paging: false,
         destroy: true,
         searching: false
     } );
    a.columns().every(function () {
        var column = this;
        var select = $('<select class="form-select form-select-sm"><option value=""></option></select>')
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
    });*/
    // Setup - add a text input to each footer cell
    $('#datatable-users tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input class="form-control form-control-sm" type="text" placeholder="Search ' + title + '" />');
    });
    $('.disabled').each(function () {
        $(this).html('');
    })
    // DataTable filter
    a.columns('.select-filter').every(function () {
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
                Swal.fire({ position: "top-end", icon: "success", title: response.message, showConfirmButton: !1, timer: 1500 });
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
                $('#datatable-users>tbody').prepend(newRow);
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
            }
        });
    });

    $('#edit-user').submit(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        e.preventDefault();
        $.ajax({
            type: "PUT",
            url: route('user.update', $('#id').val()),
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(response)
                Swal.fire({ position: "top-end", icon: "success", title: response[2], showConfirmButton: !1, timer: 1500 });
                //setTimeout(function () { window.location.href = route('accounts'); }, 1500);
                $('#edit-modal').modal('toggle')
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while saving that user", showConfirmButton: !1, timer: 1500 });
                $.each(error.responseJSON.errors, function (prefix, val) {
                    //$('#accid' + response.id + ' td:nth-child(2)').text(response.url)
                    if ($('#' + prefix).hasClass('parsley-success'))
                        $('#' + prefix).removeClass('parsley-success')
                    if ($('#' + prefix).hasClass('parsley-error'))
                        $('#' + prefix).removeClass('parsley-error')
                    if ($('#error-' + prefix).length)
                        $('#error-' + prefix).remove()
                    $('#div-' + prefix).append("<ul class=\"parsley-errors-list filled\" id=\"error-" + prefix + "\" aria-hidden=\"false\">" +
                        "<li class=\"parsley-required\">" + val[0] + "</li></ul>")
                    $('#' + prefix).addClass('parsley-error')
                })
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
                console.log("test : " + formData)
                console.log(response)
                $('#add_note-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.message, showConfirmButton: !1, timer: 1500 });
                $('#create-note')[0].reset();
            },
            error: function (error) {
                console.log("test : " + formData)
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that note", showConfirmButton: !1, timer: 1500 });
            }
        });
    })

    function fetch_data(page, sort_type = null, sort_by = null, query = null) {
        $.ajax({
            url: "/users/pagination/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&query=" + query,
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

    $(document).on('keyup', '#view-grid-search', function () {
        var query = $('#view-grid-search').val();
        var column_name = $('#view-grid-sort').val();
        var sort_type = 'asc';
        var page = $('#hidden_page').val();
        fetch_data(page, sort_type, column_name, query);
    });

    $('.view-grid-page-item').on('click', function () {
        if (!$(this).hasClass('active')) {
            $('.view-grid-page-item.active').removeClass('active')
            $(this).addClass('active')
            page = $(this).attr('id').substr(4)
            if (page == "1") {
                $('#view-grid-paginate_button').addClass('disabled')
            } else {
                $('#view-grid-paginate_button').removeClass('disabled')
            }
            fetch_data(page, 'asc', $('#view-grid-sort').val(), $('#view-grid-search').val())
        }
    })
})