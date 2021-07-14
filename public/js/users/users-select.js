$(document).ready(function () {
    timezoneSelect($('#timezone'))
    languageSelect($('#edit-language'))
    languageSelect($('.language'))
})
function timezoneSelect(select) {
    var tzStrings = [
        { "label": "(GMT-12:00) International Date Line West", "value": "Etc/GMT+12" },
        { "label": "(GMT-11:00) Midway Island, Samoa", "value": "Pacific/Midway" },
        { "label": "(GMT-10:00) Hawaii", "value": "Pacific/Honolulu" },
        { "label": "(GMT-09:00) Alaska", "value": "US/Alaska" },
        { "label": "(GMT-08:00) Pacific Time (US & Canada)", "value": "America/Los_Angeles" },
        { "label": "(GMT-08:00) Tijuana, Baja California", "value": "America/Tijuana" },
        { "label": "(GMT-07:00) Arizona", "value": "US/Arizona" },
        { "label": "(GMT-07:00) Chihuahua, La Paz, Mazatlan", "value": "America/Chihuahua" },
        { "label": "(GMT-07:00) Mountain Time (US & Canada)", "value": "US/Mountain" },
        { "label": "(GMT-06:00) Central America", "value": "America/Managua" },
        { "label": "(GMT-06:00) Central Time (US & Canada)", "value": "US/Central" },
        { "label": "(GMT-06:00) Guadalajara, Mexico City, Monterrey", "value": "America/Mexico_City" },
        { "label": "(GMT-06:00) Saskatchewan", "value": "Canada/Saskatchewan" },
        { "label": "(GMT-05:00) Bogota, Lima, Quito, Rio Branco", "value": "America/Bogota" },
        { "label": "(GMT-05:00) Eastern Time (US & Canada)", "value": "US/Eastern" },
        { "label": "(GMT-05:00) Indiana (East)", "value": "US/East-Indiana" },
        { "label": "(GMT-04:00) Atlantic Time (Canada)", "value": "Canada/Atlantic" },
        { "label": "(GMT-04:00) Caracas, La Paz", "value": "America/Caracas" },
        { "label": "(GMT-04:00) Manaus", "value": "America/Manaus" },
        { "label": "(GMT-04:00) Santiago", "value": "America/Santiago" },
        { "label": "(GMT-03:30) Newfoundland", "value": "Canada/Newfoundland" },
        { "label": "(GMT-03:00) Brasilia", "value": "America/Sao_Paulo" },
        { "label": "(GMT-03:00) Buenos Aires, Georgetown", "value": "America/Argentina/Buenos_Aires" },
        { "label": "(GMT-03:00) Greenland", "value": "America/Godthab" },
        { "label": "(GMT-03:00) Montevideo", "value": "America/Montevideo" },
        { "label": "(GMT-02:00) Mid-Atlantic", "value": "America/Noronha" },
        { "label": "(GMT-01:00) Cape Verde Is.", "value": "Atlantic/Cape_Verde" },
        { "label": "(GMT-01:00) Azores", "value": "Atlantic/Azores" },
        { "label": "(GMT+00:00) Casablanca, Monrovia, Reykjavik", "value": "Africa/Casablanca" },
        { "label": "(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London", "value": "Etc/Greenwich" },
        { "label": "(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna", "value": "Europe/Amsterdam" },
        { "label": "(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague", "value": "Europe/Belgrade" },
        { "label": "(GMT+01:00) Brussels, Copenhagen, Madrid, Paris", "value": "Europe/Brussels" },
        { "label": "(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb", "value": "Europe/Sarajevo" },
        { "label": "(GMT+01:00) West Central Africa", "value": "Africa/Lagos" },
        { "label": "(GMT+02:00) Amman", "value": "Asia/Amman" },
        { "label": "(GMT+02:00) Athens, Bucharest, Istanbul", "value": "Europe/Athens" },
        { "label": "(GMT+02:00) Beirut", "value": "Asia/Beirut" },
        { "label": "(GMT+02:00) Cairo", "value": "Africa/Cairo" },
        { "label": "(GMT+02:00) Harare, Pretoria", "value": "Africa/Harare" },
        { "label": "(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius", "value": "Europe/Helsinki" },
        { "label": "(GMT+02:00) Jerusalem", "value": "Asia/Jerusalem" },
        { "label": "(GMT+02:00) Minsk", "value": "Europe/Minsk" },
        { "label": "(GMT+02:00) Windhoek", "value": "Africa/Windhoek" },
        { "label": "(GMT+03:00) Kuwait, Riyadh, Baghdad", "value": "Asia/Kuwait" },
        { "label": "(GMT+03:00) Moscow, St. Petersburg, Volgograd", "value": "Europe/Moscow" },
        { "label": "(GMT+03:00) Nairobi", "value": "Africa/Nairobi" },
        { "label": "(GMT+03:00) Tbilisi", "value": "Asia/Tbilisi" },
        { "label": "(GMT+03:30) Tehran", "value": "Asia/Tehran" },
        { "label": "(GMT+04:00) Abu Dhabi, Muscat", "value": "Asia/Muscat" },
        { "label": "(GMT+04:00) Baku", "value": "Asia/Baku" },
        { "label": "(GMT+04:00) Yerevan", "value": "Asia/Yerevan" },
        { "label": "(GMT+04:30) Kabul", "value": "Asia/Kabul" },
        { "label": "(GMT+05:00) Yekaterinburg", "value": "Asia/Yekaterinburg" },
        { "label": "(GMT+05:00) Islamabad, Karachi, Tashkent", "value": "Asia/Karachi" },
        { "label": "(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi", "value": "Asia/Calcutta" },
        { "label": "(GMT+05:30) Sri Jayawardenapura", "value": "Asia/Calcutta" },
        { "label": "(GMT+05:45) Kathmandu", "value": "Asia/Katmandu" },
        { "label": "(GMT+06:00) Almaty, Novosibirsk", "value": "Asia/Almaty" },
        { "label": "(GMT+06:00) Astana, Dhaka", "value": "Asia/Dhaka" },
        { "label": "(GMT+06:30) Yangon (Rangoon)", "value": "Asia/Rangoon" },
        { "label": "(GMT+07:00) Bangkok, Hanoi, Jakarta", "value": "Asia/Bangkok" },
        { "label": "(GMT+07:00) Krasnoyarsk", "value": "Asia/Krasnoyarsk" },
        { "label": "(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi", "value": "Asia/Hong_Kong" },
        { "label": "(GMT+08:00) Kuala Lumpur, Singapore", "value": "Asia/Kuala_Lumpur" },
        { "label": "(GMT+08:00) Irkutsk, Ulaan Bataar", "value": "Asia/Irkutsk" },
        { "label": "(GMT+08:00) Perth", "value": "Australia/Perth" },
        { "label": "(GMT+08:00) Taipei", "value": "Asia/Taipei" },
        { "label": "(GMT+09:00) Osaka, Sapporo, Tokyo", "value": "Asia/Tokyo" },
        { "label": "(GMT+09:00) Seoul", "value": "Asia/Seoul" },
        { "label": "(GMT+09:00) Yakutsk", "value": "Asia/Yakutsk" },
        { "label": "(GMT+09:30) Adelaide", "value": "Australia/Adelaide" },
        { "label": "(GMT+09:30) Darwin", "value": "Australia/Darwin" },
        { "label": "(GMT+10:00) Brisbane", "value": "Australia/Brisbane" },
        { "label": "(GMT+10:00) Canberra, Melbourne, Sydney", "value": "Australia/Canberra" },
        { "label": "(GMT+10:00) Hobart", "value": "Australia/Hobart" },
        { "label": "(GMT+10:00) Guam, Port Moresby", "value": "Pacific/Guam" },
        { "label": "(GMT+10:00) Vladivostok", "value": "Asia/Vladivostok" },
        { "label": "(GMT+11:00) Magadan, Solomon Is., New Caledonia", "value": "Asia/Magadan" },
        { "label": "(GMT+12:00) Auckland, Wellington", "value": "Pacific/Auckland" },
        { "label": "(GMT+12:00) Fiji, Kamchatka, Marshall Is.", "value": "Pacific/Fiji" },
        { "label": "(GMT+13:00) Nuku'alofa", "value": "Pacific/Tongatapu" }
    ];
    var options = [];
    //select = document.createElement("select");

    for (var i = 0; i < tzStrings.length; i++) {
        var tz = tzStrings[i],
            option = document.createElement("option");

        option.value = tz.value
        option.append(document.createTextNode(tz.label))
        select.append(option)
    }
}

function languageSelect(select) {
    var tzStrings = [
        { "value": "af", "label": "Afrikaans" },
        { "value": "sq", "label": "Albanian - shqip" },
        { "value": "am", "label": "Amharic - አማርኛ" },
        { "value": "ar", "label": "Arabic - العربية" },
        { "value": "an", "label": "Aragonese - aragonés" },
        { "value": "hy", "label": "Armenian - հայերեն" },
        { "value": "ast", "label": "Asturian - asturianu" },
        { "value": "az", "label": "Azerbaijani - azərbaycan dili" },
        { "value": "eu", "label": "Basque - euskara" },
        { "value": "be", "label": "Belarusian - беларуская" },
        { "value": "bn", "label": "Bengali - বাংলা" },
        { "value": "bs", "label": "Bosnian - bosanski" },
        { "value": "br", "label": "Breton - brezhoneg" },
        { "value": "bg", "label": "Bulgarian - български" },
        { "value": "ca", "label": "Catalan - català" },
        { "value": "ckb", "label": "Central Kurdish - کوردی (دەستنوسی عەرەبی)" },
        { "value": "zh", "label": "Chinese - 中文" },
        { "value": "zh-HK", "label": "Chinese (Hong Kong) - 中文（香港）" },
        { "value": "zh-CN", "label": "Chinese (Simplified) - 中文（简体）" },
        { "value": "zh-TW", "label": "Chinese (Traditional) - 中文（繁體）" },
        { "value": "co", "label": "Corsican" },
        { "value": "hr", "label": "Croatian - hrvatski" },
        { "value": "cs", "label": "Czech - čeština" },
        { "value": "da", "label": "Danish - dansk" },
        { "value": "nl", "label": "Dutch - Nederlands" },
        { "value": "en", "label": "English" },
        { "value": "en-AU", "label": "English (Australia)" },
        { "value": "en-CA", "label": "English (Canada)" },
        { "value": "en-IN", "label": "English (India)" },
        { "value": "en-NZ", "label": "English (New Zealand)" },
        { "value": "en-ZA", "label": "English (South Africa)" },
        { "value": "en-GB", "label": "English (United Kingdom)" },
        { "value": "en-US", "label": "English (United States)" },
        { "value": "eo", "label": "Esperanto - esperanto" },
        { "value": "et", "label": "Estonian - eesti" },
        { "value": "fo", "label": "Faroese - føroyskt" },
        { "value": "fil", "label": "Filipino" },
        { "value": "fi", "label": "Finnish - suomi" },
        { "value": "fr", "label": "French - français" },
        { "value": "fr-CA", "label": "French (Canada) - français (Canada)" },
        { "value": "fr-FR", "label": "French (France) - français (France)" },
        { "value": "fr-CH", "label": "French (Switzerland) - français (Suisse)" },
        { "value": "gl", "label": "Galician - galego" },
        { "value": "ka", "label": "Georgian - ქართული" },
        { "value": "de", "label": "German - Deutsch" },
        { "value": "de-AT", "label": "German (Austria) - Deutsch (Österreich)" },
        { "value": "de-DE", "label": "German (Germany) - Deutsch (Deutschland)" },
        { "value": "de-LI", "label": "German (Liechtenstein) - Deutsch (Liechtenstein)" },
        { "value": "de-CH", "label": "German (Switzerland) - Deutsch (Schweiz)" },
        { "value": "el", "label": "Greek - Ελληνικά" },
        { "value": "gn", "label": "Guarani" },
        { "value": "gu", "label": "Gujarati - ગુજરાતી" },
        { "value": "ha", "label": "Hausa" },
        { "value": "haw", "label": "Hawaiian - ʻŌlelo Hawaiʻi" },
        { "value": "he", "label": "Hebrew - עברית" },
        { "value": "hi", "label": "Hindi - हिन्दी" },
        { "value": "hu", "label": "Hungarian - magyar" },
        { "value": "is", "label": "Icelandic - íslenska" },
        { "value": "id", "label": "Indonesian - Indonesia" },
        { "value": "ia", "label": "Interlingua" },
        { "value": "ga", "label": "Irish - Gaeilge" },
        { "value": "it", "label": "Italian - italiano" },
        { "value": "it-IT", "label": "Italian (Italy) - italiano (Italia)" },
        { "value": "it-CH", "label": "Italian (Switzerland) - italiano (Svizzera)" },
        { "value": "ja", "label": "Japanese - 日本語" },
        { "value": "kn", "label": "Kannada - ಕನ್ನಡ" },
        { "value": "kk", "label": "Kazakh - қазақ тілі" },
        { "value": "km", "label": "Khmer - ខ្មែរ" },
        { "value": "ko", "label": "Korean - 한국어" },
        { "value": "ku", "label": "Kurdish - Kurdî" },
        { "value": "ky", "label": "Kyrgyz - кыргызча" },
        { "value": "lo", "label": "Lao - ລາວ" },
        { "value": "la", "label": "Latin" },
        { "value": "lv", "label": "Latvian - latviešu" },
        { "value": "ln", "label": "Lingala - lingála" },
        { "value": "lt", "label": "Lithuanian - lietuvių" },
        { "value": "mk", "label": "Macedonian - македонски" },
        { "value": "ms", "label": "Malay - Bahasa Melayu" },
        { "value": "ml", "label": "Malayalam - മലയാളം" },
        { "value": "mt", "label": "Maltese - Malti" },
        { "value": "mr", "label": "Marathi - मराठी" },
        { "value": "mn", "label": "Mongolian - монгол" },
        { "value": "ne", "label": "Nepali - नेपाली" },
        { "value": "no", "label": "Norwegian - norsk" },
        { "value": "nb", "label": "Norwegian Bokmål - norsk bokmål" },
        { "value": "nn", "label": "Norwegian Nynorsk - nynorsk" },
        { "value": "oc", "label": "Occitan" },
        { "value": "or", "label": "Oriya - ଓଡ଼ିଆ" },
        { "value": "om", "label": "Oromo - Oromoo" },
        { "value": "ps", "label": "Pashto - پښتو" },
        { "value": "fa", "label": "Persian - فارسی" },
        { "value": "pl", "label": "Polish - polski" },
        { "value": "pt", "label": "Portuguese - português" },
        { "value": "pt-BR", "label": "Portuguese (Brazil) - português (Brasil)" },
        { "value": "pt-PT", "label": "Portuguese (Portugal) - português (Portugal)" },
        { "value": "pa", "label": "Punjabi - ਪੰਜਾਬੀ" },
        { "value": "qu", "label": "Quechua" },
        { "value": "ro", "label": "Romanian - română" },
        { "value": "mo", "label": "Romanian (Moldova) - română (Moldova)" },
        { "value": "rm", "label": "Romansh - rumantsch" },
        { "value": "ru", "label": "Russian - русский" },
        { "value": "gd", "label": "Scottish Gaelic" },
        { "value": "sr", "label": "Serbian - српски" },
        { "value": "sh", "label": "Serbo-Croatian - Srpskohrvatski" },
        { "value": "sn", "label": "Shona - chiShona" },
        { "value": "sd", "label": "Sindhi" },
        { "value": "si", "label": "Sinhala - සිංහල" },
        { "value": "sk", "label": "Slovak - slovenčina" },
        { "value": "sl", "label": "Slovenian - slovenščina" },
        { "value": "so", "label": "Somali - Soomaali" },
        { "value": "st", "label": "Southern Sotho" },
        { "value": "es", "label": "Spanish - español" },
        { "value": "es-AR", "label": "Spanish (Argentina) - español (Argentina)" },
        { "value": "es-419", "label": "Spanish (Latin America) - español (Latinoamérica)" },
        { "value": "es-MX", "label": "Spanish (Mexico) - español (México)" },
        { "value": "es-ES", "label": "Spanish (Spain) - español (España)" },
        { "value": "es-US", "label": "Spanish (United States) - español (Estados Unidos)" },
        { "value": "su", "label": "Sundanese" },
        { "value": "sw", "label": "Swahili - Kiswahili" },
        { "value": "sv", "label": "Swedish - svenska" },
        { "value": "tg", "label": "Tajik - тоҷикӣ" },
        { "value": "ta", "label": "Tamil - தமிழ்" },
        { "value": "tt", "label": "Tatar" },
        { "value": "te", "label": "Telugu - తెలుగు" },
        { "value": "th", "label": "Thai - ไทย" },
        { "value": "ti", "label": "Tigrinya - ትግርኛ" },
        { "value": "to", "label": "Tongan - lea fakatonga" },
        { "value": "tr", "label": "Turkish - Türkçe" },
        { "value": "tk", "label": "Turkmen" },
        { "value": "tw", "label": "Twi" },
        { "value": "uk", "label": "Ukrainian - українська" },
        { "value": "ur", "label": "Urdu - اردو" },
        { "value": "ug", "label": "Uyghur" },
        { "value": "uz", "label": "Uzbek - o‘zbek" },
        { "value": "vi", "label": "Vietnamese - Tiếng Việt" },
        { "value": "wa", "label": "Walloon - wa" },
        { "value": "cy", "label": "Welsh - Cymraeg" },
        { "value": "fy", "label": "Western Frisian" },
        { "value": "xh", "label": "Xhosa" },
        { "value": "yi", "label": "Yiddish" },
        { "value": "yo", "label": "Yoruba - Èdè Yorùbá" },
        { "value": "zu", "label": "Zulu - isiZulu" },
    ];
    var options = [];
    //select = document.createElement("select");

    for (var i = 0; i < tzStrings.length; i++) {
        var tz = tzStrings[i],
            option = document.createElement("option");

        option.value = tz.value
        option.append(document.createTextNode(tz.label))
        select.append(option)
    }
}