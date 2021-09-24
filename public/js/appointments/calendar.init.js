!(function(l) {
    "use strict";

    function e() {
        (this.$body = l("body")),
        (this.$modal = l("#edit-appointment-modal")),
        (this.$calendar = l("#calendar")),
        (this.$formEvent = l("#edit-appointment")),
        (this.$btnSaveEvent = l("#btn-edit-appointment")),
        (this.$modalTitle = l("#modal-title")),
        (this.$calendarObj = null),
        (this.$selectedEvent = null),
        (this.$newEventData = null);
    }
    (e.prototype.init = function() {
        var a = this;
        $.get(route('appointments.all'), function(data) {
            var t = [];
            data.forEach(element => {
                if (element.class == 1)
                    t.push({ title: element.subject, start: new Date(element.start_date), end: new Date(element.end_date), className: "bg-info" })
                else if (element.class == 2)
                    t.push({ title: element.subject, start: new Date(element.start_date), end: new Date(element.end_date), className: "bg-danger" })
            });
            (a.$calendarObj = new FullCalendar.Calendar(a.$calendar[0], {
                slotDuration: "00:15:00",
                slotMinTime: "08:00:00",
                slotMaxTime: "19:00:00",
                themeSystem: "bootstrap",
                bootstrapFontAwesome: !1,
                buttonText: { today: "Today", month: "Month", week: "Week", day: "Day", list: "List", prev: "Prev", next: "Next" },
                initialView: "dayGridMonth",
                handleWindowResize: !0,
                height: l(window).height() - 200,
                headerToolbar: { left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth" },
                initialEvents: t,
                editable: !1,
                droppable: !1,
                selectable: !1,
            })),
            a.$calendarObj.render();
        });
    }),
    (l.CalendarApp = new e()),
    (l.CalendarApp.Constructor = e);
})(window.jQuery),
(function() {
    "use strict";
    window.jQuery.CalendarApp.init();
})();