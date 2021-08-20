$(document).ready(function() {

    $('#btn-edit-communication').on('click', function() {
        cleanErrorsInForm('edit-communication', edit_communication_errors)
        edit_communication_errors = null
    });

    $('#btn-create-communication').on('click', function() {
        cleanErrorsInForm('create-communication', create_communication_errors)
        create_communication_errors = null
    });
    /**
     * creating communication ajax + validation
     */
    $("#create-communication").parsley().on("field:validated", function() {
        var e = 0 === $(".parsley-error").length;
        $("#create-communication .alert-info").toggleClass("d-none", !e), $("#create-communication .alert-warning").toggleClass("d-none", e);
    }).on("submit", function() {
        return !1;
    });
});

$('#create-communication').submit(function(e) {
    e.preventDefault();
    cleanErrorsInForm('create-communication', create_communication_errors)
    $.ajax({
        type: "POST",
        url: route('communications.create'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
            console.log(response)
            $('#create-communication-modal').modal('toggle')
            Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
            $('#create-communication')[0].reset();

            $('#view-list-communications').html(response.html);
            $.getScript(url_jsfile + "/datatable-communications.init.js")
                .done(function(script, textStatus) {
                    console.log(textStatus);
                })
                .fail(function(jqxhr, settings, exception) {
                    console.log("Triggered ajaxError handler.");
                });
        },
        error: function(error) {
            console.log(error)
            Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that communication", showConfirmButton: !1, timer: 1500 });
            if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                create_communication_errors = error.responseJSON.errors
                laravelValidation('create-communication', error.responseJSON.errors)
            }
        }
    });
});
$('#edit-communication').submit(function(e) {
    e.preventDefault();
    cleanErrorsInForm('edit-communication', edit_communication_errors)
    $.ajax({
        type: "POST",
        url: route('communications.update'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
            console.log(response)
            $('#edit-communication-modal').modal('toggle')
            Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
            //$('#edit-communication')[0].reset();

            $('#view-list-communications').html(response.html);
            $.getScript(url_jsfile + "/datatable-communications.init.js")
                .done(function(script, textStatus) {
                    console.log(textStatus);
                })
                .fail(function(jqxhr, settings, exception) {
                    console.log("Triggered ajaxError handler.");
                });
        },
        error: function(error) {
            console.log(error)
            Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that communication", showConfirmButton: !1, timer: 1500 });
            if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                edit_communication_errors = error.responseJSON.errors
                laravelValidation('edit-communication', error.responseJSON.errors)
            }
        }
    });
});

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