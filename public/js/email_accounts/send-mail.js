$(document).ready(function () {
    $("#send-mail-modal").draggable({
        handle: ".modal-header"
    });
    $("#send-mail-modal").resizable({
        animate: true
    });
    // Snow theme
    var quill = new Quill('#snow-editor', {
        theme: 'snow',
        modules: {
            'toolbar': [
                [{ 'font': [] }, { 'size': [] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'super' }, { 'script': 'sub' }],
                [{ 'header': [false, 1, 2, 3, 4, 5, 6] }, 'blockquote', 'code-block'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
                ['direction', { 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        },
    });

    $('#send-mail-from').on('change', function () {
        if ($('#send-mail-from').val() != "") {
            $.ajax({
                type: "GET",
                url: route('email_accounts.config', $("#send-mail-from").val()),
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    console.log(response)
                },
                error: function (error) {
                    console.log(error)
                }
            })
        }
    })

    $('#send-mail').submit(function (e) {
        e.preventDefault();
        //console.log($('#send-mail-content').val())
        console.log(editor.getContents())
        console.log(editor.getLength())
        console.log($('#snow-editor div:nth-child(1)').html())
        $('#send-mail-content').val($('#snow-editor div:nth-child(1)').html())

        $.ajax({
            type: "POST",
            url: route('send_mail'),
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(response)
                $('#send-mail-modal').modal('toggle')
                $('#send-mail')[0].reset()
                Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                //$('#create-email-account')[0].reset();
            },
            error: function (error) {
                console.log(error)
                if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                    Swal.fire({ position: "top-end", icon: "error", title: error.responseJSON.errors, showConfirmButton: !1, timer: 1500 });
                } else
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while sending that email", showConfirmButton: !1, timer: 1500 });
            }
        });
    });
});

function setToEmailValues(element, contact_id) {
    var contact_datas;
    $.ajax({
        type: "GET",
        url: route('contacts.data.element.get', { 'element': element, 'element_id': contact_id, 'class': 'email' }),
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        success: function (response) {
            console.log(response)
            contact_datas = response[0];

            $('#send-email-to').empty();
            contact_datas.forEach(contact_data => {
                $('#send-email-to').append('<option value="' + contact_data.data + '">' + contact_data.data + '</option>')
            });
        },
        error: function (error) {
            console.log(error)
        }
    })

    if (typeof $("#send-mail-to")[0].selectize !== "undefined")
        $("#send-mail-to")[0].selectize.destroy()

    $("#send-mail-to").selectize({
        valueField: 'data',
        labelField: 'data',
        searchField: ['data'],
        maxItems: null,
        openOnFocus: true,
        options: contact_datas,
        create: false,
        closeAfterSelect: true,

        load: (query, callback) => {
            if (!query.length) return callback();
            $.ajax({
                type: "GET",
                url: route('contacts.data.element.get', { 'element': element, 'element_id': contact_id, 'class': 'email' }),
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    callback(response)
                },
                error: function () {
                    callback()
                }
            })
        },
        placeholder: 'To',
    });
}