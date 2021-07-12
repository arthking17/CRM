<?php

if (!function_exists('page_title')) {
    function page_title(?string $title = null): string
    {
        return $title
            ? $title . ' | ' . config('app.name')
            : config('app.name');
    }
}

if (!function_exists('getElementName')) {
    function getElementName($element): string
    {
        if ($element == 1)
            return "accounts";
        if ($element == 2)
            return "appointments";
        if ($element == 3)
            return "communications";
        if ($element == 4)
            return "contact_data";
        if ($element == 5)
            return "contacts";
        if ($element == 6)
            return "contacts_companies";
        if ($element == 7)
            return "contacts_persons";
        if ($element == 8)
            return "email_accounts";
        if ($element == 9)
            return "fax_accounts";
        if ($element == 10)
            return "groups";
        if ($element == 11)
            return "imports";
        if ($element == 12)
            return "logs";
        if ($element == 13)
            return "notes";
        if ($element == 14)
            return "sip_accounts";
        if ($element == 15)
            return "sms_accounts";
        if ($element == 16)
            return "users";
        if ($element == 17)
            return "users_permissions";
    }
}
