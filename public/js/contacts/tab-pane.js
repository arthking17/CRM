$(document).ready(function () {
    $('.nav-link').on('click', function () {
        $('#global-btn-add').addClass('d-none')
        $('#div-global-btn-add').addClass('d-none')
        $('#global-btn-add').attr('onclick', '#')
    })
    $('#appointments-link').on('click', function () {
        $('#global-btn-add').attr('data-bs-target', '#create-appointment-modal')
        $('#global-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Appointment ')
        $('#global-btn-add').removeClass('d-none')
    })
    $('#communications-link').on('click', function () {
        $('#global-btn-add').attr('data-bs-target', '#create-communication-modal')
        $('#global-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Communication ')
        $('#global-btn-add').removeClass('d-none')
    })
    $('#notes-link').on('click', function () {
        $('#global-btn-add').attr('data-bs-target', '#create-note-modal')
        $('#global-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Note ')
        $('#global-btn-add').attr('onclick', 'viewFomAddNote(' + $('#contact_id').html() + ', ' + getElementByName('contacts') + ')')
        $('#global-btn-add').removeClass('d-none')
    })
    $('#contact_data-link').on('click', function () {
        $('#div-global-btn-add').html($('#btn-add-contact_data').html())
        $('#div-global-btn-add').removeClass('d-none')
    })
});