$(document).ready(function () {
    $(".parsley-validation").parsley();
}),
    $(function () {

        /**
         * creating contact ajax + validation
         */
        $("#form_create").parsley().on("field:validated", function () {
            var e = 0 === $(".parsley-error").length;
            $("#form_create .alert-info").toggleClass("d-none", !e), $("#form_create .alert-warning").toggleClass("d-none", e);
        }).on("submit", function () {
            return !1;
        });
        $('#form_create').submit(function (e) {
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
                success: function (response) {
                    console.log(response)
                    $('#create-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    //$('#form_create')[0].reset();
                },
                error: function (error) {
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
        $("#form_edit").parsley().on("field:validated", function () {
            var e = 0 === $(".parsley-error").length;
            $("#form_edit .alert-info").toggleClass("d-none", !e), $("#form_edit .alert-warning").toggleClass("d-none", e);
        }).on("submit", function () {
            return !1;
        });
        $('#form_edit').submit(function (e) {
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
                success: function (response) {
                    console.log(response)
                    $('#edit-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    console.log('response')
                    console.log(response.contact.source)
                    $('#contactid' + response.contact.id + ' td:nth-child(1)').text(response.contact.id)
                    //$('#contactid' + response.contact.id + ' td:nth-child(2)').text(response.contact.id)
                    /*if (response.contact.class == 1)
                    $('#contactid' + response.contact.id + ' td:nth-child(3)').html('<span class="badge bg-blue text-light">Person</span>')
                    else if (response.contact.class == 2)
                    $('#contactid' + response.contact.id + ' td:nth-child(3)').html('<span class="badge bg-success">Company</span>')*/

                    if (response.contact.source == 1)
                    $('#contactid' + response.contact.id + ' td:nth-child(4)').html('<span class="badge label-table bg-danger">Telephone prospecting</span>')
                    else if (response.contact.source == 2)
                    $('#contactid' + response.contact.id + ' td:nth-child(4)').html('<span class="badge bg-warning">Landing pages</span>')
                    else if (response.contact.source == 3)
                    $('#contactid' + response.contact.id + ' td:nth-child(4)').html('<span class="badge bg-success">Affiliation</span>')
                    else if (response.contact.source == 4)
                    $('#contactid' + response.contact.id + ' td:nth-child(4)').html('<span class="badge bg-blue text-light">Database purchased</span>')

                    $('#contactid' + response.contact.id + ' td:nth-child(5)').text(response.contact.source_id)
                    $('#contactid' + response.contact.id + ' td:nth-child(6)').text(response.contact.creation_date)

                    if (response.contact.status == 1)
                    $('#contactid' + response.contact.id + ' td:nth-child(7)').html('<span class="badge label-table bg-success">Lead</span>')
                    else if (response.contact.status == 2)
                    $('#contactid' + response.contact.id + ' td:nth-child(7)').html('<span class="badge bg-blue text-light">Customer</span>')
                    else if (response.contact.status == 3)
                    $('#contactid' + response.contact.id + ' td:nth-child(7)').html('<span class="badge bg-danger">Not interested</span>')

                    viewContact(response.contact.id, response.contact.class)
                    //$('#form_create')[0].reset();
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