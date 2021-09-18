$(document).ready(function () {
    $( "#create-appointment-modal" ).on('shown.bs.modal', function(){
        console.log('test'+$('#contact_id').html())
        $('#create-appointment-contact_id').val($('#contact_id').html())
    });
});