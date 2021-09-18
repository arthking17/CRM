$(document).ready(function () {
    /**
     * creating communication ajax + validation
    */
    $('#btn-create-communication').on('click', function () {
        cleanErrorsInForm('create-communication', create_communication_errors)
        create_communication_errors = null
    });

    $("#create-communication").parsley().on("field:validated", function () {
        var e = 0 === $(".parsley-error").length;
        $("#create-communication .alert-info").toggleClass("d-none", !e), $("#create-communication .alert-warning").toggleClass("d-none", e);
    }).on("submit", function () {
        return !1;
    });

    $('#create-communication').submit(function (e) {
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
            success: function (response) {
                console.log(response)
                $('#create-communication-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                $('#create-communication')[0].reset();

                $('#view-list-communications').html(response.html);
                $.getScript(url_jsfile_communications + "/datatable-communications.init.js")
                    .done(function (script, textStatus) {
                        console.log(textStatus);
                    })
                    .fail(function (jqxhr, settings, exception) {
                        console.log("Triggered ajaxError handler.");
                    });
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that communication", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    create_communication_errors = error.responseJSON.errors
                    laravelValidation('create-communication', error.responseJSON.errors)
                }
            }
        });
    });
});