$(document).ready(function () {
    /**
     * editing appointment ajax + validation
     */
    $('#btn-edit-appointment').on('click', function() {
        cleanErrorsInForm('edit-appointment', edit_appointment_errors)
        edit_appointment_errors = null
    });

    $("#edit-appointment").parsley().on("field:validated", function() {
        var e = 0 === $(".parsley-error").length;
        $("#edit-appointment .alert-info").toggleClass("d-none", !e), $("#edit-appointment .alert-warning").toggleClass("d-none", e);
    }).on("submit", function() {
        return !1;
    });

    $('#edit-appointment').submit(function(e) {
        e.preventDefault();
        cleanErrorsInForm('edit-appointment', edit_appointment_errors)
        $.ajax({
            type: "POST",
            url: route('appointments.update', 2),//2 when youre in tab appointments in page contact detail
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                $('#edit-appointment-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#edit-appointment')[0].reset();

                var appointment = response.appointment;
                setTimeout(function () {
                    $('#appointmentid' + appointment.id + ' td:nth-child(2)').html('<a href="'+route('contacts.view', appointment.contact_id)+'">'+response.contact_name+'</a>')
                    $('#appointmentid' + appointment.id + ' td:nth-child(3)').html('<a href="'+route('contacts.view', appointment.user_id)+'">'+appointment.user[0].username+'</a>')
                    var html;
                    if (appointment.class == 1)
                        html = '<span class="badge bg-success">Simple</span>'
                    else if (appointment.class == 2)
                        html = '<span class="badge bg-danger text-light">Urgent</span>'
                    $('#appointmentid' + appointment.id + ' td:nth-child(4)').html(html)
                    $('#appointmentid' + appointment.id + ' td:nth-child(5)').html(appointment.subject)
                    $('#appointmentid' + appointment.id + ' td:nth-child(6)').html(appointment.start_date)
                    $('#appointmentid' + appointment.id + ' td:nth-child(6)').html(appointment.end_date)
                }, 1500);
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that appointment", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    edit_appointment_errors = error.responseJSON.errors
                    laravelValidation('edit-appointment', error.responseJSON.errors)
                }
            }
        });
    });
});