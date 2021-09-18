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
            url: route('appointments.update', 1),//1 when youre in page appointements
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
                $.getScript(url_jsfile_appointments + "/datatable-appointments.init.js")
                    .done(function(script, textStatus) {
                        console.log(textStatus);
                    })
                    .fail(function(jqxhr, settings, exception) {
                        console.log("Triggered ajaxError handler.");
                    });
    
                $.getScript(url_jsfile_appointments + "/calendar.init.js")
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
});