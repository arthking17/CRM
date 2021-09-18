function call(contact_data_id, phone_number) {
    username = $('#button-call-one').attr('data-sipaccount-username')

    $('#call-number').html(phone_number)

    var audio = new Audio(url_audio + '/phone_dialing.wav');
    audio.play();

    var timer = null;

    function endCallTheme() {
        $('#button-call-two-stop-call').addClass('disabled')
        $('#button-call-two-close').addClass('disabled')
        clearTimeout(timeout);
        if (timer) {
            clearInterval(timer)
            $('#call-two-modal-content').removeClass('bg-success')
            $('#call-two-modal-header').removeClass('bg-success')
        }
        $('#call-duration').html('Call End');
        var audio = new Audio(url_audio + '/end_call.mp3');
        audio.play();
        $('#call-two-modal-content').addClass('bg-danger')
        $('#call-two-modal-header').addClass('bg-danger')
        setTimeout(() => {
            $('#call-two-modal').modal('toggle');
            $('#call-two-modal').on('hidden.bs.modal', function () {
                $('#call-duration').html('Dialing...');
                $('#call-two-modal-content').removeClass('bg-danger')
                $('#call-two-modal-header').removeClass('bg-danger')
                $('#button-call-two-stop-call').removeClass('disabled')
                $('#button-call-two-close').removeClass('disabled')
            })
        }, 1500);
    }

    timeout = setTimeout(function () {
        $('#call-two-modal-content').addClass('bg-success')
        $('#call-two-modal-header').addClass('bg-success')
        $('#call-duration').html('00:00');
        audio.pause();
        audio.currentTime = 0;
        duration = Math.random() * (3600 - 0) + 0;
        duration = 10;

        var totalSeconds = 0;
        timer = setInterval(setTime, 1000);
        console.log(timer)

        function setTime() {
            if (duration > totalSeconds) {
                ++totalSeconds;
                var minutes = Math.floor(totalSeconds / 60);
                var seconds = totalSeconds - minutes * 60;
                myTimer = pad(minutes) + ':' + pad(seconds);
                $('#call-duration').html(myTimer);
            } else
                endCallTheme()
        }

        function pad(val) {
            var valString = val + "";
            if (valString.length < 2) {
                return "0" + valString;
            } else {
                return valString;
            }
        }
    }, 3000);

    $('#button-call-two-close').on('click', function () {
        endCallTheme()
    })

    $('#button-call-two-stop-call').on('click', function () {
        endCallTheme()
    })

    /*$.ajax({
        url: 'https://' + server + '/call.php',
        dataType: 'json',
        data: {
            username: username,
            phone: phone_number
        },
        success: function(code_html, statut) {
            audio.pause();
            audio.currentTime = 0;
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            Swal.fire({ position: "top-end", icon: "error", title: "Call aborted", showConfirmButton: !1, timer: 1500 });
            //alert("Unsuccessful request");
        }
    });

    myTimer = setInterval(function() {
        $.ajax({
            type: "GET",
            url: "https://" + server + "/call_inprogress_status.php",
            dataType: "json",
            data: {
                username: username,
                phone: phone_number
            },
            success: function(data) {
                // response example 1 : {exist: 1, time: 000023}
                // response example 2 : {exist: 0}
                if (data.exist == 1) {
                    // Display call timer
                    $('#call-duration').html(myTimer);
                } else {
                    clearInterval(timer);
                    $('#call-duration').html('Dialing...');
                }
            },
            error: function() {}
        });
    }, 1000);*/
}

function setContactDataValues(element, contact_id) {
    $.ajax({
        type: "GET",
        url: route('contacts.data.element.get', { 'element': element, 'element_id': contact_id, 'class': 'call' }),
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        success: function (response) {
            console.log(response)
            contact_datas = response[0];
            $('#contacts-to-call').empty();
            if (contact_datas.length) {
                contact_datas.forEach(contact_data => {
                    console.log(contact_data)
                    $('#contacts-to-call').append(
                        '<a href="javascript: void(0);" class="" data-bs-toggle="modal" data-bs-target="#call-two-modal" data-bs-dismiss="modal"'
                        + 'onclick="call(' + contact_data.id + ', ' + contact_data.data + ');">'
                        + '<div class="card product-box" id="' + contact_data.id + '">'
                        + '<br>'
                        + '<h4 class="card-title text-success text-center">'
                        + '<img src="' + url_contact_image + '/' + getContactTypeByClass(contact_data.class) + '.png"'
                        + 'alt="contact-data-logo" height="12" class="me-1">' + contact_data.data
                        + '</h4>'
                        + '</div>'
                        + '</a>');
                });
            }else{
                $('#contacts-to-call').append('<h5 class="text-center text-muted">No Contact data Found</h5>');
            }
        },
        error: function (error) {
            console.log(error)
            Swal.fire({ position: "top-end", icon: "error", title: "No Contact data Found", showConfirmButton: !1, timer: 1500 });
        }
    })
}