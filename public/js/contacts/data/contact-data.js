function displayFormAddContactData(id, classs) {
    $('#create-contact-data-element').val(5)
    $('#create-contact-data-element_id').val(id)
    $('#create-contact-data-class').val(classs)
}

$(document).ready(function () {
    $(".parsley-validation").parsley();
}),
    $(function () {

        /**
         * creating contact ajax + validation
         */
        $("#create-contact-data").parsley().on("field:validated", function () {
            var e = 0 === $(".parsley-error").length;
            $("#create-contact-data .alert-info").toggleClass("d-none", !e), $("#create-contact-data .alert-warning").toggleClass("d-none", e);
        }).on("submit", function () {
            return !1;
        });
        $('#create-contact-data').submit(function (e) {
            e.preventDefault();
            cleanErrorsInForm('create-contact-data', create_contact_data_errors)
            $.ajax({
                type: "POST",
                url: route('contacts.data.create'),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    console.log(response)
                    $('#create-contact-data-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    //$('#create-contact-data')[0].reset();
                },
                error: function (error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that contact Data", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        create_contact_data_errors = error.responseJSON.errors
                        laravelValidation('create-contact-data', error.responseJSON.errors)
                    }
                }
            });
        });

        /**
         * updating contact ajax+validation
         */
        $("#edit-contact-data").parsley().on("field:validated", function () {
            var e = 0 === $(".parsley-error").length;
            $("#edit-contact-data .alert-info").toggleClass("d-none", !e), $("#edit-contact-data .alert-warning").toggleClass("d-none", e);
        }).on("submit", function () {
            return !1;
        });
        $('#edit-contact-data').submit(function (e) {
            e.preventDefault();
            cleanErrorsInForm('edit-contact-data', edit_contact_data_errors)
            console.log($('#edit-contact-data-source_id').val())
            console.log($('#edit-contact-data')[0])
            $.ajax({
                type: "POST",
                url: route('contacts.data.update'),
                data: new FormData(this),
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    console.log(response)
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    $('#edit-contact-data-modal').modal('toggle')
                    $('#groupid' + response.group[0].id + ' td:nth-child(2)').text(response.group.name)
                    $('#groupid' + response.group[0].id + ' td:nth-child(3)').text(response.group[0].account)
                    //$('#form_create')[0].reset();
                },
                error: function (error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while updating that contact Data", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        edit_contact_data_errors = error.responseJSON.errors
                        laravelValidation('edit-contact-data', error.responseJSON.errors)
                    }
                }
            });
        });
    });