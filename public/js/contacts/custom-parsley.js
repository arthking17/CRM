window.ParsleyValidator
    .addValidator('maxdate', function (value, requirement) {
        // is valid date?
        var timestamp = Date.parse(value),
            minTs = Date.parse(requirement);

        return isNaN(timestamp) ? false : timestamp < minTs;
    }, 32)
    .addMessage('en', 'maxdate', 'This date should be less than %s');


window.ParsleyValidator
    .addValidator('fileextension', function (value, requirement) {
        var tagslistarr = requirement.split(',');
        var fileExtension = value.split('.').pop();
        var arr = [];
        $.each(tagslistarr, function (i, val) {
            arr.push(val);
        });
        if (jQuery.inArray(fileExtension.toLowerCase(), arr) != '-1') {
            return true;
        } else {
            return false;
        }
    }, 32)
    .addMessage('en', 'fileextension', 'This photo must be a file of type: jpg, png, jpeg.')
    .addMessage('fr', 'fileextension', 'Cette photo doit être un fichier d\'extension jpg, png, jpeg.');