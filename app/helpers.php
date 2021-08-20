<?php

if (!function_exists('setEnv')) {
    function setEnv($key, $value)
    {
        file_put_contents(app()->environmentFilePath(), str_replace(
            $key . '=' . env($key),
            $key . '=' . $value,
            file_get_contents(app()->environmentFilePath())
        ));
    }
}

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
        $elements = ["accounts", "appointments", "communications", "contact_data", "contacts", "contacts_companies", "contacts_field", "contacts_persons", "custom_field", "email_accounts", "fax_accounts", "groups", "imports", "logs", "notes", "sip_accounts", "sms_accounts", "users", "users_permissions"];
        return $elements[$element];
    }
}

if (!function_exists('getElementByName')) {
    function getElementByName($element): int
    {
        $elements = ["accounts", "appointments", "communications", "contact_data", "contacts", "contacts_companies", "contacts_field", "contacts_persons", "custom_field", "email_accounts", "fax_accounts", "groups", "imports", "logs", "notes", "sip_accounts", "sms_accounts", "users", "users_permissions"];
        return array_search(strtolower($element), $elements);
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
        $contacts_class = ["phone_number", "mobile", "fax_number", "email", "facebook", "instagram", "skype", "whatsapp", "viber", "messenger"];
        return $contacts_class[$contactClass];
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

if (!function_exists('getCompanieClassByName')) {
    function getCompanieClassByName($class)
    {
        if (str_replace(' ', '_', strtolower($class)) == "one_person_companies")
            return 1;
        else if (str_replace(' ', '_', strtolower($class)) == "private_companies")
            return 2;
        else if (str_replace(' ', '_', strtolower($class)) == "public_companies")
            return 3;
        else if (str_replace(' ', '_', strtolower($class)) == "holding_and_subsidiary_companies")
            return 4;
        else if (str_replace(' ', '_', strtolower($class)) == "associate_companies")
            return 5;
    }
}

if (!function_exists('getSourceByName')) {
    function getSourceByName($source)
    {
        if (str_replace(' ', '_', strtolower($source)) == "telephone_prospecting")
            return 1;
        else if (str_replace(' ', '_', strtolower($source)) == "landing_page")
            return 2;
        else if (strtolower($source) == "affiliation")
            return 3;
        else if (str_replace(' ', '_', strtolower($source)) == "database_purchased")
            return 4;
    }
}

if (!function_exists('getStatusByName')) {
    function getStatusByName($status)
    {
        if (strtolower($status) == "lead")
            return 1;
        else if (strtolower($status) == "customer")
            return 2;
        else if (str_replace(' ', '_', strtolower($status)) == "not_interested")
            return 3;
    }
}

if (!function_exists('getProfileByName')) {
    function getProfileByName($profile)
    {
        if (strtolower($profile) == "engineer")
            return 1;
        else if (strtolower($profile) == "designer")
            return 2;
        else if (strtolower($profile) == "businessman")
            return 3;
    }
}
