$(document).ready(function () {
    $('.nav-link').on('click', function () {
        $('#global-btn-add').addClass('d-none')
        $('#global-btn-add').attr('onclick', '#')
        $('#global-btn-add').attr('data-bs-toggle', 'modal')
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
        $('#global-btn-add').attr('onclick', 'viewFomAddNote(' + $('#user_id').html() + ', ' + getElementByName('users') + ')')
        $('#global-btn-add').removeClass('d-none')
    })
    $('#permissions-link').on('click', function () {
        $('#global-btn-add').attr('data-bs-target', '')
        $('#global-btn-add').attr('data-bs-toggle', '')
        $('#global-btn-add').attr('onclick', 'updatePermissions();')
        $('#global-btn-add').html('<i class="mdi mdi-content-save me-1"></i> Update Permissions ')
        $('#global-btn-add').removeClass('d-none')
    })
});