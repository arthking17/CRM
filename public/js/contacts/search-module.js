$(function() {

    /**
     * searching contact ajax + validation
     */
    $("#search-contact").parsley().on("field:validated", function() {
        var e = 0 === $(".parsley-error").length;
        $("#search-contact .alert-info").toggleClass("d-none", !e), $("#search-contact .alert-warning").toggleClass("d-none", e);
    }).on("submit", function() {
        return !1;
    });
    $('#search-contact').submit(function(e) {
        e.preventDefault();
        cleanErrorsInForm('search-contact', search_contact_errors)
        $.ajax({
            type: "POST",
            url: route('contacts.search'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                $('#search-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                setTimeout(function() {
                    $('#contacts-result').html(response.html);

                    $('#contacts-result').prepend('<div class="row">' +
                        '<div class="col-12">' +
                        '<div class="page-title-box">' +
                        '<h4 class="page-title">Search Results</h4>' +
                        '</div>' +
                        '</div>' +
                        '</div>')
                    $.getScript(url_jsfile + "/datatable-contacts.init.js")
                        .done(function(script, textStatus) {
                            console.log(textStatus);
                        })
                        .fail(function(jqxhr, settings, exception) {
                            console.log("Triggered ajaxError handler.");
                        });
                }, 1500);
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while searching that contact file", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    search_contact_errors = error.responseJSON.errors
                    laravelValidation('search-contact', error.responseJSON.errors)
                }
            }
        });
    });
});