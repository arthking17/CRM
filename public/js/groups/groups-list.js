function viewInfoCardGroup(id) {
    $.get('/users/groups/get/' + id + '/0', function(data) {
        $('#group-info-card').empty().html(data.html);
    })
}

function viewGroup(id) {
    $.get('/users/groups/get/' + id + '/0', function(data) {
        console.log(data)
        $('#group-info-card').empty().html(data.html);
        if (data.user_id != null)
            viewUsers_Permissions(data.user_id)
        else
            viewUsers_Permissions(-1)
    })
}

function editGroup(id) {
    $.get('/users/groups/get/' + id + '/1', function(group) {
        console.log(group)
        $('#edit-group-id').val(id)
        $('#edit-group-account_id').val(group.account_id)
        $('#edit-group-name').val(group.name)
            //$('#btn-delete').attr('onClick', 'deleteGroup(' + id + ');')
    })
}

function deleteGroup(id) {
    Swal.fire({ title: "Are you sure?", text: "This group will be disabled!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function(e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('users.groups.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        //$('#edit-modal').modal('toggle')
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                        $('#btn-edit').addClass('disabled');
                        $('#groupid' + id + ' td:nth-child(4)').html('<div class="text-sm-end">' +
                            '<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>' +
                            '<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a></div>');
                        /*$('#group-info1 a:nth-child(1)').attr('data-bs-toggle', '');
                        $('#group-info1 a:nth-child(1)').attr('onclick', '');
                        $('#group-info1 a:nth-child(2)').attr('onclick', '');*/
                        $('#edit-' + id).attr('data-bs-toggle', '');
                        $('#edit-' + id).attr('onclick', '');
                        $('#delete-' + id).attr('onclick', '');

                        $('#view-list').html(response.html);

                        $.getScript(url_jsfile + "/datatable-groups.init.js")
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