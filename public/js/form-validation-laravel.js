function laravelValidation(formId, errors) {
    $("#" + formId + " .alert-info").toggleClass("d-none"), $("#" + formId + " .alert-warning").toggleClass("d-none");
    $.each(errors, function(prefix, val) {
        if ($('#' + formId + '-' + prefix).hasClass('parsley-success'))
            $('#' + formId + '-' + prefix).removeClass('parsley-success')
        if ($('#' + formId + '-' + prefix).hasClass('parsley-error'))
            $('#' + formId + '-' + prefix).removeClass('parsley-error')
        if ($('#error-' + prefix).length)
            $('#error-' + prefix).remove()
        $('#' + formId + '-' + prefix).after('<ul class=\"parsley-errors-list filled\" id=\"error-' + formId + '-' + prefix + '\" aria-hidden=\"false\">' +
            '<li class=\"parsley-required\">' + val[0] + '</li></ul>')
        $('#' + formId + '-' + prefix).addClass('parsley-error')
    })
}

function cleanErrorsInForm(formId, errors) {
    $.each(errors, function(prefix, val) {
        if ($('#' + formId + '-' + prefix).hasClass('parsley-error'))
            $('#' + formId + '-' + prefix).removeClass('parsley-error')
        $('#error-' + formId + '-' + prefix).remove()
    })
}

function showPassword(id) {
    if ($('#' + id).attr('type') === 'password') {
        $('#' + id).attr('type', 'text')
    } else {
        $('#' + id).attr('type', 'password')
    }
}

$('#profile-settings').on('click', function() {
    sessionStorage.setItem("profile-tab-panel", 'settings');
})
$('#profile-about').on('click', function() {
    sessionStorage.setItem("profile-tab-panel", 'about');
})