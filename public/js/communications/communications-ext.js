$(document).ready(function () {
    $( "#create-communication-modal" ).on('shown.bs.modal', function(){
        console.log('test'+$('#contact_id').html())
        $('#create-communication-contact_id').val($('#contact_id').html())
    });
});