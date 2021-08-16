$(document).ready(function() {

    /**
     * editing appointment ajax + validation
     */
    $("#edit-appointment").parsley().on("field:validated", function() {
        var e = 0 === $(".parsley-error").length;
        $("#edit-appointment .alert-info").toggleClass("d-none", !e), $("#edit-appointment .alert-warning").toggleClass("d-none", e);
    }).on("submit", function() {
        return !1;
    });
});