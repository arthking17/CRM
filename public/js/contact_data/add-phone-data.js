function setUpTypeInputFormCreate(input) {

    // initialise plugin add contact number form
    numberType = $('#create-phone-data-class').val()
    if (numberType == 0)
        numberType = 'MOBILE'
    else if (numberType == 1)
        numberType = 'MOBILE'
    else if (numberType == 2)
        numberType = 'FIXED_LINE'
    else if (numberType == 7)
        numberType = 'MOBILE'
    else
        numberType = 'MOBILE'
    console.log(numberType)
    input.removeAttr('placeholder')
    return input.intlTelInput("destroy").intlTelInput({
        initialCountry: "auto",
        placeholderNumberType: numberType,
        preferredCountries: ['tn', 'ca', 'fr', 'dz', 'uk', 'ma', 'eg', 'es', 'ch', 'us', 'gb'],
        geoIpLookup: function (callback) {
            $.get('https://ipinfo.io?token=947e2827248fe2', function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "tn";
                callback(countryCode);
            });
        },
        utilsScript: "/twilio/js/utils.js?1613236686837"
    });
}
$(document).ready(function () {
    /**
     * creating contact phone number ajax + validation
     */
    var input = $("#create-phone-data-data")

    // here, the index maps to the error code returned from getValidationError - see readme
    var errorMap = ["This value is an Invalid number", "The country code is Invalid", "This value is Too short", "THis value is Too long", "This value is an Invalid number"];

    $('#create-phone-data').submit(function (e) {
        e.preventDefault();
        if (checkForm()) {
            var phoneNumberString = input.intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);
            console.log(phoneNumberString);
            input.val(phoneNumberString)
            $.ajax({
                type: "POST",
                url: route('contacts.data.create'),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    console.log(response)
                    $('#create-phone-data-modal').modal('toggle')
                    Swal.fire({ position: "top-end", icon: "success", title: response.success, showConfirmButton: !1, timer: 1500 });
                    //$('#create-contact-data')[0].reset();
                    var contact_data = response.contact_data;
                    $.get(route('contacts.data.get', {'element_id':contact_data.element_id, 'element':contact_data.element}), function (contact_data) {
                        if (contact_data.length) {
                            $('#contact_data').empty().html(contact_data);
                            setTippyOnBtnXs();
                        }
                    })
                },
                error: function (error) {
                    console.log(error)
                    Swal.fire({ position: "top-end", icon: "error", title: "Error while adding that contact Data", showConfirmButton: !1, timer: 1500 });
                    if (typeof error.responseJSON !== 'undefined' && typeof error.responseJSON.errors !== 'undefined') {
                        errors_create_phone_data = error.responseJSON.errors
                        laravelValidation('create-phone-data', error.responseJSON.errors)
                    }
                }
            });
        }

        function checkForm() {
            cleanErrorsInForm('create-phone-data', errors_create_phone_data)
            var regExp = /[a-zA-Z]/i;
            if (regExp.test(input.val())) {
                errorData = errorMap[0]
                errors_create_phone_data = { 'data': { 0: errorData } }
                laravelValidation('create-phone-data', errors_create_phone_data)
            } else {
                if (input.val().trim()) {
                    if (iti.intlTelInput("isValidNumber")) {
                        console.log('success')
                        input.addClass("parsley-success");
                        return true
                    } else {
                        var errorCode = iti.intlTelInput("getValidationError");
                        if (errorCode == -99) {
                            errorData = errorMap[0]
                        } else
                            errorData = errorMap[errorCode]
                        errors_create_phone_data = { 'data': { 0: errorData } }
                        laravelValidation('create-phone-data', errors_create_phone_data)
                    }
                } else {
                    errorData = 'this value is required'
                    errors_create_phone_data = { 'data': { 0: errorData } }
                    laravelValidation('create-phone-data', errors_create_phone_data)
                }
            }
            return false
        }

        // on click / change flag: check
        input.change(function () {
            checkForm()
        });
    });
})