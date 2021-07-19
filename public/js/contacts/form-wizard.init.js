$(document).ready(function () {
    "use strict";
    $('#form_create-class').on('change', function () {
        if($(this).val() == "1"){
            $('#nav-tab-info a:nth-of-type(1)').attr('href', '#personcontact')
            //disable validation on companies contact tab
            $('#form_create .companie-required').attr('required', false)
            //active validation on person contact tab
            $('#form_create .person-required').attr('required', true)
        }else if($(this).val() == "2"){
            $('#nav-tab-info a:nth-of-type(1)').attr('href', '#companiescontact')
            //active validation on companies contact tab
            $('#form_create .companie-required').attr('required', true)
            //disable validation on person contact tab
            $('#form_create .person-required').attr('required', false)
        }
    })
    $('#form_edit-class').on('change', function () {
        if($(this).val() == "1"){
            $('#edit-nav-tab-info a:nth-of-type(1)').attr('href', '#edit-personcontact')
            //disable validation on companies contact tab
            $('#form_edit .companie-required').attr('required', false)
            //active validation on person contact tab
            $('#form_edit .person-required').attr('required', true)
        }else if($(this).val() == "2"){
            $('#edit-nav-tab-info a:nth-of-type(1)').attr('href', '#edit-companiescontact')
            //active validation on companies contact tab
            $('#form_edit .companie-required').attr('required', true)
            //disable validation on person contact tab
            $('#form_edit .person-required').attr('required', false)
        }
    })
    $("#contactwizard").bootstrapWizard({
        onTabShow: function (t, r, a) {
            var o = ((a + 1) / r.find("li").length) * 100;
            $("#contactwizard")
                .find(".bar")
                .css({ width: o + "%" });
        },
    });
    $("#edit-contactwizard").bootstrapWizard({
        onTabShow: function (t, r, a) {
            var o = ((a + 1) / r.find("li").length) * 100;
            $("#edit-contactwizard")
                .find(".bar")
                .css({ width: o + "%" });
        },
    });
});
