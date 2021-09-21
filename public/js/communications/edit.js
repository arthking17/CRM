$(document).ready(function () {
    /**
    * editing communication ajax + validation
    */
    $('#btn-edit-communication').on('click', function () {
        cleanErrorsInForm('edit-communication', edit_communication_errors)
        edit_communication_errors = null
    });
    $("#edit-communication").parsley().on("field:validated", function () {
        var e = 0 === $(".parsley-error").length;
        $("#edit-communication .alert-info").toggleClass("d-none", !e), $("#edit-communication .alert-warning").toggleClass("d-none", e);
    }).on("submit", function () {
        return !1;
    });
    $('#edit-communication').submit(function (e) {
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
            success: function (response) {
                console.log(response)
                $('#edit-communication-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#edit-communication')[0].reset();

                var communication = response.communication;
                setTimeout(function () {
                    $('#communicationid' + communication.id + ' td:nth-child(2)').html('<a href="'+route('contacts.view', communication.contact_id)+'">'+response.contact_name+'</a>')
                    $('#communicationid' + communication.id + ' td:nth-child(3)').html('<a href="'+route('contacts.view', communication.user_id)+'">'+communication.user[0].username+'</a>')
                    var html;
                    if (communication.class == 1)
                        html = '<span class="badge bg-blue">Call</span>'
                    else if (communication.class == 2)
                        html = '<span class="badge bg-info text-light">Email</span>'
                    else if (communication.class == 3)
                        html = '<span class="badge bg-warning text-light">Sms</span>'
                    $('#communicationid' + communication.id + ' td:nth-child(4)').html(html)
                    $('#communicationid' + communication.id + ' td:nth-child(5)').html(communication.channel)
                    $('#communicationid' + communication.id + ' td:nth-child(6)').html(communication.start_date)
                    if (communication.qualification == 1)
                        html = '<span class="badge label-table bg-success">completed with success</span>'
                    else if (communication.qualification == 2)
                        html = '<span class="badge bg-info text-light">interruption during call</span>'
                    $('#communicationid' + communication.id + ' td:nth-child(7)').html(html)
                }, 1500);
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that communication", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    edit_communication_errors = error.responseJSON.errors
                    laravelValidation('edit-communication', error.responseJSON.errors)
                }
            }
        });
    });
});