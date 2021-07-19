$(document).ready(function () {
    $(".parsley-validation").parsley();
}),
    $(function () {

        /**
         * creating contact ajax + validation
         */
        $("#groups-create").parsley().on("field:validated", function () {
            var e = 0 === $(".parsley-error").length;
            $("#groups-create .alert-info").toggleClass("d-none", !e), $("#groups-create .alert-warning").toggleClass("d-none", e);
        }).on("submit", function () {
            return !1;
        });
        $('#groups-create').submit(function (e) {
            e.preventDefault();
            cleanErrorsInForm('groups-create', groups_create_errors)
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
                    //$('#groups-create')[0].reset();
                },
                error: function (error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that contact", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        groups_create_errors = error.responseJSON.errors
                        laravelValidation('groups-create', error.responseJSON.errors)
                    }
                }
            });
        });

        /**
         * updating contact ajax+validation
         */
        $("#groups-edit").parsley().on("field:validated", function () {
            var e = 0 === $(".parsley-error").length;
            $("#groups-edit .alert-info").toggleClass("d-none", !e), $("#groups-edit .alert-warning").toggleClass("d-none", e);
        }).on("submit", function () {
            return !1;
        });
        $('#groups-edit').submit(function (e) {
            e.preventDefault();
            cleanErrorsInForm('groups-edit', groups_edit_errors)
            console.log($('#groups-edit-source_id').val())
            console.log($('#groups-edit')[0])
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
                    //$('#form_create')[0].reset();
                },
                error: function (error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while updating that contact", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        groups_edit_errors = error.responseJSON.errors
                        laravelValidation('groups-edit', error.responseJSON.errors)
                    }
                }
            });
        });
    });