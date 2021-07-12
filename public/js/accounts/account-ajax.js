function editAccount(id) {
    $.get('/accounts/' + id, function (account) {
        $('#id').val(id)
        $('#name').val(account.name)
        $('#url').val(account.url)
        $('#statuss').val(account.status)
    })
}
$(document).ready(function () {
    $('#create-account').submit(function (e) {
        e.preventDefault();
        formData = $('#create-account').serialize();

        $.ajax({
            type: "POST",
            url: route('account.create'),
            data: formData,
            dataType: "json",
            success: function (response) {
                console.log("test : " + formData)
                console.log(response)
                $('#create-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                newRow = '<tr id="accid'+response.account.id+'"><td>'+response.account.id+'</td><td>'+response.account.name+'</td>';
                newRow += '<td>'+response.account.url+'</td>';
                if(response.account.status == 1)
                newRow += '<td><span class="badge bg-success">Active</span></td>';
                if(response.account.status == 2)
                newRow += '<td><span class="badge bg-blue text-light">Legit</span></td>';
                if(response.account.status == 3)
                newRow += '<td><span class="badge bg-dark text-light">Invoicing</span></td>';
                if(response.account.status == 0)
                newRow += '<td><span class="badge label-table bg-danger">Disabled</span></td>';
                newRow += '<td>'+response.account.start_date.substring(0, 10)+'</td>';
                newRow += '<td></td><td>';
                if(response.account.status == 0){
                    newRow += '<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    newRow += '<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>'
                }
                else{
                    newRow += '<a href="javascript:void(0);" class="action-icon" '+
                    'data-bs-toggle="modal" data-bs-target="#edit-modal"'+
                    ' id="edit-"'+response.account.id+
                    ' onclick="editAccount('+response.account.id+');"'+
                    ' data-toggle="modal"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    newRow += '<a href="javascript:void(0);" class="action-icon" id="delete-"'+response.account.id+
                    ' onclick="deleteAccount('+response.account.id+');"> <i class="mdi mdi-delete"></i></a>';
                }
                newRow += '</td></tr>'
                $('#table-accounts>tbody').prepend(newRow);
                $('#create-account')[0].reset();
                //setTimeout(function () { window.location.href = route('accounts'); }, 1500);
            },
            error: function (error) {
                console.log("test : " + formData)
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that account", showConfirmButton: !1, timer: 1500 });
            }
        });
    })

    $('#edit-account').submit(function (e) {
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
            success: function (response) {
                console.log(response)
                $('#edit-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: "This account has been saved", showConfirmButton: !1, timer: 1500 });
                $('#accid' + response.id + ' td:nth-child(2)').text(response.name)
                $('#accid' + response.id + ' td:nth-child(3)').text(response.url)
                if (response.status == 1)
                    $('#accid' + response.id + ' td:nth-child(4)').html("<span class=\"badge bg-success\">Active</span>")
                else if (response.status == 0)
                    $('#accid' + response.id + ' td:nth-child(4)').html("<span class=\"badge label-table bg-danger\">Disabled</span>")
                else if (response.status == 2)
                    $('#accid' + response.id + ' td:nth-child(4)').html("<span class=\"badge bg-blue text-light\">Legit</span>")
                else if (response.status == 3)
                    $('#accid' + response.id + ' td:nth-child(4)').html("<span class=\"badge bg-dark text-light\">Invoicing</span>")
                $('#edit-account')[0].reset();
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while saving that account", showConfirmButton: !1, timer: 1500 });
            }
        });
    });

});

function deleteAccount(id) {
    console.log("id : " + id)
    Swal.fire({ title: "Are you sure?", text: "You won't be able to revert this!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function (e) {
            e.value
                ? $.ajax({
                    type: "DELETE",
                    url: route('account.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                        //$('#accid' + id).remove();
                        $('#accid' + id + ' td:nth-child(4)').html("<span class=\"badge label-table bg-danger\">Disabled</span>")
                        $('#accid' + id + ' td:nth-child(6)').text(response.account.end_date.substring(0, 10))
                        $('#accid' + id + ' td:nth-child(7)').html('<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>' +
                            '<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>')
                        //$('#edit-'+id).prop("onclick", null);
                        //$('#delete-'+id).prop("onclick", null);
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