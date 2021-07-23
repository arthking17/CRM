$(document).ready(function () {
    $(".parsley-validation").parsley();
}),
    $(function () {

        /**
         * creating contact ajax + validation
         */
        $("#create-group").parsley().on("field:validated", function () {
            var e = 0 === $(".parsley-error").length;
            $("#create-group .alert-info").toggleClass("d-none", !e), $("#create-group .alert-warning").toggleClass("d-none", e);
        }).on("submit", function () {
            return !1;
        });
        $('#create-group').submit(function (e) {
            e.preventDefault();
            cleanErrorsInForm('create-group', create_group_errors)
            $.ajax({
                type: "POST",
                url: route('contacts.groups.create'),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    console.log(response)
                    $('#create-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    //$('#create-group')[0].reset();
                },
                error: function (error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that contact", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        create_group_errors = error.responseJSON.errors
                        laravelValidation('create-group', error.responseJSON.errors)
                    }
                }
            });
        });

        /**
         * updating contact ajax+validation
         */
        $("#edit-group").parsley().on("field:validated", function () {
            var e = 0 === $(".parsley-error").length;
            $("#edit-group .alert-info").toggleClass("d-none", !e), $("#edit-group .alert-warning").toggleClass("d-none", e);
        }).on("submit", function () {
            return !1;
        });
        $('#edit-group').submit(function (e) {
            e.preventDefault();
            cleanErrorsInForm('edit-group', edit_group_errors)
            console.log($('#edit-group-source_id').val())
            console.log($('#edit-group')[0])
            $.ajax({
                type: "POST",
                url: route('contacts.groups.update'),
                data: new FormData(this),
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    console.log(response)
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    $('#edit-modal').modal('toggle')
                    $('#groupid' + response.group[0].id + ' td:nth-child(2)').text(response.group.name)
                    $('#groupid' + response.group[0].id + ' td:nth-child(3)').text(response.group[0].account)
                    //$('#form_create')[0].reset();
                },
                error: function (error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while updating that contact", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        edit_group_errors = error.responseJSON.errors
                        laravelValidation('edit-group', error.responseJSON.errors)
                    }
                }
            });
        });
    });