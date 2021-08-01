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

if (!function_exists('getNoteClassName')) {
    function getNoteClassName($noteClass): string
    {
        if ($noteClass == 1)
            return "Description";
        if ($noteClass == 2)
            return "Note";
        if ($noteClass == 3)
            return "Task";
    }
}

if (!function_exists('getContactTypeByClass')) {
    function getContactTypeByClass($contactClass): string
    {
        if ($contactClass == 0)
            return "phone_number";
        if ($contactClass == 1)
            return "mobile";
        if ($contactClass == 2)
            return "fax_number";
        if ($contactClass == 3)
            return "email";
        if ($contactClass == 4)
            return "facebook";
        if ($contactClass == 5)
            return "instagram";
        if ($contactClass == 6)
            return "skype";
        if ($contactClass == 7)
            return "whatsapp";
        if ($contactClass == 8)
            return "viber";
        if ($contactClass == 9)
            return "messenger";
    }
}

if (!function_exists('getCompanieClassName')) {
    function getCompanieClassName($class): string
    {
        if ($class == 1)
            return "One Person Companies";
        if ($class == 2)
            return "Private Companies";
        if ($class == 3)
            return "Public Companies";
        if ($class == 4)
            return "Holding and Subsidiary Companies";
        if ($class == 5)
            return "Associate Companies";
    }
}
