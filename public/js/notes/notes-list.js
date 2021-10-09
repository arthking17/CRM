$(document).ready(function () {
    setTippyOnNoteContent();
});
function viewNote(id) {
    $.get(route('notes.get', {'id':id, 'modal':0}), function (note) {

        $('#datatable-notes tbody tr').removeClass('selected')
        $('#noteid' + id).addClass('selected')

        if (note == null) {
            Swal.fire({ icon: "error", title: "Note Not Found", showConfirmButton: !1, timer: 1500 });
        } else {
            $('#note-info-card').empty().html(note);
            //$('#note-info-card').addClass('selected')
        }
    })
}

function editNote(id) {
    $.get(route('notes.get', {'id':id, 'modal':1}), function (note) {
        console.log(note)
        $('#edit-note-id').val(id)
        $('#edit-note-element_id').val(note.element_id)
        $('#edit-note-element').val(note.element)
        $('#edit-note-class').val(note.class)
        $('#edit-note-visibility').val(note.visibility)
        $('#edit-note-content').val(note.content)
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
                        //$('#edit-modal').modal('toggle')
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