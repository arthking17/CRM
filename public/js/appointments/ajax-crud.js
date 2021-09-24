$(document).ready(function() {

    $('#btn-edit-appointment').on('click', function() {
        cleanErrorsInForm('edit-appointment', edit_appointment_errors)
        edit_appointment_errors = null
    });

    $('#btn-create-appointment').on('click', function() {
        cleanErrorsInForm('create-appointment', create_appointment_errors)
        create_appointment_errors = null
    });
    /**
     * creating appointment ajax + validation
     */
    $("#create-appointment").parsley().on("field:validated", function() {
        var e = 0 === $(".parsley-error").length;
        $("#create-appointment .alert-info").toggleClass("d-none", !e), $("#create-appointment .alert-warning").toggleClass("d-none", e);
    }).on("submit", function() {
        return !1;
    });
});

$('#create-appointment').submit(function(e) {
    e.preventDefault();
    cleanErrorsInForm('create-appointment', create_appointment_errors)
    $.ajax({
        type: "POST",
        url: route('appointments.create'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
            console.log(response)
            $('#create-appointment-modal').modal('toggle')
            Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
            //$('#create-appointment')[0].reset();

            $('#view-list-appointments').html(response.html);
            $.getScript(url_jsfile + "/datatable-appointments.init.js")
                .done(function(script, textStatus) {
                    console.log(textStatus);
                })
                .fail(function(jqxhr, settings, exception) {
                    console.log("Triggered ajaxError handler.");
                });

            $.getScript(url_jsfile + "/calendar.init.js")
                .done(function(script, textStatus) {
                    console.log(textStatus);
                })
                .fail(function(jqxhr, settings, exception) {
                    console.log("Triggered ajaxError handler.");
                });
        },
        error: function(error) {
            console.log(error)
            Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that appointment", showConfirmButton: !1, timer: 1500 });
            if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                create_appointment_errors = error.responseJSON.errors
                laravelValidation('create-appointment', error.responseJSON.errors)
            }
        }
    });
});
$('#edit-appointment').submit(function(e) {
    e.preventDefault();
    cleanErrorsInForm('edit-appointment', edit_appointment_errors)
    $.ajax({
        type: "POST",
        url: route('appointments.update'),
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

            $('#view-list-appointments').html(response.html);
            $.getScript(url_jsfile + "/datatable-appointments.init.js")
                .done(function(script, textStatus) {
                    console.log(textStatus);
                })
                .fail(function(jqxhr, settings, exception) {
                    console.log("Triggered ajaxError handler.");
                });

            $.getScript(url_jsfile + "/calendar.init.js")
                .done(function(script, textStatus) {
                    console.log(textStatus);
                })
                .fail(function(jqxhr, settings, exception) {
                    console.log("Triggered ajaxError handler.");
                });
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

function editAppointment(id) {
    $('#edit-appointments-modal').modal('toggle')
    $.get('/appointments/get/' + id, function(data) {
        console.log(data)
        $('#edit-appointment-id').val(id)
        $('#edit-appointment-contact_id').val(data.appointment.contact_id)
        $('#edit-appointment-user_id').val(data.appointment.user_id)
        $('#edit-appointment-class').val(data.appointment.class)
        $('#edit-appointment-subject').val(data.appointment.subject)

        $("#edit-appointment-start_date").flatpickr({
            enableTime: true,
            altInput: true,
            defaultDate: data.appointment.start_date,
            dateFormat: "Y-m-d H:i",
        });

        $("#edit-appointment-end_date").flatpickr({
            enableTime: true,
            altInput: true,
            defaultDate: data.appointment.end_date,
            dateFormat: "Y-m-d H:i",
        });
    })
}

function deleteAppointment(id) {
    Swal.fire({ title: "Are you sure?", text: "This appointment will be remove!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function(e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('appointments.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                        $('#appointmentid' + id + ' td:nth-child(8)').html('<span class="badge bg-danger">Disabled</span>')
                        $('#appointmentid' + id + ' a:nth-child(1)').attr('onclick', '')
                        $('#appointmentid' + id + ' a:nth-child(1)').attr('data-bs-toggle', '')
                        $('#appointmentid' + id + ' a:nth-child(2)').attr('onclick', '')
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