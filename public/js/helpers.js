function getElementByName(element) {
    elements = ["accounts", "appointments", "communications", "contact_data", "contacts", "contacts_companies", "contacts_field", "contacts_persons", "custom_field", "email_accounts", "fax_accounts", "groups", "imports", "logs", "notes", "sip_accounts", "sms_accounts", "users", "users_permissions"];
    return elements.indexOf(element);
}
function getElementName(element) {
    elements = ["accounts", "appointments", "communications", "contact_data", "contacts", "contacts_companies", "contacts_field", "contacts_persons", "custom_field", "email_accounts", "fax_accounts", "groups", "imports", "logs", "notes", "sip_accounts", "sms_accounts", "users", "users_permissions"];
    return elements[element];
}

function getNoteClassName($noteClass) {
    if ($noteClass == 1)
        return "Description";
    if ($noteClass == 2)
        return "Note";
    if ($noteClass == 3)
        return "Task";
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
        $('#' + inputId).attr('data-parsley-pattern', '/^[a-zA-Z0-9._]+$/')
    if (contactClass == 6)
        $('#' + inputId).attr('data-parsley-pattern', '^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$')
    if (contactClass == 8)
        $('#' + inputId).attr('data-parsley-pattern', '^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$')
    if (contactClass == 9)
        $('#' + inputId).attr('data-parsley-pattern', '/^[a-z\d.]{5,}$/i')
}

function setTypeInput(formId, inputId, contactClass) {
    if (contactClass == 0 || contactClass == 1 || contactClass == 2 || contactClass == 7) { } else if (contactClass == 3) {
        $('#' + inputId).attr('type', 'email')
        $('#' + inputId).attr('placeholder', 'email@gmail.com')
    } else {
        $('#' + inputId).attr('type', 'text')
        $('#' + inputId).attr('placeholder', 'username')
    }
}

function setTippyOnBtnXs() {
    tippy('.btn-xs', {
        // change these to your liking
        arrow: true,
        placement: 'bottom', // top, right, bottom, left
        duration: [600, 300], //ms
        distance: 15, //px or string
        maxWidth: 300, //px or string
        animation: 'perspective',
        // leave these as they are
        allowHTML: true,
        theme: 'custom',
        ignoreAttributes: true,
        content(reference) {
            const title = reference.getAttribute('title');
            reference.removeAttribute('title');
            return title;
        },
        interactive: "true",
        hideOnClick: false, // if you want
        onShow(instance) {
            setTimeout(() => {
                instance.hide();
            }, 1000);
        }

    });
}

function openModal(modal) {
}

$(document).ready(function () {
    $(window.location.hash).modal("show");
    $('#open-create-contact-modal').on('click', function () {
        window.location.replace(route('contacts') + '#create-contact-modal');
    })
    $('#open-create-appointment-modal').on('click', function () {
        window.location.replace(route('contacts') + '#create-appointment-modal');
    })
    $('#open-create-user-modal').on('click', function () {
        window.location.replace(route('users') + '#create-user-modal');
    })
});