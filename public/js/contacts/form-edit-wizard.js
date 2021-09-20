$(document).ready(function () {
    "use strict";
    $('#form_edit-class').on('change', function () {
        if ($(this).val() == "1") {
            $('#edit-nav-tab-info a:nth-of-type(1)').attr('href', '#edit-personcontact')
            //disable validation on companies contact tab
            $('#form_edit .companie-required').attr('required', false)
            //active validation on person contact tab
            $('#form_edit .person-required').attr('required', true)
        } else if ($(this).val() == "2") {
            $('#edit-nav-tab-info a:nth-of-type(1)').attr('href', '#edit-companiescontact')
            //active validation on companies contact tab
            $('#form_edit .companie-required').attr('required', true)
            //disable validation on person contact tab
            $('#form_edit .person-required').attr('required', false)
        }
    })
    $("#edit-contactwizard").bootstrapWizard({
        onTabShow: function (t, r, a) {
            var o = ((a + 1) / r.find("li").length) * 100;
            $("#edit-contactwizard")
                .find(".bar")
                .css({ width: o + "%" });
        },
    });

    /**
         * updating contact ajax+validation
         */
    $("#form_edit").parsley().on("field:validated", function () {
        var e = 0 === $(".parsley-error").length;
        $("#form_edit .alert-info").toggleClass("d-none", !e), $("#form_edit .alert-warning").toggleClass("d-none", e);
    }).on("submit", function () {
        return !1;
    });
    $('#form_edit').submit(function (e) {
        e.preventDefault();

        cleanErrorsInForm('form_edit', form_edit_errors)

        var currentUrl = window.location.href;
        var urlTable = currentUrl.split('/');
        var page_name;
        if (typeof urlTable[4] !== 'undefined') {
            page_name = 'page_view';
        } else page_name = 'page_list';

        $.ajax({
            type: "POST",
            url: route('contacts.update', page_name),
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                //$('#form_edit')[0].reset();
                console.log(response)
                $('#edit-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                if (response.page_name == 'page_list') {
                    $('#contacts-result').html(response.html);
                    viewInfoCardContact(response.contact.id, response.contact.class)

                    $.getScript(url_jsfile + "/datatable-contacts.init.js")
                        .done(function (script, textStatus) {
                            console.log(textStatus);
                        })
                        .fail(function (jqxhr, settings, exception) {
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
                } else if (response.page_name == 'page_view') {
                    if (response.contact.class == 1)
                        $('#contacts_person-info-card').html(response.html);
                    else if (response.contact.class == 2)
                        $('#contacts_companie-info-card').html(response.html);
                }
            },
            error: function (error) {
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
