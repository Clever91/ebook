<?php

return [

    // Add any language you want to support
    'locales' => [
        'uz' => [
            'icon' => 'uz',
            'emoji' => '🇺🇿',
            'name' => "O'zbek"
        ],
        'oz' => [
            'icon' => 'uz',
            'emoji' => '🇺🇿',
            'name' => 'Ўзбек'
        ],
        'ru' => [
            'icon' => 'ru',
            'emoji' => '🇷🇺',
            'name' => "Русский"
        ],
        'en' => [
            'icon' => 'us',
            'emoji' => '🇺🇸',
            'name' => 'English'
        ],
    ],

    // Default locale will not be shown in the url.
    // If enabled and 'en' is the default language:
    // / -> English page, /de -> German page
    // If disabled:
    // /en -> English Page, /de -> German page
    'hide_default_locale_in_url' => false,

    // Use query parameter if there are no localized routes available.
    // Set it to null to disable usage of query parameter.
    'locale_query_parameter' => 'hl',

    // Enable redirect if there is a localized route available and the user locale was detected (via HTTP header or session)
    'redirect_to_localized_route' =>  true,

    // Try to detect user locale via Accept-Language header.
    'detect_via_http_header' => true,

    // Remember the user locale using a cookie.
    'remember_via_cookie' => true,

    // Cookie expire time in minutes
    'cookie_expires' => 20160 // 14 days

];
