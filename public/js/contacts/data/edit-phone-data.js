function setUpTypeInputFormEdit(input) {

    // initialise plugin add contact number form
    numberType = $('#create-phone-data-class').val()
    if (numberType == '0')
        numberType = 'personal_number'
    else if (numberType == '1')
        numberType = 'mobile'
    else if (numberType == '2')
        numberType = 'fixed_line'
    else if (numberType == '7')
        numberType = 'personal_number'
    else
        numberType = 'personal_number'
    input.removeAttr('placeholder')
    return input.intlTelInput("destroy").intlTelInput({
        initialCountry: "auto",
        placeholderNumberType: numberType,
        preferredCountries: ['tn', 'ca', 'fr', 'dz', 'uk', 'ma', 'eg', 'es', 'ch', 'us', 'gb'],
        utilsScript: "/twilio/js/utils.js?1613236686837"
    });
}

$(document).ready(function() {
    /**
     * updating contact phone number ajax + validation
     */
    var input = $("#edit-phone-data-data")

    // here, the index maps to the error code returned from getValidationError - see readme
    var errorMap = ["This value is an Invalid number", "The country code is Invalid", "This value is Too short", "THis value is Too long", "This value is an Invalid number"];

    $('#edit-phone-data').submit(function(e) {
        e.preventDefault();
        if (checkForm()) {
            var phoneNumberString = input.intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);
            console.log(phoneNumberString);
            input.val(phoneNumberString)
            $.ajax({
                type: "POST",
                url: route('contacts.data.update'),
                data: new FormData(this),
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    console.log(response)
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    $('#edit-phone-data-modal').modal('toggle')
                    $.get('/contacts/data/get/' + response.contact_data.element_id, function(contact_data) {
                        if (contact_data.length) {
                            $('#contact_data-info-card').empty().html(contact_data);
                        }
                    })
                },
                error: function(error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while updating that contact Data", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        edit_contact_data_errors = error.responseJSON.errors
                        laravelValidation('edit-contact-data', error.responseJSON.errors)
                    }
                }
            });
        }

        function checkForm() {
            cleanErrorsInForm('edit-phone-data', errors_edit_phone_data)
            var regExp = /[a-zA-Z]/g;
            if (regExp.test(input.val())) {
                errorData = errorMap[0]
                errors_edit_phone_data = { 'data': { 0: errorData } }
                laravelValidation('edit-phone-data', errors_edit_phone_data)
            } else {
                if (input.val().trim()) {
                    if (edit_iti.intlTelInput("isValidNumber")) {
                        console.log('success')
                        input.addClass("parsley-success");
                        return true
                    } else {
                        var errorCode = edit_iti.intlTelInput("getValidationError");
                        if (errorCode == -99) {
                            errorData = errorMap[0]
                        } else
                            errorData = errorMap[errorCode]
                        errors_edit_phone_data = { 'data': { 0: errorData } }
                        laravelValidation('edit-phone-data', errors_edit_phone_data)
                    }
                } else {
                    errorData = 'this value is required'
                    errors_edit_phone_data = { 'data': { 0: errorData } }
                    laravelValidation('edit-phone-data', errors_edit_phone_data)
                }
            }
            return false
        }

        // on click / change flag: check
        input.change(function() {
            checkForm()
        });
    });
})