$(document).ready(function () {
    /**
     * datatable js init
     */
    dataTableCustomFields = $('#datatable-users_permissions').DataTable({
        stateSave: !1,
        "pageLength": 10,
        language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
    }),
        $('#datatable-users_permissions tfoot th').each(function () {
            if (!$(this).hasClass('disabled')) {
                var title = $(this).text();
                $(this).html('<input class="form-control form-control-sm users_permissions" type="text" placeholder="Search ' + title + '" />');
            }
        });
    dataTableCustomFields.columns().every(function () {
        var that = this;

        $('.users_permissions', this.footer()).on('keyup change clear', function () {
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

    $('#btn-create_permissions').on('click', function () {
        cleanErrorsInForm('create-permissions', create_permission_errors)
        create_permission_errors = null
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
                console.log(response)
                $('#create-permission-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#create-permissions')[0].reset();
                viewUsers_Permissions(response.user_id)
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that permission", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    create_permission_errors = error.responseJSON.errors
                    laravelValidation('create-permissions', error.responseJSON.errors)
                }
            }
        });
    })
})

function viewDatatableUsers_Permissions(id) {
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

function viewFormCreatePermission(id, username) {
    $('#create-permissions-user_id').val(id)
    $('#create-permissions-username').val(username)
}

function deleteUsers_Permission(user_id, code) {
    Swal.fire({ title: "Are you sure?", text: "This user permission will be disabled!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function (e) {
            e.value ?
                $.ajax({
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
                }) :
                e.dismiss === Swal.DismissReason.cancel && Swal.fire({ title: "Cancelled", text: "Operation canceled :)", icon: "error", confirmButtonColor: "#4a4fea" });
        }
    );
}

function viewUsers_Permissions(user_id) {

    $.get('/users/permissions/get/' + user_id + '/0', function (data) {
        $('#user-permissions-info-card').empty().html(data);
    })
}

function saveUserPermissions(user_id, element) {

}
function updatePermissions() {
    var user_id = $('#user_id').html();
    elements = ['accounts', 'appointments', 'communications', 'contact_data', 'contacts', 'contacts_companies', 'contacts_field', 'contacts_persons', 'custom_field', 'email_accounts', 'fax_accounts', 'groups', 'imports', 'logs', 'notes', 'sip_accounts', 'sms_accounts', 'users', 'users_permissions', 'shortcodes'];
    codes = ['show', 'create', 'update', 'delete'];
    elements.forEach(element => {
        codes.forEach(code => {
            //console.log('#permissions-'+element+'-'+code)
            console.log($('#permissions-'+element+'-'+code).val())
        });
    });
}