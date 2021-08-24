function call(contact_data_id, phone_number) {
    username = $('#button-call-one').attr('data-sipaccount-username')

    $('#call-number').html(phone_number)

    var audio = new Audio(url_audio + '/phone_dialing.wav');
    audio.play();

    setTimeout(function() {
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
            } else {
                clearInterval(timer)
                $('#call-duration').html('Call End');
                setTimeout(() => {
                    $('#call-two-modal').modal('toggle');
                    $('#call-duration').html('Dialing...');
                }, 1500);
            }
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