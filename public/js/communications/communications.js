function editCommunication(id) {
    $('#edit-communications-modal').modal('toggle')
    $.get('/communications/get/' + id, function(data) {
        console.log(data)
        $('#edit-communication-id').val(id)
        $('#edit-communication-contact_id').val(data.communication.contact_id)
        $('#edit-communication-user_id').val(data.communication.user_id)
        $('#edit-communication-class').val(data.communication.class)
        $('#edit-communication-channel').val(data.communication.channel)

        $("#edit-communication-start_date").flatpickr({
            enableTime: true,
            altInput: true,
            defaultDate: data.communication.start_date,
            dateFormat: "Y-m-d H:i",
        });

        $('#edit-communication-qualification').val(data.communication.qualification)
    })
}

function deleteCommunication(id) {
    Swal.fire({ title: "Are you sure?", text: "This communication will be remove!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function(e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('communications.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                        $('#communicationid' + id + ' td:nth-child(7)').html('<span class="badge bg-danger">Disabled</span>')
                        $('#communicationid' + id + ' a:nth-child(1)').attr('onclick', '')
                        $('#communicationid' + id + ' a:nth-child(1)').attr('data-bs-toggle', '')
                        $('#communicationid' + id + ' a:nth-child(2)').attr('onclick', '')

                        $('#edit-' + id).attr('onclick', '')
                        $('#edit-' + id).attr('data-bs-toggle', '')
                        $('#delete-' + id).attr('onclick', '')
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

function viewCommunication(id) {
    $.get('/communications/show/' + id, function(response) {
        console.log(response)

        $('#datatable-communications tbody tr').removeClass('selected')
        $('#communicationid'+id).addClass('selected')

        try {
            $('#communications-info-card').empty().html(response.html);
            viewNotes(id, response.elementClass)
        } catch (e) {
            Swal.fire({ icon: "error", title: 'error !!!', showConfirmButton: !1, timer: 1500 });
        }
    }).fail(function(error) {
        console.log(error)
        Swal.fire({ icon: "error", title: 'error !!!', showConfirmButton: !1, timer: 1500 });
    })
}