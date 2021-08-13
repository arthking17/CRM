$(document).ready(function() {
        $(".parsley-validation").parsley();
    }),
    $(function() {

        /**
         * creating contact ajax + validation
         */
        $("#form_create").parsley().on("field:validated", function() {
            var e = 0 === $(".parsley-error").length;
            $("#form_create .alert-info").toggleClass("d-none", !e), $("#form_create .alert-warning").toggleClass("d-none", e);
        }).on("submit", function() {
            return !1;
        });
        $('#form_create').submit(function(e) {
            e.preventDefault();
            cleanErrorsInForm('form_create', form_create_errors)
            $.ajax({
                type: "POST",
                url: route('contacts.create'),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    console.log(response)
                    $('#create-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    $('#form_create')[0].reset();

                    viewContact(response.contact.id, response.contact.class)

                    $('#contacts-result').html(response.html);
                    $.getScript(url_jsfile + "/datatable-contacts.init.js")
                        .done(function(script, textStatus) {
                            console.log(textStatus);
                        })
                        .fail(function(jqxhr, settings, exception) {
                            console.log("Triggered ajaxError handler.");
                        });

                    $(".datepicker").flatpickr({
                        dateFormat: "Y-m-d",
                        altInput: true,
                        defaultDate: null,
                    });
                    $(".datetimepicker").flatpickr({
                        enableTime: true,
                        altInput: true,
                        defaultDate: null,
                        dateFormat: "Y-m-d H:i",
                    });
                },
                error: function(error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that contact", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        form_create_errors = error.responseJSON.errors
                        laravelValidation('form_create', error.responseJSON.errors)
                    }
                }
            });
        });

        /**
         * updating contact ajax+validation
         */
        $("#form_edit").parsley().on("field:validated", function() {
            var e = 0 === $(".parsley-error").length;
            $("#form_edit .alert-info").toggleClass("d-none", !e), $("#form_edit .alert-warning").toggleClass("d-none", e);
        }).on("submit", function() {
            return !1;
        });
        $('#form_edit').submit(function(e) {
            e.preventDefault();
            cleanErrorsInForm('form_edit', form_edit_errors)
            console.log($('#form_edit-source_id').val())
            console.log($('#form_edit')[0])
            $.ajax({
                type: "POST",
                url: route('contacts.update'),
                data: new FormData(this),
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    //$('#form_edit')[0].reset();
                    console.log(response)
                    $('#edit-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    $('#contacts-result').html(response.html);
                    viewInfoCardContact(response.contact.id, response.contact.class)

                    $.getScript(url_jsfile + "/datatable-contacts.init.js")
                        .done(function(script, textStatus) {
                            console.log(textStatus);
                        })
                        .fail(function(jqxhr, settings, exception) {
                            console.log("Triggered ajaxError handler.");
                        });
                    $('#edit-contactwizard').find("a[href*='edit-contact-class']").trigger('click');

                    $(".datepicker").flatpickr({
                        dateFormat: "Y-m-d",
                        altInput: true,
                        defaultDate: null,
                    });
                    $(".datetimepicker").flatpickr({
                        enableTime: true,
                        altInput: true,
                        defaultDate: null,
                        dateFormat: "Y-m-d H:i",
                    });
                },
                error: function(error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while updating that contact", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        form_edit_errors = error.responseJSON.errors
                        laravelValidation('form_edit', error.responseJSON.errors)
                    }
                }
            });
        });
    });