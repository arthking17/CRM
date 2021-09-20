$(document).ready(function() {
    $('#global-btn-add').attr('data-bs-target', '#create-email_account-modal')
    $('#global-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Email Account ')
    $('#email-account-link').on('click', function() {
        $('#global-btn-add').attr('data-bs-target', '#create-email_account-modal')
        $('#global-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Email Account ')
    })
    $('#sms-account-link').on('click', function() {
        $('#global-btn-add').attr('data-bs-target', '#create-sms_account-modal')
        $('#global-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Sms Account ')
    })
    $('#sip-account-link').on('click', function() {
        $('#global-btn-add').attr('data-bs-target', '#create-sip_account-modal')
        $('#global-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Sip Account ')
    })
    $('#shortcodes-link').on('click', function() {
        $('#global-btn-add').attr('data-bs-target', '#create-shortcode-modal')
        $('#global-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add ShortCode ')
    })
    $('#custom_fields-link').on('click', function() {
        $('#global-btn-add').attr('data-bs-target', '#create-custom-field-modal')
        $('#global-btn-add').html('<i class="mdi mdi-plus-circle me-1"></i> Add Custom Field ')
    })
});