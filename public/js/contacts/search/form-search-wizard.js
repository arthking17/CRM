$(document).ready(function () {
    $('#search-contact-class').on('change', function () {
        if ($(this).val() == "1") {
            $('#search-nav-tab-info a:nth-of-type(1)').attr('href', '#search-person-contact')
            //disable validation on companies contact tab
            $('#search-contact .companie-required').attr('required', false)
            //active validation on person contact tab
            $('#search-contact .person-required').attr('required', true)
        } else if ($(this).val() == "2") {
            $('#search-nav-tab-info a:nth-of-type(1)').attr('href', '#search-companie-contact')
            //active validation on companies contact tab
            $('#search-contact .companie-required').attr('required', true)
            //disable validation on person contact tab
            $('#search-contact .person-required').attr('required', false)
        }
    })

    $("#search-contact-wizard").bootstrapWizard({
        onTabShow: function (t, r, a) {
            var o = ((a + 1) / r.find("li").length) * 100;
            $("#search-contact-wizard")
                .find(".bar")
                .css({ width: o + "%" });
        },
    });

    // initialise plugin
    for (var i = 0; i < 10; i++) {
        if (i == 0 || i == 1 || i == 2 || i == 7) {
            input = $('#search-contact-' + getContactTypeByClass(i))
            input.intlTelInput({
                initialCountry: "auto",
                geoIpLookup: function (callback) {
                    $.get('https://ipinfo.io?token=947e2827248fe2', function () { }, "jsonp").always(function (resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "TN";
                        callback(countryCode);
                    });
                },
                utilsScript: "/twilio/js/utils.js?1613236686837" // just for formatting/placeholders etc
            });
        }
    }

    $("#search-contact-id").selectize({
        valueField: 'id',
        labelField: 'id',
        searchField: ['id'],
        maxItems: null,
        //item: [],
        create: false,
        closeAfterSelect: true,

        load: (query, callback) => {
            if (!query.length) return callback();
            $.ajax({
                type: "GET",
                url: route('contacts.id', query),
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    callback(response)
                },
                error: function () {
                    callback()
                }
            })
        },
        placeholder: 'Contact Id',
        render: {
            option: (item, escape) => {
                return `<div class="card-success">${escape(item.id)}</div>`;
            },
        }
    });

    $("#search-contact-status").selectize({
        maxItems: 3,
        create: false,
        closeAfterSelect: true,
        placeholder: 'Status',
    });

    $("#search-contact-account_id").selectize({
        maxItems: null,
        create: false,
        closeAfterSelect: true,
        placeholder: 'Account',
    });

    $("#search-contact-group_id").selectize({
        maxItems: null,
        create: false,
        closeAfterSelect: true,
        placeholder: 'Group',
    });

    $("#search-contact-source_id").selectize({
        valueField: 'source_id',
        labelField: 'source_id',
        searchField: ['source_id'],
        maxItems: null,
        item: [],
        create: false,
        closeAfterSelect: true,

        load: (query, callback) => {
            if (!query.length) return callback();
            $.ajax({
                type: "GET",
                url: route('contacts.source_id', query),
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    callback(response)
                },
                error: function () {
                    callback()
                }
            })
        },
        placeholder: 'Source id',
    });

    $("#search-contact-profile").selectize({
        maxItems: null,
        create: false,
        closeAfterSelect: true,
        placeholder: 'Profile',
    });

    $("#search-contact-person_country").selectize({
        maxItems: null,
        create: false,
        closeAfterSelect: true,
        placeholder: 'Country',
    });

    $("#search-contact-person_language").selectize({
        maxItems: null,
        create: false,
        closeAfterSelect: true,
        placeholder: 'Language',
    });

    $("#search-contact-activity").selectize({
        maxItems: null,
        create: false,
        closeAfterSelect: true,
        placeholder: 'Activity',
    });

    $("#search-contact-companies_country").selectize({
        maxItems: null,
        create: false,
        closeAfterSelect: true,
        placeholder: 'Country',
    });

    $("#search-contact-companies_language").selectize({
        maxItems: null,
        create: false,
        closeAfterSelect: true,
        placeholder: 'Language',
    });
})