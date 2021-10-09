$(document).ready(function () {
    setTippyOnNoteContent();

    $('#btn-create-note-2').on('click', function () {
        cleanErrorsInForm('create-note-2', create_note_errors)
        create_note_errors = null
    })
    $('#btn-edit-note-2').on('click', function () {
        cleanErrorsInForm('edit-note-2', edit_note_errors)
        edit_note_errors = null
    })
    $('#create-note-2').submit(function (e) {
        e.preventDefault();
        formData = $('#create-note-2').serialize();
        $.ajax({
            type: "POST",
            url: route('notes.create'),
            data: formData,
            dataType: "json",
            success: function (response) {
                $('#create-note-2-modal').modal('toggle')
                console.log(response)
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                $('#create-note-2')[0].reset();
                var note = response.note;
                if (typeof response.note.element !== 'undefined')
                    $.get(route('notes.element.modal', { 'element_id': response.note.element_id, 'element': response.note.element }), function (response) {
                        setTimeout(() => {
                            $('#notes-modal').modal('toggle')
                            viewDatatableNotes(note.element_id, note.element)
                        }, 1500);
                    })
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that note", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    create_note_errors = error.responseJSON.errors
                    laravelValidation('create-note-2', error.responseJSON.errors)
                }
            }
        });
    })
    $('#edit-note-2').submit(function (e) {
        e.preventDefault();
        cleanErrorsInForm('edit-note-2', edit_note_errors)
        formData = $('#edit-note-2').serialize();
        $.ajax({
            type: "POST",
            url: route('notes.update'),
            data: formData,
            dataType: "json",
            success: function (response) {
                $('#edit-note-2-modal').modal('toggle')
                console.log(response)
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#edit-note-2')[0].reset();
                var note = response.note;
                if (typeof response.note.element !== 'undefined')
                    $.get(route('notes.element', { 'element_id': response.note.element_id, 'element': response.note.element }), function (response) {
                        setTimeout(() => {
                            $('#noteid' + note.id + ' td:nth-child(2)').html(getNoteClassName(note.class))
                            var html;
                            if (note.visibility == 1)
                                html = '<span class="badge bg-success">Visible for all</span>';
                            else if (note.visibility == 0)
                                html = '<span class="badge label-table bg-danger">Visible only for admin</span>';
                            $('#noteid' + note.id + ' td:nth-child(3)').html(html)
                            $('#noteid' + note.id + ' td:nth-child(4)').html(getElementName(note.element))
                            $('#noteid' + note.id + ' td:nth-child(5)').html(note.element_id)
                            $('#noteid' + note.id + ' td:nth-child(6)').html(note.content)
                            $('#noteid' + note.id + ' td:nth-child(6)').attr('title', note.content)
                            instanceOfTippyNoteContent.destroy();
                            setTippyOnNoteContent();
                        }, 1500);
                    })
            },
            error: function (error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while updating that note", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    edit_note_errors = error.responseJSON.errors
                    laravelValidation('edit-note-2', error.responseJSON.errors)
                }
            }
        });
    })
})

function viewFomAddNote2(element_id, element) {
    $("#create-note-2-element_id").val(element_id);
    $("#create-note-2-element").val(element);
}

function viewFomEditNote2(id) {
    $.get(route('notes.get', { 'id': id, 'modal': 1 }), function (note) {
        console.log(note)
        $("#edit-note-2-id").val(note.id);
        $("#edit-note-2-element_id").val(note.element_id);
        $("#edit-note-2-element").val(note.element);
        $("#edit-note-2-class").val(note.class);
        $("#edit-note-2-visibility").val(note.visibility);
        $("#edit-note-2-content").val(note.content);
    })
}
/** 
 * 
 * duplicate functions fill edit form
 * 
 */
function editNote2(id) {
    $.get(route('notes.get', { 'id': id, 'modal': 1 }), function (note) {
        console.log(note)
        $('#edit-note-2-id').val(id)
        $('#edit-note-2-element_id').val(note.element_id)
        $('#edit-note-2-element').val(note.element)
        $('#edit-note-2-class').val(note.class)
        $('#edit-note-2-visibility').val(note.visibility)
        $('#edit-note-2-content').val(note.content)
    })
}

function viewNotes2(element_id, element) {
    $.get(route('notes.element', { 'element_id': element_id, 'element': element }), function (notes) {
        if (notes.length) {
            $('#notes-info-card').empty().html(notes);
        }
    })
}

function viewDatatableNotes(element_id, element) {
    $.get(route('notes.element.modal', { 'element_id': element_id, 'element': element }), function (data) {
        console.log(data)
        
        $('#notes-div').empty().html(data.html);

        $.getScript(url_jsfile_notes + "/datatable-notes-modal.init.js")
            .done(function (script, textStatus) {
                console.log(textStatus);
            })
            .fail(function (jqxhr, settings, exception) {
                console.log("Triggered ajaxError handler.");
            });

        setTippyOnNoteContent();
        $('#notes-modal').modal('toggle')
        $('#btn-add-note-2').attr('onclick', 'viewFomAddNote2(' + element_id + ', ' + element + ')')
    })
}

function deleteNote2(id) {
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

                        var note = response.note;
                        setTimeout(() => {
                            $('#notes-modal').modal('toggle')
                            viewDatatableNotes(note.element_id, note.element)
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
    instanceOfTippyNoteContent = tippy('#note-content', {
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