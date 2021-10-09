$(document).ready(function () {
    /**
     * creating appointment ajax + validation
     */
    $('#btn-create-appointment').on('click', function () {
        cleanErrorsInForm('create-appointment', create_appointment_errors)
        create_appointment_errors = null
    });

    $("#create-appointment").parsley().on("field:validated", function () {
        var e = 0 === $(".parsley-error").length;
        $("#create-appointment .alert-info").toggleClass("d-none", !e), $("#create-appointment .alert-warning").toggleClass("d-none", e);
    }).on("submit", function () {
        return !1;
    });

    $('#create-appointment').submit(function (e) {
        e.preventDefault();
        cleanErrorsInForm('create-appointment', create_appointment_errors)

        var currentUrl = route().current();
        if (currentUrl == 'users.view')
            page_name = 'page_users_view';
        else if (currentUrl == 'contacts.view')
            page_name = 'page_contacts_view';
        else if (currentUrl == 'contacts')
            page_name = 'page_contacts';
        else if (currentUrl == 'appointments')
            page_name = 'page_appointments';
        console.log(currentUrl)

        $.ajax({
            type: "POST",
            url: route('appointments.create', page_name),//1 when youre in page appointements
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(response)
                $('#create-appointment-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                $('#create-appointment')[0].reset();

                if (page_name !== 'page_contacts') {
                    $('#view-list-appointments').html(response.html);
                    $.getScript(url_jsfile_appointments + "/datatable-appointments.init.js")
                        .done(function (script, textStatus) {
                            console.log(textStatus);
                        })
                        .fail(function (jqxhr, settings, exception) {
                            console.log("Triggered ajaxError handler.");
                        });
                }
                if (page_name == 'page_appointments')
                    $.getScript(url_jsfile_appointments + "/calendar.init.js")
                        .done(function (script, textStatus) {
                            console.log(textStatus);
                        })
                        .fail(function (jqxhr, settings, exception) {
                            console.log("Triggered ajaxError handler.");
                        });
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that appointment", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    create_appointment_errors = error.responseJSON.errors
                    laravelValidation('create-appointment', error.responseJSON.errors)
                }
            }
        });
    });
});