@extends('layouts.app', ['title' => 'Search Contacts'])

@section('css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/ubold/layouts/assets/images/favicon.ico">

    <!-- third party css -->
    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- country select css files -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    <!-- country select css files end -->

    <!-- plugin css select with country flag -->
    <link rel="stylesheet" href="{{ asset('twilio/css/intlTelInput.min.css') }}">

    <!-- Edit contact companie logo css -->
    <link href="{{ asset('css/contacts/companie-logo.css') }}" rel="stylesheet" type="text/css" />

    <!-- Jquery Toast css -->
    <link href="{{ asset('libs/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- selectize js -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

    <!-- picker css -->
    <link href="{{ asset('libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Plugins css -->
    <link href="{{ asset('libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- send email modal -->
    <link href="{{ asset('css/contacts/data/send-mail.css') }}" rel="stylesheet" type="text/css" />

    <!-- Include Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">

    <!-- App css -->
    <link href="{{ asset('css/config/creative/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('css/config/creative/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ asset('css/config/creative/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="{{ asset('css/config/creative/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ config('app.name') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('contacts') }}">Contacts</a></li>
                                <li class="breadcrumb-item active">Search</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Search Contacts</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="card">
                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="#search-form" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                Search
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#search-result" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                Results
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="search-form">
                            <form class="form-horizontal" id="search-contact" method="POST"
                                action="{{ route('contacts.search') }}" data-parsley-validate="" novalidate>
                                @csrf

                                <div class="accordion custom-accordion" id="contact">
                                    <div class="card mb-0">
                                        <div class="card-header" id="headingNine">
                                            <h5 class="m-0 position-relative">
                                                <a class="custom-accordion-title text-reset d-block"
                                                    data-bs-toggle="collapse" href="#collapseNine" aria-expanded="true"
                                                    aria-controls="collapseNine">
                                                    Contact <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                </a>
                                            </h5>
                                        </div>

                                        <div id="collapseNine" class="collapse show" aria-labelledby="headingFour"
                                            data-bs-parent="#contact">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="row mb-3">
                                                            <label for="search-contact-account_id"
                                                                class="col-4 col-xl-3 col-form-label">account</label>
                                                            <div class="col-8 col-xl-9">
                                                                @if (Auth::user()->role == 2)
                                                                    <input type="text" class="form-select d-none"
                                                                        name="account_id" id="search-contact-account_id"
                                                                        value="{{ Auth::user()->account_id }}">
                                                                @endif
                                                                <select
                                                                    class="@if (Auth::user()->role === 2) form-select @endif @error('account_id') parsley-error @enderror"
                                                                    name="account_id" @if (Auth::user()->role === 2)
                                                                    id="search-contact-account_id-disabled" disabled
                                                                @elseif (Auth::user()->role === 1)
                                                                    id="search-contact-account_id"
                                                                    @endif multiple>
                                                                    <option value="">all</option>
                                                                    @foreach ($accounts as $account)
                                                                        <option value="{{ $account->id }}">
                                                                            {{ $account->name }}
                                                                        </option>
                                                                    @endforeach
                                                                    @if (Auth::user()->role == 2)
                                                                        <option value="{{ Auth::user()->account_id }}"
                                                                            selected>
                                                                            {{ Auth::user()->account[0]->name }}</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-id"
                                                                class="col-4 col-xl-3 col-form-label">Contact
                                                                Id</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text" class="form-control @error('id') parsley-error @enderror"
                                                                    id="search-contact-id" name="id" placeholder="id">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-source_id"
                                                                class="col-4 col-xl-3 col-form-label">Source
                                                                Id</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select class=" @error('source_id') parsley-error @enderror"
                                                                    name="source_id" id="search-contact-source_id">
                                                                    <option value="">all</option>
                                                                    @foreach ($contacts_1 as $contact_1)
                                                                        <option value="{{ $contact_1->source_id }}">
                                                                            {{ $contact_1->source_id }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-group_id"
                                                                class="col-4 col-xl-3 col-form-label">Group Name</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select class=" @error('group_id') parsley-error @enderror"
                                                                    name="group_id" id="search-contact-group_id">
                                                                    <option value="">all</option>
                                                                    @foreach ($groups as $group)
                                                                        <option value="{{ $group->id }}">
                                                                            {{ $group->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-adding_method"
                                                                class="col-4 col-xl-3 col-form-label">Adding Method</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input class="form-check-input" type="radio"
                                                                    name="adding_method" id="adding_method" checked=""
                                                                    value="0">
                                                                <label class="form-check-label" for="adding_method">no
                                                                    choice</label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="adding_method" id="adding_method1" value="1">
                                                                <label class="form-check-label"
                                                                    for="adding_method1">Unitally
                                                                    added</label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="adding_method" id="adding_method2" value="2">
                                                                <label class="form-check-label"
                                                                    for="adding_method2">Import</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="row mb-3">
                                                            <label for="search-contact-status"
                                                                class="col-4 col-xl-3 col-form-label">Status</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select  multiple
                                                                    name="status" id="search-contact-status">
                                                                    <option value="">all</option>
                                                                    <option value="1">Lead</option>
                                                                    <option value="2">Customer</option>
                                                                    <option value="3">Not interested</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-class"
                                                                class="col-4 col-xl-3 col-form-label">Contact
                                                                Type</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select
                                                                    class="form-select @error('class') parsley-error @enderror"
                                                                    name="class" id="search-contact-class"
                                                                    data-parsley-type="integer"
                                                                    data-parsley-length="[1, 1]">
                                                                    <option value="">all</option>
                                                                    <option value="1">Person</option>
                                                                    <option value="2">Company</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-source"
                                                                class="col-4 col-xl-3 col-form-label">Source
                                                                Type</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select
                                                                    class="form-select @error('source') parsley-error @enderror"
                                                                    name="source" id="search-contact-source"
                                                                    data-parsley-type="integer"
                                                                    data-parsley-length="[1, 1]">
                                                                    <option value="">all</option>
                                                                    <option value="1">Telephone prospecting</option>
                                                                    <option value="2">Landing pages</option>
                                                                    <option value="3">Affiliation</option>
                                                                    <option value="4">Database purchased</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-creation_date"
                                                                class="col-4 col-xl-3 col-form-label">Creation Date</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input class="form-control @error('creation_date') parsley-error @enderror"
                                                                    type="text" name="creation_date"
                                                                    id="search-contact-creation_date" placeholder="Creation Date">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-import_id"
                                                                class="col-4 col-xl-3 col-form-label">Import
                                                                Id</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select
                                                                    class="form-select @error('import_id') parsley-error @enderror"
                                                                    name="import_id" id="search-contact-import_id"
                                                                    data-parsley-type="integer" data-parsley-length="[1, 10]">
                                                                    <option value="">all</option>
                                                                    @foreach ($imports as $import)
                                                                        <option value="{{ $import->id }}">{{ $import->id }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- end row -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion custom-accordion" id="contact-person">
                                    <div class="card mb-0">
                                        <div class="card-header" id="headingFive">
                                            <h5 class="m-0 position-relative">
                                                <a class="custom-accordion-title text-reset collapsed d-block"
                                                    data-bs-toggle="collapse" href="#collapseFive" aria-expanded="false"
                                                    aria-controls="collapseFive">
                                                    Contact Person Info <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseFive" class="collapse show" aria-labelledby="headingFive"
                                            data-bs-parent="#contact-person">
                                            <div class="card-body">
                                                <div class="row">
                                                    <h3 class="mt-0 text-muted text-center">Person Contact</h3>
                                                    <div class="col-lg-6">
                                                        <div class="row mb-3">
                                                            <label for="search-contact-first_name"
                                                                class="col-4 col-xl-3 col-form-label">First
                                                                Name</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('first_name') parsley-error @enderror"
                                                                    name="first_name" id="search-contact-first_name"
                                                                    placeholder="First Name" data-parsley-minlength="2">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-nickname"
                                                                class="col-4 col-xl-3 col-form-label">Nickname</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('nickname') parsley-error @enderror"
                                                                    name="nickname" id="search-contact-nickname"
                                                                    placeholder="Nickname" data-parsley-minlength="2">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-birthdate"
                                                                class="col-4 col-xl-3 col-form-label">Birthdate</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input
                                                                    class="form-control datepicker @error('birthdate') parsley-error @enderror"
                                                                    type="text" name="birthdate" id="search-contact-birthdate"
                                                                    data-parsley-maxdate="{{ date('m/d/Y') }}" placeholder="Birthdate">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-person_country"
                                                                class="col-4 col-xl-3 col-form-label">country</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select
                                                                    class=" country @error('person_country') parsley-error @enderror"
                                                                    name="person_country" id="search-contact-person_country">
                                                                    <option value="">all</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="row mb-3">
                                                            <label for="search-contact-last_name"
                                                                class="col-4 col-xl-3 col-form-label">Last
                                                                Name</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('last_name') parsley-error @enderror"
                                                                    name="last_name" id="search-contact-last_name"
                                                                    placeholder="Last Name" data-parsley-minlength="2">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-profile"
                                                                class="col-4 col-xl-3 col-form-label">profile</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select class=" @error('profile') parsley-error @enderror"
                                                                    name="profile" id="search-contact-profile">
                                                                    <option value="">all</option>
                                                                    <option value="1">Engineer</option>
                                                                    <option value="2">Designer</option>
                                                                    <option value="3">Businessman</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-gender"
                                                                class="col-4 col-xl-3 col-form-label">gender</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="radio" id="search-contact-gender-both"
                                                                    name="search-contact-gender" class="form-check-input"
                                                                    value="0" checked>Both
                                                                <input type="radio" id="search-contact-gender-male"
                                                                    name="search-contact-gender"
                                                                    class="form-check-input" value="1" >Male
                                                                <input type="radio" id="search-contact-gender-female"
                                                                    name="search-contact-gender"
                                                                    class="form-check-input" value="2" >Female
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-person_language"
                                                                class="col-4 col-xl-3 col-form-label">language</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select
                                                                    class=" @error('person_language') parsley-error @enderror"
                                                                    name="person_language"
                                                                    id="search-contact-person_language">
                                                                    <option value="">all</option>
                                                                    <option value="ar">Arabic - العربية</option>
                                                                    <option value="en">English</option>
                                                                    <option value="fr">French - français</option>
                                                                    <option value="es">Spanish - español</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div><!-- end col -->
                                                </div> <!-- end row -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion custom-accordion" id="contact-companie">
                                    <div class="card mb-0">
                                        <div class="card-header" id="headingSix">
                                            <h5 class="m-0 position-relative">
                                                <a class="custom-accordion-title text-reset collapsed d-block"
                                                    data-bs-toggle="collapse" href="#collapseSix" aria-expanded="false"
                                                    aria-controls="collapseSix">
                                                    Contact Companie Info <i
                                                        class="mdi mdi-chevron-down accordion-arrow"></i>
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseSix" class="collapse show" aria-labelledby="headingSix"
                                            data-bs-parent="#contact-companie">
                                            <div class="card-body">
                                                <div class="row">
                                                    <h3 class="mt-0 text-muted text-center">Companies Contact</h3>
                                                    <div class="col-lg-6">
                                                        <div class="row mb-3">
                                                            <label for="search-contact-companies_class"
                                                                class="col-4 col-xl-3 col-form-label">Class</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select
                                                                    class="form-select @error('companies_class') parsley-error @enderror"
                                                                    name="companies_class"
                                                                    id="search-contact-companies_class"
                                                                    data-parsley-type="integer"
                                                                    data-parsley-length="[1, 1]">
                                                                    <option value="">all</option>
                                                                    <option value="1">One Person Companies</option>
                                                                    <option value="2">Private Companies</option>
                                                                    <option value="3">Public Companies</option>
                                                                    <option value="4">Holding and Subsidiary Companies
                                                                    </option>
                                                                    <option value="5">Associate Companies</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-name"
                                                                class="col-4 col-xl-3 col-form-label">Name</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('name') parsley-error @enderror"
                                                                    name="name" placeholder="Name" id="search-contact-name"
                                                                    data-parsley-minlength="2">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-registered_number"
                                                                class="col-4 col-xl-3 col-form-label">Registered
                                                                number</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('registered_number') parsley-error @enderror"
                                                                    name="registered_number"
                                                                    id="search-contact-registered_number"
                                                                    placeholder="Registered number"
                                                                    data-parsley-maxlength="128">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="row mb-3">
                                                            <label for="search-contact-activity"
                                                                class="col-4 col-xl-3 col-form-label">Activity</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('activity') parsley-error @enderror"
                                                                    name="activity" id="search-contact-activity"
                                                                    placeholder="Identifier of activity">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-companies_country"
                                                                class="col-4 col-xl-3 col-form-label">country</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select
                                                                    class=" country @error('companies_country') parsley-error @enderror"
                                                                    name="companies_country"
                                                                    id="search-contact-companies_country">
                                                                    <option value="">all</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-companies_language"
                                                                class="col-4 col-xl-3 col-form-label">language</label>
                                                            <div class="col-8 col-xl-9">
                                                                <select
                                                                    class=" @error('companies_language') parsley-error @enderror"
                                                                    name="companies_language"
                                                                    id="search-contact-companies_language">
                                                                    <option value="">all</option>
                                                                    <option value="ar">Arabic - العربية</option>
                                                                    <option value="en">English</option>
                                                                    <option value="fr">French - français</option>
                                                                    <option value="es">Spanish - español</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div><!-- end col -->
                                                </div> <!-- end row -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion custom-accordion" id="contact-data">
                                    <div class="card mb-0">
                                        <div class="card-header" id="headingSeven">
                                            <h5 class="m-0 position-relative">
                                                <a class="custom-accordion-title text-reset collapsed d-block"
                                                    data-bs-toggle="collapse" href="#collapseSeven" aria-expanded="false"
                                                    aria-controls="collapseSeven">
                                                    Contact Data <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseSeven" class="collapse show" aria-labelledby="headingSeven"
                                            data-bs-parent="#contact-data">
                                            <div class="card-body">
                                                <div class="row">
                                                    <h3 class="mt-0 text-muted text-center">Contact Data</h3>
                                                    <div class="col-lg-6">
                                                        <div class="row mb-3">
                                                            <label for="search-contact-phone_number"
                                                                class="col-4 col-xl-3 col-form-label">Phone Number</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="tel"
                                                                    class="form-control @error('phone_number') parsley-error @enderror"
                                                                    name="phone_number" id="search-contact-phone_number">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-email"
                                                                class="col-4 col-xl-3 col-form-label">Email Address</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('email') parsley-error @enderror"
                                                                    name="email" placeholder="Email Address"
                                                                    id="search-contact-email">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-facebook"
                                                                class="col-4 col-xl-3 col-form-label">Facebook</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('facebook') parsley-error @enderror"
                                                                    name="facebook" placeholder="Facebook account name"
                                                                    id="search-contact-facebook">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-skype"
                                                                class="col-4 col-xl-3 col-form-label">Skype</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('skype') parsley-error @enderror"
                                                                    name="skype" placeholder="Skype account name"
                                                                    id="search-contact-skype">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-viber"
                                                                class="col-4 col-xl-3 col-form-label">Viber</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('viber') parsley-error @enderror"
                                                                    name="viber" placeholder="viber account name"
                                                                    id="search-contact-viber">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="row mb-3">
                                                            <label for="search-contact-fax_number"
                                                                class="col-4 col-xl-3 col-form-label">Fax Number</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="tel"
                                                                    class="form-control @error('fax_number') parsley-error @enderror"
                                                                    name="fax_number" id="search-contact-fax_number">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-mobile"
                                                                class="col-4 col-xl-3 col-form-label">Mobile</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="tel"
                                                                    class="form-control @error('mobile') parsley-error @enderror"
                                                                    name="mobile" id="search-contact-mobile">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-instagram"
                                                                class="col-4 col-xl-3 col-form-label">Instagram</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('instagram') parsley-error @enderror"
                                                                    name="instagram" placeholder="Instagram account name"
                                                                    id="search-contact-instagram">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-whatsapp"
                                                                class="col-4 col-xl-3 col-form-label">WhatsApp</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="tel"
                                                                    class="form-control @error('whatsapp') parsley-error @enderror"
                                                                    name="whatsapp" id="search-contact-whatsapp">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="search-contact-messenger"
                                                                class="col-4 col-xl-3 col-form-label">Messenger</label>
                                                            <div class="col-8 col-xl-9">
                                                                <input type="text"
                                                                    class="form-control @error('messenger') parsley-error @enderror"
                                                                    name="messenger" placeholder="messenger account name"
                                                                    id="search-contact-messenger">
                                                            </div>
                                                        </div>
                                                    </div><!-- end col -->
                                                </div> <!-- end row -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info waves-effect waves-light">Search</button>
                                </div>
                                <br>
                            </form>
                        </div>
                        <div class="tab-pane" id="search-result">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="contacts-result">
                                                @include('contacts.datatable-contacts')
                                            </div>
                                        </div>
                                    </div> <!-- end card -->
                                </div> <!-- end col -->
                                <div class="col-lg-3" id="contacts_person-info-card">
                                    @include('contacts.contacts_person-info')
                                </div>
                                <div class="col-lg-3 d-none" id="contacts_companie-info-card">
                                    @include('contacts.contacts_companie-info')
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div> <!-- end card -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
    @include('contacts.create')
    @include('contacts.edit')

    @include('notes.create-ext')
    @include('notes.edit-ext')

    @include('appointments.create')

    @include('email_accounts.send-mail')

    @include('sip_accounts.call')

    @include('sms_accounts.sms')
@endsection

@section('js')
    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- Plugin js-->
    <script src="{{ asset('libs/parsleyjs/parsley.min.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- third party js -->
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <!-- button pdf copy -->
    <script src="{{ asset('libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <!-- style button -->
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <!-- style button end -->
    <!-- button print -->
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <!-- not use -->
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <!-- not use end -->
    <!-- pdf -->
    <script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <!-- third party js ends -->

    <!-- Plugins js-->
    <script src="{{ asset('libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

    <script src="{{ asset('twilio/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('twilio/js/intlTelInput-jquery.min.js') }}"></script>
    <script src="{{ asset('twilio/js/utils.js') }}"></script>
    <script src="{{ asset('twilio/js/data.min.js') }}"></script>

    <!-- Plugins js -->
    <script src="{{ asset('libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('libs/dropify/js/dropify.min.js') }}"></script>

    <!-- Tippy js-->
    <script src="{{ asset('libs/tippy.js/tippy.all.min.js') }}"></script>

    <!-- selectize js -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/selectize.min.js">
    </script>

    <!-- picker js -->
    <script src="{{ asset('libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/form-pickers.init.js') }}"></script>

    <!-- Edit contact companie logo js -->
    <script src="{{ asset('js/contacts/companie-logo.js') }}"></script>

    <!-- custom js files -->
    <script src="{{ asset('js/contacts/form-edit-wizard.js') }}"></script>
    <script src="{{ asset('js/contacts/form-add-wizard.js') }}"></script>

    <script src="{{ asset('js/contacts/datatable-contacts.init.js') }}"></script>
    <script src="{{ asset('js/contacts/contacts-list.js') }}"></script>

    <script src="{{ asset('js/contacts/country-select.js') }}"></script>

    <script src="{{ asset('js/custom-parsley.js') }}"></script>
    <script src="{{ asset('js/helpers.js') }}"></script>

    <script src="{{ asset('js/form-validation-laravel.js') }}"></script>

    <!-- appointments -->
    <script src="{{ asset('js/appointments/create.js') }}"></script>

    <!-- send email modal -->
    <script src="{{ asset('js/email_accounts/send-mail.js') }}"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>

    <!-- call voip modal -->
    <script src="{{ asset('js/sip_accounts/sip_accounts.js') }}"></script>

    <!-- send sms modal -->
    <script src="{{ asset('js/sms_accounts/sms.js') }}"></script>

    <!-- js file for form search -->
    <script src="{{ asset('js/contacts/search/form-search-wizard.js') }}"></script>
    <script src="{{ asset('js/contacts/search/search-module.js') }}"></script>

    <script>
        url_logo = '{{ URL::asset('/storage/images/logo/') }}';
        url_custom_field = '{{ URL::asset('/storage/custom_field/') }}';
        url_contact_image = '{{ URL::asset('images/contact_data/') }}';
        url_jsfile = '{{ URL::asset('/js/contacts/') }}';
        url_audio = '{{ URL::asset('/audio') }}';
        var form_create_errors = null
        var form_edit_errors = null
        var create_contact_data_errors = null
        var edit_contact_data_errors = null
        var create_note_errors = null
        var edit_note_errors = null
        var search_contact_errors = null
        var errors_create_phone_data = null
        var errors_edit_phone_data = null
        var iti = null
        var edit_iti = null
        var skipErrors = 0
        var errors_create_custom_field = null
        var errors_edit_custom_field = null
        var create_appointment_errors = null
        var myTimer = null

        url_jsfile_appointments = '{{ URL::asset('/js/appointments/') }}';
        var create_appointment_errors = null
        var edit_appointment_errors = null

        url_jsfile_communications = '{{ URL::asset('/js/communications/') }}';
        var create_communication_errors = null
        var edit_communication_errors = null

        var search_contact_errors = null
    </script>

    <script>
        var editor = new Quill('#snow-editor', {
            theme: 'snow'
        });
    </script>
    <!-- custom js files end -->

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>
@endsection
