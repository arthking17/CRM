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
                    $('#create-note-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                    $('#create-note')[0].reset();

                    //viewNote(response.note.id)

                    setTimeout(() => {
                        $.getScript(url_jsfile_notes + "/datatable-notes.init.js")
                            .done(function (script, textStatus) {
                                console.log(textStatus);
                            })
                            .fail(function (jqxhr, settings, exception) {
                                console.log("Triggered ajaxError handler.");
                            });
                        $('#notes').html(response.html);
                        setTippyOnNoteContent();
                    }, 1500);
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
                    $('#edit-note-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                    //viewNote(response.note.id)

                    setTimeout(() => {
                        $.getScript(url_jsfile_notes + "/datatable-notes.init.js")
                            .done(function (script, textStatus) {
                                console.log(textStatus);
                            })
                            .fail(function (jqxhr, settings, exception) {
                                console.log("Triggered ajaxError handler.");
                            });
                        $('#notes').html(response.html);
                        setTippyOnNoteContent();
                    }, 1500);

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