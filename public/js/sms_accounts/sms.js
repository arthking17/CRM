function sms(phone_number) {
    var password = null
    var username = null
    var fromName = null
    var id = $('#send-sms-from').val()

    $.get(route('sms_accounts.get', id), function (data) {
        console.log(data)
        password = data.sms_account.pwd
        username = data.sms_account.username
        fromName = data.sms_account.name

        $('#send-sms-to-disabled').val(phone_number)
        $('#send-sms-to').val(phone_number)

        $('#send-sms-from-disabled').val(fromName)
        $('#send-sms-username').val(username)
    })
}

$('#send-sms').submit(function (e) {
    e.preventDefault();
    console.log('send sms')
    var id = $('#send-sms-from').val()
    console.log($('#send-sms')[0])

    $.get(route('sms_accounts.get', id), function (data) {
        console.log(data)
        password = data.sms_account.pwd
        username = data.sms_account.username
        fromName = data.sms_account.name

        console.log($('#send-sms-message').val())

        $.ajax({
            type: 'GET',
            url: 'https://api.smsglobal.com/http-api.php',
            dataType: 'json',
            data: {
                action: 'sendsms',
                user: username,
                password: password,
                from: fromName,
                to: $('#send-sms-to').val(),
                text: $('#send-sms-message').val(),
            },
            success: function (response) {
                console.log(response);
                Swal.fire({ position: "top-end", icon: "success", title: 'SMS Sent to '.to, showConfirmButton: !1, timer: 1500 });
            },
            error: function (error) {
                console.log(error);
                Swal.fire({ position: "top-end", icon: "error", title: "Failed to send sms", showConfirmButton: !1, timer: 1500 });
            }
        });
    })
    /*$.ajax({
        type: "POST",
        url: route('sms.send'),
        dataType: 'json',
        data: new FormData(this),
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
            $('#sms-two-modal').modal('toggle')
            console.log(response)
            Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
        },
        error: function(error) {
            console.log(error);
            Swal.fire({ position: "top-end", icon: "error", title: "Failed to send sms", showConfirmButton: !1, timer: 1500 });
            //alert("Unsuccessful request");
        }
    });*/
})

function setToContactValues(element, contact_id) {
    var contact_datas;
    $.ajax({
        type: "GET",
        url: route('contacts.data.element.get', { 'element': element, 'element_id': contact_id, 'class': 'sms' }),
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        success: function (response) {
            console.log(response)
            contact_datas = response[0];

            $('#send-sms-to').empty();
            contact_datas.forEach(contact_data => {
                $('#send-sms-to').append('<option value="' + contact_data.data + '">' + contact_data.data + '</option>')
            });
        },
        error: function (error) {
            console.log(error)
        }
    })

    if (typeof $("#send-sms-to")[0].selectize !== "undefined")
        $("#send-sms-to")[0].selectize.destroy()

    $("#send-sms-to").selectize({
        valueField: 'data',
        labelField: 'data',
        searchField: ['data'],
        maxItems: 1,
        openOnFocus: true,
        options: contact_datas,
        create: false,
        closeAfterSelect: true,

        load: (query, callback) => {
            if (!query.length) return callback();
            $.ajax({
                type: "GET",
                url: route('contacts.data.element.get', { 'element': element, 'element_id': contact_id, 'class': 'sms' }),
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