
$(document).ready(function () {
    "use strict";
    $('#form_create-class').on('change', function () {
        if ($(this).val() == "1") {
            $('#nav-tab-info a:nth-of-type(1)').attr('href', '#personcontact')
            //disable validation on companies contact tab
            $('#form_create .companie-required').attr('required', false)
            //active validation on person contact tab
            $('#form_create .person-required').attr('required', true)
        } else if ($(this).val() == "2") {
            $('#nav-tab-info a:nth-of-type(1)').attr('href', '#companiescontact')
            //active validation on companies contact tab
            $('#form_create .companie-required').attr('required', true)
            //disable validation on person contact tab
            $('#form_create .person-required').attr('required', false)
        }
    })
    
    $('#form_create-account_id').on('change', function () {
        $.get(route('custom-fields.form', {'account_id':$('#form_create-account_id').val(), 'form_type':'create'}), function (data) {
           $('#custom-fields').html(data);
        });
    })

    $("#contactwizard").bootstrapWizard({
        onTabShow: function (t, r, a) {
            var o = ((a + 1) / r.find("li").length) * 100;
            $("#contactwizard")
                .find(".bar")
                .css({ width: o + "%" });
        },
    });

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
                $('#create-contact-modal').modal('toggle')
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
});
