function getElementByName(element) {
    elements = ["accounts", "appointments", "communications", "contact_data", "contacts", "contacts_companies", "contacts_field", "contacts_persons", "custom_field", "email_accounts", "fax_accounts", "groups", "imports", "logs", "notes", "sip_accounts", "sms_accounts", "users", "users_permissions"];
    return elements.indexOf(element);
}

function getContactTypeByClass(contactClass) {
    if (contactClass == 0)
        return "phone_number";
    if (contactClass == 1)
        return "mobile";
    if (contactClass == 2)
        return "fax_number";
    if (contactClass == 3)
        return "email";
    if (contactClass == 4)
        return "facebook";
    if (contactClass == 5)
        return "instagram";
    if (contactClass == 6)
        return "skype";
    if (contactClass == 7)
        return "whatsapp";
    if (contactClass == 8)
        return "viber";
    if (contactClass == 9)
        return "messenger";
}

function setPatternTypeByClass(inputId, contactClass) {
    if (contactClass == 3)
        $('#' + inputId).attr('data-parsley-pattern', '^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$')
    if (contactClass == 4)
        $('#' + inputId).attr('data-parsley-pattern', '/^[a-z\d.]{5,}$/i')
    if (contactClass == 5)
        $('#' + inputId).attr('data-parsley-pattern', '^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$')
    if (contactClass == 6)
        $('#' + inputId).attr('data-parsley-pattern', '^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$')
    if (contactClass == 8)
        $('#' + inputId).attr('data-parsley-pattern', '^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$')
    if (contactClass == 9)
        $('#' + inputId).attr('data-parsley-pattern', '^[a-zA-Z-]+ ?.* [a-zA-Z-]+$')
}

function setTypeInput(formId, inputId, contactClass) {
    if (contactClass == 0 || contactClass == 1 || contactClass == 2 || contactClass == 7) {} else if (contactClass == 3) {
        $('#' + inputId).attr('type', 'email')
        $('#' + inputId).attr('placeholder', 'email@gmail.com')
    } else {
        $('#' + inputId).attr('type', 'text')
        $('#' + inputId).attr('placeholder', 'username')
    }
}