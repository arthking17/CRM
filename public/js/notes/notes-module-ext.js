$(document).ready(function () {
    setTippyOnNoteContent();

    $('#btn-create-note').on('click', function () {
        cleanErrorsInForm('create-note', create_note_errors)
        create_note_errors = null
    })
    $('#btn-edit-note').on('click', function () {
        cleanErrorsInForm('edit-note', edit_note_errors)
        edit_note_errors = null
    })
    $('#create-note').submit(function (e) {
        e.preventDefault();
        formData = $('#create-note').serialize();
        $.ajax({
            type: "POST",
            url: route('notes.create'),
            data: formData,
            dataType: "json",
            success: function (response) {
                $('#create-note-modal').modal('toggle')
                console.log(response)
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                $('#create-note')[0].reset();
                if (typeof response.note.element !== 'undefined')
                    $.get('/notes/element/' + response.note.element_id + '/' + response.note.element, function (response) {
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
                    })
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
    })
    $('#edit-note').submit(function (e) {
        e.preventDefault();
        cleanErrorsInForm('edit-note', edit_note_errors)
        formData = $('#edit-note').serialize();
        $.ajax({
            type: "POST",
            url: route('notes.update'),
            data: formData,
            dataType: "json",
            success: function (response) {
                $('#edit-note-modal').modal('toggle')
                console.log(response)
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#edit-note')[0].reset();
                if (typeof response.note.element !== 'undefined')
                    $.get('/notes/element/' + response.note.element_id + '/' + response.note.element, function (response) {
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
                    })
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
    })
})

function viewFomAddNote(element_id, element) {
    $("#create-note-element_id").val(element_id);
    $("#create-note-element").val(element);
}

function viewFomEditNote(id) {
    $.get('/notes/get/' + id + '/1', function (note) {
        console.log(note)
        $("#edit-note-id").val(note.id);
        $("#edit-note-element_id").val(note.element_id);
        $("#edit-note-element").val(note.element);
        $("#edit-note-class").val(note.class);
        $("#edit-note-visibility").val(note.visibility);
        $("#edit-note-content").val(note.content);
    })
}

function editNote(id) {
    $.get('/notes/get/' + id + '/1', function (note) {
        console.log(note)
        $('#edit-note-id').val(id)
        $('#edit-note-element_id').val(note.element_id)
        $('#edit-note-element').val(note.element)
        $('#edit-note-class').val(note.class)
        $('#edit-note-visibility').val(note.visibility)
        $('#edit-note-content').val(note.content)
    })
}

function viewNotes(element_id, element) {
    $.get('/notes/element/' + element_id + '/' + element, function (notes) {
        if (notes.length) {
            $('#notes-info-card').empty().html(notes);
        }
    })
}

function viewDatatableNotes(element_id, element) {
    $.get('/notes/get/element/' + element_id + '/' + element, function (data) {
        if (typeof dataTableNotes !== 'undefined')
            dataTableNotes.destroy()
        $('#notes-div').empty().html(data);
        dataTableNotes = $('#datatable-notes').DataTable({
            stateSave: !0,
            language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });
        $('#notes-modal').modal('toggle')
    })
}

function deleteNote(id) {
    Swal.fire({ title: "Are you sure?", text: "This note will be delete!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function (e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('notes.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

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
                        Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
                    }
                }) :
                e.dismiss === Swal.DismissReason.cancel && Swal.fire({ title: "Cancelled", text: "Operation canceled :)", icon: "error", confirmButtonColor: "#4a4fea" });
        }
    );
}

function setTippyOnNoteContent() {
    tippy('#note-content', {
        // change these to your liking
        arrow: true,
        placement: 'left', // top, right, bottom, left
        distance: 15, //px or string
        maxWidth: 300, //px or string
        animation: 'perspective',
        // leave these as they are
        allowHTML: true,
        ignoreAttributes: true,
        content(reference) {
            const title = reference.getAttribute('title');
            reference.removeAttribute('title');
            return title;
        },
        interactive: "true",
        hideOnClick: false, // if you want

    });
}