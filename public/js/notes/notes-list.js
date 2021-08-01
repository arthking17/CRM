function viewNote(id) {
    $.get('/notes/get/' + id + '/0', function(note) {
        if (note == null) {
            Swal.fire({ icon: "error", title: "Note Not Found", showConfirmButton: !1, timer: 1500 });
        } else {
            $('#note-info-card').empty().html(note);
        }
    })
}

function editNote(id) {
    $.get('/notes/get/' + id + '/1', function(note) {
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
        function(e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('notes.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        //$('#edit-modal').modal('toggle')
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                        $('#btn-edit-' + id).addClass('disabled');
                        $('#btn-delete-' + id).addClass('disabled');
                        $('#card-note a:nth-of-type(1)').attr('data-bs-toggle', '')
                        $('#card-note a:nth-of-type(1)').attr('onClick', '')
                        $('#card-note a:nth-of-type(2)').attr('onClick', '')
                        $('#view-list').addClass('d-none');
                        $('#view-list').html(response.html);
                        $.getScript(url_jsfile + "/datatable-notes.init.js")
                            .done(function(script, textStatus) {
                                console.log(textStatus);
                            })
                            .fail(function(jqxhr, settings, exception) {
                                console.log("Triggered ajaxError handler.");
                            });
                        setTimeout(() => { $('#view-list').removeClass('d-none'); }, 2000);

                    },
                    error: function(error) {
                        console.log(error)
                        Swal.fire({ icon: "error", title: response.error, showConfirmButton: !1, timer: 1500 });
                    }
                }) :
                e.dismiss === Swal.DismissReason.cancel && Swal.fire({ title: "Cancelled", text: "Operation canceled :)", icon: "error", confirmButtonColor: "#4a4fea" });
        }
    );
}