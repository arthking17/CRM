$(document).ready(function () {
    $(".parsley-validation").parsley();
}),
    $(function () {

        /**
         * creating note ajax + validation
         */
        $("#create-note").parsley().on("field:validated", function () {
            var e = 0 === $(".parsley-error").length;
            $("#create-note .alert-info").toggleClass("d-none", !e), $("#create-note .alert-warning").toggleClass("d-none", e);
        }).on("submit", function () {
            return !1;
        });
        $('#create-note').submit(function (e) {
            e.preventDefault();
            cleanErrorsInForm('create-note', create_note_errors)
            $.ajax({
                type: "POST",
                url: route('notes.create'),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    console.log(response)
                    $('#create-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    //$('#create-note')[0].reset();
                },
                error: function (error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that note", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        create_note_errors = error.responseJSON.errors
                        laravelValidation('create-note', error.responseJSON.errors)
                    }
                }
            });
        });

        /**
         * updating note ajax+validation
         */
        $('#edit-note').submit(function (e) {
            e.preventDefault();
            cleanErrorsInForm('edit-note', edit_note_errors)
            $.ajax({
                type: "POST",
                url: route('notes.update'),
                data: new FormData(this),
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    console.log(response)
                    $('#edit-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    console.log('response')
                    console.log(response.note.source)
                    $('#noteid' + response.note.id + ' td:nth-child(1)').text(response.note.id)
                    $('#noteid' + response.note.id + ' td:nth-child(2)').text(response.note.class)
                    if (response.note.visibility == 1)
                        $('#noteid' + response.note.id + ' td:nth-child(3)').html('<span class="badge bg-success">Visible for all</span>')
                    else if (response.note.visibility == 0)
                        $('#noteid' + response.note.id + ' td:nth-child(3)').html('<span class="badge label-table bg-danger">Visible only for admin</span>')
                    $('#noteid' + response.note.id + ' td:nth-child(4)').text(response.note.content)
                    //$('#noteid' + response.note.id + ' td:nth-child(5)').text(response.note.element)
                    $('#noteid' + response.note.id + ' td:nth-child(6)').text(response.note.element_id)

                    viewNote(response.note.id)
                    //$('#create-note')[0].reset();
                },
                error: function (error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while updating that note", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        edit_note_errors = error.responseJSON.errors
                        laravelValidation('edit-note', error.responseJSON.errors)
                    }
                }
            });
        });
    });