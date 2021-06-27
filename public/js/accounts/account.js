$(document).ready(function () {
    $(".parsley-account").parsley()
})/*, $(function () {
    $("#create-account").parsley().on("field:validated", function () {
        var e = 0 === $(".parsley-error").length;
        $(".alert-info").toggleClass("d-none", !e), $(".alert-warning").toggleClass("d-none", e)
    }).on("form:submit", function () {
        return !1
    })
})*/;
