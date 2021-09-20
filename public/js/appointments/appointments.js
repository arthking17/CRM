$(document).ready(function () {
    setTippyOnNoteContent();
});

function editAppointment(id) {
    $('#edit-appointments-modal').modal('toggle')
    $.get('/appointments/get/' + id, function (data) {
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
        function (e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('appointments.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                        $('#appointmentid' + id + ' td:nth-child(8)').html('<span class="badge bg-danger">Disabled</span>')
                        $('#appointmentid' + id + ' a:nth-child(1)').attr('onclick', '')
                        $('#appointmentid' + id + ' a:nth-child(1)').attr('data-bs-toggle', '')
                        $('#appointmentid' + id + ' a:nth-child(2)').attr('onclick', '')

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
                        Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
                    }
                }) :
                e.dismiss === Swal.DismissReason.cancel && Swal.fire({ title: "Cancelled", text: "Operation canceled :)", icon: "error", confirmButtonColor: "#4a4fea" });
        }
    );
}

function setTippyOnNoteContent() {
    tippy('[title]', {
        // change these to your liking
        arrow: true,
        placement: 'left', // top, right, bottom, left
        distance: 15, //px or string
        maxWidth: 300, //px or string
        animation: 'perspective',
        // leave these as they are
        allowHTML: true,
        ignoreAttributes: true,
        content(reference) {
            const title = reference.getAttribute('title');
            reference.removeAttribute('title');
            return title;
        },
        interactive: "true",
        hideOnClick: false, // if you want

    });
}