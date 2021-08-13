!(function(t) {
    "use strict";

    function e() {}
    (e.prototype.init = function() {
        t(".colorpicker").spectrum({ showInitial: !0, showInput: !0 }),
            t(".datepicker").flatpickr({
                dateFormat: "Y-m-d",
                altInput: true,
            }),
            t(".datetimepicker").flatpickr({
                enableTime: true,
                altInput: true,
                dateFormat: "Y-m-d H:i",
            }),
            t(".birthdate-datepicker").flatpickr({
                altInput: true,
                maxDate: 'today',
                dateFormat: "Y-m-d",
            }),
            t("#search-contact-creation_date").flatpickr({
                altInput: true,
                mode: "range",
                //maxDate: "today",
                dateFormat: "Y-m-d",
            });
    }),
    (t.FormPickers = new e()),
    (t.FormPickers.Constructor = e);
})(window.jQuery),
(function() {
    "use strict";
    window.jQuery.FormPickers.init();
})();