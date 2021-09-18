$(window).on("load", function() {
    dataTablecontacts = $('#datatable-contacts').DataTable({
        stateSave: 0,
        lengthChange: !0,
        language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
    });
});