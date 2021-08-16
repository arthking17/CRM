$(document).ready(function() {

    /**
     * editing communication ajax + validation
     */
    $("#edit-communication").parsley().on("field:validated", function() {
        var e = 0 === $(".parsley-error").length;
        $("#edit-communication .alert-info").toggleClass("d-none", !e), $("#edit-communication .alert-warning").toggleClass("d-none", e);
    }).on("submit", function() {
        return !1;
    });
});