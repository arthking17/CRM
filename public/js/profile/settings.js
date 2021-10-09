$(document).ready(function() {
    $('#settings-btn-add').attr('data-bs-target', '#create-email_account-modal')
    $('#settings-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Email Account ')
    $('#email-account-link').on('click', function() {
        $('#settings-btn-add').attr('data-bs-target', '#create-email_account-modal')
        $('#settings-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Email Account ')
    })
    $('#sms-account-link').on('click', function() {
        $('#settings-btn-add').attr('data-bs-target', '#create-sms_account-modal')
        $('#settings-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Sms Account ')
    })
    $('#sip-account-link').on('click', function() {
        $('#settings-btn-add').attr('data-bs-target', '#create-sip_account-modal')
        $('#settings-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Sip Account ')
    })
    $('#shortcodes-link').on('click', function() {
        $('#settings-btn-add').attr('data-bs-target', '#create-shortcode-modal')
        $('#settings-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add ShortCode ')
    })
    $('#custom_fields-link').on('click', function() {
        $('#settings-btn-add').attr('data-bs-target', '#create-custom-field-modal')
        $('#settings-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Custom Field ')
    })
    $('#users-sip-account-link').on('click', function() {
        $('#settings-btn-add').attr('data-bs-target', '#create-users_sip_account-modal')
        $('#settings-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add User Sip Account ')
    })
});