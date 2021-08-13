$(window).on("load", function() {
    $("#datatable-contacts").footable(),
        $("#demo-foo-accordion")
        .footable()
        .on("footable_row_expanded", function(o) {
            $("#demo-foo-accordion tbody tr.footable-detail-show")
                .not(o.row)
                .each(function() {
                    $("#demo-foo-accordion").data("footable").toggleDetail(this);
                });
        });
});