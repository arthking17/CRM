$(document).ready(function () {
    /**
    * editing communication ajax + validation
    */
    $('#btn-edit-communication').on('click', function() {
        cleanErrorsInForm('edit-communication', edit_communication_errors)
        edit_communication_errors = null
    });
   $("#edit-communication").parsley().on("field:validated", function() {
       var e = 0 === $(".parsley-error").length;
       $("#edit-communication .alert-info").toggleClass("d-none", !e), $("#edit-communication .alert-warning").toggleClass("d-none", e);
   }).on("submit", function() {
       return !1;
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
                $.getScript(url_jsfile_communications + "/datatable-communications.init.js")
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
});