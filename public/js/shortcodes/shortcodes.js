$(document).ready(function() {
    $('#btn-edit-shortcode').on('click', function() {
        cleanErrorsInForm('edit-shortcode', edit_shortcode_errors)
        edit_shortcode_errors = null
    });

    $('#btn-create-shortcode').on('click', function() {
        cleanErrorsInForm('create-shortcode', create_shortcode_errors)
        create_shortcode_errors = null
    });

    $('#create-shortcode').submit(function(e) {
        e.preventDefault();
        cleanErrorsInForm('create-shortcode', create_shortcode_errors)
        $.ajax({
            type: "POST",
            url: route('shortcodes.create'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                $('#create-shortcode-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#create-shortcode')[0].reset();
                setTimeout(function() { 
                    $('#list-shortcodes').html(response.html);
                    $.getScript(url_jsfile_shortcodes + "/datatable-shortcodes.init.js")
                        .done(function (script, textStatus) {
                            console.log(textStatus);
                        })
                        .fail(function (jqxhr, settings, exception) {
                            console.log("Triggered ajaxError handler.");
                        });
                 }, 1500);
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that ShortCode", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    create_shortcode_errors = error.responseJSON.errors
                    laravelValidation('create-shortcode', error.responseJSON.errors)
                }
            }
        });
    });
    $('#edit-shortcode').submit(function(e) {
        e.preventDefault();
        cleanErrorsInForm('edit-shortcode', edit_shortcode_errors)
        $.ajax({
            type: "POST",
            url: route('shortcodes.update'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                console.log(response)
                $('#edit-shortcode-modal').modal('toggle')
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#edit-shortcode')[0].reset();
                var shortcode = response.shortcode;
                setTimeout(function() { 
                    $('#shortcodeid' + shortcode.id + ' td:nth-child(2)').html(shortcode.account_id)
                    $('#shortcodeid' + shortcode.id + ' td:nth-child(3)').html(shortcode.name)
                    $('#shortcodeid' + shortcode.id + ' td:nth-child(4)').html(shortcode.country)
                 }, 1500);
            },
            error: function(error) {
                console.log(error)
                Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that ShortCode", showConfirmButton: !1, timer: 1500 });
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    edit_shortcode_errors = error.responseJSON.errors
                    laravelValidation('edit-shortcode', error.responseJSON.errors)
                }
            }
        });
    });
});



function editShortCode (id) {
    $.get(route('shortcodes.get', id), function(data) {
        console.log(data)
        $('#edit-shortcode-id').val(id)
        $('#edit-shortcode-account_id').val(data.shortcode.account_id)
        $('#edit-shortcode-name').val(data.shortcode.name)
        $('#edit-shortcode-country').val(data.shortcode.country)
    })
}

function deleteShortCode (id) {
    Swal.fire({ title: "Are you sure?", text: "This ShortCode will be remove!", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28bb4b", cancelButtonColor: "#f34e4e", confirmButtonText: "Yes, delete it!" }).then(
        function(e) {
            e.value ?
                $.ajax({
                    type: "DELETE",
                    url: route('shortcodes.delete', id),
                    data: {
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({ icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });

                        setTimeout(function () {
                            $('#shortcodeid' + id + ' td:nth-child(7)').html('<span class="badge bg-danger">Disabled</span>')
                            $('#shortcodeid' + id + ' a:nth-child(1)').attr('onclick', '')
                            $('#shortcodeid' + id + ' a:nth-child(1)').attr('data-bs-toggle', '')
                            $('#shortcodeid' + id + ' a:nth-child(2)').attr('onclick', '')

                            $('#edit-' + id).attr('onclick', '')
                            $('#edit-' + id).attr('data-bs-toggle', '')
                            $('#delete-' + id).attr('onclick', '')
                        }, 1500);
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