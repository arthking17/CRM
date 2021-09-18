$(document).ready(function () {
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        
        $('#btn-add-contact_data').addClass('d-none')
        $('#tab-pane-btn-add').addClass('d-none')
        $('#btn-add-note').addClass('d-none')

        var target = $(e.target).attr("href") // activated tab

        if (target == '#contact_data') {
            $('#btn-add-contact_data').removeClass('d-none')
        } else if (target == '#notes') {
            $('#btn-add-note').removeClass('d-none')
        } else if (target == '#communications') {
            $('#tab-pane-btn-add').empty().html('<button id="btn-add-communication" type="button" class="btn btn-primary waves-effect waves-light"'+
            'data-bs-toggle="modal" data-bs-target="#create-communication-modal"><i class="mdi mdi-plus-circle me-1"></i> Add Communication</button>')
            $('#tab-pane-btn-add').removeClass('d-none')
        } else if (target == '#appointments') {
            $('#tab-pane-btn-add').empty().html('<button id="btn-add-appointment" type="button" class="btn btn-primary waves-effect waves-light"'+
            'data-bs-toggle="modal" data-bs-target="#create-appointment-modal"><i class="mdi mdi-plus-circle me-1"></i> Add Appointment</button>')
            $('#tab-pane-btn-add').removeClass('d-none')
        }
    });
});